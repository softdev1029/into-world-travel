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
		"buttons":{
			"type": "radio",
			"label": "Buttons",
			"default": "1",
			"specific":{
				"options":{
					"show":"1",
					"hide":"0"
				}
			}
		},
		"slices":{
			"type": "text",
			"label": "Slices",
			"default": "20"
		},
		"animated":{
			"type": "select",
			"label": "Effect",
			"default": "randomSimple",
			"specific":{
				"options":{
					"Top":"top",
					"Bottom":"bottom",
					"Left":"left",
					"Right":"right",
					"Fade":"fade",
					"ScrollLeft":"scrollLeft",
					"ScrollRight":"scrollRight",
					"Scroll":"scroll",
					"SliceUp":"sliceUp",
					"SliceDown":"sliceDown",
					"Swipe":"swipe",
					"Fold":"fold",
					"Puzzle":"puzzle",
					"Boxes":"boxes",
					"BoxesRtl":"boxesRtl",
					"RandomSimple":"randomSimple",
					"RandomFx":"randomFx"
				}
			}
		},
		"caption_animation_duration":{
			"type": "text",
			"label": "Caption Animation Duration",
			"default": "500"
		},
		"effect":{
			"type": "select",
			"label": "Slideset Effect",
			"default": "slide",
			"specific":{
				"options":{
					"Slide":"slide",
					"Zoom":"zoom",
					"Deck":"deck"
				}
			}
		},
		"slideset_buttons":{
			"type": "radio",
			"label": "Slideset Buttons",
			"default": "1",
			"specific":{
				"options":{
					"show":"1",
					"hide":"0"
				}
			}
		},
		"items_per_set":{
			"type": "text",
			"label": "Items Per Set",
			"default": "3"
		},
		"slideset_effect_duration":{
			"type": "text",
			"label": "Slideset Effect Duration (ms)",
			"default": "300"
		}
	}';