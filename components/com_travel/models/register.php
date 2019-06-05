<?php
/**
 * @version		$Id: featured.php 20469 2011-01-28 14:35:19Z chdemko $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
jimport('joomla.application.component.modellist');

/**
 * This models supports retrieving lists of articles.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class travelModelregister extends JModelList
{
	/**
	 * Model context string.
	 *
	 * @var		string
	 */
 public $_context = 'com_travel.register';
 public $_id = null;
 public $_manuf = null;
 public $_region = null;
 public $_lander = null;
 
 function __construct() {
   parent::__construct();
   $this->_id = JRequest::getInt('id');
 
   }
 
	protected function populateState($ordering = null, $direction = null)
	{
		parent::populateState($ordering, $direction);
	    $app = JFactory::getApplication();
        
        
		// List state information
		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
      
        
		$this->setState('list.start', $limitstart);
        $params = $app->getParams();
		$this->setState('params', $params);
        
		$params = $this->state->params;
        $this->_users = JFactory::getUser(); //Данные пользователя
        
        $catid = JRequest::getInt('catid'); 
        $this->setState('filter.kat', $catid);
        $id = JRequest::getInt('id'); 
        $this->setState('filter.id', $id);
        $this->_id = $id;
       
        //$menu_params = new JParameter( $menu->params );
        $limit  =  JRequest::getVar('limit',10);
        $text  =  JRequest::getVar('text');
        $this->setState('filter.text', $text);
        $state  =  JRequest::getInt('state',0);
        $this->setState('filter.state', $state);
        $this->setState('list.limit', $limit);
	 
 	}
        
       
  
    
 
	protected function getStoreId($id = '')
	{
		// Add the list state to the store id.
		$id .= ':' . $this->getState('list.start');
		$id .= ':' . $this->getState('list.limit');
		$id .= ':' . $this->getState('list.ordering');
		$id .= ':' . $this->getState('list.direction');

		return md5($this->context . ':' . $id);
	}

	/**
	 * @return	JDatabaseQuery
	 */
     
     
    
}
