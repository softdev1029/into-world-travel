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
?>
<div class="catalog">
<div class="container">
<?php if ($this->checkPosition('title')) : ?>
    <h1 class="item-title catalog__title"><?php echo $this->renderPosition('title'); ?></h1>
<?php endif; ?>

    <div class="rborder jb-box jb-divider-bottom">
        <div class="jb-row clearfix">
            <div class="width50">
                <?php if ($this->checkPosition('image')) : ?>
                    <div class="item-image jb-divider-bottom">
                        <?php echo $this->renderPosition('image'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->checkPosition('meta')) : ?>
                    <div class="item-metadata jb-divider-bottom">
                        <ul class="unstyled">
                            <?php echo $this->renderPosition('meta', array('style' => 'list')); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ($this->checkPosition('buttons')) : ?>
                    <div class="item-buttons jb-divider-bottom clearfix">
                        <div class="width100">
                            <?php echo $this->renderPosition('buttons', array('style' => 'block')); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($this->checkPosition('price')) : ?>
                <div class="width50">
                    <div class="item-price">
                        <?php echo $this->renderPosition('price'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($this->checkPosition('social')) : ?>
            <div class="jb-row item-social last clearfix">
                <div class="width100">
                    <?php echo $this->renderPosition('social', array('style' => 'block')); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

        <?php if ($this->checkPosition('text')) : ?>
     
                <div class="item-text">
                    <?php echo $this->renderPosition('text', array('style' => 'block')); ?>
                </div>
  
        <?php endif; ?>
   <div class="rborder column">
<?php if ($this->checkPosition('related')) : ?>
    <div class="jb-row item-related">
        <div class="width100">
            <?php echo $this->renderPosition('related', array(
                'labelTag' => 'h4',
                'style'    => 'jbblock',
            )); ?>
        </div>
    </div>
<?php endif; ?>
</div>
  
  </div>
    </div>
<?php     
$this->app->jbassets->tabs();
echo $this->app->jbassets->widget('#' . $tabsId, 'JBZooTabs');
