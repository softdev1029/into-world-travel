<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.form' );
JFormHelper::addFieldPath(JPATH_ROOT . '/administrator/components/com_yandex_maps/models/fields/');
$address = JFormHelper::loadFieldType('maps', true);
$address->setForm(new JForm('name'));
$address->setup(simplexml_load_string('<field/>'), null);
$address->name = $control_name.'['.$name.']';
$address->value = $value;

echo $address->renderField();
