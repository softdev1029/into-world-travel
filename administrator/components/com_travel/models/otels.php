<?php
/*
 Федянин А. 
 Webalan.ru
 */
defined( '_JEXEC' ) or die();
jimport('joomla.application.component.modellist');

 
class  travelModelotels extends JModelList
{
	protected	$option 		= 'com_travel';
 
 
 	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
			 
                 'id','a.id','ordering','a.ordering','title','a.title','published','a.published','region','a.region',
                
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
 
       $state = $app->getUserStateFromRequest($this->context.'.filter.pol', 'filter_pol', '', 'string');
		$this->setState('filter.pol', $state);
       
         
       $region = $app->getUserStateFromRequest($this->context.'.filter.region', 'filter_region', '', 'string');
		$this->setState('filter.region', $region);
 
		// Load the parameters.
		$params = JComponentHelper::getParams('com_travel');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.id', 'asc');
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
			 "a.* "
		);
        $query->select("region2.title as region2_title");
       $query->select("region.title as region_title");
		$query->from('`#__travel_otel` AS a');
       
     $query->join("LEFT","`#__travel_region` AS region ON 
     a.cityId=region.id  
     
     ");
	    $query->join("LEFT","`#__travel_region` AS region2 ON 
     a.region_id=region2.id  
     
     ");
	 
        $region = $this->getState('filter.region');
	     if ($region)
         $query->where("a.region ='$region' ");
         
         	$published = $this->getState('filter.pol');
        if ($published)
		 {
		  if ($published==1)
		 $query->where(' a.proc<>""');
         else
         $query->where(' a.proc=""');
         
	     }

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('( a.title LIKE '.$search.' )');
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
       
		 

	 
		return $query;
	}
}
?>