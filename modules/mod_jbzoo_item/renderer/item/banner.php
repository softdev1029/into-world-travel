<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Vitaliy Yanovskiy <joejoker@jbzoo.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

            <?php if ($this->checkPosition('titles')) : ?>
                <div class="item-titles <?php echo $this->renderPosition('color'); ?>"><?php echo $this->renderPosition('titles'); ?></div>
            <?php endif; ?>
<div class="wrapper-item-desc">
    <?php if ($this->checkPosition('image')) : ?>
        <div class="item-image align-<?php echo $params->get('items_image_align', 'left') ?>">
            <?php echo $this->renderPosition('image'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->checkPosition('description') ||
        $this->checkPosition('title')
    )  : ?>
        <div class="item-wrapper-desc">
            <?php if ($this->checkPosition('title')) : ?>
                <div class="item-title"><?php echo $this->renderPosition('title'); ?></div>
            <?php endif; ?>





            <?php if ($this->checkPosition('description')) : ?>
                <div class="item-description"><?php echo $this->renderPosition('description'); ?></div>
            <?php endif; ?>

        </div>

    <?php endif; ?>

</div>
<div class="item-links"><?php echo $this->renderPosition('links', array('style' => 'pipe')); ?></div>

<?php echo JBZOO_CLR; ?>
