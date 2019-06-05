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
?>

<?php if ($this->checkPosition('title')) : ?>
    <h5 class="item-title"><?php echo $this->renderPosition('title'); ?></h5>
<?php endif; ?>



<?php if ($this->checkPosition('image')) : ?>
    <div class="item-image hotel-image">
        <?php echo $this->renderPosition('image'); ?>
    </div>
<?php endif; ?>


<?php if ($this->checkPosition('prop1')) : ?>
    <div class="hotel-prop1">
        <?php echo $this->renderPosition('prop1', array('style' => 'block')); ?>
    </div>
<?php endif; ?>

<?php if ($this->checkPosition('prop2')) : ?>
    <div class="hotel-prop2">
        <?php echo $this->renderPosition('prop2', array('style' => 'block')); ?>
    </div>
<?php endif; ?>
<?php if ($this->checkPosition('prop3')) : ?>
    <div class="hotel-prop3">
        <?php echo $this->renderPosition('prop3', array('style' => 'block')); ?>
    </div>
<?php endif; ?>
<?php if ($this->checkPosition('prop4')) : ?>
    <div class="hotel-prop4">
        <?php echo $this->renderPosition('prop4', array('style' => 'block')); ?>
    </div>
<?php endif; ?>
<?php if ($this->checkPosition('prop5')) : ?>
    <div class="hotel-prop5">
        <?php echo $this->renderPosition('prop5', array('style' => 'block')); ?>
    </div>
<?php endif; ?>
<?php if ($this->checkPosition('prop6')) : ?>
    <div class="hotel-prop6">
        <?php echo $this->renderPosition('prop6', array('style' => 'block')); ?>
    </div>
<?php endif; ?>
<?php if ($this->checkPosition('prop7')) : ?>
    <div class="hotel-prop7">
        <?php echo $this->renderPosition('prop7', array('style' => 'block')); ?>
    </div>
<?php endif; ?>




<?php if ($this->checkPosition('text')) : ?>
    <?php echo $this->renderPosition('text', array('style' => 'block')); ?>
<?php endif; ?>




<?php echo JBZOO_CLR; ?>
