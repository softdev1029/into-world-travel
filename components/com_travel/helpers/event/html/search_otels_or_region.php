<?php   
header('content-type: application/json; charset=utf-8');
    $cache =  JFactory::getCache( 'com_travel', 'output' );
    $q = JRequest::getVar('q');
    $maxRows = JRequest::getInt('maxRows',12);
    $region = JRequest::getInt('region');
    $type = JRequest::getVar('type');
    
     $f=array('billing','find_region_otels');
     $f[]=JRequest::getVar('q');
     $f[]=JRequest::getInt('maxRows',12);
     $f[]=JRequest::getVar('type');
    
     if (!$cache->start( join('_',$f),'com_travel' )) {
  
 
    $response  = array();
  
    $db = JFactory::getDBO();
   if ($type==='region' || !$type){
    $q1  = 'SELECT a.*  
    FROM #__travel_region  AS a 
    WHERE a.title LIKE "'.$q.'%" ORDER BY a.title  ASC LIMIT '.$maxRows;
   $db->setQuery($q1);
    $rows = $db->LoadObjectList();    
         
        if ($rows)
        {
           foreach ($rows as $row)
           {
            
         $response[] = array(
        'title' => $row->title.", ".$row->country_title,
        'value' => $row->title,
        'id' => $row->id,
        'otel' => 0,
        'region' => 1
          
          );
            
           }
        }
        
        }
         if ($type==='otel' || !$type){
            
            $ws = '';
            if ($region)
           {
            $ws = ' AND  (a.region_id='.$region.' OR a.cityId='.$region.')';
           }
            
         $q1  = 'SELECT a.*, b.title as b_title,   
         d.title as d_title
    FROM #__travel_otel  AS a 
    LEFT JOIN   #__travel_region  AS b ON a.region_id=b.id
    LEFT JOIN   #__travel_region  AS d ON a.cityId=d.id
    
    WHERE a.title LIKE "'.$q.'%" '.$ws.' ORDER BY a.title  ASC LIMIT '.$maxRows;
    
   $db->setQuery($q1);
    $rows = $db->LoadObjectList();   
        
   
      if ($rows)
        {
           foreach ($rows as $row)
           {
            
            if ($row->b_title)
            $region =$row->b_title;
            else if ($row->d_title)
            $region =$row->d_title;
            else 
            $region =$row->region_name;
            
            
         $response[] = array(
        'title' => $row->title,
        'value' => $row->title,
        'name_region' => $region,
        'id' => $row->vid,
        'otel' => 2,
        'region' => 1
          
          );
            
           }
        }
        }
        
   
    echo json_encode($response);
   
    
       $cache->end();
 }
 else
 {
     
 }
    
    exit;