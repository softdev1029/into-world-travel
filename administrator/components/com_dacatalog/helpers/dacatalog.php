<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_weblinks
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Weblinks helper.
 *
 * @since  1.6
 */
class DacatalogHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public static function addSubmenu($vName = 'main')
	{
		JHtmlSidebar::addEntry(
			JText::_('main'),
			'index.php?option=com_dacatalog&view=main',
			$vName == 'main'
		);

		JHtmlSidebar::addEntry(
			JText::_('categories'),
			'index.php?option=com_categories&extension=com_dacatalog',
			$vName == 'categories'
		);

		JHtmlSidebar::addEntry(
			'Авиабилеты',
			'index.php?option=com_dacatalog&view=flights',
			$vName == 'flights'
		);

		JHtmlSidebar::addEntry(
			'Отели',
			'index.php?option=com_dacatalog&view=hotels',
			$vName == 'hotels'
		);

		JHtmlSidebar::addEntry(
			'Экскурсии',
			'index.php?option=com_dacatalog&view=excursions',
			$vName == 'excursions'
		);

		JHtmlSidebar::addEntry(
			'Билеты на поезда',
			'index.php?option=com_dacatalog&view=trains',
			$vName == 'trains'
		);

		JHtmlSidebar::addEntry(
			'Визовая поддержка',
			'index.php?option=com_dacatalog&view=visa',
			$vName == 'visa'
		);
	}
}
