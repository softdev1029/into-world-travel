<?php
defined( '_JEXEC' ) or die( '=;)' );
 
$version = "1.0.0";
 //print_r($_SERVER);
?>	
 
 <link rel="stylesheet" href="<?php echo JURI::root()?>administrator/components/com_travel/images/panel/css/style.css" type="text/css" />
   
   


<div class="well well-small">
<div class="module-title nav-header">Control panel</div>

 

<div class="clr"></div>

<div id="k2QuickIconsTitle">
	<a title="панель" href="/administrator/index.php?option=com_travel">
		<span>RoomXML</span>
	</a>
</div>
<div id="k2QuickIcons">
<table style="width: 100%;">

 <tr>
 
 
 <td style="vertical-align: top; width:70%">

<div class="icon-wrapper">
    <div class="icon">
	    <a href="index.php?option=com_travel&view=stranas">
		      <?php  travelHelper::I('icons8-контур-африки-48.png','width:48px')?>
		    <span>Countries(surcharges / Discounts)</span>
	    </a>
    </div>
  </div>
   <div class="icon-wrapper">
    <div class="icon">
	    <a href="index.php?option=com_travel&view=regions">
		      <?php  travelHelper::I('icons8-география-64.png','width:48px')?>
		    <span>Region</span>
	    </a>
    </div>
  </div>	
     
    	 <div class="icon-wrapper">
    <div class="icon">
	    <a href="index.php?option=com_travel&view=otels">
		      <?php  travelHelper::I('icons8-отель-5-звезд-40.png','width:48px')?>
		    <span>Hotels</span>
	    </a>
    </div>
  </div>   
  
  	 <div class="icon-wrapper">
    <div class="icon">
	    <a href="index.php?option=com_travel&view=grs">
		      <?php  travelHelper::I('icons8-группы-пользователей-48.png','width:48px')?>
		    <span>User groups</span>
	    </a>
    </div>
  </div>   
  
  <div class="icon-wrapper">
    <div class="icon">
	    <a href="index.php?option=com_travel&view=orders">
		      <?php  travelHelper::I('icons8-список-дел-64.png','width:48px')?>
		    <span>Orders</span>
	    </a>
    </div>
  </div>   
  
  </td>
  <td style="vertical-align: top;display: none" >
   
   
     
        <?php   travelHelper::I('food.png','width:16px')?>    <br />
        версия <?php  echo $version?><br />
      
        
        Разработка Федянин. <a target="_blank" href="">
           
     
  </td>
  <tr>
 
  </table> </div>
  <div style="clear: both;"></div>
  </div>

 

</div>   
   
   
          
