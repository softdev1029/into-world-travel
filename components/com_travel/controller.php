<?php
defined( '_JEXEC' ) or die( '=;)' );
jimport('joomla.application.component.controller');
class travelController extends JControllerLegacy
{
    
    function __construct($config = array())
	{
    parent::__construct($config);
	}
     
  //ajax поиск   
  public function filter_ajax(){
    $ajax = JRequest::getInt('ajax');
    if ($ajax)
    {
        $data = JRequest::getVar('e');
        
           $ajax = JRequest::getInt('ajax');
           $price_min = JRequest::getVar('price_min');
           $price_max = JRequest::getVar('price_max');
           $type = JRequest::getVar('type');
           $range_is = JRequest::getInt('range_is');
           $star = JRequest::getVar('star');
           $amenity = JRequest::getVar('amenity', array());
           
     
     $s = array();
     foreach ($data as $key=>$val)
     {
     $s[]='e['.$key.']='.$val;   
     }
     
     $d = array();
   $d['e'] = $data;
      $mapslink = travel::link('maps',  "&tmpl=components&".http_build_query($d)); 
     
     $s = implode('&',$s);
        
        $row =  xml::send_to_xml ($data, 1);
        $xml_test = simplexml_load_string($row);
       
        $region = $data['region']; 
       $region = travel::region($region);
 
   
        $total = count($xml_test->HotelAvailability);
        $html =  html::hotel_list($xml_test,$data,$region);
        
        
        $options=array(
        "html"=>$html,
        "mapslink"=>$mapslink,
        "total"=>$total,
        "link"=>$s,
        );
         echo json_encode($options);
         exit;
        
        
    }//ajax
    
    
       
    
      }
     
    //Обработка  функций
 public function html(){
  $dir  =JPATH_COMPONENT.'/helpers/event/html/';
  $function = JRequest::getVar('function');
  if (is_file($dir.''.$function.'.php'))
  require_once($dir.''.$function.'.php'); 
  }
   
    
  public function display($cachable = false, $urlparams = false)
	{
		$cachable 	= false;
		$document 	= JFactory::getDocument();
		$vName		= JRequest::getWord('view', 'travel');
 	 
		JRequest::setVar('view', $vName);
		$user 		= JFactory::getUser();



		$safeurlparams = array('catid'=>'INT','id'=>'INT','cid'=>'ARRAY','year'=>'INT','month'=>'INT','limit'=>'INT','limitstart'=>'INT',
			'showall'=>'INT','return'=>'BASE64','filter'=>'STRING','filter_order'=>'CMD','filter_order_Dir'=>'CMD','filter-search'=>'STRING','print'=>'BOOLEAN','lang'=>'CMD');

 
 
parent::display($cachable,$safeurlparams);

		return $this;
	}	
	
