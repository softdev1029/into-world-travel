<?php
// require('ipg-util.php');
date_default_timezone_set(date_default_timezone_get());

class html 
{
       static public function getDateTime() {
                // global $dateTime;
                return date("Y:m:d-H:i:s");
        }


        static public function createHash($chargetotal, $currency) {
                // Please change the store Id to your individual Store ID
                $storeId = "1109688446";
                // NOTE: Please DO NOT hardcode the secret in that script. For example read it from a database.
                $sharedSecret = "dC^sf*36iM";
                $stringToHash = $storeId . self::getDateTime() . $chargetotal . $currency . $sharedSecret;
                $ascii = bin2hex($stringToHash);
                return hash("sha256", $ascii);
        }

    
     static public function getPersona_modif($dop, $data){
        ?>
        <div class="selector_gast selectro_person<?=$dop?>">
 
 <div class="zen-guestsbutton-button ">
 <div class="zen-guestsbutton-button-arrow"></div>
 <div class="zen-guestsbutton-button-rooms"><?=($dop) ? '2' : '1'?> room for</div>
 <div class="zen-guestsbutton-button-guests zen-guestsbutton-button-guests<?=$dop?>">2 guests</div>
 </div>


 <div class="zen-guestsbutton-popup">
  <div class="zen-guests">
   <div class="zen-guests-rooms">
    <!-----------------------  ------------------------>
    <div class="zen-guest-room">
    <div class="zen-guests-room-wrapper">
      
      <div class="zen-guests-room">
      <div class="zen-guests-room-field">
      <div class="zen-guests-room-adults">
      <div class="zen-guests-room-title">Adults</div>
      
      
      <div class="zen-guests-control">
      
       
      <div class="zen-select-button">
      <select name="e[mann<?=$dop?>]" id="mann<?=$dop?>" class="zen-select-native" style="width: 100px;">
       
        <?php
      $option = array();
      
      $option[0]='0';
      $option[1]='1';
      $option[2]='2';
      $option[3]='3';
      $option[4]='4';
      $option[5]='5';
     echo JHtml::_('select.options',  html::create_select_option($option) , 'value', 'text', $data['mann'.$dop], true);
      ?>
      
      </select></div>
      
     
      
      </div>
      
      
      </div>
      
      <div class="zen-guests-room-children">
      <div class="zen-guests-room-title">Children</div>
      
      <div class="zen-guests-control">
       
      
      <div class="zen-select-button">
      
      <select name="e[kind<?=$dop?>]" id="kind<?=$dop?>" class="zen-select-native" style="width: 100px;">
      <?php
      $option = array();
      
      $option[0]='0';
      $option[1]='1';
      $option[2]='2';
      $option[3]='3';
      $option[4]='4';
     echo JHtml::_('select.options',  html::create_select_option($option) , 'value', 'text', $data['kind'.$dop], true);
      ?>
     
      </select>
      
      </div>
      
      </div>
      </div>
      
      
      </div></div>
      
      
      <div class="zen-guests-ages zen-guests-ages<?=$dop?>"  >
      <div class="zen-guests-ages-title">Children's age</div>
      
      <div class="zen-guests-room-field">
     
      <div class="zen-guests-age zen-guests-age<?=$dop?>">
      <div class="zen-guests-room-control">
     
      <div class="zen-select-button">
      <select name="e[age1<?=$dop?>]" id="age1<?=$dop?>" class="zen-select-native" style="width:60px">
      
      
         <?php
      $option = array();
      
      $option[0]='0';
      $option[1]='1';
      $option[2]='2';
      $option[3]='3';
      $option[4]='4';
      $option[5]='5';
      $option[6]='6';
      $option[7]='7';
      $option[8]='8';
      $option[9]='9';
      $option[10]='10';
      $option[11]='11';
      $option[12]='12';
      $option[13]='13';
      $option[14]='14';
      $option[15]='15';
      $option[16]='16';
      $option[17]='17';
     echo JHtml::_('select.options',  html::create_select_option($option) , 'value', 'text', $data['age1'.$dop], true);
      ?>
    </select>  </div>
    
      
      
      </div></div><!--zen-guests-age-->
      
   <div class="zen-guests-age zen-guests-age<?=$dop?>">
      <div class="zen-guests-room-control">
     
      <div class="zen-select-button">
      <select name="e[age2<?=$dop?>]" id="age2<?=$dop?>" class="zen-select-native" style="width:60px">
       <?php
         echo JHtml::_('select.options',  html::create_select_option($option) , 'value', 'text', $data['age2'.$dop], true);
      ?>
       </select></div> 
      
      
      </div></div><!--zen-guests-age-->
      
      <div class="zen-guests-age zen-guests-age<?=$dop?>">
      <div class="zen-guests-room-control">
     
      <div class="zen-select-button">
      <select name="e[age3<?=$dop?>]" id="age3<?=$dop?>" class="zen-select-native" style="width:60px">
     <?php
         echo JHtml::_('select.options',  html::create_select_option($option) , 'value', 'text', $data['age3'.$dop], true);
      ?></select></div> 
      
      
      </div></div><!--zen-guests-age-->
      
      <div class="zen-guests-age zen-guests-age<?=$dop?>">
      <div class="zen-guests-room-control">
     
      <div class="zen-select-button">
      <select name="e[age4<?=$dop?>]" id="age4<?=$dop?>" class="zen-select-native" style="width:60px">
      <?php
         echo JHtml::_('select.options',  html::create_select_option($option) , 'value', 'text', $data['age4'.$dop], true);
      ?></select></div> 
      
      
      </div></div><!--zen-guests-age-->
      
      
      </div>
      
      </div></div></div>
    <!-----------------------  ------------------------>
    
   </div>
  </div>
 </div>

</div>
        <?php
        }
     
    
     static public function get_Persona($dop = ''){
        ?>
        <div class="selector_gast" id="selectro_person<?=$dop?>">
 

 <div class="zen-guestsbutton-button ">
 <div class="zen-guestsbutton-button-arrow"></div>
 <div class="zen-guestsbutton-button-rooms"> <?=($dop) ? '2' : '1'?> room for</div>
 <div class="zen-guestsbutton-button-guests zen-guestsbutton-button-guests<?=$dop?>">2 guests</div>
 </div>


 <div class="zen-guestsbutton-popup">
  <div class="zen-guests">
   <div class="zen-guests-rooms">
    <!-----------------------  ------------------------>
    <div class="zen-guest-room">
    <div class="zen-guests-room-wrapper">
      
      <div class="zen-guests-room">
      <div class="zen-guests-room-field">
      <div class="zen-guests-room-adults">
      <div class="zen-guests-room-title">Adults</div>
      
      
      <div class="zen-guests-control">
      
       
      <div class="zen-select-button">
      <select name="e[mann<?=$dop?>]" id="mann<?=$dop?>" class="zen-select-native" style="width: 100px;">
      
      <option value="1" >1</option>
      <option value="2"  selected="selected">2</option>
      <option value="3">3</option>
      <option value="4">4</option><option value="5">5</option>
      
      </select></div>
      
     
      
      </div>
      
      
      </div>
      
      <div class="zen-guests-room-children">
      <div class="zen-guests-room-title">Children</div>
      
      <div class="zen-guests-control">
       
      
      <div class="zen-select-button">
      
      <select name="e[kind<?=$dop?>]" id="kind<?=$dop?>" class="zen-select-native" style="width: 100px;">
      <option value="0" selected="selected">0</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      </select>
      
      </div>
      
      </div>
      </div>
      
      
      </div></div>
      
      
      <div class="zen-guests-ages zen-guests-ages<?=$dop?>">
      <div class="zen-guests-ages-title">Children's age</div>
      
      <div class="zen-guests-room-field">
     
      <div class="zen-guests-age zen-guests-age<?=$dop?>">
      <div class="zen-guests-room-control">
     
      <div class="zen-select-button">
      <select name="e[age1<?=$dop?>]" id="age1<?=$dop?>" class="zen-select-native" style="width:60px">
      <option value="0" selected="selected">0</option>
      <option value="1">1</option><option value="2">2</option>
      <option value="3">3</option><option value="4">4</option>
      <option value="5">5</option><option value="6">6</option>
      <option value="7">7</option><option value="8">8</option>
      <option value="9">9</option><option value="10">10</option>
      <option value="11">11</option><option value="12">12</option>
      <option value="13">13</option><option value="14">14</option>
      <option value="15">15</option><option value="16">16</option>
      <option value="17">17</option></select></div> 
      
      
      </div></div><!--zen-guests-age-->
      
   <div class="zen-guests-age zen-guests-age<?=$dop?>">
      <div class="zen-guests-room-control">
     
      <div class="zen-select-button">
      <select name="e[age2<?=$dop?>]" id="age2<?=$dop?>" class="zen-select-native" style="width:60px">
      <option value="0" selected="selected">0</option>
      <option value="1">1</option><option value="2">2</option>
      <option value="3">3</option><option value="4">4</option>
      <option value="5">5</option><option value="6">6</option>
      <option value="7">7</option><option value="8">8</option>
      <option value="9">9</option><option value="10">10</option>
      <option value="11">11</option><option value="12">12</option>
      <option value="13">13</option><option value="14">14</option>
      <option value="15">15</option><option value="16">16</option>
      <option value="17">17</option></select></div> 
      
      
      </div></div><!--zen-guests-age-->
      
      <div class="zen-guests-age zen-guests-age<?=$dop?>">
      <div class="zen-guests-room-control">
     
      <div class="zen-select-button">
      <select name="e[age3<?=$dop?>]" id="age3<?=$dop?>" class="zen-select-native" style="width:60px">
      <option value="0" selected="selected">0</option>
      <option value="1">1</option><option value="2">2</option>
      <option value="3">3</option><option value="4">4</option>
      <option value="5">5</option><option value="6">6</option>
      <option value="7">7</option><option value="8">8</option>
      <option value="9">9</option><option value="10">10</option>
      <option value="11">11</option><option value="12">12</option>
      <option value="13">13</option><option value="14">14</option>
      <option value="15">15</option><option value="16">16</option>
      <option value="17">17</option></select></div> 
      
      
      </div></div><!--zen-guests-age-->
      
      <div class="zen-guests-age zen-guests-age<?=$dop?>">
      <div class="zen-guests-room-control">
     
      <div class="zen-select-button">
      <select name="e[age4<?=$dop?>]" id="age4<?=$dop?>" class="zen-select-native" style="width:60px">
      <option value="0" selected="selected">0</option>
      <option value="1">1</option><option value="2">2</option>
      <option value="3">3</option><option value="4">4</option>
      <option value="5">5</option><option value="6">6</option>
      <option value="7">7</option><option value="8">8</option>
      <option value="9">9</option><option value="10">10</option>
      <option value="11">11</option><option value="12">12</option>
      <option value="13">13</option><option value="14">14</option>
      <option value="15">15</option><option value="16">16</option>
      <option value="17">17</option></select></div> 
      
      
      </div></div><!--zen-guests-age-->
      
      
      </div>
      
      </div></div></div>
    <!-----------------------  ------------------------>
    
   </div>
  </div>
 </div>

</div>
        <?php
     }
      
     
      static public function srav_xml(
      
      $Booking_xml, 
      $Booking_xml2, 
      $rooms=0, 
      $dd  = 0){
        
        //Сравниваем
        $is_true = true;
         
         $HotelBooking =$Booking_xml->Booking->HotelBooking;
         $HotelBookings = $HotelBooking;
         
         $HotelBooking2 =$Booking_xml2->Booking->HotelBooking;
         $HotelBookings2 = $HotelBooking;
         
         
          $HotelBooking = $HotelBooking[$rooms];
          $HotelBooking2 = $HotelBooking2[$rooms];
          
    if ($HotelBooking->Room->NightCost->SellingPrice['amt']!=$HotelBooking2->Room->NightCost->SellingPrice['amt'])      
    $is_true = false;
    if ($HotelBooking->Room->CanxFees->Fee->Amount['amt']!=
    $HotelBooking2->Room->CanxFees->Fee->Amount['amt'])      
    $is_true = false;
         
         return $is_true; 
      }
      
     
     static public function getInfoBroon(
     $Booking_xml,$row, $rooms=0, $dd  = 0 , $total_end = 0, $paymentSuccessURL = '', $paymentFailURL = ''){
         
    
    $HotelBooking =$Booking_xml->Booking->HotelBooking;
    $HotelBookings = $HotelBooking;
    //$roms = count($HotelBooking); 
 
 
   ob_start();
 
 
    ?>
     <h2>Confirm</h2>
     <div class="zen-booking-bill-rooms">
     
      <?php
      
	 
        echo "<h2>Rooms ".($rooms+1)."</h2>";
        $HotelBooking = $HotelBooking[$rooms]; 
		$total_seling_price  =0;
        $total_seling_price = trim($HotelBooking->TotalSellingPrice['amt']);
      
  html::htmlInfo('ID ',trim($HotelBooking->Id));
  html::htmlInfo('Currency',travel::Currency()); 
  
   
 
  html::htmlInfo('CreationDate', date('M-d-Y',strtotime(trim($Booking_xml->Booking->CreationDate))) );
 
    
  html::htmlInfo('Hotel Name',trim($HotelBooking->HotelName));
  //html::htmlInfo('Arrival Date',trim($HotelBooking->ArrivalDate));
  html::htmlInfo('Arrival Date',date('M-d-Y',strtotime(trim(trim($HotelBooking->ArrivalDate)))) );
  html::htmlInfo('Nights',trim($HotelBooking->Nights));
  
  html::line();
  
  html::htmlInfo('<span style="    font-size: 22px;">Room</span>','');
 // html::htmlInfo('Room Night Cost ', 'Selling Price '.travel::pr1($HotelBooking->Room->NightCost->SellingPrice['amt'], $row), 'Night '.$HotelBooking->Room->NightCost->Night); 
  html::htmlInfo('Room Night Cost ', 'Selling Price '.travel::pr1($total_seling_price, $row), 'Night '.travel::pr1($total_seling_price, $row)); 
  html::htmlInfo('Room Type',trim($HotelBooking->Room->RoomType['text']));
  html::htmlInfo('Meal Type',trim($HotelBooking->Room->MealType['text']));
  html::line();
  
  html::htmlInfo('<span style="    font-size: 22px;">Guests</span>','');
  $Guests = $HotelBooking->Room->Guests;
  $n = 1;
  foreach ( $HotelBooking->Room->Guests->Adult as  $Adult)
  {
 
   html::htmlInfo(($n).' Adult ',travel::pr1($Adult->Price['amt'], $row) , $Adult['title'].' '.$Adult['first'].' '.$Adult['last']);
  $n++;
  }  $n = 1;
   foreach ( $HotelBooking->Room->Guests->Child as  $Adult)
  {
 
   html::htmlInfo(($n).' Child ('.$Adult['age'].' years)', travel::pr1($Adult->Price['amt'], $row), $Adult['title'].' '.$Adult['first'].' '.$Adult['last']);
  $n++;
  }
  
  //print_R($HotelBooking->Room->CanxFees);
  

 //Количество fee
   $count_fee = count($HotelBooking->Room->CanxFees->Fee); 
   
    $html_fee = array();
    $fees  = array();
    $max = 0;
    foreach ($HotelBooking->Room->CanxFees->Fee as $g=>$fee )
    {
        $r  =array();
        
        $r['data'] = isset($fee['from']) ? trim($fee['from']) : '';
        $r['amt'] = trim($fee->Amount['amt']);
        if ($max<$r['amt'] )$max =$r['amt'];
        $fees[] = $r;
    } 
 
 $price = '';
 //Перебираем
  
  foreach ($fees as $k=>$fee)
  {
    $d = '';
    if ($fee['data'])
    $d = strtotime($fee['data']);
    //первый вариант
    //Есть дата
    if ( $fee['data']){
       
       //Первый 
       if($k==0){
      $mk = mktime(0,0,0,date('m',$d),date('d',$d)-1,date('Y',$d));
      $html_fee[] = 'Until '.date('Y-m-d',$mk).' you cancel free of charge ';
       }
    
    
    
      if (isset($fees[$k+1]) &&  $fees[$k+1]['amt']!=$fee['amt'])
   {
    $d1 = strtotime($fees[$k+1]['data']);
    $html_fee[] = 'From '.date('Y-m-d',$d).' to '.date('Y-m-d',$d1).' cancelation charge will be '.travel::pr1($fee['amt'], $row);
   }
   elseif ($price!=$fee['amt'])
   {  
    
    $html_fee[] = 'From '.date('Y-m-d',$d).' cancelation charge will be '.travel::pr1($fee['amt'], $row);
   }
    
      }
      //Если даты нет
      else{
        
        
         $html_fee[] =   travel::pr1($max, $row);
         
         if ($max==$total_seling_price)
         $html_fee[] = "(non-refundable)";
      break;
      } 
     
     
     
     $price = $fee['amt'];
  }
 
 
 
// if ($count_fee==1)
   html::htmlInfo('Cancellation Fee ', implode('<br/>',$html_fee), $row);
 // else
  //{
   
     
    
   
   
    
   
      // if (isset($fee['from']))
//    {
//       $d =strtotime($fee['from']." 00:00:00");
//        
//        //1 = До этого числа беслпатно
//        if ($n==0){
//         $mk = mktime(0,0,0,date('m',$d),date('d',$d)-1,date('Y',$d));
//         $html_fee[] = 'Until ' .date('Y-m-d',$mk).' you cancel free of charge';
//        }
//        
//        
//        else
//        {
//             
//                
//            $d =strtotime($HotelBooking->Room->CanxFees->Fee[$g+1]." 00:00:00"); 
//            $d1 =strtotime($fee['from']." 00:00:00"); 
//            $html_fee[] = 'From '.date('Y-m-d',$d).' to '.date('Y-m-d',$d1).' cancelation charge will be '.travel::pr($fee->Amount['amt'], $row);
//            
//           // }
////            else
////            {
////                  $html_fee[] = 'From  date('Y-m-d',$d1).' cancelation charge will be '.travel::pr($fee->Amount['amt'], $row);
////          
////            }
//            
//        }
//        
//        
//    }
//   
//  
//  
//From 2019-02-10 cancelation charge will be 430
//
//$n++;
//
//   }
    
   
  
  html::htmlInfo('Messages ',$HotelBooking->Room->Messages->Message->Type,$HotelBooking->Room->Messages->Message->Text);
    
    
 
  
  ?>
          
     </div>
     
      <div class="zen-booking-bill-total">
         
          <div class="zen-booking-bill-total-wrapper">
          <?php
           html::htmlInfo_price('Total Selling Price',travel::pr1( $total_seling_price , $row));
          if ($total_end)
          {
           html::htmlInfo_price('Total order',travel::pr1( $total_end , $row));
         
          }
          
           ?>
          
          </div>
          </div>
          <?php if ($rooms==$dd): 
		  
		  //$total_seling_price = travel::convertPricevalue( $total_seling_price , $row); 
		  // $total_seling_price =0.10;   
		  ?>
     <div class="zen-booking-stepbar-wrapper">
  <div class="zen-booking-stepbar" style="text-align: center;">
<?php //echo travel::currencycode() ?>

<form method="post" action="https://www.ipg-online.com/connect/gateway/processing">
<input type="hidden" name="txntype" value="sale"/>
<input type="hidden" name="timezone" value="<?php print date_default_timezone_get(); ?>"/>
<input type="hidden" name="txndatetime" value="<?php echo html::getDateTime() ?>"/>
<input type="hidden" name="hash_algorithm" value="SHA256"/>
<input type="hidden" name="hash" value="<?php echo html::createHash($total_seling_price, "826") ?>"/>
<input type="hidden" name="storename" value="1109688446"/>
<input type="hidden" name="mode" value="payonly"/>
<input type="hidden" name="paymentMethod" value="M"/>
<input type="hidden" name="chargetotal" value="<?php print $total_seling_price; ?>"/>
<input type="hidden" name="responseSuccessURL" value="<?php print $paymentSuccessURL; ?>" />
<input type="hidden" name="responseFailURL" value="<?php print $paymentFailURL; ?>" />
<input type="hidden" name="currency" value="826"/>

<div data-id="1" id="click_conf123" class="zen-booking-stepbar-continue1231" ><input type="submit" class="zen-booking-stepbar-continue" style="border:none;" value="Confirm"></div>

</form>


  
  
   
   </div>
   </div>
   
   <?php  
   endif; 
   
       $var = ob_get_contents();
  ob_end_clean();  
        return $var;
     }
     
    
     static public function htmlInfo_price($title, $value){
     ?>
     <div class="zen-booking-bill-total-price clearfix">
              <div class="zen-booking-bill-total-price-title">
               <?=$title?>
              </div>
              <div class="zen-booking-bill-total-price-value">
               <?=$value?>              </div>
            </div>
     <?php
     }
     static public function line(){
     ?>
     <div style="    border-top: 1px solid #dadbdc;
    margin: 10px 0;"></div>
     <?php
     }
     static public function htmlInfo($title, $value, $dop=''){
     ?>
     <div class="zen-booking-bill-room">
            <div class="zen-booking-bill-room-info">
              <div class="zen-booking-bill-room-name">
              <?=trim($title)?>
              </div>
              <?php if ($dop): ?>
              <div class="zen-booking-bill-room-guests">
                <?=trim($dop)?>           
                 </div>
              <?php endif; ?>
              
             </div>
            <div class="zen-booking-bill-room-price">
              <div class="zen-booking-bill-room-price-value" data-custom="Price separate">
                <?=trim($value)?> 
                 </div>
            </div>
          </div>
     <?php
     }
    
