<?php
/**
 * @package         Advanced Module Manager
 * @version         7.0.4PRO
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2017 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

require_once JPATH_ADMINISTRATOR . '/components/com_advancedmodules/models/module.php';

class AdvancedModulesModelEdit extends AdvancedModulesModelModule
{
	public function __construct($config = [])
	{
		parent::__construct($config);
	}
}
