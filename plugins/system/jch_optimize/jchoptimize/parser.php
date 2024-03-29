<?php

/**
 * JCH Optimize - Aggregate and minify external resources for optmized downloads
 * 
 * @author Samuel Marshall <sdmarshall73@gmail.com>
 * @copyright Copyright (c) 2010 Samuel Marshall
 * @license GNU/GPLv3, See LICENSE file
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */
use JchOptimize\Optimize;

defined('_JCH_EXEC') or die('Restricted access');

/**
 * Class to parse HTML and find css and js links to replace, populating an array with matches
 * and removing found links from HTML
 * 
 */
class JchOptimizeParser extends JchOptimizeBase
{

        /** @var string   Html of page */
        public $sHtml = '';

        /** @var array    Array of css or js urls taken from head */
        protected $aLinks = array();
        protected $aUrls  = array();
        public $params    = null;
        public $sLnEnd    = '';
        public $sTab      = '';
        public $sFileHash = '';
        private $bPreserveOrder;
        protected $oFileRetriever;

        /**
         * Constructor
         * 
         * @param JRegistry object $params      Plugin parameters
         * @param string  $sHtml                Page HMTL
         */
        public function __construct($oParams, $sHtml, $oFileRetriever)
        {
                $this->params = $oParams;
                $this->sHtml  = $sHtml;

                $this->oFileRetriever = $oFileRetriever;

                $this->sLnEnd = JchPlatformUtility::lnEnd();
                $this->sTab   = JchPlatformUtility::tab();

                if (!defined('JCH_TEST_MODE'))
                {
                        $oUri            = JchPlatformUri::getInstance();
                        $this->sFileHash = serialize($this->params->getOptions()) . JCH_VERSION . $oUri->getHost();
                }

                $this->parseHtml();
        }

        /**
         * 
         * @return type
         */
        public function getOriginalHtml()
        {
                return $this->sHtml;
        }

        /**
         * 
         * @return type
         */
        public function cleanHtml()
        {
                $hash = preg_replace(array(
                        $this->getHeadRegex(),
                        '#' . $this->ifRegex() . '#',
                        '#' . implode('', $this->getJsRegex()) . '#six',
                        '#' . implode('', $this->getCssRegex()) . '#six'
                        ), '', $this->sHtml);


                return $hash;
        }

        /**
         * 
         */
        public function getHtmlHash()
        {
                $sHtmlHash = '';

                preg_replace_callback('#<(?!/)[^>]++>#i',
                                      function($aM) use (&$sHtmlHash)
                {
                        $sHtmlHash .= $aM[0];

                        return;
                }, $this->cleanHtml(), 200);


                return $sHtmlHash;
        }

        /**
         * Removes applicable js and css links from search area
         * 
         */
        public function parseHtml()
        {
                JCH_DEBUG ? JchPlatformProfiler::start('SetUpExcludes') : null;

                $oParams = $this->params;

                $aCBArgs = array();

                $this->getHeadHtml();
                $this->getBodyHtml();

                if (!JchOptimizeHelper::isMsieLT10() && $oParams->get('combine_files_enable', '1'))
                {
                        loadJchOptimizeClass('JchPlatformExcludes');

                        $aExJsComp  = $this->getExComp($oParams->get('excludeJsComponents', ''));
                        $aExCssComp = $this->getExComp($oParams->get('excludeCssComponents', ''));

                        $aExcludeJs     = JchOptimizeHelper::getArray($oParams->get('excludeJs', ''));
                        $aExcludeCss    = JchOptimizeHelper::getArray($oParams->get('excludeCss', ''));
                        $aExcludeScript = JchOptimizeHelper::getArray($oParams->get('pro_excludeScripts'));
                        $aExcludeStyle  = JchOptimizeHelper::getArray($oParams->get('pro_excludeStyles'));

                        $aExcludeScript = array_map(function($sScript)
                        {
                                return stripslashes($sScript);
                        }, $aExcludeScript);

                        $aCBArgs['excludes']['js']         = array_merge($aExcludeJs, $aExJsComp,
                                                                         array('.com/maps/api/js', '.com/jsapi', '.com/uds', 'typekit.net'),
                                                                         JchPlatformExcludes::head('js'));
                        $aCBArgs['excludes']['css']        = array_merge($aExcludeCss, $aExCssComp, JchPlatformExcludes::head('css'));
                        $aCBArgs['excludes']['js_script']  = $aExcludeScript;
                        $aCBArgs['excludes']['css_script'] = $aExcludeStyle;

                        $aCBArgs['removals']['js']  = JchOptimizeHelper::getArray($oParams->get('removeJs', ''));
                        $aCBArgs['removals']['css'] = JchOptimizeHelper::getArray($oParams->get('removeCss', ''));

                        JCH_DEBUG ? JchPlatformProfiler::stop('SetUpExcludes', TRUE) : null;

                        $this->initSearch($aCBArgs);
                }

                $this->getImagesWithoutAttributes();
        }

