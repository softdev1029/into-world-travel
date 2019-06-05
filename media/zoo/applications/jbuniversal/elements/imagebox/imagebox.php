<?php
/*************************
 * @package   ZOO Component
 * @file      graphibox.php
 * @version   3.2.0 August 2014
 * @author    Attavus M.D. http://www.raslab.org
 * @copyright Copyright (C) 2011 - 2014 R.A.S.Lab[.org]
 * @license   http://opensource.org/licenses/GPL-2.0 GNU/GPLv2 only
 ****************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// register ElementOption class
App::getInstance('zoo')->loader->register('ElementOption', 'elements:option/option.php');
///App::getInstance('zoo')->loader->register('ElementRepeatable', 'elements:repeatable/repeatable.php');
/*
	Class: ElementGraphiBox
		The checkbox element class
*/

class ElementImageBox extends ElementOption implements iSubmittable
{

    /*
       Function: Constructor
    */
    public function __construct()
    {
        parent::__construct();
        App::getInstance('zoo')->loader->register('JBCSVItemuserimagebox', 'elements:imagebox/csvimagebox.php');
        // load language
        $this->loadLanguage();
    }

    /**
     * Get elements search data.
     * @return null|string
     */
    public function getSearchData()
    {
        $options = $this->get('option');

        if (empty($options)) {
            return null;
        }

        $result = implode(PHP_EOL, $options);

        return (empty($result) ? null : $result);
    }

    /*
        Function: getConfigForm
            Get parameter form object to render input form.

        Returns:
            Parameter Object
    */
    public function getConfigForm()
    {
        $form = parent::getConfigForm();
        $form->addElementPath(dirname(__FILE__) . '/fields');
        return $form;
    }

    /*
        Function: loadConfigAssets()
            Load elements css/js config assets.

        Returns:
            Void
    */
    public function loadConfigAssets()
    {
        $this->app->document->addScript('elements:imagebox/assets/js/myimage.js');
        $this->app->document->addStylesheet('elements:imagebox/assets/css/editoption.css');
        $this->app->document->addScript('elements:imagebox/assets/js/myoption.js');
        $this->app->document->addStylesheet('elements:option/option.css');
    }

    /*
       Function: editOption
          Renders elements options for form input.

       Parameters:
          $var - form var name
          $num - option order number

       Returns:
          Array
    */
    public function editOption($var, $num, $name = null, $value = null, $image = null)
    {
        // init vars
        $path = $this->app->path->path('elements:imagebox/tmpl/editoption.php');
        // render option
        return $this->renderLayout($path, compact('var', 'num', 'name', 'value', 'image'));
    }

    /*
        Function: loadAssets()
            Load elements css/js assets.

        Returns:
            Void
    */
    public function loadAssets()
    {
        $this->app->document->addStylesheet('elements:imagebox/assets/css/edit.css');
        return parent::loadAssets();
    }

