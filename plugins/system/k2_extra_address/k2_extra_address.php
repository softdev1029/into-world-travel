<?php
defined('_JEXEC') or die;
jimport('joomla.version');
class plgSystemK2_Extra_Address extends JPlugin {
	protected $autoloadLanguage = true;
	protected $fieldid = 0;
	private function isAjax(){
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	}
	private function getIDS($prefix, $list, $postfix = '', $separator = ',')  {
        $result = array();
        foreach ($list as $item) {
            $result[] = $prefix . $item . $postfix;
        }
        return implode($separator, $result);
    }
	function onBeforeCompileHead() {
		$app = JFactory::getApplication();
		$option = $app->input->get('option');
		$view = $app->input->get('view');
		
        if($option!=='com_k2' or $view!='item' or !$app->isAdmin()) {
            return false;
        }

		$fields_id = JFactory::getDBO()->setQuery('select id from #__k2_extra_fields where name='.JFactory::getDBO()->quote($this->params->get('fieldname','address')))->loadColumn();

		if (!count($fields_id)) {
            return false;
        }

		$this->fields_id = $fields_id; 

		if (!$this->isAjax()) {
			JHtml::addIncludePath(JPATH_ROOT.'/components/com_yandex_maps/helpers');
			jhtml::_('xdwork.autocomplete');
			jhtml::_('xdwork.yapi');
			JFactory::getDocument()->addScriptDeclaration(';(function($){
				var map,
                    map_ready = false,
                    ready = function () {
                        if ($("' . $this->getIDS('#mapK2ExtraField_', $this->fields_id) . '").length) {
                            map = new ymaps.Map($("' . $this->getIDS('#mapK2ExtraField_', $this->fields_id) . '")[0], {
                                center: [55.76, 37.64], 
                                zoom: 7
                            });
                            map.events.add([\'boundschange\'], function () {
                                var center = map.getCenter(), zoom = map.getZoom();
                                var data, e;
                                try {
                                    data = JSON.parse($("' . $this->getIDS('#K2ExtraField_', $this->fields_id) . '").val());
                                } catch(e) {
                                    data = {address:"", lat:"", lan: "", zoom: ""};
                                }
                                data.lat = center[0];
                                data.lan = center[1];
                                data.zoom = zoom;
                                $("' . $this->getIDS('#K2ExtraField_', $this->fields_id) . '").val(JSON.stringify(data));
                            });
                            $("' . $this->getIDS('#input_K2ExtraField_', $this->fields_id, '_search') . '").trigger(\'selected.xdsoft\');
                        } else {
                            setTimeout(arguments.callee, 300);
                        }
                    };

				$(function(){
					if ($("' . $this->getIDS('#K2ExtraField_', $this->fields_id) . '").length && !$("' . $this->getIDS('#K2ExtraField_', $this->fields_id) . '").is(".disable_xdan")) {
						$("' . $this->getIDS('#K2ExtraField_', $this->fields_id) . '").hide().addClass("disable_xdan");
						$("' . $this->getIDS('#K2ExtraField_', $this->fields_id) . '").each(function () {
                            $(this).after("<input type=\"text\" class=\"xdsoft_search_input\" id=\"input_" + this.getAttribute("id") + "_search\"> "+
                                "<div style=\"position:relative;\"><div id=\"map" + this.getAttribute("id") + "\" style=\"margin-top:5px;border:1px solid #ccc;width:300px;height:250px;position:relative;\"><div class=\"xdsoft_cursor_center\"></div></div></div> "+
                                    "<style> "+
                                    ".xdsoft_cursor_center{ "+
                                    "	z-index:100; "+
                                    "	position:absolute; "+
                                    "	width:1px; "+
                                    "	height:30px; "+
                                    "	border:1px solid #ccc; "+
                                    "	border-width:0px 1px 0px 0px; "+
                                    "	left:50%; "+
                                    "	top:50%; "+
                                    "	margin-top:-15px; "+
                                    "} "+
                                    ".xdsoft_cursor_center:after{ "+
                                    "	content:\"\"; "+
                                    "	position:absolute; "+
                                    "	top:50%; "+
                                    "	left:0; "+
                                    "	width:15px; "+
                                    "	border:1px solid #ccc; "+
                                    "	border-width:1px 0px 0px 0px; "+
                                    "} "+
                                    ".xdsoft_cursor_center:before{ "+
                                    "	content:\"\"; "+
                                    "	position:absolute; "+
                                    "	top:50%; "+
                                    "	right:0; "+
                                    "	width:15px; "+
                                    "	border:1px solid #ccc; "+
                                    "	border-width:1px 0px 0px 0px; "+
                                    "} "+
                                    "</style>");
                            $("#input_" + this.getAttribute("id") + "_search")
                                .on(\'selected.xdsoft keydown.xdsoft\',function(e, datum){
                                    var data, err;
                                    try {
                                        data = JSON.parse($("' . $this->getIDS('#K2ExtraField_', $this->fields_id) . '").val());
                                    } catch(err) {
                                        data = {address:"", lat:"", lan: "", zoom: ""};
                                    }
                                    if ((e.keyCode===13 || e.type!==\'keydown\') && datum) {
                                        data.address = datum.GeoObject.metaDataProperty.GeocoderMetaData.text;
                                        data.lat = datum.GeoObject.Point.pos.split(\' \')[1];
                                        data.lan = datum.GeoObject.Point.pos.split(\' \')[0];
                                        
                                    }
                                    if (map) {
                                        map.setCenter([parseFloat(data.lat) || 55.76, parseFloat(data.lan) || 37.64]);
                                        map.setZoom(parseInt(data.zoom, 10) || 10);
                                    }
                                    $("' . $this->getIDS('#K2ExtraField_', $this->fields_id) . '").val(JSON.stringify(data));
                                    if (e.keyCode===13) {
                                        return false;
                                    }
                                })
                        });
                        
                        if (map_ready) {
                            ready();
                        }
                        
						window.initAutoComplete&&window.initAutoComplete();
					}
					setTimeout(arguments.callee, 300);
				});
                
				ymaps.ready(function() {
                    map_ready = true;
					ready();
				});

			}(window.XDjQuery || window.jQ || window.jQuery));');
		}
	}
	function onAfterRender() {
		$app = JFactory::getApplication();
		$option = $app->input->get('option');
		$view = $app->input->get('view');
		if($option!=='com_k2' or $view!='item' or $app->isAdmin()) return false;
		$fieldid = JFactory::getDBO()->setQuery('select id from #__k2_extra_fields where name='.JFactory::getDBO()->quote($this->params->get('fieldname','address')))->loadResult();
		if (!$fieldid)return false;
		$this->fieldid = $fieldid;
        
        $version = new JVersion();
        
        if (version_compare($version->RELEASE, '3.1') < 0) {
            $body = implode('', JResponse::getBody(true));
        } else {            
            $body = implode('', $app->getBody(true));
        }

		$body = preg_replace('#<li[^>]+>[\s\n\t\r]*<span[^>]+itemExtraFieldsLabel">'.$this->params->get('fieldname','address').':</span>[\s\n\t\r]*<span[^>]+>[^<>]+</span>[\s\n\t\r]*</li>#Usi','', $body);
        
        if (version_compare($version->RELEASE, '3.1') < 0) {
            JResponse::setBody($body);
        } else {            
            $app->setBody($body);
        }
	}
	function __construct(&$subject, $config = array()) {
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}
}