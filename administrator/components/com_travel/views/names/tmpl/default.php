<?php
 
 
 
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
 
JHTML::_('script','system/multiselect.js',false,true);
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_travel.name');
$saveOrder	= 'a.ordering';
$saveOrder	= $listOrder == 'a.ordering';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_travel&task=names.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>
<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
  

<form action="<?php echo JRoute::_('index.php?option=com_travel&view=names'); ?>" method="post" name="adminForm" id="adminForm">
	
    
<div id="j-main-container">
 	<div id="filter-bar" class="btn-toolbar">
    
		 
         <div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible">Поиск по названию</label>
				<input type="text" name="filter_search" placeholder="Поиск по названию" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
			</div>
               
       	<div class="btn-group pull-left hidden-phone">
				<button class="btn tip hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
				<button class="btn tip hasTooltip" type="button" onclick="document.id('filter_search').value='';this.form.submit();" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
			</div> 
         
	 <div class="btn-group pull-right hidden-phone">
			
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived' => 0, 'trash' => 0)), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>
				<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
				<?php echo $this->pagination->getLimitBox(); ?>
		 

		</div>
        
         
	</div>
    
	<div class="clr"> </div>
	<table class="table table-striped" id="articleList">
<thead>
	<tr>
		 <th width="1%" class="hidden-phone">
			   <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
		       </th><th width="1%" nowrap="nowrap">
			<?php echo JHtml::_('grid.sort', 'ID', 'a.id', $listDirn, $listOrder); ?>
		    </th>

     	<th width="1%"  class="nowrap center hidden-phone">
	    <?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
	    </th>
<th width="20%" align="center" style='text-align:center'>
	   <?php echo JHtml::_('grid.sort', 'title', 'a.title', $listDirn, $listOrder); ?>
       </th>
<th width="20%" align="center" style='text-align:center'>
	   <?php echo JHtml::_('grid.sort', 'published', 'a.published', $listDirn, $listOrder); ?>
       </th>
	</tr>
</thead>

<tbody>
<?php foreach ($this->items as $i => $item) {
    
   
    
$ordering	= ($listOrder == 'a.ordering');
$linkEdit	= JRoute::_('index.php?option=com_travel&task=name.edit&id='.$item->id);

$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out==$user->get('id') || $item->checked_out==0;
$canChange	= $user->authorise('core.edit.state',	'com_travel.name'.$item->id);
$canCreate	= $user->authorise('core.create',		'com_travel.name'.$item->id);
?>
<tr class="row<?php echo $i % 2; ?>" sortable-group-id="0">
	
     <td>
		   <?php echo JHtml::_('grid.id', $i, $item->id); ?>
	       </td><td class="center"><?php echo (int) $item->id; ?></td>
<td class="order nowrap center hidden-phone">
					<?php if ($canChange) :
						$disableClassName ='';
						$disabledLabel	  = '';

						if (!$saveOrder) :
							$disabledLabel    = JText::_('JORDERINGDISABLED');
							$disableClassName = 'inactive tip-top';
						endif; ?>
						<span class="sortable-handler hasTooltip <?php echo $disableClassName; ?>" title="<?php echo $disabledLabel; ?>">
							<i class="icon-menu"></i>
						</span>
						<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
					<?php else : ?>
						<span class="sortable-handler inactive" >
							<i class="icon-menu"></i>
						</span>
					<?php endif; ?>
					</td>

        <td><center>
	<?php  
		echo '<a href="'. JRoute::_($linkEdit).'">'. $this->escape($item->title).'</a>';
	  ?></center>
	</td>
 <td class="center"><?php echo JHtml::_('jgrid.published', $item->published, $i, 'names.', $canChange); ?></td>
	 
</tr>
<?php } ?>
</tbody>
			
<tfoot>
	<tr>
		<td colspan="11">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
</table>

<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_travel" />
 
 
 
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>