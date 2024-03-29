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

use RegularLabs\Library\Protect as RL_Protect;

class Protect
{
	static $name = 'CacheCleaner';

	public static function _(&$string)
	{
		RL_Protect::protectFields($string);
		RL_Protect::protectSourcerer($string);
		RL_Protect::protectByRegex($string, '\{nocdn\}.*?\{/nocdn\}');
	}
}
