<?php
//define('URL','http://www.roomsxmldemo.com/RXLStagingServices/ASMX/XmlService.asmx');
define('URL','http://api.stuba.com/RXLServices/ASMX/XmlService.asmx');
class xml{
   
   
   
  static public function getBData($quate_id = 0, $adult = 0){

    $curl = curl_init();

    $adultData = "";
    for($i=0;$i<$adult;$i++){
        $adultData .= "<Adult title=\"Mr\" first=\"Into\" last=\"World\"></Adult>\r\n";
    }

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://api.stuba.com/RXLServices/ASMX/XmlService.asmx",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "<BookingCreate xmlns=\"http://www.reservwire.com/namespace/WebServices/Xml\">\r\n       
      <Authority xmlns=\"http://www.reservwire.com/namespace/WebServices/Xml\">\r\n    
      <Org>intrltd</Org>\r\n    
      <User>XML</User>\r\n   
      <Password>intrltd54</Password>\r\n    
      <Currency>GBP</Currency>\r\n    
      <Language>en</Language>\r\n    
      <TestDebug>true</TestDebug>\r\n    
      <Version>1.28</Version>\r\n  
      </Authority>\r\n  
      <QuoteId>".$quate_id."</QuoteId>\r\n  
      <HotelStayDetails>\r\n     
      <Room>\r\n      
      <Guests>\r\n ". $adultData ." </Guests>\r\n    
      </Room>\r\n  </HotelStayDetails>\r\n  <HotelSearchCriteria>\r\n    <AvailabilityStatus>allocation</AvailabilityStatus>\r\n    <DetailLevel>basic</DetailLevel>\r\n  </HotelSearchCriteria>\r\n  <CommitLevel>prepare</CommitLevel>\r\n</BookingCreate>",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: text/xml",
        "postman-token: 41877355-fae5-0f0b-2990-bcffd9af7049"
      ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        return array();
      } else {
        $xml_snippet = simplexml_load_string( $response );
        $json_convert = json_encode( $xml_snippet );
        return json_decode($json_convert);
      }
  }

  static public function BookingCancel ($order) { 
    $xml='<BookingCancel xmlns="http://www.reservwire.com/namespace/WebServices/Xml">
    '.(xml::autority_xml()).'
    <BookingId>'.$order->bronid.'</BookingId>
    <CommitLevel>confirm</CommitLevel>
    </BookingCancel>';
    $subject ='BookingCancel';  
    return $xml;
  }
   
  static public function Booking_xml($order,$pr  = 'prepare'){   
      
    $data = unserialize($order->data);
    $mann = '';
    if ($order->mann>1)
    {
      for ($i=1; $i<$order->mann; $i++)
      {
        $mann .='<Adult title="'.$data['mann']['title'][$i].'" first="'.$data['mann']['first'][$i].'" last="'.$data['mann']['last'][$i].'">
        </Adult>'; 
      }
    }
    $kind = '';

    if ($order->kind>0)
    { 
      for ($i=0; $i<$order->kind; $i++)
      {
        if  ($data['kind']['title'][$i] && $data['kind']['first'][$i] && $data['kind']['last'][$i])
        {
          $kind .='<Child age="'.$order->{'age'.($i+1)}.'"  '.($data['kind']['title'][$i] ? 'title="'.$data['kind']['title'][$i].'"' : '').'  '.($data['kind']['first'][$i] ? 'first="'.$data['kind']['first'][$i].'"' : '').' '.($data['kind']['last'][$i] ? 'last="'.$data['kind']['last'][$i].'"' : '').'/>'; 
        }
        else
        {
          $kind .='<Child/>'; 
        }
      }
    }


    $mann2 = '';
    if ($order->mann_two>0)
    {
      for ($i=0; $i<$order->mann_two; $i++)
      {
        $mann2 .='<Adult title="'.$data['mann_two']['title'][$i].'" first="'.$data['mann_two']['first'][$i].'" last="'.$data['mann_two']['last'][$i].'">
        </Adult>'; 
      }
    }
    $kind2 = '';

    if ($order->kind_two>0)
    { 
      for ($i=0; $i<$order->kind_two; $i++)
      {
        if  ($data['kind_two']['title'][$i] && $data['kind_two']['first'][$i] && $data['kind_two']['last'][$i])
        {
          $kind2 .='<Child age="'.$order->{'age'.($i+1).'_two'}.'"  '.($data['kind_two']['title'][$i] ? 'title="'.$data['kind_two']['title'][$i].'"' : '').'  '.($data['kind_two']['first'][$i] ? 'first="'.$data['kind_two']['first'][$i].'"' : '').' '.($data['kind_two']['last'][$i] ? 'last="'.$data['kind_two']['last'][$i].'"' : '').'/>'; 
        }
        else
        {         
          $kind2 .='<Child/>';  
        }
      }
    }

    $rom = ' <Room>
        <Guests>
          <Adult title="'.$order->title.'" first="'.$order->first.'" last="'.$order->last.'">
          </Adult>
          '.$mann.'
          '.$kind.'
        </Guests>
      </Room>'; 

      $rom1 = ' <Room>
          <Guests>
        '.$mann2.'
        '.$kind2.'
        </Guests>
      </Room>';

    $xml='<BookingCreate xmlns="http://www.reservwire.com/namespace/WebServices/Xml">
    '.(xml::autority_xml()).'

    <QuoteId>'.$order->roomid.'</QuoteId>
    <HotelStayDetails>

    '.($order->rooms==1 ?  $rom : $rom.$rom1).'

    </HotelStayDetails>
    <HotelSearchCriteria>
    <AvailabilityStatus>allocation</AvailabilityStatus>
    <DetailLevel>basic</DetailLevel>
    </HotelSearchCriteria>
    <CommitLevel>'.$pr.'</CommitLevel>
    </BookingCreate>';
     return $xml;
  }
    
   
   
  static public function send_to_xml ($data, $cache_is = 1)
  { 
    //$cache_is = 0;
    $xml = xml::xml_AvailabilitySearch($data); 

    $md5 =md5( $xml ).".xml";
    $dir_cache = JPATH_SITE."/cache_com_travel/";
    if (!is_dir($dir_cache))
      mkdir($dir_cache);

    if (is_file($dir_cache.$md5) && $cache_is)
    {
      $row = file_get_contents($dir_cache.$md5);
    }
    else
    { 
      $row = xml::go_xml($xml);
      if ($cache_is) 
        file_put_contents($dir_cache.$md5, $row);
    }

    return $row;
  }
   
  static public function go_xml($xml)
  {
	  
	
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,            URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($ch, CURLOPT_POST,           1 );
    curl_setopt($ch, CURLOPT_TIMEOUT,        30);
    curl_setopt($ch, CURLOPT_POSTFIELDS,    $xml ); 
    curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml', 'Accept-Encoding: gzip,deflate')); 

    $result=curl_exec ($ch);
	
    $result =  gzdecode ($result);
	 

    //echo $xml;
    //echo '*************';

     $xml_test = simplexml_load_string($result);
	 return $result;
  }
    
  static public function xml_Hotel($data){
     $s_id = ''; 
    if ($data['region'])
      $s_id = '<RegionId>'.$data['region'].'</RegionId>';
    else
      $s_id = '<HotelId>'.$data['otel'].'</HotelId>';
    $xml='  <HotelSearch xmlns="http://www.reservwire.com/namespace/WebServices/Xml">

    '.(xml::autority_xml()).'
      '.$s_id.'

      <HotelSearchCriteria>
         <DetailLevel>basic</DetailLevel>
        <AvailabilityStatus>any</AvailabilityStatus>
      </HotelSearchCriteria>

     </HotelSearch>';
    return $xml; 
  }
     
   
  static public function xml_AvailabilitySearch($data){   
   
    $start = travel::strtotimed($data['data_start']);
    $end = travel::strtotimed($data['data_end']);
  
    $day = xml::time_text($start, $end); 

    $HotelSearchCriteria = array();
 
    $HotelSearchCriteria[]='<AvailabilityStatus>any</AvailabilityStatus>';
   
    $s_id = '';
   
    if ($data['otel'])
      $s_id .= '<HotelId>'.$data['otel'].'</HotelId>';
    elseif ($data['region'])
      $s_id .= '<RegionId>'.$data['region'].'</RegionId>';    
  
    if ($data['title2'] && !$data['otel'])
    {
      $HotelSearchCriteria[]='<HotelName>'.$data['title2'].'</HotelName>';
    }
   
    if (isset($data['range_is']))
      if ($data['range_is'])
        if (isset($data['price_min'] ))
        {
          $HotelSearchCriteria[]='<MinPrice>'.$data['price_min'].'</MinPrice>';
          $HotelSearchCriteria[]='<MaxPrice>'.$data['price_max'].'</MaxPrice>';
        }
   
        if (isset($data['type'] ))
        {
          if ($data['type']!='any')
            $HotelSearchCriteria[]='<HotelType>'.$data['type'].'</HotelType>';
        }
 
        if (isset($data['star'] ))
        { 
          if ($data['star']!='any')
            $HotelSearchCriteria[]='<MinStars>'.$data['star'].'</MinStars>';
          $HotelSearchCriteria[]='<Stars>'.$data['star'].'</Stars>'; 
          $HotelSearchCriteria[]='<Rank>'.$data['star'].'</Rank>';  
        }
   
        if (isset($data['amenity'] ))
        {         
          foreach ($data['amenity'] as $amenity)
            $HotelSearchCriteria[]='<HasAmenity>'.$amenity.'</HasAmenity>';
        }
   
        $fleds='';        
        if (isset($data['DetailLevel']))
          $DetailLevel = $data['DetailLevel'];
        else
          $DetailLevel ='basic';  
       
        if (isset($data['fleds'])){
          $fleds = $data['fleds']; 
          $DetailLevel ='custom';
        }
  
        $guest = '';
        for ($i=0; $i<$data['mann']; $i++)
        {
          $guest .= "<Adult />";
        }

        for ($i=0; $i<$data['kind']; $i++)
        {
          $guest .= "<Child  age=\"".$data['age'.($i+1)]."\"/>";
        }

        $guest1 = '';
        for ($i=0; $i<$data['mann_two']; $i++)
        {
          $guest1 .= "<Adult />";
        }

        for ($i=0; $i<$data['kind_two']; $i++)
        {
          $guest1 .= "<Child  age=\"".$data['age'.($i+1).'_two']."\"/>";
        }
     
 
        $rom='<Room>
             <Guests>
             '.$guest.'
             </Guests>
          </Room>';
           $rom1=' <Room>
             <Guests>
             '.$guest1.'
             </Guests>
          </Room>';
    
          $xml = '<AvailabilitySearch xmlns="http://www.reservwire.com/namespace/WebServices/Xml">
            '.(xml::autority_xml()).'
            '.$s_id.'
            <HotelStayDetails>
              <ArrivalDate>'.date('Y-m-d',$start).'</ArrivalDate>
              <Nights>'.$day.'</Nights>
              <Nationality>'.$data['nac'].'</Nationality>
               
                 '.($data['rooms']==1 ? $rom : $rom.$rom1) .'
                  
            </HotelStayDetails>  
            <HotelSearchCriteria>'."\n".implode("\n",$HotelSearchCriteria)."\n".'</HotelSearchCriteria>  
            <DetailLevel>'.$DetailLevel.'</DetailLevel>
              '.($fleds ? '<CustomDetailLevel>'.$fleds.'</CustomDetailLevel>' : '').'  
          </AvailabilitySearch>';
     return $xml;
    }
   
   // <HotelSearchCriteria>
