<?php defined( '_JEXEC' ) or die( '=;)' );
class travel       {
    
    
     static public function strtotimed($data){
      
     $arr['Jan']=1;
     $arr['Feb']=2;
     $arr['Mar']=3;
     $arr['Apr']=4;
     $arr['May']=5;
     $arr['June']=6;
     $arr['July']=7;
     $arr['Aug']=8;
     $arr['Sept']=9;
     $arr['Oct']=11;
     $arr['Nov']=11;
     $arr['Dec']=12;
     
     

     $data = explode('-',$data);
    $data[1] = trim($data[1]);

        return mktime(0,0,0,($arr[$data[1]]),$data[0],$data[2]);
     }
     
    
     static public function getRooms(){
     
         $pgbc = array();
         $n=0;
        $pgbc[$n] = new stdClass();
        $pgbc[$n]->text = 1;
        $pgbc[$n]->value =1;
            $n++;
           $pgbc[$n] = new stdClass();
          $pgbc[$n]->text = 2;
        $pgbc[$n]->value =2;
            $n++;  
       
       return $pgbc;
     
 

     }
     static public function getNacional(){
        
        $f = "Afghanistan	AF
Albania	AL
Antarctica	AQ
Algeria	DZ
American Samoa	AS
Andorra	AD
Angola	AO
Antigua and Barbuda	AG
Azerbaijan	AZ
Argentina	AR
Australia	AU
Austria	AT
Bahamas	BS
Bahrain	BH
Bangladesh	BD
Armenia	AM
Barbados	BB
Belgium	BE
Bermuda	BM
Bhutan	BT
Bolivia	BO
Bosnia and Herzegovina	BA
Botswana	BW
Bouvet Island	BV
Brazil	BR
Belize	BZ
British Indian Ocean Territory	IO
Solomon Islands	SB
British Virgin Islands	VG
Brunei Darussalam	BN
Bulgaria	BG
Myanmar	MM
Burundi	BI
Belarus	BY
Cambodia	KH
Cameroon	CM
Canada	CA
Cape Verde	CV
Cayman Islands	KY
Central African Republic	CF
Sri Lanka	LK
Chad	TD
Chile	CL
China	CN
Taiwan Province of China	TW
Christmas Island	CX
Cocos (Keeling) Islands	CC
Colombia	CO
Comoros	KM
Mayotte	YT
Congo	CG
Democratic Republic of the Congo	CD
Cook Islands	CK
Costa Rica	CR
Croatia	HR
Cuba	CU
Cyprus	CY
Czech Republic	CZ
Benin	BJ
Denmark	DK
Dominica	DM
Dominican Republic	DO
Ecuador	EC
El Salvador	SV
Equatorial Guinea	GQ
Ethiopia	ET
Eritrea	ER
Estonia	EE
Faeroe Islands	FO
Falkland Islands (Malvinas)	FK
South Georgia and the South Sandwich Islands	GS
Fiji	FJ
Finland	FI
Aland Islands	AL
France	FR
French Guiana	GF
French Polynesia	PF
French Southern Territories	TF
Djibouti	DJ
Gabon	GA
Georgia	GE
Gambia	GM
Occupied Palestinian Territory	PS
Germany	DE
Ghana	GH
Gibraltar	GI
Kiribati	KI
Greece	GR
Greenland	GL
Grenada	GD
Guadeloupe	GP
Guam	GU
Guatemala	GT
Guinea	GN
Guyana	GY
Haiti	HT
Heard and McDonald Islands	HM
Holy See	VA
Honduras	HN
Hong Kong SARC	HK
Hungary	HU
Iceland	IS
India	IN
Indonesia	ID
Iran (Islamic Republic of)	IR
Iraq	IQ
Ireland	IE
Israel	IL
Italy	IT
CΓîáte d'Ivoire	CI
Jamaica	JM
Japan	JP
Kazakhstan	KZ
Jordan	JO
Kenya	KE
Democratic People's Republic of Korea	KP
Republic of Korea	KR
Kuwait	KW
Kyrgyzstan	KG
Lao People's Democratic Republic	LA
Lebanon	LB
Lesotho	LS
Latvia	LV
Liberia	LR
Libya	LY
Liechtenstein	LI
Lithuania	LT
Luxembourg	LU
Macao SARC	MO
Madagascar	MG
Malawi	MW
Malaysia	MY
Maldives	MV
Mali	ML
Malta	MT
Martinique	MQ
Mauritania	MR
Mauritius	MU
Mexico	MX
Monaco	MC
Mongolia	MN
Republic of Moldova	MD
Montenegro	ME
Montserrat	MS
Morocco	MA
Mozambique	MZ
Oman	OM
Namibia	NA
Nauru	NR
Nepal	NP
Netherlands	NL
Netherlands Antilles	AN
Aruba	AW
New Caledonia	NC
Vanuatu	VU
New Zealand	NZ
Nicaragua	NI
Niger	NE
Nigeria	NG
Niue	NU
Norfolk Island	NF
Norway	NO
Northern Mariana Islands	MP
United States Minor Outlying Islands	UM
Micronesia, Federated States of	FM
Marshall Islands	MH
Palau	PW
Pakistan	PK
Panama	PA
Papua New Guinea	PG
Paraguay	PY
Peru	PE
Philippines	PH
Pitcairn	PN
Poland	PL
Portugal	PT
Guinea-Bissau	GW
Timor-Leste	TL
Puerto Rico	PR
Qatar	QA
R╬ÿunion	RE
Romania	RO
Russian Federation	RU
Rwanda	RW
Saint Barthelemy	BL
Saint Helena	SH
Saint Kitts and Nevis	KN
Anguilla	AI
Saint Lucia	LC
Saint Martin (French Part)	MF
Saint Pierre and Miquelon	PM
Saint Vincent and the Grenadines	VC
San Marino	SM
Sao Tome and Principe	ST
Saudi Arabia	SA
Senegal	SN
Serbia	RS
Seychelles	SC
Sierra Leone	SL
Singapore	SG
Slovakia	SK
Viet Nam	VN
Slovenia	SI
Somalia	SO
South Africa	ZA
Zimbabwe	ZW
Spain	ES
Western Sahara	EH
Sudan	SD
Suriname	SR
Svalbard and Jan Mayen Islands	SJ
Swaziland	SZ
Sweden	SE
Switzerland	CH
Syrian Arab Republic	SY
Tajikistan	TJ
Thailand	TH
Togo	TG
Tokelau	TK
Tonga	TO
Trinidad and Tobago	TT
United Arab Emirates	AE
Tunisia	TN
Turkey	TR
Turkmenistan	TM
Turks and Caicos Islands	TC
Tuvalu	TV
Uganda	UG
Ukraine	UA
Macedonia	MK
Egypt	EG
United Kingdom	GB
Guernsey	GG
Jersey	JE
Isle of Man	IM
United Republic of Tanzania	TZ
United States	US
United States Virgin Islands	VI
Burkina Faso	BF
Uruguay	UY
Uzbekistan	UZ
Venezuela	VE
Wallis and Futuna Islands	WF
Samoa	WS
Yemen	YE
Zambia	ZM
";
        $pgbc = array();
        $n=1;  
        $f = explode("\n",$f);
        foreach ($f as $ff)
        {
            $ff = trim($ff);
            if (!$ff) continue;
            $s = '';
            preg_match('/(.*)\s(\D\D)$/',$ff, $arr);
            
            
       
        $pgbc[$n] = new stdClass();
        $pgbc[$n]->text = ($arr[1]);
        $pgbc[$n]->value =trim($arr[2]);
            $n++;
          
          
            
        }
       return $pgbc;
     
 

     }
    
