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
	'{"fields": {

		"order":{
			"type": "select",
			"label": "Order",
			"default": "default",
			"specific":{
				"options":{
					"Default":"default",
					"Random":"random"
				}
			}
		},
		"total_width":{
			"type": "text",
			"label": "Total Width",
			"default": "auto"
		},
		"spacing":{
			"type": "text",
			"label": "Spacing",
			"default": "0"
		},
		"center":{
			"type": "radio",
			"label": "Center Image",
			"default": "1"
		},
		"sticky":{
			"type": "radio",
			"label": "Sticky",
			"default": "0"
		},
		"duration":{
			"type": "text",
			"label": "Effect Duration (ms)",
			"default": "500"
		},
		"zl_captions":{
			"type": "select",
			"label": "Captions",
			"default": "1",
			"specific":{
				"options":{
					"PLG_ZLFRAMEWORK_DISABLED":"0",
					"PLG_ZLFRAMEWORK_DEFAULT":"1",
					"PLG_ZLFRAMEWORK_CUSTOM":"2"
				}
			},
			"dependents":"_custom_caption > 2 | caption_animation_duration !> 0"
		},
		"_custom_caption":{
			"label":"Custom Caption",
			"type":"text"
		}
		
	}}';