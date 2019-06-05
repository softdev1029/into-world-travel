<?php
/**
* @package   ZOO Component
* @file      editoption.php
* @version   3.0.0 December 2012
* @author    Attavus M.D. http://www.raslab.org
* @copyright Copyright (C) 2011 - 2012 R.A.S.Lab[.org]
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
	
	<div class="name-input">
		<label for="name"><?php echo JText::_('Name'); ?></label>
		<input type="text" name="<?php echo $var.'[option]['.$num.'][name]'; ?>" value="<?php echo $name; ?>" />
	</div>
	<div class="value-input">
		<label for="value"><?php echo JText::_('Value'); ?></label>
		<a class="trigger" href="#" title="<?php echo JText::_('Edit Option Value');?>"><?php echo $value; ?></a>
		<div class="panel">
			<input type="text" name="<?php echo $var.'[option]['.$num.'][value]'; ?>" value="<?php echo $value; ?>" />
			<input type="button" class="accept" value="<?php echo JText::_('Accept'); ?>">
			<a href="#" class="cancel"><?php echo JText::_('Cancel'); ?></a>
		</div>
	</div><p><br/><br/></p>
	<div class="image-input">
		<label for="image"><?php echo JText::_('Image'); ?></label>
		<input type="text" id="new" name="<?php echo $var.'[option]['.$num.'][image]'; ?>" value="<?php echo $image; ?>" class="image-select" size="60" style="width:100px;" title="<?php echo JText::_('Image'); ?>" />
	</div>	
	<div class="delete" title="<?php echo JText::_('Delete option'); ?>">
		<img alt="<?php echo JText::_('Delete option'); ?>" src="<?php echo $this->app->path->url('assets:images/delete.png'); ?>"/>
	</div>
	<div class="sort-handle" title="<?php echo JText::_('Sort option'); ?>">
		<img alt="<?php echo JText::_('Sort option'); ?>" src="<?php echo $this->app->path->url('assets:images/sort.png'); ?>"/>
	</div>