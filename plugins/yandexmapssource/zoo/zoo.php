<?php
/**
 * @copyright	Copyright (c) 2015 content. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;
jimport('joomla.plugin.plugin');

if (is_dir(JPATH_SITE . '/components/com_zoo/')) {
	JHtml::addIncludePath(JPATH_ROOT.'/components/com_yandex_maps/helpers');
	require_once(JPATH_ADMINISTRATOR.'/components/com_zoo/config.php');
	class plgYandexMapsSourceZoo extends JPlugin {
		public $id = 'zoo'; // идентификатор источника

		function __construct(&$subject, $config = array()) {
			parent::__construct($subject, $config);
		}

		public function onGetName(&$names) {
			$names[$this->id] = 'ZOO материалы';
		}

		public function onGetCategories($map) {
			$cats = array();
			$zoo = App::getInstance('zoo');
			if ($application = $zoo->table->application->get($this->params->get('application', 0))) {
				$categories = $application->getCategoryTree(true, null, false);
				if (count($categories)) {
					foreach ($categories as $category) {
						if (!$category->id) {
							continue;
						}
						$cat = new stdClass();
						$cat->title = $category->name;
						$cat->lat = $map->lat;
						$cat->lan = $map->lan;
						$cat->zoom = $map->zoom;
						$cat->link = $application->app->route->category($category);
						$cat->id = $this->id.$category->id;
						$cats[] = $cat;
					}
				}
			}
			return $cats;
		}

		public function onThisPageIsMine($map) {
			return false;
		}

		public function onGetObjectsByBound($map, $bound = array(), $offset = 0, $limit = 500, $exclude = array(), $search = false, $forse_id = 0) {
			$objects = array();
			$zoo = App::getInstance('zoo');
			if ($application = $zoo->table->application->get($this->params->get('application', 0))) {
				$items = $zoo->table->item->findAll($application->id, true);
				$layout = 'teaser';
				$renderer = $zoo->renderer->create('item')->addPath(array($zoo->path->path('component.site:'), $application->getTemplate()->getPath()));
				foreach($items as $item) {
					if ($forse_id && $forse_id !== $this->id.$item->id) {
						continue;
					}
					foreach ($item->getElements() as $element) {
						foreach($element as $prop=>$data) {
							if (get_class($element) == 'ElementYandex_Maps' and $element->get('location') and ($address = json_decode($element->get('location')))) {
								$object = new stdClass();
								$cat = $item->getPrimaryCategory();
								if ($cat and $catimage = $cat->getImage('content.image')) {
									$item->category_image = $catimage['src'];
								}
								
								$object->description = $renderer->render('item.'.$layout, array('view'=>$application, 'item' => $item));
								$object->id = $this->id.$item->id;
								$object->title = $item->name;
								$object->alias = $item->alias;
								$object->type = 'placemark';
								$object->link = $application->app->route->item($item);
								$object->map_id = $map->id;
								$options = array(
									'preset'=>$this->params->get('object_preset', 'islands#greenStretchyIcon'), 
									'iconColor'=>$this->params->get('object_iconColor','green'),
								);
								$icon = $element->get('icon');
								
								if ($icon or $this->params->get('object_iconImageHref') or ($this->params->get('object_use_category_image', 1) && !empty($item->category_image))) {
									if (!$icon) {
										if ($this->params->get('object_use_category_image', 1) and $item->category_image) {
											$icon = $item->category_image;
										}
										if (!$icon) {
											$icon = $this->params->get('object_iconImageHref');
										}
									}
									if ($icon) {
										if (!preg_match('#^http:#', $icon)) {
											$icon = JURI::root().trim(str_replace(JURI::root(), '/', $icon), '/');
										}
										$options+=array(
											'iconLayout'=>$this->params->get('object_show_title_with_image', 0) ? 'default#imageWithContent' : 'default#image',
											'iconImageHref'=>$icon,
											'iconImageSize'=>array_map('intval', explode(',', $this->params->get('object_iconImageSize', '37,42'))),
											'iconImageOffset'=>array_map('intval', explode(',', $this->params->get('object_iconImageOffset', '-19,-21'))),
										);
										$options['preset'] = 'islands#greenStretchyIcon';
									}
								}
								$options['visible'] = $this->params->get('object_visible', 1) ? true : false;
								$object->options = json_encode((object)$options);
								$object->properties = json_encode((object)array('metaType'=>'Point', 'iconContent'=>$item->name));
								$object->lat = $address->lat;
								$object->lan = $address->lan;
								$object->zoom = (isset($address->zoom) and (int)$address->zoom) ? (int)$address->zoom : 10;
								$object->coordinates = json_encode(array($object->lat, $object->lan));
								
								if (!$this->params->get('use_content_categories', 1) or !$cat) {
									$category = $map->categories[0];
									if ($category) {
										$object->category_id = $category->id;
										$object->category_slug = $category->slug;
										$object->category_title = $category->title;
									}
								} else {
									$object->category_id = $this->id.$cat->id;
									$object->category_slug = $cat->alias;
									$object->category_title = $cat->name;
									$object->category_link = $application->app->route->category($cat);
								}
		
								$object->type = 'placemark';

								$objects[] = $object;								
							}
							break;
						};
					}
				}
			}
			return $objects;
		}
	}
}