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


$this->app->jbdebug->mark('layout::category::start');

// set vars
$category = $vars['object'];
$title = $this->app->string->trim($vars['params']->get('content.category_title', ''));
$subTitle = $this->app->string->trim($vars['params']->get('content.category_subtitle', ''));
$image = $this->app->jbimage->get('category_image', $vars['params']);

$title = $title ? $title : $category->name;

if ((int)$vars['params']->get('template.category_show', 1)) : ?>
    <div class="category luxury rborder alias-<?php echo $category->alias; ?>">

        <?php if ((int)$vars['params']->get('template.category_title_show', 1)) : ?>
            <h1 class="title"><?php echo $title; ?></h1>
        <?php endif; ?>
<a class="contform" href="/index.php?option=com_rsform&amp;formId=1&amp;name=General%20Enquiry" target="_blank"><img border="0" src="/images/enquiry-button.png" onmouseover="this.src='/images/enquiry-button-hover.png';return false;" onmouseout="this.src='/images/enquiry-button.png';return false;"></a>

        <?php if ((int)$vars['params']->get('template.category_subtitle', 1) && !empty($subTitle)) : ?>
            <h2 class="subtitle"><?php echo $subTitle; ?></h2>
        <?php endif; ?>


        <?php if ((int)$vars['params']->get('template.category_image', 1) && $image['src']) : ?>
            <div class="image-full align-<?php echo $vars['params']->get('template.category_image_align', 'left'); ?>">
                <img src="<?php echo $image['src']; ?>" <?php echo $image['width_height']; ?>
                     title="<?php echo $category->name; ?>" alt="<?php echo $category->name; ?>"/>
            </div>
        <?php endif; ?>


        <?php if ((int)$vars['params']->get('template.category_teaser_text', 1) && $vars['params']->get('content.category_teaser_text', '')) : ?>
            <div class="description-teaser">
                <?php echo $vars['params']->get('content.category_teaser_text', ''); ?>
            </div>
        <?php endif; ?>


        <?php if ((int)$vars['params']->get('template.category_text', 1) && $category->description) : ?>
            <div class="description-full"><?php echo $category->getText($category->description); ?></div>
        <?php endif; ?>


        <?php echo JBZOO_CLR; ?>
    </div>

<?php else: ?>

    <div class="category alias-<?php echo $category->alias; ?>">
        <?php if ((int)$vars['params']->get('template.category_title_show', 1)) : ?>
            <h1 class="title"><?php echo $title; ?></h1>
        <?php endif; ?>
    </div>

<?php endif; ?>

<?php
$this->app->jbdebug->mark('layout::category::finish');
