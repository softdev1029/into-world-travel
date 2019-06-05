<?php defined('_JEXEC') or die; 
JHtml::_('formbehavior.chosen', 'select');
$def = travel::link('travel'); 
$min_price =array();
$max_price =array();
$xml_test = $this->xml_test;

 //Цена по умолчанию



$Availability = $xml_test->HotelAvailability;
$rooms_price = xml::rooms($Availability);
   //$price =  $rooms_price['price'];
$min_price[]  = min($rooms_price['price']); 
$max_price[]  = max($rooms_price['price']); 

$min = travel::convertPricevalue(min($min_price), $row);
$max = travel::convertPricevalue(max($max_price), $row); 


$data =$this->data; 

if (isset($data['price_min']))
$price_min =$data['price_min'];
else
$price_min =$min;


if (isset($data['price_max']))
$price_max =$data['price_max'];
else
$price_max =$max;

 
if (isset($data['range_is']))
$range_is =$data['range_is'];
else
$range_is =0; 

if (isset($data['star']))
$star =$data['star'];
else
$star ='any'; 

 if (isset($data['type']))
$type =$data['type'];
else
$type ='any'; 
 
     $start = travel::strtotimed($data['data_start']);
     $end = travel::strtotimed($data['data_end']);
     $day = xml::time_text($start, $end);
     $this->e = 'for '.$day.' nights for '.$data['mann'].' adults'.($data['kind'] ? ' and '.$data['kind'].' children' : '');
    
    $dop = 0;
    if ($this->data['rooms']==2)
    $dop = $this->data['mann_two']+$this->data['kind_two'];
    
    
 
?>

<script>
 PATH = "<?php echo JURI::root()?>";
 LINKDEFAULT = "<?=$def?>";
 PD_VP = <?=( strpos($def,'?')===false) ? 0 : 1?>;