      static public function getOrder($id){
      $db=JFactory::getDBO();
      $q = 'SELECT * FROM `#__travel_order` WHERE id='.(int)$id;
      $db->setQuery($q);
     return $db->LoadObject();
     }
     static public function getOtel($id){
      $db=JFactory::getDBO();
      $q = 'SELECT * FROM #__travel_otel WHERE id='.(int)$id;
      $db->setQuery($q);
     return $db->LoadObject();
     }
     static public function getOtelVid($id){
      $db=JFactory::getDBO();
      $q = 'SELECT * FROM #__travel_otel WHERE vid='.(int)$id;
      $db->setQuery($q);
     
     return $db->LoadObject();
     }
    static public function link($view, $dop = '')
  {
  $link =  JRoute::_('index.php?option=com_travel&view='.$view.$dop);
    
     $db=JFactory::getDBO();
     $q = 'SELECT id FROM #__menu WHERE published=1 AND
     link="index.php?option=com_travel&view='.$view.'"';
     $db->setQuery($q);
  
     $Itemid = $db->LoadResult();
   
    if ($Itemid)
    $link =  JRoute::_('index.php?option=com_travel&Itemid='.$Itemid.$dop);
    
    
    return $link;
  }
    
    
      
      
    
    static public  function  pr(
     $pr, 
     $row = '', 
     $nac = true, 
     $nurpr = false) 
{
    $db=JFactory::getDBO();
    $params = JComponentHelper::getParams( 'com_travel' );
    
    
    if ($nac) {
        //Модифицируем цену в зависимости
     
         
        
        if ($row)
        {   //Страна
        $price = 0;
           if (isset($row->region_proc_strana)) 
           {
             if ($row->region_proc_strana)
             {
                $price = $row->region_proc_strana;
             }
           }
           
           
            if (isset($row->region_proc)) 
           {
             if ($row->region_proc)
             {
                $price = $row->region_proc;
             }
           }
           
       if (isset($row->proc)) 
           {
             if ($row->proc)
             {
                $price = $row->proc;
             }
           }
        
          //Модифицируем цену
         if ($price)
            {
                if (strpos($price,'%')===false)
                {
                    $pr = $pr+$price;
                }
                else
                {
                    $price = (float)$price;
                    $x =$price*$pr/100;
                    $pr = $pr+$x;
                }

            }
         
    }//row
        
    //Модификатор цены
        $user = JFactory::getUser();
        if ($user->id==0)
        {
            $price = $params->get('price',0);
        }
        else
        {
            
            
            
            $price = $params->get('price_auth',0);
       
       $grs=array();
      foreach ($user->groups as $gr)
      {
        $grs[]=$gr;
      }
     
       $q = 'SELECT proc FROM #__travel_gr WHERE 
       `gr` IN ('.implode(',',$grs).') AND
        published=1 ORDER BY ordering ASC  LIMIT 1';
         
       $db->setQuery($q);
       $proc = $db->LoadResult();
        if ($proc) $price =  $proc;
        }
             
            
            
            if ($price)
            {
                if (strpos($price,'%')===false)
                {
                    $pr = $pr+$price;
                }
                else
                {
                    $price = (float)$price;
                    $x =$price*$pr/100;
                    $pr = $pr+$x;
                }

            }
       
    
 }//Конец модификатора
 
 if ($nurpr)
 return $pr;
 
    $s = false;
    if ($pr<0)
    $s = true; 
 
 $temp = $params->get('pr','${price}');
 if ($s){
 $temp = "-".$temp;
 $pr = $pr*-1;
 }
 

$dr = '.';
$count =0; 
$ras = ' ';
$pr = (float)$pr;
$pr = number_format($pr, $count, $dr, $ras);
$temp = preg_replace("/{price}/", $pr, $temp);
if (empty($temp))  $temp=$pr;
return  $temp;
    
}

static public  function  pr1(
     $pr, 
     $row = '', 
     $nac = true, 
     $nurpr = false) 
{
    $db=JFactory::getDBO();
    $params = JComponentHelper::getParams( 'com_travel' );
	
	if($_COOKIE['JBZooCurrencyToggle_current']){
	 $to =$_COOKIE['JBZooCurrencyToggle_current']; 
	}else{
	  $to ='gbp';
	}
    
	    if($to=='eur'){
		  $rate = 1.28974;
		  $symbol='€';
		  $ConvertedPrice =  round($pr * $rate);
		  $finalPrice =  $symbol . $ConvertedPrice;
		}else if($to=='usd'){
		  $symbol='$';
		  $rate = 1.28974;
		  $ConvertedPrice =  round($pr * $rate);
		  $finalPrice =  $symbol . $ConvertedPrice;
			
		}
		else if($to=='cad'){
		 $symbol='C$';
		  $rate = 1.28974;
		  $ConvertedPrice =  round($pr * $rate);
		  $finalPrice =  $symbol . $ConvertedPrice;
		}else if($to=='gbp'){
		  $symbol='£';
		  
		  $ConvertedPrice =  round($pr);
		  $finalPrice =  $symbol . $ConvertedPrice;
		}
		
		else{
		  $symbol='£';
		  $finalPrice = round($pr * $rate);
		}
		
		return $finalPrice;
     
    
}

static public  function convertCurrency($amount, $from = 'EUR', $to = 'USD'){
    if (empty($_COOKIE['exchange_rate'])) {
        $Cookie = new Cookie($_COOKIE);
        $curl = file_get_contents_curl('http://api.fixer.io/latest?symbols='.$from.','.$to.'');
        $rate = $curl['rates'][$to];
        $Cookie->exchange_rate = $rate;
    } else {
        $rate = $_COOKIE['exchange_rate'];
    }
    $output = round($amount * $rate);

    return $output;
}
  static public function month_name($id){

 $array[1] = array('January',	'Jan.'	,'Январь');
 $array[2] = array('February',	'Feb.',	'Февраль');
 $array[3] = array('March',	'Mar.',	'Март');
 $array[4] = array('April',	'Apr.',	'Апрель');
 $array[5] = array('May',	'May',	'Май');
 $array[6] = array('June',	'June',	'Июнь');
 $array[7] = array('July',	'July',	'Июль');
 $array[8] = array('August	',	'Aug.',	'Август');
 $array[9] = array('September	',	'Sept.',	'Сентябрь');
 $array[10] = array('October',	'Oct.',	'Октябрь');
 $array[11] = array('November',	'Nov.',	'Ноябрь');
 $array[12] = array('December',	'Dec.',	'Декабрь');
 
 
   return $array[(int)$id] ;
  }
  

public static  function P($value)
{
    $value = trim($value);
    if (empty($value))
    return false;
    else
    return true;
}  
  
    
  
