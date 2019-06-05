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

class JBProviderVk extends JBProvider
{

  public $providerDetectPattern = '/vk\.com/';
  public $providerName = 'vk';

    /**
     * Builds the url of the video that can be inserted in an iframe
     * @param $params
     * @return string
     */
    public function buildVideoUrl($params)
    {
      $videoId = $this->_getVideoId($params);

      if (!empty($videoId)) {
        $videoUrl    = '//vk.com/video_ext.php' . $videoId;

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
      $videoIdPattern = '/.*vk\.com\//';
      $get_vkvideoinfo = $params->get('link', '');


   //     $videoId
      preg_match('/iframe(.*?)/', $get_vkvideoinfo, $vkifr);

      if ($vkifr[0] == 'iframe') {
       return $videoId;
     }

     else {

     }
     $get_vkvideoinfogetcontents = file_get_contents($get_vkvideoinfo);

     if ($get_vkvideoinfogetcontents == ($_SERVER["REDIRECT_STATUS"] != '403')) {
 //              echo "Все ОК"; echo "<br>"; echo "<br>";

    // echo "<pre>";
    // print_r($get_vkvideoinfogetcontents);
    // echo "</pre>";

       $getvideotourl = str_replace("http://vk.com", "", $get_vkvideoinfo);
       $getvideotourl = str_replace("video?z=", "", $get_vkvideoinfo);
//              echo "URL - ".$getvideotourl;
//               echo "<br>";
       preg_match('/video(.*?)_/', $getvideotourl, $getvid);
//               echo "<br> Video ID ";
//              echo $getvid[1];
 //              echo "<br>";
       $idvkvideoiframe = $getvid[1];

       preg_match('/(.+)_(.+)/', $getvideotourl, $getviduserid);
//               echo "<br> USER ID  ";
//               echo $getviduserid[2];
//               echo "<br>";
       $idvkvideouserid = $getviduserid[2];

       preg_match('/hash2(.*?)is_vk/', $get_vkvideoinfogetcontents, $gethashvk);

       $pat = array('\"',':',',');
       $beatifyvkhash = str_replace($pat, '', $gethashvk[1]);
//               echo "Hash: ".$beatifyvkhash;

       if (!empty($beatifyvkhash)) {

         $videoId = "?oid=".$idvkvideoiframe."&id=".$idvkvideouserid."&hash=".$beatifyvkhash."&hd=3";
         return $videoId;

       } else {
        return false;
      }

    }

    else {
      echo "<! -- Видео требует авторизации для просмотра -->";
      return false;
    }
  }
}
