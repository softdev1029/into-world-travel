 <!---crm modal-->
     <div id="layer-create-dom"  class="white-popup mfp-hide">
 <!--div id="info_message" class="modal fade new_modal"-->
  <div class="modal-dialog ">
   
    <div class="modal-content modal-sm2">
     <div class="modal-body">
      <div class="modal-top-header">     
      <span class="header_title_modal">	
      Available hotels in <?=$this->region->title?> on 
      <?=date('F j, Y',$this->start)?> – <?=date('F j, Y',$this->end)?>  
      
      <!-- <?=($this->month_start[0]==$this->month_end[0]) ? $this->month_start[0] : $this->month_start[0].", ".$this->month_end[0]?> -->
      </span> 
      
      </div>
     
     
      <div id="modal_info_cart">
      
  
  <!-----------------------  ------------------------>
  <div class="jbzoo jbfilter-wrapper">
<form id="travel_search" name="travel_search" 
method="get" action="index.php" class="jsFilter jbfilter jbfilter-default">



<div class="jbfilter-row jbfilter-auto">
<label class="jbfilter-label" for="region">City</label>
<div class="jbfilter-element">
<input type="text" name="e[title]" value="<?=$this->region->title?>" id="region"
 class="jbfilter-element-itemname jbfilter-element-tmpl-auto"
  maxlength="255" size="60" placeholder="Any city" />
  
  <input type="hidden"  name="e[region]" value="<?=$data['region']?>" id="input_region"/>
  
  </div><i class="clr"></i>
  </div>
  
  <div class="jbfilter-row jbfilter-auto first">
<label class="jbfilter-label" for="otels_or_region">Hotel</label>
<div class="jbfilter-element">

<?php if ($data['otel']):
$otel = travel::getOtelVid($data['otel']);

$data['title2'] =  $otel->title;
 endif; ?>

<input type="text" name="e[title2]" value="<?=$data['title2']?>" id="otels"
 class="jbfilter-element-itemname jbfilter-element-tmpl-auto"
  maxlength="255" size="60" placeholder="Any hotel" />
  
 
  <input type="hidden"  name="e[otel]" value="<?=$data['otel']?>" id="input_otel"/>
  </div><i class="clr"></i>
  </div>
  
   <!----------------------- nacional ------------------------>
 <div class="jbfilter-row jbfilter-date-nacionaly"  >
  <label class="jbfilter-label" for="otels_or_r2">Nationality</label>
	<select id="nac" name="e[nac]" class="inputbox"  >
	 <?php echo JHtml::_('select.options',  travel::getNacional(), 'value', 'text', $data['nac'], true);?>
   </select>
 
 </div>
 
  <div class="jbfilter-row jbfilter-date-nacionaly"  >
  <label class="jbfilter-label" for="otels_or_r2">Rooms</label>
	<select id="nacr" name="e[rooms]" class="inputbox"  >
	 <?php echo JHtml::_('select.options',  travel::getRooms(), 'value', 'text', $data['rooms'], true);?>
   </select>
 
 </div>
 
 
<div style="    margin-top: 12px;" class="jbfilter-row jbfilter-date-range last">
<label class="jbfilter-label" for="data_start-1">Journey period</label><div class="jbfilter-element">

<label for="jdata_start">From</label>
<input style="width:100px" type="text" name="e[data_start]" value="<?=$data['data_start']?>" id="data_start" class="jbfilter-element-date jbfilter-element-tmpl-date-range element-datepicker" />
<label for="jdata_end">Until</label>
<input style="width:100px" type="text" name="e[data_end]" value="<?=$data['data_end']?>" id="data_end" class="jbfilter-element-date jbfilter-element-tmpl-date-range element-datepicker" /></div><i class="clr"></i>
</div>

 <div class="jbfilter-row jbfilter-kol jbfilter-select-chosen">
<label class="jbfilter-label" for="jbfilter-id-itemname">Number of people</label>
 


 <?php 
 
 html::getPersona_modif("", $data)?>
 <i class="clr"></i>
 <?php html::getPersona_modif("_two", $data)?>
  
  
  </div>

 <div class="jbfilter-row jbfilter-buttons">

<input type="submit" name="send-form" value="Search" class="jsSubmit jbbutton" />
 <i class="clr"></i></div>
 
 
<input type="hidden" name="option" value="com_travel" />
<input type="hidden" name="task" id="task" value="filter" />
   </form>
</div>
  <!-----------------------  ------------------------>    
      </div>
       </div>
    </div>
    
  </div>
</div><!--info_message-->

    <!---->

<script> 
  jQuery(document).ready(function(){   
  jQuery("#data_start").datepicker({
      dateFormat: "dd-M-yy",
      minDate: 0,
      onSelect: function () {
          var dt2 = jQuery('#data_end');
          var startDate = jQuery(this).datepicker('getDate');
          var minDate = jQuery(this).datepicker('getDate');
          var dt2Date = dt2.datepicker('getDate');
          //difference in days. 86400 seconds in day, 1000 ms in second
          var dateDiff = (dt2Date - minDate)/(86400 * 1000);
          
          startDate.setDate(startDate.getDate() + 30);
          if (dt2Date == null || dateDiff < 0) {
              dt2.datepicker('setDate', minDate);
          }
          //sets dt2 maxDate to the last day of 30 days window
          //dt2.datepicker('option', 'maxDate', startDate);
          dt2.datepicker('option', 'minDate', minDate);
      }
  });

  jQuery('#data_end').datepicker({
      dateFormat: "dd-M-yy",
      minDate: 0
  });
  });    
</script>