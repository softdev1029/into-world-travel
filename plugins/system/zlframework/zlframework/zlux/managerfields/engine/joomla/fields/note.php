<?php
/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die();

if (!$fld->get('label') && !$fld->get('desc'))
{
	return;
}

$title = (string) $fld->get('label');
$heading = (string) $fld->get('heading') ? $fld->get('heading') : 'h4';
$description = (string) $fld->get('desc');
// $class = !empty($this->class) ? ' class="' . $this->class . '"' : '';
$close = (string) $fld->get('close');

$html = array();

if ($close)
{
	$close = $close == 'true' ? 'alert' : $close;
	$html[] = '<button type="button" class="close" data-dismiss="' . $close . '">&times;</button>';
}

// j2.5 fix
if ($this->app->joomla->isVersion('2.5')) {
	$this->app->document->addStyleDeclaration('
		fieldset label.note * {
			margin: 0;
		}
	');
	$html[] = !empty($title) ? '<label class="note"><' . $heading . '>' . JText::_($title) . '</' . $heading . '></label>' : '';
} else {
	$html[] = !empty($title) ? '<' . $heading . '>' . JText::_($title) . '</' . $heading . '>' : '';
}

// j2.5 fix
if ($this->app->joomla->isVersion('2.5')) {
	$this->app->document->addStyleDeclaration('
		fieldset div.note {
			float: left;
			margin: 5px 5px 5px 0;
			width: auto;
		}
	');

	$html[] = !empty($description) ? '<div class="note">' . JText::_($description) . '</div>' : '';
} else {
	$html[] = !empty($description) ? JText::_($description) : '';
}

echo $this->app->joomla->isVersion('2.5') ? implode('', $html) . '</li><li>' : '<div class="control-group">' . implode('', $html) . '</div>';