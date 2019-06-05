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

class JBProviderOk extends JBProvider
{

  public $providerDetectPattern = '/ok\.ru/';
  public $providerName = 'ok';

    /**
     * Builds the url of the video that can be inserted in an iframe
     * @param $params
     * @return string
     */
    public function buildVideoUrl($params)
    {
      $videoId = $this->_getVideoId($params);

      if (!empty($videoId)) {
        $videoUrl    = '//ok.ru/videoembed/' . $videoId;

        if ($iframeUrlParams) {
          $videoUrl = $this->_addParamsToUrl($videoUrl, $iframeUrlParams);
        }

        return $videoUrl;
      }

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
      $videoIdPattern = '/.*ok\.ru\//';
      $get_okvideo = $params->get('link', '');


   //     $videoId
      preg_match('/iframe(.*?)/', $get_okvideo, $okiframe);

      if ($okiframe[0] == 'iframe') {
       return $videoId;
     }

     else {

     }

     $videoId = str_replace('http://ok.ru/video/', '', $get_okvideo);

       if (!empty($videoId)) {

         return $videoId;

       } else {
        return false;
      }

    }

  }

