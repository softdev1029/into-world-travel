<?php
/**
 * @package         Better Preview
 * @version         5.0.1PRO
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2016 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

include_once __DIR__ . '/helper.php';

class HelperBetterPreviewButtonK2Category extends HelperBetterPreviewButton
{
	function getURL($name)
	{
		$helper = new HelperBetterPreviewHelperK2Category($this->params);

		if (!$item = $helper->getK2Category())
		{
			return;
		}

		return $item->url;
	}
}
