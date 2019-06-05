<?php
/**
 * @package     ZL Elements
 * @version     3.3.0
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die;
	
$separator = $params->find('separator._by_custom') != '' ? $params->find('separator._by_custom') : $params->find('separator._by');

// render
$result = $this->getRenderedValues($params);
$result = $this->app->zlfw->applySeparators($separator, $result['result'], $params->find('separator._class'), $params->find('separator._fixhtml'));

echo $this->app->zlfw->replaceShortCodes($result, array('item' => $this->_item));
