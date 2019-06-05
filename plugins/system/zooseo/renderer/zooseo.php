<?php
/**
* @package		ZOOseo
* @author    	JOOlanders, SL http://www.zoolanders.com
* @copyright 	Copyright (C) JOOlanders, SL
* @license   	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// register ItemRenderer class
App::getInstance('zoo')->loader->register('ItemRenderer', 'classes:renderer/item.php');

/*
	Class: ZooseoRenderer
		The class for fetching positions give us back an array with all meta tags
*/
class ZooseoRenderer extends ItemRenderer {

	public function setLayout($layout)
	{
		$this->_getLayoutPath($layout);
	}

	/**
	 * Render the output of the position
	 *
	 * @param string $position The name of the position to render
	 * @param array $args The list of arguments to pass on to the layout
	 *
	 * @return string The html code generated
	 */
	public function renderPosition($position, $args = array()) {

		// init vars
		$elements = array();
		$output   = array();

		// get style
		$style = isset($args['style']) ? $args['style'] : 'default';

		// set item, important
		$this->_item = isset($args['item']) ? $args['item'] : null;

		// store layout
		$layout = $this->_layout;

		// render elements
		foreach ($this->_getConfigPosition($position) as $index => $data) {
			if ($element = $this->_item->getElement($data['element'])) {

				if (!$element->canAccess()) {
					continue;
				}

				$data['_layout'] = $this->_layout;
				$data['_position'] = $position;
				$data['_index'] = $index;

				// set params
				$params = array_merge($data, $args);

				// check value
				if ($element->hasValue($this->app->data->create($params))) {

					// trigger elements beforedisplay event
					$render = true;
					$this->app->event->dispatcher->notify($this->app->event->create($this->_item, 'element:beforedisplay', array('render' => &$render, 'element' => $element, 'params' => $params)));

					if ($render) {
						$elements[] = compact('element', 'params');
					}
				}
			}
		}

		foreach ($elements as $i => $data) {
			$params  = array_merge(array('first' => ($i == 0), 'last' => ($i == count($elements)-1)), $data['params']);
			$el_type = $data['element']->getElementType();

			// Fix for categories element as zoolingual works only on frontend
			if ($el_type == 'itemcategory') {
				$output[$i] = $this->renderCategories($data['element'], $params);

			// if image get cached value
			} else if ($el_type == 'image' || $el_type == 'imagepro') {

				// if imagepro, rewind to get the first value
				if ($el_type == 'imagepro') $data['element']->rewind();

				$el_params = $this->app->data->create($params);

				//get image path
				$width = $el_params->find('specific._width', $el_params->get('width', 0));
				$height = $el_params->find('specific._height', $el_params->get('height', 0));

				$element_data = $data['element']->get('file');

				if ($el_type == 'imagepro' && !$element_data) {
					$default_resource = $data['element']->getValidResources();
					$element_data = $default_resource[0];
				}

				if ($width || $height) {
					$file = $this->app->zoo->resizeImage(JPATH_ROOT.'/'.$element_data, $width, $height);
				} else {
					$file = JPATH_ROOT.'/'.$element_data;
				}

				$output[$i] = JURI::root() . $this->app->path->relative($file);

			} elseif ($el_type == 'itemlink') {
				$output[$i] = JRoute::_($this->app->route->item($this->_item, false), true, -1);
			} else {
				$output[$i] = parent::render("element.$style", array('element' => $data['element'], 'params' => $params));
			}

			// trigger elements afterdisplay event
			$this->app->event->dispatcher->notify($this->app->event->create($this->_item, 'element:afterdisplay', array('html' => &$output[$i], 'element' => $data['element'], 'params' => $params)));
		}

		// restore layout
		$this->_layout = $layout;

		return $output;
	}
	
	/**
	 * Fix for categories element as zoolingual works only on frontend
	 */
	protected function renderCategories($element, $params) {

		$params = $this->app->data->create($params);
		$values = array();

		$code = JFactory::getLanguage()->getTag();

		foreach ($element->getItem()->getRelatedCategories(true) as $category) {
			// Name Translation
			$name_translations = $category->getParams()->get('content.name_translation', array());
			if( count( $name_translations )) {
				if( array_key_exists($code, $name_translations)) {
					if( strlen($name_translations[$code]) )	{
						$category->name = $name_translations[$code];
					}
				}
			}
			$values[] = $params->get('linked') ? '<a href="'.$this->app->route->category($category).'">'.$category->name.'</a>' : $category->name;
		}

		return $this->app->element->applySeparators($params->get('separated_by'), $values);
	}

	/*
		Function: setItem
	*/
	public function setItem($item){
		$this->_item = $item;
	}
}