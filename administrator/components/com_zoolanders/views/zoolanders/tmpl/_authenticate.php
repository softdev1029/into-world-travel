<?php
/**
 * @package     ZOOlanders
 * @version     3.3.15
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die;

// retrieve credentials avoiding cache
$table = $this->app->table->get('extensions', '#__');
$table->key = 'extension_id';

$component = $table->get(JComponentHelper::getComponent('com_zoolanders')->id);
$data = $this->app->parameter->create($component->params);

$user = $data->find('zoolanders.username', '');
$pass = $data->find('zoolanders.password', false);
$pass = $pass ? $this->app->zlfw->crypt($pass, 'decrypt') : '';

?>

<form class="uk-form" action="<?php echo $this->component->link(array('controller' => $this->controller, 'task' => 'saveOptions')); ?>" method="post">

	<!-- fields -->
	<div class="uk-form-icon">
		<i class="uk-icon-user"></i>
		<input type="text" name="username" class="uk-form-width-small" value="<?php echo $user; ?>" placeholder="<?php echo JText::_('PLG_ZLFRAMEWORK_USERNAME'); ?>" />
	</div>

	<div class="uk-form-icon">
		<i class="uk-icon-lock"></i>
		<input type="password" name="password" class="uk-form-width-small" value="<?php echo $pass; ?>" placeholder="<?php echo JText::_('PLG_ZLFRAMEWORK_PASSWORD'); ?>" />
	</div>
	
	<!-- submit -->
	<button type="submit" id="zl_options_save" class="uk-button uk-button-small uk-text-right">
		<i class="uk-icon-edit"></i> <?php echo JText::_('PLG_ZLFRAMEWORK_SAVE'); ?>
	</button>

	<!-- clear -->
	<a href="#" id="zl_options_reset" class="uk-button uk-button-small uk-button-danger uk-text-right">
		<i class="uk-icon-eraser"></i> <?php echo JText::_('PLG_ZLFRAMEWORK_RESET'); ?>
	</a>
</form>