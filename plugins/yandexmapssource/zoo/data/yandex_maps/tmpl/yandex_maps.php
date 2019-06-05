<?php
defined('_JEXEC') or die('Restricted access');
JHtml::addIncludePath(JPATH_ROOT.'/components/com_yandex_maps/helpers');
JHtml::addIncludePath(JPATH_ROOT.'/administrator/components/com_yandex_maps/helpers/html');
if ($params->get('map_id')) {
	include_once JPATH_ADMINISTRATOR."/components/com_yandex_maps/helpers/CModel.php";
	JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_yandex_maps/models');
	$map = JModelLegacy::getInstance('Maps', 'Yandex_MapsModel')->model($params->get('map_id'));
	if (!$map->id) { ?>
		<p class="text-danger">Карта не задана</p>
	<?php } else {
		jhtml::_('xdwork.frontjs');
		$location =  json_decode($this->get('location'));
		if ($location) {
			$map->lat = $location->lat;
			$map->lan = $location->lan;
			$map->zoom = $location->zoom ? $location->zoom : 10;
		}
		
		if ($params->get('alone')) {
			$dispatcher = JEventDispatcher::getInstance();
			JPluginHelper::importPlugin('yandexmapssource');
			$data = $dispatcher->trigger('onGetObjectsByBound', array($map, array(), 0, 1, array(), false, 'zoo'.$this->getItem()->id));
			if ($data[0] && $data[0][0]) {
				$data[0][0]->_data = array();
				foreach ($data[0][0] as $key=>$value) {
					$data[0][0]->_data[$key] = $value;
				}
				echo JHtml::_('map.show', $map, $data[0][0]);
			}
		} else {
			echo JHtml::_('map.show', $map);
		}
		
	}
} else { ?>
	<p class="text-danger">Карта не задана</p>
<?php }
