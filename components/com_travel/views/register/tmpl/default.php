 <?php defined('_JEXEC') or die; JHtml::_('formbehavior.chosen', 'select');
 $plugin = JPluginHelper::getPlugin('captcha', 'recaptcha');
 $pluginParams = new JRegistry($plugin->params);
 $site_key = $pluginParams->get('public_key');
 $layer = 'josForm';
 $return = JRequest::getVar('return');
 if ($return) $return = base64_decode($return);
 else $return = JURI::root();
 ?>
 <script>
 var PATH = "<?=JURI::root()?>";
 var returns ="<?=$return?>";
 </script>    
 
<script src='https://www.google.com/recaptcha/api.js'></script>

<div class="zen-hotels-content" id="loginregister" style="">

 <div class="zen-hotels-leftbar" >
 <div class="zen-hotels-leftbar-regioninfo">
 <div class="zen-regioninfo zen-regioninfo-able-change">
 
 	<h2 class="componentheading">
		<?=JText::_('Login')?></h2>
 <form action="/index.php" enctype="multipart/form-data" method="post" id="josForm2" name="josForm2" class="form-validate">


		<div class="admintable_register"  >
 
			<div class="form-register row">

 <div class="zen-hotels-filter zen-hotels-filter-hotelname">
  <div class="zen-filter zen-filter-hotelname zen-filter-hotelname">
  <div class="zen-filter-title zen-filter-hotelname-title">Username <span class="colorR">*</span></div>
  <div class="zen-filter-hotelname-field">
    	<input type="text" name="login" id="login"  value="" class="inputbox required zen-filter-hotelname-input "  />
                                  
  <div class="zen-filter-hotelname-clear"></div></div></div>
  </div>
   <div class="zen-hotels-filter zen-hotels-filter-hotelname">
  <div class="zen-filter zen-filter-hotelname zen-filter-hotelname">
  <div class="zen-filter-title zen-filter-hotelname-title">Password <span class="colorR">*</span></div>
  <div class="zen-filter-hotelname-field">
    	<input type="password" name="pass" id="pass"  value="" class="inputbox required zen-filter-hotelname-input "  />
                                  
  <div class="zen-filter-hotelname-clear"></div></div></div>
  </div>
  
  
  <div class="k2AccountPageUpdate">
			<button id="login_btn" class="zen-hotelcard-nextstep-button" id="" type="submit">
			Login			</button>
		</div>
  
 </div>
 </div>
 	<input type="hidden" name="option" value="com_travel" />
	<input type="hidden" name="task" value="login" />
</form>


 </div></div>
 </div>
 
 <section  class="zen-hotels-main-content"  >
