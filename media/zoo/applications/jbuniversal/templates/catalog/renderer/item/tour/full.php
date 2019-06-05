<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Sergey Kalistratov <kalistratov.s.m@gmail.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


$align     = $this->app->jbitem->getMediaAlign($item, $layout);
$tabsId    = $this->app->jbstring->getId('tabs');

$element_color = $item->getElement('dfb325d4-75c9-4a05-8bb4-bb0c8857f30f'); // element id получаем так 
$data_color = (array)$element_color->data(); // получаем данные
//print_r($data_color);

?>

<?php if ($this->checkPosition('hb')) : ?>
    <div class="hb">
        <?php echo $this->renderPosition('hb'); ?>
        <?php if ($this->checkPosition('hbb')) : ?>
            <div class="hbb"><?php echo $this->renderPosition('hbb'); ?></div>
        <?php endif; ?>
        <?php if ($this->checkPosition('hbtext')) : ?>
            <div class="hbtext" <?php if ($this->checkPosition('color')) : ?>style="color:#<?php echo trim($this->renderPosition('color')); ?>;<?php if ($this->checkPosition('color2')) : ?>text-shadow:0px 0px 1px #<?php echo trim($this->renderPosition('color2')); ?>;<?php endif; ?>"<?php endif; ?>><div><div class="hbtext-box"><?php echo $this->renderPosition('hbtext'); ?></div></div></div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!--<div class="container">-->
    <div class="container">    
        
        
    <div class="block-sm">
      
      <p class="block-sm__title"><b>Why book with</b> <span>Logo</span></p>
      
      <ul class="block-sm__list">
        
        <li>
          
          <p><b>Our Expertise</b></p>
          <p>Travel Specialist since 1932</p>
          
        </li>
        
        
        <li>
          
          <p><b>Our Service</b></p>
          <p>UK offices and support while on holiday</p>
          
        </li>
        
        
        <li>
          
          <p><b>First Class Guides</b></p>
          <p>Learn from local experts with  real passion</p>
          
        </li>
        
        
        <li>
          
          <p><b>Peace of Mind</b></p>
          <p>Full ATOL, IATA, ABTA protection</p>
          
        </li>
        
      </ul>
      
    </div>
   
        
        <?php if ($this->checkPosition('alttitle')) : ?>
            <h1 class="item-title alttitle"><?php echo $this->renderPosition('alttitle'); ?></h1>
        <?php else: ?>

            <?php if ($this->checkPosition('title')) : ?>
                <h1 class="item-title alttitle"><?php echo $this->renderPosition('title'); ?><?php if ($this->checkPosition('code')) : ?> (<?php echo $this->renderPosition('code'); ?>)<?php endif; ?></h1>
            <?php endif; ?>
        <?php endif; ?>


        <?php if ($this->checkPosition('subtitle2')) : ?>
            <div class="item-subtitle2"><?php echo $this->renderPosition('subtitle2'); ?></div>
        <?php endif; ?>
        
        <?php if ($this->checkPosition('db')) : ?>
        <?php else: ?>
            <?php if ($this->checkPosition('advb')) : ?>
                <a class="contform<?php if ($this->checkPosition('hb')) : ?> hbbut<?php endif; ?>" href="/index.php?option=com_rsform&formId=<?php echo trim($this->renderPosition('advb')); ?>&name=<?php echo trim($this->renderPosition('title')); ?>&code=<?php echo trim($this->renderPosition('code')); ?>" target="_blank">
                Get your quote
                </a>

                <?php if ($this->checkPosition('file')) : ?>
                    <?php echo $this->renderPosition('file'); ?>
                <?php endif; ?>

            <?php else: ?>
                <a class="contform<?php if ($this->checkPosition('hb')) : ?> hbbut<?php endif; ?>" href="/index.php?option=com_rsform&formId=1&name=<?php echo trim($this->renderPosition('title')); ?>&code=<?php echo trim($this->renderPosition('code')); ?>" target="_blank">
                Get your quote
                </a>

                <?php if ($this->checkPosition('file')) : ?>
                    <?php echo $this->renderPosition('file'); ?>
                <?php endif; ?>

            <?php endif; ?>
        <?php endif; ?>
<div style="clear:both;"></div>



<?php if ($this->checkPosition('content')) : ?>
    <div class="item-content"><?php echo $this->renderPosition('content'); ?>    </div>
