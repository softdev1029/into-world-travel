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



class JRE extends Cache
{
	public static function purge()
	{
		self::emptyTable('#__jrecache_repository');
	}
}
