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

$align     = $this->app->jbitem->getMediaAlign($item, $layout);
?>

<?php if ($this->checkPosition('title')) : ?>
    <h4 class="item-title"><?php echo $this->renderPosition('title'); ?></h4>
<?php endif; ?>

<?php if ($this->checkPosition('top')) : ?>
    <div class="item-text-top jb-row">
        <div class="width100">
            <?php echo $this->renderPosition('top', array('style' => 'block')); ?>
        </div>
    </div>
<?php endif; ?>


<div class="jb-row">
    <?php if ($this->checkPosition('image')) : ?>
        <div class="width100 clearfix">
            <div class="item-image align-<?php echo $align; ?> jb-divider-right">
                <?php echo $this->renderPosition('image'); ?>
            </div>
        </div>
    <?php endif; ?>
</div>



<?php if ($this->checkPosition('text')) : ?>
    <div class="item-text jb-row">
        <div class="width100">
            <?php echo $this->renderPosition('text', array('style' => 'block')); ?>
        </div>
    </div>
<?php endif; ?>


<?php if ($this->checkPosition('tours')) : ?>
    <div class="jb-row item-tours catalog clearfix">
        <h2>Coinciding Tours:</h2>
        <div class="width100 section-row">
            <?php echo $this->renderPosition('tours'); ?>
        </div>
    </div>
<?php endif; ?>
