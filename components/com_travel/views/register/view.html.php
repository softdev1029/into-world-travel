<?php
/**
  
 все вопросы по компоненту http://webalan.ru
 
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

 
class TravelViewRegister extends JViewLegacy
{
	protected $state = null;
	protected $item = null;
	protected $items = null;
	protected $pagination = null;

 
	function display($tpl = null)
	{
		// Initialise variables.
		$user = JFactory::getUser();
		$app = JFactory::getApplication();
	    $state 		= $this->get('State');
        $model = $this->getModel();
        $this->Itemid = JRequest::getVar('Itemid');
        $path    = $app->getPathWay();
        $task = JRequest::getVar('task'); 
        
        
        $mess = JRequest::getInt('mess');
        if ($mess)
        	$app->enqueueMessage(JText::_('COM_USERS_REGISTRATION_COMPLETE_ACTIVATE'));

        //Проверка авторизации 
          if ($model->_users->id!=0)
        {
            $msg = JText::_( 'auth_ok' );
            $return =  ('index.php?option=com_travel&Itemid='.$this->Itemid);
            $app->redirect($return, $msg);
         return;
        }
        
         $this->_prepareDocument('Register');    
         
        
        
		$this->assignRef('params', $params);
        $this->assignRef('state', $state);
		$this->assignRef('user', $model->_users);
     
		

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument($title = null)
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
	    $this->document->setTitle($title);
       
		 
	 
		
	 
	}
}
