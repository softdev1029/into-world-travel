<?php
/*
 Федянин А.
 Webalan.ru
 */
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.modal');
 
$row = $this->item;

echo "<h1>Первый prepare</h1>";
echo '<pre>';
$row->xml = str_Replace('>',">\n", $row->xml);
 
 print_r (htmlspecialchars  ($row->xml));
echo '</pre>';

echo "<h1>Второй prepare</h1>";
echo '<pre>';
$row->xml1 = str_Replace('>',">\n", $row->xml1);
 
 print_r (htmlspecialchars  ($row->xml1));
echo '</pre>';


echo "<h1>Confirm</h1>";
echo '<pre>';
$row->xml2 = str_Replace('>',">\n", $row->xml2);
 
 print_r (htmlspecialchars  ($row->xml2));
echo '</pre>';
$region = travel::region($row->region);
$otel = travel::getOtelVid($row->otel);

    $start = strtotime($row->data_start);
     $end = strtotime($row->data_end);
     $day = xml::time_text($start, $end);
     $data = unserialize($row->data);
 
//ajax
?>
 <!--style-->
<script type="text/javascript">
 
//------------------------Проверка на заполненость формы !------------------
	Joomla.submitbutton = function(task) {
		if (task == 'order.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			 
            
            Joomla.submitform(task, document.getElementById('adminForm'));
	 
	}}
</script>
 
  
  
  
  
<form target="_self" enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_travel&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">

 
	<div class="row-fluid">
		<!-- Begin Content -->
		<div class="span10 form-horizontal">
         
		<fieldset class="adminform">
			<legend>Order data #<?=$row->id?></legend>
		
	     
        
Request number QuoteId: <strong><?=$row->roomid?></strong><br />
Booking number: <strong><?=$row->bronid?></strong><br />
 
Surname: <strong><?=$row->first?> [<?=$row->title?>]</strong><br />
Name: <strong><?=$row->last?></strong><br />
Phone: <strong><?=$row->phone?></strong><br />
E-mail: <strong><?=$row->email?></strong><br />
Date of arrival: <strong><?=date('d.m.Y',$start)?></strong><br />
Number of nights: <strong><?=$day?></strong><br />

 
  Country: <strong><?=$region->country_title?></strong><br />
 City: <strong><?=$region->title?></strong><br />
 Hotel: <strong><?=$otel->title?></strong><br />
 
 rooms: <strong><?=$row->rooms?></strong><br />
 
 Cost:  <div style="background: #c8e8aa;
    padding: 5px;
    display:inline-block;
    border-radius: 8px;
    color: #000;
    border: 1px solid #c5baba;"><?=travel::pr($row->summa, '', false);?></div><br />

<h3>Rooms 1</h3>
  <?php if ($row->mann>1): ?><br />
  The rest of adult guests: <br /> 
   <?php for ($i=1; $i<$row->mann; $i++): ?>
   Surname: <strong><?=$data['mann']['first'][$i]?> [<?=$data['mann']['title'][$i]?>]</strong><br />
   Name: <strong><?=$data['mann']['last'][$i]?></strong><br />
   
   
   <?php endfor; ?>
  <?php endif;?>
   
 <?php if ($row->kind>1): ?><br />
  Children: <br /> 
   <?php for ($i=0; $i<$row->kind; $i++): ?>
   Surname: <strong><?=$data['kind']['first'][$i]?> [<?=$data['kind']['title'][$i]?>]</strong><br />
   Name: <strong><?=$data['kind']['last'][$i]?></strong><br />
   Age: <strong><?= $row->{'age'.($i+1)}?></strong><br />
   
   <?php endfor; ?>
  <?php endif;?>
   <?php if ($row->rooms>1): ?>
  <h3>Rooms 2</h3>
  <?php if ($row->mann_two>0): ?><br />
  The rest of adult guests: <br /> 
   <?php for ($i=0; $i<$row->mann; $i++): ?>
   Surname: <strong><?=$data['mann_two']['first'][$i]?> [<?=$data['mann_two']['title'][$i]?>]</strong><br />
   Name: <strong><?=$data['mann_two']['last'][$i]?></strong><br />
   
   
   <?php endfor; ?>
  <?php endif;?>
   
 <?php if ($row->kind_two>1): ?><br />
  Children: <br /> 
   <?php for ($i=0; $i<$row->kind_two; $i++): ?>
   Surname: <strong><?=$data['kind_two']['first'][$i]?> [<?=$data['kind_two']['title'][$i]?>]</strong><br />
   Name: <strong><?=$data['kind_two']['last'][$i]?></strong><br />
   Age: <strong><?= $row->{'age'.($i+1).'_two'}?></strong><br />
   
   <?php endfor; ?>
  <?php endif;?>
    <?php endif;?>
     <br />
 Comment: <br />
 <em><?=$row->komm?>  </em> 
     <br />
     <hr />
      <?php if ($row->status!='delete'): ?>
     <a class="btn btn-danger" href="<?=JRoute::_('index.php?option=com_travel&task=order.orderotmena&id='.$row->id)?>">Cancel booking</a>
     <?php endif; ?>
     
     <?php if ($row->status==='prepare'): ?>
     <a class="btn btn-success" href="<?=JRoute::_('index.php?option=com_travel&task=order.conf&id='.$row->id)?>">Confirmed reservation</a>
     <?php endif; ?>
    

 
         
 <!--sdos-->

<div class="clr"></div>

 
	   <input type="hidden" name="task" value="" />
		<input type="hidden" name="return" value="<?php echo JRequest::getCmd('return');?>" />
		<?php echo JHtml::_('form.token'); ?>


</div>
</form>
	
