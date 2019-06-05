<?php

/**
 * Поиск отелей
 * 
  все вопросы по компоненту http://webalan.ru
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class travelViewRoom extends JViewLegacy {

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

        if (isset($data['nac'])) {
            if (!$data['nac'])
                $data['nac'] = 'GB';
        } else
            $data['nac'] = 'GB';

        if (count($data) == 0) {
            $app->redirect('index.php');
            return;
        }


        $this->region = travel::region($obj->region_id);
        if (!$this->region)
            $this->region = travel::region($obj->cityId);




        $page_title = $obj->type . ' ' . $obj->title . ' in ' . $obj->region_name . ' ' . $this->region->title;
        $this->document->setTitle($page_title);


        $region = $data['region'];


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


        $d = array();
        $d['e'] = $data;
        $link = travel::link('travel', "&id=" . $obj->id . "&" . http_build_query($d));
        $path->addItem($obj->title, $link);
        $path->addItem('Booking');



        $page_title = $metadesc = $metakey = $page_heading = null;



        $this->data = $data; //Параметрый запроса





        $page_title = 'Booking hotel ' . $obj->title . ' in ' . $this->region->title . ' ' . date('d', $this->start) . "-" . date('d', $this->end) . ' ' . $this->month_end[1];



        $this->document->setTitle($page_title);
        if ($metadesc)
            $this->document->setDescription($metadesc);
        if ($metakey)
            $this->document->setMetadata('keywords', $metakey);





        $this->assignRef('page_heading', $page_heading);
        $this->assignRef('page_title', $page_title);
        $this->assignRef('row', $obj);
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
