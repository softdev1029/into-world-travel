<?php
/**
 * Поиск отелей
 * 
все вопросы по компоненту http://webalan.ru
*/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

 
class travelViewFail extends JViewLegacy
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
       
        $return = JRequest::getVar('return');
       $data = JRequest::getVar('e');
  
  
   $order = travel::getOrder($id);
   if (!$order)
       {
       $app->redirect('index.php');
       return;
       }
   $obj = travel::getOtelVid($order->otel);
   $this->region = travel::region($order->region);
    
    
   
   $d = array();
   $d['e'] = $data;
   
   $this->link =travel::link('travel',  "&".http_build_query($d));
    
   $path->addItem('Hotels '.$this->region->title, $this->link);
   
    $link =travel::link('travel',  "&id=".$obj->id."&".http_build_query($d));
    $path->addItem($obj->title, $link);
        
   
   $path->addItem('Error');
   
       $page_title =  $metadesc = $metakey = $page_heading = null;
      
   
 
   
   
    $page_title = 'Error.';
     
      	$this->document->setTitle($page_title);
        if ($metadesc)
        $this->document->setDescription($metadesc);
        if ($metakey)
       	$this->document->setMetadata('keywords', $metakey);
       
       
    
    
 
        $this->assignRef('page_heading', $page_heading);
        $this->assignRef('page_title', $page_title);
        
         $this->assignRef('data', $data);
	    $this->assignRef('params', $params);
        $this->assignRef('state', $state);
		$this->assignRef('user', $model->_users);
     	$this->assignRef('return', $return);
			$this->assignRef('order', $order);

		parent::display($tpl);
	}

 
	protected function _prepareDocument($title = null)
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
	    $this->document->setTitle($title);
        
	 
	}
}