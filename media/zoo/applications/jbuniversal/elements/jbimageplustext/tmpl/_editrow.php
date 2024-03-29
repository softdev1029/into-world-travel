<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Denis Smetannikov <denis@jbzoo.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


?>
<div>

    <div class="row">
        <?php echo $this->app->html->_('control.text', $this->getControlName('file'), $this->get('file'), 'class="jbimage-select" size="60" style="width:200px;margin-right:5px;" title="' . JText::_('File') . '"'); ?>
    </div>

    <div class="row">
        <strong><?php echo JText::_('Обтекание текста'); ?></strong>
		<?php		
		$state[] = JHTML::_('select.option', 'left', 'Справа');
		$state[] = JHTML::_('select.option', 'right', 'Слева');        
		echo $this->app->html->_('select.radiolist', $state, $this->getControlName('align'), null, 'value', 'text', $this->get('align'));
		?>
    </div>
	
    <div class="more-options">

        <div class="trigger">
            <div>
                <div class="link button"><?php echo JText::_('Link'); ?></div>
                <div class="title button"><?php echo JText::_('Title'); ?></div>
            </div>
        </div>

        <div class="title options">

            <div class="row">
                <?php echo $this->app->html->_('control.text', $this->getControlName('title'), $this->get('title'), 'maxlength="255" title="' . JText::_('Title') . '" placeholder="' . JText::_('Title') . '"'); ?>
            </div>

        </div>

        <div class="link options">

            <div class="row">
                <?php echo $this->app->html->_('control.text', $this->getControlName('link'), $this->get('link'), 'size="60" maxlength="255" title="' . JText::_('Link') . '" placeholder="' . JText::_('Link') . '"'); ?>
            </div>

            <div class="row">
                <strong><?php echo JText::_('New window'); ?></strong>
                <?php echo $this->app->html->_('select.booleanlist', $this->getControlName('target'), $this->get('target'), $this->get('target')); ?>
            </div>

            <div class="row">
                <?php echo $this->app->html->_('control.text', $this->getControlName('rel'), $this->get('rel'), 'size="60" maxlength="255" title="' . JText::_('Rel') . '" placeholder="' . JText::_('Rel') . '"'); ?>
            </div>

        </div>
    </div>
    <div class="textarea">
		<?php
		if ($trusted_mode) {
			echo $this->app->editor->display($this->getControlName('text'), htmlspecialchars($this->get('text'), ENT_QUOTES, 'UTF-8'), null, null, 60, 20, array('pagebreak', 'readmore', 'article'));
		} else {
			echo $this->app->html->_('control.textarea', $this->getControlName('text'), $this->get('text'), 'size="60" maxlength="255" title="' . JText::_('Text') . '" placeholder="' . JText::_('Text') . '"');
		}
		?>
    </div>
</div>
