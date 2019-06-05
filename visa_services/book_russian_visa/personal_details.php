<?php 
 $vtype = isset($_REQUEST["vt"]) ? addslashes($_REQUEST["vt"]) : '1';
 $fc    = isset($_REQUEST["fc"]) ? addslashes($_REQUEST["fc"]) : 'United_Kingdom';
 $fcitizen = str_replace('_',' ',$fc);
 $entry = isset($_REQUEST["entry"]) ? addslashes($_REQUEST["entry"]) : 'single';
 $pr    = isset($_REQUEST["pr"]) ? addslashes($_REQUEST["pr"]) : 'standard';
 $processing = str_replace('_',' ',$pr);	
 $fb    = isset($_REQUEST["fb"]) ? addslashes($_REQUEST["fb"]) : 'no';
  $text1='You have required 
  <span style="font-size:10pt;"><strong>[Pr]</strong></span> processing service of 
  <span style="font-size:10.0pt;"><strong>[Entry]</strong></span> entry 
  <span style="font-size:10.0pt;"><strong>[Visa]</strong></span> for 
  <span style="font-size:10pt;"><strong>[Country]</strong></span> passport holder.</p> ';
  $info= '<div id="security" style="background:rgb(207, 236, 254) none repeat scroll 0 0;
  width:300px;float:right;padding:0 0 10px 10px;">
  <p>Need help? Let us call you.</p>
