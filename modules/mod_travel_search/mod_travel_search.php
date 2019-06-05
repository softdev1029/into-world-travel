<?php defined('_JEXEC') or die;
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
 require_once(JPATH_SITE.'/components/com_travel/helpers/helper.php');
 require_once(JPATH_SITE.'/components/com_travel/helpers/html.php');
 JHtml::_('formbehavior.chosen', '.jbfilter-wrapper select');
   
   $document = JFactory::getDocument();
   $document->addStyleSheet(JURI::root().'components/com_travel/css/style.css');
   $document->addStyleSheet('https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');
 

require JModuleHelper::getLayoutPath('mod_travel_search', $params->get('layout', 'default'));
