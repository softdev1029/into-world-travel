<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Sergey Kalistratov <kalistratov.s.m@gmail.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class JBFilterElementImageBox
 */
class JBFilterElementImageBox extends JBFilterElement
{

    /**
     * Elements object.
     *
     * @var
     */
    protected $_element;

    /**
     * Constructor.
     *
     * @param string $identifier
     * @param array|string $value
     * @param array $params
     * @param array $attrs
     */
    public function __construct($identifier, $value, array $params, array $attrs)
    {
        parent::__construct($identifier, $value, $params, $attrs);

        $this->_element = $this->app->jbfilter->getElement($this->_identifier);
    }

    /**
     * Render html for filter.
     *
     * @return null|string
     */
    public function html()
    {
        $values = $this->_createValues($this->_getDbValues());
        $type   = $this->_isMultiple ? 'checkbox' : 'radio';

        return $this->_getHtml($values, $this->_getName(), array(
            'image' => array(
                'width' => 50,
                'height' => 50
            )
        ), $this->_value, $type);
    }

    /**
     * Create html for filter.
     *
     * @param array $data
     * @param $name
     * @param array $attrs
     * @param null $selected
     * @param string $type
     * @return string
     */
    protected function _getHtml($data = array(), $name, $attrs = array(), $selected = null, $type = 'checkbox')
    {
        $unique    = $this->app->jbstring->getId('image-box-');
        $showTitle = (int)$this->_params->get('jbzoo_filter_show_title', 0);

        $this->app->jbassets->js('elements:imagebox/assets/js/imagebox.js');
        $this->app->jbassets->less('elements:imagebox/assets/less/styles.less');

        $this->app->jbassets->widget('#' . $unique, 'JBZoo.ImageBox', array(
            'type'     => $type,
            'multiple' => ($this->_isMultiple) ? true : false,
        ));

        $attrs['id']    = $unique;
        $attrs['class'] = 'jbzoo-image-box';

        $html      = array();
        $imageAttr = array();

        if ((isset($attrs['image']))) {
            $imageAttr = $attrs['image'];
            unset($attrs['image']);
        }

        $html[] = '<div ' . $this->app->jbhtml->buildAttrs($attrs) . '>';

        $i = 0;
        foreach ($data as $option) {
            $image   = '<img/>';
            $inputId = $this->app->jbstring->getId('image-box-input-');
            $labelId = $this->app->jbstring->getId('image-box-label-');
            $i++;

            if (isset($option['image'])) {
                $imageInfo = $this->app->html->image($option['image']);

                $_imageAttrs = array(
                    'class'  => 'image-box-label-img',
                    'src'    => $imageInfo['src'],
                    'alt'    => $option['text'],
                    'title'  => $option['text'],
                    'width'  => $imageInfo['width'],
                    'height' => $imageInfo['height'],
                );

                $imageAttrs = array_replace($_imageAttrs, $imageAttr);

                $image = '<img ' . $this->app->jbhtml->buildAttrs($imageAttrs) . ' />';
            }

            $labelAttrs = array(
                'id'    => $labelId,
                'for'   => $inputId,
                'class' => 'image-box-label'
            );

            $inputAttrs = array(
                'type'  => $type,
                'id'    => $inputId,
                'name'  => $name,
                'value' => $option['value'],
                'class' => 'image-box-input',
            );

            if ($selected != null) {
                if (is_string($selected) && $selected == $option['value'] || is_array($selected) && in_array($option['value'], $selected)) {
                    $inputAttrs['checked'] = 'checked';
                    $inputAttrs['class'] .= ' checked';
                }
            }

            if ($showTitle) {
                $image .= '<div class="image-box-label-text"><div>' . $option['text'] . '</div></div>';
            }

            $html[] = '<input ' . $this->app->jbhtml->buildAttrs($inputAttrs) . '/>';
            $html[] = '<label ' . $this->app->jbhtml->buildAttrs($labelAttrs) . '>' .  $image . '</label>';

        }

        $html[] = '</div>';


        return implode(PHP_EOL, $html);
    }

    /**
     * Create values.
     *
     * @param $values
     * @return int
     */
    protected function _createValues($values)
    {
        $options = $this->_element->config->get('option');

        $_options = $_values = $output = array();
        foreach ($options as $option) {
            $_options[$option['value']]['name'] = $option['name'];
            $_options[$option['value']]['value'] = $option['value'];
            $_options[$option['value']]['image'] = $option['image'];
        }

        foreach ($values as $value) {
            $_values[$value['value']]['value'] = $value['value'];
            $_values[$value['value']]['count'] = $value['count'];
        }

        $i = 0;
        foreach ($_values as $key => $data) {
            $output[$i]['text'] = $_options[$key]['name'];
            $output[$i]['image'] = $_options[$key]['image'];
            $output[$i]['value'] = $data['value'];
            $output[$i]['count'] = $data['count'];
            $i++;
        }

        return $output;
    }

}
