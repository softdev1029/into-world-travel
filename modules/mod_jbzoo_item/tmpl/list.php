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


$items   = $modHelper->getItems();
$count   = count($items);
$columns = (int)$params->get('item_cols', 1);
$border  = (int)$params->get('display_border', 1) ? 'rborder' : '';

if ($count) {

    echo '<ul id="' . $modHelper->getModuleId() . '" class="jbzoo yoo-zoo">';
    echo '';
    echo $modHelper->renderRemoveButton();

    if ($columns) {
        $j = 0;
        foreach ($items as $item) {

            $first = ($j == 0) ? ' first' : '';
            $last  = ($j == $count - 1) ? ' last' : '';
            $j++;

            $isLast = $j % $columns == 0;

            if ($isLast) {
                $last .= ' last';
            }

            $renderer = $modHelper->createRenderer('item');
            echo ''
                .   ''
                        . $renderer->render('item.' . $modHelper->getItemLayout(), array(
                            'item'   => $item,
                            'params' => $params
                        ))
                    . ''
                . '';

            if ($isLast) {
                echo JBZOO_CLR;
            }
        }

    } else {

        foreach ($items as $item) {
            $renderer = $modHelper->createRenderer('item');
            echo $renderer->render('item.' . $modHelper->getItemLayout(), array(
                'item'   => $item,
                'params' => $params
            ));
        }
    }

    echo '</ul>';
}


