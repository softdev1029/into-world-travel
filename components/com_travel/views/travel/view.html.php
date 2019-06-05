<?php

/**
 * Поиск отелей
 * 
  все вопросы по компоненту http://webalan.ru
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class travelViewtravel extends JViewLegacy {

    protected $state = null;
    protected $item = null;
    protected $items = null;
    protected $pagination = null;

    function display($tpl = null) {
        // Initialise variables.
        $user = JFactory::getUser();
        $app = JFactory::getApplication();
        $state = $this->get('State');
        $model = $this->getModel();
        $this->Itemid = JRequest::getVar('Itemid');
        //$id = $state->get('filter.id');
        $path = $app->getPathWay();
        $params = $app->getParams();

        $db = JFactory::getDBO();
        $task = JRequest::getVar('task');
        $list = array();

        $id = JRequest::getInt('id');


        $obj = travel::getOtel($id);
        $data = JRequest::getVar('e', array());
        // echo  JRequest::getInt('room_view');
        //echo '<pre>';
        //print_r(JRequest::getVar('room_view'));

        if (isset($data['nac'])) {
            if (!$data['nac'])
                $data['nac'] = 'GB';
        } else
            $data['nac'] = 'GB';

        if (count($data) == 0) {
            $app->redirect('index.php');
            return;
        }

        $region = $data['region'];
        $this->region = travel::region($region);

        $this->start = travel::strtotimed($data['data_start']);
        $this->end = travel::strtotimed($data['data_end']);


        $d = array();
        $d['e'] = $data;

        $link = travel::link('travel', "&" . http_build_query($d));
        $this->mapslink = travel::link('maps', "&tmpl=components&" . http_build_query($d));


        //$path->addItem('Hotels '.$this->region->country_title);
        $path->addItem('Hotels ' . $this->region->title, $link);

        $this->month_start = travel::month_name(date('m', $this->start));
        $this->month_end = travel::month_name(date('m', $this->end));
        //$data['DetailLevel'] = 'full';
        //Оставляем этот запрос постоянно и на страницу списка и на страницу подробно
        $row = xml::send_to_xml($data, 0);
        $this->data = $data; //Параметрый запроса
        //Поиск отелей
        // echo '<pre>';
        // print_r(simplexml_load_string($row));
        // exit;
        $xml_test = simplexml_load_string($row);
        $this->xml_test = $xml_test;

        if (JRequest::getVar('room_view') == 'display') {



            $Availability2 = $xml_test->HotelAvailability;
            $hotel2 = $Availability2->Hotel;

            $region2 = $hotel2->Region;

            $data2 = array();
            $data2['vid'] = trim($hotel2['id']);
            $data2['title'] = trim($hotel2['name']);
            $data2['region_name'] = trim($region2['name']);
            $data2['region_id'] = trim($hotel2['id']);
            $data2['cityId'] = trim($hotel2->Region->CityId);
            $data2['stars'] = trim($hotel2['stars']);
            $data2['type'] = trim($hotel2['type']);
            $data2['latitude'] = trim($hotel2->GeneralInfo->Latitude);
            $data2['longitude'] = trim($hotel2->GeneralInfo->Longitude);
            $data2['rank'] = trim($hotel2['rank']);


            $data2['address'] = array();
            foreach ($hotel2->Address as $a => $b) {
                foreach ($b as $aa => $bb)
                    $data2['address'][trim($aa)] = trim($bb);
            }



            //print_R(trim($xml_test->Address->Address1));
            $data2['description'] = array();
            foreach ($hotel2->Description as $desc) {
                $data2['description'][trim($desc->Type)] = trim($desc->Text);
            }



            $data2['amenity'] = array();
            foreach ($hotel2->Amenity as $r) {

                $data2['amenity'][trim($r->Code)] = trim($r->Text);
            }

            $data2['amenity'] = array();
            foreach ($hotel2->Amenity as $r) {

                $data2['amenity'][trim($r->Code)] = trim($r->Text);
            }

            $data2['rating'] = array();
            foreach ($hotel2->Rating as $a => $b) {
                foreach ($b as $aa => $bb)
                    $data2['rating'][trim($aa)] = trim($bb);
            }
            $n = 0;
            $data2['photo'] = array();
            foreach ($hotel2->Photo as $a => $b) {
                foreach ($b as $aa => $bb)
                    $data2['photo'][$n][trim($aa)] = trim($bb);
                $n++;
            }

            $tpl = 'row';
            $data2['photo'] = serialize($data2['photo']);
            $data2['amenity'] = serialize($data2['amenity']);
            $data2['description'] = serialize($data2['description']);
            $data2['address'] = serialize($data2['address']);
            $data2['rating'] = serialize($data2['rating']);
            $data2['published'] = 1;
            $this->region = travel::region($obj->region_id);
            if (!$this->region)
                $this->region = travel::region($data2['cityId']);
            // $row = $data2; 
            $obj = (object) $data2;
        }
        if (!$obj) {



            $Availability2 = $xml_test->HotelAvailability;

            $hotel2 = $Availability2->Hotel;
            // echo '<pre>';
            // print_r($xml_test);  
            // exit; 

            $page_title = $metadesc = $metakey = $page_heading = null;

            $active = $app->getMenu()->getActive();
            if ($active) {
                if ($active->params->get('page_title'))
                    $page_title = $active->params->get('page_title');
                $metadesc = $active->params->get('menu-meta_description');
                $metakey = $active->params->get('menu-meta_keywords');
                $page_heading = $active->params->get('page_heading');
            }
            if (!$page_title)
                $page_title = 'Hotel search';

            $this->document->setTitle($page_title);
            if ($metadesc)
                $this->document->setDescription($metadesc);
            if ($metakey)
                $this->document->setMetadata('keywords', $metakey);
        }
        else {


            $d = array();
            $dd = $data;
            $dd['otel'] = $obj->vid;
            $d['e'] = $dd;

            $link = travel::link('travel', "&" . http_build_query($d));
            $this->mapslink = travel::link('maps', "&tmpl=components&" . http_build_query($d));


            $link = travel::link('travel', "&id=" . $obj->id . "&" . http_build_query($d));
            $path->addItem($obj->title, $link);
            //СТраница подробно
            $tpl = 'row';
            $this->region = travel::region($obj->region_id);
            if (!$this->region)
                $this->region = travel::region($obj->cityId);

            $this->assignRef('row', $obj);


            $page_title = $obj->type . ' ' . $obj->title . ' in ' . $obj->region_name . ' ' . $this->region->title;
            $this->document->setTitle($page_title);
        }


        $this->assignRef('page_heading', $page_heading);
        $this->assignRef('page_title', $page_title);

        $this->assignRef('data', $data);
        $this->assignRef('params', $params);
        $this->assignRef('state', $state);
        $this->assignRef('user', $model->_users);

        $this->assignRef('link', $link);

        parent::display($tpl);
    }

    protected function _prepareDocument($title = null) {
        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        $this->document->setTitle($title);
    }

}
