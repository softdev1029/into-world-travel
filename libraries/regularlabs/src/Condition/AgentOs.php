<?php
/**
 * @package         Regular Labs Library
 * @version         17.1.26563
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2017 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\Library\Condition;

defined('_JEXEC') or die;

/**
 * Class AgentOs
 * @package RegularLabs\Library\Condition
 */
class AgentOs
	extends AgentBrowser
	implements \RegularLabs\Library\Api\ConditionInterface
{
	public function pass()
	{
		// Same as AgentBrowser
		return parent::pass();
	}
}
