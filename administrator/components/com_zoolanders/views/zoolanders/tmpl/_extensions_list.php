<?php
/**
 * @package     ZOOlanders
 * @version     3.3.15
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

// group them
$elements = $extensions = $apps = $free = array();
foreach ($all_exts as $ext) {
	if(!empty($ext->hidden)){
		continue;
	}
	if (strlen($ext->price)) {
		$group = strtolower(trim($ext->type)).'s';
		array_push($$group, $ext);
	} else {
		$free[] = $ext;
	}
}

$groups = array();
$groups[] = array('name' => 'free', 'list' => $free);
$groups[] = array('name' => 'elements', 'list' => $elements);
$groups[] = array('name' => 'extensions', 'list' => $extensions);
$groups[] = array('name' => 'apps', 'list' => $apps);

?>
<!-- if no extensions, abort -->
<?php if(empty($all_exts)): ?>
	<div class="uk-text-center uk-margin-large-top">
		<?php echo JText::_('PLG_ZLFRAMEWORK_EXT_EMPTY_LIST'); ?>
	</div>
<?php else : ?>

<!-- extensions -->
<div class="tm-main uk-panel uk-panel-box">
<?php foreach($groups as $group) : sort($group['list']); ?>
	<table class="uk-table uk-table-hover">
		<?php if($group['name'] != 'free') : ?>
			<thead>
			<tr class="uk-text-bold">
				<th colspan="3">
					<?php echo ucfirst($group['name']); ?>
				</th>
			</tr>
			</thead>
		<?php endif; ?>
		<tbody>
		<?php foreach($group['list'] as $key => $ext) : ?>
			<?php
			// skip deprecated not installed extensions
			if (isset($ext->deprecated) && $ext->state == 'uninstalled') continue;

			// prepare ext data
			$data = array('url' => $ext->url, 'state' => $ext->state, 'name' => $ext->name, 'title' => $ext->title);
			?>
			<tr data-ext='<?php echo json_encode($data); ?>'>
				<td>
					<div class="uk-grid">

						<!-- name -->
						<div class="zx-x-name uk-width-2-3 uk-width-medium-4-10 uk-text-truncate">
							<?php
							if($ext->title == 'zlmanager'){
								// naming fix
								echo 'ZL Manager';
							} else {
								echo $ext->title;
							}
							?>

							<!-- deprecated warning -->
							<?php if (isset($ext->deprecated)) : ?>
								<span title="<?php echo JText::_('PLG_ZLFRAMEWORK_EXT_DEPRECATED_NOTICE'); ?>" data-uk-tooltip>
									<i class="uk-icon-warning uk-text-danger"></i>
								</span>
							<?php endif; ?>

						</div>

						<!-- link -->
						<div class="zx-x-link uk-text-center uk-width-1-10 uk-hidden-small">
							<?php if($ext->title == 'ZL Framework') : ?>
								---
							<?php else : ?>
								<a href="<?php echo $ext->link; ?>" target="_blank" title="<?php echo JText::sprintf('PLG_ZLFRAMEWORK_EXT_VISIT_SITE', $ext->title); ?>" data-uk-tooltip>
									<i class="uk-icon-external-link"></i>
								</a>
							<?php endif; ?>
						</div>

						<!-- version -->
						<div class="zx-x-version uk-width-2-6 uk-width-medium-1-10 uk-text-center">
							<?php

							if($ext->state == 'uptodate') {
								$badge = $offline ? ' ' : 'uk-badge-success';
								$title = $offline ? JText::_('PLG_ZLFRAMEWORK_EXT_OFFLINE_WARNING') : JText::sprintf('PLG_ZLFRAMEWORK_EXT_UPTODATE_TIP', $ext->title, $ext->version);
								$content = $ext->version;
							} else if($ext->state == 'outdated') {
								$badge = $offline ? ' ' : 'uk-badge-warning';
								$title = $offline ? JText::_('PLG_ZLFRAMEWORK_EXT_OFFLINE_WARNING') : JText::sprintf('PLG_ZLFRAMEWORK_EXT_OUTDADED_TIP', $ext->title, $ext->version);
								$content = $ext->installed->version;
							} else if($ext->state == 'deprecated') {
								$badge = 'uk-badge-danger';
								$title = JText::sprintf('PLG_ZLFRAMEWORK_EXT_DEPRECATED_TIP', $ext->title, $ext->installed->version, $ext->version);
								$content = $ext->installed->version;
							} else {
								$badge = false;
								$content = '---';
							}

							if($badge)
								echo '<span class="uk-badge uk-badge-notification '.$badge.'" title="'. $title . '" data-uk-tooltip>'.$content.'</span>';
							else
								echo $content;
							?>
						</div>

						<!-- actions -->
						<?php
						// set install/update button state
						if(strlen($ext->url)) {
							if($ext->state == 'uninstalled') {
								$label = 'PLG_ZLFRAMEWORK_INSTALL';
								$icon = 'bolt';
								$title = JText::sprintf('PLG_ZLFRAMEWORK_EXT_INSTALL', $ext->title, $ext->version);
							} else if(($ext->state == 'outdated' || $ext->state == 'deprecated')) {
								$label = 'PLG_ZLFRAMEWORK_UPDATE';
								$icon = 'bolt';
								$title = JText::sprintf('PLG_ZLFRAMEWORK_EXT_UPDATE', $ext->title, $ext->version);
							} else if($ext->state == 'uptodate') {
								$label = 'PLG_ZLFRAMEWORK_REINSTALL';
								$icon = 'retweet';
								$title = JText::sprintf('PLG_ZLFRAMEWORK_EXT_REINSTALL', $ext->title, $ext->version);
							}
						} else {
							$label = 'PLG_ZLFRAMEWORK_EXT_GET';
							$icon = 'shopping-cart';
							$title = JText::sprintf('PLG_ZLFRAMEWORK_EXT_SUBSCRIBE', $ext->title);
						}

						$btn_class = 'uk-button uk-button-mini';
						$label = JText::_($label);
						?>
						<div class="zx-x-actions uk-width-1-1 uk-width-medium-4-10">

							<?php if (!isset($ext->deprecated)) : ?>

								<!-- install/update button -->
								<a href="<?php echo $ext->link; ?>" data-uk-tooltip target="_blank" class="zx-x-install uk-button-primary <?php echo $btn_class; ?>" title="<?php echo $title; ?>" <?php echo ((!$authorized && ($ext->price>0)) ? 'disabled' : ''); ?>>
									<i class="uk-icon-<?php echo $icon; ?>"></i>
								</a>

								<!-- download button -->
								<?php $title = JText::sprintf('PLG_ZLFRAMEWORK_EXT_DOWNLOAD', $ext->title); ?>
								<button type="button" class="zx-x-download uk-hidden-small <?php echo $btn_class; ?>" data-uk-tooltip title="<?php echo $title; ?>" <?php echo ((empty($ext->url) || (!$authorized && ($ext->price>0))) ? 'disabled' : ''); ?>>
									<i class="uk-icon-download"></i>
								</button>

								<!-- language packs button -->
								<?php $title = JText::sprintf('PLG_ZLFRAMEWORK_EXT_TRANSLATIONS', $ext->title); ?>
								<button type="button" class="zx-x-resource-lang-packs <?php echo $btn_class; ?>" data-uk-tooltip title="<?php echo $title; ?>">
									<i class="uk-icon-flag"></i>
								</button>

							<?php endif; ?>

							<!-- status -->
							<?php if($ext->type == 'extension' && $ext->state != 'uninstalled' && $ext->title != 'ZL Framework' && $ext->name != 'zlmanager' && $ext->title != 'ZOOlanders') :

								$state = $ext->installed->enabled;
								$title = JText::_($state ? 'PLG_ZLFRAMEWORK_ENABLED' : 'PLG_ZLFRAMEWORK_DISABLED');
								$title = $this->app->zlfw->html->tooltipText($title, 'PLG_ZLFRAMEWORK_TOGGLE_STATE');
								$class = $state ? 'check' : 'times';
								?>
								<button type="button" class="zx-x-status <?php echo $btn_class; ?>" data-uk-tooltip title="<?php echo $title; ?>">
									<i class="uk-icon-<?php echo $class; ?>"></i>
								</button>
							<?php else : ?>
								<button type="button" class="<?php echo $btn_class; ?>" disabled>
									<i class="uk-icon-ban"></i>
								</button>
							<?php endif; ?>

							<!-- uninstall button - ZL or ZLFW uninstall must be done from joomla manager -->
							<?php if ($ext->title != 'ZOOlanders' && $ext->state != 'uninstalled') :
								$title = JText::sprintf('PLG_ZLFRAMEWORK_EXT_UNINSTALL', $ext->title);
								?>
								<button type="button" class="zx-x-uninstall <?php echo $btn_class; ?>" data-uk-tooltip title="<?php echo $title; ?>">
									<i class="uk-icon-trash-o"></i>
								</button>
							<?php else : ?>
								<button type="button" class="<?php echo $btn_class; ?>" disabled>
									<i class="uk-icon-ban"></i>
								</button>
							<?php endif; ?>

						</div>

					</div>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endforeach; ?>




</div><!-- tm-main -->

	<script type="text/javascript">
		jQuery(document).ready(function($){
			// init checkout script
			zlux.zoolandersExtensions($('#zl-extensions'), {
				autoload: <?php echo (int)!empty($autoload); ?>
			});
		});
	</script>

<?php endif; ?>