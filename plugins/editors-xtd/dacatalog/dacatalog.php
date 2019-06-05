<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Editors-xtd.readmore
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Editor Readmore buton
 *
 * @since  1.5
 */
class PlgButtonDacatalog extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * Readmore button
	 *
	 * @param   string  $name  The name of the button to add
	 *
	 * @return array A two element array of (imageName, textToInsert)
	 */
	public function onDisplay($name)
	{
		$lang = & JFactory::getLanguage();
		$lang->load('com_dacatalog');

		$doc = JFactory::getDocument();
		$js = "
			function inserPriceTour(id) {
				var tag = '{pricetour ' + id + '}';

				jInsertEditorText(tag, '".$name."');
				SqueezeBox.close();
			}
		";

		$doc->addScriptDeclaration($js);

		$button = new JObject;
		$button->set('modal', true);
		$button->set('link', 'index.php?option=com_dacatalog&view=main&tmpl=component');
		$button->set('text', JText::_('ADD_PRICE'));
		$button->set('name', 'file-add');
		$button->set('options', "{handler: 'iframe', size: {x: 950, y: 600}}");

		return $button;
	}
}
