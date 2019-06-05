<?php
defined( '_JEXEC' ) or die( '=;)' );
 
 //загрузка файлов
class F 
{
  static public  function  TranremoveDirectory($dir) {
    
    if (!is_dir($dir)) return;
    
if ($objs = glob($dir."/*")) {
foreach($objs as $obj) {
is_dir($obj) ?   F::TranremoveDirectory($obj) : unlink($obj);
}
}
if (is_dir($dir)) rmdir($dir);
 }



function DELF ($file)
	{					
	if (JFile::exists($file)) {JFile::delete($file);}
	}  	


function LOADEN($id,$name, $pat=null)
{
    $params  = JComponentHelper::getParams( 'com_workschedule' );
    

$type=$params->get('filetype',".doc,.txt,.zip,.rar,.jpg,.bmp");
$max_size=$params->get('maxfile',9000000);
   $err = null;
$path = JPATH_SITE."/components/com_workschedule/doc".DS;


if  (!file_exists($path.$id)) mkdir($path.$id);
$path = $path.$id.DS.$pat;

if  (!file_exists($path)) mkdir($path);



 
$filename=null;
 if ($_FILES[$name]['size'] <= $max_size)	
 {

$nam=$_FILES[$name]['name'];
$ext = strrchr($nam, ".");

$type=explode(',',$type);
 if (in_array($ext,$type))
 {

$secret=rand(1000,9000);
$filename=F::getAliasName((substr($nam,0,strlen($nam)-4)));
$filename=$secret.$filename.$ext;
$uploadfile = $path.$filename;
	
if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile))
{
$real_path = realpath($path.$filename);
   $file = $real_path;
   chmod($file, 0777);
}
    else {$err = JText::_("ERROR_UPLOAD"); } 		
 }  else {$err = JText::_("ERROR_FORMATFILE"); }
  } else {$err = JText::_("ERROR_MAXFILE"); }


$fil->filename = $filename;
$fil->err = $err;
$fil->url = JURI::root()."components/com_workschedule/doc/".$id."/".$filename;
 

  return $fil;
}


 function LOADEN_EXT($name,$pat=null, $type = '.doc')
{
    $params  = JComponentHelper::getParams( 'com_support' );
    $max_size=$params->get('maxfile',9000000);
    $err = null;
   $path = JPATH_SITE."/components/com_support/".$pat;


if  (!file_exists($path)) mkdir($path);
 

 
 
$filename=null;
 if ($_FILES[$name]['size'] <= $max_size)	
 {

$nam=$_FILES[$name]['name'];
$ext = strrchr($nam, ".");

$type=explode(',',$type);
 if (in_array($ext,$type))
 {

$secret=rand(1000,9000);
$filename=F::getAliasName((substr($nam,0,strlen($nam)-4)));
$filename=$secret.$filename.$ext;
$uploadfile = $path.$filename;
	
if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile))
{
$real_path = realpath($path.$filename);
   $file = $real_path;
   chmod($file, 0777);
}
    else {$err = JText::_("ERROR_UPLOAD"); } 		
 }  else {$err = JText::_("ERROR_FORMATFILE"); }
  } else {$err = JText::_("ERROR_MAXFILE"); }


$fil->filename = $filename;
$fil->err = $err;
 
 

  return $fil;
}



	function getAliasName($str) {
    // переводим в транслит
    $str = F::rus2translit($str);
    // в нижний регистр
    $str = strtolower($str);
    // заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
    $str = trim($str, "-");
    return $str;
}
	
	
	
  function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}


}
?>