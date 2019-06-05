<?php
defined('_JEXEC') or die;
JHtml::_('formbehavior.chosen', 'select');
$id_room = JRequest::getVar('room');
$region = $this->region;
$row = $this->row;



$row->region_proc = $row->region_proc_strana = 0;
if ($region) {
    $row->region_proc = $region->proc;
    $row->region_proc_strana = $region->proc_strana;
}

$data = $this->data;


$user = $this->user = JFactory::getUser();
$address = unserialize($row->address);
$amenity = unserialize($row->amenity);
$description = unserialize($row->description);


$start = travel::strtotimed($data['data_start']);
$end = travel::strtotimed($data['data_end']);
$day = xml::time_text($start, $end);
$this->e = 'for ' . $day . ' nights for ' . $data['mann'] . ' adults' . ($data['kind'] ? ' and ' . $data['kind'] . ' children' : '');

//print_r($address['Address1']);
$data_send = $data;
$data_send['otel'] = $data['otel'];
$data_send['DetailLevel'] = 'full';
$rowe = xml::send_to_xml($data_send, 0);

$xml_test = simplexml_load_string($rowe);
$Availability = $xml_test->HotelAvailability;
$hotel_xml = $Availability->Hotel;
$curr = trim($xml_test->Currency);

//Фото отеля 
$all_foto = xml::fotos($Availability);
//Комнаты
$rooms_price = xml::rooms($Availability);
$RoomImage = $all_foto[0]['ThumbnailUrl'];

$rooms = $rooms_price['rooms'];

$price = $rooms_price['price'];

$room = $rooms[$id_room];

/* echo "<pre>";
print_r($room);
echo $room['attr']['id']; */
$restictionData = array();


    //if(isset($room['cancellationPolicyStatus']) ) {
        if(isset($room['attr'])) {
            if($room['attr']['id'] != "") {
                //Get data when booking status is un-known;
              //$restictionData = xml::getBData($room['attr']['id'], $data['mann']);
            }
        }

    


//echo "<pre>=====================";
//print_r($restictionData->Booking->HotelBooking->Room); 
//exit();

$restrictionPrice = 0;
$fromDate = "";
//$total_seling_price1 =$restictionData->Booking->HotelBooking->Room->TotalSellingPrice->{'@attributes'}->amt;
 $html_fee = array();
    $fees  = array();
    $max = 0;
if(isset($restictionData)):
    if(isset($restictionData->Booking->HotelBooking->Room->CanxFees->Fee)):
	
	
	   foreach ($restictionData->Booking->HotelBooking->Room->CanxFees->Fee as $g=>$fee )
		{
			$r  =array();
			
	
			$r['data'] = isset($fee->{'@attributes'}->from) ? trim($fee->{'@attributes'}->from) : '';
			$r['amt'] = isset($fee->Amount->{'@attributes'}->amt); 
			if ($max<$r['amt'] )
				$max =$r['amt'];
			$fees[] = $r;
		} 
	     /*
        $priceData = $restictionData->Booking->HotelBooking->Room->CanxFees->Fee;
        if(!empty($priceData)) {
            for($i=0;$i<count($priceData);$i++){
                $restrictionPrice = $priceData[$i]->Amount->{'@attributes'}->amt;
                $fromDate = date("m/d/Y", strtotime($priceData[$i]->{'@attributes'}->from));
            }
        } */
    endif;
	
	$count_fee = count($restictionData->Booking->HotelBooking->Room->CanxFees->Fee); 
	
endif;




  
    
 
 
 $price = '';
  
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
         
         if ($max==$total_seling_price1)
         $html_fee[] = "(non-refundable)";
      break;
      }
	  $price = $fee['amt'];
  }

 
$d = array();
$d['e'] = $data;
$link = travel::link('room', '&room=' . $id_room . '&id=' . $row->id . "&" . http_build_query($d));
$return = base64_encode($link);

?>

<link rel="stylesheet" href="<?php echo JURI::root() ?>components/com_travel/css/reserve.css" type="text/css" />

<script src="<?php echo JURI::root() ?>components/com_travel/js/match.js" type="text/javascript"></script>


