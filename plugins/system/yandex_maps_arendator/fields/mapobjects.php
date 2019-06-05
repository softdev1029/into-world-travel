<?php
defined('JPATH_PLATFORM') or die;

class JFormFieldMapObjects extends JFormField {
	protected $type = 'MapObjects';

	protected function getLabel() {
		return JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_FIELD_MAPOBJECTS_LABEL');
	}

    function getInput() {
        ob_start();
        $params = new JRegistry();
        $plugin = JPluginHelper::getPlugin('system','yandex_maps_arendator');
        $input = jfactory::getApplication()->input;
        if ($input->get('option') === 'com_users' and $input->get('view') === 'user' and $input->get('layout') === 'edit'  and jfactory::getApplication()->isAdmin() and jFactory::getUser()->get('isRoot')) {
            $user_id = $input->get('id', jFactory::getUser()->id, 'INT');
        } else {
            $user_id = jFactory::getUser()->id;
        }
        if ($plugin && isset($plugin->params)) {
            $params->loadString($plugin->params);
        }
        include dirname(__FILE__) . DIRECTORY_SEPARATOR .'tmpl' . DIRECTORY_SEPARATOR . 'mapobjects.php';
		return ob_get_clean();
	}
}
