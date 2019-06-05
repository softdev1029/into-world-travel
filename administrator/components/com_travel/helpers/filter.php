<?php
 
class FILTER_HTML
{

public static function type()
	{
	 
  	 
		  
		$pgbc = array();
        $pgbc[0] = new stdClass();
        $pgbc[0]->text ='С наценкой';
        $pgbc[0]->value =1;
          $pgbc[1] = new stdClass();
        $pgbc[1]->text ='Без наценки';
        $pgbc[1]->value =2;
		return $pgbc;

	}
public  function filter ($table = null)
	{
		$db = &JFactory::getDBO();

       //build the list of categories
		$query = 'SELECT a.title AS text, a.id AS value'
		. ' FROM #__travel_'.$table.' AS a'
	 
		. ' ORDER BY a.title';
       
       
		$db->setQuery( $query );
		$pgbc = $db->loadObjectList();
	
	  
	 
		return $pgbc;

	}
}
?>