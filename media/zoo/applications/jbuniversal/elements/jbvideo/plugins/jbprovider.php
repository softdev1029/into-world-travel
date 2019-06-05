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

abstract class JBProvider
{
    public $layout                = 'iframe';
    public $isValidVideo          = true;
    public $providerDetectPattern = '';
    public $providerName;

    /**
     * @var App
     */
    protected $app;

    /**
     * @var ElementJBVideo
     */
    protected $element;

    /**
     * Constructor
     * @param ElementJBVideo $element
     */
    public function __construct(ElementJBVideo $element)
    {
        $this->app = App::getInstance('zoo');
        $this->element = $element;

        //loading language files
        $language = JFactory::getLanguage();
        $language->load($this->providerName, $element->_jbvideoPath);
    }

    /**
     * Adds a string with parameters to the url
     * @param $url
     * @param array $attrs
     * @return string
     */
    protected function _addParamsToUrl($url, array $attrs)
    {
        return $this->app->jbrouter->addParamsToUrl($url, $attrs);
    }

    /**
     * Builds the url of the video that can be inserted in an iframe, for example
     * @param $params
     * @return string
     */
    abstract public function buildVideoUrl($params);

    /**
     * Plugin specific decoding of API call result
     * @param $responseBody
     * @return string
     */
    protected function _apiCall($responseBody)
    {
        return '';
    }

    /**
     * Builds attributes for the html tag with the video
     * @param $params
     * @return bool|string
     */
    public function buildVideoAttrs($params)
    {
        if (!$src = $this->buildVideoUrl($params)) {
            $this->isValidVideo = false;

            return false;
        }

        $width  = (int)$params->get('width', 640);
        $height = (int)$params->get('height', 360);

        $this->videoAttrs           = array();
        $this->videoAttrs['width']  = $width;
        $this->videoAttrs['height'] = $height;
        $this->videoAttrs['src']    = $src;
    }

    /**
     * Getting a link to the thumbnail image
     * @param $params
     * @return string
     */
    abstract public function getThumbSrc($params);

    /**
     * Makes a call to the provider API
     * @param $url
     * @return bool|mixed
     */
    protected function apiCall($url)
    {
        $group = 'jbvideo_cache';

        //using cache to avoid a ban from API
        if (!($responseData = $this->app->jbcache->get($url, $group, true))) {

            $jhttp    = JHttpFactory::getHttp();
            $response = $jhttp->get($url);

            if ($response->code == 200) {
                $responseData = $this->_apiCall($response->body);
            } else {
                $responseData = false;
            }

            $this->app->jbcache->set($url, $responseData, $group, true);
        }

        return $responseData;
    }

    /**
     * Method used in front-end submission validation
     * @param $url
     * @return bool
     */
    public function validateSubmission($url)
    {
        if (preg_match($this->providerDetectPattern, $url)) {
            return true;
        }

        return false;
    }

    /**
     * Method is used in provider detection
     * @param $url
     * @return bool|array
     */
    public function detectProvider($url)
    {
        if (preg_match($this->providerDetectPattern, $url, $match)) {
            return $match;
        }

        return false;
    }

}