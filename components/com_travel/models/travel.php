<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.modellist');


class travelModeltravel extends JModelList
{
	
 public $_context = 'com_travel.travel';
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
 
     $kat = JRequest::getInt('kat');
     $this->setState('filter.kat', $kat);
   
     
      
        $id = JRequest::getInt('id'); 
        $this->setState('filter.id', $id);
        $this->_id = $id;
         
        $land = JRequest::getInt('land'); 
        $this->setState('filter.land', $land);
       
       
       
        //$menu_params = new JParameter( $menu->params );
        $limit  =  JRequest::getVar('limit',10);
        
         
 
        
        $text  =  JRequest::getVar('text');
        $this->setState('filter.text', $text);
        $state  =  JRequest::getInt('state',0);
        $this->setState('filter.state', $state);
        $this->setState('list.limit', $limit);
	 
	 
	
		 
	  
	}
    public function getImages()
  { 
   $id = $this->getState('filter.id');
    $q = 'SELECT * FROM #__travel_prod_images WHERE vid='.(int)$id." ORDER BY ordering";
     $this->_db->setQuery($q);
     return $this->_db->LoadObjectList(); 
  }
  
  public function getKat()
  {  $kat = $this->state->get('filter.kat');
     $q = "SELECT * FROM #__travel_kat WHERE published=1  AND id=".$kat;
     $this->_db->setQuery($q);
     return $this->_db->LoadObject(); 
  }
   
    
    
            public function getObject()
  {        
    
    $id = $this->getState('filter.id');
    if ($id) {
            $q = 'SELECT a.*, kat.title as kat_title, kat.content2 
             FROM #__travel_prod AS a
              LEFT JOIN #__travel_kat AS kat ON a.kat = kat.id
            
              WHERE a.published=1 AND a.id='.$id;
            $this->_db->setQuery($q);
            return $this->_db->LoadObject(); 
            }
            else return false;
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

		function getListQuery()
	{   $db = $this->getDbo();
		$query = $db->getQuery(true);
		// Set the blog ordering
		$params = $this->state->params;
	  
  	$query->select(
			 "a.*, kat.title as kat_title
             , 
 (SELECT images FROM #__travel_prod_images AS img 
 WHERE img.vid=a.id ORDER BY img.ordering ASC LIMIT 1) as images 
             "
		);
		$query->from('`#__travel_prod` AS a') 
        ->join('LEFT', '#__travel_kat AS kat ON a.kat = kat.id');
        
        
        $kat = $this->state->get('filter.kat');
        if ($kat)
        $query->where('a.kat='.$kat);     
            
         
         
         
        $query->where('a.published=1'); 
     	$orderby =   ' a.ordering ASC ';
		$this->setState('list.ordering', $orderby);
		$this->setState('list.direction', '');
	 
        $orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
	    $query->order($db->escape($orderCol.' '.$orderDirn));

	   //echo	 nl2br(str_replace('#__','dar1w_',$query));
    
		return $query;
	} 
     
    
}
