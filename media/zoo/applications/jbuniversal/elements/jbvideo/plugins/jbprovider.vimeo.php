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

class JBProviderVimeo extends JBProvider
{

    public $providerDetectPattern = '/vimeo\.com/';
    public $providerName = 'vimeo';

    const THUMB_SMALL  = 1;
    const THUMB_MEDIUM = 2;
    const THUMB_LARGE  = 3;

    /**
     * Builds the url of the video that can be inserted in an iframe
     * @param $params
     * @return string
     */
    public function buildVideoUrl($params)
    {
        $videoId = $this->_getVideoId($params);

        $videoUrl    = '//player.vimeo.com/video/' . $videoId;
        $isAutoplay  = (int)$params->get('autoplay', 0);
        $isAutopause = (int)$params->get('vimeo_autopause', 1);
        $isBadge     = (int)$params->get('vimeo_badge', 1);
        $isByline    = (int)$params->get('vimeo_byline', 1);
        $isLoop      = (int)$params->get('vimeo_loop', 0);
        $isPortrait  = (int)$params->get('vimeo_portrait', 1);
        $isTitle     = (int)$params->get('vimeo_title', 1);
        $color       = $params->get('vimeo_color', '00adef');

        $iframeUrlParams = array();

        $iframeUrlParams['autoplay']  = ($isAutoplay) ? 1 : 0;
        $iframeUrlParams['autopause'] = ($isAutopause) ? 1 : 0;
        $iframeUrlParams['badge']     = ($isBadge) ? 1 : 0;
        $iframeUrlParams['byline']    = ($isByline) ? 1 : 0;
        $iframeUrlParams['loop']      = ($isLoop) ? 1 : 0;
        $iframeUrlParams['portrait']  = ($isPortrait) ? 1 : 0;
        $iframeUrlParams['title']     = ($isTitle) ? 1 : 0;
        $iframeUrlParams['color']     = $color;

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
        $this->videoAttrs['frameborder'] = 0;

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

        $apiUrl      = 'http://vimeo.com/api/v2/video/' . $videoId . '.php';
        $apiResponse = $this->apiCall($apiUrl);
        if ($apiResponse) {
            $thumbImg = (int)$params->get('vimeo_thumb', 1);

            if ($thumbImg == self::THUMB_SMALL) {
                $thumbImg = 'small';
            } elseif ($thumbImg == self::THUMB_MEDIUM) {
                $thumbImg = 'medium';
            } elseif ($thumbImg == self::THUMB_LARGE) {
                $thumbImg = 'large';
            }

            $thumbUrl = $apiResponse[0]['thumbnail_' . $thumbImg];

            return $thumbUrl;
        }

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
        $videoIdPattern = '/.*vimeo\.com\//';
        $videoId        = preg_replace($videoIdPattern, '', $params->get('link', ''));

        return $videoId;
    }

}