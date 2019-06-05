<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Denis Smetannikov <denis@jbzoo.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


App::getInstance('zoo')->jbassets->jbimagePopup();

echo '<a ' . $linkAttrs . '><img style="float:'. $align  .';"' . $imageAttrs . ' /></a><p> ' . $text . '</p><div class="clear clr"></div>' . "\n";