<?php
defined('_JEXEC') or die();
jimport('joomla.application.component.controllerform');

class travelControllerorder extends JControllerForm
{

	protected	$option 		= 'com_travel';
	
     
    
	protected function allowAdd($data = array())
	{
		return parent::allowAdd($data);
	}


		protected function allowEdit($data = array(), $key = 'id')
	{
		// Initialise variables.
		$recordId	= (int) isset($data[$key]) ? $data[$key] : 0;
		$user		= JFactory::getUser();
		$userId		= $user->get('id');

		// Check general edit permission first.
		if ($user->authorise('core.edit', 'com_travel.order.'.$recordId)) {
		  
			return true;
		}

	   

		// Since there is no asset tracking, revert to the component permissions.
		return parent::allowEdit($data, $key);
	}

 static public function conf(){
 $app = JFactory::getApplication('administrator');
    $db=JFactory::getDBO();
    $id = JRequest::getInt('id');
     $db=JFactory::getDBO();
     $q = 'SELECT * FROM #__travel_order WHERE id='.(int)$id;
     $db->setQuery($q);
     $order = $db->LoadObject();
    
    $xml = xml::Booking_xml($order,  'confirm'    );
    $rowe = xml::go_xml($xml);
    $xml_test = simplexml_load_string($rowe);
 $code = 0;
 
 $Description = '';
 if (isset($xml_test->Code))
 {
 $code = trim($xml_test->Code);
 $Description = trim($xml_test->Description);
 
   $error = 'Code: '.$code.' '.$Description;  
   JError::raiseWarning( 100, $error );
   $app->Redirect('index.php?option=com_travel&task=order.edit&id='.$id);
   return;   
 }
 JError::raiseNotice( 100, 'OK' );
  $db=JFactory::getDBO();
  $q = 'UPDATE #__travel_order SET status="confirm" WHERE id='.$id;
  $db->setQuery($q);
  $db->Query();
   $app->Redirect('index.php?option=com_travel&task=order.edit&id='.$id);
  }
 

  static public function orderotmena(){
 	$app = JFactory::getApplication('administrator');
    $db=JFactory::getDBO();
    $id = JRequest::getInt('id');
     $db=JFactory::getDBO();
     $q = 'SELECT * FROM #__travel_order WHERE id='.(int)$id;
     $db->setQuery($q);
     $order = $db->LoadObject();
    
    $xml = xml::BookingCancel ($order);
   
    
    $rowe = xml::go_xml($xml);
    
    
   
    
    $xml_test = simplexml_load_string($rowe);
 $code = 0;
 
 $Description = '';
 if (isset($xml_test->Code))
 {
 $code = trim($xml_test->Code);
 $Description = trim($xml_test->Description);
 
   $error = 'Code: '.$code.' '.$Description;  
   JError::raiseWarning( 100, $error );
   $app->Redirect('index.php?option=com_travel&task=order.edit&id='.$id);
   return;   
 }
 JError::raiseNotice( 100, 'OK' );
  $db=JFactory::getDBO();
  $q = 'UPDATE #__travel_order SET status="delete" WHERE id='.$id;
  $db->setQuery($q);
  $db->Query();
   $app->Redirect('index.php?option=com_travel&task=order.edit&id='.$id);
  }
  
}