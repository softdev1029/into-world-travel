<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
 $time = time();
 
 
//$format_d = 'd-M-Y';
$format_d = 'M-d-Y';

$den1 = date('Y-m-d',$time);
//$den1 = mktime(0,0,0,date('m',$time),date('d',$time)+1, date('Y',$time) );
$den1 = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
//$den1 = date($format_d,$den1);
$den1 = date('M-d-Y') ;
//$den2 = mktime(0,0,0,date('m',$time),date('d',$time)+2, date('Y',$time) );
$den2 = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
 $den2 = date($format_d,$den2);

$def = 'GB';
?>
  
<style>
.jbfilter-date-nacionaly {
    width:139px;
}
.jbfilter-date-nacionaly .chzn-container-single {
    width:100%!important;
}
</style>


<!--noindex-->
<div class="jbzoo jbfilter-wrapper">
<form id="travel_search" style="    flex-flow: row wrap;" name="travel_search" 
method="get" action="<?=travel::link('travel')?>" class="jsFilter jbfilter jbfilter-default">



<div class="jbfilter-row jbfilter-auto">
<label class="jbfilter-label" for="region">City </label>
<div class="jbfilter-element">
<input type="text" name="e[title]" value="" id="region"
 class="jbfilter-element-itemname jbfilter-element-tmpl-auto"
  maxlength="255" size="60" placeholder="Any city" />
  
  <input type="hidden"  name="e[region]" id="input_region"/>
  
  </div><i class="clr"></i>
  </div>
  
  <!--<div class="jbfilter-row jbfilter-auto first">
<label class="jbfilter-label" for="otels_or_region">Hotel</label>
<div class="jbfilter-element">
<input type="text" name="e[title2]" value="" id="otels"
 class="jbfilter-element-itemname jbfilter-element-tmpl-auto"
  maxlength="255" size="60" placeholder="Any hotel" />
  
 
  <input type="hidden"  name="e[otel]" id="input_otel"/>
  </div><i class="clr"></i>
  </div>-->
  
  
  <!----------------------- nacional ------------------------>
 <div class="jbfilter-row jbfilter-date-nacionaly"  >
  <label class="jbfilter-label" for="otels_or_r2">Nationality</label>
	<select  name="e[nac]" class="inputbox"  >
	 <?php echo JHtml::_('select.options',  travel::getNacional(), 'value', 'text', $def, true);?>
   </select>
 
 </div>
 <div class="jbfilter-row jbfilter-date-nacionaly"  >
  <label class="jbfilter-label" for="otels_or_r2">Rooms</label>
	<select id="rooms_d"  name="e[rooms]" class="inputbox"  >
	 <?php echo JHtml::_('select.options',  travel::getRooms(), 'value', 'text', $def, 1);?>
   </select>
 
 </div>
 
<div style="width:300px" class="jbfilter-row jbfilter-date-range last">
<label class="jbfilter-label" for="data_start-1">Check-in &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;check-out</label><div class="jbfilter-element">

<label for="jdata_start">From</label>
<input style="width:100px" type="text" name="e[data_start]" value="<?=$den1?>" id="data_start" class="jbfilter-element-date jbfilter-element-tmpl-date-range element-datepicker" />
<label for="jdata_end">Until</label>
<input  style="width:100px" type="text" name="e[data_end]" value="<?=$den2?>" id="data_end" class="jbfilter-element-date jbfilter-element-tmpl-date-range element-datepicker" /></div><i class="clr"></i>
</div>

 <div style="width:170px" class="jbfilter-row jbfilter-kol jbfilter-select-chosen jbfilter-auto">
 <label class="jbfilter-label" for="jbfilter-id-itemname">Number of people</label>
 <?php html::get_Persona(); ?>
 <i class="clr"></i>
 <?php html::get_Persona('_two'); ?>
 <i class="clr"></i>
  </div>
  
 
 <div class="jbfilter-row jbfilter-buttons">

<input type="submit" name="send-form" value="Search" class="jsSubmit jbbutton" />
 <i class="clr"></i></div>
 
 
<input type="hidden" name="option" value="com_travel" />
<input type="hidden" name="task" value="filter" />
   </form>
   
   
</div>
<!--/noindex-->
 
 
 
 <script src="//code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script> 
