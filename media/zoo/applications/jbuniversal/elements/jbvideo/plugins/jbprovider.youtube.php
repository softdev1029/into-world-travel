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

class JBProviderYoutube extends JBProvider
{

    public $providerDetectPattern = '/youtube\.com|youtu\.be/';
    public $providerName = 'youtube';

    const ANNOTATIONS_SHOW = 1;
    const ANNOTATIONS_HIDE = 3;

    const THEME_DARK  = 1;
    const THEME_LIGHT = 2;

    const COLOR_RED   = 1;
    const COLOR_WHITE = 2;

    const THUMB_DEFAULT       = 1;
    const THUMB_MQDEFAULT     = 2;
    const THUMB_HQDEFAULT     = 3;
    const THUMB_SDDEFAULT     = 4;
    const THUMB_MAXRESDEFAULT = 5;

    /**
     * Builds the url of the video that can be inserted in an iframe
     * @param $params
     * @return string
     */
    public function buildVideoUrl($params)
    {
        $videoId = $this->_getVideoId($params);

        $isPrivacy     = (int)$params->get('youtube_privacy', 0);
        $videoUrl      = '//www.youtube' . ($isPrivacy ? '-nocookie' : '') . '.com/embed/' . $videoId[1];
        $isAutoplay    = (int)$params->get('autoplay', 0);
        $isRelated     = (int)$params->get('youtube_related', 1);
        $isAnnotations = (int)$params->get('youtube_annotations', 1);
        $isControls    = (int)$params->get('youtube_controls', 1);
        $isLoop        = (int)$params->get('youtube_loop', 0);
        $isInfo        = (int)$params->get('youtube_info', 1);
        $theme         = (int)$params->get('youtube_theme', 1);
        $color         = (int)$params->get('youtube_color', 1);

        $iframeUrlParams = array();

        $iframeUrlParams['autoplay']       = ($isAutoplay) ? 1 : 0;
        $iframeUrlParams['rel']            = ($isRelated) ? 1 : 0;
        $iframeUrlParams['iv_load_policy'] = ($isAnnotations) ? self::ANNOTATIONS_SHOW : self::ANNOTATIONS_HIDE;
        $iframeUrlParams['controls']       = ($isControls) ? 1 : 0;
        $iframeUrlParams['loop']           = ($isLoop) ? 1 : 0;
        if ($isLoop && !$videoId[2]) {
            //if looping is enabled and there is no link to the playlist in the url
            $iframeUrlParams['loop']       = 1;
            //playlist param is required when there is a need to loop a single video
            $iframeUrlParams['playlist']   = $videoId[1];
        } elseif ($isLoop && $videoId[2]) {
            //if looping is enabled and there is a playlist link in the url
            $iframeUrlParams['loop']       = 1;
            $iframeUrlParams['list']       = $videoId[2];
        } elseif ($videoId[2]) {
            //if there is a link to the playlist but no looping
            $iframeUrlParams['list']       = $videoId[2];
        }
        $iframeUrlParams['showinfo']       = ($isInfo) ? 1 : 0;
        $iframeUrlParams['theme']          = ($theme == self::THEME_DARK) ? 'dark' : 'light';
        $iframeUrlParams['color']          = ($color == self::COLOR_RED) ? 'red' : 'white';
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
        $isAllowFullscreen                   = (int)$params->get('youtube_allow_fullscreen', 1);
        $this->videoAttrs['frameborder']     = 0;
        $this->videoAttrs['allowfullscreen'] = ($isAllowFullscreen) ? 1 : 0;

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

        $thumbImg = (int)$params->get('youtube_thumb', 1);

        if ($thumbImg == self::THUMB_DEFAULT) {
            $thumbImg = 'default';
        } elseif ($thumbImg == self::THUMB_MQDEFAULT) {
            $thumbImg = 'mqdefault';
        } elseif ($thumbImg == self::THUMB_HQDEFAULT) {
            $thumbImg = 'hqdefault';
        } elseif ($thumbImg == self::THUMB_SDDEFAULT) {
            $thumbImg = 'sddefault';
        } elseif ($thumbImg == self::THUMB_MAXRESDEFAULT) {
            $thumbImg = 'maxresdefault';
        }
        $thumbUrl = 'http://i1.ytimg.com/vi/' . $videoId[1] . '/' . $thumbImg . '.jpg';

        return $thumbUrl;
    }

    /**
     * Getting ID of the video and its playlist (if present)
     * @param $params
     * @return array
     */
    private function _getVideoId($params)
    {
        $pattern = '/\/watch\?v=([^&]*)(?:&list=)?([^&]*)/i';
        if ($params->get('match', '') == 'youtu.be') {
            $pattern = '/youtu\.be\/([^\?]*)(?:\?list=)?([^&]*)/i';
        }
        preg_match($pattern, $params->get('link', ''), $match);

        return $match;
    }

}