<?php
 require_once ('../../db.php');

 $id		=isset($_REQUEST["id"]) 	? $_REQUEST["id"]	: 0;
 $vcode		=isset($_REQUEST["vcode"]) 	? $_REQUEST["vcode"] 	: '';
 $title		=isset($_REQUEST["title"]) 	? $_REQUEST["title"] 	: '';
 $firstname	=isset($_REQUEST["firstname"]) 	? $_REQUEST["firstname"] : '';
 $lastname 	=isset($_REQUEST["lastname"]) 	? $_REQUEST["lastname"] : '';
 $email		=isset($_REQUEST["email"]) 	? $_REQUEST["email"] 	: '';
 $total		=isset($_REQUEST["total"]) 	? $_REQUEST["total"] 	: '0';
 $bookingdetails=isset($_REQUEST["bookingdetails"]) 	? $_REQUEST["bookingdetails"] 	: '';
 $paymentdetails=isset($_REQUEST["paymentdetails"]) 	? $_REQUEST["paymentdetails"] 	: '0';

if ($id>=0)
{	

    $query = "Select BookingDetails, PaymentDetails from visa_bookings where ID = ".$id." and VCode= '".$vcode."'";     
    $result=mysql_query($query) or die ("Invalid query: " . mysql_error());  
    $nrows = MYSQL_NUM_ROWS($result);
    if ($nrows > 0)
      {
        $row=mysql_fetch_assoc ($result);  
        
	$officemail='visa.intouristuk@gmail.com, visa@intouristuk.com';		
	$sout='';
        $msg="";        
	$msg.='<p>Dear <strong>'.$title.' '.$firstname.' '.$lastname.'</strong>,</p>
        	<p>Thank you for your request. Your booking reference number is <strong>VR'.$id.'</strong>.</p>
        	<p>Please 
<a href="http://www.intouristuk.com/visa_services/book_russian_visa/application_registration_service.php?vcode='.$vcode.
'&amp;id='.$id.'">click here</a> to verify your e-mail adress:<br/>';
        	
        $msg.=  '<div id="booking_details"><p>Please also check information you have provided below:
        </p>'.$row['BookingDetails'].'</div>
        	<div id="booking_total" style="width:660px;"><br/>'.$row['PaymentDetails'].'</div><br/>
        	 <h3>What is next?</h3>     
        	
                 <p><b>1. Deliver a copy of your passport and your visa to us</b></p>
			<p>Please scan and e-mail a copy of the first page of your passport 
			and a copy of your Russian Visa to <a href="mailto:visa@intouristuk.com">visa@intouristuk.com</a> <br/>
			or bring them (send them) to our office at 18 Norland Road, London, W11 4TR.</p>	
			<p><b>2. Enter Russia</b></p>
			<p>After passing passport control where your Immigration card will be stamped, you have to take 
    			a photo with your mobile phone of the Immigration card and send the image via MMS or email 
    			to IntouristUK at <a href="mailto:visa@intouristuk.com">visa@intouristuk.com</a>.</p> 
			<p><b>3. Receive your Russian Visa Registration Certificate</b></p>
			<p>IntouristUK will complete the Russian registration form for you in OVIR and send you 
			the completed 
			Russian registration certificate / Registration of Foreigners back via email.</p>
			<p><b>4. Print your Russian Registration Certificate</b></p>
			<p>
			After receiving your Russian Registration Certificate from IntouristUK you have to print out 
			the Russian registration certificate and keep it with you.</p><br/>	
			<p>Please do not hesitate to contact us on +44(0)&nbsp;20&nbsp;7603&nbsp;5045 if you have any questions.</p>
			<p><i>All of the above steps of registration process fully comply with Russian Law!</i></p> 
			<br/>	       	
        	<p>Your Sinserely, <br/>
        	IntouristUK Team</p>
        	<p>18 Norland Road<br/>
		Holland Park<br/>
		London<br/>
		W11 4TR</p>
		<p>Tel: 020 7603 5045<br/>
		Fax: 020 7603 5876<br/>
		Email: <a href="mailto:visa@intouristuk.com">visa@intouristuk.com</a><br/>
		<a href="http://www.intouristuk.com">www.intouristuk.com</a><br/>
		</p>';	
	$bg2='style="border-color:#E6D8BA #CDB276 #CDB276 #E6D8BA;border-style:solid;border-width:1px;padding:2px 10px;"';
        $bg5='style="border-color:#E6D8BA #CDB276 #CDB276 #E6D8BA;border-style:solid;border-width:1px;font-weight:bold;
        padding:2px 10px;"';
	$bg6='style="background:#CDB276 none repeat scroll 0 0;color:#FFFFFF;font-family:arial;font-weight:bold;
	padding:4px 10px;text-align:center;"';
	$msg  = str_replace('class="bg2"',$bg2,$msg);
	$msg  = str_replace('class="bg5"',$bg5,$msg);
	$msg  = str_replace('class="bg6"',$bg6,$msg);
	
	
        $sender_email="visa@intouristuk.com";  
	$sender_name="IntouristUK Russian Visa Services Team";      
        $replyto_email="visa@intouristuk.com";
	
			$mailheaders  = "MIME-Version: 1.0\r\n";
			$mailheaders .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$mailheaders .= "From: $sender_name <$sender_email>\r\n";
			$mailheaders .= "Reply-To: $replyto_email <$replyto_email>\r\n"; 
                        
	if (@mail($email,"IntouristUK Russian Visa Services Confirmation",stripslashes($msg), $mailheaders))
           {  
             $query = "Update visa_bookings set fSent=1 where ID = ".$id." and VCode= '".$vcode."'";     
             mysql_query($query) or die ("Invalid query: " . mysql_error());  
           }
       } 
  echo json_encode($response);
 }         
?>		

