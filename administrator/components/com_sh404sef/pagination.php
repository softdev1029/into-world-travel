<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.14.0.3812
 * @date		2018-05-16
 */

defined('JPATH_PLATFORM') or die;

$fileName = JPATH_ADMINISTRATOR . '/components/com_sh404sef/pagination_' . Sh404sefHelperGeneral::getJoomlaVersionPrefix() . '.php';

if(JFile::exists($fileName))
{
	include_once $fileName;
}
