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

use RegularLabs\Library\Parameters as RL_Parameters;

class Params
{
	protected static $params = null;

	public static function get()
	{
		if (!is_null(self::$params))
		{
			return self::$params;
		}

		self::$params = RL_Parameters::getInstance()->getPluginParams('cachecleaner');

		return self::$params;
	}
}