</script>

  <script src="<?php echo JURI::root()?>components/com_travel/js/modal.js" type="text/javascript"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
  <script src="<?php echo JURI::root()?>components/com_travel/js/nouislider.min.js"></script>
  <script src="<?php echo JURI::root()?>components/com_travel/js/wNumb.js"></script>
  <script src="<?php echo JURI::root()?>components/com_travel/js/jquery.debounce-1.0.5.js"></script>
  


 <div class="zen-hotels-content">
 
  <aside class="zen-hotels-leftbar"> 
   
    <!----------------------- Выбор из первичного модуля  ------------------------>
   <div class="zen-regioninfo zen-regioninfo-able-change">
   <div class="zen-regioninfo-header">
   <div class="zen-regioninfo-region"><?=$this->region->title?>, <?=$this->region->country_title?></div>
   <div class="zen-regioninfo-counter" data-total="count"><?php echo  isset($xml_test->HotelAvailability) ? count($xml_test->HotelAvailability):0?></div></div>
   <div class="zen-regioninfo-footer">
   <div class="zen-regioninfo-request">
   <div class="zen-regioninfo-dates"><?=$this->month_start[1]?> <?=date('d',$this->start)?>  — <?=$this->month_end[1]?> <?=date('d',$this->end)?> </div>
   <div class="zen-regioninfo-rooms"><?=$this->data['rooms']?> room for&nbsp;<?=$this->data['mann']+$this->data['kind']+$dop  ?>&nbsp;guests</div></div>
   <span class="zen-regioninfo-change-wrapper">
   <span class="zen-regioninfo-change-text">change</span>
   <a class="zen-regioninfo-change-link" href="#" data-history="replace"></a></span></div></div>
  
  
  <!----------------------- maps ------------------------>
  
  <div class="zen-maptrigger zen-maptrigger-has-map">
   
  <a class="zen-maptrigger-button zen-maptrigger-button-map" 
  href="<?=$this->mapslink?>" data-history="replace">Map</a></div>
  <!----------------------- Фильтры  ------------------------>
 
 <form method="POST" action="index.php" id="travel_sort" name="travel_sort">
 <input type="hidden" name="option" value="com_travel" />
 

 <div class="zen-hotels-filters"> 
 
  <div style="display: none;" class="zen-hotels-filter zen-hotels-filter-favorites"><div class="zen-filter zen-filter-favorites"><a class="zen-filter-favorites-button" data-history="replace"><span class="zen-filter-favorites-label">My choice</span></a><div class="zen-filter-favorites-tip"><div class="zenpopuptipcontainer zenpopuptipcontainer-show"></div></div></div></div>
 
 
  <div class="zen-hotels-filter zen-hotels-filter-hotelname">
  <div class="zen-filter zen-filter-hotelname zen-filter-hotelname">
  <div class="zen-filter-title zen-filter-hotelname-title">The name of the hotel</div>
  <div class="zen-filter-hotelname-field">
  <input class="zen-filter-hotelname-input" 
  value="<?=$this->data['title2']?>" 
  id="hotel_name"
  
  placeholder="For example, Hilton">
  <div class="zen-filter-hotelname-clear"></div></div></div>
  </div>
  
  
  <!----------------------- Цена ------------------------>
  
  <div class="zen-hotels-filter zen-hotels-filter-price">
  <div class="zen-filter zen-filter-prices">
  <div class="zen-filter-selects">
  <div class="zen-filters-selects-title">Price for </div>
  <div class="zen-filter-select-period zen-filter-select-period-disable">
  <div class="zen-select"><div class="zen-select-label">1 night</div>
  <div class="zen-select-arrow"></div>
   </div></div> 
  <div class="zen-filter-currency-select">
  
  <div class="zenfiltercurrency-select-wrapper">
  <div class="zenfiltercurrency-select">
  <div class="zenfiltercurrency-select-icon"></div>
  <div class="zenfiltercurrency-select-inner">
  <div class="zenfiltercurrency-select-label"></div>
     
  </div></div></div></div></div>
  
  <div class="zen-filter-prices-indicator">
  <input name="e[price_min]" data-price-min="<?=$min?>" class="zen-filter-prices-indicator-input zen-filter-prices-indicator-from" 
  type="text" id="price-from"  autocomplete="off" autocorrect="off">
  <input name="e[price_max]"  data-price-max="<?=$max?>" class="zen-filter-prices-indicator-input zen-filter-prices-indicator-to" 
  type="text" id="price-to" autocomplete="off" autocorrect="off">
  
  <input type="hidden" name="e[range_is]" value="1" id="range_is" />
  
  </div>
  
  <div class="zen-filter-slider">
 <div
                
                             data-min="<?=$min?>"
							 data-max="<?=$max?>"
							 data-value-min="<?=$price_min?>"
							 data-value-max="<?=$price_max?>"
							 data-step="10"
                 id="range-input"></div>
  
  </div>
  
  
  </div></div>
  
   <!-----------------------  ------------------------>
  <div class="zen-hotels-filter zen-hotels-filter-stars">
  <div class="zen-filter zen-filter-stars">
  <div class="zen-filter-title zen-filter-stars-title">Min Stars
  <div class="zen-filter-checkbox-fields zen-filter-stars-fields">
  
  <div class="zen-filter-checkbox-field">
  <div class="zen-checkboxfield">
  <label class="zen-checkboxfield-wrapper">
  <input <?=($star==='any') ? 'checked' : ''?> name="e[star]" value="any" class="zen-checkboxfield-element" type="radio">
  <div class="zen-checkboxfield-styled-checkbox"></div>
  
  <div class="zen-checkboxfield-stars-field">
Any
  </div>
  
  </label><div class="zen-checkboxfield-tip"></div>
  </div>
  </div>
  
  <div class="zen-filter-checkbox-field">
  <div class="zen-checkboxfield">
  <label class="zen-checkboxfield-wrapper">
  <input <?=($star==5) ? 'checked' : ''?> name="e[star]" value="5" class="zen-checkboxfield-element" type="radio">
  <div class="zen-checkboxfield-styled-checkbox"></div>
  
  <div class="zen-checkboxfield-stars-field">
  <span class="zen-checkboxfield-stars-star"></span>
  <span class="zen-checkboxfield-stars-star"></span>
  <span class="zen-checkboxfield-stars-star"></span>
  <span class="zen-checkboxfield-stars-star"></span>
  <span class="zen-checkboxfield-stars-star"></span>
  
  
  
  </div>
  
  </label><div class="zen-checkboxfield-tip"></div>
  </div>
  </div>
  
  
  
  <div class="zen-filter-checkbox-field">
  <div class="zen-checkboxfield">
  <label class="zen-checkboxfield-wrapper">
   <input <?=($star==4) ? 'checked' : ''?> name="e[star]" value="4" class="zen-checkboxfield-element" type="radio"><div class="zen-checkboxfield-styled-checkbox"></div><div class="zen-checkboxfield-stars-field"><span class="zen-checkboxfield-stars-star"></span><span class="zen-checkboxfield-stars-star"></span><span class="zen-checkboxfield-stars-star"></span><span class="zen-checkboxfield-stars-star"></span></div></label><div class="zen-checkboxfield-tip"></div></div>
  </div>
  
  <div class="zen-filter-checkbox-field"><div class="zen-checkboxfield">
  <label class="zen-checkboxfield-wrapper">
 <input <?=($star==3) ? 'checked' : ''?> name="e[star]" value="3" class="zen-checkboxfield-element" type="radio">
  
  <div class="zen-checkboxfield-styled-checkbox"></div><div class="zen-checkboxfield-stars-field"><span class="zen-checkboxfield-stars-star"></span><span class="zen-checkboxfield-stars-star"></span><span class="zen-checkboxfield-stars-star"></span></div></label><div class="zen-checkboxfield-tip"></div></div>
  </div>
  
  <div class="zen-filter-checkbox-field"><div class="zen-checkboxfield">
  <label class="zen-checkboxfield-wrapper">
