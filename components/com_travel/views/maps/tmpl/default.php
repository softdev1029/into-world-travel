<?php defined('_JEXEC') or die; 
JHtml::_('formbehavior.chosen', 'select');
$def = travel::link('travel'); 
$xml_test = $this->xml_test;

 $curr = trim($xml_test->Currency);
 $zn_s = '';
 $zn_e = '';
 
 if ($curr==='USD')
 $zn_s = '$';

$data =$this->data; 
 
 
     $start = travel::strtotimed($data['data_start']);
     $end = travel::strtotimed($data['data_end']);
     $day = xml::time_text($start, $end);
     $e = 'for '.$day.' nights for '.$data['mann'].' adults'.($data['kind'] ? ' and '.$data['kind'].' children' : '');
    
    
   
?>

<script>
 PATH = "<?php echo JURI::root()?>";
 LINKDEFAULT = "<?=$def?>";
 PD_VP = <?=( strpos($def,'?')===false) ? 0 : 1?>;
</script>

   <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
   <script src="https://maps.googleapis.com/maps/api/js?v=3.20&signed_in=true&libraries=places&key=AIzaSyChhTLzGNb925EBySsEQz7D58tpS6MkZ4A"></script>
  
<div style="position: relative;">

 <div id="floating-panel">
      
      
      <input id="autocomplete" placeholder="Enter your address"
             onFocus="geolocate()" type="text"></input>
      
    </div>

<div id="map" class="map"></div>
 
</div>
 <?php
 
 
 
 $db=JFactory::getDBO();
 $arr = array();
  foreach ($xml_test->HotelAvailability as $Availability)
      { 
        
    $hotel = $Availability->Hotel;
    $id_otel = $hotel['id'];
    $q = 'SELECT * FROM #__travel_otel WHERE vid='.(int)$id_otel;
    $db->setQuery($q);
    $row = $db->LoadObject(); 
    if (!$row) continue; 
    $address= unserialize($row->address);
    $d = array();
    $d['e'] = $data ;
    $link =travel::link('travel', '&id='.$row->id."&".http_build_query($d));
    
    $price = 0;
   
   //Получаем комнаты 
  foreach ($Availability->Result as $result)
  {
   $price = trim($result->Room->Price['amt']);  
   break;
  }
    
    
  
    $arr[]='{
        lat: '.$row->latitude.',     
		lng: '.$row->longitude.',     
		name: "'.$row->title.'",   
	    id: "'.$row->id.'",
        link: "'.$link.'",
        price: "'.$zn_s.$price.$zn_e.'",
        stars:"'.$row->stars.'",
        address: "'.$address['Address1'].', '.$this->region->title.', '.$this->region->country_title.'",
        
        }';
      }
      
      $s ='var markersData = ['.implode(',',$arr).'];';
     
 ?>
 
