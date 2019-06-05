<?php
 $id	= isset($_REQUEST["id"]) ? addslashes($_REQUEST["id"]) : '';
 $vcode	= isset($_REQUEST["vcode"]) ? addslashes($_REQUEST["vcode"]) : '';
 $country='Russia';
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


function GetAddDocs($vtype, $citisenship)
{
      
     $query = "SELECT ID, VisaType, Country, VisaAddDocuments, VisaAddDocumentsShort  
     FROM visa_citizenships WHERE VisaType=".$vtype." and UPPER(Country) = UPPER('".$citisenship."')";
    
     $result=mysql_query($query) or die ("Invalid query: " . mysql_error());     
     $rows = MYSQL_NUM_ROWS($result);
     if ($rows <= 0) return '';    
     $adddoc=mysql_fetch_assoc ($result); 
return $adddoc;
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
 	if ($bdata['Delivery']=='Royal Mail Special Delivery') $delivery='we will post your passport and visa back 
 	to you by Royal Mail Special Delivery.';
       		else if ($bdata['Delivery']=='Collection from IntoRussia office') $delivery='we will contact you 
       		and you will be able to collect your passport and visa from our office at 
       		18 Norland Road, London, W11 4TR.';
       		else $delivery='we will e-mail your passport and visa to the e-mail 
       		address you have provided ('.$bdata['Email'].').';
 	$h1='<h1>Submit your Application</h1>';
 	if ($bdata['VisaType']==1) $visa="Russian Tourist Visa"; 		
            else if ($bdata['VisaType']==16) $visa="Russian Tourist Visa"; 
            else if ($bdata['VisaType']==2) $visa="Russian Business Visa";
            else if ($bdata['VisaType']==25) $visa="Russian Business Visa"; 
     	    else if ($bdata['VisaType']==3) $visa="Russian Private Visa";
     	    else if ($bdata['VisaType']==4) $visa="Russian Transit Visa";     	    
     	    else if ($bdata['VisaType']==5) 
     	    	{
     	    		$h1='<h1>E-mail your documents</h1>'; 
     	    		$delivery = str_replace("passport and visa","Business Visa Invitation from 
     	    		the Ministry of Foreign Affairs",$delivery);
     	    	}
            else if ($bdata['VisaType']==6) 
            	{
            		$h1='<h1>E-mail your documents</h1>';
            		$delivery = str_replace("passport and visa","Visa Support Documents",$delivery);
            	}
     	    else $visa="Russian Visa";
     	$addd=GetAddDocs($bdata['VisaType'], $bdata['Citizenship']);
     	$adddoc=$addd['VisaAddDocuments'];
     	$adddocstr=$addd['VisaAddDocumentsShort'];
     	if (($bdata['fBooked']==0) and ($bdata['VisaType']==1))
     	    {
     	    	$adddoc.='<li>Visa support documents like hotel voucher etc. They can be obtained through your hotel or 
     	    	an approved travel agent who deals with trips to Russia, and should be valid for the entire duration 
     	    	of your trip</li>';
     	    	$adddocstr.=', visa support documents';
     	    }
     	if ($bdata['VisaEntry']=='multiple') $note='<p>Please note that multiple visa can not include children!</p>'; 
     	else if (!($bdata['VisaType']==5))$note='<p>For all children under 18 the please also include following documents:</p>
		  	<ul><li>
		  	Copy of birth certificate</li><li>
			Copy of parent&#39;s passports</li><li>
			Letter of consent if one or both parents  are not travelling</li></ul>';
	else $note='';
     
        if ($bdata['VisaType']==5) {$strout= $h1.'<h2>Deliver your Documents to us</h2>
			<p>Please scan and e-mail copy of your passport to 
			<a href="mailto:visa@into-russia.co.uk">visa@into-russia.co.uk</a> <br/>
			or bring it (send it) to our office at 18 Norland Road, London, W11 4TR.</p>
			'.$note.'
			<h2>Receive your Business Visa Invitation</h2>
			<p>When your Business Visa Invitation is ready '.$delivery.' </p> 
			';
        		$topmenu='SELECT VISA -> SERVICE -> PERSONAL DETAILS -> CONFIRM -> 
        		<span style="font-size:12.0pt;text-decoration:underline;">E-MAIL YOUR DOCUMENTS</span>';
        		}
         else if ($bdata['VisaType']==6) {$strout= $h1.'<h2>Deliver your Documents to us</h2>
			<p>Please scan and e-mail copy of your passport to
			 <a href="mailto:visa@into-russia.co.uk">visa@into-russia.co.uk</a> <br/>
			or bring it (send it) to our office at 
			18 Norland Road, London, W11 4TR.</p>					
			<h2>Receive your Visa Support Documents</h2>
			<p>When your Visa Support Documents are ready '.$delivery.' </p> 
			';
        		$topmenu='SELECT VISA -> SERVICE -> PERSONAL DETAILS -> CONFIRM -> 
        		<span style="font-size:12.0pt;text-decoration:underline;">E-MAIL YOUR DOCUMENTS</span>';
        		}
         else if ($bdata['VisaType']==25) {$strout= $h1.'<h2>1. Deliver copy of your passport to us</h2>
			<p>Please scan and e-mail copy of your passport to 
			<a href="mailto:visa@into-russia.co.uk">visa@into-russia.co.uk</a> <br/>
			or bring it (send it) to our office at 18 Norland Road, London, W11 4TR.</p>	
			<h2>2. Receive your Business Visa Invitation</h2>
			<p>When your Business Visa Invitation is ready we will send its copy to you by e-mail, 
			so you will be able to fill in your Russian Visa Application form online.</p> 
			<h2>3. Fill in Russian Visa Application form online</h2>
			<p>Following our 
<a href="http://www.into-russia.co.uk/visa_services/book_russian_visa/instruction.php" target="_blank">instructions</a>  
			please complete <a href="http://visa.kdmid.ru/" target="_blank">the '.$visa.' Application Form</a>. 
			When you complete the visa application form please do print it off and sign it off 
			at the bottom of the second page. </p>
			<p>Fill in Russian Visa Application form online step-by step:</p>
			<p>
			<span style="padding: 0 0 0 30px;"> 1. Read our 
<a href="http://www.into-russia.co.uk/visa_services/book_russian_visa/instruction.php" target="_blank">instruction</a></span><br/>
			<span style="padding: 0 0 0 30px;"> 2. Fill in 
			<a href="http://visa.kdmid.ru/" target="_blank">Application form</a> online</span> 
			(you will need to register on this official website of Consular Department of the Ministry 
			for Foreign Affairs of the Russian Federation first)<br/>
			<span style="padding: 0 0 0 30px;"> 3. Download the application form on your computer</span><br/>
			<span style="padding: 0 0 0 30px;"> 4. Print it off and Sign it off at the bottom 
			of the second page</span></p>
			<h2>4. Deliver your Documents to us</h2>
			<p>Please send your passport, one passport-sized photograph'.$adddocstr.' and application 
			form by Royal Mail Special Delivery 
			or bring them in person to our office at 18 Norland Road, London, W11 4TR.</p>
			<p>Please make sure you put all these documents in the envelop:<p/>
			<ul><li>
			Original passport</li><li>
			One passport-size photograph*</li><li>
			Application form printed and signed</li>'.$adddoc.'   	    		  
			</ul>
			'.$note.'<h2>5. Receive your Visa</h2>
			<p>When your visa is ready '.$delivery.' </p> 
			'; 
        		$topmenu='SELECT VISA -> SERVICE -> PERSONAL DETAILS -> CONFIRM -> 
        		<span style="font-size:12.0pt;text-decoration:underline;">SUBMIT YOUR APPLICATION</span>';
        		}       
         else {$strout=$h1.'<h2>1.  Fill in Russian Visa Application form online</h2>
<p>Following our 
<a href="http://www.into-russia.co.uk/visa_services/book_russian_visa/instruction.php" target="_blank">instructions</a>  
please complete <a href="http://visa.kdmid.ru/" target="_blank">the '.$visa.' Application Form</a>. 
When you complete the visa application form please do print it off and sign it off at the bottom of the second page. </p>
<p>Fill in Russian Visa Application form online step-by step:</p>
<p>
<span style="padding: 0 0 0 30px;"> 1. Read our 
<a href="http://www.into-russia.co.uk/visa_services/book_russian_visa/instruction.php" target="_blank">instruction</a></span><br/>
<span style="padding: 0 0 0 30px;"> 2. Fill in 
<a href="http://visa.kdmid.ru/" target="_blank">Application form</a> online</span> 
(you will need to register on this official website of Consular Department of the Ministry 
for Foreign Affairs of the Russian Federation first)<br/>
<span style="padding: 0 0 0 30px;"> 3. Download the application form on your computer</span><br/>
<span style="padding: 0 0 0 30px;"> 4. Print it off and Sign it off at the bottom of the second page</span></p>

<h2>2. Deliver your Documents to us</h2>
<p>Please send your passport, one passport-sized photograph'.$adddocstr.' and application form by Royal Mail Special Delivery 
or bring them in person to our office at 18 Norland Road, London, W11 4TR.</p>
<p>Please make sure you put all these documents in the envelop:<p/>
<ul><li>
Original passport
<ul>
<li>This must be valid for at least 6 months after your visa expiry date</li>
<li>Must contain at least 2 blank pages for visa to be affixed</li>
</ul>
</li>
<li>
One recent photograph taken within the last 6 months. The photograph should be in colour and meet the following requirements:
<ul>
<li>Taken against a light background (white or off-white) so that features are distinguishable and contrast against the background.</li>
<li>High quality and with the face in focus.</li>
<li>Printed on normal photographic paper (camera print)</li>
<li>35mm x 45mm in size</li>
</ul>
</li><li>
Application form printed and signed</li>'.$adddoc.'
<li>Please also include the login details (including the answer to your security question) for the online application form, in case any amendments are required.</li>

</ul>
'.$note.'
<h2>3. Receive your Visa</h2>
<p>When your visa is ready '.$delivery.' </p> 
        '; 
        		$topmenu='SELECT VISA -> SERVICE -> PERSONAL DETAILS -> CONFIRM -> 
        		<span style="font-size:12.0pt;text-decoration:underline;">SUBMIT YOUR APPLICATION</span>';
        		}       
  
  if ($bdata['fRegistration']==1) {$strout.='<h1>Register Your Visa</h1>';
  			if (($bdata['VisaType']==5) || ($bdata['VisaType']==6))
  				$strout.='<h2>1. Deliver a copy of your visa to us</h2>
				<p>Please scan and e-mail a copy of your Russian Visa to 
				<a href="mailto:visa@into-russia.co.uk">visa@into-russia.co.uk</a> <br/>
				or bring it (send it) to our office at 18 Norland Road, London, W11 4TR.</p>	
				<h2>2. Enter Russia</h2>
				<p>After passing passport control where your Immigration card will be stamped, you have to take 
    				a photo with your mobile phone of the Immigration card and send the image via MMS 
    				or email to IntoRussia at <a href="mailto:visa@into-russia.co.uk">visa@into-russia.co.uk</a>.</p> 
				<h2>3. Receive your Russian Visa Registration Certificate</h2>
				<p>IntoRussia will complete the Russian registration form for you in 
				OVIR and send you the completed 
				Russian registration certificate / Registration of Foreigners back via email.</p>
				<h2>4. Print your Russian Registration Certificate</h2>
				<p>After receiving your Russian Registration Certificate from IntoRussia you have to 
				print out the Russian registration certificate and keep it with you.</p>
				<p><i>All of the above steps of registration process fully comply with Russian Law!</i></p>';
  			else $strout.='<h2>1. Enter Russia</h2>
				<p>After passing passport control where your Immigration card will be stamped, you have to take 
    				a photo with your mobile phone of the Immigration card and send the image via MMS 
    				or email to IntoRussia at <a href="mailto:visa@into-russia.co.uk">visa@into-russia.co.uk</a>.</p> 
				<h2>2. Receive your Russian Visa Registration Certificate</h2>
				<p>IntoRussia will complete the Russian registration form for you in 
				OVIR and send you the completed 
				Russian registration certificate / Registration of Foreigners back via email.</p>
				<h2>3. Print your Russian Registration Certificate</h2>
				<p>After receiving your Russian Registration Certificate from IntoRussia you have 
				to print out the Russian registration certificate and keep it with you.</p>
				<p><i>All of the above steps of registration process fully comply with Russian Law!</i></p>';}
	$strout.='<p>Please do not hesitate to contact us on +44(0)&nbsp;20&nbsp;7603&nbsp;5045 if you have any questions.</p>';
			
  }
  else
  { 
        $strout='<h1>Step 5 out of 5. Submit your Application</h1><p>We are embarassed - we can not find your booking details,
         please contact us on +44(0)&nbsp;20&nbsp;7603&nbsp;5045.</p>';
  }
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Russian Visa Services. Submit your Russian Visa for '.$id.$vcode.'</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Book your Russian Visa with the Russian Travel specialist since 1938. 
Submit your Russian Visa Application" />
<meta name="keywords" content="Russian Visa Services, Russian tourist visa, Russian visa,Russian business visa, 
Russian Private visa, Russian Transit Visa, Russian Visa Application" />
  <meta name="rating" content="general" /> 
  <meta name="resource type" content="document" /> 
  <meta name="expires" content="never" /> 
  <meta name="Robots" content="noindex, nofollow" /> 
  <meta name="Revisit-After" content="7 day" /> 
  <meta name="distribution" content="global" /> 
  <meta name="classification" content="Russian Visa Services, Russian tourist visa, Russian visa, Russian business visa,
   Russian Private visa, Russian Transit Visa, Russian Visa Application" /> 
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