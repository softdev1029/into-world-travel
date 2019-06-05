<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Andrey Voytsehovsky <kess@jbzoo.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

echo '<div class="jbvideo ' . $providerName . '">';

//display thumbnail or an iframe
if ($isThumb) {
    if ($thumbType == ElementJBVideo::THUMB_TYPE_ITEMLINK || $thumbType == ElementJBVideo::THUMB_TYPE_POPUP) {
        echo '<a ' . $thumbLink . '><img ' . $thumbAttrs . ' /></a>';
    } else {
        echo '<img ' . $thumbAttrs . ' />';
    }
} else {
    echo '<iframe ' . $videoAttrs . ' ></iframe>';
}

echo '</div>';

//initialize fancybox if pop-up option is enabled
if ($thumbType == ElementJBVideo::THUMB_TYPE_POPUP) : ?>
    <script>
        jQuery(document).ready(function () {
            jQuery('.jbvideo-popup').fancybox({
                type: 'iframe',
                autoSize: false,
                beforeLoad: function () {
                    this.width = parseInt(this.element.data('fancybox-width'));
                    this.height = parseInt(this.element.data('fancybox-height'));
                }
            });
        });
    </script>
<?php endif;