<input <?=($star==2) ? 'checked' : ''?> name="e[star]" value="2" class="zen-checkboxfield-element" type="radio">
  
  <div class="zen-checkboxfield-styled-checkbox"></div><div class="zen-checkboxfield-stars-field"><span class="zen-checkboxfield-stars-star"></span><span class="zen-checkboxfield-stars-star"></span></div></label><div class="zen-checkboxfield-tip"></div></div>
  </div>
  
  <div class="zen-filter-checkbox-field"><div class="zen-checkboxfield">
  <label class="zen-checkboxfield-wrapper">
<input <?=($star==1) ? 'checked' : ''?> name="e[star]" value="1" class="zen-checkboxfield-element" type="radio">
  <div class="zen-checkboxfield-styled-checkbox"></div>
  <div class="zen-checkboxfield-stars-field">
  <span class="zen-checkboxfield-stars-star"></span>
 
    </div></label>
  <div class="zen-checkboxfield-tip"></div></div></div>
  
  </div></div></div></div>
 
  <!-----------------------  ------------------------>
 

 <div class="zen-hotels-filter zen-hotels-filter-estatetypes" >
        <div class="zen-filter zen-filter-estatetypes">
                <div class="zen-filter-title zen-filter-estatetypes-title">
                        Type of property
                </div>
                <div class="zen-filter-checkbox-fields">
                        <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input  <?=($type==='any') ? 'checked' : ''?> class="zen-checkboxfield-element" name="e[type]" value="any" type="radio">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                        Any
                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                        <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input <?=($type==='Hotel') ? 'checked' : ''?> class="zen-checkboxfield-element" name="e[type]" value="Hotel" type="radio">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                        Hotel
                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                        <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input <?=($type==='Hostel') ? 'checked' : ''?> class="zen-checkboxfield-element" name="e[type]" value="Hostel" type="radio">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                        Hostel
                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                        <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" <?=($type==='Apartments') ? 'checked' : ''?> value="Apartments" name="e[type]" type="radio">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                        Apartments
                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                      
                      
                         <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" <?=($type==='Motel') ? 'checked' : ''?> value="Motel" name="e[type]" type="radio">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                        Motel
                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                          <!--<div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" <//?=($type==='Resorts') ? 'checked' : ''?> value="Resorts" name="e[type]" type="radio">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                        Resorts
                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>-->
                      
                </div>
        </div>
</div>


