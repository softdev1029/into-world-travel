<?php
/*************************
* @package   ZOO Component
* @file      options.php
* @version   3.1.0 August 2014
* @author    Attavus M.D. http://www.raslab.org
* @copyright Copyright (C) 2011 - 2014 R.A.S.Lab[.org]
* @license   http://opensource.org/licenses/GPL-2.0 GNU/GPLv2 only
****************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// get element from parent parameter form
$element = $parent->element;
$config  = $element->config;
$url     = $this->app->link(array('controller' => 'manager', 'format' => 'raw', 'task' => 'getalias', 'force_safe' => 1), false);

// init vars
$id = uniqid('option-');
$i  = 0;
?>
<div id="<?php echo $id; ?>" class="options">
	<ul>
		<?php
			foreach($config->get('option', array()) as $opt) {
				echo '<li>';
				echo $element->editOption($control_name, $i++, $opt['name'], $opt['value'], isset($opt['image']) ? $opt['image'] : null);
				echo '</li>';
			}
		?>
		<li class="hidden" ><?php echo $element->editOption($control_name, '0', '', '', ''); ?></li>
	</ul>
	<div class="add"><?php echo JText::_('Add Option'); ?></div>
</div>

<script type="text/javascript">
	jQuery('#<?php echo $id; ?>').MyElementSelect({variable: '<?php echo $control_name; ?>', url : '<?php echo $url; ?>'});
</script>
