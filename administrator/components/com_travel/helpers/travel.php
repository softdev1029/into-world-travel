<?php
jimport('joomla.application.component.controller');
jimport( 'joomla.filesystem.folder' ); 
jimport( 'joomla.filesystem.file' );
jimport( 'joomla.mail.helper' );

 
 function aurl() 
{return JURI::root().'administrator/components/com_travel/assets/js/';} 

require_once  JPATH_SITE.'/administrator/components/com_travel/helpers/xls/Classes/PHPExcel/IOFactory.php';

 
 Class ChunkReadFilter implements PHPExcel_Reader_IReadFilter {

    private $_startRow = 0;
    private $_endRow = 0;

    /**  Set the list of rows that we want to read  */
    public function setRows($startRow, $chunkSize) {
        $this->_startRow = $startRow;
        $this->_endRow = $startRow + $chunkSize;
    }

    public function readCell($column, $row, $worksheetName = '') {

        //  Only read the heading row, and the rows that are configured in $this->_startRow and $this->_endRow 
        if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow)) {

            return true;
        }
        return false;
    }

}

class travelHelper  
{


 public static function find__otel($vid = 0)
 { 
    $db = JFactory::getDBO(); 
  
    $q = 'SELECT id FROM `#__travel_otel` WHERE vid='.$vid;
    $db->setQuery($q);
    return $db->LoadResult();
    
 }

 public static function find_($vid = 0)
 { 
    $db = JFactory::getDBO(); 
  
    $q = 'SELECT id FROM `#__travel_region` WHERE id='.$vid;
    $db->setQuery($q);
    return $db->LoadResult();
    
 }
 public static function deletexkat($id, $type)
    {
       $db = JFactory::getDBO();
       $q = 'DELETE FROM `#__travel_'.$type.'_xref` WHERE vid='.(int)$id; 
       $db->setQuery($q);
       $db->Query();
    }
    
 public static function loadxkat($id, $type)
 { 
    $db = JFactory::getDBO();
    $q = 'SELECT kat FROM `#__travel_'.$type.'_xref` WHERE vid='.(int)$id;
    $db->setQuery($q);
    return $db->LoadColumn();
    
 }

 public static    function save_xkat($id, $pref ='')
    {    $db = JFactory::getDBO();
        $jform= JRequest::getVar('jform');
        $kat = ($jform['kat']);
        
        
        $q = "SELECT kat FROM #__travel_".$pref."_xref WHERE vid=".(int)$id;
        $db->setQuery($q);
        $list =   $db->loadColumn();
        
        if ($kat)
        foreach ($kat as $k)
        {if (!$k) continue;
            if (!in_array($k,$list)){
            $q  ='INSERT INTO #__travel_'.$pref.'_xref (`vid`,`kat`) VALUES ('.$id.','.$k.')';
            $db->setQuery($q);
            $db->Query();
            }
        }       
         
            if (!empty($list))
  {
    if (!is_array($kat)) $kat =array();
    
$count = count($list);
for ($i=0; $i<$count; $i++)
{
    $cat = $list[$i];
    if (!in_array($cat, $kat))
     {
        $q = "DELETE FROM #__travel_".$pref."_xref WHERE  kat=".$cat." AND vid=".(int)$id;
        $db->setQuery( $q );
        $db->query();
           
          
          
     }
}    
  }
        
    }
    
public static 	function getAliasName($str) {
    // переводим в транслит
    $str = travelHelper::rus2translit($str);
    // в нижний регистр
    $str = strtolower($str);
    // заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
    $str = trim($str, "-");
    return $str;
}
	
	 
	
  public static function rus2translit($string) {
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

 public static function addSubmenu($vName)
	{
	  
		JSubMenuHelper::addEntry(
			JText::_('PANEL'),
			'index.php?option=com_travel',
			$vName == ''
		);
	 $vName = '';
         JSubMenuHelper::addEntry(
			JText::_("Countries"),
			"index.php?option=com_travel&view=stranas",
			$vName == "stranas"
		); 
         JSubMenuHelper::addEntry(
			JText::_("Regions"),
			"index.php?option=com_travel&view=regions",
			$vName == "regions"
		); 
          JSubMenuHelper::addEntry(
			JText::_("Hotels"),
			"index.php?option=com_travel&view=otels",
			$vName == "otels"
		); 
          JSubMenuHelper::addEntry(
			JText::_("Orders"),
			"index.php?option=com_travel&view=orders",
			$vName == "orders"
		);
	}
 
   
public static function I ($name, $w=null, $v = false, $alt=null)
{
 if (!empty($w))
 {
    $w = 'style="'.$w.'"';
 }
 if (!$v)
echo '<img  alt="'.$alt.'" title="'.$alt.'"   border="0" '.$w.' src="'.JURI::root().'administrator/components/com_travel/assets/images/'.$name.'" />';
else return '<img border="0" alt="'.$alt.'" title="'.$alt.'" '.$w.' src="'.JURI::root().'administrator/components/com_travel/assets/images/'.$name.'" />';
}

  
function get_list_table($table,$order = 'id',$where='')
{
    $db = JFactory::getDBO();
    $q = 'SELECT * FROM #__travel_'.$table.$where.' ORDER BY '.$order;
    $db->setQuery($q);
    return $db->LoadObjectList();
} 
 
 //function_designer_helpers
 
 
public static function  AJAX()
{ 

if (!isset($_REQUEST['ajax_fedyanin']))  
{
$_REQUEST['ajax_fedyanin'] = 1;
$document = & JFactory::getDocument();
$document->addScript(JURI::root().'administrator/components/com_travel/JsHttpRequest/lib/JsHttpRequest/JsHttpRequest.js');
} }
	

 public static  function store($data, $name)
  {
   
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
$row = JTable::getInstance($name, 'Table');
      

      
     // Bind the form fields to the hello table
     if (!$row->bind($data)) {
        
        return false;
     }

     // Make sure the record is valid
     if (!$row->check()) {
        
        return false;
     }

     // Store the table to the database
     if (!$row->store()) {
        
        return false;
     }
 
 return $row;    
 }
 
}
 
?>