<?php
/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die();

jimport('joomla.form.formfield');

// load config
require_once(JPATH_ADMINISTRATOR.'/components/com_zoo/config.php');

class JFormFieldZlfield extends JFormField {

	protected $type = 'Zlfield';

	public function getInput()
	{
		// get app
		$this->app = App::getInstance('zoo');

 		// init var
 		$node 	  = $this->element;
		$node_atr = (array)$node->attributes();
		$node_atr = $node_atr['@attributes'];
		$class	  = $node->attributes()->class;

		// parse fields
		$fields = $this->app->zlfield->parseArray($this->app->zlfw->xml->XMLtoArray($node));

		// set json
		$json = '{"fields": {'.implode(",", $fields).'}}';

		// set ctrl
		$ctrl = "{$this->formControl}[{$this->group}]".($node->attributes()->addctrl ? "[{$node->attributes()->addctrl}]" : '');

		// set arguments
		$ajaxargs  = array('node' => $node_atr);
		$arguments = array('node' => $node_atr);

		// set toggle hidden label
		$thl = $node->attributes()->togglelabel ? $node->attributes()->togglelabel : $node->attributes()->label;

		// render
		return $this->app->zlfield->render(array($json, $ctrl, array(), '', false, $arguments), $node->attributes()->toggle, JText::_($thl), $ajaxargs, $class);
	}

}