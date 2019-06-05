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

class JBProviderCoub extends JBProvider
{

    public $providerDetectPattern = '/coub\.com/';
    public $providerName = 'coub';

    /**
     * Builds the url of the video that can be inserted in an iframe
     * @param $params
     * @return string
     */
    public function buildVideoUrl($params)
    {
        $videoId = $this->_getVideoId($params);

        $videoUrl        = 'http://coub.com/embed/' . $videoId;
        $isAutoplay      = (int)$params->get('autoplay', 0);
        $isHideTopBar    = (int)$params->get('coub_hidetopbar', 0);
        $isNoSiteButtons = (int)$params->get('coub_nositebuttons', 0);
        $isStartWithHd   = (int)$params->get('coub_startwithhd', 0);
        $isMuted         = (int)$params->get('coub_muted', 0);

        $iframeUrlParams = array();

        $iframeUrlParams['autostart']     = ($isAutoplay) ? 'true' : 'false';
        $iframeUrlParams['noSiteButtons'] = ($isNoSiteButtons) ? 'true' : 'false';
        if ($isHideTopBar) {
            $iframeUrlParams['hideTopBar']    = 'true';
            $iframeUrlParams['noSiteButtons'] = 'false';
        }
        $iframeUrlParams['startWithHD']  = ($isStartWithHd) ? 'true' : 'false';
        $iframeUrlParams['muted']        = ($isMuted) ? 'true' : 'false';
        $iframeUrlParams['originalSize'] = 'false';

        if ($iframeUrlParams) {
            $videoUrl = $this->_addParamsToUrl($videoUrl, $iframeUrlParams);
        }

        return $videoUrl;
    }

    /**
     * Builds attributes for the html tag with the video
     * @param $params
     * @return string
     */
    public function buildVideoAttrs($params)
    {
        parent::buildVideoAttrs($params);
        $this->videoAttrs['frameborder']     = 0;
        $this->videoAttrs['allowfullscreen'] = 'true';

        return $this->element->_buildAttrs($this->videoAttrs);
    }

    /**
     * Getting a link to the thumbnail image
     * @param $params
     * @return string
     */
    public function getThumbSrc($params)
    {
        $videoId = $this->_getVideoId($params);

        $apiUrl      = 'http://coub.com/api/oembed.json?url=http://coub.com/embed/' . $videoId;
        $apiResponse = $this->apiCall($apiUrl);
        if ($apiResponse) {
            $thumbUrl = $apiResponse->thumbnail_url;

            return $thumbUrl;
        }

        return false;
    }

    /**
     * Decoding the result of API call
     * @param $responseBody
     * @return object
     */
    public function _apiCall($responseBody)
    {
        $result = json_decode($responseBody);

        return $result;
    }

    /**
     * Getting ID of the video
     * @param $params
     * @return string
     */
    private function _getVideoId($params)
    {
        $videoIdPattern = '/.*coub\.com\/view\//';
        $videoId        = preg_replace($videoIdPattern, '', $params->get('link', ''));

        return $videoId;
    }
}