<div class="zen-roomspage">
    <div class="zen-booking zen-booking-loaded">
        <div class="zen-booking-main">



            <div class="zen-booking-hotelcard-wrapper">
                <div class="zen-booking-hotelcard zen-booking-hotelcard-has-meal">
                    <div class="zen-booking-hotelcard-images">
                        <div class="zen-booking-hotelcard-photo">
                            <div class="zen-roomspageroom-photo">
                                <?php /* ?> <img class="zen-roomspageroom-photo-img" src="http://placehold.it/120x114"> <?php */ ?> 
                                <img class="zen-roomspageroom-photo-img" src="<?php echo $RoomImage; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="zen-booking-hotelcard-info">
                        <div class="zen-booking-hotelcard-stars">

                            <?php for ($i = 0; $i < $row->stars; $i++): ?>
                                <div class="zen-ui-stars-star"></div>
                            <?php endfor; ?> 
                        </div>
                        <div class="zen-booking-hotelcard-name">
                            <?= trim($hotel_xml['name']); ?> 
                        </div>
                        <div class="zen-booking-hotelcard-rate">
                            <?= $room['room_type']['text'] ?>

                        </div>
                    </div>
                    <div class="zen-booking-hotelcard-dates">
                        <div class="zen-booking-hotelcard-checkin">
                            <div class="zen-booking-hotelcard-dates-title">
                                Check in
                            </div>
                            <span class="zen-booking-hotelcard-dates-date">
                                <?= $this->month_start[1] ?> <?= date('d', $this->start) ?> 
                            </span>
                            <span class="zen-booking-hotelcard-dates-time">

                            </span>
                        </div>
                        <div class="zen-booking-hotelcard-checkout">
                            <div class="zen-booking-hotelcard-dates-title">
                                Departure
                            </div>
                            <span class="zen-booking-hotelcard-dates-date">
                                <?= $this->month_end[1] ?> <?= date('d', $this->end) ?>
                            </span>
                            <span class="zen-booking-hotelcard-dates-time">

                            </span>
                        </div>
                    </div>
                    <div class="zen-booking-hotelcard-valueadds">
                        <ul class="valueadds valueadds-expanded">
                            <li class="valueadds-item valueadds-item-has-popuptip valueadds-item-pro valueadds-item-meal">
                                <div class="valueadds-item-title-wrapper">
                                    <div class="valueadds-item-title">
                                        <?= $room['room_mealtype']['text'] ?>

                                    </div>

                                </div>
                                <div class="valueadds-item-description">
                                </div>
                            </li>
                            <li class="valueadds-item valueadds-item-has-popuptip valueadds-item-cancellation">
                                <div class="valueadds-item-title-wrapper">
                                    <div class="valueadds-item-title">
                                        CANCELATION POLICY 
                                    </div>

                                </div>
                                <div class="valueadds-item-description">
                                    <?php // echo travel::cancelPolicy($room['cancellationPolicyStatus'], $startdate, $enddate); ?>
                                    <div class="clearfix">
                                    <?php 
                                    if(isset($restictionData)):
                                        if(isset($restictionData->Booking->HotelBooking->Room->Messages->Message->Text)):
                                    ?>
                                    <p>
                                        <?php echo $restictionData->Booking->HotelBooking->Room->Messages->Message->Text;?>
                                    </p>
                                    <?php 
                                        endif; 
                                    endif;
                                    if($restrictionPrice > 0 ) :
									
									echo implode('<br/>',$html_fee);
                                    ?>
                                   <?php /* ?> <p>Cancel Booking : <?php echo $fromDate;?></p>
                                    <p>Cancel Booking Price : <?= travel::pr1($restrictionPrice, $row); ?></p> <?php */ ?>
                                <?php endif; ?>
                                </div>
                            </li>
                            <li class="valueadds-item valueadds-item-has-popuptip valueadds-item-payment">
                                <div class="valueadds-item-title-wrapper">
                                    <div class="valueadds-item-title">
                                        Payment Now
                                    </div>

                                </div>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php if ($user->id == 0): ?>
                <div class="zen-booking-authpane-wrapper">
                    <div class="zen-booking-authpane">
                        <a style="display: block;" class="zen-booking-authpane-title zen-booking-authpane-title-closed" href="<?= travel::link('register', '&return=' . $return) ?>">Authorize and speed up your booking</a>
                    </div>
                </div>
            <?php endif; ?>

            <form id="form_broner">

                <?php echo $this->loadTemplate('form'); ?>


                <?php foreach ($data as $k => $v): ?>
                    <input  type="hidden" name="e[<?= $k ?>]" value="<?= $v ?>"    />

                <?php endforeach; ?>
                <input  type="hidden" name="data[roomid]" value="<?= $room['attr']['id'] ?>"    />
                <input  type="hidden" name="data[otel]" value="<?= $row->vid ?>"    />
                <input  type="hidden" name="data[region]" value="<?= $region->id ?>"    />

                <input  type="hidden" name="order_id" id="order_id" value="0"    />
                <input  type="hidden" name="return" value="<?= $return ?>"    />

            </form>



            <div class="zen-booking-stepbar-wrapper">
                <div class="zen-booking-stepbar">
                    <div data-id="0" id="click_m" class="zen-booking-stepbar-continue">Reserve</div>


                </div>
            </div>
        </div><!--zen-booking-main-->


        <div class="zen-booking-sidebar">


            <div class="zen-booking-sidebar-bill-wrapper">
                <div class="zen-booking-bill zen-booking-bill-expanded">
                    <div class="zen-booking-bill-content">
                        <div class="zen-booking-bill-main">
                            <div class="zen-booking-bill-rooms">

                                <div class="zen-booking-bill-room">
                                    <div class="zen-booking-bill-room-info">
                                        <div class="zen-booking-bill-room-name" data-test="room-rate">
                                            Room rate
                                        </div>
                                        <div class="zen-booking-bill-room-guests">
                                            <?= $this->e ?>
                                        </div>
                                    </div>
                                    <div class="zen-booking-bill-room-price">
                                        <div class="zen-booking-bill-room-price-value" >
                                            <?php /* ?><?=travel::pr($room['price'], $row);?><?php */ ?>
                                            <?= travel::pr1($room['price'], $row); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="zen-booking-bill-total">

                                <div class="zen-booking-bill-total-wrapper">
                                    <div class="zen-booking-bill-total-price clearfix">
                                        <div class="zen-booking-bill-total-price-title">
                                            To pay now
                                        </div>
                                        <div class="zen-booking-bill-total-price-value">
                                            <?= travel::pr1($room['price'], $row); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="zen-booking-bill-payment-systems">
                        <div class="zen-booking-bill-payment-systems-row-top">
                            <div class="zen-booking-bill-payment-systems-visa">
                            </div>
                            <div class="zen-booking-bill-payment-systems-mastercard">
                            </div>
                            <div class="zen-booking-bill-payment-systems-thawte">
                            </div>
                        </div>
                        <div class="zen-booking-bill-payment-systems-row-bottom">
                            <div class="zen-booking-bill-payment-systems-paypal">
                            </div>
                            <div class="zen-booking-bill-payment-systems-dss">
                            </div>
                            <div class="zen-booking-bill-payment-systems-stripe">
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div><!--zen-booking-sidebar-->
        <div style="clear: both;"></div>

    </div><!--zen-booking zen-booking-loaded-->

