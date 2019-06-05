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

$element_img = $item->getElement('9786f7f0-5548-4a79-8ad5-6fe653f90e89'); // element id получаем так 
$data_img = (array)$element_img->data(); // получаем данные
//print_r($data_img);

?>


            <img src="<?php echo $data_img[0]['file']; ?>" <?php if ($data_img[0]['title']) : ?>alt="<?php echo $data_img[0]['title']; ?>"<?php endif; ?>>

            <div class="banner__caption">
            <?php if ($this->checkPosition('title')) : ?>
                <h2 class="item-title"><?php echo $this->renderPosition('title'); ?></h2>
            <?php endif; ?>
            <?php if ($this->checkPosition('subtitle')) : ?>
                <p><?php echo $this->renderPosition('subtitle'); ?></p>
            <?php endif; ?>
             </div>


<?php //echo JBZOO_CLR; ?>
