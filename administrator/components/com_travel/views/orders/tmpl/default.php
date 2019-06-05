<?php
JHtml::_('formbehavior.chosen', 'select');
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
 
JHTML::_('script','system/multiselect.js',false,true);
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_travel.order');
$saveOrder	= 'a.ordering';
$saveOrder	= $listOrder == 'a.ordering';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_travel&task=orders.saveOrderAjax&tmpl=component';
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
   <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
   <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" type="text/css" />
  
<form action="<?php echo JRoute::_('index.php?option=com_travel&view=orders'); ?>" method="post" name="adminForm" id="adminForm">
	
    
<div id="j-main-container">
 	<div id="filter-bar" class="btn-toolbar">
    
		 
         <div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible">Search by name, surname, phone, E-mail</label>
				<input type="text" name="filter_search" placeholder="Search by name, surname, phone, E-mail" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
			</div>
               
       	<div class="btn-group pull-left hidden-phone">
				<button class="btn tip hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
				<button class="btn tip hasTooltip" type="button" onclick="document.id('input_otel').value='';document.id('filter_otel').value=''; document.id('input_region').value=''; document.id('filter_region').value='';  document.id('filter_search').value='';this.form.submit();" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
			</div> 
         
	 <div class="btn-group pull-right hidden-phone">
		 
        	<input type="text" name="filter_region" placeholder="Region" id="filter_region" value="<?php echo $this->escape($this->state->get('filter.region')); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
		   	<input type="hidden" name="filter_regionid" id="input_region" value="<?php echo $this->escape($this->state->get('filter.regionid')); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
		   
           
            <input type="text" name="filter_otel" placeholder="Hotel" id="filter_otel" value="<?php echo $this->escape($this->state->get('filter.otel')); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
		  <input type="hidden" name="filter_otelid" id="input_otel" value="<?php echo $this->escape($this->state->get('filter.otelid')); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
		   
         <div style="clear: both;"></div>
         	
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
	   <?php echo JHtml::_('grid.sort', 'QuoteId', 'a.roomid', $listDirn, $listOrder); ?>
       </th>      
   <th width="20%" align="center" style='text-align:center'>
	   <?php echo JHtml::_('grid.sort', 'BookingID', 'a.bronid', $listDirn, $listOrder); ?>
       </th>      
    <th width="20%" align="center" style='text-align:center'>
	   <?php echo JHtml::_('grid.sort', 'Status', 'a.status', $listDirn, $listOrder); ?>
       </th>    
       
         <th width="20%" align="center" style='text-align:center'>
	  Canxfee 
       </th>  
             
        <th width="20%" align="center" style='text-align:center'>
	  Информация 
       </th>        
              
    <th width="20%" align="center" style='text-align:center'>
	   <?php echo JHtml::_('grid.sort', 'Surname', 'a.first', $listDirn, $listOrder); ?>
       </th>    
<th width="20%" align="center" style='text-align:center'>
	   <?php echo JHtml::_('grid.sort', 'Name', 'a.last', $listDirn, $listOrder); ?>
       </th>

<th width="20%" align="center" style='text-align:center'>
	   <?php echo JHtml::_('grid.sort', 'Phone', 'a.phone', $listDirn, $listOrder); ?>
       </th>

<th width="20%" align="center" style='text-align:center'>
	   <?php echo JHtml::_('grid.sort', 'email', 'a.email', $listDirn, $listOrder); ?>
       </th>
	</tr>
</thead>

