<?php
 require_once ('../../db.php');

 $id		=isset($_REQUEST["id"]) 	? $_REQUEST["id"]	: 0;
 $vcode		=isset($_REQUEST["vcode"]) 	? $_REQUEST["vcode"] 	: '';
 $title		=isset($_REQUEST["title"]) 	? $_REQUEST["title"] 	: '';
 $firstname	=isset($_REQUEST["firstname"]) 	? $_REQUEST["firstname"] : '';
 $lastname 	=isset($_REQUEST["lastname"]) 	? $_REQUEST["lastname"] : '';
 $email		=isset($_REQUEST["email"]) 	? $_REQUEST["email"] 	: '';
 $total		=isset($_REQUEST["total"]) 	? $_REQUEST["total"] 	: '0';

if ($id>=0)
{	

    $query = "Select BookingDetails, PaymentDetails from visa_bookings where ID = ".$id." and VCode= '".$vcode."'";     
    $result=mysql_query($query) or die ("Invalid query: " . mysql_error());  
    $nrows = MYSQL_NUM_ROWS($result);
    if ($nrows > 0)
      {
        $row=mysql_fetch_assoc ($result);  
        
        $officemail='visa@into-russia.co.uk';		
	$sout='';
        $msg="";        
	$msg.='<p>Dear <strong>'.$title.' '.$firstname.' '.$lastname.'</strong>,</p>
        	<p>Thank you for your request. Your booking reference number is <strong>VIS'.$id.'</strong>.</p>
        	<p style="color: #CC6600;font-weight: bold;">Remember to submit your Chinese Visa Application by completing the <a href="http://www.into-russia.co.uk/visa_services/book_chinese_visa/application.php?vcode='.$vcode.'&amp;id='.$id.'">Next Step</a>.</p>'; 
        $msg.=  '<div id="booking_details"><p>Please also check information you have provided below:</p>'.$row['BookingDetails'].'</div>
        	<div id="booking_total" style="width:660px;"><br/>'.$row['PaymentDetails'].'</div><br/><br/>	        	
        	<p>Your Sinserely, <br/>
        	IntoRussia Team</p>
        	<p>18 Norland Road<br/>
		Holland Park<br/>
		London<br/>
		W11 4TR</p>
		<p>Tel: 020 7603 5045<br/>
		Fax: 020 7603 5876<br/>
		Email: <a href="mailto:visa@into-russia.co.uk">visa@into-russia.co.uk</a><br/>
		<a href="http://www.into-russia.co.uk">www.into-russia.co.uk</a><br/>
		</p>';	
	$bg2='style="border-color:#E6D8BA #CDB276 #CDB276 #E6D8BA;border-style:solid;border-width:1px;padding:2px 10px;"';
        $bg5='style="border-color:#E6D8BA #CDB276 #CDB276 #E6D8BA;border-style:solid;border-width:1px;font-weight:bold;padding:2px 10px;"';
	$bg6='style="background:#CDB276 none repeat scroll 0 0;color:#FFFFFF;font-family:arial;font-weight:bold;padding:4px 10px;text-align:center;"';
	$msg  = str_replace('class="bg2"',$bg2,$msg);
	$msg  = str_replace('class="bg5"',$bg5,$msg);
	$msg  = str_replace('class="bg6"',$bg6,$msg);

	
        $sender_email="visa@into-russia.co.uk";  
	$sender_name="IntoRussia Chinese Visa Services Team";      
        $replyto_email="visa@into-russia.co.uk";
	
			$mailheaders  = "MIME-Version: 1.0\r\n";
			$mailheaders .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$mailheaders .= "From: $sender_name <$sender_email>\r\n";
			$mailheaders .= "Reply-To: $replyto_email <$replyto_email>\r\n"; 
                        
	if (@mail($email,"IntoRussia Chinese Visa Services Confirmation",stripslashes($msg), $mailheaders))
          {  
             $query = "Update visa_bookings set fSent=1 where ID = ".$id." and VCode= '".$vcode."'";     
             mysql_query($query) or die ("Invalid query: " . mysql_error());  
           }
	
       } 
  echo json_encode($response);
 }         
?>		

