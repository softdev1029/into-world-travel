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

namespace RegularLabs\CacheCleaner\Cache;

defined('_JEXEC') or die;

use JCache;
use JFactory;

class Joomla extends Cache
{
	public static function purge()
	{
		self::emptyFolder(JPATH_SITE . '/cache');
		self::emptyFolder(JPATH_ADMINISTRATOR . '/cache');

		$cache = self::getCache();

		if (!isset($cache->options['storage']) || $cache->options['storage'] == 'file')
		{
			return;
		}

		$cache->clean(null, 'all');
	}

	public static function purgeOPcache()
	{
		if (!extension_loaded('Zend OPcache'))
		{
			return;
		}

		opcache_reset();
	}

	public static function purgeExpired()
	{
		$cache = self::getCache();
		$cache->gc();
	}

	public static function purgeUpdates()
	{
		$db = JFactory::getDbo();
		$db->setQuery('TRUNCATE TABLE #__updates');
		if (!$db->execute())
		{
			return;
		}

		// Reset the last update check timestamp
		$query = $db->getQuery(true)
			->update('#__update_sites')
			->set('last_check_timestamp = ' . $db->quote(0));
		$db->setQuery($query);
		$db->execute();
	}

	public static function checkIn()
	{
		$db       = JFactory::getDbo();
		$query    = $db->getQuery(true);
		$nullDate = $db->getNullDate();

		$tables = $db->getTableList();

		foreach ($tables as $table)
		{
			// make sure we get the right tables based on prefix
			if (strpos($table, $db->getPrefix()) !== 0)
			{
				continue;
			}

			$fields = $db->getTableColumns($table);

			if (!(isset($fields['checked_out']) && isset($fields['checked_out_time'])))
			{
				continue;
			}

			$query->clear()
				->update($db->quoteName($table))
				->set('checked_out = 0')
				->set('checked_out_time = ' . $db->quote($nullDate))
				->where('checked_out > 0');
			if (isset($fields['editor']))
			{
				$query->set('editor = NULL');
			}
			$db->setQuery($query);
			$db->execute();
		}
	}

	private static function getCache()
	{
		$conf = JFactory::getConfig();

		$options = array(
			'defaultgroup' => '',
			'storage'      => $conf->get('cache_handler', ''),
			'caching'      => true,
			'cachebase'    => $conf->get('cache_path', JPATH_SITE . '/cache'),
		);

		$cache = JCache::getInstance('', $options);

		return $cache;
	}
}
