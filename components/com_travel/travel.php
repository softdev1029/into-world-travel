<?php
 # Файл travel.php
 # Отели  - точка входа в компонент
 # Автор: Федянин Александр
 # Сайт: http://webalan.ru
 # E-mail: alae@bk.ru
 
 
 
defined( '_JEXEC' ) or die( '=;)' );
if (!defined('DS'))  define('DS','/');
$document = JFactory::getDocument();
 
$document->addStyleSheet('https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');
$document->addStyleSheet(JURI::root().'components/com_travel/css/otels.css');
$document->addStyleSheet(JURI::root().'components/com_travel/css/style.css');
$document->addStyleSheet(JURI::root().'components/com_travel/js/modal.css');
$document->addStyleSheet(JURI::root().'components/com_travel/js/nouislider.min.css'); 
//$document->addScript(JURI::root().'components/com_travel/js/main.js');
  
 $db=JFactory::getDBO();
////$q = 'ALTER TABLE  `#__travel_order` ADD  `` INT NOT NULL';
//$db->setQuery($q);
//$db->Query();
//
//$q = 'ALTER TABLE  `#__travel_order` ADD  `kind_two` INT NOT NULL';
//$db->setQuery($q);
//$db->Query();
//
//
//$q = 'ALTER TABLE  `#__travel_order` ADD  `age1_two` INT NOT NULL';
//$db->setQuery($q);
//$db->Query();
//
//
//$q = 'ALTER TABLE  `#__travel_order` ADD  `age2_two` INT NOT NULL';
//$db->setQuery($q);
//$db->Query();
//
//
//$q = 'ALTER TABLE  `#__travel_order` ADD  `age3_two` INT NOT NULL';
//$db->setQuery($q);
//$db->Query();
//
//
// $q = 'ALTER TABLE  `#__travel_order` ADD  `xml1` TEXT NOT NULL';
// $db->setQuery($q);
// $db->Query();
// 
//  $q = 'ALTER TABLE  `#__travel_order` ADD  `xml2` TEXT NOT NULL';
// $db->setQuery($q);
// $db->Query();
//

require_once( JPATH_COMPONENT.'/helpers/html.php' );
require_once( JPATH_COMPONENT.'/helpers/xml.php' );
require_once( JPATH_COMPONENT.'/helpers/helper.php' );
 
require_once( JPATH_COMPONENT.'/controller.php' );
 

// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.'/controllers/'.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}
// Create the controller
$classname    = 'travelController'.ucfirst($controller);
$controller   = new $classname( );

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task', 'display'));

// Redirect if set by the controller
$controller->redirect();