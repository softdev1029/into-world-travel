<?php
/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die();

// load config
require_once(JPATH_ADMINISTRATOR . '/components/com_zoo/config.php');

	return 
	'{
		"slides_settings": {
			"type":"subfield",
			"path":"elements:pro\/tmpl\/render\/widgetkit\/slideshow\/slides_settings.php"
		},
		"navigation":{
			"type": "select",
			"label": "Navigation",
			"default": "left",
			"specific":{
				"options":{
					"Left":"left",
					"Center":"center",
					"Right":"right"
				}
			}
		},
		"animated":{
			"type": "select",
			"label": "Effect",
			"default": "fade",
			"specific":{
				"options":{
					"Fade":"fade",
					"Scroll":"scroll"
				}
			}
		}
	}';