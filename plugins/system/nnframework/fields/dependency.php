<?php
/**
 * @package         NoNumber Framework
 * @version         16.3.25323
 * 
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2016 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

jimport('joomla.form.formfield');

require_once dirname(__DIR__) . '/helpers/functions.php';
require_once dirname(__DIR__) . '/helpers/field.php';

class JFormFieldNN_Dependency extends NNFormField
{
	public $type = 'Dependency';

	protected function getLabel()
	{
		return '';
	}

	protected function getInput()
	{
		$this->params = $this->element->attributes();

		JHtml::_('jquery.framework');
		NNFrameworkFunctions::script('nnframework/script.min.js', '16.3.25323');

		if ($file = $this->get('file'))
		{
			$label = $this->get('label', 'the main extension');

			NNFieldDependency::setMessage($file, $label);

			return '';
		}

		$path      = ($this->get('path') == 'site') ? '' : '/administrator';
		$label     = $this->get('label');
		$file      = $this->get('alias', $label);
		$file      = preg_replace('#[^a-z-]#', '', strtolower($file));
		$extension = $this->get('extension');

		switch ($extension)
		{
			case 'com';
				$file = $path . '/components/com_' . $file . '/com_' . $file . '.xml';
				break;
			case 'mod';
				$file = $path . '/modules/mod_' . $file . '/mod_' . $file . '.xml';
				break;
			default:
				$file = '/plugins/' . str_replace('plg_', '', $extension) . '/' . $file . '.xml';
				break;
		}

		$label = JText::_($label) . ' (' . JText::_('NN_' . strtoupper($extension)) . ')';

		NNFieldDependency::setMessage($file, $label);

		return '';
	}
}

class NNFieldDependency
{
	static function setMessage($file, $name)
	{
		jimport('joomla.filesystem.file');

		$file = str_replace('\\', '/', $file);
		if (strpos($file, '/administrator') === 0)
		{
			$file = str_replace('/administrator', JPATH_ADMINISTRATOR, $file);
		}
		else
		{
			$file = JPATH_SITE . '/' . $file;
		}
		$file = str_replace('//', '/', $file);

		$file_alt = preg_replace('#(com|mod)_([a-z-_]+\.)#', '\2', $file);

		if (!JFile::exists($file) && !JFile::exists($file_alt))
		{
			$msg          = JText::sprintf('NN_THIS_EXTENSION_NEEDS_THE_MAIN_EXTENSION_TO_FUNCTION', JText::_($name));
			$message_set  = 0;
			$messageQueue = JFactory::getApplication()->getMessageQueue();
			foreach ($messageQueue as $queue_message)
			{
				if ($queue_message['type'] == 'error' && $queue_message['message'] == $msg)
				{
					$message_set = 1;
					break;
				}
			}
			if (!$message_set)
			{
				JFactory::getApplication()->enqueueMessage($msg, 'error');
			}
		}
	}
}
