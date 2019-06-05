<?php 
$vtype=8; 
$fcitizen= $_POST['FCitizen'];
if ($fcitizen=='') $fcitizen='United Kingdom';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chinese Visa Services. Book Chinese Tourist Visa</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Book your Chinese Visa to visit China. Select your Chinese Tourist Visa Service" />
<meta name="keywords" content="Chinese Visa Services, Chinese tourist visa, Chinese tourist visa support, Chinese tourist visa support documents," />
  <meta name="rating" content="general" /> 
  <meta name="resource type" content="document" /> 
  <meta name="expires" content="never" /> 
  <meta name="copyright" content="2010, intouristuk.com" /> 
  <meta name="Robots" content="index,follow" /> 
  <meta name="Revisit-After" content="7 day" /> 
  <meta name="distribution" content="global" /> 
  <meta name="author" content="intouristuk.com" /> 
  <meta name="classification" content="Chinese Visa Services, Chinese tourist visa, Chinese tourist visa support, Chinese tourist visa support documents," /> 
  <meta name="google-site-verification" content="nlj28uiVr_AmzBmrEWLBB_eoKY9U0GF_M6pKVb6JuMc" />
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="/css/default.css" rel="stylesheet" type="text/css" />
</head>

<body class="visa">
<div id="block_main">
<div id="block_top"><?php   
	$top= implode("", file('../../../Resource/top_visa_booking.html'));	
 	$top=str_replace('[MENU]','<a href="/visa_services/china/chinese_visa/visa_to_china.php">CHINESE VISA SERVICES</a>',$top); 
 	$top=str_replace('[STEP]','SELECT VISA -> <span style="font-size:14.0pt;text-decoration:underline;">SERVICE</span> -> PERSONAL DETAILS -> CONFIRM -> SUBMIT YOUR APPLICATION',$top); 
 	echo $top; ?></div>
<div id="block_content"><?php include('../../../includes/visa_processing_details.php'); ?>
</div>
<br class="clearfloat" />

<div id="block_bottom"><?php   include('../../../Resource/bottom2.html');   ?></div>
</div>

<?php include('../../../Resource/googlescr.html'); ?>

</body>
</html>