<tbody>
<?php foreach ($this->items as $i => $item) {
    
   $Booking_xml = simplexml_load_string($item->xml);
     $HotelBooking =$Booking_xml->Booking->HotelBooking; 
$ordering	= ($listOrder == 'a.ordering');
$linkEdit	= JRoute::_('index.php?option=com_travel&task=order.edit&id='.$item->id);

$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out==$user->get('id') || $item->checked_out==0;
$canChange	= $user->authorise('core.edit.state',	'com_travel.order'.$item->id);
$canCreate	= $user->authorise('core.create',		'com_travel.order'.$item->id);

     $start = strtotime($item->data_start);
     $end = strtotime($item->data_end);
     $day = xml::time_text($start, $end);
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
		echo '<a href="'. JRoute::_($linkEdit).'">'. $this->escape($item->roomid).'</a>';
	  
   
      ?></center>
	</td>
 <td><center>
	<?php  
		echo '<a href="'. JRoute::_($linkEdit).'">'. $this->escape($item->bronid).'</a>';
	  ?></center>
	</td>
        <td><center>
        <div style="background: #c8e8aa;
    padding: 5px;
    display:inline-block;
    border-radius: 8px;
    color: #000;
    border: 1px solid #c5baba;">
	<?php  
		echo '<a style=" color: #000;" href="'. JRoute::_($linkEdit).'">'. $this->escape($item->status).'</a>';
	  ?></div></center>
	</td>
    <td>
    <?php
       echo travel::pr($HotelBooking->Room->CanxFees->Fee->Amount['amt']);
      
    ?>
    </td>
     <td> 
     
   Date of arrival: <strong><?=date('d.m.Y',$start)?></strong><br />
   Number of nights: <strong><?=$day?></strong><br />
   Country: <strong><?=$item->country_title?></strong><br />
 City: <strong><?=$item->region_title?></strong><br />
 Hotel: <strong><?=$item->otel_title?></strong><br />
 Cost:  <div style="background: #c8e8aa;
    padding: 5px;
    display:inline-block;
    border-radius: 8px;
    color: #000;
    border: 1px solid #c5baba;"><?=travel::pr($item->summa, '', false);?></div><br />

	 
	</td>
    
     <td><center>
	<?php  
		echo '<a href="'. JRoute::_($linkEdit).'">'. $this->escape($item->first).'</a>';
	  ?></center>
	</td>
     <td><center>
	<?php  
		echo '<a href="'. JRoute::_($linkEdit).'">'. $this->escape($item->last).'</a>';
	  ?></center>
	</td>
    
    
 <td><center>
	<?php  
		echo '<a href="'. JRoute::_($linkEdit).'">'. $this->escape($item->phone).'</a>';
	  ?></center>
	</td>

       
        <td><center>
	<?php  
		echo '<a href="'. JRoute::_($linkEdit).'">'. $this->escape($item->email).'</a>';
	  ?></center>
	</td>
	 
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



<script>
jQuery(document).ready(function(){
 var region_select = <?=(int)$this->escape($this->state->get('filter.regionid'))?>;
 var region_to = 1;


 jQuery( "#filter_region" ).autocomplete({
      source: function( request, response ) {
        jQuery.ajax({
          url: "<?=JURI::root()?>index.php?option=com_travel&task=html&type=region&function=search_otels_or_region",
         
          data: {
            maxRows: 8,
            q: request.term
          },
          cache: true,
           
          success: function(data){
            
              region_to  = 1;
                response(jQuery.map(data, function(item){
                
                    return {
                        label: item.title, 
                        value: item.value,
                        otel: item.otel,
                        region: item.region,
                        id: item.id,
                    }
                }));
            } 
          
        });
      },
      minLength: 1,
      select: function( event, ui ) {
        
        jQuery( "#input_region" ).val(0);
         
        region_select = ui.item.id;
        
        jQuery( "#input_region" ).val(ui.item.id);
        
        
        //log( ui.item ?
          //"Selected: " + ui.item.label :
          //"Nothing selected, input was " + this.value);
      },
       
  
      open: function() {
        jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    })
     .autocomplete( "instance" )._renderItem = function( ul, item ) {
      
      
      
      if (item.region==region_to)
      {
        region_to = 2;
        var b =    jQuery( "<li>" )
        .append( "<span class='travel_title_ul'>Регионы</span>")
        .appendTo( ul );
      }
     
      
      
      var a = jQuery( "<li>" )
        .append( "<span class='travel_item_ul'>" + item.label + "</span>")
        .appendTo( ul );
        
        
        return a;
    };
 jQuery( "#filter_otel" ).autocomplete({
      source: function( request, response ) {
        jQuery.ajax({
          url:  "<?=JURI::root()?>index.php?option=com_travel&task=html&type=otel&function=search_otels_or_region&region="+region_select,
         
          data: {
            maxRows: 8,
            q: request.term
          },
          cache: true,
           
          success: function(data){
            
              region_to  = 1;
                response(jQuery.map(data, function(item){
                
                    return {
                        label: item.title, 
                        value: item.value,
                        otel: item.otel,
                        name_region:item.name_region,
                        region: item.region,
                        id: item.id,
                    }
                }));
            } 
          
        });
      },
      minLength: 1,
      select: function( event, ui ) {
        
    
        
         jQuery( "#input_otel" ).val(0);
         jQuery( "#input_otel" ).val(ui.item.id);  
        
        //log( ui.item ?
          //"Selected: " + ui.item.label :
          //"Nothing selected, input was " + this.value);
      },
       
  
      open: function() {
        jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    })
     .autocomplete( "instance" )._renderItem = function( ul, item ) {
      
      
      
      
    if(region_to==1)
      {
         region_to =-1; 
      var b =    jQuery( "<li><hr>" )
        .append( "<span class='travel_title_ul'>Отели</span>")
        .appendTo( ul );
      }
      
      
      var a = jQuery( "<li>" )
        .append( "<span class='travel_item_ul'>" + item.label + ", <em>"+item.name_region+"</em></span>")
        .appendTo( ul );
        
        
        return a;
    };
 
});
</script>