//          <HotelName>string</HotelName>
//          <HotelType>string</HotelType>
//          <MinStars>int</MinStars>
//          <Supplier>string</Supplier>
//          <MinPrice>decimal</MinPrice>
//          <MaxPrice>decimal</MaxPrice>
//          <HasAmenity>string</HasAmenity>
//          <HasAmenity>string</HasAmenity>
//          <AvailabilityStatus>any or request or allocation</AvailabilityStatus>
//        </HotelSearchCriteria>
   
  static public function autority_xml()
  {
    $params = JComponentHelper::getParams( 'com_travel' );

    $org = $params->get('orgforb2c','SampleRequest');
    $user = $params->get('userforb2c','SampleRequest');
    $pass = $params->get('passwordforb2c','demo123');

    $loggeduser = JFactory::getUser();        // Get the user object
    $app  = JFactory::getApplication(); // Get the application

    if ($loggeduser->id != 0)
    {
      // you are logged in
      $org = $params->get('org','SampleRequest');
      $user = $params->get('user','SampleRequest');
      $pass = $params->get('password','demo123');
    }

    $xml = '<Authority xmlns="http://www.reservwire.com/namespace/WebServices/Xml">
    <Org>'. $org .'</Org>
    <User>'. $user .'</User>
    <Password>'. $pass .'</Password>
    <Currency>'.$params->get('currency','USD').'</Currency>
    <Language>'.$params->get('language','en').'</Language>
    <TestDebug>'.$params->get('testdebug','false').'</TestDebug>
    <Version>'.$params->get('version','1.26').'</Version> 
    </Authority>';
    return $xml;
  }

  static public function time_text($cur_time, $kogda_polucheno)
  {
    //$stf = 0;

    $diff = $kogda_polucheno-$cur_time ;
    // $years = floor($diff / (365*60*60*24));
    // $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    //$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    $days = floor($diff / (60 * 60 * 24));

    return $days;
  }

 //Вернуть массив фото
  static public function fotos($Availability){
    
    $hotel_xml = $Availability->Hotel;

    $all_foto = array();
    $n = 0;
    if (isset($hotel_xml->Photo))
    {
      foreach ($hotel_xml->Photo as $photo)
      {
        $all_foto[$n] = array();
        foreach ($photo as $k=>$v)
        {
          $all_foto[$n][trim($k)]=trim($v);
        }
        $n++;
      }
    }
    return $all_foto;   
  }

