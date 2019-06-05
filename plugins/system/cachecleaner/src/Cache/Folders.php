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

use RegularLabs\CacheCleaner\Params;

class Folders extends Cache
{
	// Empty tmp folder
	public static function purge_tmp()
	{
		self::emptyFolder(JPATH_SITE . '/tmp');
	}

	// Empty custom folder
	public static function purge_folders()
	{
		$params = Params::get();

		if (empty($params->clean_folders_selection))
		{
			return;
		}

		$folders = explode("\n", str_replace('\n', "\n", $params->clean_folders_selection));

		foreach ($folders as $folder)
		{
			if (!trim($folder))
			{
				continue;
			}

			$folder = rtrim(str_replace('\\', '/', trim($folder)), '/');
			$path   = str_replace('//', '/', JPATH_SITE . '/' . $folder);
			self::emptyFolder($path);
		}
	}
}
