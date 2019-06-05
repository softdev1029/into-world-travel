<?php
/**
 * @version		$Id: view.html.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * @package		Joomla.Administrator
 * @subpackage	com_users
 */
class travelViewstrana extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $grouplist;
	protected $groups;
	protected $state;
	protected static $actions;
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->form			= $this->get('Form');
		$this->item			= $this->get('Item');
	   //add_itesms
		$this->state		= $this->get('State');

 
	 
 

		parent::display($tpl);
		$this->addToolbar();
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', 1);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
		$canDo	= $this->getActions();
		
		
		$isNew	= ($this->item->id == 0);
		$isProfile = $this->item->id == $user->id;
		JToolBarHelper::title('Страны');
        
		if ($canDo->get('core.edit')||$canDo->get('core.edit.own')||$canDo->get('core.create')) {
	//		JToolBarHelper::apply('strana.apply','JTOOLBAR_APPLY');
 JToolBarHelper::save('strana.save','JTOOLBAR_SAVE');
		}
		if ($canDo->get('core.create')&&$canDo->get('core.manage')) {			
		//	JToolBarHelper::custom('strana.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}
		if (empty($this->item->id))  {
			JToolBarHelper::cancel('strana.cancel','JTOOLBAR_CANCEL');
		} else {
			JToolBarHelper::cancel('strana.cancel', 'JTOOLBAR_CLOSE');
		}
		JToolBarHelper::divider();
	 
	} public static function getActions()
	{
		if (empty(self::$actions)) {
			$user	= JFactory::getUser();
			self::$actions	= new JObject;

			$actions = array(
				'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
			);

			foreach ($actions as $action) {
				self::$actions->set($action, $user->authorise($action, 'com_travel'));
			}
		}

		return self::$actions;
	}
}