<form action="/index.php" enctype="multipart/form-data" method="post" id="josForm" name="josForm" class="form-validate">
	 
		<div id="k2Container" class="register_m">




		<div class="admintable_register"  >
			<h2 class="k2ProfileHeading"><?=JText::_('REGISTER')?></h2>
			<div class="form-register row">
             
  <div class="zen-hotels-filter zen-hotels-filter-hotelname">
  <div class="zen-filter zen-filter-hotelname zen-filter-hotelname">
  <div class="zen-filter-title zen-filter-hotelname-title">You are registering as:</div>
  <div class="zen-filter-hotelname-field">
    <select name="jform[type]" class="zen-filter-hotelname-input ">
                    <option value="0">Tourist</option>
                    <option value="1">Agency</option>
                    </select>
                                  
  <div class="zen-filter-hotelname-clear"></div></div></div>
  </div>
  
  
  
    <div class="zen-hotels-filter zen-hotels-filter-hotelname">
  <div class="zen-filter zen-filter-hotelname zen-filter-hotelname">
  <div class="zen-filter-title zen-filter-hotelname-title">Name <span class="colorR">*</span></div>
  <div class="zen-filter-hotelname-field">
    	<input type="text" name="jform[name]" id="name"  value="" class="inputbox required zen-filter-hotelname-input "  />
                                  
  <div class="zen-filter-hotelname-clear"></div></div></div>
  </div>
           
           
    <div class="zen-hotels-filter zen-hotels-filter-hotelname">
  <div class="zen-filter zen-filter-hotelname zen-filter-hotelname">
  <div class="zen-filter-title zen-filter-hotelname-title">Login <span class="colorR">*</span></div>
  <div class="zen-filter-hotelname-field">
    	<input type="text" name="jform[username]" id="username"  value="" class="inputbox required zen-filter-hotelname-input"    />
                                  
  <div class="zen-filter-hotelname-clear"></div></div></div>
  </div>
      <div class="zen-hotels-filter zen-hotels-filter-hotelname">
  <div class="zen-filter zen-filter-hotelname zen-filter-hotelname">
  <div class="zen-filter-title zen-filter-hotelname-title">E-mail <span class="colorR">*</span></div>
  <div class="zen-filter-hotelname-field">
    	<input type="text" name="jform[email]" id="email1"  value="" class="inputbox required zen-filter-hotelname-input "    />
                                  
  <div class="zen-filter-hotelname-clear"></div></div></div>
  </div>
          <div class="zen-hotels-filter zen-hotels-filter-hotelname">
  <div class="zen-filter zen-filter-hotelname zen-filter-hotelname">
  <div class="zen-filter-title zen-filter-hotelname-title">Repeat E-mail <span class="colorR">*</span></div>
  <div class="zen-filter-hotelname-field">
    	<input type="text" name="jform[email2]" id="email2"  value="" class="inputbox required zen-filter-hotelname-input "    />
                                  
  <div class="zen-filter-hotelname-clear"></div></div></div>
  </div>           
           <div class="zen-hotels-filter zen-hotels-filter-hotelname">
  <div class="zen-filter zen-filter-hotelname zen-filter-hotelname">
  <div class="zen-filter-title zen-filter-hotelname-title">Password<span class="colorR">*</span></div>
  <div class="zen-filter-hotelname-field">
    	<input type="password" name="jform[password]" id="password"  value="" class="inputbox required zen-filter-hotelname-input "    />
                                  
  <div class="zen-filter-hotelname-clear"></div></div></div>
  </div>        
           <div class="zen-hotels-filter zen-hotels-filter-hotelname">
  <div class="zen-filter zen-filter-hotelname zen-filter-hotelname">
  <div class="zen-filter-title zen-filter-hotelname-title">Repeat password<span class="colorR">*</span></div>
  <div class="zen-filter-hotelname-field">
    	<input type="password" name="jform[password2]" id="password2"  value="" class="inputbox required zen-filter-hotelname-input "    />
                                  
  <div class="zen-filter-hotelname-clear"></div></div></div>
  </div>        
                  
			    
				
			 
				
				
				<div class="col-sm-12 col-xs-12">
				 											
				</div>
			</div>
		</div>
 
		
        
        	<div class="f-input" id="capt">
	 <div class="g-recaptcha" data-sitekey="<?=$site_key?>"></div>
			</div>
        
		<div class="k2AccountPageNotice">Fields marked with an asterisk (*) are required.</div>
		<div class="k2AccountPageUpdate">
			<button id="<?=$layer?>_save" class="zen-hotelcard-nextstep-button" id="" type="submit">
			Register			</button>
		</div>
	</div>
	<input type="hidden" name="option" value="com_travel" />
	<input type="hidden" name="task" value="register" />
 
    </form>
    </section>
 	</div>
 <script>
 jQuery(document).ready(function(){
 
 //Авторизация
 
  jQuery(document).on('click', '#login_btn', function () {       
  var btn  = jQuery('#login_btn');
  var txtbtn = btn.html();
    btn.html('<?=JText::_('SAVEGO');?>');
   
    
   var $that = jQuery('#josForm2');
   formData = new FormData($that.get(0));
   
   
    jQuery.ajax({
      url: $that.attr('action'),
      type: $that.attr('method'),
      contentType: false,  
      processData: false,  
      data: formData,
      dataType: "json",  
      success: function(res){
   
   btn.html(txtbtn);
  
   jQuery('.error_fled').removeClass('error_fled');
   
   if (res.error) { alert(res.error);
   grecaptcha.reset();
   }
   
   if (res.fleds.length > 0)
   {grecaptcha.reset();
    for (var i=0; i<res.fleds.length; i=i+1)
    {
    jQuery('#'+res.fleds[i]).addClass('error_fled');
    }
    
    
    
    
      setTimeout(function(){
     jQuery('.error_fled').removeClass('error_fled');
    
}, 4000);
    
   }
   else if (!res.error) {
   
    
   // //if (res.news==1)
    window.location.href = returns;
  //  else
  // location.reload();
  
   }
   
  }
  });
    return false;
  }); // 
 
 
 
 //Обработка формы
 jQuery(document).on('click', '#<?=$layer?>_save', function () {       
  var btn  = jQuery('#<?=$layer?>_save');
  var txtbtn = btn.html();
    btn.html('<?=JText::_('SAVEGO');?>');
   
    
   var $that = jQuery('#<?=$layer?>');
   formData = new FormData($that.get(0));
   
   
    jQuery.ajax({
      url: $that.attr('action'),
      type: $that.attr('method'),
      contentType: false,  
      processData: false,  
      data: formData,
      dataType: "json",  
      success: function(res){
   
   btn.html(txtbtn);
  
   jQuery('.error_fled').removeClass('error_fled');
   
   if (res.error) { alert(res.error);
   grecaptcha.reset();
   }
   
   if (res.fleds.length > 0)
   {grecaptcha.reset();
    for (var i=0; i<res.fleds.length; i=i+1)
    {
    jQuery('#'+res.fleds[i]).addClass('error_fled');
    }
    
    
    
    
      setTimeout(function(){
     jQuery('.error_fled').removeClass('error_fled');
    
}, 4000);
    
   }
   else if (!res.error) {
   
    
   // //if (res.news==1)
    window.location.href = res.link;
  //  else
  // location.reload();
  
   }
   
  }
  });
    return false;
  }); // 
 });
 </script>
 
 
 
  