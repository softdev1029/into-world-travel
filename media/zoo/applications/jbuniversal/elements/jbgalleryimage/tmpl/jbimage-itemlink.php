<?php
/**
 * @package   FL Gallery Image Element for Zoo
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


if ($link) {
    echo '<a ' . $linkAttrs . '><img ' . $imageAttrs . ' /></a> ' . PHP_EOL;
} else {
    echo '<img ' . $imageAttrs . ' /> ' . PHP_EOL;
}
