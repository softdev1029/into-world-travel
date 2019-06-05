<?php
/**
 * @package         Cache Cleaner
 * @version         6.0.1PRO
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2017 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\CacheCleaner;

defined('_JEXEC') or die;

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

use JFactory;
use JFile;
use JFolder;
use JHttpFactory;
use JText;
use RegularLabs\Library\Document as RL_Document;
use RegularLabs\Library\Language as RL_Language;

class Cache
{
	static $show_message = true;
	static $message      = '';
	static $error        = '';
	static $thirdparties = ['jre', 'jotcache', 'siteground', 'maxcdn', 'keycdn', 'cdn77', 'cloudflare'];

	public static function clean()
	{
		self::purgeThirdPartyCacheByUrl();

		if (!self::getCleanType())
		{
			return false;
		}

		// Load language for messaging
		RL_Language::load('mod_cachecleaner');

		self::purgeCache();

		// only handle messages in html
		if (!RL_Document::isHtml())
		{
			return false;
		}

		$params = Params::get();

		$error = self::getError();

		if ($error)
		{
			$message = JText::_('CC_NOT_ALL_CACHE_COULD_BE_REMOVED');
			$message .= $error !== true ? '<br>' . $error : '';
		}
		else
		{
			$message = self::$message ?: JText::_('CC_CACHE_CLEANED');

			if ($params->show_size && Cache\Cache::getSize())
			{
				$message .= ' (' . Cache\Cache::getSize() . ')';
			}
		}

		if (JFactory::getApplication()->input->getInt('break'))
		{
			echo (!$error ? '+' : '') . str_replace('<br>', ' - ', $message);
			die;
		}

		if (self::$show_message && $message)
		{
			JFactory::getApplication()->enqueueMessage($message, ($error ? 'error' : 'message'));
		}
	}

	private static function getCleanType()
	{
		$params = Params::get();

		$cleancache = trim(JFactory::getApplication()->input->getString('cleancache'));

		// Clean via url
		if (!empty($cleancache))
		{
			// Return if on frontend and no secret url key is given
			if (JFactory::getApplication()->isSite() && $cleancache != $params->frontend_secret)
			{
				return '';
			}

			// Return if on login page
			if (JFactory::getApplication()->isAdmin() && JFactory::getUser()->get('guest'))
			{
				return '';
			}

			if (JFactory::getApplication()->input->getWord('src') == 'button')
			{
				return 'button';
			}

			self::$show_message = true;

			if (JFactory::getApplication()->isSite() && $cleancache == $params->frontend_secret)
			{
				self::$show_message = $params->frontend_secret_msg;
			}

			return 'clean';
		}

		// Clean via save task
		if (self::passTask())
		{
			return 'save';
		}

		// Clean via interval
		if (self::passInterval())
		{
			return 'interval';
		}

		return '';
	}

	private static function passTask()
	{
		$params = Params::get();

		if (!$task = JFactory::getApplication()->input->get('task'))
		{
			return false;
		}

		$task = explode('.', $task, 2);
		$task = isset($task['1']) ? $task['1'] : $task['0'];
		if (strpos($task, 'save') === 0)
		{
			$task = 'save';
		}

		$tasks = array_diff(array_map('trim', explode(',', $params->auto_save_tasks)), ['']);

		if (empty($tasks) || !in_array($task, $tasks))
		{
			return false;
		}

		if (JFactory::getApplication()->isAdmin() && $params->auto_save_admin)
		{
			self::$show_message = $params->auto_save_admin_msg;

			return true;
		}

		if (JFactory::getApplication()->isSite() && $params->auto_save_front)
		{
			self::$show_message = $params->auto_save_front_msg;

			return true;
		}

		return false;
	}

	private static function purgeCache()
	{
		$params = Params::get();

		// Joomla cache
		if (self::passType('purge'))
		{
			Cache\Joomla::purge();
		}

		// 3rd party cache
		self::purgeThirdPartyCaches();

		// Folders
		if (self::passType('clean_tmp'))
		{
			Cache\Folders::purge_tmp();
		}
		if (self::passType('clean_folders'))
		{
			Cache\Folders::purge_folders();
		}

		// Tables
		if (self::passType('clean_tables'))
		{
			Cache\Tables::purge();
		}

		// Purge OPcache
		if (self::passType('purge_opcache'))
		{
			Cache\Joomla::purgeOPcache();
		}

		// Purge expired cache
		if (self::passType('purge'))
		{
			Cache\Joomla::purgeExpired();
		}

		// Purge update cache
		if (self::passType('purge_updates'))
		{
			Cache\Joomla::purgeUpdates();
		}

		// Global check-in
		if (self::passType('checkin'))
		{
			Cache\Joomla::checkIn();
		}

		if (self::passType('query_url') && !empty($params->query_url_selection))
		{
			self::queryUrl();
		}

		self::updateLog();
	}

	private static function passType($type)
	{
		$params = Params::get();

		if (empty($params->{$type}))
		{
			return false;
		}

		if ($params->{$type} == 2 && self::getCleanType() != 'button')
		{
			return false;
		}

		return true;
	}

	private static function purgeThirdPartyCaches()
	{
		foreach (self::$thirdparties as $thirdparty)
		{
			if (!self::passType('clean_' . $thirdparty))
			{
				continue;
			}

			self::purgeThirdPartyCache($thirdparty);
		}
	}

	private static function purgeThirdPartyCache($thirdparty)
	{
		switch ($thirdparty)
		{
			case 'jre':
				return Cache\JRE::purge();

			case 'jotcache':
				return Cache\JotCache::purge();

			case 'siteground':
				return Cache\SiteGround::purge();

			case 'maxcdn':
				return Cache\MaxCDN::purge();

			case 'keycdn':
				return Cache\KeyCDN::purge();

			case 'cdn77':
				return Cache\CDN77::purge();

			case 'cloudflare':
				return Cache\CloudFlare::purge();
		}

		return '';
	}

	private static function purgeThirdPartyCacheByUrl()
	{
		$purged = false;

		foreach (self::$thirdparties as $thirdparty)
		{
			if (!JFactory::getApplication()->input->getInt('purge_' . $thirdparty))
			{
				continue;
			}

			if (self::purgeThirdPartyCache($thirdparty) == '-1')
			{
				self::addError('(<em>' . JText::_('CC_SAVE_SETTINGS_FIRST') . '</em>)');
			}

			$purged = true;
		}

		if ($purged)
		{
			echo self::getError() ?: '+' . Cache\Cache::getMessage();
			die;
		}
	}

	private static function queryUrl()
	{
		$params = Params::get();

		try
		{
			$http = JHttpFactory::getHttp()->get($params->query_url_selection, null, 5);
			if ($http->code != 200)
			{
				self::setError(JText::sprintf('CC_ERROR_QUERY_URL_FAILED', $params->query_url_selection));
			}
		}
		catch (RuntimeException $e)
		{
			self::setError(JText::sprintf('CC_ERROR_QUERY_URL_FAILED', $params->query_url_selection));
		}
	}

	private static function passInterval()
	{
		$params = Params::get();

		if (
			(JFactory::getApplication()->isAdmin() && !$params->auto_interval_admin)
			|| (JFactory::getApplication()->isSite() && !$params->auto_interval_front)
		)
		{
			return false;
		}

		if (JFactory::getApplication()->isAdmin() && JFactory::getUser()->get('guest'))
		{
			return false;
		}

		$file_path = str_replace('//', '/', JPATH_SITE . '/' . str_replace('\\', '/', $params->log_path . '/'));
		if (!JFolder::exists($file_path))
		{
			$file_path = JPATH_PLUGINS . '/system/cachecleaner/';
		}
		$file = $file_path . '/cachecleaner_lastclean.log';

		$secs = JFactory::getApplication()->isSite() ? $params->auto_interval_front_secs : $params->auto_interval_admin_secs;

		// Return false if last clean is within interval
		if (
			JFile::exists($file)
			&& ($lastclean = JFile::read($file))
			&& $lastclean > (time() - $secs)
		)
		{
			return false;
		}

		self::$show_message = JFactory::getApplication()->isSite() ? $params->auto_interval_front_msg : $params->auto_interval_admin_msg;

		return true;
	}

	private static function updateLog()
	{
		$params = Params::get();

		// Write current time to text file

		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');

		$file_path = str_replace('//', '/', JPATH_SITE . '/' . str_replace('\\', '/', $params->log_path . '/'));

		if (!JFolder::exists($file_path))
		{
			$file_path = JPATH_PLUGINS . '/system/cachecleaner/';
		}

		$time = time();
		JFile::write($file_path . 'cachecleaner_lastclean.log', $time);
	}

	public static function getMessage()
	{
		return self::$message;
	}

	public static function getError()
	{
		return self::$error;
	}

	public static function setMessage($message = '')
	{
		self::$message = $message;
	}

	public static function setError($error = '')
	{
		self::$error = $error;
	}

	public static function addMessage($message = '')
	{
		self::$message .= self::$message ? '<br>' : '';
		self::$message .= $message;
	}

	public static function addError($error = '')
	{
		self::$error .= self::$error ? '<br>' : '';
		self::$error .= $error;
	}
}
