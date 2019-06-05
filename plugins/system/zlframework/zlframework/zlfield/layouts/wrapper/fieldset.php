<?php
/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die();
	
	// prepare label
	if($label = $fld->find('specific.toggle.label'))
	{
		$vars = explode('||', $label);
		$text = JText::_($vars[0]);
		unset($vars[0]);

		$label = count($vars) ? $this->app->zlfield->replaceVars($vars, $text) : $text;
	}

?>

	<?php if ($fld->find('specific.toggle')) : ?>

	<fieldset class="wrapper" data-layout="fieldset-toggle" data-id="<?php echo $id ?>">

		<div class="zl-toggle open">
			<div class="btn-close">
				<?php echo $label ?>
				<span class="sign"></span>
			</div>
			<div class="btn-open">
				<?php echo $label ?>
				<span class="sign"></span>
			</div>
		</div>

		<div class="zl-toggle-content">
			<?php echo $content ?>
		</div>

	</fieldset>

	<?php else : ?>

	<fieldset class="wrapper" data-id="<?php echo $id ?>">
		<?php echo $content ?>
	</fieldset>

	<?php endif; ?>