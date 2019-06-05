<div class="zen-roomspage-gallery-wrapper">
    <div class="zen-roomspage-gallery" >
     <div class="zen-roomspage-gallery-inner">
       <div class="zen-tablet-gallery">
        <div class="your-class">
   
   
   <div class="zen-tablet-gallery-thumb-big-wrapper">
   <?php  $f = str_replace('www.roomsxmldemo.com/RXLStagingImages', 'www.stuba.com/RXLImages', $this->all_foto[0]['Url']); ?>
   <a class="galery_travel" href="<?= $f ?>">
   <img class="zen-tablet-gallery-thumb-big-img" src="<?=$f ?>"   data-photonum="0">
   </a>
   </div>
   
      <?php 
	  
      $s =1;
      for($i==1; $i<count($this->all_foto); $i=$i+2)
      {
        
        if (isset($this->all_foto[$i])){
			
		$imageUrl = str_replace('www.roomsxmldemo.com/RXLStagingImages', 'www.stuba.com/RXLImages', $this->all_foto[$i]['Url']);
            
            ?> 
             <div class="zen-tablet-gallery-thumb-column">

   <div class="zen-tablet-gallery-thumb-wrapper">
    
   <a class="galery_travel" href="<?= $imageUrl; ?>">
   <img class="zen-tablet-gallery-thumb-img" src="<?= $imageUrl; ?>" data-photonum="3">
   </a>
   </div>
   <?php  if (isset($this->all_foto[$s+1])): ?>
     <?php 
     
	 $f = str_replace('www.roomsxmldemo.com/RXLStagingImages', 'www.stuba.com/RXLImages', $this->all_foto[$i-1]['Url']); ?>
    <div class="zen-tablet-gallery-thumb-wrapper">
   <a class="galery_travel" href="<?= $f ?>">
   <img class="zen-tablet-gallery-thumb-img" src="<?= $f; ?>" data-photonum="3">
   </a>
   </div>
   <?php endif; ?>
   
  </div>
            <?php
            
        }
        $s++;
      }
      
  ?>
   

</div>
       
       </div><!--zen-tablet-gallery-->
     </div>    
    </div><!--zen-roomspage-gallery-->
   
   </div><!--zen-roomspage-gallery-wrapper-->