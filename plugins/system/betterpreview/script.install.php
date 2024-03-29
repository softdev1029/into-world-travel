<?php
/**
 * @package         Better Preview
 * @version         5.0.1PRO
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2016 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/script.install.helper.php';

class PlgSystemBetterPreviewInstallerScript extends PlgSystemBetterPreviewInstallerScriptHelper
{
	public $name           = 'BETTER_PREVIEW';
	public $alias          = 'betterpreview';
	public $extension_type = 'plugin';

	public function uninstall($adapter)
	{
		$this->uninstallPlugin($this->extname, 'editors-xtd');
	}

	public function onAfterInstall()
	{
		$this->createTable();
		$this->fixSystemPluginOrdering();
		$this->deleteOldModule();
	}

	public function createTable()
	{
		$query = "CREATE TABLE IF NOT EXISTS `#__betterpreview_sefs` (
			`url` VARCHAR(255) NOT NULL,
			`sef` VARCHAR(255) NOT NULL,
			`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
			KEY  (`url`(50))
		) DEFAULT CHARSET=utf8;";
		$this->db->setQuery($query);
		$this->db->execute();

		$query = 'SHOW INDEX FROM ' . $this->db->quoteName('#__betterpreview_sefs');
		$this->db->setQuery($query);
		$index = $this->db->loadObject();

		if (!empty($index->Key_name) && $index->Key_name == 'PRIMARY')
		{
			$query = 'ALTER TABLE ' . $this->db->quoteName('#__betterpreview_sefs')
				. ' DROP INDEX ' . $this->db->quoteName($index->Key_name) . ','
				. ' ADD INDEX ' . $this->db->quoteName('url') . ' (' . $this->db->quoteName('url') . '(50));';
			$this->db->setQuery($query);
			$this->db->execute();
		}

		// delete all cached sef urls
		$this->db->truncateTable('#__betterpreview_sefs');
	}

	public function fixSystemPluginOrdering()
	{
		// force system plugin ordering
		$query = $this->db->getQuery(true)
			->update('#__extensions')
			->set($this->db->quoteName('ordering') . ' = -1')
			->where($this->db->quoteName('element') . ' = ' . $this->db->quote('betterpreview'))
			->where($this->db->quoteName('folder') . ' = ' . $this->db->quote('system'));
		$this->db->setQuery($query);
		$this->db->execute();

		JFactory::getCache()->clean('_system');
	}

	public function deleteOldModule()
	{
		// delete old module
		$query = $this->db->getQuery(true)
			->delete('#__extensions')
			->where($this->db->quoteName('element') . ' = ' . $this->db->quote('mod_betterpreview'));
		$this->db->setQuery($query);
		$this->db->execute();

		$query->clear()
			->delete('#__modules')
			->where($this->db->quoteName('module') . ' = ' . $this->db->quote('mod_betterpreview'));
		$this->db->setQuery($query);
		$this->db->execute();

		$folder = JPATH_ADMINISTRATOR . '/modules/mod_betterpreview';
		if (JFolder::exists($folder))
		{
			JFolder::delete($folder);
		}

		JFactory::getCache()->clean('_system');
	}
}
