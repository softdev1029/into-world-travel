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

use JFactory;

/**
 * Class Akeebasubs
 * @package RegularLabs\Library\Condition
 */
class Akeebasubs
	extends \RegularLabs\Library\Condition
	implements \RegularLabs\Library\Api\ConditionInterface
{
	var $agent  = null;
	var $device = null;

	public function pass()
	{
		// See specific conditions
		return false;
	}

	public function initRequest(&$request)
	{
		if ($request->id || $request->view != 'level')
		{
			return;
		}

		$slug = JFactory::getApplication()->input->getString('slug', '');

		if (!$slug)
		{
			return;
		}

		$query = $this->db->getQuery(true)
			->select('l.akeebasubs_level_id')
			->from('#__akeebasubs_levels AS l')
			->where('l.slug = ' . $this->db->quote($slug));
		$this->db->setQuery($query);
		$request->id = $this->db->loadResult();
	}
}