 public static  function email($email) {

if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
        {return true; } else{ return false;}
 
 
}
   //Записать 
    public static   function store($data, $name)
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

  static public  function send_(  $email, $subject, $html, $file = '')
   {  
      $params =  JComponentHelper::getParams( 'com_travel' );
   
      $app		= JFactory::getApplication();
      $date		= JFactory::getDate();
      
         $mail = JFactory::getMailer();
         $sender = array(
             $app->getCfg('mailfrom'),
             $app->getCfg('fromname')
             );
                  if ($file)
                  {
                 foreach ($file as $fil)
                 $mail->addAttachment($fil); 
                  }
                  
         $mail->setSender($sender); 
         
       if (is_array($email))
         {
            foreach ($email as $em)
            $mail->addRecipient($em);
         }
         else
         $mail->addRecipient($email);
         
		 $mail->isHTML(true);
			$mail->setSubject($subject);
			$mail->setBody($html);
		    $send =  $mail->Send();
if ($send !== true)
{ 
    return false;
}
else
{
    return true;
}
            
   } 
   
    static public function region($id){
         $db=JFactory::getDBO();
         $q = 'SELECT * FROM #__travel_region WHERE id='.(int)$id;
         $db->setQuery($q);
       return $db->LoadObject();
    }
	
	
    
   
}

?>