<script>
 
 jQuery(document).ready(function(){
	 
	 
	 
	
 //var formatdata = 'd-M-yy';
 var formatdata = 'M-d-yy'; 
 
 function selectro_person()
 {
  
    jQuery('#selectro_person_two').hide();
  var d = jQuery('#rooms_d').val();
  if (d==2)
     jQuery('#selectro_person_two').show();
    
 }
 selectro_person();
 
 jQuery( "#rooms_d" ).change(function() {
   selectro_person(); 
 });
 
 jQuery(document).on('click', '.jsSubmit', function () { 
 var obj = jQuery(this);
  var region = jQuery('#input_region').val();

 if (!region){
 alert('Select region to search');
 return false;
 }
 else{
  obj.val('Wait...'); 
  jQuery("#progressbar-div").css("display", "block");   
 }
 
 });
 
  
    jQuery(document).on('click', '.selector_gast .zen-guestsbutton-button', function () { 
   var obj = jQuery(this);
   var par = obj.parent();
   obj.toggleClass('zen-guestsbutton-button-active');
  
  if (obj.hasClass('zen-guestsbutton-button-active'))
 {
  par.find('.zen-guestsbutton-popup').show();
   par.find(".zen-select-native").chosen("destroy");
   par.find(".zen-select-native").chosen({}, 0);
   
 }
  else {
   par.find('.zen-guestsbutton-popup').hide();
  }
  return false;
  });
  
    jQuery('.zen-guests-ages').hide();
  
    jQuery('#mann, #kind').change(function(){
   
    var total = 0;
    total = (jQuery('#mann').val()*1) +total;
    total = (jQuery('#kind').val()*1) +total;
    
      jQuery('.zen-guests-age').hide();
    
    
   jQuery('.zen-guestsbutton-button-guests').html(total+' guest');
    var ob = jQuery('#kind').val()*1;
    //Если дети
  if (ob > 0) {
      jQuery('.zen-guests-ages').show();
      jQuery(".zen-select-native").chosen("destroy");
      jQuery(".zen-select-native").chosen({}, 0);
  
  var n = 0;    
  jQuery( ".zen-guests-age" ).each(function( index ) {
    n++;
    if (n<=ob){
  jQuery(this).show();
   jQuery(".zen-select-native").chosen("destroy");
      jQuery(".zen-select-native").chosen({}, 0);
  }
  else   jQuery(this).hide();
   });
      
 
    }
    else{
        
    jQuery('.zen-guests-ages').hide();
      }
  
   
   
      }); //jQuery('#mann, #kind').change(function(){
  
  
   jQuery('#mann_two, #kind_two').change(function(){
   
    var total = 0;
    total = (jQuery('#mann_two').val()*1) +total;
    total = (jQuery('#kind_two').val()*1) +total;
    
      jQuery('.zen-guests-age_two').hide();
    
    
   jQuery('.zen-guestsbutton-button-guests_two').html(total+' guest');
    var ob = jQuery('#kind_two').val()*1;
    //Если дети
  if (ob > 0) {
      jQuery('.zen-guests-ages_two').show();
      jQuery(".zen-select-native").chosen("destroy");
      jQuery(".zen-select-native").chosen({}, 0);
  
  var n = 0;     
  jQuery( ".zen-guests-age_two" ).each(function( index ) {
    n++;
    if (n<=ob){
  jQuery(this).show();
   jQuery(".zen-select-native").chosen("destroy");
      jQuery(".zen-select-native").chosen({}, 0);
  }
  else   jQuery(this).hide();
   });
      
 
    }
    else{
        
    jQuery('.zen-guests-ages').hide();
      }
  
   
   
      }); //jQuery('#mann, #kind').change(function(){
  
  
  
  jQuery(".zen-select-native").chosen({}, 0);
  jQuery("#select_kind").chosen({}, 0);
  
 /* jQuery("#data_start").datepicker({"dateFormat":formatdata,"timeFormat":"hh:mm:ss"}); */
 
   jQuery("#data_end").datepicker({ minDate: 0,"dateFormat":formatdata,"timeFormat":"hh:mm:ss" });
  
  jQuery("#data_start").datepicker({
	  minDate: 0  ,
	  "dateFormat":formatdata,"timeFormat":"hh:mm:ss",
  onSelect: function(dateText) {
     
     var newDate = jQuery(this).datepicker('getDate');
       if (newDate) { // Not null
             //  newDate.setDate(newDate.getDate() + 1);
               newDate.setDate(newDate.getDate() + 0);
       }
	   //jQuery("#data_end").datepicker({"dateFormat":formatdata,"timeFormat":"hh:mm:ss"}); 
	   jQuery('#data_end').datepicker('setDate', newDate);
	  // jQuery('#data_end').datepicker('dateFormat', formatdata);
       // jQuery('#data_end').datepicker('minDate', newDate); 
       jQuery("#data_end").datepicker("option", "minDate", newDate); 	  
	  
     
  },
  
});
   
  
 
 
 PATH = "<?php echo JURI::root()?>";
 var region_to = 1;
 
 var region_select = 0;
 
 
 
 jQuery( "#otels" ).autocomplete({
      source: function( request, response ) {
        jQuery.ajax({
          url: PATH+"index.php?option=com_travel&task=html&type=otel&function=search_otels_or_region&region="+region_select,
         
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
        .append( "<span class='travel_title_ul'>Hotels</span>")
        .appendTo( ul );
      }
      
      
      var a = jQuery( "<li>" )
        .append( "<span class='travel_item_ul'>" + item.label + "</span>")
        .appendTo( ul );
        
        
        return a;
    };
 
 jQuery( "#region" ).autocomplete({
      source: function( request, response ) {
        jQuery.ajax({
          url: PATH+"index.php?option=com_travel&task=html&type=region&function=search_otels_or_region",
         
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
        .append( "<span class='travel_title_ul'>Cities</span>")
        .appendTo( ul );
      }
     
      
      
      var a = jQuery( "<li>" )
        .append( "<span class='travel_item_ul'>" + item.label + "</span>")
        .appendTo( ul );
        
        
        return a;
    };
 
 
 
 jQuery( "#otels_or_region" ).autocomplete({
      source: function( request, response ) {
        jQuery.ajax({
          url: PATH+"index.php?option=com_travel&task=html&function=search_otels_or_region",
         
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
        jQuery( "#input_otel" ).val(0);
        
        if (ui.item.region==1){
        jQuery( "#input_region" ).val(ui.item.id);
        
        }
        else
        {
          jQuery( "#input_otel" ).val(ui.item.id);  
        }
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
        .append( "<span class='travel_title_ul'>Cities</span>")
        .appendTo( ul );
      }
      else if(item.otel==region_to)
      {
         region_to =-1; 
      var b =    jQuery( "<li><hr>" )
        .append( "<span class='travel_title_ul'>Hotels</span>")
        .appendTo( ul );
      }
      
      
      var a = jQuery( "<li>" )
        .append( "<span class='travel_item_ul'>" + item.label + "</span>")
        .appendTo( ul );
        
        
        return a;
    };
 });
</script>

<style>
		
 
        

        #page-wrap { width: 490px; margin: 80px auto; }

        
		
		
        footer p{line-height: 2}
        header a,footer a{color: #fff;}

        pre {
            background: black;
            text-align: left;
            padding: 20px;
            margin: 0 auto 30px auto;
        }
.meter {
    height: 20px;  /* Can be anything */
    position: relative;
    margin: 60px 0 20px 0; /* Just for demo spacing */
    background: #555;
    -moz-border-radius: 25px;
    -webkit-border-radius: 25px;
    border-radius: 25px;
    
    -webkit-box-shadow: inset 0 -1px 1px rgba(255,255,255,0.3);
    -moz-box-shadow   : inset 0 -1px 1px rgba(255,255,255,0.3);
    box-shadow        : inset 0 -1px 1px rgba(255,255,255,0.3);
}
.meter > span {
    display: block;
    height: 100%;
       -webkit-border-top-right-radius: 8px;
    -webkit-border-bottom-right-radius: 8px;
           -moz-border-radius-topright: 8px;
        -moz-border-radius-bottomright: 8px;
               border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        -webkit-border-top-left-radius: 20px;
     -webkit-border-bottom-left-radius: 20px;
            -moz-border-radius-topleft: 20px;
         -moz-border-radius-bottomleft: 20px;
                border-top-left-radius: 20px;
             border-bottom-left-radius: 20px;
    background-color: rgb(200,171,111);
    background-image: -webkit-gradient(
      linear,
      left bottom,
      left top,
      color-stop(0, rgb(200,171,111)),
      color-stop(1, rgb(200,171,111) )
     );
    background-image: -moz-linear-gradient(
      center bottom,
      rgb(200,171,111) 37%,
      rgb(84,240,84) 69%
     );
    -webkit-box-shadow:
      inset 0 2px 9px  rgba(255,255,255,0.3),
      inset 0 -2px 6px rgba(0,0,0,0.4);
    -moz-box-shadow:
      inset 0 2px 9px  rgba(255,255,255,0.3),
      inset 0 -2px 6px rgba(0,0,0,0.4);
    box-shadow:
      inset 0 2px 9px  rgba(255,255,255,0.3),
      inset 0 -2px 6px rgba(0,0,0,0.4);
    position: relative;
    overflow: hidden;
}
.meter > span:after, .animate > span > span {
    content: "";
    position: absolute;
    top: 0; left: 0; bottom: 0; right: 0;
    background-image:
       -webkit-gradient(linear, 0 0, 100% 100%,
          color-stop(.25, rgba(255, 255, 255, .2)),
          color-stop(.25, transparent), color-stop(.5, transparent),
          color-stop(.5, rgba(255, 255, 255, .2)),
          color-stop(.75, rgba(255, 255, 255, .2)),
          color-stop(.75, transparent), to(transparent)
       );
    background-image:
        -moz-linear-gradient(
          -45deg,
          rgba(255, 255, 255, .2) 25%,
          transparent 25%,
          transparent 50%,
          rgba(255, 255, 255, .2) 50%,
          rgba(255, 255, 255, .2) 75%,
          transparent 75%,
          transparent
       );
    z-index: 1;
    -webkit-background-size: 50px 50px;
    -moz-background-size: 50px 50px;
    background-size: 50px 50px;
    -webkit-animation: move 2s linear infinite;
    -moz-animation: move 2s linear infinite;
       -webkit-border-top-right-radius: 8px;
    -webkit-border-bottom-right-radius: 8px;
           -moz-border-radius-topright: 8px;
        -moz-border-radius-bottomright: 8px;
               border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        -webkit-border-top-left-radius: 20px;
     -webkit-border-bottom-left-radius: 20px;
            -moz-border-radius-topleft: 20px;
         -moz-border-radius-bottomleft: 20px;
                border-top-left-radius: 20px;
             border-bottom-left-radius: 20px;
    overflow: hidden;
}

.animate > span:after {
    display: none;
}

@-webkit-keyframes move {
    0% {
       background-position: 0 0;
    }
    100% {
       background-position: 50px 50px;
    }
}

@-moz-keyframes move {
    0% {
       background-position: 0 0;
    }
    100% {
       background-position: 50px 50px;
    }
}


.orange > span {
    background-color: #f1a165;
    background-image: -moz-linear-gradient(top, #f1a165, #f36d0a);
    background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0, #f1a165),color-stop(1, #f36d0a));
    background-image: -webkit-linear-gradient(#f1a165, #f36d0a);
}

.red > span {
    background-color: #f0a3a3;
    background-image: -moz-linear-gradient(top, #f0a3a3, #f42323);
    background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0, #f0a3a3),color-stop(1, #f42323));
    background-image: -webkit-linear-gradient(#f0a3a3, #f42323);
}

.nostripes > span > span, .nostripes > span:after {
    -webkit-animation: none;
    -moz-animation: none;
    background-image: none;
}
.label-processer {
	display: table;
    margin: auto;
    color: gray;
}
#progressbar-div { display:none; width:50%; margin:0 auto; }	
		</style> 
 
 <div class="loader-block" style="display: none;">
		<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>


     <div id="progressbar-div">
	 <div class="meter">
			<span style="width: 100%;"></span>
	 </div>
	  
	  <div class="label-processer">
       <label id="lblprogressText" class="tdheadMain LineHeight">Our system is checking multiple sources.<br>The results will appear within a few seconds.</label>
      </div>
	  
	</div>

<script>
		jQuery(document).ready(function()
		{  
			jQuery(".meter > span").each(function() {
				/* jQuery(this)
					.data("origWidth", jQuery (this).width()) 
					.width(0)
					.animate({
						width: jQuery(this).data("origWidth")
					}, 1200); */
			});
		});
	</script>

	
	
