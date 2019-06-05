

<?php 

$order = $this->order;

//echo 'CCC<pre>'; print_r($order); exit;
 
?><link rel="stylesheet" href="<?php echo JURI::root()?>components/com_travel/css/reserve.css" type="text/css" />

<div class="zen-roomspage">
 <div class="zen-booking zen-booking-loaded">
 <div class="zen-booking-main">
  
  
 
  
 <div class="zen-booking-authpane-wrapper">
<div class="zen-booking-authpane">
Thank you for booking with Into World Travel. Your reservation number is <?php echo JRequest::getInt('order_id'); ?>. You will receive confirmation of your booking on <?php echo $order->email; ?>  shortly..</div>
</div>
 

</div> 

 <div class="zen-booking-sidebar"></div>

</div></div>