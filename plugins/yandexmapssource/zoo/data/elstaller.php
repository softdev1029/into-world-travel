<?php
defined('JPATH_BASE') or die;
jimport('joomla.form.helper');
class JFormFieldElstaller extends JFormField{
	function getVersion($file) {
		return preg_match('#<version>([0-9]+.[0-9]+.[0-9]+)</version>#simu', file_get_contents($file), $result) ? $result[1] : '1.0.0';
	}
	function getInput() {
		// инсталлируем/обновляем  Элемент Яндекс карт
		if (!is_dir(JPATH_ROOT.'/media/zoo/elements/yandex_maps') or $this->getVersion(JPATH_ROOT.'/media/zoo/elements/yandex_maps/yandex_maps.xml') != $this->getVersion(dirname(__FILE__).'/yandex_maps/yandex_maps.xml')) {
			jimport('joomla.filesystem.folder' );
			JFolder::copy(dirname(__FILE__).'/yandex_maps', JPATH_ROOT.'/media/zoo/elements/yandex_maps', '', true);
		}

		return is_dir(JPATH_ROOT.'/media/zoo/elements/yandex_maps') ? '<span class="text-success">Яндекс Элемент Инсталлирован</span>' : '<span class="text-error">При установке Яндекс элемента произошли проблемы. Проверьте папку <code>media/zoo/elements/</code> на запись</span>';
	}
}