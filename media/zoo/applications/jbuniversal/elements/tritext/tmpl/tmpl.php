<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 */
// no direct access
defined('_JEXEC') or die( 'Restricted access' );
print 
 '<div class="itincontainer"><div class="titleit">';
if ($this->get('level1')) {	
 print 
 '<div class="titleitday">'
 .$this->get('level1')
 .'</div>';
}
 print '<span>'
 .$this->get('level2').'</span></div><p class="itinbox">'
 .$this->get('level3').'</p></div> ';			
 ?>