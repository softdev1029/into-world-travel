<?php
/**
 * Поиск отелей
 * 
все вопросы по компоненту http://webalan.ru
*/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

 
class TravelViewMaps extends JViewLegacy
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
       
       $id = JRequest::getInt('id');
       $data = JRequest::getVar('e');
  
  
   $region = $data['region']; 
   $this->region = travel::region($region);
    
    $this->start = travel::strtotimed($data['data_start']);
    $this->end = travel::strtotimed($data['data_end']); 
     
   $d = array();
   $d['e'] = $data;
   
   $link =travel::link('travel',  "&".http_build_query($d));
   
     
  
   $this->month_start = travel::month_name(date('m',$this->start));
   $this->month_end = travel::month_name(date('m',$this->end));
   
  
     
       $page_title =  $metadesc = $metakey = $page_heading = null;
      
   
   // $fleds = 'Region, Address, GeneralInfo, Photo, Description, Rating';
    //$data['fleds'] = 'basic';
    
    //$data['DetailLevel']='full';
   $row =  xml::send_to_xml ($data, 0);
   
   $this->data = $data;//Параметрый запроса
 
   //Поиск отелей
   $this->xml_test = simplexml_load_string($row);
   
  
   
   
   
     $active	= $app->getMenu()->getActive();
     if ($active) {
     if ($active->params->get('page_title'))   
     $page_title = $active->params->get('page_title');  
     $metadesc = $active->params->get('menu-meta_description');  
     $metakey = $active->params->get('menu-meta_keywords');  
     $page_heading = $active->params->get('page_heading');
    }
     if (!$page_title)  $page_title = 'Поиск отелей';
     
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
     
     

		parent::display($tpl);
	}

 
	protected function _prepareDocument($title = null)
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
	    $this->document->setTitle($title);
        
	 
	}
}