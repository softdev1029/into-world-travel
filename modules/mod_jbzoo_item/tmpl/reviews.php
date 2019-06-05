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
$border  = (int)$params->get('display_border', 1) ? 'rborder' : 'no-border';

if ($count) {

    echo '<div class="reviews__carousel">';
    echo '';
    //echo $modHelper->renderRemoveButton();

    if ($columns) {

        $j = $i = 0;

        $rowItem = array_chunk($items, $columns);

        echo '';

        foreach ($rowItem as $row) {
            echo '';

            foreach ($row as $item) {

                $app_id = $item->application_id;
                $first  = ($j == 0) ? ' first' : '';
                $last   = ($j == $count - 1) ? ' last' : '';
                $j++;

                $isLast = $j % $columns == 0;

                if ($isLast) {
                    $last .= ' last';
                }

                $renderer = $modHelper->createRenderer('item');

                echo '<div class="reviews__item">'
                        . ''
                            . $renderer->render('item.' . $modHelper->getItemLayout(), array(
                                'item'   => $item,
                                'params' => $params
                            ))
                        . ''
                    . '</div>';
            }

            $i++;

            echo '';
        }

        echo '';


    } else {

        foreach ($items as $item) {
            $renderer = $modHelper->createRenderer('item');
            echo '<div class="reviews__item">'
            . $renderer->render('item.' . $modHelper->getItemLayout(), array(
                'item'   => $item,
                'params' => $params
            )). '</div>';
        }
    }

    echo '</div>';
}

