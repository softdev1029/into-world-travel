<?php
/**
 * @package   FL Gallery Image Element for Zoo
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

App::getInstance('zoo')->jbassets->jbimagePopup();

echo '<a ' . $linkAttrs . '><img ' . $imageAttrs . ' /></a> ' . PHP_EOL;
