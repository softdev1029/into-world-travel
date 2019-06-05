<?php
/**
 * @version     1.0.0
 * @package     com_travel
 */
 
if (!defined('DS'))  define('DS','/');
// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_travel')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

 //file_path
  require_once( JPATH_SITE.'/components/com_travel/helpers/helper.php' );
  require_once( JPATH_SITE.'/components/com_travel/helpers/xml.php' );
 require_once( JPATH_COMPONENT.DS.'helpers'.DS.'travel.php' );
  require_once( JPATH_COMPONENT.DS.'helpers'.DS.'xls.php' );
 require_once( JPATH_COMPONENT.DS.'helpers'.DS.'file.php' );
 require_once( JPATH_COMPONENT.DS.'helpers'.DS.'filter.php' );
 require_once( JPATH_COMPONENT.DS.'helpers'.DS.'images.php' );

$vName = JRequest::getVar('view');
travelHelper::addSubmenu($vName);

$controller	= JControllerLegacy::getInstance('travel');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
