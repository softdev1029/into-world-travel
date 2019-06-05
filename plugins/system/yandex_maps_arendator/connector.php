<?php
define('_JEXEC', 1);
define('JPATH_BASE', realpath(realpath(__DIR__).'/../../../'));
require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';
$app = JFactory::getApplication('site');
$input = $app->input;


$lang = JFactory::getLanguage();
$language = $app->getUserStateFromRequest("plgSystemMultilingual.language", 'language', 'ru-RU');
$language = JRequest::getCmd('lang', $language ?: 'ru-RU');
$lang->setLanguage($language);
$lang->load('plg_system_yandex_maps_arendator', JPATH_ADMINISTRATOR);



$plugin_params = new JRegistry();
$plugin = JPluginHelper::getPlugin('system','yandex_maps_arendator');

if ($plugin && isset($plugin->params)) {
    $plugin_params->loadString($plugin->params);
}

function normalizeURL($url, $replace = '') {
    return str_replace('/plugins/system/yandex_maps_arendator', $replace, $url);
}

$result = (object)array('error'=> 0, 'msg' => array(), 'files'=> array(), 'baseurl' => normalizeURL(JURI::root(), '/images'));

function display () {
    global $result;
    exit(json_encode($result));
}
function errorHandler ($errno, $errstr, $file, $line) {
    global $result;
    $result->error = $errno ? $errno : 1;
    $result->msg = jtext::_($errstr);
    display();
}

$user = JFactory::getUser();
set_error_handler('errorHandler', E_USER_WARNING);

JHtml::addIncludePath(JPATH_ROOT.'/components/com_yandex_maps/helpers');

ob_start();
header('Content-Type: application/json');

include_once JPATH_ROOT.'/administrator/components/com_yandex_maps/helpers/CModel.php';
JModelLegacy::addIncludePath(JPATH_ROOT.'/administrator/components/com_yandex_maps/models/');
$db = jFactory::getDBO();

$action = $input->get('action', 'list', 'STRING');

