<?php
/*
 Федянин А.
 Webalan.ru
 */
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.modal');

//ajax
?>
 <!--style-->
<script type="text/javascript">
 
//------------------------Проверка на заполненость формы !------------------
	Joomla.submitbutton = function(task) {
		if (task == 'gr.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			 
            
            Joomla.submitform(task, document.getElementById('adminForm'));
	 
	}}
</script>
 
  
  
  
  
<form target="_self" enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_travel&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">

 
	<div class="row-fluid">
		<!-- Begin Content -->
		<div class="span10 form-horizontal">
         
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('NEW') : JText::sprintf('EDIT_N', $this->item->id); ?></legend>
		
	     
        
         <?php /*if (empty($this->item->id)): ?>
        
       	<div class="row-fluid"> 
  
   <div class="control-group form-inline">
	<label title="">Впишите название. <strong>Каждое название с новой строки</strong>
    
    <span class="star">&nbsp;*</span></label> 
    
     <textarea style="width:400px; height:100px" name="titles"></textarea>
         	</div> 
          </div> 
        	 
        
        
        <?php else: ?>
        
          <div class="control-group">
	 <?php echo $this->form->getLabel('title') ?>
     <?php echo $this->form->getInput('title') ?>
     
        </div> 
	   	 <?php endif; */?>
         
        <div class="row-fluid">
        
        <?php
        
      $formArray = $this->form->getFieldset('form');
           
			foreach ($formArray as $field) {
            //if ($field->id==='jform_title') continue;

				echo '<div class="control-group">'.$field->label . $field->input.'</div>' . "\n";
			}
           
             ?>
	 </div>	
 
      <!--proj-->    
        <div class="clr"></div>
     
		
         
	</fieldset>
</div>
 
 
         
 <!--sdos-->

<div class="clr"></div>

 
	   <input type="hidden" name="task" value="" />
		<input type="hidden" name="return" value="<?php echo JRequest::getCmd('return');?>" />
		<?php echo JHtml::_('form.token'); ?>


</div>
</form>
	