<script>

 
var map, infoWindows, latlngbounds,geocoder;
var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};
function initMap() {
	<?=$s?>
    var centerLatLng = new google.maps.LatLng(51.5116028, -0.1183185);
	var mapOptions = {
		center: centerLatLng,
		zoom: 8,
        gestureHandling: 'greedy'
	};
      
      
      
      map = new google.maps.Map(document.getElementById("map"), mapOptions);
      
      //----------------------- auto --------------------------
      
       autocomplete = new google.maps.places.Autocomplete(
      /** @type {HTMLInputElement} */(document.getElementById('autocomplete')),
      { types: ['geocode'] });
  // When the user selects an address from the dropdown,
  // populate the address fields in the form.
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    fillInAddress();
  });
      
      //-----------------------  --------------------------
	  latlngbounds= new google.maps.LatLngBounds();
      
   //----------------------- Балун --------------------------   
      
     // InfoWindow content
  var content = '<div id="iw-container">' +
                    '<div class="iw-title">Porcelain Factory of Vista Alegre</div>' +
                    '<div class="iw-content">' +
                      '<div class="iw-subTitle">History</div>' +
                      '<img src="images/vistalegre.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                      '<p>Founded in 1824, the Porcelain Factory of Vista Alegre was the first industrial unit dedicated to porcelain production in Portugal. For the foundation and success of this risky industrial development was crucial the spirit of persistence of its founder, José Ferreira Pinto Basto. Leading figure in Portuguese society of the nineteenth century farm owner, daring dealer, wisely incorporated the liberal ideas of the century, having become "the first example of free enterprise" in Portugal.</p>' +
                      '<div class="iw-subTitle">Contacts</div>' +
                      '<p>VISTA ALEGRE ATLANTIS, SA<br>3830-292 Ílhavo - Portugal<br>'+
                      '<br>Phone. +351 234 320 600<br>e-mail: geral@vaa.pt<br>www: www.myvistaalegre.com</p>'+
                    '</div>' +
                    '<div class="iw-bottom-gradient"></div>' +
                  '</div>';
                    
        // A new Info Window is created and set content
   infoWindows = new google.maps.InfoWindow({
     
     maxWidth: 350
  });
      //infoWindow = new google.maps.InfoWindow();
    // Отслеживаем клик в любом месте карты
    google.maps.event.addListener(map, "click", function() {
        // infoWindow.close - закрываем информационное окно.
        infoWindows.close();
    });
    
    google.maps.event.addListener(infoWindows, 'domready', function() {

    // Reference to the DIV that wraps the bottom of infowindow
    var iwOuter = jQuery('.gm-style-iw');

    /* Since this div is in a position prior to .gm-div style-iw.
     * We use jQuery and create a iwBackground variable,
     * and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
    */
    var iwBackground = iwOuter.prev();

    // Removes background shadow DIV
    iwBackground.children(':nth-child(2)').css({'display' : 'none'});

    // Removes white background DIV
    iwBackground.children(':nth-child(4)').css({'display' : 'none'});

    // Moves the infowindow 115px to the right.
    //iwOuter.parent().parent().css({left: '115px'});

    // Moves the shadow of the arrow 76px to the left margin.
    //iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 76px !important;'});

    // Moves the arrow 76px to the left margin.
   // iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 76px !important;'});

    // Changes the desired tail shadow color.
    iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1' });
    
    // Reference to the div that groups the close button elements.
    var iwCloseBtn = iwOuter.next();

    // Apply the desired effect to the close button
    iwCloseBtn.css({opacity: '1', right: '38px', top: '3px', border: '7px solid #48b5e9', 'border-radius': '13px', 'box-shadow': '0 0 5px #3990B9'});

    // If the content of infowindow not exceed the set maximum height, then the gradient is removed.
    if(jQuery('.iw-content').height() < 140){
      jQuery('.iw-bottom-gradient').css({display: 'none'});
    }

    // The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
    iwCloseBtn.mouseout(function(){
      jQuery(this).css({opacity: '1'});
    });
  });
    
     
     for (var i = 0; i < markersData.length; i++){
       var latLng = new google.maps.LatLng(markersData[i].lat, markersData[i].lng);
        //var name = markersData[i].name;
        //var id = markersData[i].id;
        // Добавляем маркер с информационным окном
        addMarker(latLng, markersData[i]);
      }
   
   map.setCenter( latlngbounds.getCenter(), map.fitBounds(latlngbounds));	 
}
google.maps.event.addDomListener(window, "load", initMap);
function addMarker(latLng, markersData) {
    
    var image = '/components/com_travel/images/pinactive.svg';
    
    latlngbounds.extend(latLng);
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        title: markersData.name,
        icon: image
    });
    // Отслеживаем клик по нашему маркеру
    google.maps.event.addListener(marker, "click", function() {
       
    var st = '<div class="zen-hotelcard-stars"><div class="zen-ui-stars">';
       for (var i=0; i<(1*markersData.stars); i++){
         st+= '<div class="zen-ui-stars">';
         st+= '<div class="zen-ui-stars-wrapper">';
         st+= '<div class="zen-ui-stars-star"></div></div>';
         st+= '</div>';
         }
         st+= '</div></div>';
       
       
       var price = '<div class="zen-hotelcard-rates-wrapper">';
  price+= '<div class="zen-hotelcard-rates">';
    price+= '<div class="zen-hotelcard-rate">';
      price+= '<div class="zen-hotelcard-rate-inner">';
      price+= '  <a class="zen-hotelcard-rate-price-wrapper" href="'+markersData.link+'" target="_blank" data-name="newTab">';
      price+= '    <div class="zen-hotelcard-rate-price">';
      price+= '      <div class="zen-hotelcard-rate-price-inner">';
      price+= '        <div class="zen-hotelcard-rate-price-has-value">';
       price+= '         <div class="zen-hotelcard-rate-price-value">';
       price+= '           <span>';
                    price+= markersData.price;
                  price+= '</span>';
                price+= '</div>';
             price+= ' </div>';
           price+= ' </div>';
            price+= '<div class="zen-hotelcard-rate-price-notice">';
             price+= ' <?=$e?>';
            price+= '</div>';
         price+= ' </div>';
       price+= ' </a>';
     price+= ' </div>';
   price+= ' </div>';
  price+= '</div>';
price+= '</div>';
       
        var contentString = '<div id="iw-container"><div class="zen-hotelcard"><div class="zen-hotelcard-content-wrapper"><div class="zen-hotelcard-content"><div class="zen-hotelcard-content-main">'+ st+
                    '<h2 class="zen-hotelcard-name">'+
      '<a class="zen-hotelcard-name-link" href="'+markersData.link+'" target="_blank" data-name="newTab">'+
        markersData.name+
      '</a></h2>'+
      
      '<a class="zen-hotelcard-address" href="'+markersData.link+'" target="_blank">'+ markersData.address+'</a>'+
      
      '</div></div></div><div class="zen-hotelcard-gallery-wrapper"><a class="mein_img" target="_blank" href="'+markersData.link+'"><img src="http://placehold.it/320x134"></a></div>' +
                    ' ' +price+
     '<div class="zen-hotelcard-nextstep-wrapper"><div class="zen-hotelcard-nextstep"><a class="zen-hotelcard-nextstep-button" href="'+markersData.link+'" target="_blank" data-name="newTab">Learn More</a></div></div>'+               
                    '<div class="iw-bottom-gradient"></div>' +
                  '</div></div>';
            
        // Меняем содержимое информационного окна
         infoWindows.setContent(contentString);
        // Показываем информационное окно
        infoWindows.open(map, marker);
       
        
        
    });
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = new google.maps.LatLng(
          position.coords.latitude, position.coords.longitude);
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
</script>
 