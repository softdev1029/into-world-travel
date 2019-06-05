<?php
defined('_JEXEC') or die('Restricted access');

$add_edit_text = !empty($this->element['id']) ? JText::_('JGLOBAL_EDIT_ITEM') : JText::_('JTOOLBAR_NEW');

JRequest::setVar( 'hidemainmenu', 1 );

JToolBarHelper::title(  JText::_('dacatalog').' :: '.mb_strtolower(JText::_(JRequest::getVar( 'view' )), 'utf-8').' :: '.mb_strtolower($add_edit_text, 'utf-8') );

JToolBarHelper::apply($this->controller.'.save');
JToolBarHelper::save2new($this->controller.'.save_new');
JToolBarHelper::save($this->controller.'.save_exit');
JToolBarHelper::save2copy($this->controller.'.save2copy');
JToolBarHelper::cancel('cancel');
?>
<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

	<fieldset class="adminform">

		<legend><?php echo $add_edit_text; ?></legend>

		<div class="form-horizontal">
			<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'params', JText::_('params')); ?>
			<?php echo $this->form->renderFieldset('params'); ?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<?php echo JHtml::_('bootstrap.endTabSet'); ?>
		</div>

	</fieldset>

	<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' ); ?>" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar( 'view' ); ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>

</form>