    //Смотрите также
     static public function hotel_list_review($xml_test, 
     $data_send = null, $ignore=0){
		 
		  
        
     $data_req = JRequest::getVar('e');   
     $start = travel::strtotimed($data_req['data_start']);
     $end = travel::strtotimed($data_req['data_end']);
     $day = xml::time_text($start, $end); 
     $db=JFactory::getDBO();
     
          $rows = array();
      foreach ($xml_test->HotelAvailability as $Availability){
      $hotel = $Availability->Hotel;
       if ($hotel['id']==$ignore) continue;
      
      $rows[]=$Availability;
      }
      shuffle($rows);
      $HotelAvailability = array_slice($rows, 0, 9);
     
      foreach ($HotelAvailability as $Availability){
      $hotel = $Availability->Hotel;
      $price =array();
   
       //Получаем комнаты 
  foreach ($Availability->Result as $result)
  {
    
   //Атрибуты комнаты 
   $attr = array();
   foreach($result->attributes() as $a => $b)
   $attr[trim($a)]=trim($b);
  
   $room_type = array();
   foreach($result->Room->RoomType->attributes() as $a => $b)
   $room_type[trim($a)]=trim($b);
   
   
   
   $room_mealtype = array();
   if (isset($result->Room->MealType))
   foreach($result->Room->MealType->attributes() as $a => $b)
   $room_mealtype[trim($a)]=trim($b);
   
   $pric = array();
   foreach($result->Room->Price->attributes() as $a => $b)
   $pric[trim($a)]=trim($b);
    
    //Все цены  
  $price[] = ($pric['amt']);  
    
    break;
  }
  
   $data = array();
   foreach($hotel->attributes() as $a => $b)
   $data[trim($a)]=trim($b);
  /*
    $q = 'SELECT * FROM #__travel_otel WHERE vid='.(int)$data['id'];
    $db->setQuery($q);
    $row = $db->LoadObject();
	
	*/
	 $data_send['otel'] = $data_send['id'];
        $data_send['DetailLevel'] = 'full';
        $rowe =  xml::send_to_xml ($data_send, 1); 
        $xml_test = simplexml_load_string($rowe);
        
         $Availability2 = $xml_test->HotelAvailability;
        
		$hotel2 = $Availability2->Hotel;  
		//echo '<pre>';
		//print_r($xml_test);  
		//exit; 
		  $region2 = $hotel2->Region;
        //echo 'vid'.trim($hotel2['id']); 
		  
		 $data2 = array();
		 $data2['vid'] = trim($hotel2['id']);
		 $data2['title'] = trim($hotel2['name']);
		 $data2['region_name'] = trim($region2['name']);
		 $data2['region_id'] = trim($hotel2['id']);
		 $data2['cityId'] = trim($hotel2->Region->CityId);
		 $data2['stars'] = trim($hotel2['stars']);   
		 $data2['type'] = trim($hotel2['type']);	
		 $data2['latitude'] = trim($hotel2->GeneralInfo->Latitude);   
		 $data2['longitude'] = trim($hotel2->GeneralInfo->Longitude); 
		 $data2['rank'] = trim($hotel2['rank']); 
		 
		 
		 $data2['address'] = array();
		 foreach ($hotel2->Address as $a=>$b)
		 { 
			foreach ($b as $aa=>$bb)
			 $data2['address'][trim($aa)] = trim($bb);
			 
			   
		 
		 }
		   
		 
		  
		 //print_R(trim($xml_test->Address->Address1));
		 $data2['description'] = array();
		 foreach ($hotel2->Description as  $desc)
		 {
		  $data2['description'][trim($desc->Type)] = trim($desc->Text);
		 }
		 

		 
		$data2['amenity'] = array(); 
		 foreach ($hotel2->Amenity  as $r)
		 {
		 
			$data2['amenity'][trim($r->Code)] = trim($r->Text);
		 }
		 
		 $data2['amenity'] = array(); 
		 foreach ($hotel2->Amenity  as $r)
		 {
		 
			$data2['amenity'][trim($r->Code)] = trim($r->Text);
		 }
		 
		 $data2['rating'] = array(); 
		  foreach ($hotel2->Rating  as $a=>$b)
		 {
		 foreach ($b as $aa=>$bb)
			 $data2['rating'][trim($aa)] = trim($bb);
			 
		 }
		  $n=0;
		 $data2['photo'] = array(); 
		  foreach ($hotel2->Photo  as $a=>$b)
		 {
		 foreach ($b as $aa=>$bb)
			 $data2['photo'][$n][trim($aa)] = trim($bb);
		   $n++; 
		 }
		 
		  
		 $data2['photo'] = serialize($data2['photo']);
		 $data2['amenity'] = serialize($data2['amenity']);
		 $data2['description'] = serialize($data2['description']);
		 $data2['address'] = serialize($data2['address']);
		 $data2['rating'] = serialize($data2['rating']); 
		 $data2['published'] =1;
		 

          // $row = $data2; 
          $row = (object) $data2;
	
	
  
  
    if (!$row)
    {  // continue;
       
	    $data_send['otel'] = $data_send['id'];
        $data_send['DetailLevel'] = 'full';
        $rowe =  xml::send_to_xml ($data_send, 1); 
        $xml_test = simplexml_load_string($rowe);
        
         $Availability2 = $xml_test->HotelAvailability;
        
		$hotel2 = $Availability2->Hotel;  
		//echo '<pre>';
		//print_r($xml_test);  
		//exit; 
		  $region2 = $hotel2->Region;
        //echo 'vid'.trim($hotel2['id']); 
		  
		 $data2 = array();
		 $data2['vid'] = trim($hotel2['id']);
		 $data2['title'] = trim($hotel2['name']);
		 $data2['region_name'] = trim($region2['name']);
		 $data2['region_id'] = trim($hotel2['id']);
		 $data2['cityId'] = trim($hotel2->Region->CityId);
		 $data2['stars'] = trim($hotel2['stars']);   
		 $data2['type'] = trim($hotel2['type']);	
		 $data2['latitude'] = trim($hotel2->GeneralInfo->Latitude);   
		 $data2['longitude'] = trim($hotel2->GeneralInfo->Longitude); 
		 $data2['rank'] = trim($hotel2['rank']); 
		 
		 
		 $data2['address'] = array();
		 foreach ($hotel2->Address as $a=>$b)
		 { 
			foreach ($b as $aa=>$bb)
			 $data2['address'][trim($aa)] = trim($bb);
			 
			   
		 
		 }
		   
		 
		  
		 //print_R(trim($xml_test->Address->Address1));
		 $data2['description'] = array();
		 foreach ($hotel2->Description as  $desc)
		 {
		  $data2['description'][trim($desc->Type)] = trim($desc->Text);
		 }
		 

		 
		$data2['amenity'] = array(); 
		 foreach ($hotel2->Amenity  as $r)
		 {
		 
			$data2['amenity'][trim($r->Code)] = trim($r->Text);
		 }
		 
		 $data2['amenity'] = array(); 
		 foreach ($hotel2->Amenity  as $r)
		 {
		 
			$data2['amenity'][trim($r->Code)] = trim($r->Text);
		 }
		 
		 $data2['rating'] = array(); 
		  foreach ($hotel2->Rating  as $a=>$b)
		 {
		 foreach ($b as $aa=>$bb)
			 $data2['rating'][trim($aa)] = trim($bb);
			 
		 }
		  $n=0;
		 $data2['photo'] = array(); 
		  foreach ($hotel2->Photo  as $a=>$b)
		 {
		 foreach ($b as $aa=>$bb)
			 $data2['photo'][$n][trim($aa)] = trim($bb);
		   $n++; 
		 }
		 
		  
		 $data2['photo'] = serialize($data2['photo']);
		 $data2['amenity'] = serialize($data2['amenity']);
		 $data2['description'] = serialize($data2['description']);
		 $data2['address'] = serialize($data2['address']);
		 $data2['rating'] = serialize($data2['rating']); 
		 $data2['published'] =1;
		 

          // $row = $data2; 
          $row = (object) $data2;

		 //travel::store($data2, 'otel'); 
		 //exit; 
	}
  
  
   $d = array();
   $d['e'] = $data_send;
   $link =travel::link('travel', '&id='.$row->id."&".http_build_query($d));
   $photo= unserialize($row->photo);
   
    //echo $photo[0]['Url'];
	
   //echo $f = 'http://www.roomsxmldemo.com'.$photo[0]['Url'];
  // $f = 'http://www.stuba.com/'.$photo[0]['Url']; 
   $f = str_replace('www.roomsxmldemo.com/RXLStagingImages', 'www.stuba.com/RXLImages', $photo[0]['Url']);
   
 
  ?>
  <div class="similarhotels-hotel">
          <div class="div zensimilarhotelcard">
            <a class="zensimilarhotelcard-header" href="<?=$link?>" target="_blank">
              <div class="zensimilarhotelcard-header-rating">
                
                   <?php for ($i=0; $i<$row->stars; $i++): ?>
<div class="zensimilarhotelcard-header-rating-star">
                </div>
       <?php endfor; ?>  
                
             
              </div>
              <div class="zensimilarhotelcard-header-hotelname">
              <?=$data['name']?>
              </div>
            </a>
            <div class="zensimilarhotelcard-body">
              
              <div class="zensimilarhotelcard-body-gallery">
                <div class="zen-mobile-gallery">
                  <a class="zen-mobile-gallery-link" href="<?=$link?>" target="_blank" data-history="replace" data-name="newTab">
                    <img class="zenfittedimage" src="<?=$f?>">
                  </a>
                   
                </div>
              </div>
            </div>
            <a class="zensimilarhotelcard-footer" href="<?=$link?>" target="_blank">
              <div class="zensimilarhotelcard-footer-reviews">
                <div class="zensimilarhotelcard-footer-reviews-tripadvisor-wrapper">
                     
                  <div class="zensimilarhotelcard-footer-reviews-count">
                    
                  </div>
                </div>
              </div>
              <div class="zensimilarhotelcard-footer-value">
                <div class="zensimilarhotelcard-footer-value-price">
                  <?=travel::pr($pric['amt'], $row);?>
                </div>
              </div>
            </a>
          </div>
        </div>
 
  
  <?php
  
  }
     }
    
