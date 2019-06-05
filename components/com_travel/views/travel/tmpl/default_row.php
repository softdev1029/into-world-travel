<?php defined('_JEXEC') or die;
JHtml::_('formbehavior.chosen', 'select');
$def = travel::link('travel'); 
$region = $this->region;
$row = $this->row;




//Для цены отправим  
    $row->region_proc = $row->region_proc_strana = 0;
    if ($region){
    $row->region_proc = $region->proc;
    $row->region_proc_strana = $region->proc_strana;
    }

$data = $this->data;
   $address= unserialize($row->address);
  // $amenity= unserialize($row->amenity);
   $description= unserialize($row->description);
 
 
      $start = travel::strtotimed($data['data_start']);
     $end = travel::strtotimed($data['data_end']);
     $day = xml::time_text($start, $end);
     $this->e = 'for '.$day.' nights for '.$data['mann'].' adults'.($data['kind'] ? ' and '.$data['kind'].' children' : '');
       
	   $data_send = $data;
        $data_send['otel'] = $row->vid;
        $data_send['DetailLevel'] = 'full';
        $rowe =  xml::send_to_xml($data_send, 0);
        
       
        
        $xml_test = simplexml_load_string($rowe);
		
		//echo '<pre>';
		//print_r($xml_test);
		//exit;
        $Availability = $xml_test->HotelAvailability;
        $hotel_xml = $Availability->Hotel;
        $curr = trim($xml_test->Currency);
		/*$amenity['amenity'] =array();
		foreach ($hotel_xml->Amenity  as $r)
		 {
		   $amenity['amenity'][] = trim($r->Text);
		 }
		 */
      
      
        $id_otel =$hotel_xml['id'];
        $db=JFactory::getDBO();   
		$q = 'SELECT * FROM #__travel_otel WHERE vid='.(int)$id_otel;
		$db->setQuery($q);
		$hotelData = $db->LoadObject(); 
		
		$amenity = unserialize($hotelData->amenity); 
		
        $latitude= '';
        $longitude = '';
        if($hotelData){
        $latitude= $hotelData->latitude;
        $longitude = $hotelData->longitude;
         }


    
    //Получить комнаты
    $rooms_price = xml::rooms($Availability);
    $rooms = $rooms_price['rooms'];
    $price =  $rooms_price['price'];
	
	

	
       //Фото отеля 
    $this->all_foto = xml::fotos($Availability);    
    $dop = 0;
    if ($this->data['rooms']==2)
    $dop = $this->data['mann_two']+$this->data['kind_two'];
    
?>  

<script>
 PATH = "<?php echo JURI::root()?>";
 LINKDEFAULT = "<?=$def?>";
 PD_VP = <?=( strpos($def,'?')===false) ? 0 : 1?>;