        /**
         * 
         * @param type $sType
         */
        protected function initSearch($aCBArgs)
        {

                JCH_DEBUG ? JchPlatformProfiler::start('InitSearch') : null;

                $aJsRegex = $this->getJsRegex();
                $j        = implode('', $aJsRegex);

                $aCssRegex = $this->getCssRegex();
                $c         = implode('', $aCssRegex);

                $i  = $this->ifRegex();
                $ns = '<noscript\b[^>]*+>(?><?[^<]*+)*?</noscript>';

                $sRegex = "#(?>(?:<(?!!))?[^<]*+(?:$i|$ns|<!)?)*?\K(?:$j|$c|\K$)#six";

                $this->iIndex_js    = -1;
                $this->iIndex_css   = -1;
                $this->bExclude_js  = TRUE;
                $this->bExclude_css = TRUE;

                JCH_DEBUG ? JchPlatformProfiler::stop('InitSearch', TRUE) : null;

                $this->searchArea($sRegex, 'head', $aCBArgs);

                ##<procode>##

                if ($this->params->get('pro_searchBody', '0'))
                {
                        $aCBArgs['excludes']['js_script'] = array_merge($aCBArgs['excludes']['js_script'], array('document.write'),
                                                                        JchPlatformExcludes::body('js', 'script'));
                        $aCBArgs['excludes']['js']        = array_merge($aCBArgs['excludes']['js'], array('.com/recaptcha/api'),
                                                                        JchPlatformExcludes::body('js'));

                        $this->searchArea($sRegex, 'body', $aCBArgs);
                }

                ##</procode>##
        }

        /**
         * 
         * @param type $sRegex
         * @param type $sType
         * @param type $sSection
         * @param type $aCBArgs
         * @throws Exception
         */
        protected function searchArea($sRegex, $sSection, $aCBArgs)
        {
                JCH_DEBUG ? JchPlatformProfiler::start('SearchArea - ' . $sSection) : null;

                $obj = $this;

                $sProcessedHtml = preg_replace_callback($sRegex,
                                                        function($aMatches) use ($obj, $aCBArgs)
                {
                        return $obj->replaceScripts($aMatches, $aCBArgs);
                }, $this->{'s' . ucfirst($sSection) . 'Html'});

                if (is_null($sProcessedHtml))
                {
                        throw new Exception(sprintf('Error while parsing for links in %1$s', $sSection));
                }

                $this->{'s' . ucfirst($sSection) . 'Html'} = $sProcessedHtml;

                JCH_DEBUG ? JchPlatformProfiler::stop('SearchArea - ' . $sSection, TRUE) : null;
        }

        /**
         * 
         */
        protected function getImagesWithoutAttributes()
        {
                if ($this->params->get('img_attributes_enable', '0'))
                {
                        JCH_DEBUG ? JchPlatformProfiler::start('GetImagesWithoutAttributes') : null;

                        $rx = '#(?><?[^<]*+)*?\K(?:<img\s++(?!(?=(?>[^\s>]*+\s++)*?width\s*+=\s*+["\'][^\'">a-z]++[\'"])'
                                . '(?=(?>[^\s>]*+\s++)*?height\s*+=\s*+["\'][^\'">a-z]++[\'"]))'
                                . '(?=(?>[^\s>]*+\s++)*?src\s*+=(?:\s*+"([^">]*+)"|\s*+\'([^\'>]*+)\'|([^\s>]++)))[^>]*+>|$)#i';

                        preg_match_all($rx, $this->getBodyHtml(), $m, PREG_PATTERN_ORDER);

                        $this->aLinks['img'] = array_map(function($a)
                        {
                                return array_slice($a, 0, -1);
                        }, $m);

                        JCH_DEBUG ? JchPlatformProfiler::stop('GetImagesWithoutAttributes', true) : null;
                }
        }

