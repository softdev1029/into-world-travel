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

defined('_JEXEC') or die;

/**
 * This layout displays message or error, insde a bootstrap alert box
 */

if (!empty($displayData['message']))
{
	echo ShlHtmlBs_Helper::alert($displayData['message'], $type = 'success', $dismiss = false);
}
