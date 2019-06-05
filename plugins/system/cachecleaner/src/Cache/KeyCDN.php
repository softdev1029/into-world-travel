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


use JText;
use KeyCDN as ApiKeyCDN;
use RegularLabs\CacheCleaner\Params;

class KeyCDN extends Cache
{
	public static function purge()
	{
		$params = Params::get();

		if (empty($params->keycdn_authentication_key))
		{
			self::addError(JText::sprintf('CC_ERROR_CDN_NO_AUTHENTICATIONION_KEY', JText::_('CC_KEYCDN')));

			return -1;
		}

		if (empty($params->keycdn_zones))
		{
			self::addError(JText::sprintf('CC_ERROR_CDN_NO_ZONES', JText::_('CC_KEYCDN')));

			return -1;
		}

		$api = self::getAPI();
		if (!$api || is_string($api))
		{
			self::addError(JText::sprintf('CC_ERROR_CDN_COULD_NOT_INITIATE_API', JText::_('CC_KEYCDN')));
			if (is_string($api))
			{
				self::addError($api);
			}

			return false;
		}

		$zones = explode(',', $params->keycdn_zones);

		foreach ($zones as $zone)
		{
			$api_call = json_decode($api->get('zones/purge/' . $zone . '.json'));

			if (!is_null($api_call) && isset($api_call->status) && $api_call->status == 'success')
			{
				continue;
			}

			self::addError(JText::sprintf('CC_ERROR_CDN_COULD_NOT_PURGE_ZONE', JText::_('CC_KEYCDN'), $zone));

			return false;
		}

		return true;
	}

	public static function getAPI()
	{
		$params = Params::get();

		require_once __DIR__ . '/../Api/KeyCDN.php';

		return new ApiKeyCDN(trim($params->keycdn_authentication_key));
	}
}
