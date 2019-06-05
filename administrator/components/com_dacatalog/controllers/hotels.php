<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

/**
 * @package		Joomla
 * @subpackage	Config
 */

class dacatalogControllerHotels extends JControllerLegacy
{
	private $table = '#__dacatalog_hotels';

	function __construct($config = array())
	{
		parent::__construct($config);

		if (strpos($this->input->get("task"), "_exit") !== false) {
			$this->registerTask( $this->input->get("task"), str_replace('_exit', '', $this->input->get("task")) );
		} elseif (strpos($this->input->get("task"), "_new") !== false) {
			$this->registerTask( $this->input->get("task"), str_replace('_new', '', $this->input->get("task")) );
		}

		$this->registerTask( 'unpublish', 'publish' );
	}

	function save()
	{
		JSession::checkToken() or jexit( 'Invalid Token' );

		$app = JFactory::getApplication();
		$db =& JFactory::getDBO();
		$post = $this->input->getArray();
		$post["date"] = $post["date"] ? $post["date"] : time();

		// Считываем поля таблицы
		$fieldsArray = array_keys($db->getTableColumns($this->table));

		// Удаляем поля которые не надо сохранять
		$fieldsNotSave = array('hits');
		foreach ($fieldsNotSave AS $field) {
			unset($fieldsArray[$field]);
		}

		// Операции с алиасом, если он есть
		if(array_search('alias', $fieldsArray) !== false) {
			$post['alias'] = str_replace('.', '', $post['alias']);
			// Делаем транслитерацию алиаса
			if(!$post['alias']) {
				$post['alias'] = JFilterOutput::stringURLSafe($post['name']);
			}

			// Проверяем чтобы алиасы не совпадали
			$query = "SELECT alias FROM $this->table WHERE alias = '".$post['alias']."' AND id != '".$post['id']."'";
			$db->setQuery($query);
			$alias = $db->loadResult();

			// Если алиасы совпадают то ошибка!!!!
			if($alias) {
				JError::raiseWarning( 'error', 'Не уникальный алиас!' );
				JRequest::setVar('saved', $post);
				parent::display();
				return false;
			}
		}

		// Проверка обязательных полей
		$form = JForm::getInstance('com_dacatalog.'.$this->input->get('view'), $this->input->get('view'));
		if(!$form->validate($post)) {
			foreach($form->getErrors() AS $error) {
				if (($error) instanceof Exception) {
					$app->enqueueMessage($error->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($error, 'warning');
				}
			}

			JRequest::setVar('saved', $post);
			parent::display();
			return false;
		}

		// Находим id и определяем другие не стандартные переменные
		if(!empty($post['id'])) {
			$id = $post['id'];
		} else {
			if(array_search('ordering', $fieldsArray) !== false) {
				$query = "SELECT MAX(ordering) FROM $this->table";
				$db->setQuery($query);
				$post['ordering'] = $db->loadResult() + 1;
			}
		}

		// Операции с изображением
		jimport('joomla.filesystem.file');
		$images = JRequest::getVar('images_add', null, 'files', 'array');
		foreach ($images['name'] AS $i => $image) {
			$image = array(
				'name' => $images['name'][$i],
				'tmp_name' => $images['tmp_name'][$i],
				'type' => $images['type'][$i],
				'size' => $images['size'][$i],
				'error' => $images['error'][$i]
			);
			if(!$image['tmp_name']) continue;

			$imagesModel = $this->getModel('images');
			$post['images'][] = $imagesModel->setImage($image, $post["images_path"], explode(" ", $post["images_sizes"]));
		}
		$post['images'] = json_encode($post['images']);

		// Выстраиваем запрос
		foreach ($post AS $field => $value) {
			if($field == 'id') continue;
			if(array_search($field, $fieldsArray) === false) continue;

			// Если массив
			if(is_array($value)) {
				$post[$field] = json_encode($post[$field]);
			}

			switch ($field)
			{
				default :
					// Если редактирование
					if(!empty($post['id'])) {
						$fieldsQuery[] = $db->quoteName($field)." = ".$db->quote($post[$field]);
						// Если новый элемент
					} else {
						$fieldsQuery[] = $db->quoteName($field);
						$fieldsQueryValue[] = $db->quote($post[$field]);
					}
					break;
			}
		}

		// Если редактирование
		if(!empty($post['id'])) {
			$fieldsQuery = implode(", ", $fieldsQuery);

			$query = "UPDATE $this->table SET ".$fieldsQuery." WHERE id = ".$db->quote($id);
			$db->setQuery( $query );
			$db->execute();

			$msg_array['msg'] = JText::_('edited');
			// Если новый элемент
		} else {
			$fieldsQuery = implode(", ", $fieldsQuery);
			$fieldsQueryValue = implode(", ", $fieldsQueryValue);

			$query = "INSERT INTO $this->table (".$fieldsQuery.") VALUES (".$fieldsQueryValue.")";
			$db->setQuery( $query );
			$db->execute();

			$id = $db->insertid();

			$msg_array['msg'] = JText::_('added');
		}

		// Находим куда вернуться
		$return = (!$post['id']) ? $_SERVER['HTTP_REFERER'].'&id='.$id : $_SERVER['HTTP_REFERER'];
		$return = (mb_strstr($this->getTask(), '_exit') !== false) ? "index.php?option=".$this->input->get("option")."&view=".$this->input->get("view") : $return;
		$return = (mb_strstr($this->getTask(), '_new') !== false) ? "index.php?option=".$this->input->get("option")."&view=".$this->input->get("view")."&layout=add" : $return;

		// Редиректим
		$this->setRedirect( $return, $msg_array['msg'], $msg_array['error'] );
	}

	function ajaxSave()
	{
		$db =& JFactory::getDBO();
		$post = $this->input->post->getArray();

		foreach($post AS $field => $values) {
			foreach($values AS $id => $value) {
				$query = "UPDATE ".$this->table." SET $field = ".$db->q($value)." WHERE id = ".$db->q($id);
				$db->setQuery( $query );
				$db->execute();
			}
		}

		die('ok');
	}

	function save2copy()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit( 'Invalid Token' );

		$db =& JFactory::getDBO();
		$id = $this->input->get("id");
		if($id) {
			$isOne = true;
			$cid = array($id);
		} else {
			$cid = $this->input->get("cid", array(), "array");
		}

		foreach ($cid AS $id) {
			$query = "SELECT * FROM ".$this->table." WHERE id = $id";
			$db->setQuery( $query );
			$object = $db->loadObject();

			$object->published = 0;
			unset($object->id);

			$db->insertObject($this->table, $object);
			$id = $db->insertid();
		}

		// Находим куда вернуться
		if($isOne) {
			$return = "index.php?option=".$this->input->get("option")."&view=".$this->input->get("view")."&layout=add&id=".$id;
		} else {
			$return = @$_SERVER['HTTP_REFERER'];
		}

		$this->setRedirect( $return );
	}

	function delete()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit( 'Invalid Token' );

		$db =& JFactory::getDBO();
		$cid = $this->input->get("cid", array(), "array");

		foreach ($cid AS $id) {
			$query = "DELETE FROM ".$this->table." WHERE id = $id";
			$db->setQuery( $query );
			$db->execute();
		}

		$this->setRedirect( @$_SERVER['HTTP_REFERER'] );
	}

	function publish()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit( 'Invalid Token' );

		$db =& JFactory::getDBO();
		$cid = $this->input->get("cid", array(), "array");
		$viewName = $this->input->get("view");
		$publish  = $this->getTask() == 'publish' ? 1 : 0;

		foreach ($cid as $id) {
			$query = "UPDATE ".$this->table." SET published = '".$publish."' WHERE id = '".$id."'";
			$db->setQuery( $query );
			$db->execute();
		}

		$this->setRedirect( @$_SERVER['HTTP_REFERER'] );
	}
}