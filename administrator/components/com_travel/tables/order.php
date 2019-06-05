<?php
/*
 *  webalan.ru ;
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filter.input');

class Tableorder extends JTable
{
	function __construct(& $db) {
		parent::__construct('#__travel_order', 'id', $db);
	}
    
    
    
    public function bind($array, $ignore = '')
	{
	
   	 

		return parent::bind($array, $ignore);
	}
    
    
    	function store($updateNulls = false)
	{
		// Get the table key and key value.
		$k = $this->_tbl_key;
		$key =  $this->$k;
        
    
        
        $titles = JRequest::getVar('titles');
        if (($titles))
        {
            $titles = explode("\n",$titles);
             
        }
        
        $stop = false;
 if (is_array( $titles))
 {
    foreach ($titles as $tit)
    {$stop = true;
        $this->id = 0;
        $this->title  = trim($tit);
       	$return = $this->_db->insertObject($this->_tbl, $this, $this->_tbl_key);
    }
 }

 if (!$stop):

		// Insert or update the object based on presence of a key value.
		if ($key) {
			// Already have a table key, update the row.
			$return = $this->_db->updateObject($this->_tbl, $this, $this->_tbl_key, $updateNulls);
		}
		else {
			// Don't have a table key, insert the row.
			$return = $this->_db->insertObject($this->_tbl, $this, $this->_tbl_key);
		}

endif;
		// Handle error if it exists.
		if (!$return)
		{
			$this->setError(JText::sprintf('JLIB_DATABASE_ERROR_STORE_FAILED', strtolower(get_class($this)), $this->_db->getErrorMsg()));
			return false;
		}

	 
   
    
    
		return true;
	}

}
?>