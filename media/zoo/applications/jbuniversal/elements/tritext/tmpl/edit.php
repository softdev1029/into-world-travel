<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 */
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

 print 		
  $this->app->html->_('control.text', $this->getControlName('level1'), $this->get('level1'), 'size="5" style=" width:100px;" title="'.JText::_('Text').'" placeholder="'.JText::_('Day').'"').'<br />'.
  $this->app->html->_('control.text', $this->getControlName('level2'), $this->get('level2'), 'size="10" style=" margin-left:30px; width:100px;display: block;float: left;" title="'.JText::_('Text').'" placeholder="'.JText::_('Name day').'"').
  $this->app->html->_('control.textarea', $this->getControlName('level3'), $this->get('level3'), 'size="60" style=" height: 150px;" title="'.JText::_('Text').'" placeholder="'.JText::_('Program').'"');			
 ?>