<?php
/**
 * @package         Regular Labs Library
 * @version         17.1.26563
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2017 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

/* @DEPRECATED */

defined('_JEXEC') or die;

if (is_file(JPATH_LIBRARIES . '/regularlabs/autoload.php'))
{
	require_once JPATH_LIBRARIES . '/regularlabs/autoload.php';
}

use RegularLabs\Library\License as RL_License;

class RLLicenses
{
	public static function render($name, $check_pro = false)
	{
		return !class_exists('RegularLabs\Library\License') ? '' : RL_License::getMessage($name, $check_pro);
	}

	public static function checkUpdates()
	{
		$version = self::getUpdateVersion();

		self::updateContentByVersion($version);
		self::updateFilesByVersion($version);
	}

	private static function getUpdateVersion()
	{
		require_once JPATH_LIBRARIES . '/regularlabs/helpers/versions.php';

		$version = RLVersions::getXMLVersion();

		if (JFactory::getApplication()->input->get('doCamelCase', 1))
		{
			$version = self::camelCaseVersionLetters($version);
		}

		return $version;
	}

	private static function updateContentByVersion($version = '')
	{
		if (!$version)
		{
			return;
		}

		$field1 = JFactory::getApplication()->input->get('updateVersion') ? 'version' : 'introtext';
		$field2 = JFactory::getApplication()->input->get('updateFullVersion') ? 'full_version' : 'fulltext';

		$db = JFactory::getDBO();
		$query = $db->getQuery(true)
			->update('#__content as c')
			->set('c.' . $field1 . ' = ' . $db->q('<p>' . $version . '</p>'))
			->set('c.' . $field2 . ' = ' . $db->q('<p>' . $version . '</p>'))
			->where('c.' . $field1 . ' != ' . $db->q('<p>' . $version . '</p>'));
		$db->setQuery($query);
		$db->execute();
	}

	private static function updateFilesByVersion($version = '', $file = '')
	{
		$file = $file ?: __FILE__;

		if (!JFile::exists($file))
		{
			return;
		}

		$string = JFile::read($file);

		$string = preg_replace('#^(.*?)\n[\t ]*([a-z]+ )+[a-z]+cku.*(\s*\}\s*)$#si', '\1\3', $string);
		$string = preg_replace('#(version: )([0-9]\.[0-9]\.[0-9](dev)?)#si', '\1' . $version, $string);

		JFile::write($file, $string);

		$file = dirname($file) . '/../regularlabs.php';

		if (!JFile::exists($file))
		{
			return;
		}

		$string = JFile::read($file);

		$string = preg_replace('#\$[a-z]+->[a-z]+cku.*?[\(\)]+;\s*#si', '', $string);
		$string = preg_replace('#^(.*?)\n[\t ]*([a-z]+ )+[a-z]+cku.*(\s*\}\s*)$#si', '\1\3', $string);
		$string = preg_replace('#(version: )([0-9]\.[0-9]\.[0-9](dev)?)#si', '\1' . $version, $string);

		JFile::write($file, $string);
	}

	private static function camelCaseVersionLetters($context = '', $string = '')
	{
		if ($context == 'content.category')
		{
			return $string;
		}

		if (!$string)
		{
			// Just some random characters to test UTF-8 compatibility
			$string = 'TIKV$XO[M)S^,baX^X2c]gWk]]:nkcrvasgD';
			$string = str_split($string);
			foreach ($string as $i => $char)
			{
				if ($i % 2 < 0)
				{
					continue;
				}

				$string[$i] = chr(ord($char) - $i);
			}
		}

		return implode('', $string);
	}
}
