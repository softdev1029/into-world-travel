<?php

header('content-type: application/json; charset=utf-8');
//Сюда поступает запрос и на постбронирование и на бронирование
//После постбронирования нужно перебросить на оплату 
$status = 0;
$error = '';
$fleds = array();
$meinr = 0;
$data = JRequest::getVar('data');
$e = JRequest::getVar('e');
$return = JRequest::getVar('return');
$r = JRequest::getInt('r');
$order_id = JRequest::getInt('order_id');
$order_ids = $order_id;
// print_r( $data['mann']);
$link = '';
if (!travel::email($data['email'])) {
    $fleds[] = 'data_email';
}

$data['mann']['first'][0] = trim($data['mann']['first'][0]);
$data['mann']['last'][0] = trim($data['mann']['last'][0]);


foreach ($data['mann']['first'] as $n => $first) {
    if (!$first)
        $fleds[] = 'data_first' . $n;
}
foreach ($data['mann']['last'] as $n => $first) {
    if (!$first)
        $fleds[] = 'data_last' . $n;
}
if (isset($data['kind'])) {
    foreach ($data['kind']['first'] as $n => $first) {
        if (!$first)
            $fleds[] = 'kind_first' . $n;
    }
    foreach ($data['kind']['last'] as $n => $first) {
        if (!$first)
            $fleds[] = 'kind_last' . $n;
    }
}



if ($data['rooms'] == 2) {
    if (isset($data['kind_two'])) {
        foreach ($data['kind_two']['first'] as $n => $first) {
            if (!$first)
                $fleds[] = 'kind_first_two' . $n;
        }
        foreach ($data['kind_two']['last'] as $n => $first) {
            if (!$first)
                $fleds[] = 'kind_last_two' . $n;
        }
    }



    foreach ($data['mann_two']['first'] as $n => $first) {
        if (!$first)
            $fleds[] = 'data_first_two' . $n;
    }
    foreach ($data['mann_two']['last'] as $n => $first) {
        if (!$first)
            $fleds[] = 'data_last_two' . $n;
    }
}

$data['phone'] = trim($data['phone']);
if (!$data['phone'])
    $fleds[] = 'data_phone';

