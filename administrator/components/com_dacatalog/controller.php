<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

/**
 * @package		Joomla
 * @subpackage	Config
 */

class DaCatalogController extends JControllerLegacy
{
	function __construct($config = array())
	{
		parent::__construct($config);

		if (strpos(JRequest::getVar('task'), "_exit") !== false) {
			$this->registerTask( JRequest::getVar('task'), str_replace('_exit', '', JRequest::getVar('task')) );
		}
		
		$this->registerTask( 'up',   'ordermove' );
		$this->registerTask( 'down', 'ordermove' );
		
		$this->registerTask( 'add', 'redirects' );


		$app = JFactory::getApplication();

		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}

		$search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$app->setUserState('filter.search', $search);
	}

	function redirects()
	{
		$option = JRequest::getVar( 'option' );
		$viewName = JRequest::getVar( 'view' );
	   	$this->setRedirect( "index.php?option=".$option."&view=".$viewName."&layout=".$this->getTask() );
	}
	
	function cancel()
	{
		$option = JRequest::getVar( 'option' );
		$viewName = JRequest::getVar( 'view' );
		$layout_redirect = JRequest::getVar( 'layout_redirect' );
		
		if(!empty($layout_redirect))
			$layout_redirect = '&layout='.$layout_redirect;

	   	$this->setRedirect( "index.php?option=".$option."&view=".$viewName.$layout_redirect );
	}
	
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT . '/helpers/dacatalog.php';

		if(!$this->input->get("view"))
			$this->input->set("view", "main");

		parent::display();
		return $this;
	}

	function delete()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit( 'Invalid Token' );

		$db =& JFactory::getDBO();
		$cid = $this->input->get("cid", array(), "array");
		$viewName = $this->input->get("view");

		foreach ($cid AS $id) {
 			if($viewName == 'main')	{
				$query = "DELETE FROM #__dacatalog_elements WHERE id = $id";
			}

			if($viewName == 'complectations')	{
				$query = "DELETE FROM #__dacatalog_complectations WHERE id = $id";
			}

			$db->setQuery( $query );
			$db->execute();
		}

		$msg_array['msg'] = 'Удалено';
	    $return = @$_SERVER['HTTP_REFERER'];
	    $this->setRedirect( $return, $msg_array['msg'], $msg_array['error'] );
	}

	function publish()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit( 'Invalid Token' );

		$db =& JFactory::getDBO();
		$cid = $this->input->get("cid", array(), "array");
		$viewName = $this->input->get("view");
		$publish  = $this->getTask() == 'publish' ? 1 : 0;

		foreach ($cid as $id) {
			if($viewName == 'main') {
				$query = "UPDATE #__dacatalog_elements SET published = '".$publish."' WHERE id = '".$id."'";
			}

			if($viewName == 'complectations') {
				$query = "UPDATE #__dacatalog_complectations SET published = '".$publish."' WHERE id = '".$id."'";
			}

			$db->setQuery( $query );
			$db->execute();
		}

	    $return = @$_SERVER['HTTP_REFERER'];
		$this->setRedirect( $return );
	}

	function ordermove()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit( 'Invalid Token' );

		$db =& JFactory::getDBO();
		$cid = $this->input->get("cid", array(), "array");
		$view = $this->input->get("view");
		$filter_order_Dir = $this->input->get("filter_order_Dir");
		$order_var  = $filter_order_Dir == 'asc' ? -1 : 1;

		if($view == 'main') {
			$table = "#__dacatalog_elements";
		}
		if($view == 'complectations') {
			$table = "#__dacatalog_complectations";
		}

		if($this->getTask() == 'up')
		{
			foreach ($cid as $id)
			{
				$query = "SELECT ordering FROM ".$table." WHERE id = '".$id."'";
				$db->setQuery($query);
				$ordering = $db->loadResult();

				$query = "UPDATE ".$table." SET ordering = '".$ordering."' WHERE ordering = '".($ordering + $order_var)."'";
				$db->setQuery( $query );
				$db->execute();

				$query = "UPDATE ".$table." SET ordering = '".($ordering + $order_var)."' WHERE id = '".$id."'";
				$db->setQuery( $query );
				$db->execute();
			}
		}

		if($this->getTask() == 'down')
		{
			foreach ($cid as $id)
			{
				$query = "SELECT ordering FROM ".$table." WHERE id = '".$id."'";
				$db->setQuery($query);
				$ordering = $db->loadResult();

				$query = "UPDATE ".$table." SET ordering = '".$ordering."' WHERE ordering = '".($ordering - $order_var)."'";
				$db->setQuery( $query );
				$db->execute();

				$query = "UPDATE ".$table." SET ordering = '".($ordering - $order_var)."' WHERE id = '".$id."'";
				$db->setQuery( $query );
				$db->execute();
			}
		}

		$return = @$_SERVER['HTTP_REFERER'];
		$this->setRedirect( $return );
	}
}