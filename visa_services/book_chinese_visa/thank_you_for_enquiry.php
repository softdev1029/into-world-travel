<?php 
 $vtype = isset($_REQUEST["vt"]) ? addslashes($_REQUEST["vt"]) : '1';
 $fc    = isset($_REQUEST["fc"]) ? addslashes($_REQUEST["fc"]) : 'United_Kingdom';
 $fcitizen = str_replace('_',' ',$fc);
 $entry = isset($_REQUEST["entry"]) ? addslashes($_REQUEST["entry"]) : 'single';
 $pr    = isset($_REQUEST["pr"]) ? addslashes($_REQUEST["pr"]) : 'standard';
 $processing = str_replace('_',' ',$pr);	
 $fb    = isset($_REQUEST["fb"]) ? addslashes($_REQUEST["fb"]) : 'no';
 $CallPhone    = isset($_REQUEST["CallPhone"]) ? addslashes($_REQUEST["CallPhone"]) : '';
 $CallName    = isset($_REQUEST["CallName"]) ? addslashes($_REQUEST["CallName"]) : '';
 $Enquiry    = isset($_REQUEST["Enquiry"]) ? addslashes($_REQUEST["Enquiry"]) : ''; 
 
 $topmenu='SELECT VISA -> SERVICE -> <span style="font-size:13.0pt;text-decoration:underline;">PERSONAL DETAILS</span> -> CONFIRM -> SUBMIT YOUR APPLICATION';

  if ($vtype==8) 		
	{
	  $visa='Chinese Tourist Visa';
	  $strout.='<h1>Chinese Tourist Visa. Personal Details</h1>';
	}  
 else if ($vtype==9) 		
	{
	  $visa='Chinese Business Visa';
	  $strout.='<h1>Chinese Business Visa. Personal Details</h1>';
	} 
 
function EnquiryCheck( $CallPhone,  $CallName, $Enquiry)
{
  $sout='';
  If ((($CallPhone=='') && ($Enquiry==''))||( ($CallPhone=='Phone:') && ($Enquiry=='')))
  $sout='<p>Sorry, you did not fill in your contact details</p><p> Please go back and correct your information</p>
  <FORM><INPUT TYPE="button" class="input_button" VALUE="Back" onClick="history.go(-1);return true;"></FORM> '; 
  
return $sout;
}
function SendEnquiry ($visa, $vtype, $fcitizen, $entry, $processing, $fb, $CallPhone,  $CallName, $Enquiry)
{	
	$officemail='visa@into-russia.co.uk';		
	$sout='';
        $msg="";        
	$msg.='<p>Please note that hew enquiry has been made on-line:</p><table width="560" cellspacing="1" cellpadding="0" border="0"><tbody>
 		   <tr>
   			   <td colspan="4" class="bg6"> 
   			   CLIENT DETAILS
   			   </td>
   		   </tr>
   		   <tr>
   		   <td class="bg5">Name</td>
   		   <td class="bg2">'.ucwords($CallName).'</td>
   		   <td class="bg5">Phone</td>
   		   <td class="bg2">'.$CallPhone.'</td>
   		   </tr>
   		   <tr>
   		   <td class="bg5">Enquiry</td>
   		   <td colspan="3" class="bg2">'.$Enquiry.'</td>
   		   </tr>
   		   <tr>
   			   <td colspan="4" class="bg6"> 
   			   VISA DETAILS
   			   </td>
   		   </tr>
   		   <tr>
   		   <td class="bg5">Service</td>
   		   <td colspan="3" class="bg2">'.$visa.'</td>   		  
   		   </tr>
   		   <tr>
   		   <td class="bg5">Entry</td>
   		   <td class="bg2">'.$entry.'</td>
   		   <td class="bg5">Processing</td>
   		   <td class="bg2">'.$processing.'</td>
   		   </tr>
   		   <tr>
   		   <td class="bg5">Citizenship</td>
   		   <td class="bg2">'.$fcitizen.'</td>
   		   <td class="bg5">Booked before?</td>
   		   <td class="bg2">'.$fb.'</td>
   		   </tr>
   		   </tbody></table>';
	$bg2='style="border-color:#E6D8BA #CDB276 #CDB276 #E6D8BA;border-style:solid;border-width:1px;padding:2px 10px;"';
        $bg5='style="border-color:#E6D8BA #CDB276 #CDB276 #E6D8BA;border-style:solid;border-width:1px;font-weight:bold;padding:2px 10px;"';
	$bg6='style="background:#CDB276 none repeat scroll 0 0;color:#FFFFFF;font-family:arial;font-weight:bold;padding:4px 10px;text-align:center;"';
	$msg  = str_replace('class="bg2"',$bg2,$msg);
	$msg  = str_replace('class="bg5"',$bg5,$msg);
	$msg  = str_replace('class="bg6"',$bg6,$msg);
	

	$subject='New '.$visa.' enquiry has been made on-line';
        $sender_email="visa@into-russia.co.uk";
	$sender_name="IntoRussia Chinese Visa Services Team";
	$replyto_email="visa@into-russia.co.uk";
	
			$mailheaders  = "MIME-Version: 1.0\r\n";
			$mailheaders .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$mailheaders .= "From: $sender_name <$sender_email>\r\n";
			$mailheaders .= "Reply-To: $replyto_email <$replyto_email>\r\n"; 
                        
	if (!(@mail($officemail,$subject,stripslashes($msg), $mailheaders)))
        $sout.='Error send message';         
		
  return $sout;
}	

