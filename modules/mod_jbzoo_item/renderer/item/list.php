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
<li class="wrapper-item-desc">
    <?php if ($this->checkPosition('image')) : ?>
        <div class="item-image align-<?php echo $params->get('items_image_align', 'left') ?>">
            <?php echo $this->renderPosition('image'); ?>
        </div>
    <?php endif; ?>

            <?php if ($this->checkPosition('title')) : ?>
                <span class="item-title"><?php echo $this->renderPosition('title'); ?></span>
            <?php endif; ?>




</li>

<?php echo JBZOO_CLR; ?>