    //----------------------- Регистрация --------------------------
   //Авторизация и регистрация
  function login ()
  { ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
   $user  = JFactory::getUser();
   $db = JFactory::getDBO();
   $Itemid = Jrequest::getVar('Itemid');
    	$app	= JFactory::getApplication();
   $params = JComponentHelper::getParams('com_travel');
      $status = 0;
    $error = '';
    $fleds = array();
   $login = JRequest::getVar('login');
   $pass = JRequest::getVar('pass');
      if ($user->id!=0)
        {
           $error ='You are already authorized'; 
        }
     if (!$login)
       {
         $fleds[]='login';
       }
   if (!$pass)
       {
         $fleds[]='pass';
       }
       
        if (count($fleds)==0) {
    $status =1; 
	  $credentials = array();
	  $credentials['username'] = $login;
	  $credentials['password'] = $pass;
       $options = array();
     $options['remember'] = false;
     $options['return'] = null;
      
      $app->login($credentials, $options);
      $user = JFactory::getUser();
    
     if ($user->id==0)
     {
        $status = 0; 
        $error  ='Login or password error';  
     }
    }
        $options=array(
    "fleds"=>$fleds,
    "error"=>$error,
    "status"=>$status,);
     echo json_encode($options);
     exit; 
  }   
     
     
       //Регистрация участника
  function register()
  {
   $user  = JFactory::getUser();
   $db = JFactory::getDBO();
   $Itemid = Jrequest::getVar('Itemid');
   $params = JComponentHelper::getParams('com_travel');
    
    $status = 0;
    $error = '';
    $fleds = array();
    
    
    $jform = JRequest::getVar('jform',array());
    
    $email = $jform['email'];
    $email2 = $jform['email2'];
    
    
    $name = $jform['name'];
    $username =  $jform['username'];
    $country = JRequest::getInt('country');
    $state = JRequest::getInt('state');
    $password1 = $jform['password'];
    $password2 = $jform['password2'];
   
   
  
   
     if ($user->id!=0)
        {
           $error ='You are already authorized'; 
        }
   
   
  	$app	= JFactory::getApplication();
	$model	= $this->getModel('Registration', 'TravelModel');
         
   
       if (!$username)
       {
         $fleds[]='username';
       }
      
       if ( !travel::email( $email ) ) {
       $fleds[]='email1';
       }
       elseif($email!=$email2)
       {
         $fleds[]='email1';
         $fleds[]='email2';
       } 
    
    
  
  
  if (! ($name)) {$fleds[]='name';}
  //if (! ($namel)) {$fleds[]='namel';}
    
     if (!$password1)
     $fleds[]='password';  
    if ($password1!=$password2)
    $fleds[]='password2';    
    
    
   if (count($fleds)==0)
   {
    
     $plugin = JPluginHelper::getPlugin('captcha', 'recaptcha');
     $pluginParams = new JRegistry($plugin->params);
     $urlc = 'https://www.google.com/recaptcha/api/siteverify';
    $input = JFactory::getApplication()->input;
        $data = array('secret' => $pluginParams->get('private_key'), 'response' => $input->get('g-recaptcha-response')); 
		$moduleParams = new JRegistry();
		$http = new JHttp($moduleParams, $transport = null);
		
		//Post data to url and get response
		$response = $http->post($urlc, $data);
		$response = json_decode($response->body);
 
		if($response->success)
		 {}
		else
		{			
		$fleds[] = 'capt';
		}
   } 
    
    
 if (count($fleds)>0) {
     $options=array(
    "fleds"=>$fleds,
    "error"=>$error,
    "status"=>$status,);
     echo json_encode($options);
     exit;
    }
    
     $requestData['email1'] = $email;
     $requestData['email2'] = $email;
     $requestData['name'] = $name;
     $requestData['username'] = $username;
     
     $requestData['password1'] = $password1;
     $requestData['password2'] = $password2;
         
        if ( !($error) ) {   
    	$form	= $model->getForm();
		if (!$form) {
		$error = $model->getError();
        } 
        else
        {
         $data	= $model->validate($form, $requestData);    
        
        if ($data === false) {
			// Get the validation messages.
		   $errors	= $model->getErrors();
         	// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					//$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
			
             $error = $errors[$i]->getMessage();
            	}
				else
				{
					///$app->enqueueMessage($errors[$i], 'warning');
                     $error  = $errors[$i];
				}
			}
 
			// Save the data in the session.
			$app->setUserState('com_users.registration.data', $requestData);
  
		}
        }
        }
        
        
        
        
         if ( !($error) ) {  
         $return	= $model->register($data);
        
        
        
        
        
		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_users.registration.data', $data);
 
 
             $errors	= $model->getErrors();
         	// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					//$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
			
             $error = implode('<br/>',$errors[$i]->getMessage());
            	}
				else
				{
					///$app->enqueueMessage($errors[$i], 'warning');
                     $error = implode('<br/>',$errors[$i]);
				}
			}

 
	
        
		}}
        
        
    if (!($error))
    {
  
    
     $status = 1;
    
     $options = array();
     $options['remember'] = false;
     $options['return'] = null;
     
   //Активация 
     $q = 'UPDATE #__users SET `activation`=0, `block`=0 
     WHERE username="'.$username.'"';
     $db->setQuery($q);
     $db->Query();
     
     
     $params2 = JComponentHelper::getParams( 'com_travel' );  
     $spec = $params2->get('spec');
     $type = $jform['type'];
   
     
     if ($type==1)
     {
     $q = 'SELECT group_id FROM #__user_usergroup_map WHERE user_id='.(int)$return;
    $db->setQuery($q);
    $groups = $db->loadColumn();
       if (!in_array($spec,$groups))
       {
        $q = 'INSERT INTO #__user_usergroup_map (`group_id`,`user_id`) 
         VALUES ('.$spec.','.$return.')';
        $db->setQuery($q);
        $db->Query();
       }  
     }
     

//Создаем пользователя в базе 
    //$data_user = array();
//    $data_user['name'] = $name;
//    $data_user['activate'] = 0; 
// 
//   
//    
//    if(isset($_FILES['payload']) && $_FILES['payload']['error'] == 0){
//    $extension = pathinfo($_FILES['payload']['name'], PATHINFO_EXTENSION);
//    $file = F::LOADEN($return,'payload');
//  if (!$file->err)
//  {
//     $lists=$file->filename;
//     $data_user['avatar'] = $lists;
//  }
// 
// 
// }
 
    
    //$data_user['country'] = $country;
    //$data_user['state'] = $state;
   // custom::USERS($return);
  //custom::UPDATE($return, $data_user);

     
     
	 //$credentials = array();
	 //$credentials['username'] = $username;
	// $credentials['password'] = $password1;
    // $app->login($credentials, $options);
    // $user = JFactory::getUser();
    
    //if ($user->id==0)
    //{
     //  $status = 0; 
    //   $error  ='Авторизация не прошла.';  
   // }
    
    }
     
     $link = travel::link('register','&mess=1');// 'index.php?option=com_users&view=login';
        
    $options=array(
    "fleds"=>$fleds,
    "error"=>$error,
    "link"=>$link,
    "status"=>$status,);
     echo json_encode($options);
     exit;       
   
  } //Регистрация участника в системе
    
    
}// class