</script>

 <script src="https://maps.googleapis.com/maps/api/js?v=3.20&signed_in=true&libraries=places&key=AIzaSyChhTLzGNb925EBySsEQz7D58tpS6MkZ4A"></script>
  
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
  <script src="<?php echo JURI::root()?>components/com_travel/js/modal.js" type="text/javascript"></script>
  <script src="<?php echo JURI::root()?>components/com_travel/js/nouislider.min.js"></script>
  <script src="<?php echo JURI::root()?>components/com_travel/js/wNumb.js"></script>
 <link rel="stylesheet" href="<?php echo JURI::root()?>components/com_travel/js/slick/slick.css" type="text/css" />

 <link rel="stylesheet" type="text/css" href="<?php echo JURI::root()?>components/com_travel/js/slick/slick-theme.css"/>
 
  <script src="<?php echo JURI::root()?>components/com_travel/js/slick/slick.min.js"></script>
  
  <link rel="stylesheet" href="<?php echo JURI::root()?>components/com_travel/css/rooms.css" type="text/css" />

 
 <div class="zen-roomspage">
  <div class="zen-roomspage-leftbar">
  
 
   
    <!----------------------- Выбор из первичного модуля  ------------------------>
   <div class="zen-regioninfo zen-regioninfo-able-change">
   <div class="zen-regioninfo-header"> 
   <div class="zen-regioninfo-region"><?=$row->title?>, <?=$row->region_name?></div>
   </div>
   <div class="zen-regioninfo-footer">
   <div class="zen-regioninfo-request">
   <div class="zen-regioninfo-dates"> <?=$this->month_start[1]?> <?=date('d',$this->start)?> — <?=$this->month_end[1]?><?=date('d',$this->end)?> </div>
   <div class="zen-regioninfo-rooms"><?=$this->data['rooms']?> room for&nbsp;<?=$this->data['mann']+$this->data['kind']+$dop  ?>&nbsp;guests</div></div>
   <span class="zen-regioninfo-change-wrapper">
   <span class="zen-regioninfo-change-text">change</span>
   <a class="zen-regioninfo-change-link" href="#" data-history="replace"></a></span></div></div>
  
  <!----------------------- Отель на карте ------------------------>
  
  <a class="zen-roomspage-leftbar-map" href="<?=$this->mapslink?>"
   data-history="replace">
   <div class="zen-roomspage-leftbar-map-button">Hotel on the map</div></a>
  
  <!----------------------- Посмотрите также ------------------------>
  <?php /* ?>
  <div class="zen-roomspage-leftbar-similarhotels">
  <div class="zen-roomspage-leftbar-similarhotels-wrapper">
    <div class="similarhotels">
      <div class="similarhotels-title">
       Look also
      </div>
      <div class="similarhotels-hotels">
      
      <?php echo html::hotel_list_review($xml_test, $this->data, $row->vid); ?>
      
      
        
       
        
      </div>
      <div class="similarhotels-showmore">
       Show 3 more
      </div>
    </div>
  </div>
</div>
<?php */ ?>
 
