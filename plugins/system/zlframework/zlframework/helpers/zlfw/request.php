<?php
/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die();

/*
	Class: zlfwHelperRequest
		The ZLFW request helper class
*/
class zlfwHelperRequest extends AppHelper {

	/**
	 * isAjax
	 *
	 * @return bool True if an ajax call is being made
	 */
	public function isAjax(){
		return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest');
	}
}