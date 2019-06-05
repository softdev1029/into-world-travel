<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.form' );
JFormHelper::addFieldPath(JPATH_ROOT . '/administrator/components/com_yandex_maps/models/fields/');
$form = new JForm('name');
?>
<div style="margin-left: 170px;">
	<?php
	$address = JFormHelper::loadFieldType('address', true);
	$address->setForm($form);
	$params = $this->getConfig();
	$address->setup(simplexml_load_string('<field autocomplete="'.$params->get('autocomplete', 1).'" width="'.$params->get('width', 300).'"  height="'.$params->get('height', 300).'"/>'), null);
	$address->name = $this->getControlName('location');
	$address->value = $this->get('location');
	echo $address->getInput();
	if ($params->get('show_iconpicker', 1)) {
	?>
	<div>
		<?php
		$address = JFormHelper::loadFieldType('iconpicker', true);
		$address->setForm($form);
		$params = $this->getConfig();
		$address->setup(simplexml_load_string('<field/>'), null);
		$address->name = $this->getControlName('icon');
		$address->value = $this->get('icon');
		echo $address->getInput();
		?>
	</div>
	<?php } ?>
</div>
<style>
.creation-form .element,.box-bottom ,#adminForm.assign-elements, #adminForm.manager-editelements, #adminForm.item-edit, .creation-form .element > div {
overflow:visible;
}
</style>
