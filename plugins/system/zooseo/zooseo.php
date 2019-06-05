<?php
/**
* @package		ZOOseo
* @author    	ZOOlanders http://www.zoolanders.com
* @copyright 	Copyright (C) JOOlanders SL
* @license   	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class plgSystemZooSeo extends JPlugin {

	public $joomla;
	public $app;

	/**
	 * onAfterInitialise handler
	 *
	 * Adds ZOO event listeners
	 *
	 * @access	public
	 * @return null
	 */
	public function onAfterInitialise()
	{
		// Get Joomla instances
		$this->joomla = JFactory::getApplication();
		$jlang = JFactory::getLanguage();
		
		// load default and current language
		$jlang->load('plg_system_zooseo', JPATH_ADMINISTRATOR, 'en-GB', true);
		$jlang->load('plg_system_zooseo', JPATH_ADMINISTRATOR, null, true);

		// check dependences
		if (!defined('ZLFW_DEPENDENCIES_CHECK_OK')){
			$this->checkDependencies();
			return; // abort
		}

		// Get the ZOO App instance
		$this->app = App::getInstance('zoo');

		// register plugin path
		if ( $path = $this->app->path->path( 'root:plugins/system/zooseo' )) {
			$this->app->path->register($path, 'zooseo');
		}

		$event = $this->params->get('event', 'saved');
		
		if ($event !== 'none') {
			// if onLoad and site
			if ($event == 'init' && $this->joomla->isSite()) {
				$this->app->event->dispatcher->connect('item:init', array($this, 'initItemMetadata'));
			} else {
				$this->app->event->dispatcher->connect('item:saved', array($this, 'saveItemMetadata'));
			}
		}

		$event = $this->params->get('category_event', 'saved');
		
		if ($event !== 'none') {
			if ($event == 'init') {
				$this->app->event->dispatcher->connect('category:init', array($this, 'setCategoryMetadata'));
			} else {
				$this->app->event->dispatcher->connect('category:saved', array($this, 'setCategoryMetadata'));
			}
		}

		// on site only
		if ($this->joomla->isSite()) {
			if ($this->params->get('use_category_path', false) || $this->params->get('remove_item', false) || $this->params->get('remove_category', false)) {
				$this->app->event->dispatcher->connect('application:sefbuildroute', array($this, 'sefBuildRoute')); 
				$this->app->event->dispatcher->connect('application:sefparseroute', array($this, 'sefParseRoute')); 
			}
		} else {
			if ($this->params->get('remove_item', false) && $this->params->get('remove_category', false)) {
				$this->app->event->dispatcher->connect('application:addmenuitems', array($this, 'checkAliases')); 
			}
		}

		$this->app->event->dispatcher->connect('layout:init', array($this, 'initTypeLayouts')); 
	}

	/**
	 * onAfterRoute handler
	 *
	 * @access public
	 * @return null
	 */
	public function onAfterRoute()
	{
		// check dependences
		if (!defined('ZLFW_DEPENDENCIES_CHECK_OK')){
			$this->checkDependencies();
			return; // abort
		}
		
		// init Open Graph
		$this->addOpenGraphTags();
	}

	/**
	 * Detect alias duplication across all apps, items and categories
	 */
	public function checkAliases($event) {
		$app_id = $event->getSubject()->id;

		if ($this->app->zoo->getApplication()->id == $app_id) {
			$query = 	"SELECT * FROM
							((SELECT i.alias, application_id FROM " . ZOO_TABLE_ITEM . " AS i)
							UNION ALL
							(SELECT c.alias, application_id FROM " . ZOO_TABLE_CATEGORY . " AS c)
							) as u 
						GROUP BY alias
						HAVING COUNT(*) > 1";
			$db = $this->app->database;
			$db->setQuery($query);
			$duplicates = $db->loadObjectList();
			
			// Print out links to duplicates
			if (count($duplicates) > 0) {				
				$html = '<ul>';
				$links = array();
				foreach ($duplicates as $duplicate) {
					$app_id = $duplicate->application_id;
					$duplicate = $duplicate->alias;
					$links[] = '<li>' . 
								$duplicate . 
								' (<a href="index.php?option=com_zoo&controller=category&task=edit&cid[]='.$this->app->alias->category->translateAliasToID($duplicate).'&changeapp='.$app_id.'" target="_blank">' . 
										JText::_('PLG_ZOOSEO_CATEGORY') . 
								'</a> / 
								<a href="index.php?option=com_zoo&controller=item&task=edit&cid[]='.$this->app->alias->item->translateAliasToID($duplicate).'&changeapp='.$app_id.'" target="_blank">' . 
									JText::_('PLG_ZOOSEO_ITEM') . 
								'</a>) ' .
								'</li>';
				}
				$html .= implode("\n", $links);
				$html .= '</ul>';

				$msg = JText::sprintf('PLG_ZOOSEO_ALIAS_DUPLICATES', $html);
				$this->joomla->enqueueMessage($msg, 'notice');
			}
		}
	}

	/**
	 * Add SEF url build rules
	 */
	public function sefBuildRoute($event) {
		$segments = $event['segments'];
		$query = $event['query'];

		// Category based mode (reccomanded)
		if ($this->params->get('use_category_path', false)) {
			// Build the route for an item
			if (in_array('item', $segments)) {
				$key = array_search('item', $segments);
				if ($key === 0) {
					// Remove /item
					unset($segments[$key]);
					// Build the route based on the categories
					$segments = array_merge($this->buildItemPath($segments[1], $query), $segments);
				}
			}

			// Build the route for a category
			if (in_array('category', $segments)) {
				$key = array_search('category', $segments);
				if ($key === 0) {
					// remove the /category
					unset($segments[$key]);
					// Build the route based on the parent categories
					$segments = array_merge($this->buildCategoryPath($segments[1], $query), $segments);
				}
			}
		}
		// OLD MODE
		else {

			// Remove category query from url for item
			if (isset($query['Itemid'])) {
				$menu_params = $this->joomla->getMenu()->getParams($query['Itemid']);
				if ($menu_params->get('category') && $menu_params->get('application') && in_array('item', $segments)) {
					unset($query['category_id']);
				}
			}

			// Remove the /item
			if ($this->params->get('remove_item', false)) {
				if (in_array('item', $segments)) {
					$key = array_search('item', $segments);
					if ($key === 0) {
						unset($segments[$key]);
					}
				}
			}

			// Remove the /category
			if ($this->params->get('remove_category', false)) {
				if (in_array('category', $segments)) {
					$key = array_search('category', $segments);
					if ($key === 0) {
						unset($segments[$key]);
					}
				}
			}
		}

		// Pass them back to zoo
		$event['segments'] = array_values($segments);
		$event['query'] = $query;
	}

	/**
	 * Add SEF url parse rules
	 */
	public function sefParseRoute($event) {
		$segments = $event['segments'];
		$vars = $event['vars'];
		$count = count($segments);

		// Category Based mode enabled
		if ($this->params->get('use_category_path', false) && $count) {
			$id = null;
			$task = null;
			$page = null;

			// Paginated category faster case (if the last part is a number, it's pagination on category)
			// Therefore, skip right to the category case without checking if it's an item
			if ($count > 1) {
				// Last segment is a number?
				$last_segment = $segments[$count-1];

				// Can be page id or category alias
				if (is_numeric($last_segment)) {

					// The last one is a category alias?
					$category_id = (int) $this->app->alias->category->translateAliasToID($last_segment);
					$item_id = (int) $this->app->alias->item->translateAliasToID($last_segment);

					if ($item_id && $category_id){
						// Conflict? let's chose by priority settings:
						$priority = $this->params->get('alias_priority', 'item');
						if('item' == $priority){
							$id = $category_id;
							$task = 'category';
						}else{
							$id = $item_id;
							$task = 'item';
						}
					}elseif($item_id){
						$id = $item_id;
						$task = 'item';
					}elseif($category_id){
						$id = $category_id;
						$task = 'category';
					}else{
						// The one before the number is a category alias?
						$category_id = (int) $this->app->alias->category->translateAliasToID($segments[$count - 2]);

						// We're lucky! skip to the end
						if ($category_id) {
							$id = $category_id;
							$task = 'category';
							$page = $last_segment;
						}
					}
				}
			}

			// General case
			if (!$id) {
				// Get item and category alias
				$item_id = (int) $this->app->alias->item->translateAliasToID($segments[$count - 1]);
				$category_id = (int) $this->app->alias->category->translateAliasToID($segments[$count - 1]);

				// Conflict?
				if ($item_id && $category_id) {

					// Let's try guessing between a category and an item based on the parents
					$item_path = $this->getItemPath($item_id, $segments, $vars);
					$category_path = $this->getCategoryPath($category_id, $segments, $vars);

					$url_path = $segments;

					// Remove the last part (already taken care of)
					array_pop($url_path);

					// Go through
					$found = false;
					while (!$found && count ($item_cat) && count($cat_cat) && count($current_path)) {
						$item_cat = array_pop($item_path);
						$cat_cat = array_pop($category_path);
						$current_path = array_pop($url_path);

						$is_item = $item_cat->alias == $current_path;
						$is_cat = $cat_cat->alias == $current_path; 
						
						// Are we done?
						if ($is_item && !$is_cat) {
							$id = $item_id;
							$task = 'item';
							$found = true;
						} else {
							if (!$is_item && $is_cat) {
								$id = $category_id;
								$task = 'category';
								$found = true;
							} else {
								// Still conflict
							}
						}
					}

					// We've still conflict: choosen one or the other
					if (!$found) {
						$priority = $this->params->get('alias_priority', 'item');

						if ($priority == 'item') {
							$id = $item_id;
							$task = 'item';
						} else {
							$id = $category_id;
							$task = 'category';
						}
					}
				} 
				// No conflict: choose the found one
				else {
					
					if ($item_id) {
						$id = $item_id;
						$task = 'item';
						if(($count>=2) && !empty($segments[$count - 2]))
						{
							$cat_id = (int) $this->app->alias->category->translateAliasToID($segments[$count - 2]);
						}
					}

					if ($category_id) {
						$id = $category_id;
						$task = 'category';	
					}
				}
			}

			// Do we have a valid alias?
			if ($id && $task) {
				// Check if the pathway is correct
				if ($object = $this->app->table->$task->get($id)) {
					// Load the category tree to populate the parents
					$categories = $this->app->table->application->get($object->application_id)->getCategoryTree(true, $this->app->user->get(), true);
					$category_id = null;

					if ($task == 'item') {
						$path = $this->getItemPath($id, $segments, $vars);
					} else {
						$path = $this->getCategoryPath($id, $segments, $vars);
					}

					$url_path = $segments;

					// Remove the last part (already taken care of)
					array_pop($url_path);

					// If there was page, then remove also the previous one
					if ($page) {
						array_pop($url_path);						
					}

					// Go through the url to find the right category and item
					$found = true;
					foreach ($url_path as $part) {
						$parent = array_pop($path);

						if ($parent) {
							if ($parent->alias == $part){
								$found = true;
							} else {
								$found = false;
							}
						} else {
							$found = false;
						}
					}

					if ($found) {
						$vars['task']    = $task;
						$vars[$task . '_id'] = $id;

						if($category_id){
							$vars['category_id'] = $category_id;
						}

						if($task=='item' && $cat_id){
							$vars['category_id'] = $cat_id;
						}
					}
				}
			}
			if($page)
			{
				$vars['page'] = $page;
			}
		} 
		// OLD MODE
		else {
			// Parse the alias
			if (count($segments) == 1 || count($segments) == 2){
				
				$id = null;
				$task = null;

				// Get item and category alias
				$item_id = (int) $this->app->alias->item->translateAliasToID($segments[0]);
				$category_id = (int) $this->app->alias->category->translateAliasToID($segments[0]);
				
				// Conflict?
				if ($item_id && $category_id) {
					$priority = $this->params->get('alias_priority', 'item');

					if ($priority == 'item') {
						$id = $item_id;
						$task = 'item';
					} else {
						$id = $category_id;
						$task = 'category';
					}
				} else {
					
					if ($item_id) {
						$id = $item_id;
						$task = 'item';
					}

					if ($category_id) {
						$id = $category_id;
						$task = 'category';	
					}
				}

				if ($id && $task) {
					$vars['task']    = $task;
					$vars[$task . '_id'] = $id;

					// Add page?
					if ($task == 'category' && count($segments) == 2) {
						$vars['page'] = $segments[1];
					}
				}
			}
		}

		// Redirect old tasks (original zoo ones)
		if ($this->params->get('redirect_old_urls', true)) {

			if ($this->params->get('use_category_path', false) || $this->params->get('remove_item', false)) {
				// item
				$task = 'item';

				if (count($segments) == 2 && $segments[0] == $task) {
					$item = $this->app->table->item->get((int) $this->app->alias->item->translateAliasToID($segments[1]));
					$this->joomla->redirect($this->app->route->item($item));
				}
			}

			if ($this->params->get('use_category_path', false) || $this->params->get('remove_category', false)) {
				// category (with optional pagination)
				$task = 'category';

				if (count($segments) == 2 && $segments[0] == $task) {
					$category = $this->app->table->category->get((int) $this->app->alias->category->translateAliasToID($segments[1]));
					$this->joomla->redirect($this->app->route->category($category));
				}

				if (count($segments) == 3 && $segments[0] == $task) {
					$category = $this->app->table->category->get((int) $this->app->alias->category->translateAliasToID($segments[1]));
					$this->joomla->redirect($this->app->route->category($category) . '/' . (int) $segments[2]);
				}
			}

		}

		$event['vars'] = $vars;
		$event['segments'] = $segments;
	}

	/*
		Function: initTypeLayouts
			Callback function for the zoo layouts

		Returns:
			void
	*/
	public function initTypeLayouts($event)
	{
		$extensions = (array) $event->getReturnValue();
		
		// clean all ZOOseo layout references
		$newextensions = array();
		foreach ($extensions as $ext) {
			if (stripos($ext['name'],'zooseo') === false) {
				$newextensions[] = $ext;
			}
		}
		
		// add new ones
		$newextensions[] = array('name' => 'ZOOseo', 'path' => $this->app->path->path('zooseo:'), 'type' => 'plugin');
		
		$event->setReturnValue($newextensions);
	}

	/**
	 * Add the Open Graph Tags if requested
	 */
	public function addOpenGraphTags()
	{
		// init vars
		$document = JFactory::getDocument();

		// Only if item full view and document is HTML
		if ($this->app->zlfw->enviroment->is('site.com_zoo.item') && $document->getType() == 'html') {

			// Avoid related items
			if ($item = $this->app->table->item->get($this->app->zlfw->enviroment->params->get('item_id'))) {

				// Set custom renderer path
				$this->app->path->register($this->app->path->path('zooseo:renderer'), 'renderer'); 
				$renderer = $this->app->renderer->create('zooseo');
				$renderer->addPath(array($this->app->path->path('component.site:'), $this->app->path->path('zooseo:')));
				$renderer->setLayout('item.itemmetadata');

				$renderer->setItem($item);

				// get the positions
				$positions = $renderer->getPositions('item.itemmetadata');
				if (is_array($positions) && isset($positions['positions'])) {
					$positions = array_keys($positions['positions']);
				} else {
					$positions = array();
				}

				// Filter out the OG ones
				$tmp = $positions;
				$positions = array();
				foreach ($tmp as $position) {
					if (stripos($position, "og-") === 0) {
						$positions[] = $position;
					}
				}

				// remove the custom position
				array_pop($positions);

				// get separator
				$separator = $this->params->get('separator', '');

				// render the positions
				foreach ($positions as $position) {
					$content = $renderer->renderPosition($position, array('item' => $item));
					$content = htmlspecialchars(strip_tags(trim(implode($separator, (array)$content))));
					
					$property = str_replace("og-", "og:", $position);

					// Set Current URL if not provided
					if ($property == 'og:url' && empty($content))
						$content = JURI::current();
					
					if (!empty($content)) {
						$tag = '<meta property="' . $property . '" content="' . $content . '" />';
						$document->addCustomTag($tag);
					}
				}

				// render the custom position
				$contents = $renderer->renderPosition('og-custom', array('item' => $item));
				$path = $item->getApplication()->getGroup().'.'.$item->getType()->id.'.itemmetadata';
				foreach ($contents as $i => $content) {
					$content = htmlspecialchars(strip_tags(trim($content)));

					if (!empty($content)) {

						// use as property value the alternative label param
						$property = $renderer->getConfig('item')->find("$path>og-custom>$i>altlabel", array(), '>');

						// set tag
						$tag = '<meta property="' . $property . '" content="' . $content . '" />';
						$document->addCustomTag($tag);
					}
				}

			}
		}
	}

	/**
	 * Load the item metadata on item init
	 */
	public function initItemMetaData($event)
	{
		// get item
		$item = $event->getSubject();

		// abort if not current item, avoiding related ones
		if ($item->id != $this->app->zlfw->enviroment->params->get('item_id')) return;

		// if all ok, set meta data
		$this->setItemMetadata($item);
	}

	/**
	 * Set metadata when item saved
	 */
	public function saveItemMetaData($event)
	{
		// get item
		$item = $event->getSubject();

		// if all ok, set meta data
		$this->setItemMetadata($item);
	}

	/**
	 * Set the item metadata (either on save or on init)
	 */
	public function setItemMetaData($item)
	{
		// init vars
		$params		= clone $item->getParams();
		$temp_item	= clone $item;
		$override	= $this->params->get('override_item_metadata', false);

		// Set custom renderer path
		$this->app->path->register($this->app->path->path('zooseo:renderer'), 'renderer'); 
		$renderer = $this->app->renderer->create('zooseo');
		$renderer->addPath(array($this->app->path->path('component.site:'), $this->app->path->path('zooseo:')));
		$renderer->setLayout('item.itemmetadata');

		$renderer->setItem($item);

		// get separator
		$separator = $this->params->get('separator', '');

		// get languages, the ones with language content set
		$languages = JLanguageHelper::getLanguages();

		// get site default language
		$default_language = JComponentHelper::getParams('com_languages')->get('site');

		// get active language
		$active_language = JFactory::getLanguage();

		// prepare language simple tag array
		foreach($languages as &$language) $language = $language->lang_code;

		// the default language must be present (it could not be if it's language content was omited)
		$languages[] = $default_language;

		// remove duplicates
		$languages = array_unique($languages);


		// deal with multilanguage
		foreach($languages as $lang) {

			// Change the language forcefully (needed for the active language detected by Zoolingual)
			JFactory::$language = JLanguage::getInstance($lang);

			// It's a translated metadata?
			$translation = $default_language == $lang ? false : true;


			// META TITLE
			$key = $translation ? 'content.metatitle_translation>'.$lang : 'metadata.title';

			// Title and alias are special, as zoolingual works only on frontend

			// Name Translation
			$name_translations = $params->get('content.name_translation', array());
			if( count( $name_translations )) {
				if( array_key_exists($lang, $name_translations)) {
					if( strlen($name_translations[$lang]) )	{
						$item->name = $name_translations[$lang];
					}
				}
			}

			// Alias
			$alias_translations = $params->get('content.alias_translation', array());
			if( count( $alias_translations ) ) {
				if( array_key_exists($lang, $alias_translations)) {
					if( strlen($alias_translations[$lang]) )	{
						$item->alias = $alias_translations[$lang];
					}
				}
			}

			// Render title elements
			$content = $renderer->renderPosition('title', array('item' => $item));
			$content = strip_tags(trim(implode($separator, (array)$content)));

			// go on only if data set and override is enabled or param empty
			if ($content && ($override || $this->_isMetaDataEmpty($params, $key))) {
				$this->_setItemMetaData($params, $key, $content, $lang);
			}


			// META DESCRIPTION
			$key = $translation ? 'content.metadesc_translation>'.$lang : 'metadata.description';

			// Render description elements
			$content = $renderer->renderPosition('description', array('item' => $item));
			$content = strip_tags(trim(implode($separator, (array)$content)));

			// go on only if data set and override is enabled or param empty
			if ($content && ($override || $this->_isMetaDataEmpty($params, $key))) {
				$this->_setItemMetaData($params, $key, $content, $lang);
			}


			// META KEYWORDS
			$key = $translation ? 'content.metakeywords_translation>'.$lang : 'metadata.keywords';
			
			// Render keywords elements
			$content = $renderer->renderPosition('keywords', array('item' => $item));
			$content = strip_tags(trim(implode(',', (array)$content)));

			// go on only if data set and override is enabled or param empty
			if ($content && ($override || $this->_isMetaDataEmpty($params, $key))) {
				$this->_setItemMetaData($params, $key, $content, $lang);
			}

			// META AUTHOR
			if($global_show_author = $this->joomla->getCfg('MetaAuthor', 0)) {

				$key = 'metadata.author';
				$content = $renderer->renderPosition( 'author', array( 'item' => $item ) );
				$content = strip_tags( trim( implode( $separator, (array) $content ) ) );

				// go on only if data set and override is enabled or param empty
				if ( $content && ( $override || $this->_isMetaDataEmpty( $params, $key ) ) ) {
					$params->remove( $key );
					$params->set( $key, $content );
				}
			}
		}

		// Set back the real active language
		JFactory::$language = $active_language;

		// Save only if different, otherwise infinite loop
		if ($params->serialize() != $item->getParams()->serialize()) {
			$item = $temp_item;
			$item->params = $params;
			$this->app->table->item->save($item);
		}
	}

	/**
	 * Set the metadata in the param
	 */
	protected function _setItemMetaData(&$params, $key, $content, $lang)
	{
		// if translation
		if (strpos($key, ">$lang") !== false) {
			$key = str_replace(">$lang", '', $key);
			$translations = $params->get($key, array());
			$translations[$lang] = $content;
			$params->set($key, $translations);
		} else {
			$params->set($key, $content); 
		}
	}

	/**
	 * Checks if a metadata param is empty
	 */
	protected function _isMetaDataEmpty($params, $key)
	{
		return ! (bool) strlen(trim( $params->find($key, null, '>') ));
	}

	/**
	 * Set the category metadata, either on save or on init
	 */
	public function setCategoryMetaData($event) {

		// Plugin params
		$category 		 = $event->getSubject();
		$params 		 = clone $category->getParams();
		$temp_cat		 = clone $category;
		$override 		 = $this->params->get('override_category_metadata', false);


		// META TITLE
		$key = 'metadata.title';

		// Render content
		$field = $this->params->get('category_metatitle', false); 
		$content = strip_tags(trim($this->getCategoryField($category, $field)));

		// go on only if data set and override is enabled or param empty
		if ($content && ($override || $this->_isMetaDataEmpty($params, $key))) {
			$params->remove($key);
			$params->set($key, $content); 
		}


		// META DESCRIPTION
		$key = 'metadata.description';

		// Render content
		$field = $this->params->get('category_metadescription', false); 
		$content = strip_tags(trim($this->getCategoryField($category, $field)));

		// go on only if data set and override is enabled or param empty
		if ($content && ($override || $this->_isMetaDataEmpty($params, $key))) {
			$params->remove($key);
			$params->set($key, $content); 
		}


		// META KEYWORDS
		$key = 'metadata.keywords';

		// Render content
		$field = $this->params->get('category_keywords', false); 
		$content = strip_tags(trim($this->getCategoryField($category, $field)));

		// go on only if data set and override is enabled or param empty
		if ($content && ($override || $this->_isMetaDataEmpty($params, $key))) {
			$params->remove($key);
			$params->set($key, $content); 
		}

		// META AUTHOR
		if($global_show_author = $this->joomla->getCfg('MetaAuthor', 0)) {

			$key = 'metadata.author';

			// Render content
			$field = $this->params->get('category_author', false);
			$content = strip_tags(trim($this->getCategoryField($category, $field)));

			// go on only if data set and override is enabled or param empty
			if ($content && ($override || $this->_isMetaDataEmpty($params, $key))) {
				$params->remove($key);
				$params->set($key, $content);
			}
		}


		// Save only if different, otherwise infinite loop
		if ($params->serialize() != $category->getParams()->serialize()) {
			$category = $temp_cat;
			$category->params = $params;
			$this->app->table->category->save($category);
		}
	}

	/**
	 * Get the path to an item
	 */
	protected function getItemPath($id, $segments, $vars) {
		$category = null;

		// Get category we're in
		if (isset($vars['category_id']) && $vars['category_id']){
			$category = $this->app->table->category->get($vars['category_id']);
		} else {
			// Try to guess based on the path
			$previous_segments = $segments;
			// Remove current segment (the alias we're checking)
			array_pop($previous_segments);

			// Get the previous alias to get the category
			$category_alias = $previous_segments[count($previous_segments) - 1];
			// This is the category we're in
			$parent_category_id = (int) $this->app->alias->category->translateAliasToID($category_alias);
			
			// Load the category
			if ($parent_category_id) {
				$category = $this->app->table->category->get($parent_category_id);
				$category_id = $parent_category_id;
			}

		}

		// Fallback to primary category
		if (!$category) {
			$category = $this->app->table->item->get($id)->getPrimaryCategory();
		}

		// Path
		$path = array();
		if ($category) {
			$path = $category->getPathway();
			$path[] = $category;
		}

		// reverse it to match the url
		return array_reverse($path);
	}

	/**
	 * Get the path to a category
	 */
	protected function getCategoryPath($id, $segments, $vars) {

		$category = $this->app->table->category->get($id);

		// Load the category tree to populate the parents
		$categories = $this->app->table->application->get($category->application_id)->getCategoryTree(true, $this->app->user->get(), true);

		$object = $categories[$id];
		$path = $object->getPathway();	
		
		// remove the category itself
		array_pop($path);

		// reverse it to match the url
		return array_reverse($path);
	}

	/**
	 * Build the url for an item based on the categories the item is in
	 */
	protected function buildItemPath($alias, &$query) {
		$item = $this->app->table->item->get($this->app->alias->item->translateAliasToID($alias));
		$category = false;
		
		// Load the category tree to populate the parents
		$categories = $this->app->table->application->get($item->application_id)->getCategoryTree(true, $this->app->user->get(), true);

		// Get category we're in
		if(isset($query['category_id']) && $query['category_id']) {
			$category = $categories[$query['category_id']];
			unset($query['category_id']);
		} else  {
			if ($cat = $item->getPrimaryCategory()) {
				$category = $categories[$cat->id];
			}
		}

		$path = array();
		if ($category) $path = $category->getPathway();

		$segments = array();
		foreach ($path as $p) {
			$segments[] = $p->alias;
		}

		return $segments;
	}

	/**
	 * Build the url for a category based on the categories the category is in
	 */
	protected function buildCategoryPath($alias, $query) {
		$category = $this->app->table->category->get($this->app->alias->category->translateAliasToID($alias));
		
		// if we don't have the category, probably it's in the menu item
		if (!$category) {
			$menu_params = $this->joomla->getMenu()->getParams($query['Itemid']);
			if (isset($query['Itemid']) && $menu_params['category']) {
				$category = $this->app->table->category->get((int)$menu_params['category']);
			}
		}
		
		$path = array();
		if ($category) {
			$path = $category->getPathway();
		}

		$segments = array();
		foreach ($path as $p) {
			$segments[] = $p->alias;
		}

		// Remove last one: is the current category
		array_pop($segments);

		return $segments;
	}


	/**
	 * Utility method to get the description field based on config
	 */
	protected function getCategoryField($category, $field)
	{
		// basic check
		if (!$field) return '';

		if (!is_array($field)) {
			$field = array($field);
		}

		$separator = $this->params->get('category_separator', '');
		$return = array();
		foreach ($field as $f) {
			if ($f) {
				switch ($f) {
					case 'description':
						$return[] = $category->description;
						break;
					case 'teaser_description':
						$return[] = $category->getParams()->get('content.teaser_description');
						break;
					case 'alias':
						$return[] = $category->alias;
						break;
					case 'name':
					default:
						$return[] = $category->name;
						break;
				}
			}
		}

		$return = implode($separator, $return);
		return $return;
	}

	/**
	 * Check the dependecies (zlframework)
	 */
	public function checkDependencies()
	{
		if($this->joomla->isAdmin())
		{
			// if ZLFW not enabled
			if(!JPluginHelper::isEnabled('system', 'zlframework') || !JComponentHelper::getComponent('com_zoo', true)->enabled) {
				$this->joomla->enqueueMessage(JText::_('PLG_ZOOSEO_MISSING_DEPENDENCIES'), 'notice');
			} else {
				// load zoo
				require_once(JPATH_ADMINISTRATOR.'/components/com_zoo/config.php');

				// fix plugins ordering
				$zoo = App::getInstance('zoo');
				$zoo->loader->register('ZlfwHelper', 'root:plugins/system/zlframework/zlframework/helpers/zlfwhelper.php');
				$zoo->zlfw->checkPluginOrder('zooseo');
			}
		}
	}
}
