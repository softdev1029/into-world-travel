<?php
defined("_JEXEC") or die("Access deny");
$input = JFactory::getApplication()->input;
?>
<div class="xdsoft_object_description_ballon">
<?php
$meta = is_string($object->metadata) ? (json_decode($object->metadata)?:new stdClass()) : $object->metadata;
if (isset($meta->image) and trim($meta->image)!='') { ?>
	<div class="xdsoft_imagebox"><img src="<?php echo jhtml::_('xdwork.thumb', $meta->image, 300);?>" alt="<?php echo $object->title;?>"></div>
<?php }

$dispatcher = JEventDispatcher::getInstance();
$description = $object->description;

$dispatcher->trigger('generateDescription', array(&$description, $object));
echo $description;

if ($map && $map->settings->get('show_more_in_balloon', 1) && $input->get('task') !== 'object') {
    echo '<div class="xdsoft_more_link"><a target="'. ($object->target ? $object->target : '_self') . '" href="' . $object->link . '">Подробнее</a></div>';
}
?>
</div>
