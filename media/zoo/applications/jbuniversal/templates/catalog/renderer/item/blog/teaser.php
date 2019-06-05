<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Denis Smetannikov <denis@jbzoo.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


$align = $this->app->jbitem->getMediaAlign($item, $layout);
if ($this->renderPosition('title') == ' Bestseller '){
$coloritem = 'catalog__label--blue';
}
else {
  $coloritem = 'catalog__label--red';  
}
?>




               <div class="catalog__img">

                <?php if ($this->checkPosition('image')) : ?>
    
        <?php echo $this->renderPosition('image'); ?>
    
<?php endif; ?>
                <?php if ($this->checkPosition('title')) : ?>
    <p class="catalog__label <?php echo $coloritem; ?>"><?php echo $this->renderPosition('title'); ?></p>
<?php endif; ?>

<?php if ($this->checkPosition('title2')) : ?>
<h3 class="catalog__name"><?php echo $this->renderPosition('title2'); ?></h3>
<?php endif; ?>

              </div>


              <div class="catalog__caption">
<?php if ($this->checkPosition('day', 'flights')) : ?>
                <p class="catalog__txt"><?php echo $this->renderPosition('day'); ?> day tour <i class="fa fa-plane" aria-hidden="true"></i> <?php echo $this->renderPosition('flights'); ?></p>
                <?php endif; ?>
                <?php if ($this->checkPosition('typet') || $this->checkPosition('typet1')) : ?>
                <p class="catalog__txt"><?php echo $this->renderPosition('typet'); ?> <?php if ($this->checkPosition('typet') && $this->checkPosition('typet1')) : ?>/<?php endif; ?> <?php echo $this->renderPosition('typet1'); ?></p>
                <?php endif; ?>
                <?php if ($this->checkPosition('text')) : ?>
    <div class="catalog__txt"><?php echo $this->renderPosition('text', array('style' => 'block')); ?></div>
<?php endif; ?>
               
                <?php if ($this->checkPosition('price')) : ?>
                <div class="catalog__txt  catalog__txt--bg">From <?php echo $this->renderPosition('price'); ?></div>
<?php endif; ?>
                <a class="catalog__btn" href="<?php echo $this->app->route->item($this->_item); ?>">Read More</a>

              </div>
              
              
              
              
<?php echo JBZOO_CLR; ?>