<?php
// Запрещаем прямой доступ к файлу
defined('_JEXEC') or die('Restricted access');

// Регистрируем ElementRepeatable class

App::getInstance('zoo')->loader->register('ElementRepeatable', 'elements:repeatable/repeatable.php');

class ElementTriText extends ElementRepeatable implements iRepeatSubmittable {

	/* проверка введенности полей элемента */

	protected function _hasValue($params = array()) {
		$level1 = $this->get('level1', '');
		$level2 = $this->get('level2', '');
		$level3 = $this->get('level3', '');
		return !empty($level1) || !empty($level2) || !empty($level3) ;
	}
	
	/* добавление в поиск данных элемента */
	protected function _getSearchData() {
		return value;
	}
	
    /* Добавляем возможность подачи и редактирования в админке */
    protected function _edit()
	{
		if ($layout = $this->getLayout('edit.php')) {
			return $this->renderLayout($layout);
		}
		return false;
	}
		
    /* Добавлем возмождность редактировать с фронта  */
    public function _renderSubmission($params = array()) {
        return $this->_edit();
	}		
		
    /* Вывод результатов */
    public function _render($params = array())
    {
		if ($layout = $this->getLayout('tmpl.php')) {
			$params 	= $this->app->data->create($params);
			$jplugins   = $this->config->get('jplugins');
            return $this->renderLayout($layout);
        }
        return null;
    }


//Валмдация элемента
	public function _validateSubmission($value, $params)
	{
		return array(
			'level1' => $this->app->validator->create('textfilter', array('required' => $params->get('required')))->clean($value->get('level1')),
			'level2' => $this->app->validator->create('textfilter', array('required' => $params->get('required')))->clean($value->get('level2')),
			'level3' => $this->app->validator->create('textfilter', array('required' => $params->get('required')))->clean($value->get('level3')),
		);
	}

}