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



class Tables extends Cache
{
	public static function purge($tables = [])
	{
		if (empty($tables))
		{
			return;
		}

		if (!is_array($tables))
		{
			$tables = explode(',', str_replace("\n", ',', $tables));
		}

		foreach ($tables as $table)
		{
			self::emptyTable($table);
		}
	}
}