    //Вывод отеля в списке
    
     static public function hotel_list($xml_test, $data_send = null, $region = null){
   
     $data_req = JRequest::getVar('e');   
     $start = travel::strtotimed($data_req['data_start']);
     $end = travel::strtotimed($data_req['data_end']);
     $day = xml::time_text($start, $end);
     
    $e = 'for '.$day.' nights for '.$data_req['mann'].' adults'.($data_req['kind'] ? ' and '.$data_req['kind'].' children' : '');
    
    $all  = array();
    $alll = array();
     $db=JFactory::getDBO();
     
        $limit =   10;
        $limitstart =    JRequest::getVar('limitstart',0);
    
     ob_start();
 $curr = trim($xml_test->Currency);
 
 
 
 $total = count($xml_test->HotelAvailability);
       //  jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $limitstart, $limit);
        
       $rows = array();
      foreach ($xml_test->HotelAvailability as $Availability)
      $rows[]=$Availability;
        
     $HotelAvailability = array_slice($rows, $pagination->limitstart, $pagination->limit);
        
  
 
  foreach ($HotelAvailability as $Availability){
   $hotel = $Availability->Hotel;
   
   $price =array();
   
   //Получаем комнаты 
  foreach ($Availability->Result as $result)
  {
   
   //Атрибуты комнаты 
   $attr = array();
   foreach($result->attributes() as $a => $b)
   $attr[trim($a)]=trim($b);
   
   
  // $result->Room
  // $result->Room->RoomType
  // $result->Room->MealType
   
   $room_type = array();
   foreach($result->Room->RoomType->attributes() as $a => $b)
   $room_type[trim($a)]=trim($b);
   
   
   
   $room_mealtype = array();
   if (isset($result->Room->MealType))
   foreach($result->Room->MealType->attributes() as $a => $b)
   $room_mealtype[trim($a)]=trim($b);
   
   $pric = array();
   foreach($result->Room->Price->attributes() as $a => $b)
   $pric[trim($a)]=trim($b);
    
	
	
    //Все цены  
  $price[] = ($pric['amt']);  
    
   // break;
  }
  
     $min_price  =0;  
     $min_price = min($price);
//$end_price =end($price);

 
   $data = array();
   foreach($hotel->attributes() as $a => $b)
   $data[trim($a)]=trim($b);
   
  // if ($data['name']==='Apex London Wall'){
   // print_r($result->Room->RoomType);
  // }
   
   //Проверка отеля 
   // $q = 'SELECT * FROM #__travel_otel WHERE vid='.(int)$data['id'];
    //$db->setQuery($q);
    //$row = $db->LoadObject(); 
	    $data_send['otel'] = $data['id'];
        $data_send['DetailLevel'] = 'full';
        $rowe =  xml::send_to_xml ($data_send, 1);
        $xml_test = simplexml_load_string($rowe);
        
         $Availability2 = $xml_test->HotelAvailability;
        
		$hotel2 = $Availability2->Hotel;

 	
		$sub ='Sub';
	///	mail("siddhant.parmar@kcsitglobal.com",$subject, $hotel2 );
	//	mail("siddhant.parmar@kcsitglobal.com",$subject,'Test' );
	//	mail("dpandey@eagletechsolutions.co.uk",$subject, $hotel2 );
		//exit;
		  $region2 = $hotel2->Region;
        //echo 'vid'.trim($hotel2['id']); 
		  
		 $data2 = array();
		 $data2['vid'] = trim($hotel2['id']);
		 $data2['title'] = trim($hotel2['name']);
		 $data2['region_name'] = trim($region2['name']);
		 $data2['region_id'] = trim($hotel2['id']);
		 $data2['cityId'] = trim($hotel2->Region->CityId);
		 $data2['stars'] = trim($hotel2['stars']);   
		 $data2['type'] = trim($hotel2['type']);	
		 $data2['latitude'] = trim($hotel2->GeneralInfo->Latitude);   
		 $data2['longitude'] = trim($hotel2->GeneralInfo->Longitude); 
		 $data2['rank'] = trim($hotel2['rank']); 
		 
		 
		 $data2['address'] = array();
		 foreach ($hotel2->Address as $a=>$b)
		 { 
			foreach ($b as $aa=>$bb)
			 $data2['address'][trim($aa)] = trim($bb);
			 
			   
		 
		 }
		   
		 
		  
		 //print_R(trim($xml_test->Address->Address1));
		 $data2['description'] = array();
		 foreach ($hotel2->Description as  $desc)
		 {
		  $data2['description'][trim($desc->Type)] = trim($desc->Text);
		 }
		 

		 
		$data2['amenity'] = array(); 
		 foreach ($hotel2->Amenity  as $r)
		 {
		 
			$data2['amenity'][trim($r->Code)] = trim($r->Text);
		 }
		 
		 $data2['amenity'] = array(); 
		 foreach ($hotel2->Amenity  as $r)
		 {
		 
			$data2['amenity'][trim($r->Code)] = trim($r->Text);
		 }
		 
		 $data2['rating'] = array(); 
		  foreach ($hotel2->Rating  as $a=>$b)
		 {
		 foreach ($b as $aa=>$bb)
			 $data2['rating'][trim($aa)] = trim($bb);
			 
		 }
		  $n=0;
		 $data2['photo'] = array(); 
		  foreach ($hotel2->Photo  as $a=>$b)
		 {
		 foreach ($b as $aa=>$bb)
			 $data2['photo'][$n][trim($aa)] = trim($bb);
		   $n++; 
		 }
		 
		  
		 $data2['photo'] = serialize($data2['photo']);
		 $data2['amenity'] = serialize($data2['amenity']);
		 $data2['description'] = serialize($data2['description']);
		 $data2['address'] = serialize($data2['address']);
		 $data2['rating'] = serialize($data2['rating']); 
		 $data2['published'] =1;
		 

          // $row = $data2; 
          $row = (object) $data2;
	//echo '<pre>';
	//print_r($row); 
    //Не нашли отеля в базе = Грузим из api 
    if (!$row)
    {  // continue;
       
	    $data_send['otel'] = $data['id'];
        $data_send['DetailLevel'] = 'full';
        $rowe =  xml::send_to_xml ($data_send, 1);
        $xml_test = simplexml_load_string($rowe);
        
         $Availability2 = $xml_test->HotelAvailability;
        
		$hotel2 = $Availability2->Hotel;  
		//echo '<pre>';
		//print_r($xml_test);  
		//exit; 
		  $region2 = $hotel2->Region;
        //echo 'vid'.trim($hotel2['id']); 
		  
		 $data2 = array();
		 $data2['vid'] = trim($hotel2['id']);
		 $data2['title'] = trim($hotel2['name']);
		 $data2['region_name'] = trim($region2['name']);
		 $data2['region_id'] = trim($hotel2['id']);
		 $data2['cityId'] = trim($hotel2->Region->CityId);
		 $data2['stars'] = trim($hotel2['stars']);   
		 $data2['type'] = trim($hotel2['type']);	
		 $data2['latitude'] = trim($hotel2->GeneralInfo->Latitude);   
		 $data2['longitude'] = trim($hotel2->GeneralInfo->Longitude); 
		 $data2['rank'] = trim($hotel2['rank']); 
		 
		 
		 $data2['address'] = array();
		 foreach ($hotel2->Address as $a=>$b)
		 { 
			foreach ($b as $aa=>$bb)
			 $data2['address'][trim($aa)] = trim($bb);
			 
			   
		 
		 }
		   
		 
		  
		 //print_R(trim($xml_test->Address->Address1));
		 $data2['description'] = array();
		 foreach ($hotel2->Description as  $desc)
		 {
		  $data2['description'][trim($desc->Type)] = trim($desc->Text);
		 }
		 

		 
		 $data2['amenity'] = array(); 
         foreach ($hotel2->Amenity  as $r)
		 {
		 
			$data2['amenity'][trim($r->Code)] = trim($r->Text);
		 }
		 
		 $data2['rating'] = array(); 
		  foreach ($hotel2->Rating  as $a=>$b)
		 {
		 foreach ($b as $aa=>$bb)
			 $data2['rating'][trim($aa)] = trim($bb);
			 
		 }
		  $n=0;
		 $data2['photo'] = array(); 
		  foreach ($hotel2->Photo  as $a=>$b)
		 {
		 foreach ($b as $aa=>$bb)
			 $data2['photo'][$n][trim($aa)] = trim($bb);
		   $n++; 
		 }
		 
		  
		 $data2['photo'] = serialize($data2['photo']);
		 $data2['amenity'] = serialize($data2['amenity']);
		 $data2['description'] = serialize($data2['description']);
		 $data2['address'] = serialize($data2['address']);
		 $data2['rating'] = serialize($data2['rating']); 
		 $data2['published'] =1;
		 

          // $row = $data2; 
          $row = (object) $data2;

		 //travel::store($data2, 'otel'); 
		 //exit; 
	}
     
   
  //Для цены отправим  
    $row->region_proc = $row->region_proc_strana = 0;
    if ($region){
    $row->region_proc = $region->proc;
    $row->region_proc_strana = $region->proc_strana;
    }
    
   $photo= unserialize($row->photo);
   
   
   //echo $f = 'http://www.roomsxmldemo.com'.$photo[0]['Url'];
   $f = str_replace('www.roomsxmldemo.com/RXLStagingImages', 'www.stuba.com/RXLImages', $photo[0]['Url']);
   
   //$f = 'http://www.stuba.com/'.$photo[0]['Url']; 
 
   $address= unserialize($row->address);
   $amenity= unserialize($row->amenity);
   $d = array();
   $d['e'] = $data_send;
   
   $link =travel::link('travel', '&room_view=display&id='.$row->id."&".http_build_query($d)); 
 
 foreach ($amenity as $k=>$v)
  {
    
     if (!in_array($k, $all))
     {
        $all[]=$k."=".$v;
        
        
        
        //$alll[]=".zen-hotelcard-content-amenities-multi-list-item-has_".$k."
//{
//     background-image:url(../images/ico/".$k.".png);
//}\n";
     }
  }
 

  ?>
   
<!-----------------------  ------------------------>
  <div class="hotel-wrapper">
        <div class="zen-hotelcard-wrapper">
                <div class="zen-hotelcard zen-hotelcard-wide">
                        <div class="zen-hotelcard-content-wrapper">
                                <div class="zen-hotelcard-content">
                                        <div class="zen-hotelcard-content-main">
                                                <div class="zen-hotelcard-stars">
                                                        <div class="zen-ui-stars">
                                                        <?php 
														//echo '<pre>';
														// print_r($row->stars);  
														//exit;  
														 ?>
                                                        <?php for ($i=0; $i<$row->stars; $i++): ?>
                                                                <div class="zen-ui-stars-wrapper">
                                                                        <div class="zen-ui-stars-star">
                                                                        </div>
                                                                </div>
                                                         <?php endfor; ?>       
                                                               
                                                        </div>
                                                </div>
                                                <h2 class="zen-hotelcard-name">
                                                        <a class="zen-hotelcard-name-link" href="<?=$link?>"
                                                        target="_blank" data-name="newTab"><?=$data['name']?></a>
                                                </h2>
                                                <a class="zen-hotelcard-address" href="<?=$link?>"
                                                target="_blank"><?=$address['Address1']?></a>
                                                <div class="zen-hotelcard-distances">
                                                        
                                                </div>
                                        </div>
                                        <div class="zen-hotelcard-content-rating">
                                                <!--div class="zen-hotelcard-rating-wrapper">
                                                        <div class="zen-hotelcard-rating">
                                                        </div>
                                                </div-->
                                                <ul class="zen-hotelcard-content-amenities-list">
                                                
       
<?php
$n=0;
 foreach ($amenity as $key=>$val): ?>
 <li class="zen-hotelcard-content-amenities-list-item zen-hotelcard-content-amenities-multi-list-item zen-hotelcard-content-amenities-multi-list-item-has_<?=$key?>"
          title="<?=$val?>">
         </li>
 <?php 
 $n++;
 if ($n>7) break;
 endforeach; ?>                                                       
                                                      
                                                </ul>
                                        </div>
                                </div>
                        </div>
                        <div class="zen-hotelcard-gallery-wrapper">
                                
                                <div class="zen-maphotelcard-picks">
                                </div>
                                <div class="zen-hotelcard-gallery">
                                        <div class="zen-mobile-gallery img-vm-tc">
                                                <a class="zen-mobile-gallery-link" custom-src="cc" href="<?=$link?>"
                                                target="_blank" data-history="replace" data-name="newTab">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
   <td><img class="zenfittedimage" src="<?=$f?>"></td>
 </tr>
</table>
                                                </a>
                                                <!--<div class="zen-mobile-gallery-controls">
                                                        
                                                        
                                                       
                                                </div>-->
                                        </div>
                                </div>
                        </div>
                        <div class="zen-hotelcard-rates-wrapper">
                                <div class="zen-hotelcard-rates">
                                        <div class="zen-hotelcard-rate-name">
                                                <div class="zen-hotelcard-rate-name-text">
                                            <?=$room_type['text']?>
                                                </div>
                                                <div class="zen-hotelcard-rate-name-bedding">
                                              
                                                </div>
                                        </div>
                                        <div class="zen-hotelcard-rate-valueadds-wrapper">
                                                <ul class="valueadds valueadds-short">
                                                        <li class="valueadds-item valueadds-item-meal">
                                                                <div class="valueadds-item-title-wrapper">
                                                                        <div class="valueadds-item-title">
                                                                     <?=isset($room_mealtype['text']) ? $room_mealtype['text'] : ''?>
                                                                        </div>
                                                                </div>
                                                        </li>
                                                        <li class="valueadds-item valueadds-item-cancellation">
                                                                <div class="valueadds-item-title-wrapper">
                                                                        <div class="valueadds-item-title">
                                                                               <?=$row->type?>
                                                                        </div>
                                                                </div>
                                                        </li>
                                                       <!-- <li class="valueadds-item valueadds-item-payment">
                                                                <div class="valueadds-item-title-wrapper">
                                                                        <div class="valueadds-item-title">
                                                                                Payment on the site
                                                                        </div>
                                                                </div>
                                                        </li>-->
                                                </ul>
                                        </div>
										<?php 
										 
										//echo '<pre>';
										//print_r($pric);
										//exit;
									   
        
										?>
 
                                        <div class="zen-hotelcard-rate" data-page="list-hote;" data-curruncy="<?=travel::pr1($pric['amt'], $row);?>" > 
                                                <div class="zen-hotelcard-rate-inner">
                                                        <a class="zen-hotelcard-rate-price-wrapper" href="<?=$link?>"
                                                        target="_blank" data-name="newTab"><div class="zen-hotelcard-rate-price">
                                                        
                                                        <div class="zen-hotelcard-rate-price-inner">
                                                        <div class="zen-hotelcard-rate-price-has-value">
                                                        <div class="zen-hotelcard-rate-price-value">
                                                        <span><?=travel::pr1($min_price, $row);?></span>
                                                        </div></div></div>
                                                        <div class="zen-hotelcard-rate-price-notice"><?=$e?></div>
                                                        </div></a>
                                                </div>
                                        </div>
                                </div>
                        </div>
                        <div class="zen-hotelcard-nextstep-wrapper">
                                <div class="zen-hotelcard-nextstep">
                                        <div class="zen-hotelcard-nextstep-text">
                                                <div class="zen-hotelcard-nextstep-label">
                                                </div>
                                        </div>
                                        <a class="zen-hotelcard-nextstep-button" href="<?=$link?>"
                                        target="_blank" data-name="newTab">Select Your Room</a>
                                </div>
                        </div>
                        <div class="zen-hotelcard-metavok-wrapper">
                                <div class="zen-hotelcard-metavok-container" data-id="8623336">
                                        <div class="zen-hotelcard-metavok" id="st-meta-8623336">
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div><!--hotel-wrapper-->
<?php
  }  
  ?>
  <div class="pagination"><?
   echo $pagination->getPagesLinks();
   ?>
   </div>
   
   <?php if (!$total): ?>
   <div style="    background: #efebeb;
    padding: 7px;
    border-radius: 10px;
    color: #230707;">
   Your search did not match any documents. <br/>Try changing search criteria.
   </div>
   <?php endif; ?>
   
 <?php
  
  $var = ob_get_contents();
  ob_end_clean();
 //print_r($all);
   
  return $var;
     }
     
    
    
    
    //Генерация option для select
     static public function create_select_option($array){
         $pgbc = array();
         $n=0;
        foreach ($array as $key=>$value)
        {
        $pgbc[$n]= new stdClass();
        $pgbc[$n]->text =$value;
        $pgbc[$n]->value =$key;
        $n++;
        }
     return $pgbc;
     }
     
    
   //Галерея в отеле 
   static public function gallery(){
   }
   
  
   


}
