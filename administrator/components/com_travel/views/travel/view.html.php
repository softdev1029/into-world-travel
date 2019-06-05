<?php
#http://webalan.ru

//--No direct access
defined( '_JEXEC' ) or die( '=;)' );

jimport( 'joomla.application.component.view');



class  travelViewtravel extends JViewLegacy
{

     function view_disp($tpl = null)
     {
        JToolBarHelper::title(   JText::_( 'PANEL' ), 'generic.png' ); 
        JToolBarHelper::preferences('com_travel', '400');               
      
  
        parent::display($tpl);
     }

      
      function display($tpl = null)
         {
     
        switch ($this->getLayout()) {
         
          default:
           $this->view_disp($tpl);
           break;
     }        
        
     }      }
