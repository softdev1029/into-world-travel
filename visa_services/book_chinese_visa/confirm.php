<?php
 session_start(); 
 $fc    = isset($_REQUEST["fc"]) ? addslashes($_REQUEST["fc"]) : 'United_Kingdom';
 $fcitizen = str_replace('_',' ',$fc);
 $entry = isset($_REQUEST["entry"]) ? addslashes($_REQUEST["entry"]) : 'single';
 $processing    = isset($_REQUEST["pr"]) ? addslashes($_REQUEST["pr"]) : 'standard';
 $fb    = isset($_REQUEST["fb"]) ? addslashes($_REQUEST["fb"]) : '0';
 $vt    = isset($_REQUEST["vt"]) ? addslashes($_REQUEST["vt"]) : '8';
 $id    = isset($_REQUEST["id"]) ? addslashes($_REQUEST["id"]) : '';

 $country = 'China';
 if ($vt==8) {$visa="Chinese Tourist Visa"; $visatype="Tourist"; $topmenu='SELECT VISA -> SERVICE -> PERSONAL DETAILS -> 
                                                                           <span style="font-size:14.0pt;text-decoration:underline;">
                                                                           CONFIRM</span> -> SUBMIT YOUR APPLICATION';}
 else if ($vt==9) {$visa="Chinese Business Visa";  $visatype="Business"; $topmenu='SELECT VISA -> SERVICE -> PERSONAL DETAILS -> 
                                                                                   <span style="font-size:14.0pt;
                                                                                   text-decoration:underline;">
                                                                                   CONFIRM</span> -> SUBMIT YOUR APPLICATION';} 
 else if ($vt==10) {$visa="Chinese Business Visa Invitation";  $visatype="Business"; 
                     $topmenu='SELECT VISA -> SERVICE -> PERSONAL DETAILS -> 
                              <span style="font-size:14.0pt;
                              text-decoration:underline;">CONFIRM</span> -> E-MAIL YOUR DOCUMENTS';} 
                                                                                   
 else if ($vt==11) {$visa="Chinese Business Visa and Invitation";  $visatype="Business"; 
                     $topmenu='SELECT VISA -> SERVICE -> PERSONAL DETAILS -> 
                                <span style="font-size:14.0pt;
                                text-decoration:underline;">CONFIRM</span> -> SUBMIT YOUR APPLICATION';}
                                
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chinese Visa Services. Confirm your booking of <?php echo $visa; ?>: <?php echo $entry; ?> entry, 
<?php echo  $processing;?> service, <?php echo $fc;?>, reference - <?php if ($fb==0) echo 'no'; else echo 'yes';?>.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Book your Chinese Visato travel to China. Confirm your Chinese Visa Services" />
<meta name="keywords" content="Chinese Visa Services, Chinese tourist visa, Chinese visa, Chinese business visa" />
  <meta name="rating" content="general" /> 
  <meta name="resource type" content="document" /> 
  <meta name="expires" content="never" /> 
  <meta name="copyright" content="2010, intouristuk.com" /> 
  <meta name="Robots" content="noindex, nofollow" /> 
  <meta name="Revisit-After" content="7 day" /> 
  <meta name="distribution" content="global" /> 
  <meta name="author" content="intouristuk.com" /> 
  <meta name="classification" content="Chinese Visa Services, Chinese tourist visa, Chinese visa,Chinese business visa" /> 
  <meta name="google-site-verification" content="nlj28uiVr_AmzBmrEWLBB_eoKY9U0GF_M6pKVb6JuMc" />
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="/css/default.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="ui/development-bundle/themes/redmond/jquery.ui.all.css"/>


        <script type="text/javascript" src="/tour_finder/ui/development-bundle/jquery-1.7.1.js"></script>
	<script type="text/javascript" src="/tour_finder/ui/development-bundle/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="/tour_finder/ui/development-bundle/ui/jquery.ui.datepicker.js"></script>

        <script type="text/javascript">
          
          function  ReSendConfirmation( idX, vcodeX, titleX, firstnameX, lastnameX, emailX, totalX ){                    
             
                   var dd=new Date().getTime();   
                  
                  $.getJSON ("resend_confirmation.php",
                             { id: idX, vcode: vcodeX, title: titleX, firstname: firstnameX, lastname: lastnameX,
                               email: emailX, total: totalX, t: dd }, function(json){ alert("Confirmation email has been resent!");}
			    
                  );
           }
      </script> 
</head>

<body class="visa">
<div id="block_main">
<div id="block_top">

	<?php   
 	$top=implode("", file('../../Resource/top_visa_booking.html'));	
 	$top=str_replace('[MENU]','<a href="/visa_services/china/chinese_visa/visa_to_china.php">CHINESE VISA SERVICES</a>',$top);  
 	$top=str_replace("[STEP]",$topmenu,$top); 
 	echo $top; ?>
</div>
<div id="block_content">


<?php

$Title= isset($_REQUEST["Title"]) ? (string)$_REQUEST["Title"] : '';
$FirstName= isset($_REQUEST["FirstName"]) ? (string)$_REQUEST["FirstName"] : '';
$LastName= isset($_REQUEST["LastName"]) ? (string)$_REQUEST["LastName"] : '';
$DOB= isset($_REQUEST["DOB"]) ? (string)$_REQUEST["DOB"] : '';
$PassportNumber= isset($_REQUEST["PassportNumber"]) ? (string)$_REQUEST["PassportNumber"] : '';
$ExpireDate= isset($_REQUEST["ExpireDate"]) ? (string)$_REQUEST["ExpireDate"] : '';
$VisaStart= isset($_REQUEST["VisaStart"]) ? (string)$_REQUEST["VisaStart"] : '';
$VisaEnd= isset($_REQUEST["VisaEnd"]) ? (string)$_REQUEST["VisaEnd"] : '';
$Itinerary= isset($_REQUEST["Itinerary"]) ? (string)$_REQUEST["Itinerary"] : '';
$Address= isset($_REQUEST["Address"]) ? (string)$_REQUEST["Address"] : '';
$Phone= isset($_REQUEST["Phone"]) ? (string)$_REQUEST["Phone"] : '';
$Email= isset($_REQUEST["Email"]) ? (string)$_REQUEST["Email"] : '';
$Delivery_ = isset($_REQUEST["Delivery"]) ? (string)$_REQUEST["Delivery"] : '';
$Delivery = str_replace('_',' ',$Delivery_);
$DeliveryAddress= isset($_REQUEST["DeliveryAddress"]) ? (string)$_REQUEST["DeliveryAddress"] : '';
$ReferenceNumber= isset($_REQUEST["ReferenceNumber"]) ? (string)$_REQUEST["ReferenceNumber"] : '';
$CountryOB= isset($_REQUEST["CountryOB"]) ? (string)$_REQUEST["CountryOB"] : '';
$PlaceOB= isset($_REQUEST["PlaceOB"]) ? (string)$_REQUEST["PlaceOB"] : '';
$Children= isset($_REQUEST["Children"]) ? (string)$_REQUEST["Children"] : '';
$Company= isset($_REQUEST["Company"]) ? (string)$_REQUEST["Company"] : '';
$Position= isset($_REQUEST["Position"]) ? (string)$_REQUEST["Position"] : '';
$CompanyAddress= isset($_REQUEST["CompanyAddress"]) ? (string)$_REQUEST["CompanyAddress"] : '';
$CompanyPostCode= isset($_REQUEST["CompanyPostCode"]) ? (string)$_REQUEST["CompanyPostCode"] : '';
$CompanyPhone= isset($_REQUEST["CompanyPhone"]) ? (string)$_REQUEST["CompanyPhone"] : '';
$CompanyFax= isset($_REQUEST["CompanyFax"]) ? (string)$_REQUEST["CompanyFax"] : '';
$TravelPurpose= isset($_REQUEST["TravelPurpose"]) ? (string)$_REQUEST["TravelPurpose"] : '';
$TravelPeriod= isset($_REQUEST["TravelPeriod"]) ? (string)$_REQUEST["TravelPeriod"] : '';
$fRegistration= isset($_REQUEST["Registration"]) ? (string)$_REQUEST["Registration"] : '0';
     
require_once ('../../db.php');
require_once ('../../includes/visa_f.php');

function BookDataCheck($vt, $entry, $processing, $fcitizen, $Title, $FirstName, $LastName, $DOB,
                       $PassportNumber, $ExpireDate, $fb, $ReferenceNumber, $VisaStart, $VisaEnd, $Itinerary, $Address, 
                       $Phone, $Email, $Delivery, $DeliveryAddress, $Company, $Position, $CompanyAddress, $CompanyPostCode,
                       $CompanyPhone, $CompanyFax, $TravelPurpose, $TravelPeriod, $Children, $Total )
{
 $strout='';
 $fErr=false;
 
  //check entered details
  if (!((!preg_match("/[^A-z_\-]/", $FirstName)) && ($FirstName!="")))
   {$fErr=true; $strout.='<li>Invalid First Name</li>'; }
  if (!((!preg_match("/[^A-z_\-]/", $LastName)) && ($LastName!="")))
   {$fErr=true; $strout.='<li>Invalid Last Name</li>';}
  if (!((!preg_match("/[^0-9_\-]/", $DOB)) && ($DOB!="") && (strlen($DOB)==8)))
     {$fErr=true; $strout.='<li>Invalid Date of Birth</li>';}   
  if (!((!preg_match("/[^a-zA-Z0-9_\-]/", $PassportNumber)) && ($PassportNumber!="")))
   {$fErr=true; $strout.='<li>Invalid Passport Number</li>';}
  if (!((!preg_match("/[^0-9_\-]/", $ExpireDate)) && ($ExpireDate!="") && (strlen($ExpireDate)==8)))
   {$fErr=true; $strout.='<li>Invalid Expire Date</li>';} 
  if (($fb==1) && ($ReferenceNumber==""))
     {$fErr=true; $strout.='<li>Invalid Reference Number</li>';} 
  //travel information check
  if ($fb==0)
    {
     if (!((!preg_match("/[^0-9_\-]/", $VisaStart)) && ($VisaStart!="") && (strlen($VisaStart)==8)))
	{$fErr=true; $strout.='<li>Invalid Travel Start Date</li>';} 
     if (!((!preg_match("/[^0-9_\-]/", $VisaEnd)) && ($VisaEnd!="") && (strlen($VisaEnd)==8)))
	{$fErr=true; $strout.='<li>Invalid Travel End Date</li>';}
     if ($Itinerary=="")
	{$fErr=true; $strout.='<li>Invalid Itinerary</li>';}
     if (($Address=="") && (!(($vt==16) || ($vt==6) || ($vt==11) || ($vt==10) || ($vt==25) || ($vt==5))))
	{$fErr=true; $strout.='<li>Invalid Address of your Stay in China</li>';}
    }
  //check company for business invitation
  if (($vt==25) || ($vt==5))
    {
    	if ($Company=="")
		{$fErr=true; $strout.='<li>Invalid Company Name</li>';}
    	if ($Position=="")
		{$fErr=true; $strout.='<li>Invalid Position</li>';}
	if ($CompanyAddress=="")
		{$fErr=true; $strout.='<li>Invalid Company Address</li>';}
    	if ($CompanyPostCode=="")
		{$fErr=true; $strout.='<li>Invalid Postcode</li>';}
	$numbersOnly = ereg_replace("[^0-9]", "", $CompanyPhone);
  	$numberOfDigits = strlen($numbersOnly);
  	if ($numberOfDigits <10)
   		{$fErr=true; $strout.='<li>Invalid Company Phone Number</li>';}
  	if (!($CompanyFax=="")) 
  		{
  			$numbersOnly = ereg_replace("[^0-9]", "", $CompanyFax);
  			$numberOfDigits = strlen($numbersOnly);
    			if ($numberOfDigits <10)
				{$fErr=true; $strout.='<li>Invalid Company Fax Number</li>';}
		}
       	if ($TravelPurpose=="")
		{$fErr=true; $strout.='<li>Invalid Travel Purpose</li>';}
   	if ($TravelPeriod=="")
		{$fErr=true; $strout.='<li>Invalid Travel Period</li>';}
    }
  //validate phone
  $numbersOnly = ereg_replace("[^0-9]", "", $Phone);
  $numberOfDigits = strlen($numbersOnly);
  if ($numberOfDigits <10)
   {$fErr=true; $strout.='<li>Invalid Phone Number</li>';}
  if (!((eregi("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\._\-]+\.[a-zA-Z]{2,4}", $Email)) && (!($Email==""))))
   {$fErr=true; $strout.='<li>Invalid E-Mail</li>';}  
  //validate delivery address
  if (($Delivery=="Royal Mail Special Delivery") && ($DeliveryAddress=="") and (!(($vt==5) || ($vt==10))))
   {$fErr=true; $strout.='<li>Invalid Delivery Address</li>';} 
   
   
  
return $strout;
}


function CalcTotal ($vt, $entry, $processing, $fcitizen, $fb, $fRegistration, $Delivery)
{
     $Price_1= GetPrice ( $vt, $entry, $processing, $fcitizen, $fb);
     if ($Delivery=='Royal Mail Special Delivery') $Price_2=7.5; else $Price_2=0;    
     $Total=$Price_1+$Price_2;
     
return $Total;
}

function BookDataSave( $country, $vt, $entry, $processing, $fcitizen, $Title, $FirstName, $LastName, $DOB,
                       $PassportNumber, $ExpireDate, $fb, $ReferenceNumber, $VisaStart, $VisaEnd, $Itinerary, $Address, 
                       $Phone, $Email, $Delivery, $DeliveryAddress, $Company, $Position, $CompanyAddress, $CompanyPostCode,
                       $CompanyPhone, $CompanyFax, $TravelPurpose, $TravelPeriod, $Children, $Total, $fRegistration,
                       $bookingdetails, $paymentdetails)
{   
   $VisaRegistration='';
   $sessionID = session_id();    
   $query_1 = "SELECT ID, VCode, fSent FROM visa_bookings WHERE SessionID='".$sessionID."' 
                and UPPER(FirstName) = UPPER('".$FirstName."') and UPPER(LastName) = UPPER('".$LastName."')
                and UPPER(PassportNumber) = UPPER('".$PassportNumber."') and  Country='".$country."'";         
   $result_1 = mysql_query($query_1) or die ("Invalid query: " . mysql_error());  
   $rows_1 = MYSQL_NUM_ROWS($result_1);   
   
   if ($rows_1 <= 0) 
     { 
     //insert new, return ID
    
     $query_2 = "INSERT INTO visa_bookings (ID, Country, VisaType, VisaEntry, ProcessingSpeed, Citizenship,
      Title, FirstName, LastName, 
     DateOfBirth, PassportNumber, ExpireDate, fBooked, ReferenceNumber, VisaStart, VisaEnd, VisaItinerary, VisaAddress,
     Phone, Email, Delivery, DeliveryAddress, fVerified, VCode, fConfirmed, SessionID, Total, 
     Company, Position, CompanyAddress, CompanyPostCode, CompanyPhone, CompanyFax, TravelPurpose, TravelPeriod, Children, 
     fRegistration, VisaRegistration, BookingDetails, PaymentDetails) 
       Values ('NULL','".$country."','".$vt."', '".$entry."', '".$processing."', '".$fcitizen."',
       '".$Title."','".$FirstName."', '".$LastName."', 
       '".$DOB."', '".$PassportNumber."', '".$ExpireDate."', ".$fb.", '".$ReferenceNumber."', 
       '".$VisaStart."','".$VisaEnd."','".$Itinerary."','".$Address."',
       '".$Phone."', '".$Email."','".$Delivery."', '".$DeliveryAddress."', 1, 
       HEX(Left('".$FirstName.$LastName."',10)), 0, '".$sessionID."', 
        ".$Total.", '".$Company."','".$Position."','".$CompanyAddress."','".$CompanyPostCode."','".$CompanyPhone."',
        '".$CompanyFax."','".$TravelPurpose."','".$TravelPeriod."','".$Children."', ".$fRegistration.", '".$VisaRegistration."',
         '".$bookingdetails."', '".$paymentdetails."')";
 
     mysql_query($query_2) or die ("Invalid query: " . mysql_error()); 
           
     $query_3 = "SELECT ID, VCode, fSent FROM visa_bookings WHERE SessionID='".$sessionID."' 
                and UPPER(FirstName) = UPPER('".$FirstName."') 
                and UPPER(LastName) = UPPER('".$LastName."')and UPPER(PassportNumber) = UPPER('".$PassportNumber."') 
                and  Country='".$country."'"; 
     $result_3 = mysql_query($query_3) or die ("Invalid query: " . mysql_error());     
     $rows_3 = MYSQL_NUM_ROWS($result_3);
     if ($rows_3 <= 0) return 'Record not found';      
     $rowID=mysql_fetch_assoc ($result_3);     
     }
     
     else
     { 
      //update current
      $rowID=mysql_fetch_assoc($result_1);
      // check if any fields have been changed
      $query_5="select fSent from visa_bookings where Country='".$country."' and VisaType='".$vt."'  and 
      VisaEntry ='".$entry."' and ProcessingSpeed='".$processing."'  and Citizenship='".$fcitizen."' and
      Title='".$Title."' and  FirstName='".$FirstName."' and  LastName='".$LastName."' and DateOfBirth='".$DOB."' and 
      PassportNumber='".$PassportNumber."' and ExpireDate='".$ExpireDate."' and fBooked=".$fb." 
      and ReferenceNumber='".$ReferenceNumber."' and 
      VisaStart='".$VisaStart."' and VisaEnd='".$VisaEnd."' and VisaItinerary='".$Itinerary."' and VisaAddress='".$Address."' and 
      Phone='".$Phone."' and Email='".$Email."' and Delivery='".$Delivery."' and DeliveryAddress='".$DeliveryAddress."' and 
      VCode=HEX(Left('".$FirstName.$LastName."',10)) and Company='".$Company."' and Position ='".$Position."' and
      CompanyAddress='".$CompanyAddress."' and CompanyPostCode='".$CompanyPostCode."' and CompanyPhone='".$CompanyPhone."' and
      CompanyFax='".$CompanyFax."' and TravelPurpose='".$TravelPurpose."' and TravelPeriod='".$TravelPeriod."' and 
      Children='".$Children."' and fRegistration=".$fRegistration." and VisaRegistration='".$VisaRegistration."' 
      and ID = ".$rowID['ID'];
      $result_5 = mysql_query($query_5) or die ("Invalid query: " . mysql_error());     
      $rows_5 = MYSQL_NUM_ROWS($result_5);
      if ($rows_5 <= 0)  $rowID['fSent']='0';
          
      
      //update
      $query_4 = "Update visa_bookings set Country='".$country."', VisaType='".$vt."' , fSent= ". $rowID['fSent'].",
      VisaEntry ='".$entry."', ProcessingSpeed='".$processing."' , Citizenship='".$fcitizen."',
      Title='".$Title."',  FirstName='".$FirstName."',  LastName='".$LastName."', DateOfBirth='".$DOB."', 
      PassportNumber='".$PassportNumber."', ExpireDate='".$ExpireDate."', fBooked=".$fb.", ReferenceNumber='".$ReferenceNumber."', 
      VisaStart='".$VisaStart."', VisaEnd='".$VisaEnd."', VisaItinerary='".$Itinerary."', VisaAddress='".$Address."', 
      Phone='".$Phone."', Email='".$Email."', Delivery='".$Delivery."', DeliveryAddress='".$DeliveryAddress."', 
      VCode=HEX(Left('".$FirstName.$LastName."',10)), Company='".$Company."', Position ='".$Position."',
      CompanyAddress='".$CompanyAddress."', CompanyPostCode='".$CompanyPostCode."', CompanyPhone='".$CompanyPhone."',
      CompanyFax='".$CompanyFax."', TravelPurpose='".$TravelPurpose."', TravelPeriod='".$TravelPeriod."', 
      Children='".$Children."', fRegistration=".$fRegistration.", VisaRegistration='".$VisaRegistration."',
      BookingDetails ='".$bookingdetails."', PaymentDetails='".$paymentdetails."' where ID = ".$rowID['ID'];     
      mysql_query($query_4) or die ("Invalid query: " . mysql_error());       
     }
 
return $rowID;
}

function SendConfirmation ($ID, $VCode, $Title, $FirstName, $LastName, $Email, $Total, $bookingdetails, $paymentdetails)
{	
	$officemail='visa.intouristuk@gmail.com, visa@intouristuk.com';		
	$sout='';
        $msg="";        
	$msg.='<p>Dear <strong>'.$Title.' '.$FirstName.' '.$LastName.'</strong>,</p>
        	<p>Thank you for your request. Your booking reference number is <strong>VIS'.$ID.'</strong>.</p>
        	<p style="color: #CC6600;font-weight: bold;">Remember to submit your Chinese Visa Application 
        	by completing the 
<a href="http://www.intouristuk.com/visa_services/book_chinese_visa/application.php?vcode='.$VCode.'&amp;id='.$ID.'">Next 
Step</a>.</p>'; 
        $msg.=  '<div id="booking_details"><p>Please also check information you have provided below:</p>'.$bookingdetails.'</div>
        	<div id="booking_total" style="width:660px;"><br/>'.$paymentdetails.'</div><br/><br/>	        	
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
	
	$officemsg='<p>Please note that hew booking has been made on-line.<br/><strong>TOTAL: </strong>&#163; '.$Total.
	' </p>'.$bookingdetails.'<br/>Link to confirmation page:<br/>
	<a href="http://www.intouristuk.com/visa_services/book_chinese_visa/application.php?vcode='.$VCode.'&amp;id='.$ID.'">Next
	 Step</a></p>'; 
	$officemsg= str_replace('class="bg2"',$bg2,$officemsg);
	$officemsg= str_replace('class="bg5"',$bg5,$officemsg);
	$officemsg= str_replace('class="bg6"',$bg6,$officemsg);
	$officesubject='New China Visa booking VIS'.$ID.' has been made on-line';
        $sender_email="visa@intouristuk.com";  
	$sender_name="IntouristUK Chinese Visa Services Team";      
        $replyto_email="visa@intouristuk.com";
	
			$mailheaders  = "MIME-Version: 1.0\r\n";
			$mailheaders .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$mailheaders .= "From: $sender_name <$sender_email>\r\n";
			$mailheaders .= "Reply-To: $replyto_email <$replyto_email>\r\n"; 
                        
	if (!(@mail($Email,"IntouristUK Chinese Visa Services Confirmation",stripslashes($msg), $mailheaders)))
        $sout.='Error send message';   
        @mail($officemail,$officesubject,stripslashes($officemsg), $mailheaders);
		
  return $sout;
}

function  SetSent($ID, $VCode, $fSent)
{
     $query = "Update visa_bookings set fSent='".$fSent."' where ID = ".$ID." and VCode= '".$VCode."'";     
     mysql_query($query) or die ("Invalid query: " . mysql_error());   
}

$fcheck = BookDataCheck($vt, $entry, $processing, $fcitizen, $Title, $FirstName, $LastName, $DOB,
                       $PassportNumber, $ExpireDate, $fb, $ReferenceNumber, $VisaStart, $VisaEnd, $Itinerary, $Address, 
                       $Phone, $Email, $Delivery, $DeliveryAddress, $Company, $Position, $CompanyAddress, $CompanyPostCode,
                       $CompanyPhone, $CompanyFax, $TravelPurpose, $TravelPeriod, $Children);
if ($fcheck=='')
   {
	$Total=CalcTotal($vt,$entry,$processing,$fcitizen, $fb, $fRegistration, $Delivery);	
	
        	            
	//form parts of the page with data to check  details                     
        $childrendetails='';
      
          
   	if (($Delivery=='by E-mail') && ($DeliveryAddress==''))   $DeliveryAddress = $Email;
        if ($fb==0) 
         	{
         		if (($vt==11)||($vt==10)) 
         		  {
         			$traveldetails ='<tr><td colspan="4" class="bg6">JOB DETAILS</td></tr>
         			<tr>
   			  	<td class="bg5">Position</td>
   			  	<td colspan="3" class="bg2">'.$Position.'</td>
   			  	</tr>
   			  	<tr>
   			  	<td class="bg5">Company Name</td>
   			  	<td colspan="3" class="bg2">'.$Company.'</td>
   			  	</tr>   			  	
   			  	<tr>
   			  	<td class="bg5">Address</td>
   			  	<td colspan="3" class="bg2">'.$CompanyAddress.', '.$CompanyPostCode.'</td>
   			  	</tr>
   			  	<tr>   			
   			  	<td class="bg5">Phone</td>
   			  	<td class="bg2">'.$CompanyPhone.'</td>
   			  	<td class="bg5">Fax</td>
   			  	<td class="bg2">'.$CompanyFax.'</td>
   			  	</tr>   			  	
         			<tr><td colspan="4" class="bg6">TRAVEL DETAILS</td></tr>
   			  	<tr>   			
   			  	<td class="bg5">Purpose of the Trip</td>
   			  	<td class="bg2">'.$TravelPurpose.'</td>
   			  	<td class="bg5">Travel Period</td>
   			  	<td class="bg2">'.$TravelPeriod.'</td>
   			  	</tr>
   			  	<tr>   			
   			  	<td class="bg5">Travel Start Date</td>
   			  	<td class="bg2">'.$VisaStart.'</td>
   			  	<td class="bg5">Travel End Date</td>
   			  	<td class="bg2">'.$VisaEnd.'</td>
   			  	</tr>
   			  	<tr>
   			  	<td class="bg5">Cities to visit</td>
   			  	<td colspan="3" class="bg2">'.$Itinerary.'</td>
   			  	</tr>';
   			  	if ($entry=="multiple") $childrendetails= 'Multiple visa can not include children!';
   			  	else $childrendetails='<tr>
   			  		<td class="bg5">Children</td>
   			  		<td colspan="3" class="bg2">'.$Children.'</td>
   			  		</tr>';
   			  }
         		else if (($vt==6)||($vt==16)) $traveldetails ='<tr><td colspan="4" class="bg6">TRAVEL DETAILS</td></tr>
   			<tr>
   			  	<td class="bg5">Travel Start Date</td>
   			  	<td class="bg2">'.$VisaStart.'</td>
   			  	<td class="bg5">Travel End Date</td>
   			  	<td class="bg2">'.$VisaEnd.'</td>
   			  </tr>
   			  <tr>
   			  	<td class="bg5">Itinerary</td>
   			  	<td colspan="3" class="bg2">'.$Itinerary.'</td>
   			  </tr>';
   			 else $traveldetails ='<tr><td colspan="4" class="bg6">TRAVEL DETAILS</td></tr>
   			 <tr>
   			  	<td class="bg5">Travel Start Date</td>
   			  	<td class="bg2">'.$VisaStart.'</td>
   			  	<td class="bg5">Travel End Date</td>
   			  	<td class="bg2">'.$VisaEnd.'</td>
   			  </tr>
   			  <tr>
   			  	<td class="bg5">Itinerary</td>
   			  	<td class="bg2">'.$Itinerary.'</td>
   			  	<td class="bg5">Stay in China</td>
   			  	<td class="bg2">'.$Address.'</td>
   			  </tr>';
   		}
   	   else   $traveldetails ='<tr>
   			  	<td colspan="4" class="bg6">TRAVEL DETAILS</td>
   			  </tr>
   			  <tr>
                    		<td colspan="2" class="bg5">Your Travel Booking Reference Number</td>
   		   		<td colspan="2" class="bg2">'.$ReferenceNumber.'</td>   		  
   		   	  </tr>';
   		 
   		   
        
           $bookingdetails='<table width="560" cellspacing="1" cellpadding="0" border="0"><tbody>
 		   <tr>
   			   <td colspan="4" class="bg6"> 
   			   TRAVELLER DETAILS
   			   </td>
   		   </tr>
   		   <tr>
   		   <td class="bg5">Name</td>
   		   <td colspan="3" class="bg2">'.$Title.' '.ucwords($FirstName).' '.ucwords($LastName).'</td>
   		   </tr>
   		   <tr>
   		   <td class="bg5">Date Of Birth</td>
   		   <td class="bg2">'.$DOB.'</td>
   		   <td class="bg5">Citizenship</td>
   		   <td class="bg2">'.$fcitizen.'</td>
   		   </tr>
   		   <tr>
   		   <td class="bg5">Passport No.</td>
   		   <td class="bg2">'.$PassportNumber.'</td>
   		   <td class="bg5">Expires</td>
   		   <td class="bg2">'.$ExpireDate.'</td>
   		   </tr>
   		   <tr>
   		   <td class="bg5">Phone</td>
   		   <td class="bg2">'.$Phone.'</td>
   		   <td class="bg5">E-mail</td>
   		   <td class="bg2">'.$Email.'</td>
   		   </tr>
   		   '.$childrendetails.'
   		   <tr>
   		   <td colspan="4" class="bg6" > 
   			   VISA DETAILS
   			   </td>
   		   </tr>
   		   <tr>
                   <td class="bg5">Service requested</td>
   		   <td colspan="3" class="bg2">'.$visa.'</td>   		  
   		   </tr>
   		   <tr>
                    <td class="bg5">Type of Visa</td>
   		   <td colspan="3" class="bg2">'.$visatype.'</td>   		  
   		   </tr>
   		   <tr>
   		   <td class="bg5">Number of Entries</td>
   		   <td class="bg2">'.$entry.'</td>
   		   <td class="bg5">Processing Speed</td>
   		   <td class="bg2">'.$processing.'</td>
   		   </tr>
   		   '.$traveldetails.'   		   
   		   <tr>
   		   <td colspan="4" class="bg6" > 
   			   DELIVERY DETAILS
   			   </td>
   		   </tr>
   		   <tr>
                   <td colspan="2"class="bg5">Preferred delivery method</td>
   		   <td colspan="2"class="bg2">'.$Delivery.'</td>
   		   </tr>
   		   <tr>
                   <td colspan="2" class="bg5">Address</td>  
   		   <td colspan="2"class="bg2">'.$DeliveryAddress.'</td>   		  
   		   </tr>
            </tbody></table>';
        
            $paymentdetails='<p style="font-size:10pt; margin-top:0;"><strong>TOTAL:</strong> &#163;'.$Total.'</p>
        <p style="color:#333333;font-family:arial;font-size:10pt;">Prices include:</p>
	<ul><li>Full Email &amp; Telephone visa support</li><li>
	Chinese visa centre and Chinese embassy fees </li><li>
	Chinese visa processing </li><li>
	Submission of your Chinese visa application to the Chinese embassy </li><li>
	Pick-up of the completed Chinese visa from the Chinese embassy with our in house courier service </li></ul>

	<p style="color:#333333;font-family:arial;font-size:10pt;">We accept payments by the one of following options:</p>
	<ul><li>In cash (made payable at IntouristUK office)</li><li>
	 By check (made payable at IntouristUK office)</li><li>
	 Credit / Debit Card. <i>Here at intouristUK we do not register or save your credit card details. </i></li><li>
	 Bank transfers (company only) </li></ul>';
	if ($vt==10) $paymentdetails.='<p style="color:#333333;font-family:arial;font-size:10pt;">Please 
	note that we will not be able to receive your Business Visa Invitation until we receive payment from you in full.</p>';
	else if ($vt==6) $paymentdetails.='<p style="color:#333333;font-family:arial;font-size:10pt;">Please 
	note that we will not be able to receive your visa support documents until we receive payment from you in full.</p>';
	else $paymentdetails.='<p style="color:#333333;font-family:arial;font-size:10pt;">Please note that we 
	will not be able to receive your visa until we receive payment from you in full.</p>';
	
	$rowID=BookDataSave( $country, $vt, $entry, $processing, $fcitizen, $Title, ucwords($FirstName), ucwords($LastName), $DOB,
                       $PassportNumber, $ExpireDate, $fb, $ReferenceNumber, $VisaStart, $VisaEnd, $Itinerary, $Address, 
                       $Phone, $Email, $Delivery, $DeliveryAddress, $Company, $Position, $CompanyAddress, $CompanyPostCode,
                       $CompanyPhone, $CompanyFax, $TravelPurpose, $TravelPeriod, $Children, $Total, $fRegistration, 
                       $bookingdetails, $paymentdetails);
                       	
	if ($rowID['fSent']=='0') 
	   {  
              $fsend = SendConfirmation($rowID['ID'], $rowID['VCode'], $Title, ucwords($FirstName), ucwords($LastName), $Email,$Total, $bookingdetails, $paymentdetails);  
              if ($fsend =='') $fsend = SetSent ($rowID['ID'], $rowID['VCode'], "1" );              
           } 
        $href="'".'location.href="/visa_services/book_chinese_visa/application.php?vcode='.$rowID['VCode'].'&amp;id='.$rowID['ID'].'"'."'";
        $top_content='<div style="font-size: 8pt; color: grey; width: 300px;" class="flright" id="booking_note">
         	<p style="font-size: 7.5pt; color: grey;"> It could take a few seconds for the confirmation e-mail to reach you. 
         	If you did not get the e-mail, please check if you can recieve e-mails from <strong>visa@intouristuk.com</strong> 
         	or simply add visa@intouristuk.com to your address book and <span style="cursor:pointer;" 
         	onClick="javascript:ReSendConfirmation('."'".$rowID['ID']."'".',   
                                         '."'".$rowID['VCode']."'".', '."'".$Title."'".',
                                         '."'".ucwords($FirstName)."'".', '."'".ucwords($LastName)."'".',
                                         '."'".$Email."'".', '."'".$Total."'".');" ><u>
         	click here to resend the confirmation e-mail</u></span>.</p>
        	</div>
        	<div style="width:660px;">
        	<p>Dear <strong>'.$Title.' '.ucwords($FirstName).' '.ucwords($LastName).'</strong>,</p>
        	<p>Thank you for your request. Your booking reference number is <strong>VIS'.$rowID['ID'].'</strong>.<br/>
        	Confirmation e-mail have been sent to your e-mail address <strong>'.$Email.'</strong>.</p>
        	<p class="special_price">Remember to submit your Chinese Visa Application by completing the next step.</p>
        	<p>Please also check information you have provided below:</p></div>';  
        
               
        echo '<h1>Confirm Your Booking</h1>'.$top_content. 
        '<div id="booking_total" class="flright" style="width:400px;">
           <input type="submit" style="float:right;" name="Confirm and Continue" class="continue_long"
            value="Submit Your Application" onclick='.$href.'">
            </input>'.$paymentdetails.'
	</div>
        <div id="booking_details">'.$bookingdetails.'
           <br/>
           <FORM  style="font-size:9pt;color:black; " >
                        Please follow <INPUT TYPE="button" class="input_button" VALUE="this link"  onClick="history.go(-1);return true;" 
        		style="font-size:9pt;color:black; background:white; border: 0px; cursor pointer; padding:0; 
        		border-bottom: 1px solid black;" > to correct your booking details.
        		<br/><br/>
           </FORM>
        </div>
        ';
   }
   else
   { 
   echo '<h1>Personal Details Verification</h1><p>Data check was not successful:</p><ul>'.$fcheck.'
   </ul><p>Please go back and correct your booking details.</p>
   <FORM><INPUT TYPE="button" class="input_button" VALUE="Back" onClick="history.go(-1);return true;"></FORM> '; 
   }

?>
</div>
<br class="clearfloat" />

<div id="block_bottom">
<?php   include('../../Resource/bottom2.html');?></div>
</div>

<?php include('../../Resource/googlescr.html'); ?>

</body>
</html>