if (!in_array($action, array('affordtime')) and !$user->id) {
    trigger_error(jText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_USER_NOT_AUTORIZATE'), E_USER_WARNING);
}

switch ($action) {
    case 'remove': 
    case 'unpublic': 
    case 'public': {
        $main = normalizeURL(JURI::root());

        if (!$input->get('id', 0, 'INT')) {
            $app->redirect($main, JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_ID_NOT_FILL'), 'error');
        }

        if ($user->get('isRoot')) {
            $newobject = JModelLegacy::getInstance('Objects', 'Yandex_MapsModel')->model($input->get('id', 0, 'INT'));
            if (!$newobject->id) {
                $app->redirect($main, JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_ID_NOT_FILL'), 'error');
            }
            if ($action === 'remove') {
                $newobject->delete();
                $app->redirect($main, JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_WAS_REMOVED'));
            } else {
                $newobject->active = $action === 'public' ? 1 : 0;
                $newobject->save();
                $link = normalizeURL(JRoute::_('index.php?option=com_yandex_maps&task=object&id='.$newobject->slug, true, -1));
                $app->redirect($link);
            }
        } else {
            $joomlaLoginUrl = 'index.php?option=com_users&view=login';
            $finalUrl = JRoute::_($joomlaLoginUrl . '&return='.urlencode(base64_encode(jURI::current())));
            $app->redirect(normalizeURL(JRoute::_($finalUrl, true, -1)), JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_YOU_NOT_HAVE_ACCESS'), 'error');
        }
        
        $app->redirect();
        break;
    }
    case 'save': {
        if (!$input->get('title', '', 'STRING')) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_NOT_FILL_TITLE', E_USER_WARNING);
        }
        if (!$input->get('description', '', 'RAW')) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_NOT_FILL_TITLE', E_USER_WARNING);
        }
        if (!$input->get('price', '', 'STRING')) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_NOT_FILL_PRICE', E_USER_WARNING);
        }
        $images = $input->get('images', null, 'ARRAY');
        if (!$images or !is_array($images) or !count($images)) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_NOT_SELECT_IMAGES', E_USER_WARNING);
        }

        $time_variant = (int)$plugin_params->get('time_variant', 1) === 2 ? (int)$input->get('time_variant', 1, 'INT') : (int)$plugin_params->get('time_variant', 1);

        if ($time_variant !== 0 and $time_variant !== 1) {
            $time_variant = 0;
        }

        if ($time_variant === 1) {
            $periods = $input->get('periods', null, 'ARRAY');
            if (!$periods or !is_array($periods)) {
                trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_NOT_SELECT_PERIOD', E_USER_WARNING);
            }
        } else {
            $times = $input->get('times', null, 'ARRAY');
            if (!$times or !is_array($times)) {
                trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_NOT_SELECT_DATE_TIME', E_USER_WARNING);
            }
            $ok = false;
            foreach ($times as $time) {
                if (count($time)) {
                    $ok = true;
                    break;
                };
            }
            if (!$ok) {
                trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_NOT_SELECT_DATE_TIME', E_USER_WARNING);
            }
        }

        $location = json_decode($input->get('location', '', 'RAW'));


        if (!$location || !$location->lat || !$location->lan || !$location->zoom) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_NOT_FILL_LOCATION', E_USER_WARNING);
        }
        
        if (!$input->get('id', 0, 'INT')) {
            $newobject = JModelLegacy::getInstance('Objects', 'Yandex_MapsModel');
        } else {
            $newobject = JModelLegacy::getInstance('Objects', 'Yandex_MapsModel')->model($input->get('id', 0, 'INT'), (!jFactory::getUser()->get('isRoot') ? 'and create_by='.$user->id : ''));
            if (!$newobject->id) {
                trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_NOT_FOUND', E_USER_WARNING);
            }
        }

        $map_id = 1;

        $newobject->_attributes = array(
            'title' => $input->get('title', '', 'STRING'),
            'description' => $input->get('description', '', 'RAW'),
            'lat'=> $location->lat,
            'lan'=> $location->lan,
            'zoom'=> $location->zoom,
            'map_id'=> $map_id,
            'create_by'=> jFactory::getUser()->get('isRoot') ? ($input->get('user_id', '', 'INT') ?: $user->id) : $user->id,
        );
        
        if (!$plugin_params->get('moderation', 2) || jFactory::getUser()->get('isRoot')) {
            $newobject->active = 1;
        } else {
            $newobject->active = $plugin_params->get('moderation', 2) === 2 ? 1 : 0; // премодерация, постмодерация
        }
        
        $newobject->params = array(
            'time_variant' => $time_variant,
            'images' => $images,
            'price' => $input->get('price', '', 'STRING'),
            'placecount' => $input->get('placecount', '', 'INT'),
            'type' => $input->get('type', '', 'STRING'),
            'tags' => $input->get('tags', array(), 'ARRAY'),
        );
        
        if ($input->get('categories', false, 'ARRAY') and count($input->get('categories', false, 'ARRAY'))) {
            $newobject->setCategoryIds($input->get('categories', false, 'ARRAY'));
        } else {
            if (!$newobject->id) {
                $newobject->setCategoryIds(JModelLegacy::getInstance('Categories', 'Yandex_MapsModel')->findNearest(array($newobject->lat, $newobject->lan, $map_id))->id);
            }
        }

        $newobject->coordinates = json_encode(array($location->lat, $location->lan));
        $newobject->options = '{"strokeColor":"0066ffff","strokeWidth":1,"fillColor":"0066ff99","preset":"islands#blueStretchyIcon","iconColor":"'.($input->get('type', '', 'STRING')?:'blue').'","visible":true}';
        $newobject->properties = '{"metaType":"Point"}';

        $newobject->type = 'placemark';


        if (!$newobject->save()) {
            trigger_error(implode("\n", $newobject->error), E_USER_WARNING);
        }

        if ($plugin_params->get('moderation', 2)) {
            $link = normalizeURL(JRoute::_('index.php?option=com_yandex_maps&task=object&id='.$newobject->slug, true, -1));
            jhtml::_('xdwork.sendMail',
                jtext::sprintf('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_USER_ADDED_OBJECT', $user->username),
                jtext::sprintf('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_USER_ADDED_OBJECT_MESSAGE', 
                    $user->username, 
                    $link, 
                    $newobject->title, 
                    JURI::root().'connector.php?action='.($plugin_params->get('moderation', 2) === 1 ? 'public' : 'unpublic').'&id='.$newobject->id, 
                    $plugin_params->get('moderation', 2) === 1 ? 'Опубликовать' : 'Снять с публикации',
                    JURI::root().'connector.php?action=remove&id='.$newobject->id
                ),
                true,
                'skoder@ya.ru'
            );
        }
        if ($time_variant == 1) {
            $db->setQuery('delete from #__yandex_maps_periods_object where object_id='.$newobject->id)->execute();
            $times = array();
            foreach ($periods as $period) {
                list($day, $time) = explode('-', $period);
                if (empty($times[$time])) {
                    $times[$time] = array();
                }
                $times[$time][] = $day;
            }
            foreach ($times as $time=>$days) {
                $period = (object)array(
                    'object_id' => $newobject->id,
                    'period_start' => (int)$time,
                    'period_end' => (int)$time + 1,
                );
                $dayswhere = array();
                for ($i = 1; $i <= 7; $i += 1) {
                    $dayswhere[$i] = 'isnull(`day' . $i . '`)'; 
                }
                foreach ($days as $day) {
                    $period->{'day'.$day} = 1;
                    $dayswhere[$day] = '(`day'.$day.'`=1)';
                }
                $update = false;
                $q = 'select id, period_start, period_end from  #__yandex_maps_periods_object where '.(implode(' and ', $dayswhere)).' and object_id='.$newobject->id;
                $hasperiods = $db->setQuery($q)->loadObjectList();
                foreach ($hasperiods as $hasperiod) {
                    if ($hasperiod->period_start == $period->period_end) {
                        $hasperiod->period_start = $period->period_start;
                        $db->updateObject('#__yandex_maps_periods_object', $hasperiod, 'id');
                        $update = true;
                        break;
                    }
                    if ($hasperiod->period_end == $period->period_start) {
                        $hasperiod->period_end = $period->period_end;
                        $db->updateObject('#__yandex_maps_periods_object', $hasperiod, 'id');
                        $update = true;
                        break;
                    }
                }
                if (!$update) {                    
                    $db->insertObject('#__yandex_maps_periods_object', $period);
                }
            }
        } else {
            $db->setQuery('delete from #__yandex_maps_datetimes where object_id='.$newobject->id)->execute();
            foreach ($times as $date=>$times) {
                foreach ($times as $time) {
                    $datetime = (object)array(
                        'object_id' => $newobject->id,
                        'date_value' => date('Y-m-d', strtotime($date)),
                        'time_value' => $time['time'],
                        'price' => $time['price'] ?: $input->get('price', '', 'STRING'),
                    );

                    $db->insertObject('#__yandex_maps_datetimes', $datetime);
                }
            }
        }

        if ($input->get('tags', array(), 'ARRAY')) {
            $type_id = $db->setQuery('select type_id from `#__content_types` where type_alias="com_yandex_maps.object"')->loadResult() ?: 100000;
            $content_item_id = $db->setQuery('select max(content_item_id) from `#__contentitem_tag_map`')->loadResult();
            $db->setQuery('delete from #__contentitem_tag_map where type_id='.$type_id.' and core_content_id='.$newobject->id)->execute();
            $tags = $input->get('tags', array(), 'ARRAY');
            foreach ($tags as $tagid) {
                $tagmap = (object)array(
                    'type_alias'=>'com_yandex_maps.object',
                    'core_content_id'=>$newobject->id,
                    'content_item_id'=> ++$content_item_id,
                    'tag_id'=>$tagid,
                    'type_id'=>$type_id
                );
                $db->insertObject('#__contentitem_tag_map', $tagmap);
            }
        }

        $result->msg = jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_WAS_ADDED');
        break;
    }
    case 'edit': {
        if (!$input->get('id', 0, 'INT')) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_ID_NOT_FILL', E_USER_WARNING);
        }
        $db->setQuery('select count(id) as cnt from #__yandex_maps_objects where id='.$input->get('id', 0, 'INT').(!jFactory::getUser()->get('isRoot') ? ' and create_by = '.(int)$user->id : ''));
        if (!$db->loadResult()) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_ID_NOT_FILL', E_USER_WARNING);
        }
        $result->data =  $db->setQuery('select * from #__yandex_maps_objects where id='.$input->get('id', 0, 'INT').(!jFactory::getUser()->get('isRoot') ? ' and create_by = '.(int)$user->id : ''))->loadObject();
        $result->data->params = json_decode($result->data->params ?: '{"images":[], "price": 0}');
        
        $result->data->times = array();
        $datetimes = $db->setQuery('select * from #__yandex_maps_datetimes where object_id='.$input->get('id', 0, 'INT'))->loadObjectList();
        foreach ($datetimes as $datetime) {
            $d = date('d.m.Y', strtotime($datetime->date_value));
            if (!$result->data->times[$d]) {
                $result->data->times[$d] = array();
            }
            $result->data->times[$d][] = array('time' => date('H:i', strtotime($datetime->time_value)), 'price' => $datetime->price ?: $result->data->params->price);
        }
        
        $result->data->periods = $db->setQuery('select * from #__yandex_maps_periods_object where object_id='.$input->get('id', 0, 'INT'))->loadObjectList();
        
        $newobject = JModelLegacy::getInstance('Objects', 'Yandex_MapsModel')->model($input->get('id', 0, 'INT'));
        $result->data->categories = $newobject->getCategoryIds();
        
        $type_id = $db->setQuery('select type_id from `#__content_types` where type_alias="com_yandex_maps.object"')->loadResult() ?: 100000;
        $result->data->tags = $db->setQuery('select tag_id from #__contentitem_tag_map where type_id='.$type_id.' and core_content_id='.$newobject->id)->loadColumn();
        
        break;
    }
    case 'affordtime': {
        $periods = $app->input->get('periods', null, 'ARRAY');
        if (!$periods or !is_array($periods) or !$periods[0] or !preg_match('#^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4}$#', $periods[0])) {
            unset($periods[0]);
            unset($periods[1]);
        }
        if (isset($periods[1]) and (!preg_match('#^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4}$#', $periods[1]) or $periods[1] == $periods[0])) {
            unset($periods[1]);
        }
        
        $query = $db->getQuery(true);


        $query->select('TIME_FORMAT(time_value, "%H:%i") as time_value');
        $query->from($db->quoteName('#__yandex_maps_datetimes'));
        if ($periods[0]) {
            list($d, $m, $y) = explode('.',$periods[0]);
            $periods[0] = "$y-$m-$d";
            if ($periods[1]) {
                list($d, $m, $y) = explode('.',$periods[1]);
                $periods[1] = "$y-$m-$d";
                $query->where($db->quoteName('date_value') . ' >= '. $db->quote($periods[0]));
                $query->where($db->quoteName('date_value') . ' <= '. $db->quote($periods[1]));
            } else {
                 $query->where($db->quoteName('date_value') . ' = '. $db->quote($periods[0]));
            }
        }
        $query->group('time_value');
        $query->order('time_value ASC');
        $db->setQuery($query);
        $result->data = $db->loadColumn();
        
        $query = $db->getQuery(true);
        $query->select('concat(concat(period_start,":00"),"-",concat(period_end,":00")) as time_value');
        $query->from($db->quoteName('#__yandex_maps_periods_object'));
        if ($periods[0]) {
            $start_period = strtotime($periods[0]);
            if ($periods[1]) {
                $end_period = strtotime($periods[1]);
            } else {
                $end_period = $start_period;
            }
            $days = array();
            // ничего умнее не придумал. напишите на skoder@ya.ru если придумаете как вычислить все дни недели входящие в промежуток по другому
            for ($i = $start_period; $i <= $end_period; $i += 3600) {
                $days['day'.(date('N', $i))] = true;
            }
            foreach ($days as $key=>$f) {
                $query->where('!isnull(' . $db->quoteName($key) . ')', 'or');
            }
        }


        $query->group('time_value');
        $query->order('time_value ASC');
        $db->setQuery($query);

        $result->data = array_unique(array_merge($result->data, $db->loadColumn()));
        break;
    }
    case 'deletebook': {
        if (!$input->get('date', 0, 'STRING') || !$input->get('time', 0, 'STRING')) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_DATETIME_NOT_FILL', E_USER_WARNING);
        }

        $db->setQuery($q = 'select
            id
            from
                #__yandex_maps_datetimes
            where
                object_id= "'.$input->get('object_id', 0, 'INT').'" and 
                book_user="'.((int)$user->id).'" and 
                status="1" and 
                date_value="'.$input->get('date', 0, 'STRING').'" and 
                time_value="'.$input->get('time', 0, 'STRING').'"'
        );

        $id = $db->loadResult();
        if (!$id) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_DATETIME_NOT_FILL_OR_WAS_ADDED_NOT_YOU', E_USER_WARNING);
        }

        if (!$db->setQuery('delete from #__yandex_maps_datetimes where id='.(int)$id)->execute()) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_BOOK_ERROR', E_USER_WARNING);
        }


        $result->msg = jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_BOOK_DELETE_SUCCESS');
        
        jhtml::_('xdwork.sendMail', jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_USER_REMOVE_BOOK_SUBJECT', $user->username), jtext::sprintf('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_USER_REMOVE_BOOK_BODY', $user->username), true, array(
            JFactory::getUser($object->create_by)->email,
            JFactory::getUser()->email,
        ));
        
        break;
    }
    case 'book': {
        $object = JModelLegacy::getInstance('Objects', 'Yandex_MapsModel')->model($input->get('object_id', 0, 'INT'));
        if (!$object->id) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_ID_NOT_FILL', E_USER_WARNING);
        }
        
        if (!$input->get('email', '', 'STRING')) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_NOT_FILL_EMAIL', E_USER_WARNING);
        }
        
        if (!$input->get('phone', '', 'STRING')) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_NOT_FILL_PHONE', E_USER_WARNING);
        }
        
        $book = (object)array(
            'object_id'=>$input->get('object_id', 0, 'INT'),
            'date_value'=>date('Y-m-d', strtotime($input->get('date', 0, 'STRING'))),
            'time_value'=>$input->get('time', 0, 'STRING'),
            'status'=>1,
            'price'=> $object->params->price,
            'book_user'=>$user->id,
            'params' => json_encode(array(
                'email' => $input->get('email', '', 'STRING'),
                'phone' => $input->get('phone', '', 'STRING'),
                'comment' => $input->get('comment', '', 'HTML')
            ))
        );
        
        $db->insertObject('#__yandex_maps_datetimes', $book);
        $input->set('id', $db->insertid());
        
        if (!$input->get('id', 0, 'INT')) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_DATETIME_NOT_FILL', E_USER_WARNING);
        }

        $result->msg = jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_BOOK_SUCCESS');

        jhtml::_('xdwork.sendMail', sprintf(jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_BOOK_ON_SITE'), normalizeURL(JURI::root())), $s = sprintf(jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_BOOK_EMAIL_BODY'), 
            $book->date_value, 
            $book->time_value, 
            normalizeURL(JRoute::_('index.php?option=com_yandex_maps&task=object&id='.$object->slug, true, -1)),
            $object->title,
            $book->price ?: $object->params->price,
            $input->get('email', '', 'STRING'),
            $input->get('phone', '', 'STRING'),
            $input->get('comment', '', 'HTML')
        ), true, array(
            JFactory::getUser($object->create_by)->email,
            JFactory::getUser()->email,
        ));
        break;
    }
    case 'delete': {
        if (!$input->get('id', 0, 'INT')) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_NOT_FILL_OBJECT_ID', E_USER_WARNING);
        }
        $db->setQuery('select count(id) as cnt from #__yandex_maps_objects where id='.$input->get('id', 0, 'INT').(!jFactory::getUser()->get('isRoot') ? ' and create_by = '.(int)$user->id: ''));
        if (!$db->loadResult()) {
            trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_NOT_FOUND', E_USER_WARNING);
        }

        $object = JModelLegacy::getInstance('Objects', 'Yandex_MapsModel')->model($input->get('id', 0, 'INT'), (!jFactory::getUser()->get('isRoot') ? 'and create_by='.$user->id : ''));
        $db->setQuery('delete from #__yandex_maps_datetimes where object_id='.$object->id)->execute();
        if (!$object->realDelete()) {
             trigger_error('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_NOT_DELETED', E_USER_WARNING);
        }
        break;
    }
    default:
        $user_id = (int)$user->id;
        if (jFactory::getUser()->get('isRoot') and $input->get('user_id', 0, 'INT')) {
            $user_id = $input->get('user_id', 0, 'INT');
        }
        $db->setQuery('select 
            a.id,
            a.title,
            CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug 
            from #__yandex_maps_objects as a where a.create_by = '.$user_id);
        $result->data = $db->loadObjectList();
        foreach ($result->data as &$item) {
            $item->link = normalizeURL(JRoute::_('index.php?option=com_yandex_maps&task=object&id='.$item->slug));
        }

    break;
}

display();