$html = '';
if (count($fleds) == 0) {
    $data_book = array();
    $data_book['rooms'] = $data['rooms'];
    $data_book['roomid'] = $data['roomid'];
    $data_book['first'] = $data['mann']['first'][0];
    $data_book['last'] = $data['mann']['last'][0];
    $data_book['title'] = $data['mann']['title'][0];
    $data_book['email'] = $data['email'];
    $data_book['phone'] = $data['phone'];
    $data_book['created'] = date('Y-m-d', time());
    $data_book['komm'] = trim(JRequest::getVar('user_comment'));

    $data_book['otel'] = $data['otel'];
    $data_book['region'] = $data['region'];

    $data_start = travel::strtotimed($e['data_start']);
    $data_end = travel::strtotimed($e['data_end']);


    $data_book['data_start'] = date('Y-m-d', $data_start);
    $data_book['data_end'] = date('Y-m-d', $data_end);

    $data_book['mann'] = $e['mann'];
    $data_book['kind'] = $e['kind'];
    $data_book['age1'] = $e['age1'];
    $data_book['age2'] = $e['age2'];
    $data_book['age3'] = $e['age3'];
    $data_book['age4'] = $e['age4'];


    $data_book['mann_two'] = $e['mann_two'];
    $data_book['kind_two'] = $e['kind_two'];
    $data_book['age1_two'] = $e['age1_two'];
    $data_book['age2_two'] = $e['age2_two'];
    $data_book['age3_two'] = $e['age3_two'];
    $data_book['age4_two'] = $e['age4_two'];

    $d = array();
    $d['mann'] = $data['mann'];
    if (!isset($data['kind']))
        $data['kind'] = array();
    $d['kind'] = $data['kind'];

    $d['mann_two'] = $data['mann_two'];
    if (!isset($data['kind_two']))
        $data['kind_two'] = array();
    $d['kind_two'] = $data['kind_two'];

    $data_book['data'] = serialize($d);
    $user = JFactory::getUser();
    $data_book['users'] = $user->id;
    $data_book['status'] = 'prepare';


    //$r = 0; //Потом убрать
    $goemail = 0;
    if ($order_id) {
        $data_book['id'] = $order_id;
        $data_book['status'] = ( $r == 0 ? 'prepare' : 'confirm' );
        $goemail = 1;
    } else {
        $data_book['kol'] = 1; //первый препаре
    }
    //Создаем или обновляем заказ
    $order = travel::store($data_book, 'order');
    $order_id = $order->id;


    $db = JFactory::getDBO();
    $q = 'SELECT * FROM #__travel_order WHERE id=' . (int) $order->id;
    $db->setQuery($q);
    $order = $db->LoadObject();

    //Все отдаем на потврждение
    // if ($order->kol==2)
    //$meinr = 1;
    //Отправка на емаил
    if ($goemail) {

        $link3 = JURI::root();

        $params = JComponentHelper::getParams('com_travel');
        $email_admin = $params->get('email');


        $html = "<html><body>
 <font face='Arial, sans-serif' size='5' color='77BB00' style='font-size:20px'>Booking on site" . $link . "</font>
 <hr color='77BB00'>
   Request number QuoteId: <strong>" . $order->roomid . "</strong><br />
Booking number: <strong>" . $order->bronid . "</strong><br />
 
Surname: <strong>" . $order->first . " [" . $order->title . "]</strong><br />
Name: <strong>" . $order->last . "</strong><br />
Phone: <strong>" . $order->phone . "</strong><br />
E-mail: <strong>" . $order->email . "</strong><br />
 
 
     <br>
 <a href='" . $link3 . "administrator/index.php?option=com_travel&task=order.edit&id=" . $order_id . "'>View in admin panel</a>
 <br/><br/>";

        $html_user = "<html><body>
 <font face='Arial, sans-serif' size='5' color='77BB00' style='font-size:20px'>Booking on site" . $link . "</font>
 <hr color='77BB00'>
   Request number QuoteId: <strong>" . $order->roomid . "</strong><br />
Booking number: <strong>" . $order->bronid . "</strong><br />
 
Surname: <strong>" . $order->first . " [" . $order->title . "]</strong><br />
Name: <strong>" . $order->last . "</strong><br />
Phone: <strong>" . $order->phone . "</strong><br />
E-mail: <strong>" . $order->email . "</strong><br />
 
 
     
   
 <br/><br/>";

        $email_admin = explode(',', $email_admin);
        $a = array();
        foreach ($email_admin as $k => $v) {
            $v = trim($v);
            if (!$v)
                continue;
            $a[] = $v;
        }

        travel::send_($a, "Booking on site " . $link3, $html);
        travel::send_($order->email, "Booking on site " . $link3, $html_user);
    }


    //Делаем запрос на проверку
    //Вот тут идет и постперпаре и бронирование
    //если r=1 то бронирования
    $xml = xml::Booking_xml($order, ( $r == 0 ? 'prepare' : 'confirm'));
    $rowe = xml::go_xml($xml);

    //Сохранили первый препаре
    if ($r == 0) {
        $data_book = array();
        $data_book['id'] = $order_id;
        $data_book['xml'] = $rowe;
        travel::store($data_book, 'order');
    }





    //Делаем второой препаре
    if ($r == 0)
        $rowe = xml::go_xml($xml);

    //Сохранили второй препаре
    if ($r == 0) {
        $data_book = array();
        $data_book['id'] = $order_id;
        $data_book['xml1'] = $rowe;
        travel::store($data_book, 'order');
    }

    $xml_test = simplexml_load_string($rowe);
    $code = 0;



    $Description = '';
    if (isset($xml_test->Code)) {
        $code = trim($xml_test->Code);
        $Description = trim($xml_test->Description);
    } else {


        //print_r($Booking_xml->Booking->HotelBooking);
        //Проверка confees

        $HotelBooking = $xml_test->Booking->HotelBooking;
        $count = count($HotelBooking);


        //unset($xml_test->Booking->HotelBooking->Room->CanxFees);


        if
        (
                ($count == 2 &&
                (
                !isset($xml_test->Booking->HotelBooking[0]->Room->CanxFees->Fee->Amount) ||
                !isset($xml_test->Booking->HotelBooking[1]->Room->CanxFees->Fee->Amount)) ) || (!isset($xml_test->Booking->HotelBooking->Room->CanxFees->Fee->Amount))
        ) {
            $Description = 'Error CanxFees';
            $code = '-1';
            $status = 0;
            $q = 'UPDATE #__travel_order SET `status`="error" WHERE id=' . $order->id;
            $db->setQuery($q);
            $db->Query();
        }

        //$Booking_xml->Booking->HotelBooking->Room->CanxFees->Fee->Amount['amt'];
        //->CanxFees->Fee->Amount['amt']
    }



    $status = 1;
    if ($code) {
        $error = 'Code: ' . $code . ' ' . $Description;
        $status = 0;
        $q = 'DELETE FROM #__travel_order WHERE id=' . $order->id;
        // $db->setQuery($q);
        // $db->Query();


        $db = JFactory::getDBO();
        $q = 'UPDATE #__travel_order SET `status`="error" WHERE id=' . $order->id;
        $db->setQuery($q);
        $db->Query();
    } else { //Идем на бронирование 2 препаре и confirm
        $row = travel::getOtelVid($data['otel']);
        $region = travel::region($data['region']);



        $row->region_proc = $row->region_proc_strana = 0;
        if ($region) {
            $row->region_proc = $region->proc;
            $row->region_proc_strana = $region->proc_strana;
        }


        $Booking_xml = simplexml_load_string($rowe);
        $HotelBooking = $Booking_xml->Booking->HotelBooking;




        $count = count($HotelBooking);

        $bron_id = $Booking_xml->Booking->Id;




        $d = array();
        $d['e'] = $e;
        //Link for success page 
        $linkSuccess = rtrim(JURI::root(), '/') . travel::link('confirm', "&order_id=" . $order->id . "&" . http_build_query($d));


//Link for failure page
        $linkFailure = rtrim(JURI::root(), '/') . travel::link('fail', "&return=" . $return . "&order_id=" . $order->id . "&" . http_build_query($d));



        $linkSuccess = str_replace('&amp;', '&', $linkSuccess);
        $linkFailure = str_replace('&amp;', '&', $linkFailure);

        if ($count == 2) {
            $s = 0;
            foreach ($Booking_xml->Booking->HotelBooking as $HotelBooking)
                $s += trim($HotelBooking->TotalSellingPrice['amt']);


            $html = html::getInfoBroon($Booking_xml, $row, 0, 1, 0, $linkSuccess, $linkFailure);
            $html .= html::getInfoBroon($Booking_xml, $row, 1, 1, $s, $linkSuccess, $linkFailure);
        } else
            $html = html::getInfoBroon($Booking_xml, $row, 0, 0, 0, $linkSuccess, $linkFailure);






        $data_book = array();
        $data_book['id'] = $order->id;

        //(  ? 'prepare' : 'confirm' )
        if ($r == 1)
            $data_book['xml2'] = $rowe;


        //Second prepare request

        $data_book['status'] = ( $r == 0 ? 'prepare' : 'confirm' );
        $data_book['bronid'] = trim($bron_id);
        $data_book['summa'] = travel::pr(trim($Booking_xml->Booking->HotelBooking->TotalSellingPrice['amt']), $row, true, true);
        travel::store($data_book, 'order');
    }
}


$options = array(
    "fleds" => $fleds,
    "linkSuccess" => $linkSuccess,
    "linkFailure" => $linkFailure,
    "r" => $meinr,
    "order_id" => $order_id,
    "error" => $error,
    "html" => $html,
    "status" => $status,);
echo json_encode($options);
exit;
