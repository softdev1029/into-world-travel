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

	// init vars
	$type = $psv->get('_widget');

	return
	'{"fields": {
		
		"style":{
			"type":"layout",
			"label":"Style",
			"default":"default",
			"specific": {
				"path":"media:widgetkit\/widgets\/' . $type . '\/styles",
				"mode":"folders"
			},
			"childs":{
				"loadfields": {

					"subfield": {
						"type":"subfield",
						"path":"zlfield:json\/widgetkit\/settings.json.php"
					}

				}
			}
		}

	},
	"control": "settings"}';