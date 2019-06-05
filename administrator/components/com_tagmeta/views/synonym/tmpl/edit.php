<?php
/**
 * Tag Meta Community component for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package TagMeta
 * @copyright Copyright 2009 - 2017
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link http://www.selfget.com
 * @version 1.9.0
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include the component HTML helpers
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
  Joomla.submitbutton = function(task)
  {
    if (task == 'synonym.cancel' || document.formvalidator.isValid(document.id('synonym-form'))) {
      Joomla.submitform(task, document.getElementById('synonym-form'));
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_tagmeta&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="synonym-form" class="form-validate form-horizontal">
  <div class="row-fluid">
    <!-- Begin Content -->
    <div class="span10 form-horizontal">

      <ul class="nav nav-tabs">
        <li class="active"><a href="#synonym" data-toggle="tab"><?php echo empty($this->item->id) ? JText::_('COM_TAGMETA_SYNONYM_NEW_SYNONYM') : JText::_('COM_TAGMETA_SYNONYM_EDIT_SYNONYM'); ?></a></li>
        <li><a href="#stats" data-toggle="tab"><?php echo JText::_('COM_TAGMETA_SYNONYM_STATS'); ?></a></li>
        <li><a href="#help" data-toggle="tab"><?php echo JText::_('COM_TAGMETA_SYNONYM_QUICK_HELP_LABEL'); ?></a></li>
      </ul>

      <fieldset>
      <div class="tab-content">

        <div class="tab-pane active" id="synonym">
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('keywords'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('keywords'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('synonyms'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('synonyms'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('weight'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('weight'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('comment'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('comment'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('id'); ?></div>
          </div>
        </div>

        <div class="tab-pane" id="stats">
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('hits'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('hits'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('last_visit'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('last_visit'); ?></div>
          </div>
        </div>

        <div class="tab-pane" id="help">
          <?php echo JHtml::_('sliders.start','tagmeta-rule-sliders-'.$this->item->id, array('useCookie'=>1, 'allowAllClose'=>1, 'startOffset'=>-1)); ?>
          <?php echo JHtml::_('sliders.panel',JText::_('COM_TAGMETA_SYNONYM_QUICK_HELP_LABEL'), 'quick-help'); ?>
          <fieldset class="panelform">
            <p><?php echo JText::_('COM_TAGMETA_SYNONYM_QUICK_HELP_DESC'); ?></p>
          </fieldset>
          <?php echo JHtml::_('sliders.end'); ?>
        </div>

      </div>
      </fieldset>

    </div>
    <!-- End Content -->

    <!-- Begin Sidebar -->
    <div class="span2">

      <h4><?php echo JText::_('COM_TAGMETA_SYNONYM_PUBLISHING_OPTIONS');?></h4>
      <hr />
      <fieldset class="form-vertical">
      <div class="control-group">
        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('published'); ?></div>
          <div class="controls"><?php echo $this->form->getInput('published'); ?></div>
        </div>
      </div>
      </fieldset>

    </div>
    <!-- End Sidebar -->
  </div> <!-- row-fluid -->
  <input type="hidden" name="task" value="" />
  <?php echo JHtml::_('form.token'); ?>
</form>
