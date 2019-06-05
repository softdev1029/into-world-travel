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

if (App::getInstance('zoo')->joomla->isVersion('2.5')) {

	class JFormFieldZldummy extends JFormField {

		protected $type = 'Zldummy';

		// usin Zl Field on modules it's not possible to save the values with no additinal CTRL because Joomla! checks the XML before saving them.
		// an workaround is to just create an dummy xml with same name as the value wonted to be saved.

		public function getInput() {
			return;
		}

		// avoid rendering the title
		public function setup(&$element, $value, $group = null){}
	}

} else { // Joomla 3+

	class JFormFieldZldummy extends JFormField {

		protected $type = 'Zldummy';

		// usin Zl Field on modules it's not possible to save the values with no additinal CTRL because Joomla! checks the XML before saving them.
		// an workaround is to just create an dummy xml with same name as the value wonted to be saved.

		public function getInput() {
			return;
		}

		// avoid rendering the title
		public function setup(SimpleXMLElement $element, $value, $group = null){}
	}

}