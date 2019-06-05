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

class JBProviderRutube extends JBProvider
{

    private $videoIdPattern = '/\<iframe.*embed\/|\".*iframe\>/';

    public $providerDetectPattern = '/rutube\.ru/';
    public $providerName = 'rutube';

    const THUMB_SMALL  = 1;
    const THUMB_MEDIUM = 2;
    const THUMB_LARGE  = 3;

    /**
     * Builds the url of the video that can be inserted in an iframe
     * @param $params
     * @return bool|string
     */
    public function buildVideoUrl($params)
    {
        if ($apiResponse = $this->_getApiResponse($params)) {
            $responseHtml = $apiResponse->html;
            $videoId      = preg_replace($this->videoIdPattern, '', $responseHtml);

            $videoUrl   = '//rutube.ru/play/embed/' . $videoId;
            $isAutoplay = (int)$params->get('autoplay', 0);
            $isTitle    = (int)$params->get('rutube_showtitle', 1);
            $isAuthor   = (int)$params->get('rutube_showauthor', 1);
            $isFullTab  = (int)$params->get('rutube_fulltab', 0);
            $skinColor  = $params->get('rutube_color', '0e8dee');

            $iframeUrlParams = array();

            $iframeUrlParams['autoStart'] = ($isAutoplay) ? 'true' : 'false';
            $iframeUrlParams['sTitle']    = ($isTitle) ? 'true' : 'false';
            $iframeUrlParams['sAuthor']   = ($isAuthor) ? 'true' : 'false';
            $iframeUrlParams['isFullTab'] = ($isFullTab) ? 'true' : 'false';
            $iframeUrlParams['skinColor'] = $skinColor;

            if ($iframeUrlParams) {
                $videoUrl = $this->_addParamsToUrl($videoUrl, $iframeUrlParams);
            }

            return $videoUrl;
        }

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
        $this->videoAttrs['frameborder'] = '0';

        return $this->element->_buildAttrs($this->videoAttrs);
    }

    /**
     * Getting a link to the thumbnail image
     * @param $params
     * @return bool|string
     */
    public function getThumbSrc($params)
    {
        if ($apiResponse = $this->_getApiResponse($params)) {
            $thumbImg = (int)$params->get('rutube_thumb', 1);

            if ($thumbImg == self::THUMB_SMALL) {
                $thumbImg = 's';
            } elseif ($thumbImg == self::THUMB_MEDIUM) {
                $thumbImg = 'm';
            } elseif ($thumbImg == self::THUMB_LARGE) {
                $thumbImg = 'l';
            }

            $thumbUrl = $apiResponse->thumbnail_url;
            $thumbUrl = preg_replace('/\?.*/', '', $thumbUrl);
            $thumbUrl .= '?size=' . $thumbImg;

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
     * @param $params
     * @return object
     */
    private function _getApiResponse($params)
    {
        //adds a forward slash at the end if it's missing
        $pattern = '/\/$/';
        $link = $params->get('link', '');
        if (!preg_match($pattern, $link)) {
            $link .= '/';
        }

        $apiUrl      = 'http://rutube.ru/api/oembed/?url=' . $link . '&format=json';
        $apiResponse = $this->apiCall($apiUrl);

        return $apiResponse;
    }
}