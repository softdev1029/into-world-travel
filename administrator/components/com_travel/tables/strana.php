<?php
/*
 *  webalan.ru ;
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filter.input');

class Tablestrana extends JTable
{
	function __construct(& $db) {
		parent::__construct('#__travel_region', 'id', $db);
	}
    
     

}
?>