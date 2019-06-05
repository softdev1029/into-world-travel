<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Andrey Voytsehovsky <kess@jbzoo.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

App::getInstance('zoo')->loader->register('ElementRepeatable', 'elements:repeatable/repeatable.php');

class ElementJBVideo extends ElementRepeatable implements iRepeatSubmittable
{

    const THUMB_TYPE_SIMPLE   = 1;
    const THUMB_TYPE_ITEMLINK = 2;
    const THUMB_TYPE_POPUP    = 3;

    public  $_jbvideoPath;
    protected $_providers = array();

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        $this->_getFolder();
        $this->_initLanguage();
        $this->_initPlugins();
    }

    /**
     * Get the folder of the element
     */
    protected function _getFolder()
    {
        $dir = dirname(__FILE__);
        $this->app->path->register($dir, 'jbvideo');
        $this->_jbvideoPath = $this->app->path->path('jbvideo:');
    }

    /**
     * Initializes plugins for different video providers
     */
    protected function _initPlugins()
    {
        //getting available providers
        $pluginsFiles    = JFolder::files($this->_jbvideoPath . '/plugins/', '^jbprovider\.[a-z]*\.php$');

        //registering main provider class
        $this->app->loader->register('JBProvider', 'jbvideo:plugins/jbprovider.php');

        //registering providers classes
        foreach ($pluginsFiles as $pluginFile) {
            $pluginName = preg_replace('/jbprovider\.|\.php/', '', $pluginFile);
            $pluginName = 'JBProvider' . $pluginName;
            $this->app->loader->register($pluginName, 'jbvideo:plugins/' . $pluginFile);

            if (!class_exists($pluginName)) {
                $msg = JText::sprintf('JBZOO_JBVIDEO_CLASS_DOES_NOT_EXIST', $pluginName);
                throw new AppException($msg);
            }

            $this->_providers[$pluginName] = new $pluginName($this);
        }
    }

    /**
     * Loads main language files
     */
    protected function _initLanguage()
    {
        $language = JFactory::getLanguage();
        $language->load('', $this->_jbvideoPath);
    }

    /**
     * Checks if the element has values
     * @param array $params
     * @return mixed
     */
    protected function _hasValue($params = array())
    {
        $value = $this->get('value');

        return !empty($value);
    }

    /**
     * Creates a string with url parameters
     * @param array $attrs
     * @return mixed
     */
    public function _buildAttrs(array $attrs)
    {
        return $this->app->jbhtml->buildAttrs($attrs);
    }

    /**
     * For editing in the admin panel
     * @return mixed
     */
    protected function _edit()
    {
        $attribs = $this->_buildAttrs(array(
            'size'         => 60,
            'maxlength'    => 255,
            'placeholder ' => JText::_('JBZOO_JBVIDEO_EDIT_PLACEHOLDER'),
        ));

        return $this->app->html->_('control.text', $this->getControlName('value'), $this->get('value'), $attribs);
    }

    /**
     * Renders element
     * @param array $params
     * @return string
     */
    public function render($params = array())
    {

        $params           = $this->app->data->create($params);
        $isOnlyFirst = (int)$params->get('only_first', 0);

        $result = array();
        foreach ($this as $self) {
            $link = $this->get('value');
            foreach ($this->_providers as $providerName => $provider) {
                if ($detect = $provider->detectProvider($link)) {
                    $params->providerName = $providerName;
                    $params->link         = $link;
                    $params->match        = $detect[0];
                    $result[]             = $this->_render($params);
                }
            }
            if ($isOnlyFirst) {
                break;
            }
        }

        return implode("\n", $result);
    }


    /**
     * Renders repeatable parts
     * @param array $params
     * @return string
     * @throws AppException
     */
    protected function _render($params = array())
    {
        $providerName = $params->get('providerName', 'error');
        $provider = $this->_providers[$providerName];

        if (!class_exists($providerName)) {
            $msg = JText::sprintf('JBZOO_JBVIDEO_CLASS_DOES_NOT_EXIST', $providerName);
            throw new AppException($msg);
        }

        $isThumb     = (int)$params->get('show_thumb', 0);
        $thumbSrc = $thumbType = $thumbLink = $thumbWidth = $thumbHeight = '';

        if ($isThumb) {
            $thumbSrc    = $provider->getThumbSrc($params);
            $thumbWidth  = (int)$params->get('thumb_width', 320);
            $thumbHeight = (int)$params->get('thumb_height', 180);
            $thumbType   = (int)$params->get('thumb_type', 1);
            if ($thumbType == self::THUMB_TYPE_ITEMLINK) {
                $item      = $this->getItem();
                $thumbUrl  = $this->app->route->item($item);
                $thumbLink = $this->_buildAttrs(array(
                    'href' => $thumbUrl,
                ));
            } elseif ($thumbType == self::THUMB_TYPE_POPUP) {
                $this->app->jbassets->fancybox();
                $thumbLink = $this->_buildAttrs(array(
                    'class'                => 'jbvideo-popup',
                    'data-fancybox-width'  => (int)$params->get('width', 640),
                    'data-fancybox-height' => (int)$params->get('height', 360),
                    'href'                 => $provider->buildVideoUrl($params),
                ));
            }
        }

        if ($layout = $this->getLayout($provider->layout . '.php')) {
            $videoAttrs = $provider->buildVideoAttrs($params);
            if (!$provider->isValidVideo) {
                return '';
            } else {
                return $this->renderLayout($layout, array(
                    'videoAttrs'   => $videoAttrs,
                    'thumbAttrs'   => $this->_buildAttrs(array(
                            'src'    => $thumbSrc,
                            'width'  => $thumbWidth,
                            'height' => $thumbHeight,
                        )),
                    'isThumb'      => $isThumb,
                    'thumbType'    => $thumbType,
                    'thumbLink'    => $thumbLink,
                    'providerName' => $provider->providerName,
                ));
            }
        }
    }

    /**
     * For the front-end submission
     * @param array $params
     * @return mixed
     */
    public function _renderSubmission($params = array())
    {
        return $this->_edit();
    }

    /**
     * Validates front-end submission
     * @param $value
     * @param $params
     * @return array
     * @throws AppValidatorException
     */
    public function _validateSubmission($value, $params)
    {
        $url = $this->app->validator
            ->create('url', array('required' => $params->get('required', 0)))
            ->clean($value->get('value'));

        if ($url) {
            $check           = false;
            $providersString = '';
            foreach ($this->_providers as $provider) {
                if ($check = $provider->validateSubmission($url)) {
                    break;
                }
                $providersString .= "\n" . JText::_('JBZOO_JBVIDEO_' . $provider->providerName);
            }
            if (!$check) {
                if ($providersString) {
                    $msg = JText::sprintf('JBZOO_JBVIDEO_UNSUPPORTED_SERVICE', nl2br($providersString));
                } else {
                    $msg = JText::_('JBZOO_JBVIDEO_NO_SERVICES_SUPPORTED');
                }
                throw new AppValidatorException($msg);
            }

            return array('value' => $url);
        }

        return array('value' => '');
    }

}

