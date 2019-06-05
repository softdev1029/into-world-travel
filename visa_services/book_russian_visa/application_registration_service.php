<?php
 $id	= isset($_REQUEST["id"]) ? addslashes($_REQUEST["id"]) : '';
 $vcode	= isset($_REQUEST["vcode"]) ? addslashes($_REQUEST["vcode"]) : '';
require_once ('../../db.php');

function GetData($id, $vcode)
{
      
     $query = "SELECT ID, VisaType, VisaEntry, ProcessingSpeed, Citizenship, Title, FirstName, LastName, DateOfBirth,
     PassportNumber, ExpireDate, fBooked, ReferenceNumber, VisaStart, VisaEnd, VisaItinerary, VisaAddress, Phone, Email, 
     Delivery, DeliveryAddress, fVerified, VCode, fConfirmed, SessionID, Total, fRegistration, VisaRegistration
     FROM visa_bookings WHERE ID=".$id." and UPPER(VCode) = UPPER('".$vcode."')";
     
     $result=mysql_query($query) or die ("Invalid query: " . mysql_error());     
     $rows = MYSQL_NUM_ROWS($result);
     if ($rows <= 0) return 'Your booking not found.';    
     $data=mysql_fetch_assoc ($result); 
return $data;
}

function ConfirmBooking($id)
{
     $err='';
     $query = "UPDATE visa_bookings SET fConfirmed=1 WHERE ID=".$id;
     $result=mysql_query($query) or die ("Invalid query: " . mysql_error());         
return $err;
}

$bdata=GetData($id, $vcode);  	
if (!$bdata['ID']=='')
 	{ 
 	
 	ConfirmBooking($bdata['ID']); 	
 	$h1='<h1>E-mail your documents</h1>';   
        $topmenu='SELECT VISA -> SERVICE -> PERSONAL DETAILS -> CONFIRM -> 
        <span style="font-size:12.0pt;text-decoration:underline;">E-MAIL YOUR DOCUMENTS</span>';
        		
        $strout= $h1.'<h2>1. Deliver a copy of your passport and your visa to us</h2>
			<p>Please scan and e-mail a copy of the first page of your passport 
			and a copy of your Russian Visa to <a href="mailto:visa@intourist.co.uk">visa@intourist.co.uk</a> <br/>
			or bring them (send them) to our office at 18 Norland Road, London, W11 4TR.</p>	
			<h2>2. Enter Russia</h2>
			<p>After passing passport control where your Immigration card will be stamped, you have to take 
    			a photo with your mobile phone of the Immigration card and send the image via MMS or email 
    			to IntouristUK at <a href="mailto:visa@intouristuk.com">visa@intouristuk.com</a>.</p> 
			<h2>3. Receive your Russian Visa Registration Certificate</h2>
			<p>IntouristUK will complete the Russian registration form for you in OVIR and send you the completed 
			Russian registration certificate / Registration of Foreigners back via email.</p>
			<h2>4. Print your Russian Registration Certificate</h2>
			<p>
			After receiving your Russian Registration Certificate from IntouristUK you have to print out 
			the Russian registration certificate and keep it with you.</p>
			<p>Please do not hesitate to contact us on +44(0)&nbsp;20&nbsp;7603&nbsp;5045 if you have any questions.</p>
			<p><i>All of the above steps of registration process fully comply with Russian Law!</i></p>'; 
        }
  else
  { 
        $strout='<h1>E-mail your documents</h1><p>We are embarassed - we can not find your booking details, please 
        contact us on +44(0)&nbsp;20&nbsp;7603&nbsp;5045.</p>';
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Russian Visa Services. Register your Russian Visa for '.$id.$vcode.'</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Book your Russian Visa Registration Services with the Russian Travel 
specialist since 1938. E-mail your documents" />

<meta name="keywords" content="Russian Visa Registration Services, Russian Visa Registration Service, Registration Service,
 Visa Registration Service,  Russian tourist visa Registration Service, Russian visa Registration Service, 
 Russian business visa Registration Service, Russian Private visa Registration Service,
  Russian Transit Visa Registration Service,  Registration Services, Visa Registration Services, 
   Russian tourist visa Registration Services, Russian visa Registration Services, 
   Russian business visa Registration Services, Russian Private visa Registration Services, 
 Russian Transit Visa Registration Services" />
  <meta name="rating" content="general" /> 
  <meta name="resource type" content="document" /> 
  <meta name="expires" content="never" /> 
  <meta name="copyright" content="2010, intouristuk.com" /> 
  <meta name="Robots" content="noindex, nofollow" /> 
  <meta name="Revisit-After" content="7 day" /> 
  <meta name="distribution" content="global" /> 
  <meta name="author" content="intouristuk.com" /> 
  <meta name="classification" content="Russian Visa Registration Services, Russian Visa Registration Service,
   Registration Service, Visa Registration Service,  Russian tourist visa Registration Service, 
   Russian visa Registration Service, Russian business visa Registration Service, Russian Private visa Registration Service, 
   Russian Transit Visa Registration Service,  Registration Services, Visa Registration Services,  
   Russian tourist visa Registration Services, Russian visa Registration Services, 
   Russian business visa Registration Services, Russian Private visa Registration Services,    
 Russian Transit Visa Registration Services" /> 
  <meta name="google-site-verification" content="nlj28uiVr_AmzBmrEWLBB_eoKY9U0GF_M6pKVb6JuMc" />
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="/css/default.css" rel="stylesheet" type="text/css" />
</head>

<body class="visa">
<div id="block_main">
<div id="block_top">
	<?php   
	$top= implode("", file('../../Resource/top_visa_booking.html'));
 	$top=str_replace('[MENU]','<a href="/visa_services/russia/russian_visa/visa_to_russia.php">RUSSIAN VISA SERVICES</a>',$top); 
 	$top=str_replace('[STEP]',$topmenu,$top); 
 	echo $top; ?>
</div>
<div id="block_content">


<?php
    

 echo $strout;
?>

<br class="clearfloat" />

<div id="block_bottom">
<?php   include('../../Resource/bottom2.html');   ?></div>
</div>

<?php include('../../Resource/googlescr.html'); ?>

</body>
</html>