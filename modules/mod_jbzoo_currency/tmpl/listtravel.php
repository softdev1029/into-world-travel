<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Denis Smetannikov <denis@jbzoo.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

echo '<div class="currency-select jbzoo">' . $modHelper->renderSelectlist() . '</div>';
echo "<script>
			jQuery(document).ready(function($){
					//if (!sessionStorage.getItem('argo_p_al-".$mid."')) {
					//	sessionStorage.setItem('argo_p_al-".$mid."', '0');
					//}
					var scountry".$this->_module->id." = new show_country('#cur-".$this->_module->id."');
				});
			</script>";
