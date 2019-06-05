<?php
/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die();

// init vars
$settings = json_decode($params->find('layout._widget'), true);

// load WK
if (!($wk = (@include JPATH_ADMINISTRATOR.'/components/com_widgetkit/widgetkit-app.php')
	and isset($settings['widget'])
	and $widget = $wk['widgets']->get($settings['widget']))
) {
	return;
}

JLoader::register('YOOtheme\Widgetkit\Content\Item', JPATH_ADMINISTRATOR . '/components/com_widgetkit/src/Content/Item.php');
$settings = array_merge($widget->getConfig('settings'), $settings);

// set Widget items
foreach ($items as $i => $item) {
	$items[$i] = new YOOtheme\Widgetkit\Content\Item($wk, $item);
}

// render
echo str_replace(
    '{wk}',
    $wk['config']->get('theme.support') === 'noconflict' ? 'wk' : 'uk',
    $wk['view']->render($widget->getConfig('view'), compact('widget', 'items', 'settings'))
);