//Вернуть комнаты 
  static public function rooms($Availabilities) {
    
    $rooms = [];
    $price = [];
    $n = 0;
  
    foreach ($Availabilities as $i => $Availability) {

      if (isset($Availability->Result))
        foreach ($Availability->Result as $result)
        {
          //Child
          //Атрибуты комнаты 
          $attr = array();
          foreach($result->attributes() as $a => $b)
            $attr[trim($a)]=trim($b);

          //$n = $attr['id'];
          $rooms[$n]['attr'] = $attr;
          $rooms[$n]['room_type'] = array();
          foreach($result->Room->RoomType->attributes() as $a => $b)
            $rooms[$n]['room_type'][trim($a)]=trim($b);

          $rooms[$n]['room_mealtype'] = array();
          if (isset($result->Room->MealType))
            foreach($result->Room->MealType->attributes() as $a => $b)
              $rooms[$n]['room_mealtype'][trim($a)]=trim($b);

          $rooms[$n]['Guests']= array();
          if (isset($result->Room->Guests->Adult))
            foreach ($result->Room->Guests->Adult as $m=>$adult){
              foreach($adult->attributes() as $a => $b)
                $rooms[$n]['Guests'][$m]['attr'][trim($a)]=trim($b);
              $rooms[$n]['Guests'][$m]['price'] = trim($adult->Price['amt']);
          }

          if (isset($result->Room->Guests->Child))
            foreach ($result->Room->Guests->Child as $m=>$adult){
              foreach($adult->attributes() as $a => $b)
                $rooms[$n]['Guests'][$m]['attr'][trim($a)]=trim($b);
              $rooms[$n]['Guests'][$m]['price'] = trim($adult->Price['amt']);
            }

          if(isset($result->Room->CancellationPolicyStatus))
          {
            $rooms[$n]['cancellationPolicyStatus'] = trim($result->Room->CancellationPolicyStatus);
            //$rooms[$n]['Guests'][$m]['price'] = trim($adult->Price['amt']);
          }       
       
          if(isset($result->Room->message))
          {
            $rooms[$n]['message'] = trim($result->Room->message); 
            //$rooms[$n]['Guests'][$m]['price'] = trim($adult->Price['amt']);
          }

          $rooms[$n]['price'] = array();
          foreach($result->Room->Price->attributes() as $a => $b)
            $rooms[$n]['price']=trim($b);

          //Все цены  
          $price[] = ($rooms[$n]['price']);  
          $n++;
        }
    }    

    $volume  = array_column($rooms, 'price');
    array_multisort($volume, SORT_ASC, $rooms);
    sort($price); 
  
    /*  echo "<pre>";
     print_r($rooms);
     exit(); */
    return array('rooms'=>$rooms,'price'=>$price);
  
  }
}