<!-----------------------  ------------------------>
<div class="zen-hotels-filter zen-hotels-filter-estatetypes" style="display: none;">
        <div class="zen-filter zen-filter-estatetypes">
                <div class="zen-filter-title zen-filter-estatetypes-title">
               	Amenity 
                </div>
                <div class="zen-filter-checkbox-fields">
                       <!----------------------- 11 ------------------------>
                       <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="NonSmokingRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Non smoking rooms                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Parking" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Parking                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="CoffeeTeaMaker" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Tea and Coffee maker                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Safe" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Safe                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="AirConditioning" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Air conditioning                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="HairDryer" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Hair dryer                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SatelliteTV" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Satellite TV                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="AirConditionedRooms" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Air-conditioned rooms                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="RadioInRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Radio in room                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="MiniBarInRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Mini-bar                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="BreakfastRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Breakfast room                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="InHouseDining" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Hotel restaurant                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="InHouseBar" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Hotel bar                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="MeetingRooms" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Meeting rooms                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="RoomService" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Room service                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="HotelSafe" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Central hotel safe                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="TrouserPress" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Trouser press                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="FitnessFacility" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Fitness facility                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="HandicapAccessible" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Handicap accessible                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="DataPorts" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Data ports                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="BusinessCenter" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Business center                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Restaurant" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Restaurant                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="LaundryService" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Laundry service                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SwimmingPool" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Swimming pool                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Golf" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Golf                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="HighSpeedInternet" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       High Speed Internet                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="BeautyShop" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Beauty Shop                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="TeaCoffeeMaker" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Tea / Coffee Maker                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="ConferenceRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Conference Room                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Gym" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Fitness room / Gym                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Concierge" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Concierge                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Spa" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Spa                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="WheelchairService" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Wheelchair Service                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="WiFi" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Wi-Fi                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="FreeOnSiteCarparking" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Free On - Site Car parking                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="TennisCourt" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Tennis court                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="OutdoorPool" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Outdoor swimming pool                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Bar" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Bar                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SpecialSpaPackages" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Special Spa Packages                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Doctoroncall" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Doctor on call                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="ContinentalBreakfast" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Contintenal breakfast                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Sauna" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Sauna                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="ClothingIron" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Clothing iron                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="WakeUpService" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Wake up service                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="CarRentDesk" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Car rental desk                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Kitchen" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Kitchen                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="CoffeeShop" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Coffee shop                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SteamBath" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Steam Bath                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Shower" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Shower                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Bath" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Bath                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Freenewspaper" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Free Newspaper                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Icemachine" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Ice Machine                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Giftshop" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Gift Shop                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="MeetingBanquetFacilities" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Meeting / Banquet Facilities                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="TV" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       TeleVision                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="CurrencyExchangeService" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Currency Exchange Service                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="ChildrensClub" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Childrens Club                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Medical centre" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Medical centre                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Scuba Diving" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Scuba Diving                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="24HourFrontDesk" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       24 Hour Front Desk                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Elevators" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Elevators                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="WheelchairAccess" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Wheelchair access                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="TourDesk" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Tour Desk                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="AirportTransportation" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Airport transportation                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Casino" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Casino                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="NightClub" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Night Club                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="PetsAllowed" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Pets allowed                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="ValetParking" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Valet parking                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="GameRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       GameRoom                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="VIPSecurity" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       VIP Security                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="ATMMachine" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       ATM Machine                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Shops" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Shops                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Porters" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Porters                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="IndoorPool" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Indoor swimming pool                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Babysitter" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Babysitter                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="InRoomMovies" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       In-room movies                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="VideoCheckout" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Video check-out facility                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Security24Hour" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       24-hour security                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Playground" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Playground                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="HeatedPool" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Heated Pool                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Fishing" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Fishing                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="JoggingTrack" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Jogging Track                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="MultilingualStaff" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Multilingual Staff                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="RoomCentralHeating" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Central heating in room                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="FamilyRooms" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Family rooms                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="PublicInternetAccess" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Public internet access                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="CarPark" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Car parking                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="AirConditioned" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Air-conditioned                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="ReceptionArea" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Reception Area                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="CheckIn24hr" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       24hr. CheckIn                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Reception24hr" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       24hr. Reception                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Lift" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Lift                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Supermarket" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Supermarket                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="RestaurantAirconditioned" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Restaurant Air-Conditioned                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="RestaurantNonSmokingArea" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Restaurant - non-smoking area                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="MobilePhoneNetwork" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Mobile Phone Network                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="WLANAccessPoint" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       WLAN Access Point                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="MedicalService" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Medical Service                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Massage" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Massage                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="RoomPrivateBathroom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Private bathrooms                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="InternetAccess" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       InternetAccess                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="KingSizeBeds" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       KingSizeBeds                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="IndividualAirCondition" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       IndividualAirCondition                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Balcony" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Balcony                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Fridge" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Fridge                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="TVInRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       TV in room                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="MiniFridge" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       MiniFridge                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="BathRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Bath Room                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="MoneyExchange" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Money exchange                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="RestaurantSmokingArea" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Restaurant Smoking Area                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SunLounge" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       SunLounge                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="RoomTerraceBalcony" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Terrace or balcony                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Launderette" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Launderette                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="WheelchairAccessible" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Wheelchair Accessible                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Cafe(s)" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Cafe(s)                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Restaurants" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Restaurants                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="DiningRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Dining Room                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Garage" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Garage                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="HiFiStereoSystem" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       HiFiStereoSystem                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Carpeted" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Carpeted                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="TelephoneInRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Direct Dial Telephone                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Hairdresser" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Hairdresser                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Pub" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Pub                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="DiscoClub" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Disco / Club                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Theatre" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Theatre                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="CloakRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Cloak Room                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SunBathingTerrace" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Sun Bathing Terrace                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Lounge" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Lounge                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Whirlpool" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Whirlpool                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="TVRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       TV Room                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="BicycleStorage" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Bicycle Storage                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SaltWaterPool" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Salt Water Pool                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="ChildrenPool" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Children's pool                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Heating" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Heating                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Parasol" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Parasol                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="NumberOfPool" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Number Of Pool                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="MiniClub" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Mini Club                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="FreshWaterPool" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Fresh Water Pool                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="BicycleRental" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Bicycle Rental                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Sun roof solarium" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Sun roof solarium                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="BarLounge" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Bar/Lounge                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SelfLaundry" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Self Laundry                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="ValetLaundry" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Valet Laundry                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="RestuarantHighChair" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Restuarant High Chair                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="DoubleBeds" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Double Beds                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="TanningStudio" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Tanning Studio                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Jacuzzi" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Jacuzzi                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SafetyBox" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Safety Box                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="LuggageService" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Luggage Service                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Tours" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Tours                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Reception24Hour" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       24 hour reception                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Lobby" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Lobby                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Shop" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Shop                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SnackBar" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Snack Bar                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Hottub" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Hot Tub                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="GolfCourse" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Golf course                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Housekeeping" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Housekeeping                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Kidspool" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Kids Pool                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="TeenClub" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Teen Club                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Salon" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Salon                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="GamesRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Games room                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="RoomToiletries" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Room Toiletries                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="RoomSlippers" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Room Slippers                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="*FB plus" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       *FB plus                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="HotelPetsNotAllowed" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Hotel Pets NotAllowed                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Room220V" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Room 220V                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="ShuttleServices" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Shuttle Services                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SecurityGuards" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Security Guards                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SquashCourt" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Squash Court                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="OnSiteBeach" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       On-Site Beach                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="WaterSports" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       WaterSports                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="ComplimentaryBreakfast" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Complimentary Breakfast                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Library" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Library                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Hammam" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Hammam                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Treadmills" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Treadmills                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Aerobic" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Aerobic                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="SmokingRoom" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Smoking rooms                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="FitnessProgramme" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Fitness Programme                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="Cinema" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Cinema                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="24hrsReception" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       24hrs Reception                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>
                            <div class="zen-filter-checkbox-field">
                                <div class="zen-checkboxfield">
                                        <label class="zen-checkboxfield-wrapper">
                                                <input class="zen-checkboxfield-element" name="amenity[]" value="DryCleaning" type="checkbox">
                                                <div class="zen-checkboxfield-styled-checkbox">
                                                </div>
                                                <span class="zen-checkboxfield-text">
                                                       Dry cleaning service                                                       
                                                </span>
                                        </label>
                                </div>
                        </div>

                         <!----------------------- 11 ------------------------>
                      
                </div>
        </div>
</div>
<!-----------------------  ------------------------>
 </div><!--zen-hotels-filters-->
 </form>
  </aside>
  
  
  <!----------------------- Основное содержание ------------------------>
  <section class="zen-hotels-main-content">



<div class="zen-hotels-list-wrapper">
 <div class="zen-hotels-list-inner">
  <div class="zen-hotels-list">
   <div class="hotels">
   <div class="hotels-inner">

  <?php echo html::hotel_list($xml_test, $this->data, $this->region); ?>

</div></div></div></div></div> 
 
  </section> 
 </div><!--zen-hotels-content-->

<!-- modal -->

<?php 
$data = $this->data;
include(JPATH_SITE."/components/com_travel/helpers/html/modal_find.php");
?>
 <script src="<?php echo JURI::root()?>components/com_travel/js/main.js" type="text/javascript"></script>
     
 