<script>
jQuery(document).ready(function(){
    var n=1;
 jQuery( ".similarhotels-hotel" ).each(function( index ) {
//jQuery(this)

if (n>3){
jQuery(this).hide();
jQuery(this).addClass('hide');
}
n++;
  });

 jQuery(document).on('click', '.similarhotels-showmore', function () { 
 var obj = jQuery(this);
   var n=1;
   
  jQuery( ".similarhotels-hotel.hide" ).each(function( index ) {
  
if (n<=3){
jQuery(this).show();
jQuery(this).removeClass('hide');
}
    n++;
  });
  
  
 if (jQuery( ".similarhotels-hotel.hide" ).length)
 {
    
 }
 else
 {jQuery( ".similarhotels-showmore" ).hide();
 }

 
 return false;
 });

});
</script>
 

  <!-----------------------  ------------------------>
  </div><!--zen-roomspage-leftbar-->
  
  
  <div class="zen-roomspage-hotel">
  
  <div class="zen-roomspage-header zen-roomspage-header-has-stars">
  <div class="zen-roomspage-header-content">
    <div class="zen-roomspage-header-inner">
      <div class="zen-roomspage-header-title-wrapper">
       
        <div class="zen-roomspage-title">
          <div class="zen-roomspage-title-stars">
            <div class="zen-ui-stars">
            
            
             <?php for ($i=0; $i<$row->stars; $i++): ?>
                                                                <div class="zen-ui-stars-wrapper">
                                                                        <div class="zen-ui-stars-star">
                                                                        </div>
                                                                </div>
                                                         <?php endfor; ?> 
            
            
            </div>
          </div>
          <div class="zen-roomspage-title-name-wrapper">
            <h1 class="zen-roomspage-title-name">
              <?=$row->title?> 
            </h1>
          </div>
          <p class="zen-roomspage-location">
            <a class="zen-roomspage-address" href="/hotel/poland/warsaw/mid7478973/best_western_hotel_portos/?q=3765&amp;dates=25.08.2018-27.08.2018&amp;guests=2and0.0&amp;popup=map&amp;room=s-d54c3000-5519-5395-aae3-5912ba098d5a&amp;serp_price=best_western_hotel_portos.5890.RUB.h-9a8740a0-68c8-59ba-8efd-08d4c28df2ca&amp;sid=76c2018b-8751-4811-89b5-5de15acacf02" data-history="replace">
    <?=$address['Address1']?>,<?=($address['Address2']) ? ' '.$address['Address2']."," : ''?>
    <?=($address['Address3']) ? ' '.$address['Address3']."," : ''?>
    <?=$address['City']?>, <?= (isset($hotel_xml->Region['name'])) ? $hotel_xml->Region['name'].', ' : ''?><?=$address['Country']?>
               
              
            </a>
            <a class="zen-roomspage-phone" href="tel:+<?=$address['Tel']?>">
              <?=$address['Tel']?>
            </a>
           
          </p>
        </div>
      </div>
      <div class="zen-roomspage-header-calltoaction">
        <div class="zen-roomspage-calltoaction-fixed ">
          <div class="zen-roomspage-calltoaction-roomtypes">
            <div class="zen-roomspage-calltoaction-roomtypes-price">
              <div class="zen-roomspage-calltoaction-roomtypes-price-wrapper">
                from
                <strong class="zen-roomspage-calltoaction-roomtypes-price-value" data-price="<?= (isset($price[0])) ?  travel::pr($price[0], $row) : 'no price'?> ">
              <?php  /* ?>    <?= (isset($price[0])) ?  travel::pr($price[0], $row) : 'no price'?> <?php */ ?>
				  <?= (isset($price[0])) ?  travel::pr1($price[0], $row) : 'no price'?>
                </strong>
              </div>
              <div class="zen-roomspage-calltoaction-roomtypes-nights">
               Price for <?=$day?> nights
              </div>
            </div>
          </div>
          <div class="zen-roomspage-calltoaction-button">
            <a class="zen-roomspage-calltoaction-button-link" href="<?=$this->link.'&room_view=display' ?>#price" data-history="replace">
              <span class="zen-roomspage-calltoaction-button-text">
                View prices
              </span>
            </a>
          </div>
        </div>
      </div>
      <div class="zen-roomspage-picks">
      </div>
    </div>
  </div>
</div>

   <?php echo $this->loadTemplate('images'); ?>
  
  
  
  <!-----------------------  ------------------------>
  <div class="zen-roomspage-perks">
  <div class="zen-roomspage-perks-content">
  <div class="zen-roomspage-perks-inner">
  
  <div class="zen-roomspage-amenities">
  <h2 class="zen-roomspage-amenities-title">Hotel services and facilities</h2>
  <div class="zen-roomspage-amenities-list">
  <?php
$n=0;
 
 //echo '<pre>';
 //print_r($amenity);
 //exit;

 foreach ($amenity as $key=>$val): ?>
  <p class="zen-roomspage-amenities-amenity zen-roomspage-amenities-multi-amenity">
 <?php $img =str_replace("/","",$val); 

$img = str_replace(' ', '', $img);