<form action="/visa_services/book_russian_visa/thank_you_for_enquiry.php?vt='.$vtype.'&amp;fc='.$fc.
'&amp;entry='.$entry.'&amp;pr='.$pr.'&amp;fb='.$fbooked.'"" method="post">
 <table width="290" cellspacing="0" cellpadding="0" border="0"><tbody>
     <tr>  
     	<td width="115"><input width="114" id="CallPhone" value="Phone:" name="CallPhone" size="18" style="color: grey; 
     	font-size: 8pt;"></td>
     	<td width="115"><input width="114" style="color: grey; font-size: 8pt;" size="18" name="CallName" 
     	value="Name:" id="CallName"></td>
     	<td>&nbsp;</td>
     	<td width="60"><input width="60" type="submit" size="4" class="input_button" name="CallMe"
     	 value="Call me" style="padding: 2px 3px;"></td>
     </tr></tbody>
  </table>
  
  <p>
  Do you want to call us instead?<br>
  <strong>London: 44 (0) 207 603 5045</strong><br>
  Alternatively send us a message:</p>
  <table width="290" cellspacing="0" cellpadding="0" border="0"><tbody>
     <tr>  
     	<td width="230"><textarea style="width: 228px;" rows="2" name="Enquiry"></textarea></td><td>&nbsp;</td>
       	<td><input type="submit" class="input_button" name="Send" value="Send" style=""></td>
     </tr>	
    </tbody>
  </table>
  <p style="padding: 0pt 70px 0pt 0pt;">One of our visa consultant would be more than happy to assist you with your query.<br/>
  May we remind you that we are <strong>ABTA, ATOL and IATA</strong> registered, so you are fully protected.</p>
  <table width="230" cellspacing="0" cellpadding="4">
    <tbody><tr>
    <td align="center"><img width="200" height="55" src="/IMG/IATA_ATOL_ABTA_registered.jpg" 
    alt="IntouristUK is ABTA, ATOL and IATA registered, so you are fully protected"></td>
    </tr>
    </tbody>
  </table>
 <p style="padding: 0pt 70px 0pt 0pt;"> We also certified by <strong>Security Metrics</strong> for your peace of mind.</p>
  <table width="230" cellspacing="0" cellpadding="4">
    <tbody><tr>
    <td align="center">
       <img border="0" alt="SecurityMetrics for PCI Compliance, QSA, IDS, Penetration Testing, Forensics, 
       and Vulnerability Assessment" src="/IMG/security_metrics.png">
    </td>
    </tr>
    </tbody>
  </table>
  </form>
    
  </div>  ';
 if ($vtype==6) 
 	{
 	  $ss = implode("", file('../../Resource/visa_book_visa_support_only.html')); 
 	  $fbooked=0; 
 	  $visa='Russian Tourist Visa Support Documents';
 	  $strout.='<h1>Tourist Visa Support Documents. Personal Details</h1>';
 	  $topmenu='SELECT VISA -> SERVICE -> 
 	  <span style="font-size:13.0pt;text-decoration:underline;">PERSONAL DETAILS</span> -> CONFIRM -> E-MAIL YOUR DOCUMENTS';
 	}
 else if ($vtype==16) 
 	{
 	  $ss = implode("", file('../../Resource/visa_book_personal_plus_support.html')); 
 	  $fbooked=0; 
 	  $visa='Russian Tourist Visa and Visa Support Documents';
	  $strout.='<h1>Tourist Visa and Visa Support. Personal Details</h1>'; 
	  $topmenu='SELECT VISA -> SERVICE -> 
	  <span style="font-size:13.0pt;text-decoration:underline;">PERSONAL DETAILS</span> -> CONFIRM -> SUBMIT YOUR APPLICATION';
 	}
 else if ($vtype==5) 
 	{
 	  $ss = implode("", file('../../Resource/visa_book_business_invitation.html')); 
 	  if ($entry=='multiple')$ss=  str_replace('[CHILDREN]','',$ss); 
 	  else $ss = str_replace('[CHILDREN]','<tr><td colspan="2" style="vertical-align: top;">Children:</td>
      		<td>&nbsp;</td><td colspan="3"><input id="Children" value="" name="Children" width="155"  size="48"></td>
      		<td>&nbsp;</td>           
        	<td style="color:grey; font-size:8pt;vertical-align: top;">children over 16 years old
        	 if accompanying the passport holder</td></tr>',$ss);
 	  $fbooked=0; 
 	  $visa='Russian Business Visa Invitation from the Ministry of Foreign Affairs';
 	  $strout.='<h1>Business Visa Invitation. Personal Details</h1>';
 	  $topmenu='SELECT VISA -> SERVICE -> 
 	  <span style="font-size:13.0pt;text-decoration:underline;">PERSONAL DETAILS</span> -> CONFIRM -> E-MAIL YOUR DOCUMENTS';
 	}
  else if ($vtype==25) 		
	{ $ss = implode("", file('../../Resource/visa_book_business_invitation.html')); 
 	  if ($entry=='multiple')$ss=  str_replace('[CHILDREN]','',$ss); 
 	  else $ss = str_replace('[CHILDREN]','<tr><td colspan="2" style="vertical-align: top;">Children:</td>
      		<td>&nbsp;</td><td colspan="3"><input id="Children" value="" name="Children" width="155"  size="48"></td>
      		<td>&nbsp;</td>           
        	<td style="color:grey; font-size:8pt;vertical-align: top;">children over 16 years old 
        	if accompanying the passport holder</td></tr>',$ss);
 	  $fbooked=0; 
	  $visa='Russian Business Visa and Invitation from the Ministry of Foreign Affairs';
	  $strout.='<h1>Business Visa and Invitation. Personal Details</h1>';
	  $topmenu='SELECT VISA -> SERVICE -> <span style="font-size:13.0pt;text-decoration:underline;">PERSONAL 
	  DETAILS</span> -> CONFIRM -> SUBMIT YOUR APPLICATION';
	}
 else if ($fb=="yes") 
 	{
 	  $ss = implode("", file('../../Resource/visa_book_personal_tourist_ref.html'));
 	  $fbooked=1; 
 	  $topmenu='SELECT VISA -> SERVICE -> <span style="font-size:13.0pt;text-decoration:underline;">PERSONAL 
 	  DETAILS</span> -> CONFIRM -> SUBMIT YOUR APPLICATION';
 	}
 else   { 
 	  $ss = implode("", file('../../Resource/visa_book_personal_tourist.html'));
 	  $fbooked=0; 
 	  $topmenu='SELECT VISA -> SERVICE -> <span style="font-size:13.0pt;text-decoration:underline;">PERSONAL 
 	  DETAILS</span> -> CONFIRM -> SUBMIT YOUR APPLICATION';
 	}
 if ($vtype==1) 		
	{
	  $visa='Russian Tourist Visa';
	  $strout.='<h1>Tourist Visa. Personal Details</h1>';
	}  
 else if ($vtype==2) 		
	{
	  $visa='Russian Business Visa';
	  $strout.='<h1>Business Visa. Personal Details</h1>';
	} 

 else if ($vtype==3) 		
	{
	  $visa='Russian Private Visa';
	  $strout.='<h1>Private Visa. Personal Details</h1>';
	}
 else if ($vtype==4) 		
	{
	  $visa='Russian Transit Visa';
	  $strout.='<h1>Transit Visa. Personal Details</h1>';
	}	
 if (!(($vtype==6) or ($vtype==5))) $text='<p>Please provide your contacts and basic details of your trip to help us to
  deal with your booking. Remember to fill in Visa Application form on the final step.<br/>'.$text1; else $text=$text1;		
 $ss = str_replace("[Action]",'action="/visa_services/book_russian_visa/confirm.php?vt='.$vtype.'&amp;fc='.$fc.
 '&amp;entry='.$entry.'&amp;pr='.$pr.'&amp;fb='.$fbooked.'"',$ss);
 $text=  str_replace("[Country]",$fcitizen,$text);	
 $text=  str_replace("[Pr]",$processing,$text);	
 $text=  str_replace("[Entry]",$entry,$text);
 $text=  str_replace("[Visa]",$visa, $text);

 
 
 $strout.=$text.$info.'<div style="width:640px;">'.$ss.'</div>';	 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Russian Visa Services. Book your <?php echo $visa;?>: Personal Details for <?php echo $entry;?> entry, 
<?php echo $pr;?> service, <?php echo $fc;?>, booked - <?php echo $fb;?>.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Book your <?php echo $visa;?> with the Russian Travel specialist since 1938. 
Personal Details" />
<meta name="keywords" content="Russian Visa Services, <?php echo $visa;?>, Russian visa, Visa Services, 
Book <?php echo $visa;?>" />
  <meta name="rating" content="general" /> 
  <meta name="resource type" content="document" /> 
  <meta name="expires" content="never" /> 
  <meta name="copyright" content="2010, intouristuk.com" /> 
  <meta name="Robots" content="noindex, nofollow" /> 
  <meta name="Revisit-After" content="7 day" /> 
  <meta name="distribution" content="global" /> 
  <meta name="author" content="intouristuk.com" /> 
  <meta name="classification" content="Russian Visa Services, <?php echo $visa;?>, Russian visa, Visa Services, 
  Book <?php echo $visa;?>" /> 
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