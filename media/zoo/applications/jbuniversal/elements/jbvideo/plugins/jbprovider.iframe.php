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

class JBProviderIframe extends JBProvider
{

    public $providerDetectPattern = '/iframe/';
    public $providerName = 'iframe';

    /**
     * Builds the url of the video that can be inserted in an iframe
     * @param $params
     * @return string
     */
    public function buildVideoUrl($params)
    {
        $videoUrl = $params->get('link', '');
        echo $videoUrl;

        return false;

    }

    /**
     * Builds attributes for the html tag with the video
     * @param $params
     * @return string
     */
    public function buildVideoAttrs($params)
    {
        parent::buildVideoAttrs($params);
         return false;
    }

    /**
     * Getting a link to the thumbnail image
     * @param $params
     * @return string
     */
    public function getThumbSrc($params)
    {


        return false;
    }

    /**
     * Decoding the result of API call
     * @param $responseBody
     * @return array
     */
    public function _apiCall($responseBody)
    {
        $result = unserialize($responseBody);

        return $result;
    }

    /**
     * Getting ID of the video
     * @param $params
     * @return string
     */
    private function _getVideoId($params)
    {
  return false;}
}