?>
  <img  src="<?=JURI::root()?>components/com_travel/images/ico/<?=$key?>.png" />
  <?=$val?></p>
   <?php 
 $n++;
  //if ($n>7) break;
 endforeach; ?>  
    
  </div>
  
  <div style="display: none;" class="zen-roomspage-amenities-button-wrapper">
  <a class="zen-roomspage-amenities-button" 
  href="<?=$this->link?>#amenity" data-history="replace">All services and amenities</a>
  </div>
  </div><!--zen-roomspage-amenities-->
  
  <div class="zen-roomspage-map">
  <div class="zen-roomspage-map-title">Hotel on the map</div>
  
  
  <!-----------------------  ------------------------>
  <a class="zen-roomspage-map-link" href="<?=$this->link?>#maps" data-history="replace">
  <div class="zen-roomspage-map-container">
  <div class="hotelminimap hotelminimap-ready">
  <div class="hotelminimap-link" target="_self">
  <div id="mini" class="hotelminimap-content" style="position: relative;">
 
  </div>
  </div></div></div>
  </a>
  <!-----------------------  ------------------------>
  <p class="zen-roomspage-location">
  <a class="zen-roomspage-address" href="<?=$this->link?>#maps" data-history="replace">
   <?=$address['Address1']?>,<?=($address['Address2']) ? ' '.$address['Address2']."," : ''?>
    <?=($address['Address3']) ? ' '.$address['Address3']."," : ''?>
    <?=$address['City']?>, <?= (isset($hotel_xml->Region['name'])) ? $hotel_xml->Region['name'].', ' : ''?><?=$address['Country']?>
  </a>
  <a class="zen-roomspage-phone" href="tel:<?=$address['Tel']?>">
  <?=$address['Tel']?>
  </a>
  
</p>

  <!-----------------------  ------------------------>
  
  </div>
  
  </div>
  </div>
  </div>
  <!-----------------------  ------------------------>
  
  <div class="zen-roomspage-about-wrapper">
  <div class="zen-roomspage-about">
  <div class="zen-roomspage-about-report-button"></div>
  <h2 class="zen-roomspage-about-title">Hotel description</h2>
  <?php 
  $n = 0;
  foreach ($description as $key=>$val): ?>
  <div class="zen-roomspage-about-item" style="<?=($n>0) ? 'display:none' : ''?>">
  <div class="zen-roomspage-about-item-title zen-roomspage-about-item-title-about">
  <?=$key?></div>
  <div class="zen-roomspage-about-item-description">
  <p class="zen-roomspage-about-item-description-paragraph"><?=$val?></p></div>
  </div>
  <?php 
  $n++;
  endforeach; ?>
  
  
  
  
  
  <div class="zen-roomspage-about-button">
  <div class="zen-roomspage-about-button-caption">Expand description</div>
  </div></div>
  </div>
 
 <!----------------------- Карта отеля ------------------------>
 
 <script>
 var map,map2, infoWindows, latlngbounds,geocoder;
 
function initMap() {
 
    var centerLatLng = new google.maps.LatLng(<?=$latitude?>,<?=$longitude?>);
	var mapOptions = {
		center: centerLatLng,
		zoom: 17,
        gestureHandling: 'greedy'
	};
    	var mapOptions2 = {
		center: centerLatLng,
		zoom: 10,
        gestureHandling: 'greedy'
	};
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
        map2 = new google.maps.Map(document.getElementById("mini"), mapOptions2);
        
        latlngbounds= new google.maps.LatLngBounds();
         var latLng = new google.maps.LatLng(<?=$latitude?>,<?=$longitude?>);
        addMarker(latLng);
    
     var marker = new google.maps.Marker({
        position: latLng,
        map: map2,
        title: "<?=$row->title?>"
        
    });
    
       // map.setCenter( latlngbounds.getCenter(), map.fitBounds(latlngbounds));	 
      
      
 }
 
 function addMarker(latLng) {
    
   
    latlngbounds.extend(latLng);
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        title: "<?=$row->title?>"
        
    });
    
}

 
 google.maps.event.addDomListener(window, "load", initMap);
 </script>  <a name="maps"></a>
 <div class="zenroomspage-geoblock-wrapper">
  <div class="zenroomspagegeoblock">
    <header class="zenroomspagegeoblock-header">
      <div class="zenroomspagegeoblock-title">
       Location of the hotel
      </div>
      
    
      <div class="zenroomspagegeoblock-address">
         <?=$address['Address1']?>,<?=($address['Address2']) ? ' '.$address['Address2']."," : ''?>
    <?=($address['Address3']) ? ' '.$address['Address3']."," : ''?>
    <?=$address['City']?>, <?= (isset($hotel_xml->Region['name'])) ? $hotel_xml->Region['name'].', ' : ''?><?=$address['Country']?>
      </div>
     
    </header>
    <main class="zenroomspagegeoblock-main">
      <div  id="map" class="zenroomspagegeoblock-main-map">
        
      </div>
    </main>
  </div>
