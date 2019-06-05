<?php
 
defined('_JEXEC') or die();


class JFormFieldorderx extends JFormField
{
	protected $type 		= 'orderx';

	protected function getInput() {
		
		$db = JFactory::getDBO();

		$query = 'SELECT a.title AS text, a.id AS value'
		. ' FROM #__travel_order AS a ORDER BY a.ordering ASC';
	 
	 
		
		
		
		$db->setQuery( $query );
		$guestbooks = $db->loadObjectList();
		
     	array_unshift($guestbooks, JHTML::_('select.option', '', '- '.JText::_('SELECT').' -', 'value', 'text'));

		return JHTML::_('select.genericlist',  $guestbooks, $this->name."[]", 'multiple class="inputbox"', 'value', 'text', $this->value, $this->id );

		
	}
}
?>