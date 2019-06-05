<?php
 
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

 
class travelModelgr extends JModelAdmin
{
  	protected	$option 		= 'com_travel';
	protected 	$text_prefix	= 'com_travel';

	protected function canDelete($record)
	{
	   //exit;
		$user = JFactory::getUser();
	//	return parent::canDelete($record);
     
     
      
        return $user->authorise('core.delete', 'com_travel.gr.'.(int) $record->id);
	}
    
    	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		$table->title		= htmlspecialchars_decode($table->title, ENT_QUOTES);
	
   if (!$table->alias) $table->alias = $table->title;
	          $table->alias	= JApplication::stringURLSafe($table->alias);
  
 	if (empty($table->id)) {
			$table->reorder();
		}
	 
	}
	
       public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk)) {
		 
		 
 
           
		}

		return $item;
	}


//functionS_models
	protected function canEditState($record)
	{
	 
 
		 
			return parent::canEditState($record);
		 
	}
	
        
    
	public function getTable($type = 'gr', $prefix = 'Table', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) {
	 
		$app	= JFactory::getApplication();
		$form 	= $this->loadForm('com_travel.grs', 'gr', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		return $form;
	}
	
	protected function loadFormData()
	{ 
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_travel.edit.gr.data', array());
 
		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}
    
    
    	public function save($data)
	{
	      
		if (parent::save($data)) {
			 
                $id = $data['id'];
                 
                  if (empty($id)) 
                 {
				$this->_db->setQuery('SELECT MAX(id) FROM #__travel_gr');
				$id = $this->_db->loadResult();
                 }
//dops_savesa
                 
			return true;
		}

		return false;
	}
    
    	protected function getReorderConditions($table)
	{
		$condition = array();
		//$condition[] = 'region= '.(int) $table->region;
		return $condition;
	}
}
