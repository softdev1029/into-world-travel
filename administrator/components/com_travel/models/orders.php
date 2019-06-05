<?php
/*
 Федянин А. 
 Webalan.ru
 */
defined( '_JEXEC' ) or die();
jimport('joomla.application.component.modellist');

 
class  travelModelorders extends JModelList
{
	protected	$option 		= 'com_travel';
 
 
 	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
			 
                 'id','a.id','ordering','a.ordering','name','a.name','published','a.published','phone','a.phone','fam','a.fam','email','a.email',
                
			);
		}

		parent::__construct($config);
	}
  
	
  protected function populateState($ordering = NULL, $direction = NULL)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

    	$state = $app->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $state);
 
       
 	$state = $app->getUserStateFromRequest($this->context.'.filter.region', 'filter_region', '', 'string');
		$this->setState('filter.region', $state);        
     	$state = $app->getUserStateFromRequest($this->context.'.filter.regionid', 'filter_regionid', '', 'string');
		$this->setState('filter.regionid', $state);  
 
  	$state = $app->getUserStateFromRequest($this->context.'.filter.otel', 'filter_otel', '', 'string');
		$this->setState('filter.otel', $state);        
     	$state = $app->getUserStateFromRequest($this->context.'.filter.otelid', 'filter_otelid', '', 'string');
		$this->setState('filter.otelid', $state);
 
		// Load the parameters.
		$params = JComponentHelper::getParams('com_travel');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.id', 'DESC');
	}
    
    	protected function getStoreId($id = '')
	{
		// Compile the store id.
	 
        
        
        $id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.kat');
		$id	.= ':'.$this->getState('filter.state');
	 
	 

		return parent::getStoreId($id);
	}
    protected function getListQuery()
	{
	 
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		 
		$query->select(
			 "a.*, o.title as otel_title, r.title as region_title,
             r.country_title"
		);
        
       
		$query->from('`#__travel_order` AS a');
       
      $query->join('LEFT','`#__travel_otel` AS o ON a.otel=o.vid');
	  $query->join('LEFT','`#__travel_region` AS r ON a.region=r.id');
	 
      $regionid = $this->getState('filter.regionid');
     
	if ($regionid)
    	$query->where('a.region = '.(int) $regionid);
        
        $otelid = $this->getState('filter.otelid');
     
	if ($otelid)
    	$query->where('o.vid = '.(int) $otelid); 
		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			}
			else
			{$search2 = $search;
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('
                ( a.first LIKE '.$search.' ) OR 
                ( a.last LIKE '.$search.' ) OR 
                ( a.phone LIKE '.$search.' ) OR 
                ( a.email LIKE '.$search.' ) OR
                ( a.roomid="'.$search2.'" ) OR 
                ( a.bronid="'.$search2.'" )  
                ');
			}
		}


       	// Filter by published state.
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.published = '.(int) $published);
		}
		else if ($published === '') {
			$query->where('(a.published IN (0, 1))');
		}
        
        
       //where
		$orderCol	= $this->state->get('list.ordering','a.id');
		$orderDirn	= $this->state->get('list.direction','ASC');
        
       
		$query->order($db->escape($orderCol.' '.$orderDirn));
       
		 

		  //echo nl2br(str_replace('#__', 'jos_', $query->__toString()));
       
		return $query;
	}
}
?>