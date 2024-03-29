<?php
/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die();

	// return json string
	return
	'{
		"_chosenapps":{
			"type":"apps",
			"label": "'.$params->find('label', 'PLG_ZLFRAMEWORK_APP').'",
			"help": "'.$params->find('help').'",
			"specific": {
				"options":{
					"PLG_ZLFRAMEWORK_SELECT_APP":""
				}
			},
			"childs":{
				"loadfields":{

					'./* Submissions */ '
					"_chosensubmissions":{
						"type":"submissions",
						"label":" ",
						"specific":{
							'.($params->find('submissions.multi') ? '"multi":"1",' : '').'
							"value_map":{
								"apps":"_chosenapps"
							}
							'.(!$params->find('types.multi') ? ',
							"options":{
								"PLG_ZLFRAMEWORK_SELECT_SUBMISSION":""
							}' : '').'
						},
						"childs":{
							"loadfields": {

								'./* Types */ '
								"_chosentypes":{
									"type":"types",
									"label":" ",
									"specific":{
										'.($params->find('types.multi') ? '"multi":"1",' : '').'
										"value_map":{
											"apps":"_chosenapps",
											"submissions":"_chosensubmissions"
										}
										'.(!$params->find('types.multi') ? ',
										"options":{
											"PLG_ZLFRAMEWORK_SELECT_TYPE":""
										}' : '').'
									}
								}
							}
						}
					}

				}
			}
		}
	}';
?>