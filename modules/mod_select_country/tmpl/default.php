<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_breadcrumbs
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
if ($curren == '') return false;
$mid = $module->id;
$html = '';

$html .= '<div class="data-country" data-nlonge="'	. $long_name . '" data-nshort="'	. $curren . '">';
$html .= '</div>';
echo $html;
/*echo "<script>
			jQuery(document).ready(function($){
					if (!sessionStorage.getItem('argo_p_al-".$mid."')) {
						sessionStorage.setItem('argo_p_al-".$mid."', '0');
					}
					var al".$mid." = new argo_p('#al-".$mid."');
				});
			</script>";
*/			
?>

