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

//$element_link = $item->getElement('dd0098ef-dd7e-4a89-b872-138d21c84c10'); // element id получаем так 
//$data_link = (array)$element_link->data(); // получаем данные
//print_r($data_link);
//if ($this->renderPosition('type') == ' Bestselling '){
//$coloritem = 'special__item--blue';
//}
//else {
//  $coloritem = 'special__item--red';  
//}


?>





            <div class="travel__item">


<?php if ($this->checkPosition('image')) : ?>
                <?php echo $this->renderPosition('image'); ?>
            <?php endif; ?>
                
<?php if ($this->checkPosition('title')) : ?>
                <h3 class="travel__title"><?php echo $this->renderPosition('title'); ?></h3>
            <?php endif; ?>
                

                <a href="<?php echo $this->app->route->item($this->_item); ?>">Look more<img src="/templates/ir/img/arr-right.png" alt=""></a>
            </div>
            
            
            
            
            
            
            