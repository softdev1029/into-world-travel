<?php
/**
* @package   ZOO
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<div id="<?php echo $this->identifier; ?>" class="select-relateditems">
	<ul>

	<?php foreach ($data as $item) : ?>

		<li>
			<div>
				<div class="item-name"><?php echo $item->name; ?></div>
				<div class="item-sort" title="<?php echo JText::_('Sort Item'); ?>"></div>
				<div class="item-delete" title="<?php echo JText::_('Delete Item'); ?>"></div>
				<input type="hidden" name="<?php echo $this->getControlName('item', true); ?>" value="<?php echo $item->id; ?>"/>
			</div>
		</li>
		<input type="hidden" name="<?php echo $this->getControlName('previous', true); ?>" value="<?php echo $item->id; ?>"/>
		
	<?php endforeach; ?>
	
	</ul>
	<a class="item-add modal" rel="{handler: 'iframe', size: {x: 850, y: 500}}" title="<?php echo JText::_('Add Item'); ?>" href="<?php echo $link; ?>" ><?php echo JText::_('Add Item'); ?></a>
</div>

<script type="text/javascript">
	jQuery(function($) {
		$('#<?php echo $this->identifier; ?>').ElementRelatedItems({ variable: '<?php echo $this->getControlName('item', true); ?>', msgDeleteItem: '<?php echo JText::_('Delete Item'); ?>', msgSortItem: '<?php echo JText::_('Sort Item'); ?>' });
	});
</script>