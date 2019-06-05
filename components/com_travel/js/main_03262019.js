  var formatdata = 'd-M-yy';
jQuery(document).ready(function(){
 
 jQuery('.zen-maptrigger-button-map, .zen-roomspage-leftbar-map').magnificPopup({
  type: 'iframe' 
  
  
});
 
 function selectro_person()
 {
  
    jQuery('.selectro_person_two').hide();
  var d = jQuery('#nacr').val();
  if (d==2)
     jQuery('.selectro_person_two').show();
    
    
 }
 selectro_person();
 
 jQuery( "#nacr" ).change(function() {
   selectro_person(); 
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
    kindage();
     }); //jQuery('#mann, #kind').change(function(){
        
        kindage();
        
         jQuery('#mann_two, #kind_two').change(function(){
    kindage_two();
     }); //jQuery('#mann, #kind').change(function(){
        
        kindage_two();
        
      function kindage()
      {
          var total = 0;
    total = (jQuery('#mann').val()*1) +total;
    total = (jQuery('#kind').val()*1) +total;
    
      jQuery('.zen-guests-age').hide();
    
    
   jQuery('.zen-guestsbutton-button-guests').html(total+' guests');
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
  
   
      }  
        function kindage_two()
      {
          var total = 0;
    total = (jQuery('#mann_two').val()*1) +total;
    total = (jQuery('#kind_two').val()*1) +total;
    
      jQuery('.zen-guests-age_two').hide();
    
    
   jQuery('.zen-guestsbutton-button-guests_two').html(total+' guests');
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
        
    jQuery('.zen-guests-ages_tow').hide();
      }
  
   
      }  
  
  jQuery(".zen-select-native").chosen({}, 0);
  jQuery("#select_kind").chosen({}, 0);
  
  jQuery(".jbfilter-element-date").datepicker({"dateFormat":formatdata,"timeFormat":"hh:mm:ss",minDate: 0}); 
  
  jQuery(".jbfilter-element-date").datepicker({
  onSelect: function(dateText) {
     
     
     
  }
});
   
   jQuery(".jbfilter-element-date").datepicker({"dateFormat":formatdata,"timeFormat":"hh:mm:ss",minDate: 0});  
 
  jQuery(document).on('click', '.zen-regioninfo-change-link', function () { 
  var obj = jQuery(this);
  
  

    jQuery.magnificPopup.open({
  items: {
    src:  '#layer-create-dom'
  },
  type: 'inline',
  callbacks: {
    open: function() {
     jQuery("#nac").chosen("destroy");
     jQuery("#nac").chosen({}, 0);
    },
    close: function() {
    
    }
    // e.t.c.
  }
 });
 
   return false;
  });
    

 
 var region_select = 0;
 var region_to = 1;
 if (jQuery( "#input_region" ).length){
 region_select = jQuery( "#input_region" ).val();
 }
 

 
  
 jQuery( "#hotel_name" ).autocomplete({
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
         updateContent();
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
        .append( "<span class='travel_title_ul'>Регионы</span>")
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
        .append( "<span class='travel_title_ul'>Регионы</span>")
        .appendTo( ul );
      }
      else if(item.otel==region_to)
      {
         region_to =-1; 
      var b =    jQuery( "<li><hr>" )
        .append( "<span class='travel_title_ul'>Отели</span>")
        .appendTo( ul );
      }
      
      
      var a = jQuery( "<li>" )
        .append( "<span class='travel_item_ul'>" + item.label + "</span>")
        .appendTo( ul );
        
        
        return a;
    };
    
    
    
    
    
    
    
    
    
    function inisluderrange(){
    
     if (jQuery('#range-input').length==0) return false;
     
    
  var range = document.getElementById('range-input');
  var rangeFromField = document.getElementById('price-from');
  var rangeToField = document.getElementById('price-to');
  var $slider = jQuery('#range-input');
 
  var Format = wNumb({
	suffix: ' руб.',
	decimals: 0,
	thousand: ' '
});
  noUiSlider.create(range, { 
   
  
    start: [parseInt($slider.data('value-min')), parseInt($slider.data('value-max'))],
			step: parseInt($slider.data('step')) || 100,
			connect: true,
			range: {
				min: parseInt($slider.data('min')),
				max: parseInt($slider.data('max'))
			}
  });
  
  var rangeValues = range.noUiSlider.get();
  var rangeFrom = Math.floor(rangeValues[0]);
  var rangeTo = Math.floor(rangeValues[1]);
  rangeFromField.value = rangeFrom;
  rangeToField.value = rangeTo;
  
  	range.noUiSlider.on('update', function(values, handle) {
	 
    rangeValues = range.noUiSlider.get();
    rangeFrom = Math.floor(rangeValues[0]);
    rangeTo = Math.floor(rangeValues[1]);
    rangeFromField.value = rangeFrom;
    rangeToField.value = rangeTo;
            
             jQuery('#range_is').val(1);
           if (parseInt($slider.data('min'))==values[0] 
           && parseInt($slider.data('max'))==values[1])
           jQuery('#range_is').val(0);
            
		});
  	range.noUiSlider.on('change', function(values, handle) {
		  
           jQuery('#range_is').val(1);
           if (parseInt($slider.data('min'))==values[0] 
           && parseInt($slider.data('max'))==values[1])
           jQuery('#range_is').val(0);
           
           
           
		   updateContent();
		});
  
  /*
  range.noUiSlider.on('end', function() {
    rangeValues = range.noUiSlider.get();
    rangeFrom = Math.floor(rangeValues[0]);
    rangeTo = Math.floor(rangeValues[1]);
    rangeFromField.value = rangeFrom;
    rangeToField.value = rangeTo;
    
    
           jQuery('#range_is').val(1);
           if (parseInt($slider.data('min'))==rangeValues[0] 
           && parseInt($slider.data('max'))==rangeValues[1])
           jQuery('#range_is').val(0);
		   updateContent();
    

  });
  */
  rangeToField.addEventListener('input', function() {
    var context = this;
    range.noUiSlider.set([null, context.value]);
  });
  rangeFromField.addEventListener('input', function() {
    var context = this;
    range.noUiSlider.set([context.value, null]);
  });
     }
     inisluderrange();
     
     
     jQuery(document).on('click', '.zen-checkboxfield-element', function () { 
     var obj = jQuery(this);
     updateContent();
     
    
     });
     
     
    
  
 //Поиcк ajax
 
 	var loaderShow = function() {
		jQuery('.zen-hotels-list').css('opacity',0.2);
	};


 
	var loaderHide = function() {
		jQuery('.zen-hotels-list').css('opacity',1);
	};   
    //jQuery('#hotel_name').keyup( jQuery.debounce( 250, text_2 ) );
 
  jQuery('#hotel_name').keyup(function(e){
    
    
    
    if(e.keyCode == 13)
    {
        jQuery('#input_otel').val(0);
        jQuery('#otels').val( jQuery('#hotel_name').val());
        updateContent();
    }
  });
  
  
 var updateContent = function() { 
    //travel_search
    //travel_sort
     var $form = jQuery('.travel_sort'); 
     var m_data = '';
     var a = '';
     var start = false;
     var rand = Math.random() * (999999 - 100) + 100;
     
     var rangeis=jQuery('#range_is').val();
    if (rangeis==1)
    {
     var fprice_from= $form.find('#price-from').val();
     var fprice_to= $form.find('#price-to').val();
    }  
    
    jQuery('#task').val('filter_ajax');
    
    var m_data = jQuery('#travel_sort,#travel_search').serialize();
      jQuery('#task').val('filter');
   // console.log(m_data);
		jQuery.ajax({
			type: 'GET',
			cache: false,
             dataType: "json", 
			url:  PATH+'?ajax=1&rand='+rand,
            data: m_data,
		 
			beforeSend: function() {
				loaderShow();
			},
			error: function() {
				loaderHide();
			},
			success: function(res) {
		  
      
         var a = '';
         if (PD_VP==0)
         a = '?';
         else
         a = '&';
         
         
         jQuery('.zen-maptrigger-button-map').attr('href',res.mapslink);
         
          stroka = LINKDEFAULT+a+res.link;
 var state = {title:'Фильтр',url: stroka} 
 history.pushState( state, state.title, state.url); 
         
             jQuery('.zen-regioninfo-counter').html(res.total);
             jQuery('.hotels-inner').html(res.html);
             loaderHide();
             
			}
            
            });
 
 
 }//uploadContent
     
     
     //Если вводим то удаляем пока id выбранный отеля
    jQuery('#hotel_name, #otels').on('input keyup', function(e) {
    jQuery( "#input_otel" ).val(0);
});
     
}); //Jquery end