</div>

 <!-----------------------  ------------------------>
 <a name="price"></a>
 <div class="zen-roomspage-form">
 <h2 class="zen-roomspage-form-title">Rooms available for the selected period</h2>
 <div class="zen-roomspage-searchform">
 <div class="zen-searchform">
 <form id="travel_search" name="travel_search" 
method="get" action="index.php" class="jsFilter jbfilter jbfilter-default">



 
   
  
 
 
<div class="jbfilter-row jbfilter-date-range last">
<label class="jbfilter-label" for="data_start-1">Journey period</label><div class="jbfilter-element">

<label for="jdata_start">From</label>
<input style="width:100px" type="text" name="e[data_start]" value="<?=$data['data_start']?>" id="data_start" class="jbfilter-element-date jbfilter-element-tmpl-date-range element-datepicker" />
<label for="jdata_end">Until</label>
<input  style="width:100px" type="text" name="e[data_end]" value="<?=$data['data_end']?>" id="data_end" class="jbfilter-element-date jbfilter-element-tmpl-date-range element-datepicker" /></div><i class="clr"></i>
</div>

 <div class="jbfilter-row jbfilter-kol jbfilter-select-chosen">
<label class="jbfilter-label" for="jbfilter-id-itemname">Number of people</label>
  <?php html::getPersona_modif("", $data)?>

<?php html::getPersona_modif("_two", $data)?>
 
 <i class="clr"></i>
  
  
  
  </div>

 <div class="jbfilter-row jbfilter-buttons">

<input type="submit" name="send-form" value="Search" class="jsSubmit jbbutton" />
 <i class="clr"></i></div>
 
 
<input type="hidden" name="option" value="com_travel" />
<input type="hidden" name="id" value="<?=$row->id?>" />
<input type="hidden"  name="e[otel]" value="<?=$row->vid?>" />
<input type="hidden"  name="e[title2]" value="" />
<input type="hidden"  name="e[title]" value="" />
 <input type="hidden"  name="e[region]" value="<?=$region->id?>" />
 <input type="hidden"  name="e[rooms]" value=" <?=$data_send['rooms']?>" />

 
   </form>
 
 </div>
 </div>
 </div><!--zen-roomspage-form-->
 
  <?php 
  $this->rooms=$rooms;
  echo $this->loadTemplate('rooms'); ?>
 
 
 
  </div><!--zen-roomspage-hotel-->
   
   
   
   
</div>

<?php 
$data = $this->data;
 $data['otel'] = 0;
include(JPATH_SITE."/components/com_travel/helpers/html/modal_find.php");
?>
<script src="<?php echo JURI::root()?>components/com_travel/js/main.js" type="text/javascript"></script>
     
 
<script>
jQuery(document).ready(function(){
jQuery('.your-class').slick({
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 1,
  centerMode: false,
  variableWidth: true
});
jQuery('.galery_travel').magnificPopup({
  type: 'image',
  gallery:{
    enabled:true
  }
});

jQuery(document).on('click', '.zen-roomspage-about-button', function () { 
var obj = jQuery(this);

 if (obj.hasClass('zen-roomspage-about-button-hide'))
 {jQuery('.zen-roomspage-about-button-caption').html('Expand description');
    
    jQuery('.zen-roomspage-about-item').hide();
    jQuery('.zen-roomspage-about-item:first').show();
    obj.removeClass('zen-roomspage-about-button-hide'); 
  
 }
 else
 {jQuery('.zen-roomspage-about-button-caption').html('Collapse description');
    jQuery('.zen-roomspage-about-item').show();
    obj.addClass('zen-roomspage-about-button-hide');  
 }




return false;
});

});
</script>
