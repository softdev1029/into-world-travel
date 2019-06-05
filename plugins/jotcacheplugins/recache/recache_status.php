<?php
/*
 * @version 5.3.2
 * @package JotCachePlugins
 * @category Joomla 3.5
 * @copyright (C) 2010-2016 Vladimir Kanich
 * @license GNU General Public License version 2 or later
 */
defined('_JEXEC') or die('Restricted access');
$lang = JFactory::getLanguage();
$lang->load('plg_jotcacheplugins_recache', JPATH_ADMINISTRATOR, null, false, false);
$database = JFactory::getDBO();
$sql = $database->getQuery(true);
$sql->select('COUNT(*)')
->from('#__jotcache')
->where($database->quoteName('recache') . ' = ' . $database->quote(1));
$database->setQuery($sql);
$total = $database->loadResult();
echo sprintf(JText::_('PLG_JCPLUGINS_RECACHE_STATUS'), $total);
