<?php
defined('JPATH_BASE') or die;

class JFormFieldSubmit extends JFormField
{
	protected $type = 'Submit';

	protected function getInput()
	{
		$html = array();
		$html[] = '<input type="submit" name="'.$this->name.'" value="'.$this->default.'" class="'.$this->class.'">';

		return implode("\n", $html);
	}
}
