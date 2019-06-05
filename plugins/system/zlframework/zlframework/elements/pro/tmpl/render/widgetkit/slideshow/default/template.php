<?php
/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */ 

defined('_JEXEC') or die();

	$widget_id  = $widget->id.'-'.uniqid();
	$settings   = $widget->settings;
	$navigation = array();
	$captions   = array();
	
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

<div id="slideshow-<?php echo $widget_id; ?>" class="yoo-wk wk-slideshow wk-slideshow-default" data-widgetkit="slideshow" data-options='<?php echo json_encode($settings); ?>'>
	<div>
		<ul class="slides">

			<?php $i = 0; foreach ($items as $key => &$item) : ?>
			<?php
				$navigation[] = '<li><span></span></li>';
				$captions[]   = '<li>'.(isset($item['caption']) ? $item['caption']:"").'</li>';
			
				/* Lazy Loading */
				$item["content"] = ($i==$settings['index']) ? $item["content"] : $widgetkit['image']->prepareLazyload($item["content"]);
			?>
			<li>
				<article class="wk-content clearfix"><?php echo $item['content']; ?></article>
			</li>
			<?php $i=$i+1;?>
			<?php endforeach; ?>
		</ul>
		<?php if ($settings['buttons']): ?><div class="next"></div><div class="prev"></div><?php endif; ?>
		<?php if (!isset($settings['zl_captions']) || $settings['zl_captions']): ?><div class="caption"></div><ul class="captions"><?php echo implode('', $captions);?></ul><?php endif; ?>
	</div>
	<?php echo ($settings['navigation'] && count($navigation)) ? '<ul class="nav">'.implode('', $navigation).'</ul>' : '';?>
</div>