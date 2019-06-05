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
			"type": "radio",
			"label": "Navigation",
			"default": "1",
			"specific":{
				"options":{
					"show":"1",
					"hide":"0"
				}
			}
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
					"SliceUpDown":"sliceUpDown",
					"Swipe":"swipe",
					"Fold":"fold",
					"Puzzle":"puzzle",
					"Boxes":"boxes",
					"BoxesRtl":"boxesRtl",
					"KenBurns":"kenburns",
					"RandomSimple":"randomSimple",
					"RandomFx":"randomFx"
				}
			}
		},
		"zl_captions":{
			"type": "radio",
			"label": "Captions",
			"default": "1",
			"specific":{
				"options":{
					"show":"1",
					"hide":"0"
				}
			}
		},
		"caption_animation_duration":{
			"type": "text",
			"label": "Caption Animation Duration",
			"default": "500"
		}
	}';