        /**
         * Callback function used to remove urls of css and js files in head tags
         *
         * @param array $aMatches       Array of all matches
         * @return string               Returns the url if excluded, empty string otherwise
         */
        public function replaceScripts($aMatches, $aCBArgs)
        {
                $sUrl            = $aMatches['url'] = isset($aMatches[1]) && $aMatches[1] != '' ? 
                        $aMatches[1] : (isset($aMatches[3]) ? $aMatches[3] : '');

                $sDeclaration = isset($aMatches[2]) && $aMatches[2] != '' ? $aMatches[2] : (isset($aMatches[4]) ? $aMatches[4] : '');

                if (preg_match('#^<!--#', $aMatches[0])
                        || (JchOptimizeUrl::isInvalid($sUrl) && trim($sDeclaration) == ''))
                {
                        return $aMatches[0];
                }

                $sType = preg_match('#^<script#i', $aMatches[0]) ? 'js' : 'css';

                if ($sType == 'js' && !$this->params->get('javascript', '1'))
                {
                        return $aMatches[0];
                }

                if ($sType == 'css' && !$this->params->get('css', '1'))
                {
                        return $aMatches[0];
                }

                $this->bPreserveOrder = (bool) !(($sType == 'css' && $this->params->get('pro_optimizeCssDelivery_enable', '0'))
                        || ($this->params->get('bottom_js', '0'))
                        || ($sType == 'js' && $this->params->get('bottom_js', '0') == '1'));


                $aExcludes = array();

                if (isset($aCBArgs['excludes']))
                {
                        $aExcludes = $aCBArgs['excludes'];
                }

                $aRemovals = array();

                if (isset($aCBArgs['removals']))
                {
                        $aRemovals = $aCBArgs['removals'];
                }

                $sMedia = '';

                if (($sType == 'css') && (preg_match('#media=(?(?=["\'])(?:["\']([^"\']+))|(\w+))#i', $aMatches[0], $aMediaTypes) > 0))
                {
                        $sMedia .= $aMediaTypes[1] ? $aMediaTypes[1] : $aMediaTypes[2];
                }

                switch (TRUE)
                {
                        case (($sUrl != '') && !$this->isHttpAdapterAvailable($sUrl)):
                        case ($sUrl != '' && JchOptimizeUrl::isSSL($sUrl) && !extension_loaded('openssl')):
                        case ($sUrl != '' && !JchOptimizeUrl::isHttpScheme($sUrl)):
                        case (($sUrl != '') && !empty($aExcludes[$sType]) && JchOptimizeHelper::findExcludes($aExcludes[$sType], $sUrl)):
                        case ($sDeclaration != '' && $this->excludeDeclaration($sType)):
                        case ($sDeclaration != '' && JchOptimizeHelper::findExcludes($aExcludes[$sType . '_script'], $sDeclaration, $sType)):
                        case (($sUrl != '') && $this->excludeExternalExtensions($sUrl)):

                                $this->{'bExclude_' . $sType} = TRUE;

                                return $aMatches[0];

                        case (($sUrl != '') && $this->isDuplicated($sUrl)):
                        case (($sUrl != '') && !empty($aRemovals[$sType]) && JchOptimizeHelper::findExcludes($aRemovals[$sType], $sUrl)):

                                return '';

                        default:
                                $return = '';

                                if ($this->{'bExclude_' . $sType} && $this->bPreserveOrder)
                                {
                                        $this->{'bExclude_' . $sType} = FALSE;

                                        $iIndex = ++$this->{'iIndex_' . $sType};
                                        $return = '<JCH_' . strtoupper($sType) . $iIndex . '>';
                                }
                                elseif (!$this->bPreserveOrder)
                                {
                                        $iIndex = 0;
                                }
                                else
                                {
                                        $iIndex = $this->{'iIndex_' . $sType};
                                }

                                $array = array();

                                $array['match'] = $aMatches[0];

                                if ($sUrl == '' && trim($sDeclaration) != '')
                                {
                                        $content = JchOptimize\HTML_Optimize::cleanScript($sDeclaration, $sType);

                                        $array['content'] = $content;
                                }
                                else
                                {
                                        $array['url'] = $sUrl;
                                }

                                if ($this->sFileHash != '')
                                {
                                        $array['id'] = $this->getFileID($aMatches);
                                }

                                if ($sType == 'css')
                                {
                                        $array['media'] = $sMedia;
                                }

                                $this->aLinks[$sType][$iIndex][] = $array;

                                return $return;
                }
        }

