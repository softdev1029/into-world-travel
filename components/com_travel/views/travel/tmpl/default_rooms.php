<?php
 $rooms = $this->rooms;
 
 ?>

<div class="zen-roomspage-rooms">
  <div class="zen-roomspage-rooms-content">
    <div class="zen-roomspagerooms">
      <div class="zen-roomspagerooms-report-button">
      </div>
      <div class="zen-roomspagerooms-inner">
      
      <?php 
      if ($rooms){
		  
		   
      foreach ($rooms as $n=>$room):
	  
	  
      
   $d = array();
   $d['e'] = $this->data;
  $link =travel::link('room', '&room='.$n.'&id='.$this->row->id."&".http_build_query($d));
 
  
       ?>
        <div class="zen-roomspagerooms-room">
          <div class="zen-roomspageroom">
            <div class="zen-roomspageroom-content">
              <div class="zen-roomspageroom-content-item">
                <div class="zen-roomspagerate zen-roomspagerate-is-active">
                  <div class="zen-roomspagerate-inner">
                    <div class="zen-roomspagerate-name-wrap">
                      <div class="zen-roomspagerate-name">
                        <div class="zen-roomspagerate-name-title">
                         <?=$room['room_type']['text']?>
                        </div>
                      </div>
                    </div>
                    <div class="zen-roomspagerate-description">
                      <div class="zen-roomspagerate-valueadds">
                        <ul class="valueadds">
                          <li class="valueadds-item valueadds-item-has-popuptip valueadds-item-meal">
                            <div class="valueadds-item-title-wrapper">
                              <div class="valueadds-item-title">
                                
                                  <?=$room['room_mealtype']['text']?>
                              </div>
                             
                            </div>
                          </li>
                         
                          <!--<li class="valueadds-item valueadds-item-has-popuptip valueadds-item-payment">
                            <div class="valueadds-item-title-wrapper">
                              <div class="valueadds-item-title">
                               Payment at the hotel - For reservations, you need a card
                              </div>
                             
                            </div>
                          </li>-->
                        </ul>
                      </div>
                     
                    </div>
                    <div class="zen-roomspagerate-price-wrap">
                      <div class="zen-roomspagerate-price-inner zen-roomspagerate-price-inner-best">
                        <div class="zen-roomspagerate-price-content">
                          <div class="zen-roomspagerate-price-badge-wrapper">
                          </div>
                          <div class="zen-roomspagerate-price-info">
                            <div class="zen-roomspagerate-deal">
                              Best price at the hotel
                            </div>
                            <div class="zen-roomspagerate-price">
                              
                              <div class="zen-roomspagerate-price-value">
                                <?=travel::pr1($room['price'], $this->row)?>
                                <div class="zen-roomspagerate-detailedprice">
                                </div>
                              </div>
                              <div class="zen-roomspagerate-price-notice">
							   
                               <?=$this->e ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="zen-roomspagerate-button-wrapper">
                          <a class="zen-roomspagerate-button" href="<?=$link?>">
                            Reserve
                          </a>
                          
                        </div>
						
						<div class="zen-roomspagerate-price-notice">
						
						
						
						<?php
						 $class = '';
                                 if($room['cancellationPolicyStatus']=="Refundable"){
									//echo "Room does not incur a cancellation charge at the time of booking";
									$class= 'refundable';
								 }
								 
								 if($room['cancellationPolicyStatus']=="NonRefundable"){
									$class= 'non_refundable';
								 }
								 
								 if($room['cancellationPolicyStatus']=="Unknown"){
									$class= 'unknown_';
								 }
								

							 if($room['cancellationPolicyStatus'] =="Unknown"){
							   ?>
  
                               <a href="javascript:void(0)" ><?php echo 'Restrictions apply' ?></a>
							   <?php
							   
							 }else{ ?>
								 <a href="javascript:void(0)" class="<?php echo  $class ; ?>" ><?php echo $room['cancellationPolicyStatus'] ?></a>
							<?php  }  ?>
                               
                        </div>
                      </div>
                    </div>
                 </div>
               </div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; 
        }
        else
        {
            ?>
             <div style="    background: #efebeb;
    padding: 7px;
    border-radius: 10px;
    color: #230707;">
   Your search did not match any documents. <br/>Try changing search criteria.
   </div>
            <?php
        }
        ?>
         
        
      </div>
    </div>
  </div>
</div>
