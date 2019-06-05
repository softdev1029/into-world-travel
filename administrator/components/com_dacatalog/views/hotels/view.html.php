<?php
/**
* @version		$Id: view.html.php 10381 2008-06-01 03:35:53Z pasamio $
* @package		Joomla
* @subpackage	Config
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class DaCatalogViewHotels extends JViewLegacy
{
	protected $form;
	private $table = '#__dacatalog_hotels';

	function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$db =& JFactory::getDBO();

		$id = $app->input->get("id");
		$option = $app->input->get( 'option' );
		$this->controller = $view = $app->input->get( 'view' );
		$layout = $app->input->get( 'layout' );

		DacatalogHelper::addSubmenu($view);

		if(!empty($layout)) {
			$query = "SELECT i.* FROM ".$this->table." AS i WHERE i.id = '$id'";
			$db->setQuery($query);
			$element = $db->loadAssoc();
			$saved = JRequest::getVar( 'saved' );
			if($saved) $element = $saved;

			$this->form	= JForm::getInstance('com_dacatalog.'.$this->controller, $this->controller);
			$this->form->bind($element);

			$this->element = $element;
		}

		$list = $app->getUserStateFromRequest( 'com_dacatalog.list', 'list', array('limit' => 20), 'array' );
		$limit = $list['limit'];
		$limitstart	= $app->getUserStateFromRequest( $option.$view.'.limitstart', 'limitstart', 0, 'int' );
		$filter_order		= $app->getUserStateFromRequest( "$option.$view.filter_order",		    'filter_order',		  'i.id',	'cmd' );
		$filter_order_Dir	= $app->getUserStateFromRequest( "$option.$view.filter_order_Dir",	'filter_order_Dir',	'desc',		'word' );

		$this->filter = $app->getUserStateFromRequest($option.$view.'.filter', 'filter');

		$where = array();

		if(!empty($this->filter['search'])) {
			$where[] = is_numeric($this->filter['search']) ? " i.id = ".$this->filter['search'] : " i.name LIKE '%".$this->filter['search']."%'";
		}

		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir;

		$query = "SELECT COUNT(*) FROM ".$this->table." AS i".$where;
		$db->setQuery( $query );
		$total = $db->loadResult();

		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = "SELECT i.* FROM ".$this->table." AS i".$where.$orderby;
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();

		// filters
		$this->filterForm = JForm::getInstance('com_dacatalog.filter_flights', 'filter_flights');
		$this->filterForm->bind(array('filter' => $this->filter, 'list' => array('limit' => $limit)));
		$this->activeFilters = false;

		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;

		$this->lists = $lists;
		$this->items = $rows;
		$this->pagination = $pagination;

		parent::display($tpl);
	}
}