        /**
         * 
         * @param type $sUrl
         * @return type
         */
        protected function getFileID($aMatches)
        {
                $id = $aMatches[0];

                $containsgf = JchOptimizeHelper::getArray($this->params->get('hidden_containsgf', ''));

                if (!empty($aMatches['url']))
                {
                        if (strpos($aMatches['url'], 'fonts.googleapis.com') !== FALSE
                                || in_array($aMatches['url'], $containsgf))
                        {
                                $browser = JchOptimizeBrowser::getInstance();

                                $id .= $browser->getFontHash();
                        }
                }

                return md5($this->sFileHash . $id);
        }

        /**
         * 
         * @param type $sUrl
         */
        public function isDuplicated($sUrl)
        {
                $sUrl   = JchOptimizeUrl::AbsToProtocolRelative($sUrl);
                $return = in_array($sUrl, $this->aUrls);

                if (!$return)
                {
                        $this->aUrls[] = $sUrl;
                }

                return $return;
        }

        /**
         * 
         * @param type $sPath
         */
        protected function excludeExternalExtensions($sPath)
        {
                if (!$this->params->get('includeAllExtensions', '0'))
                {
                        return !JchOptimizeUrl::isInternal($sPath) || preg_match('#' . JchPlatformExcludes::extensions() . '#i', $sPath);
                }

                return FALSE;
        }

        /**
         * Generates regex for excluding components set in plugin params
         * 
         * @param string $param
         * @return string
         */
        protected function getExComp($sExComParam)
        {
                $aComponents = JchOptimizeHelper::getArray($sExComParam);
                $aExComp     = array();

                if (!empty($aComponents))
                {
                        $aExComp = array_map(function($sValue)
                        {
                                return $sValue . '/';
                        }, $aComponents);
                }

                return $aExComp;
        }

        /**
         * Fetches Class property containing array of matches of urls to be removed from HTML
         * 
         * @return array
         */
        public function getReplacedFiles()
        {
                return $this->aLinks;
        }

        /**
         * Set the Searcharea property
         * 
         * @param type $sSearchArea
         */
        public function setSearchArea($sSearchArea, $sSection)
        {
                $this->{'s' . ucfirst($sSection) . 'Html'} = $sSearchArea;
        }

        /**
         * Determines if document is of html5 doctype
         * 
         * @return boolean
         */
        public function isHtml5()
        {
                return (bool) preg_match('#^<!DOCTYPE html>#i', trim($this->sHtml));
        }

        /**
         * 
         * @return string
         */
        protected static function ifRegex()
        {
                return '<!--(?>-?[^-]*+)*?-->';
        }

