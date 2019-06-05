<?php
/*
 Федянин А. 
 Webalan.ru
 */
defined( '_JEXEC' ) or die();
jimport('joomla.application.component.modellist');

 
class  travelModelregions extends JModelList
{
	protected	$option 		= 'com_travel';
 
 
 	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
			 
                 'id','a.id','ordering','a.ordering','title','a.title','published','a.published',
                
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
        
       
		$query->from('`#__travel_region` AS a');
       
     
	  
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
				$query->where('( a.title LIKE '.$search.' ) OR ( a.country_title LIKE '.$search.' )');
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