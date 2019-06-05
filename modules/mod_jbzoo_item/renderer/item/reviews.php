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

//$element_img = $item->getElement('9786f7f0-5548-4a79-8ad5-6fe653f90e89'); // element id получаем так 
//$data_img = (array)$element_img->data(); // получаем данные
//print_r($data_img);

?>



            <?php if ($this->checkPosition('title')) : ?>
                <h3><?php echo $this->renderPosition('title'); ?></h3>
            <?php endif; ?>
            
            <?php if ($this->checkPosition('date')) : ?>
                <div class="rdate"><?php echo $this->renderPosition('date'); ?></div>
            <?php endif; ?>
            
            <?php if ($this->checkPosition('tour')) : ?>
                 <div class="rtour"><?php echo $this->renderPosition('tour'); ?></div>
            <?php endif; ?>

            <?php if ($this->checkPosition('text')) : ?>
                <?php echo $this->renderPosition('text'); ?>
            <?php endif; ?>
