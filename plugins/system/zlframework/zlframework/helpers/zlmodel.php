<?php
/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die();

/*
	Class: ModelHelper
		Helper for models
*/
class ZlModelHelper extends AppHelper {

	/* prefix */
	protected $_prefix;

	/* models */
	protected $_models = array();
    
	/*
		Function: __construct
			Class Constructor.
	*/
	public function __construct($app) {
		parent::__construct($app);

		// set table prefix
		$this->_prefix = 'ZLModel';
	}

	/*
		Function: get
			Retrieve a model

		Parameters:
			$name - Model name
			$prefix - Model prefix

		Returns:
			Mixed
	*/
	public function get($name, $prefix = null) {
		
		// set prefix
		if ($prefix == null) {
			$prefix = $this->_prefix;
		}
		
		// load class
		$class = $prefix . $name;
		
		$this->app->loader->register($class, 'models:'.strtolower($name).'.php');
		
		// add model, if not exists
		if (!isset($this->_models[$name])) {
			$this->_models[$name] = ZLModel::getInstance($name, $prefix);
		}

		return $this->_models[$name];
	}

	/*
		Function: getNew
			Retrieve a new instance model

		Parameters:
			$name - Model name
			$prefix - Model prefix

		Returns:
			Mixed
	*/
	public function getNew($name, $prefix = null)
	{
		// set prefix
		if ($prefix == null) {
			$prefix = $this->_prefix;
		}

		// register class
		$class = $prefix.$name;
		$this->app->loader->register($class, 'models:'.strtolower($name).'.php');

		$model = ZLModel::getInstance($name, $prefix);
		if (!isset($this->_models[$name])) {
			$this->_models[$name] = $model;
		}
		return $model;
	}
	
	/*
		Function: __get
			Retrieve a model

		Parameters:
			$name - Model name

		Returns:
			Mixed
	*/
	public function __get($name) {
		return $this->get($name);
	}
	
}