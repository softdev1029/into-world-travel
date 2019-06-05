<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.controller');
 
  
class travelController extends JControllerLegacy
{
	 
	protected $default_view = 'travel';


 public function __construct($config = array())
	{
		parent::__construct($config);
 
		 
	}
    
    
  
	public function display($cachable = false, $urlparams = false)
	{
	   	$view		= JRequest::getCmd('view', 'travel');
		$layout 	= JRequest::getCmd('layout', 'default');
		$id			= JRequest::getInt('id');
 
           

	 		parent::display();

		return $this;
	}

  //Загрузка файла на сервер
  function upload()
  {
    
 $hash = JRequest::getVar('hash');   
 $t = JRequest::getInt('t');  
 $tip =  JRequest::getVar('tip');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");                                      
@set_time_limit(5 * 60);                                                                                                  
 
 
$params = JComponentHelper::getParams( 'com_travel' );
 
$targetDir=JPATH_SITE."/administrator/components/com_travel/uploaddir/"; 

if (!file_exists($targetDir)) {
	@mkdir($targetDir);
}
 //если отели положим в другую папку
  if ($t==1)
  {$targetDir = $targetDir."otels/";

     if (is_dir($targetDir))
     F::TranremoveDirectory($targetDir);
  
     mkdir($targetDir) ;

   } 

 // Get a file name
if (isset($_REQUEST["name"])) {
	$fileName = $_REQUEST["name"];
} elseif (!empty($_FILES)) {
	$fileName = $_FILES["file"]["name"];
} else {
	$fileName = uniqid("file_");
}

    $path_info = pathinfo( $fileName );
    $a = $path_info;
    
   $fileName =  $hash.".".$a['extension'];
   $filePath = $targetDir.$fileName;
 
// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

     $db = JFactory::getDBO();
     $q = 'SELECT * FROM #__travel_hash WHERE `hash`="'.$hash.'"';
     $db->setQuery($q);
     $rows = $db->LoadObjectList();
    
    if ($rows)
    {
        foreach ($rows as $row)
        {
       if (JFile::exists($targetDir."/".$row->file)) 
      { JFile::delete($targetDir."/".$row->file);
            
       } }
    }


// Open temp file
if (!$out = @fopen("{$filePath}", $chunks ? "ab" : "wb")) {
	die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

if (!empty($_FILES)) {
	if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
	}

	// Read binary input stream and append it to temp file
	if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
	}
} else {	
	if (!$in = @fopen("php://input", "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
	}
}

while ($buff = fread($in, 4096)) {
	fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
	// Strip the temp .part suffix off 
    
    $path_info = pathinfo( $filePath );
    $a = $path_info;
    
    $new = $a['dirname'].'/'.$hash.(rand(1000,99999)).".".$a['extension'];
   
    rename("{$filePath}",$new);
    
    
    $q = 'DELETE FROM #__travel_hash WHERE `hash`="'.$hash.'"';
    $db->setQuery($q);
    $db->Query();
    
    $q = 'INSERT INTO `#__travel_hash` (`hash`,`file`,`t`,`data`,`tip`) 
    VALUES ("'.$hash.'","'.basename($new).'",'.$t.','.time().',"'.$tip.'")';
    
    $db->setQuery($q);
    $db->Query();
    
    
   
    
  
 }

// Return Success JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
 
 
exit;
 
  }  
 