<?php endif; ?>



    <div id="<?php echo $tabsId; ?>" class="item-tabs jb-row">
        <ul class="jb-nav">
            <?php if ($this->checkPosition('tab1content') || $this->checkPosition('highlights')) : ?>
                <li class="active">
                    <a href="#item-desc" id="desc-tab">
                        <?php echo $this->renderPosition('tab1name'); ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($this->checkPosition('tab2content')) : ?>
                <li>
                    <a href="#item-int" id="prop-tab">
                        <?php echo $this->renderPosition('tab2name'); ?>
                    </a>
                </li>
            <?php endif; ?>
<?php if ($this->checkPosition('tab3hotel') ||$this->checkPosition('tab3content')) : ?>
            
                <li>
                    <a href="#item-acom" id="gallery-tab">
                        <?php echo $this->renderPosition('tab3name'); ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($this->checkPosition('tab4content')) : ?>
                <li>
                    <a href="#item-price" id="comments-tab">
                        <?php echo $this->renderPosition('tab4name'); ?>
                    </a>
                </li>
            <?php endif; ?>


            <?php if ($this->checkPosition('tab5content')) : ?>
                <li>
                    <a href="#item-tab5content" id="tab5content-tab">
                        <?php echo $this->renderPosition('tab5name'); ?>
                    </a>
                </li>
            <?php endif; ?>


                        <?php if ($this->checkPosition('tab6content')) : ?>
                <li>
                    <a href="#item-tab6content" id="tab6content-tab">
                        <?php echo $this->renderPosition('tab6name'); ?>
                    </a>
                </li>
            <?php endif; ?>

                        <?php if ($this->checkPosition('tab7content')) : ?>
                <li>
                    <a href="#item-tab7content" id="tab7content-tab">
                        <?php echo $this->renderPosition('tab7name'); ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->checkPosition('tabreviews')) : ?>
                <li>
                    <a href="#item-tabreviews" id="tabreviews-tab">
                        Reviews
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->checkPosition('advb')) : ?>
                <li>
                    <a href="#item-book" id="book-tab">
                        Send Enquiry
                    </a>
                </li>
            <?php endif; ?>
        </ul>

        <?php if ($this->checkPosition('tab1content') || $this->checkPosition('highlights')) : ?>
            <div class="tab-pane fade active in" id="item-desc">
              
              <div class="tableft">
                <div class="item-text">
                    <?php echo $this->renderPosition('tab1content', array('style' => 'block')); ?>
                </div>
                <div class="item-highlights">
                    <?php echo $this->renderPosition('highlights', array('style' => 'block')); ?>
                </div>
              </div>
              
                <?php if ($this->checkPosition('tab1banner') || $this->checkPosition('tab1modul') || $this->checkPosition('tab1gallery')) : ?>
                    <div class="tabright">
                        <?php if ($this->checkPosition('tab1banner')) : ?>
                            <div class="item-banner">
                                <?php echo $this->renderPosition('tab1banner', array('style' => 'block')); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->checkPosition('tab1modul')) : ?>
                            <div class="item-module">
                                <?php echo $this->renderPosition('tab1modul', array('style' => 'block')); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->checkPosition('tab1gallery')) : ?>
                            <div class="item-gallery">
                                <?php echo $this->renderPosition('tab1gallery', array('style' => 'block')); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->checkPosition('tab1blog')) : ?>
                            <div class="item-tab1blog">
                                <?php echo $this->renderPosition('tab1blog', array('style' => 'block')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>


        <?php if ($this->checkPosition('tab2content')) : ?>
            <div class="jb-tab-pane" id="item-int">
                <div class="item-tab2content">
                    <?php echo $this->renderPosition('tab2content', array('style' => 'block')); ?>
                </div>
            </div>
        <?php endif; ?>



        <?php if ($this->checkPosition('tab3hotel') ||$this->checkPosition('tab3content')) : ?>
            <div class="jb-tab-pane" id="item-acom">
                <div class="item-tab3hotel">
                    <?php echo $this->renderPosition('tab3hotel', array('style' => 'block')); ?>
                </div>
                <div class="item-tab3content">
                    <?php echo $this->renderPosition('tab3content', array('style' => 'block')); ?>
                </div>
                <div class="item-tab3gallery">
                    <?php echo $this->renderPosition('tab3gallery', array('style' => 'block')); ?>
                </div>
                    <div id="<?php echo 'ac'.$tabsId; ?>" class="item-tabs jb-row <?php if ($this->checkPosition('tab3acccabin1nimg')) : ?>cruise<?php endif; ?>">
                        <ul class="jb-nav">
                            <?php if ($this->checkPosition('tab3acccabin1') || $this->checkPosition('tab3acccabin1nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin1" id="tab3acccabin1-tab">
                                        <?php echo $this->renderPosition('tab3acccabin1'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin1nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin2') || $this->checkPosition('tab3acccabin2nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin2" id="tab3acccabin2-tab">
                                        <?php echo $this->renderPosition('tab3acccabin2'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin2nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin3') || $this->checkPosition('tab3acccabin3nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin3" id="tab3acccabin3-tab">
                                        <?php echo $this->renderPosition('tab3acccabin3'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin3nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin4') || $this->checkPosition('tab3acccabin4nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin4" id="tab3acccabin4-tab">
                                        <?php echo $this->renderPosition('tab3acccabin4'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin4nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin5') || $this->checkPosition('tab3acccabin5nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin5" id="tab3acccabin5-tab">
                                        <?php echo $this->renderPosition('tab3acccabin5'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin5nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin6') || $this->checkPosition('tab3acccabin6nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin6" id="tab3acccabin6-tab">
                                        <?php echo $this->renderPosition('tab3acccabin6'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin6nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin7') || $this->checkPosition('tab3acccabin7nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin7" id="tab3acccabin7-tab">
                                        <?php echo $this->renderPosition('tab3acccabin7'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin7nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin8') || $this->checkPosition('tab3acccabin8nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin8" id="tab3acccabin8-tab">
                                        <?php echo $this->renderPosition('tab3acccabin8'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin8nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin9') || $this->checkPosition('tab3acccabin9nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin9" id="tab3acccabin9-tab">
                                        <?php echo $this->renderPosition('tab3acccabin9'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin9nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin10') || $this->checkPosition('tab3acccabin10nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin10" id="tab3acccabin10-tab">
                                        <?php echo $this->renderPosition('tab3acccabin10'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin10nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin11') || $this->checkPosition('tab3acccabin11nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin11" id="tab3acccabin11-tab">
                                        <?php echo $this->renderPosition('tab3acccabin11'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin11nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin12') || $this->checkPosition('tab3acccabin12nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin12" id="tab3acccabin12-tab">
                                        <?php echo $this->renderPosition('tab3acccabin12'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin12nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin13') || $this->checkPosition('tab3acccabin13nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin13" id="tab3acccabin13-tab">
                                        <?php echo $this->renderPosition('tab3acccabin13'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin13nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin14') || $this->checkPosition('tab3acccabin14nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin14" id="tab3acccabin14-tab">
                                        <?php echo $this->renderPosition('tab3acccabin14'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin14nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin15') || $this->checkPosition('tab3acccabin15nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin15" id="tab3acccabin15-tab">
                                        <?php echo $this->renderPosition('tab3acccabin15'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin15nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($this->checkPosition('tab3acccabin16') || $this->checkPosition('tab3acccabin16nimg')) : ?>
                                <li class="active">
                                    <a href="#item-tab3acccabin16" id="tab3acccabin16-tab">
                                        <?php echo $this->renderPosition('tab3acccabin16'); ?>
                                        <?php echo $this->renderPosition('tab3acccabin16nimg'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                
                
                        <?php if ($this->checkPosition('tab3acccabin1content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin1">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin1image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin1gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin1content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin1shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                
                
                        <?php if ($this->checkPosition('tab3acccabin2content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin2">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin2image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin2gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin2content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin2shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                
                
                        <?php if ($this->checkPosition('tab3acccabin3content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin3">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin3image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin3gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin3content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin3shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($this->checkPosition('tab3acccabin4content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin4">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin4image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin4gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin4content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin4shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                
                
                
                        <?php if ($this->checkPosition('tab3acccabin5content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin5">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin5image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin5gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin5content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin5shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                
                
                        <?php if ($this->checkPosition('tab3acccabin6content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin6">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin6image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin6gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin6content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin6shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                
                
                        <?php if ($this->checkPosition('tab3acccabin7content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin7">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin7image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin7gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin7content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin7shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php if ($this->checkPosition('tab3acccabin8content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin8">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin8image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin8gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin8content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin8shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php if ($this->checkPosition('tab3acccabin9content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin9">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin9image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin9gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin9content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin9shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php if ($this->checkPosition('tab3acccabin10content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin10">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin10image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin10gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin10content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin10shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php if ($this->checkPosition('tab3acccabin11content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin11">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin11image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin11gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin11content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin11shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php if ($this->checkPosition('tab3acccabin12content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin12">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin12image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin12gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin12content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin12shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->checkPosition('tab3acccabin13content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin13">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin13image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin13gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin13content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin13shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php if ($this->checkPosition('tab3acccabin14content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin14">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin14image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin14gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin14content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin14shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php if ($this->checkPosition('tab3acccabin15content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin15">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin15image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin15gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin15content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin15shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php if ($this->checkPosition('tab3acccabin16content')) : ?>
                            <div class="tab-pane fade active in" id="item-tab3acccabin16">
                                <div class="item-column">
                                    <?php echo $this->renderPosition('tab3acccabin16image', array('style' => 'block')); ?>
                                    <?php echo $this->renderPosition('tab3acccabin16gallery', array('style' => 'block')); ?>
                                </div>
                                <div class="item-text">
                                    <?php echo $this->renderPosition('tab3acccabin16content', array('style' => 'block')); ?>
                                </div>
                                <div class="item-shema">
                                    <?php echo $this->renderPosition('tab3acccabin16shema', array('style' => 'block')); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
            </div>
        <?php endif; ?>



        <?php if ($this->checkPosition('tab4content')) : ?>
            <div class="jb-tab-pane" id="item-price">
                <div class="item-tab4content">
                    <?php echo $this->renderPosition('tab4content', array('style' => 'block')); ?>
                </div>
            </div>
        <?php endif; ?>


        <?php if ($this->checkPosition('tab5content')) : ?>
            <div class="jb-tab-pane" id="item-tab5content">
                <div class="item-tab5content">
                    <?php echo $this->renderPosition('tab5content', array('style' => 'block')); ?>
                </div>
            </div>
        <?php endif; ?>


        <?php if ($this->checkPosition('tab6content')) : ?>
            <div class="jb-tab-pane" id="item-tab6content">
                <div class="item-tab6content">
                    <?php echo $this->renderPosition('tab6content', array('style' => 'block')); ?>
                </div>
              </div>
        <?php endif; ?>


        <?php if ($this->checkPosition('tab7content')) : ?>
            <div class="jb-tab-pane" id="item-tab7content">
                <div class="item-tab7content">
                    <?php echo $this->renderPosition('tab7content', array('style' => 'block')); ?>
                </div>
              </div>
        <?php endif; ?>
        
        
        <?php if ($this->checkPosition('tabreviews')) : ?>
            <div class="jb-tab-pane" id="item-tabreviews">
                <div class="item-tabreviews">
                    <?php echo $this->renderPosition('tabreviews', array('style' => 'block')); ?>
                </div>
              </div>
        <?php endif; ?>
        
        
        <?php if ($this->checkPosition('advb')) : ?>
            <div class="jb-tab-pane" id="item-book">
                <div class="item-book">
        
        <?php
        $formId = trim($this->renderPosition('advb'));
// Check if RSForm! Pro can be loaded

        $helper = JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';
        if (file_exists($helper)) {
            require_once($helper);
            
        }
        



    // Load language
                JFactory::getLanguage()->load('com_rsform', JPATH_SITE);

                echo RSFormProHelper::displayForm($formId, true);


    ?>
        </div>
              </div>
        <?php endif; ?>
        
    </div>


<div class="telbottomtour">
    <i>Contact us by phone or email today with any queries, to book, or for excellent rates and service on add-ons to your trip.</i>
    <div class="contformb">
        <div>
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <tr>
                        <td>
                            <a href="/contact-us"  class="contcallourb">
                                <span class="callourb">Call Our Booking/Enquiry Line On</span><br>
                                <span class="telcalb">
                                    <img src="/images/phone-icon.png" width="20" height="20"> <b>+44(0)2076035045 (UK)</b><br><b>+14377009339 (CANADA, US)</b>
                                </span>
                           </a>
                        </td>
                        <td align="right">
                            <a class="makeanenquiry" href="/index.php?option=com_rsform&formId=<?php if ($this->checkPosition('advb')) { echo trim($this->renderPosition('advb')); } else { echo '1';} ?>&name=<?php echo trim($this->renderPosition('title')); ?>&code=<?php echo trim($this->renderPosition('code')); ?>" target="_blank">
                            Make an Enquiry Online
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


    </div>

<?php 
$this->app->jbassets->tabs();
echo $this->app->jbassets->widget('#' . $tabsId, 'JBZooTabs');
echo $this->app->jbassets->widget('#ac' . $tabsId, 'JBZooTabs');