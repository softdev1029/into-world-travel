<?php
	//Запрещаем прямой доступ к модулю
	defined('_JEXEC') or die('Restricted access');

	JHTML::script('modules/mod_select_country/js/script.js', false);
	JHTML::stylesheet('modules/mod_select_country/css/style.css');
	$long_name = $params->get('long_name', '');
	//$long_name = $long_name != '' ? explode(',',$long_name) :'';
	$curren = $params->get('curren', '');
	//$curren = $curren != '' ? explode(',',$curren) :'';

	require (JModuleHelper::getLayoutPath('mod_select_country',$params->get('layout', 'default')));
?>
