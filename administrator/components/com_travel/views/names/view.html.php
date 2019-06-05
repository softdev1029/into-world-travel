<?php
 
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
 

class  travelViewnames extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	protected static $actions;
	public function display($tpl = null)
	{
        $this->items		= $this->get('Items'); 
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
	 

		$this->addToolbar();
		parent::display($tpl);
	}
    protected function addToolbar()
	{
		$canDo	= $this->getActions();

		JToolBarHelper::title(JTEXT::_('nameS'));

		if ($canDo->get('core.create')) {
			JToolBarHelper::custom('name.add', 'new.png', 'new_f2.png','JTOOLBAR_NEW', false);
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::custom('name.edit', 'edit.png', 'edit_f2.png','JTOOLBAR_EDIT', true);
		}

		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::custom('names.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('names.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
	 
			JToolBarHelper::divider();
		}

		if ($canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'names.delete','JTOOLBAR_DELETE');
			JToolBarHelper::divider();
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_travel');
		 
		}

	 
	}
    public static function getActions()
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