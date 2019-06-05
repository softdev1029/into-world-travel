<?php
/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */ 

defined('_JEXEC') or die();

	$widget_id = $widget->id.'-'.uniqid();
	$settings  = $widget->settings;
	$content   = array();
	$nav       = ($settings['navigation']) ? 'nav-'.$settings['navigation'] : '';
	
	// ZL integration
	$items = $this->getRenderedValues($params, $widget->mode);
	$items = $items['result'];

	// if separator tag present wrap each item
	if(preg_match('/(^tag|\stag)=\[(.*)\]/U', $separator, $separated_by)){
		foreach($items as &$item) {
			$item['content'] = $this->app->zlfw->applySeparators($separated_by[0], $item['content'], $params->find('separator._class'), $params->find('separator._fixhtml'));
		}
	}
	unset($item);
?>

<div id="slideshow-<?php echo $widget_id; ?>" class="yoo-wk wk-slideshow wk-slideshow-tabsbar" data-widgetkit="slideshow" data-options='<?php echo json_encode($settings); ?>'>
	
	<div class="nav-container <?php echo $nav; ?> clearfix">
		<ul class="nav">
			<?php foreach ($items as $key => $item) : ?>
			<?php $content[] = '<li><article class="wk-content clearfix">'.$item['content'].'</article></li>'; ?>
			<li>
				<span><?php echo $item['title']; ?></span>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	
	<div class="slides-container"><?php echo (count($content)) ? '<ul class="slides">'.implode('', $content).'</ul>' : '';?></div>
	
</div>