<?php
/**
 * Поиск отелей
 * 
все вопросы по компоненту http://webalan.ru
*/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
 
 
class travelViewConfirm extends JViewLegacy
{
	
	protected $state = null;
	protected $item = null;
	protected $items = null;
	protected $pagination = null;

 
	function display($tpl = null)
	{
		
		// Initialise variables.
		$user = JFactory::getUser();
		$app = JFactory::getApplication();
		
	    $state 		= $this->get('State');
        $model = $this->getModel();
        $this->Itemid = JRequest::getVar('Itemid');
		
        //$id = $state->get('filter.id');
        $path    = $app->getPathWay();
        $params = $app->getParams();
        $db = JFactory::getDBO(); 
        $task = JRequest::getVar('task'); 
        $list = array();
	
       
       $id = JRequest::getInt('order_id');
	   	
		
       
       $data = JRequest::getVar('e');
	   
  
  
   $order = travel::getOrder($id);
   
   $xml = xml::Booking_xml($order, 'confirm' );
   
    $db=JFactory::getDBO();
    $q = 'UPDATE #__travel_order SET `status`="confirm" WHERE id='.$order->id; 
    $db->setQuery($q);
    $db->Query(); 
   
   $rowe = xml::go_xml($xml);
  
    
   if (!$order)
       {
       $app->redirect('index.php');
       return;
       }
   $obj = travel::getOtelVid($order->otel);
   $this->region = travel::region($order->region);
    
   $d = array();
   $d['e'] = $data;
   //echo '<pre>'; print_r($order);
  // exit;
   
   
   $this->link =travel::link('travel',  "&".http_build_query($d));
    
   $path->addItem('Hotels '.$this->region->title, $this->link);
   
    $link =travel::link('travel',  "&id=".$obj->id."&".http_build_query($d));
    $path->addItem($obj->title, $link);
        
   
   $path->addItem('Thank you');
   
       $page_title =  $metadesc = $metakey = $page_heading = null;
      
   
  
   
   
     $page_title = 'Thank you for using our services.';
     
      	$this->document->setTitle($page_title);
        if ($metadesc)
        $this->document->setDescription($metadesc);
        if ($metakey)
       	$this->document->setMetadata('keywords', $metakey);
       
       
    
    
 
        $this->assignRef('page_heading', $page_heading);
        $this->assignRef('page_title', $page_title);
        $this->assignRef('order', $order);
         $this->assignRef('data', $data);
	    $this->assignRef('params', $params);
        $this->assignRef('state', $state);
		$this->assignRef('user', $model->_users);
     
		

		parent::display($tpl);
	}

 
	protected function _prepareDocument($title = null)
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
	    $this->document->setTitle($title);
        
	 
	}
}