    /*
       Function: edit
           Renders the edit form field.

       Returns:
           String - html
    */
    public function edit()
    {
        // init vars
        $input_type = $this->config->get('input_type', 'checkbox');
        $options_from_config = $this->config->get('option', array());
        $default_option = $this->config->get('default');
        $show_label = $this->config->get('show_label', 'false');
        $multiple = $this->config->get('multiple');
        $data_limit = $this->config->get('data_limit');

        $sizeStyle = '';
        $paramwidth = $this->config->get('adminwidth');
        $paramheight = $this->config->get('adminheight');
        $width = $paramwidth ? 'width:' . $paramwidth . 'px' : '';
        $height = $paramheight ? 'height:' . $paramheight . 'px' : '';
        if ($width || $height) {
            $sizeStyle = 'style="' . $width . ($width ? ';' . $height : $height) . '"';
        }

        //
        if (count($options_from_config)) {
            // set default, if item is new
            if ($default_option != '' && $this->_item != null && $this->_item->id == 0) {
                $default_option = array($default_option);
            } else {
                $default_option = array();
            }
            $control_name = $this->getControlName('option', true);
            $selected_options = $this->get('option', array());
            $i = 0;
            $html = array();
            if ($input_type == 'select') {
                // image picker js and css
                $this->app->document->addScript('elements:imagebox/assets/js/image-picker.min.js');
                $this->app->document->addStylesheet('elements:imagebox/assets/css/image-picker.css');
                // opening html
                $html[] = '<select name="' . $control_name . '" ' . (!empty($data_limit) ? 'data-limit="' . (int)$data_limit . '"' : '') . ' ' . ($multiple ? 'multiple="multiple" size="' . max(min(count($options_from_config), 10), 3) . '"' : '') . ' >';
            }
            foreach ($options_from_config as $option) {
                // clear vars
                $image_info = array();
                $image_html = '<img/>';
                $checked = in_array($option['value'], $selected_options) ? ($input_type == 'select' ? ' selected="selected"' : ' checked="checked"') : null;
                // set image data
                if (isset($option['image'])) {
                    $image_info = $this->app->html->image($option['image']);
                    $image_html = '<img ' . $sizeStyle . ' src="' . $image_info['src'] . '" title="' . $option['name'] . '" /><br/>';
                }
                // set options
                if ($input_type == 'checkbox' || $input_type == 'radio') {
                    $html[] = '<input type="' . $input_type . '" id="' . $control_name . $i . '" name="' . $control_name . '" value="' . $option['value'] . '"' . $checked . ' /><label for="' . $control_name . $i . '" id="' . $control_name . $i . '-lbl">' . ($show_label == 'true' ? $option['name'] : '') . $image_html . '</label>';
                } elseif ($input_type == 'select') {
                    $html[] = '<option data-img-src="' . (isset($image_info['src']) ? $image_info['src'] : '') . '" data-img-label="' . $option['name'] . '" value="' . $option['value'] . '" ' . $checked . '>' . $option['name'] . '</option>';
                }
                $i++;
            }
            // workaround: if nothing is selected, the element is still being transfered
            if ($input_type == 'checkbox') {
                $html[] = '<input type="hidden" name="' . $this->getControlName('check') . '" value="1" />';
            } elseif ($input_type == 'select') {
                // closing html
                $html[] = '</select>';
                $html[] = '<input type="hidden" name="' . $this->getControlName('select') . '" value="1" />';
                $html[] = '<script type="text/javascript">jQuery(function($) {'
                    . '$("select[name=\'' . $control_name . '\']").imagepicker({hide_select: ' . $this->config->get('hide_select', 'true') . ', show_label: ' . $show_label . (!empty($data_limit) ? ', limit: "' . (int)$data_limit . '", limit_reached: function() {alert("' . JText::_('We are full') . '")}' : '') . '});'
                    . '$("select[name=\'' . $control_name . '\']").data("picker").sync_picker_with_select();'
                    . '});'
                    . '</script>';
            }
            // output
            return '<div class="graphibox-edit">' . implode("\n", $html) . '</div>';
        }

        return '<div class="graphibox-edit">' . JText::_("There are no options to choose from.") . '</div>';
    }

    /*
        Function: render
            Renders the element.

       Parameters:
            $params - render parameter

        Returns:
            String - html
    */
    public function render($params = array())
    {
        // init vars
        $options_from_config = $this->config->get('option');
        $selected_options = $this->get('option', array());
        // init display params
        $params = $this->app->data->create($params);
        $option_name = $params->get('option_name', 1);
        $separated_by = $params->get('separated_by');
        // include assets css
        $this->app->document->addStylesheet('elements:imagebox/assets/css/imagebox.css');
        $options = array();

        $sizeStyle = '';
        $paramwidth = $this->config->get('renderwidth');
        $paramheight = $this->config->get('renderheight');
        $width = $paramwidth ? 'width:' . $paramwidth . 'px' : '';
        $height = $paramheight ? 'height:' . $paramheight . 'px' : '';
        if ($width || $height) {
            $sizeStyle = 'style="' . $width . ($width ? ';' . $height : $height) . '"';
        }

        foreach ($options_from_config as $option) {
            if (in_array($option['value'], $selected_options)) {
                if (isset($option['image']) && JFile::exists($option['image'])) {
                    $info = getimagesize($option['image']);
                    $options[] = '<div class="gboxicon"><img  ' . $sizeStyle . ' src="' . $option['image'] . '" title="' . $option['name'] . '"' . $info[3] . ' />' . (!empty($option_name) ? '<br/><div style="text-align: center;">' . $option['name'] . '</div>' : '') . '</div>';

                } else {
                    $options[] = '<div class="gboxicon">' . $option['name'] . '</div>';
                }
            }
        }

        return $this->app->element->applySeparators($params['separated_by'], $options);
    }

    /*
        Function: loadLanguage
            Load elements language file.

        Returns:
            Void
    */
    public function loadLanguage()
    {
        // init vars
        $element = strtolower($this->getElementType());
        $path = $this->app->path->path('elements:' . $element);
        $jlang = $this->app->system->language;
        // lets load first english, then joomla default standard, then user language
        $jlang->load('com_zoo.element.' . $element, $path, 'en-GB', true);
        $jlang->load('com_zoo.element.' . $element, $path, $jlang->getDefault(), true);
        $jlang->load('com_zoo.element.' . $element, $path, null, true);
    }

}
