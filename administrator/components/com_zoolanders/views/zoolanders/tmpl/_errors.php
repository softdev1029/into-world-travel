<?php
/**
 * @package     ZOOlanders
 * @version     3.3.15
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die;

?>
<?php if(!empty($errors)): ?>
	<?php foreach ($errors as $type => $errorlist): ?>
		<?php if(!empty($errorlist)): ?>
			<?php $errorlist = is_array($errorlist) ? $errorlist : array ($errorlist) ?>
			<?php foreach ($errorlist as $error): ?>
				<?php if($type !== 'hidden'): ?>
					<div class="uk-alert uk-alert-<?php echo ($type == 'warning') ? 'warning' : 'danger'; ?>"
					     data-uk-alert>
						<p><span class="uk-icon-exclamation-triangle"></span> <?php echo $error; ?></p>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
 