    #Импорт отелей
  function import()
  {
    $hash = JRequest::getVar('hash'); 
    $session = JFactory::getSession();
    $db=JFactory::getDBO();
    $status = 0;
    $error = '';
    
   $params =  JComponentHelper::getParams( 'com_travel' );

 
       
 set_time_limit(1800);
 ini_set('memory_liit', '128M');
 
 
 $start = JRequest::getInt('start');
 //Первый запуск
 if ($start)
 { $MaxRow = 0;
    
     $dir = JPATH_SITE."/".$params->get('path','HotelDetailXML');
     if ($objs = glob($dir."/*.xml")) {
     $MaxRow = count($objs);
      }
    else
    {
        $status = 0;
        $error ='Ошибка пути';
    }
   
   
   
    $session->set('startRow',0);
    $session->set('kol',0);
    $session->set('MaxRow',$MaxRow);
    $status = 1;
    
     $options=array(
    "error"=>$error,
    "status"=>$status,
    "max"=>$MaxRow,
    
     );
     echo json_encode($options);
     exit; 
 }
   
   
    $startRow  = $session->get('startRow',0);
    $MaxRow=  $session->get('MaxRow');
    
      $dir = JPATH_SITE."/".$params->get('path','HotelDetailXML');
      $objs = glob($dir."/*.xml");
     $kol =  $session->get('kol',0);
      $was = 100;
 for ($i=0; $i<=$was; $i++)
 {
    if (!isset($objs[$startRow])) { $end=1;  break; }
    else {   
 
      $row = $objs[$startRow];
      $end = 0;
     
 
 $xm = file_get_contents($row);
 $xml_test = simplexml_load_string($xm);
 

 
  $id = travelHelper::find__otel($xml_test->Id);
 if (!$id){
 
 $data = array();
 $data['vid'] = trim($xml_test->Id);
 $data['title'] = trim($xml_test->Name);
 $data['region_name'] = trim($xml_test->Region->Name);
 $data['region_id'] = trim($xml_test->Region->Id);
 $data['cityId'] = trim($xml_test->Region->CityId);
 
 $data['stars'] = trim($xml_test->Stars);   
 $data['type'] = trim($xml_test->Type);	
 $data['latitude'] = trim($xml_test->GeneralInfo->Latitude);   
 $data['longitude'] = trim($xml_test->GeneralInfo->Longitude);
 $data['rank'] = trim($xml_test->GeneralInfo->Rank);
 
 $data['address'] = array();
 foreach ($xml_test->Address as $a=>$b)
 { 
    foreach ($b as $aa=>$bb)
     $data['address'][trim($aa)] = trim($bb);
 }
  
 //print_R(trim($xml_test->Address->Address1));
 $data['description'] = array();
 foreach ($xml_test->Description as  $desc)
 {
  $data['description'][trim($desc->Type)] = trim($desc->Text);
 }
 

 
$data['amenity'] = array(); 
 foreach ($xml_test->Amenity  as $r)
 {
 
    $data['amenity'][trim($r->Code)] = trim($r->Text);
 }
 
 $data['amenity'] = array(); 
 foreach ($xml_test->Amenity  as $r)
 {
 
    $data['amenity'][trim($r->Code)] = trim($r->Text);
 }
 
 $data['rating'] = array(); 
  foreach ($xml_test->Rating  as $a=>$b)
 {
 foreach ($b as $aa=>$bb)
     $data['rating'][trim($aa)] = trim($bb);
     
 }
  $n=0;
 $data['photo'] = array(); 
  foreach ($xml_test->Photo  as $a=>$b)
 {
 foreach ($b as $aa=>$bb)
     $data['photo'][$n][trim($aa)] = trim($bb);
   $n++; 
 }
  
 
 $data['photo'] = serialize($data['photo']);
 $data['amenity'] = serialize($data['amenity']);
 $data['description'] = serialize($data['description']);
 $data['address'] = serialize($data['address']);
 $data['rating'] = serialize($data['rating']);
 $data['published'] =1;
 
 
 travelHelper::store($data, 'otel');
 }
 

 
     
     $startRow ++;
      $kol++;
    }
 }
  $session->set('startRow',$startRow);  
     $session->set('kol',$kol);

     
if ($startRow>$MaxRow){
$end=1;  
$startRow = $MaxRow;
 

}
     $options=array(
    "error"=>$error,
    "startRow"=>$startRow,
    "status"=>$status,
    "kol"=>$startRow,
    "end"=>$end,
     );
     echo json_encode($options);
     exit; 
        
 
    
    
     
  }  
 
 
    #Импорт Регионов
  function import2()
  {
    $hash = JRequest::getVar('hash'); 
    $session = JFactory::getSession();
    $db=JFactory::getDBO();
    $status = 0;
    $error = '';
    $targetDir=JPATH_SITE."/administrator/components/com_travel/uploaddir/";
    $q = 'SELECT file FROM #__travel_hash WHERE `hash`="'.$hash.'"';
    $db->setQuery($q);
    $row = $db->LoadObject();
    
    if (!$row) 
    $error = 'Файл не найден';
    else
    {
         $file = $row->file;
         $ext = strrchr($file, ".");
     
$type = '.xls,.xlsx';



$type = explode(',',$type);
 if (in_array($ext,$type))
 {
 $fileName = $targetDir.$file;
       
 set_time_limit(1800);
 ini_set('memory_liit', '128M');
 
  $excelReader = new Excelreader();
 $start = JRequest::getInt('start');
 //Первый запуск
 if ($start)
 {
   
   $MaxRow =  $excelReader->info($fileName);
    $session->set('startRow',1);
    $session->set('kol',0);
    $session->set('MaxRow',$MaxRow);
    $status = 1;
    
     $options=array(
    "error"=>$error,
    "status"=>$status,
    "max"=>$MaxRow,
    
     );
     echo json_encode($options);
     exit; 
 }
   
    $objReader = PHPExcel_IOFactory::createReader(PHPExcel_IOFactory::identify($fileName));

  $startRow  = $session->get('startRow',1);
 
    $chunkSize = 100;
    $chunkFilter = new chunkReadFilter();
    $n = 0;
    
   $MaxRow=  $session->get('MaxRow');
    
    
    //for ($n==0; $n<=2; $n++){
     $chunkFilter->setRows($startRow,$chunkSize);
     $objReader->setReadFilter($chunkFilter);
     $objReader->setReadDataOnly(true);
     $objPHPExcel = $objReader->load($fileName);
     $rows = $objPHPExcel->getActiveSheet()->toArray(); 
      
     $end = 0;
     
 

 
     $kol =  $session->get('kol',0);
     foreach ($rows as $row)
     {
        $kol++;
        foreach ($row as $key=>$val)
        $row[$key]=trim($val);
       
       
       
     /**
 *   Array ( 
 *        [0] => Region ID 
 *        [1] => Region Name 
 *        [2] => State 
 *        [3] => Country ID 
 *        [4] => Country Name )
 */
       
        if (!$row[0] || !$row[1]  ) continue;
        if ($row[0]==='Region ID') continue;
   $id = travelHelper::find_($row[0]);
   
   if (!$id)
   {
    $q = 'INSERT INTO #__travel_region 
    (`id`,`title`,`state`, `country`,`country_title`,`published`)  VALUES 
    ('.$row[0].',"'.$row[1].'","'.$row[2].'",'.$row[3].',"'.$row[4].'",1)';
    $db->setQuery($q);
    $db->Query();
    
   }
  
       
         
     }
  
 
     
     $startRow += $chunkSize;
     
     
     $session->set('startRow',$startRow);  
     $session->set('kol',$kol);
 

    unset($objReader); 
    unset($objPHPExcel);

     
if ($startRow>$MaxRow){
$end=1;  
$startRow = $MaxRow;
if (JFile::exists($fileName)) 
JFile::delete($fileName);

}
     $options=array(
    "error"=>$error,
    "startRow"=>$startRow,
    "status"=>$status,
    "kol"=>$startRow,
    "end"=>$end,
     );
     echo json_encode($options);
     exit; 
        
        
        
 } 
 else
 $error = 'Формат файла неверный';
    
    }//=========row
    
    
     $options=array(
    "error"=>$error,
    "status"=>$status,
     
    
     );
     echo json_encode($options);
     exit;
  }  
 
//  
  
}