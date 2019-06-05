<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.14.0.3812
 * @date        2018-05-16
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC'))
{
	die();
}

class Sh404sefModelWaf
{
	private $url   = null;
	private $path  = null;
	private $query = null;

	/**
	 * Stores external information.
	 *
	 * @param $uri
	 * @param $config
	 * @param $jconfig
	 */
	public function __construct($uri, $config, $jconfig)
	{
		$this->uri = $uri;
		$this->config = $config;
		$this->jconfig = $jconfig;

		$this->parseCurrentRequest();
	}

	/**
	 * Breaks up current requst URLs into normalized components/
	 *
	 * @return $this
	 */
	private function parseCurrentRequest()
	{
		// requestPathAndQuery HAS the query string in it
		$requestPathAndQuery = str_replace(
			JURI::root(),
			'',
			$this->getCurrentRequestUrl()
		);

		if (empty($requestPathAndQuery))
		{
			$requestPathAndQuery = '/';
		}
		$this->url = $requestPathAndQuery;

		$parts = explode('?', $requestPathAndQuery, 2);
		$path = empty($parts) ? '' : array_shift($parts);
		$this->path = rawurldecode($path);
		$this->query = empty($parts) ? '' : array_shift($parts);

		return $this;
	}

	/**
	 * Checks whether current request should be blocked.
	 *
	 */
	public function filter()
	{
		try
		{
			/**
			 * Filter the list of URL blocking rules.
			 *
			 * @api
			 * @package sh404SEF\filter\security
			 * @var sh404sef_redirect_alias
			 * @since   4.14.0
			 *
			 * @param array $rules Configured URL blocking rules.
			 *
			 * @return array
			 */
			$rules = ShlHook::filter(
				'sh404sef_block_urls_rules',
				$this->config->request_block_list
			);
			if (empty($rules) || !is_array($rules))
			{
				return;
			}
			foreach ($rules as $rule)
			{
				// test the full URL
				$matches = ShlSystem_Route::urlRuleMatch(
					$rule,
					$this->url,
					$wildChar = '{*}',
					$singleChar = '{?}',
					$regexpChar = '~'
				);
				if (!empty($matches[0]))
				{
					$this->blockUrl($rule);
				}

				// test the path
				$matches = ShlSystem_Route::urlRuleMatch(
					$rule,
					$this->path,
					$wildChar = '{*}',
					$singleChar = '{?}',
					$regexpChar = '~'
				);
				if (!empty($matches[0]))
				{
					$this->blockUrl($rule);
				}
			}
		}
		catch (Exception $e)
		{
			// if error, just log
			ShlSystem_Log::error(
				'sh404sef', '%s::%d: %s', __METHOD__, __LINE__,
				'Error checking blocked URLs: ' . $e->getMessage()
			);
		}
	}

	/**
	 * Ends a request with a raw response.
	 *
	 * @param string $rule The rule that triggered the blocking.
	 */
	private function blockUrl($rule)
	{
		switch ($this->config->request_block_list_action)
		{
			case 'error_404':
				$this->logRequest('Blocked by rule ' . $rule);
				ShlSystem_Http::abort(ShlSystem_Http::RETURN_NOT_FOUND);
				break;
			case 'error_403':
				$this->logRequest('Blocked by rule ' . $rule);
				ShlSystem_Http::abort(ShlSystem_Http::RETURN_FORBIDDEN);
				break;
			default:
				$this->logRequest('Triggered rule ' . $rule . ', not blocked per config.');
				break;
		}

		return;
	}

	private function logRequest($causeText, $comment = '')
	{
		if ($this->config->shSecLogAttacks)
		{
			$logData = array();
			$logData['DATE'] = ShlSystem_Date::getSiteNow('Y-m-d');
			$logData['TIME'] = ShlSystem_Date::getSiteNow('H:i:s');
			$logData['CAUSE'] = $causeText;
			$logData['C-IP'] = ShlSystem_Http::getVisitorIpAddress();
			if ($logData['C-IP'] != 'localhost' && $logData['C-IP'] != '::1')
			{
				$name = getHostByAddr($logData['C-IP']);
			}
			else
			{
				$name = '-';
			}
			$logData['NAME'] = $name;
			$logData['USER_AGENT'] = empty($_SERVER['HTTP_USER_AGENT']) ? '-' : $_SERVER['HTTP_USER_AGENT'];
			$logData['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'];
			$logData['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
			$logData['COMMENT'] = $comment;

			ShlSystem_Log::logSec(
				$logData
			);
		}
	}

	/**
	 * Gets the current request full URL.
	 *
	 * @return string
	 */
	private function getCurrentRequestUrl()
	{
		static $currentRequestUrl = null;

		if (is_null($currentRequestUrl))
		{
			$currentRequestUrl = wbGetProtectedProperty('Juri', 'uri', $this->uri);
		}

		return $currentRequestUrl;
	}
}