$stout = EnquiryCheck($CallPhone, $CallName, $Enquiry);
if ($stout=='')
  {
  	SendEnquiry ($visa, $vtype, $fcitizen, $entry, $processing, $fb, $CallPhone,  $CallName, $Enquiry);
   	$strout.='<h1>Thank you for your enquiry</h1><p>Thank you for your enquiry, one of our Visa Consultants will contact you shortly.</p>
	<p>Please go back to your booking.</p>
	<FORM><INPUT TYPE="button" class="input_button" VALUE="Back" onClick="history.go(-1);return true;"></FORM> 
	<p>Alternatively, please go to the <a href="/visa_services/china/chinese_visa/visa_to_china.php">Visa Services section</p>';
  }
else  $strout.= '<h1>Error has been appeared when we were processing your enquiry</h1>'.$stout;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chinese Visa Services. Thank you for your enquary about <?php echo $entry;?> entry <?php echo $visa;?>, <?php echo $pr;?> service, <?php echo $fc;?>, booked - <?php echo $fb;?>.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Book your <?php echo $visa;?> with the Russian Travel specialist since 1938. Enquiry" />
<meta name="keywords" content="Chinese Visa Services, <?php echo $visa;?>, Chinese visa, Visa Services, Book <?php echo $visa;?>" />
  <meta name="rating" content="general" /> 
  <meta name="resource type" content="document" /> 
  <meta name="expires" content="never" /> 
  <meta name="Robots" content="noindex, nofollow" /> 
  <meta name="Revisit-After" content="7 day" /> 
  <meta name="distribution" content="global" /> 
  <meta name="classification" content="Chinese Visa Services, <?php echo $visa;?>, Chinese visa, Visa Services, Book <?php echo $visa;?>" /> 
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="/css/default.css" rel="stylesheet" type="text/css" />
</head>

<body class="visa">
<div id="block_main">
<div id="block_top">

	<?php   
 	$top= implode("", file('../../Resource/top_visa_booking.html')); 	
 	$top=str_replace('[MENU]','<a href="/visa_services/china/chinese_visa/visa_to_china.php">CHINESE VISA SERVICES</a>',$top); 
 	$top=str_replace("[STEP]",$topmenu,$top); 
 	echo $top; ?>
</div>
<div id="block_content"><?php echo $strout; ?>

</div>
<br class="clearfloat" />

<div id="block_bottom"><?php   include('../../Resource/bottom2.html');   ?></div>
</div>

<?php include('../../Resource/googlescr.html'); ?>

</body>
</html>