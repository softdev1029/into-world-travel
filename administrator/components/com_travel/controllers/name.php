<?php
defined('_JEXEC') or die();
jimport('joomla.application.component.controllerform');

class travelControllername extends JControllerForm
{

	protected	$option 		= 'com_travel';
	
     
    
	protected function allowAdd($data = array())
	{
		return parent::allowAdd($data);
	}


		protected function allowEdit($data = array(), $key = 'id')
	{
		// Initialise variables.
		$recordId	= (int) isset($data[$key]) ? $data[$key] : 0;
		$user		= JFactory::getUser();
		$userId		= $user->get('id');

		// Check general edit permission first.
		if ($user->authorise('core.edit', 'com_travel.name.'.$recordId)) {
		  
			return true;
		}

	   

		// Since there is no asset tracking, revert to the component permissions.
		return parent::allowEdit($data, $key);
	}

 
}