        /**
         * 
         * @param type $aAttrs
         * @param type $aExts
         * @param type $bFileOptional
         */
        protected static function urlRegex($aAttrs, $aExts)
        {
                $sAttrs = implode('|', $aAttrs);
                $sExts  = implode('|', $aExts);

                $sUrlRegex = <<<URLREGEX
                (?>  [^\s>]*+\s  )+?  (?>$sAttrs)=["']?
                ( (?<!["']) [^\s>]*+  | (?<!') [^"]*+ | [^']*+ )
                                                                        
URLREGEX;

                return $sUrlRegex;
        }

        /**
         * 
         * @param type $sCriteria
         * @return string
         */
        protected static function criteriaRegex($sCriteria)
        {
                $sCriteriaRegex = '(?= (?> [^\s>]*+[\s] ' . $sCriteria . ' )*+  [^\s>]*+> )';

                return $sCriteriaRegex;
        }

        /**
         * 
         */
        public function getJsRegex()
        {
                $aRegex = array();

                $aRegex[0] = '(?:<script';

                $sCriteria = '(?(?=  type=  )  type=["\']?(?:text|application)/javascript  )';

                $aRegex[1] = self::criteriaRegex($sCriteria);
                $aRegex[2] = '(?:' . self::urlRegex(array('src'), array('js', 'php')) . ')?';
                $aRegex[3] = "[^>]*+>(  (?> <? [^<]*+)*?  )</script>)";

                return $aRegex;
        }

        /**
         * 
         * @return string
         */
        public function getCssRegex()
        {
                $aRegex = array();

                $aRegex[0] = '(?:<link';

                $sCriteria = '(?! (?:  itemprop | disabled | type=  (?!  ["\']?text/css  )  | rel=  (?!  ["\']?stylesheet  )  ) ) ';

                $aRegex[1] = self::criteriaRegex($sCriteria);
                $aRegex[2] = self::urlRegex(array('href'), array('css', 'php'));
                $aRegex[3] = '[^>]*+>)';
                $aRegex[4] = "|(?:<style(?:(?!(?:type=(?![\"']?text/css))|(?:scoped))[^>])*>((?><?[^<]+)*?)</[a-z0-9]++>)";

                return $aRegex;
        }

        /**
         * Get the search area to be used..head section or body
         * 
         * @param type $sHead   
         * @return type
         */
        public function getBodyHtml()
        {
                if ($this->sBodyHtml == '')
                {
                        if (preg_match($this->getBodyRegex(), $this->sHtml, $aBodyMatches) === FALSE || empty($aBodyMatches))
                        {
                                throw new Exception('Error occurred while trying to match for search area.'
                                . ' Check your template for open and closing body tags');
                        }

                        $this->sBodyHtml = $aBodyMatches[0];
                }

                return $this->sBodyHtml;
        }

        /**
         * Returns processed html to be sent to the browser
         * 
         * @return string
         */
        public function getHtml()
        {
                $sHtml = parent::getHtml();

                if ($this->sBodyHtml != '')
                {
                        $sHtml = preg_replace($this->getBodyRegex(), JchOptimizeHelper::cleanReplacement($this->sBodyHtml), $sHtml, 1);

                        if (is_null($sHtml) || $sHtml == '')
                        {
                                throw new Exception('Error occured while trying to get HTML');
                        }
                }

                return $sHtml;
        }

        ##<procode2>##

        /**
         * 
         * @return boolean
         */
        public function excludeDeclaration($sType)
        {
                return ($sType == 'css' && !$this->params->get('pro_inlineStyle', '1'))
                        || ($sType == 'js' && !$this->params->get('pro_inlineScripts', '0'));
        }

        ##</procode2>##
        ##<procode>##
        /**
         * Determines if file contents can be fetched using http protocol if required
         * 
         * @param string $sPath    Url of file
         * @return boolean        
         */

        public function isHttpAdapterAvailable($sUrl)
        {
                if ($this->params->get('pro_phpAndExternal', '1'))
                {
                        if (preg_match('#^(?:http|//)#i', $sUrl) && !JchOptimizeUrl::isInternal($sUrl)
                                || $this->isPHPFile($sUrl))
                        {
                                return $this->oFileRetriever->isHttpAdapterAvailable();
                        }
                        else
                        {
                                return true;
                        }
                }
                else
                {
                        return parent::isHttpAdapterAvailable($sUrl);
                }
        }

        /**
         * 
         */
        public function runCookieLessDomain()
        {
                if ($this->params->get('pro_cookielessdomain_enable', '0'))
                {
                        JCH_DEBUG ? JchPlatformProfiler::start('RunCookieLessDomain') : null;

                        $static_files_array = $this->params->get('pro_staticfiles',
                                                                 array('css', 'js', 'jpe?g', 'gif', 'png', 'ico', 'bmp', 'pdf', 'tiff?', 'docx?'));
                        $static_files       = implode('|', $static_files_array);

                        $uri  = clone JchPlatformUri::getInstance();
                        $port = $uri->toString(array('port'));

                        if (empty($port))
                        {
                                $port = ':80';
                        }

                        $host = preg_quote($uri->getHost()) . '(?:' . $port . ')?';
                        $path = $uri->getPath();

                        $aPath = (preg_split('#/#', $path));
                        array_pop($aPath);
                        $dir   = trim(implode('/', $aPath), '/');
                        $dir   = str_replace('/administrator', '', $dir);

                        $match = '(?!data:image|[\'"])'
                                . '(?=((?:(?:https?:)?//' . $host . ')?)((?!http|//).))'
                                . '(?:(?<![=\'(])(?:\g{1}|\g{2})((?>\.?[^.">?]*+)*?\.(?>' . $static_files . ')[^">]*+)'
                                . '|(?<![\'="])(?:\g{1}|\g{2})((?>\.?[^.)>?]*+)*?\.(?>' . $static_files . ')[^)>]*+)'
                                . '|(?<![="(])(?:\g{1}|\g{2})((?>\.?[^.\'>?]*+)*?\.(?>' . $static_files . ')[^\'>]*+)'
                                . '|(?<![\'"(])(?:\g{1}|\g{2})((?>\.?[^.\s*>?]*+)*?\.(?>' . $static_files . ')[^\s>]*+))';

                        $a = '(?:<(?:link|script|ima?ge?|a))?(?>=?[^=<>]*+)*?(?<= href| src| data-src| xlink:href)=["\']?';
                        $b = '(?:<style[^>]*+>|(?=(?>(?:<(?!style))?[^<]*+)?</style))(?>\(?[^(<>]*+)*?(?<= url)\(["\']?';
                        $c = '(?>=?[^=>]++)*?(?<= style)=[^(>]++(?<=url)\(["\']?';

                        $sRegex = "#(?><?[^<]*+)*?(?:(?:$a|$b|$c)\K$match|\K$)#iS";

                        $obj = $this;

                        $sProcessedHeadHtml = preg_replace_callback($sRegex,
                                                                    function($m) use ($dir, $obj)
                        {
                                return $obj->cdnCB($m, $dir);
                        }, $this->getHeadHtml());
                        $sProcessedBodyHtml = preg_replace_callback($sRegex,
                                                                    function($m) use ($dir, $obj)
                        {
                                return $obj->cdnCB($m, $dir);
                        }, $this->getBodyHtml());

                        if (is_null($sProcessedHeadHtml) || is_null($sProcessedBodyHtml))
                        {
                                JchOptimizeLogger::log('Cookie-less domain function failed', $this->params);

                                return;
                        }

                        if (preg_match($this->getHeadRegex(), $sProcessedHeadHtml, $aHeadMatches) === FALSE || empty($aHeadMatches))
                        {
                                JchOptimizeLogger::log('Failed retrieving head in cookie-less domain function', $this->params);

                                return;
                        }

                        if (preg_match($this->getBodyRegex(), $sProcessedBodyHtml, $aBodyMatches) === FALSE || empty($aBodyMatches))
                        {
                                JchOptimizeLogger::log('Failed retrieving body in cookie-less domain function', $this->params);

                                return;
                        }

                        $this->sHeadHtml = $aHeadMatches[0];
                        $this->sBodyHtml = $aBodyMatches[0];

                        JCH_DEBUG ? JchPlatformProfiler::stop('RunCookieLessDomain', TRUE) : null;
                }
        }

        /**
         * 
         * @param type $m
         * @param type $cdn
         * @param type $dir
         * @return type
         */
        public function cdnCB($m, $dir)
        {
                $sPath = (isset($m[2]) && $m[2] != '/' ? '/' . $dir . '/' : '') .
                        (isset($m[3]) ? $m[3] : '') .
                        (isset($m[4]) ? $m[4] : '') .
                        (isset($m[5]) ? $m[5] : '') .
                        (isset($m[6]) ? $m[6] : '');

                return JchOptimizeHelper::cookieLessDomain($this->params, $sPath);
        }

        /**
         * 
         * @return type
         */
        public function lazyLoadImages()
        {
                if ($this->params->get('pro_lazyload', '0'))
                {
                        JCH_DEBUG ? JchPlatformProfiler::start('LazyLoadImages') : null;

                        $css = '        <noscript>
                        <style type="text/css">
                                img[data-jchll=true]{
                                        display: none;
                                }                               
                        </style>                                
                </noscript>
        </head>';

                        $this->sHeadHtml = preg_replace('#</head>#i', $css, $this->getHeadHtml(), 1);

                        $sLazyLoadBodyHtml = preg_replace(
                                $this->getLazyLoadRegex(),
                                '$1src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="$3" '
                                . 'data-jchll="true"$4<noscript>$1$2$4</noscript>'
                                , $this->getBodyHtml());

                        if (is_null($sLazyLoadBodyHtml))
                        {
                                JchOptimizeLogger::log('Lazy load images function failed', $this->params);

                                return;
                        }

                        if (preg_match($this->getBodyRegex(), $sLazyLoadBodyHtml, $aBodyMatches) === FALSE || empty($aBodyMatches))
                        {
                                JchOptimizeLogger::log('Failed retrieving body in lazy load images function', $this->params);

                                return;
                        }

                        $this->sBodyHtml = $aBodyMatches[0];

                        JCH_DEBUG ? JchPlatformProfiler::stop('LazyLoadImages', TRUE) : null;
                }
        }

        /**
         * 
         * @return string
         */
        public function getLazyLoadRegex($admin = FALSE)
        {
                $s      = '<script\b[^>]*+>(?><?[^<]*+)*?</script>';
                $n      = '<noscript\b[^>]*+>(?><?[^<]*+)*?</noscript>';
                $t      = '<textarea\b[^>]*+>(?><?[^<]*+)*?</textarea>';
                $sRegex = "#(?><?[^<]*+(?:$s|$n|$t)?)*?"
                        . '\K(?:(<img(?!(?>\s*+[^\s>]*+)*?\s*+(?>data-(?:src|original)';

                $aExcludeClass = JchOptimizeHelper::getArray($this->params->get('pro_excludeLazyLoadClass', array()));

                if (!empty($aExcludeClass))
                {

                        $aExcludeClass = array_map(function($sValue)
                        {
                                return '\b' . preg_quote($sValue) . '\b';
                        }, $aExcludeClass);
                        $sExcludeClass = implode('|', $aExcludeClass);

                        $sRegex .= '|class\s*+=\s*+[\'"]?[^\'">]*?(?>' . $sExcludeClass . ')';
                }

                $sRegex .= '))';

                if ($admin)
                {
                        $sRegex .= '(?:(?=(?>\s*+[^\s>]*+)*?\s*+class\s*+=\s*+[\'"]?([^\'">]*+)))?';
                }

                $sRegex .= '(?>\s*+[^\s>]*+)*?\s*+)(src\s*+=\s*+(?![\'"]?[^\'"> ]*?(?:data:image';

                $aExcludesFiles   = JchOptimizeHelper::getArray($this->params->get('pro_excludeLazyLoad', array()));
                $aExcludesFolders = JchOptimizeHelper::getArray($this->params->get('pro_excludeLazyLoadFolders', array()));

                $aExcludes = array_merge($aExcludesFiles, $aExcludesFolders);

                if (!empty($aExcludes))
                {
                        $aExcludes = array_map(function($sValue)
                        {
                                return preg_quote($sValue);
                        }, $aExcludes);
                        $sExcludes = implode('|', $aExcludes);
                        $sRegex .= '|' . $sExcludes;
                }

                $sRegex .= '))[\'"]?((?(?<=[\'"])[^\'"]*+|[^\s>]*+))[\'"]?)([^>]*+>)|\K$)#i';

                return $sRegex;
        }

        ##</procode>##
}