</div>


<script>

    jQuery(document).ready(function () {
        var meinr = 0; //Первое нажатие
        //cancellationPolicy("<?= $stringArray; ?>");
        function form_go(btn, txtbtn, r)
        {
            var $that = jQuery('#form_broner');
            formData = $that.serialize();
            jQuery.ajax({
                url: 'index.php?option=com_travel&task=html&function=booking_created&r=' + r,
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (res) {

                    btn.html(txtbtn);

                    jQuery('.flrderror').removeClass('flrderror');

                    if (res.error) {
                        alert(res.error);
                        // grecaptcha.reset();
                    }

                    if (res.fleds.length > 0)
                    {
                        //grecaptcha.reset();
                        for (var i = 0; i < res.fleds.length; i = i + 1)
                        {
                            jQuery('#' + res.fleds[i] + '').addClass('flrderror');

                        }

                        jQuery('html, body').animate({scrollTop: jQuery('#' + res.fleds[0] + '').offset().top}, 'slow');


                        setTimeout(function () {
                            jQuery('.flrderror').removeClass('flrderror');

                        }, 4000);

                    }
                    else if (!res.error && res.status == 1) {

                        //Что можно дальше
                        //meinr = res.r;
                        // if (meinr==1)
                        //{
                        // jQuery('#click_conf').trigger('click');
                        // return;

                        //}

                        if (r == 0) {
                            //Первый этап потверждени
                            jQuery('#form_broner,.zen-booking-authpane-wrapper,.zen-booking-main').hide();
                            jQuery('.zen-booking-sidebar').css('width', '100%');
                            jQuery('.zen-booking-bill-main').html(res.html);
                            jQuery('html, body').animate({scrollTop: jQuery('.zen-booking-bill-rooms').offset().top}, 'slow');
                            jQuery('#order_id').val(res.order_id);
                        }
                        else {



                            // //if (res.news==1)
                            window.location.href = res.link;
                            //  else
                            // location.reload();
                        }
                    }

                }
            });
        }

        //Обработка формы
        jQuery(document).on('click', '#click_m', function () {
            //  alert('111');
            //  return false;
            var btn = jQuery('#click_m');
            var txtbtn = btn.html();
            btn.html('<?= JText::_('SAVEGO'); ?>');
            var $that = jQuery('#form_broner');
            formData = $that.serialize();
            var r = btn.data('id');
            form_go(btn, txtbtn, 0);

            return false;
        });

        //Первый клик потверждение формы
        jQuery(document).on('click', '#click_conf', function () {
            var btn = jQuery('#click_conf');
            var txtbtn = btn.html();
            btn.html('<?= JText::_('SAVEGO'); ?>');
            form_go(btn, txtbtn, 1);

            return false;
        });

        //
        jQuery("#phone_fleds").mask("+999 99?9 999 999 999", {completed: function () {
            }});
    });
</script>