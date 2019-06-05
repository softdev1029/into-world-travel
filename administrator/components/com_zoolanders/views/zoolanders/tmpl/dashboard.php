<?php
/**
 * @package     ZOOlanders
 * @version     3.3.15
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die;

// load assets
$this->app->document->addScript('media:com_zoolanders/js/admin-overlay.js');
$this->app->document->addScript('media:com_zoolanders/js/admin-dashboard.js');

// add page title
JToolbarHelper::title('ZOOlanders::' . JText::_('Dashboard'), '48-zoolanders');

// set toolbar buttons
JToolBar::getInstance('toolbar')->appendButton('Custom', '<div class="zx"><button type="button" class="uk-button uk-button-mini"><i class="uk-icon-gear"></i> '.JText::_('PLG_ZLFRAMEWORK_OPTIONS').'</button></div>', 'options');
JToolBar::getInstance('toolbar')->appendButton('Custom', '<div class="zx"><button type="button" class="uk-button uk-button-mini"><i class="uk-icon-refresh"></i> '.JText::_('PLG_ZLFRAMEWORK_RELOAD').'</button></div>', 'reload');

$warning = $this->app->zlfw->path->checkSystemPaths();
$errors = $this->app->zl->check->getMsg(NULL, true);

if(!empty($warning)){
	$errors = array_merge(array('warning' => $warning), $errors);
}
?>

<div id="zl-dashboard">

<!-- menu -->
<?php echo $this->partial('zlmenu'); ?>

	<!-- Messages, warnings, notices: -->
	<?php if($errors):?>
		<?php echo $this->partial('errors', array('errors' => $errors)); ?>
	<?php endif; ?>

	<!-- dashboard area -->
	<div class="dashboard-pane uk-grid">
		<div class="uk-width-1-1">
			<!-- extra-content: -->
			<div class="extra_content uk-panel uk-panel-box"><?php echo empty($this->data) ? '' : $this->data->extra_content; ?></div>
		</div>
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function($){

			zlux.lang.push({
				'ZL_MSG_CONNECTING': '<?php echo JText::_('PLG_ZLFRAMEWORK_ZL_CONNECTING'); ?>'
			});

			// init scripts
			zlux.zoolandersDashboard($('#zl-dashboard'), {
				autoload: <?php echo (int)$this->autoload; ?>
			});
		});
	</script>

	<!-- Options Modal Content -->
	<div id="zl-modal-options">
		<?php echo $this->partial('authenticate'); ?>
	</div>

</div>