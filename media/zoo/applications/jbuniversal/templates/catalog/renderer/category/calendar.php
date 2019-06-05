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
    <div class="catalog categorynew rborder alias-<?php echo $category->alias; ?>">
<div class="container">
       <?php if ((int)$vars['params']->get('template.category_title_show', 1)) : ?>
            <h1 class="catalog__title"><?php echo $title; ?></h1>
        <?php endif; ?>

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
            <div class="description-teaser catalog__desc">
                <?php echo $vars['params']->get('content.category_teaser_text', ''); ?>
            </div>
        <?php endif; ?>


        <?php if ((int)$vars['params']->get('template.category_text', 1) && $category->description) : ?>
            <div class="description-full catalog__desc"><?php echo $category->getText($category->description); ?></div>
        <?php endif; ?>


        <?php echo JBZOO_CLR; ?>
        </div>
    </div>
    <?php
    //$categories = $this->category->getChildren();
    //echo $this->app->jblayout->render('subcategories', $categories); 
    $application = $this->app->zoo->getApplication();
$categoryTree = $application->getCategoryTree(true);
//$categoryTree = $application->getCategories();
//$categories = $this->app->table->category->getByName('13');
//$categories = $this->app->getCategoryTree('13');
//$category = $item->getPrimaryCategory();
//echo $this->app->route->category($category);
//print_r($categoryTree[128]->alias);

//jbdump($categoryTree[128]->item_ids);
    ?>
 
<section class="catalog">
<div class="container subcategoriesnew clearfix subcategory-col-1">    

<?php        
if (!empty($categoryTree[128]->item_ids)){
//echo $categoryTree[128]->alias;?>

        <div class="calendar-title">
            <a href="/calendar/january" title="January">January</a>
                    </div>
                   <?php   }
if (!empty($categoryTree[127]->item_ids)){
?>
        <div class="calendar-title">
            <a href="/calendar/february" title="February">February</a>
                    </div>
                   <?php   }
if (!empty($categoryTree[126]->item_ids)){
?>
        <div class="calendar-title">
            <a href="/calendar/march" title="March">March</a>
                    </div>
                   <?php   }
if (!empty($categoryTree[125]->item_ids)){
?>
        <div class="calendar-title">
            <a href="/calendar/april" title="April">April</a>
                    </div>
                   <?php   }
if (!empty($categoryTree[124]->item_ids)){
?>
        <div class="calendar-title">
            <a href="/calendar/may" title="May">May</a>
                    </div>
                   <?php   }
if (!empty($categoryTree[123]->item_ids)){
?>
        <div class="calendar-title">
            <a href="/calendar/june" title="June">June</a>
                    </div>
                   <?php   }
if (!empty($categoryTree[122]->item_ids)){
?>
        <div class="calendar-title">
            <a href="/calendar/july" title="July">July</a>
                    </div>
                   <?php   }
if (!empty($categoryTree[121]->item_ids)){
?>
        <div class="calendar-title">
            <a href="/calendar/august" title="August">August</a>
                    </div>
                   <?php   }
if (!empty($categoryTree[120]->item_ids)){
?>
        <div class="calendar-title">
            <a href="/calendar/september" title="September">September</a>
                    </div>
                   <?php   }
if (!empty($categoryTree[119]->item_ids)){
?>
        <div class="calendar-title">
            <a href="/calendar/october" title="October">October</a>
                    </div>
                   <?php   }
if (!empty($categoryTree[118]->item_ids)){
?>
        <div class="calendar-title">
            <a href="/calendar/november" title="November">November</a>
                    </div>
                   <?php   }
if (!empty($categoryTree[117]->item_ids)){
?>
        <div class="calendar-title">
            <a href="/calendar/december" title="December">December</a>
                    </div>
                   <?php   }

?>
</div></section>
<?php else: ?>

    <div class="category alias-<?php echo $category->alias; ?>">
        <?php if ((int)$vars['params']->get('template.category_title_show', 1)) : ?>
            <h1 class="title"><?php echo $title; ?></h1>
        <?php endif; ?>
    </div>

<?php endif; ?>

<?php
$this->app->jbdebug->mark('layout::category::finish');
