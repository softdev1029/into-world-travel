<?php
/**
 * @copyright	Copyright (c) 2015 content. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');
if (is_dir(JPATH_SITE . '/components/com_k2/')) {
	require_once JPATH_SITE . '/components/com_k2/helpers/utilities.php';
	require_once JPATH_SITE . '/components/com_k2/helpers/route.php';
	JHtml::addIncludePath(JPATH_ROOT.'/components/com_yandex_maps/helpers');
	class plgYandexMapsSourceK2 extends JPlugin {
		public $id = 'kdva'; // идентификатор источника
		public $params2;
		public $fields_id;
		public $k2params;
		function __construct(&$subject, $config = array()) {
			$this->params2 = new JRegistry();
			$plugin = JPluginHelper::getPlugin('system','k2_extra_address');
			if ($plugin && isset($plugin->params)) {
				$this->params2->loadString($plugin->params);
			}
			$this->fields_id = JFactory::getDBO()->setQuery('select id from #__k2_extra_fields where name='.JFactory::getDBO()->quote($this->params2->get('fieldname','address')))->loadColumn();
			
			$this->k2params = K2HelperUtilities::getParams('com_k2');

			parent::__construct($subject, $config);
		}
		public function onGetName(&$names) {
			if (is_dir(JPATH_ROOT.'/components/com_k2')) {
				$names[$this->id] = 'K2 материалы';
			}
		}
		public function onGetCategories($map) {
			$categories = array();
			if (!$map or $map->settings->get('source')!=$this->id or !$this->params->get('use_content_categories', 1)) {
				return $categories;
			}
			$db = JFactory::getDBO();
			
			$filter = array('1');
			if ($this->params->get('exlude_these_categories') and count($this->params->get('exlude_these_categories'))) {
				$filter[] = '(a.id not in ('.implode(',', $this->params->get('exlude_these_categories')).'))';
			}
			if ($this->params->get('include_only_these_categories') and count($this->params->get('include_only_these_categories'))) {
				$filter[] = '(a.id in ('.implode(',', $this->params->get('include_only_these_categories')).'))';
			}

			$db->setQuery($q = 
				'select 
					a.id,
					a.name,
					a.alias,
					a.description,
					a.image,
					a.params
				from 
					#__k2_categories  as a
				where 
					a.published = 1 and trash=0 and ('.implode(' and ', $filter).')'
			);

			$data = $db->loadObjectList();
			foreach ($data as $category) {
				$_params = new JRegistry();
				$_params->loadString($category->params);// настройки категории
				$category->params = clone($this->k2params); // настройки компонента
				$category->params->merge($_params); // мержим сперва категорию
                
				$category->title = $category->name;
				$category->lat = $map->lat;
				$category->lan = $map->lan;
				$category->zoom = $map->zoom;
				$category->link = JRoute::_(K2HelperRoute::getCategoryRoute($category->id.':'.urlencode($category->alias)));
				$category->image = K2HelperUtilities::getCategoryImage($category->image, $category->params);
				$category->id = $this->id.$category->id;

                unset ($category->params); // пока сделаем так, посмотрим что будет
                unset ($category->description); // пока сделаем так, посмотрим что будет

				$categories[] = $category;
			}
			return $categories;
		}
		public function onThisPageIsMine($map) {
			if (!$map or $map->settings->get('source') != $this->id) {
				return false;
			}
			$app = JFactory::getApplication();
			$option = $app->input->get('option');
			$view = $app->input->get('view');
			if($option!='com_k2' or $view!='item' or $app->isAdmin()) return false;
			if ($app->input->get('id')) {
				return $this->id.(int)$app->input->get('id');
			}
		}
		private function getQueryObjects($search = '', $count = false) {
            $db = JFactory::getDBO();
            $nullDate	= $db->quote($db->getNullDate());
			$nowDate	= $db->quote(JFactory::getDate()->toSql());
            $filter = array('1');
			if ($search) {
				$filter[]='(
					a.title like "%'.$db->escape( $search, true ).'%" or
					c.name like "%'.$db->escape( $search, true ).'%" 
				)';
			}
			$filter[]=' ((a.publish_up = '.$nullDate.' OR a.publish_up <= '.$nowDate.') and (a.publish_down = '.$nullDate.' OR a.publish_down >= '.$nowDate.'))';
			
			if ($this->params->get('exlude_these_categories') and count($this->params->get('exlude_these_categories'))) {
				$filter[] = '(c.id not in ('.implode(',', $this->params->get('exlude_these_categories')).'))';
			}
			if ($this->params->get('include_only_these_categories') and count($this->params->get('include_only_these_categories'))) {
				$filter[] = '(c.id in ('.implode(',', $this->params->get('include_only_these_categories')).'))';
			}

			$db->setQuery(
				'select '.(!$count ? 'a.*, c.params as category_params,
					CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,
					CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as category_slug,
					c.name as category_title,
					c.image as category_image': 'count(a.id) as cnt').'
					from 
						#__k2_items  as a
					left join
						#__k2_categories  as c on a.catid=c.id
					where 
						a.published in (1) and ('.implode(' and ', $filter).')'
			);
            return $db;
        }
		public function getObjectsCount($map, $filter, $bound = array(), $exclude = array(), $search = false, $forse_id = 0) {
            $db = $this->getQueryObjects($search, true);
            return $db->loadResult();
        }
		public function onGetObjectsByBound($map, $bound = array(), $offset = 0, $limit = 500, $exclude = array(), $search = false, $forse_id = 0) {
			if (!$this->fields_id or !count($this->fields_id) or !$map or $map->settings->get('source')!=$this->id or (!count($map->categories) and !$this->params->get('use_content_categories'))) {
				return array();
			}

			$db = $this->getQueryObjects($search);

			$data = $db->loadObjectList();

			$objects = array();
			
			foreach($data as $item) {
				$metadata = json_decode($item->extra_fields);
				if (empty($metadata) or !is_array($metadata) or !count($metadata)) {
					continue;
				}
				$address = null;
				foreach ($metadata as $field) {
					if (in_array($field->id, $this->fields_id)) {
						$address = json_decode($field->value);
						break;
					}
				}

				if (!$address or !isset($address->lat) or !$address->lat) {
					continue;
				}
				

				$_params = new JRegistry();
				$_params->loadString($item->category_params);// настройки категории
				$_params2 = new JRegistry();
				$_params2->loadString($item->params);// настройки элемента

				$item->params = clone($this->k2params); // настройки компонента
				$item->params->merge($_params); // мержим сперва категорию
				$item->params->merge($_params2);// мержим настройки элемента
				
				//Image
				$item->imageXSmall = '';
				$item->imageSmall = '';
				$item->imageMedium = '';
				$item->imageLarge = '';
				$item->imageXLarge = '';

				if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_XS.jpg'))
					$item->imageXSmall = JURI::root(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_XS.jpg';

				if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_S.jpg'))
					$item->imageSmall = JURI::root(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_S.jpg';

				if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_M.jpg'))
					$item->imageMedium = JURI::root(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_M.jpg';

				if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_L.jpg'))
					$item->imageLarge = JURI::root(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_L.jpg';

				if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_XL.jpg'))
					$item->imageXLarge = JURI::root(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_XL.jpg';

				if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_Generic.jpg'))
					$item->imageGeneric = JURI::root(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_Generic.jpg';
				
				
				$object = new stdClass();
				$object->id = $this->id.$item->id;
				$object->type = 'placemark';
				$object->link = $item->link = JRoute::_(K2HelperRoute::getItemRoute($item->slug, $item->catid));
				$object->target = $this->params->get('how_open_link','_self');
				$object->title = $item->title;
				$object->alias = $item->alias;

                if ($this->params->get('point_layout')) {
                    $object->layout = $this->params->get('point_layout');
                }

				K2HelperUtilities::setDefaultImage($item, 'item', $item->params);

                $object->map_id = $map->id;
				
                $object->description = JHtml::_('xdwork.tpl', array('object'=> $object, 'item'=>$item, 'params'=>$this->params), 'plugins/yandexmapssource/k2/tmpl/item.php');
                
				$options = array(
					'preset'    =>  $this->params->get('object_preset', 'islands#greenStretchyIcon'), 
					'iconColor' =>  $this->params->get('object_iconColor','green'),
				);
				if ($this->params->get('object_iconImageHref') or ((int)$this->params->get('object_use_category_image', 1) === 1 && $item->category_image) or (int)$this->params->get('object_use_category_image', 1) === 2) {
					$icon = '';
                    // если установлена нужная опция и есть изображение у метки
                    if ((int)$this->params->get('object_use_category_image', 1) === 2 and $item->image) {
                        $icon = $item->image;
                    }

                    if (!$icon) {
                        // если установлена нужная опция и есть изображение у категории
                        $icon = !$this->params->get('object_use_category_image', 1) ? '' :  K2HelperUtilities::getCategoryImage($item->category_image, $_params); // настройки берем из категории
                        if (!$icon) {
                            $icon = $this->params->get('object_iconImageHref');
                        }
					}

					if ($icon) {
						if (!preg_match('#^http:#', $icon)) {
							$icon = JURI::root().trim(str_replace(JURI::root(true), '', $icon), '/');
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
				$object->properties = json_encode((object)array('metaType'=>'Point', 'iconContent'=>$item->title));
				$object->lat = $address->lat;
				$object->lan = $address->lan;
				$object->zoom = (isset($address->zoom) and (int)$address->zoom) ? (int)$address->zoom : 10;
				$object->coordinates = json_encode(array($object->lat, $object->lan));
				if (!$this->params->get('use_content_categories', 1)) {
					$category = $map->categories[0];
					$object->category_id = $category->id;
					$object->category_slug = $category->slug;
					$object->category_title = $category->title;
				} else {
					$object->category_id = $this->id.$item->catid;
					$object->category_slug = $item->category_slug;
					$object->category_title = $item->category_title;
					$object->category_link = JRoute::_(K2HelperRoute::getCategoryRoute($item->category_slug));
				}
				$object->type = 'placemark';
				$objects[] = $object;
			}
			
			return $objects;
		}
	}
}