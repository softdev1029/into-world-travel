<?php
defined('_JEXEC') or die;

/**
 * Template for Joomla! CMS, created with Artisteer.
 * See readme.txt for more details on how to use the template.
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php';

// Create alias for $this object reference:
$document = $this;

// Shortcut for template base url:
$templateUrl = $document->baseurl . '/templates/' . $document->template;

Artx::load("Artx_Page");

// Initialize $view:
$view = $this->artx = new ArtxPage($this);

// Decorate component with Artisteer style:
$view->componentWrapper();

JHtml::_('behavior.framework', true);

?>
<!DOCTYPE html>
<html dir="ltr" lang="<?php echo $document->language; ?>">
<head>
    <jdoc:include type="head" />
<meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="<?php echo $templateUrl; ?>/css/normalize.css" rel="stylesheet">
    <link href="<?php echo $templateUrl; ?>/css/template.css" rel="stylesheet">
    <link href="<?php echo $templateUrl; ?>/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $templateUrl; ?>/css/jquery-ui.css" rel="stylesheet">
    <link href="<?php echo $templateUrl; ?>/css/slick.css" rel="stylesheet">
    <link href="<?php echo $templateUrl; ?>/css/style.css" rel="stylesheet">





    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $templateUrl; ?>/icons/apple-touch-icon.png">
<link rel="icon" type="image/png" href="<?php echo $templateUrl; ?>/icons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="<?php echo $templateUrl; ?>/icons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="<?php echo $templateUrl; ?>/icons/manifest.json">
<link rel="mask-icon" href="<?php echo $templateUrl; ?>/icons/safari-pinned-tab.svg" color="#197dbb">
<link rel="shortcut icon" href="<?php echo $templateUrl; ?>/icons/favicon.ico">
<meta name="msapplication-config" content="<?php echo $templateUrl; ?>/icons/browserconfig.xml">
<meta name="theme-color" content="#ffffff">



<?php echo $view->position('debug'); ?>

  <script src="//code.jivosite.com/widget.js" jv-id="XfitLTR9tv" async></script>

  <!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '219695701927544'); 
fbq('track', 'PageView');
</script>
<noscript>
<img height="1" width="1" 
src="https://www.facebook.com/tr?id=219695701927544&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->


</head>

<body>
    <!-- BEGIN HEADER -->
    <header class="header">

      <div class="container  clearfix">

        <div class="header__logo">

          <a href="/"><img src="<?php echo $templateUrl; ?>/img/newlogo3.png" alt=""></a>

        </div>


        <div class="headerbar">

          <div class="headerbar__top">

            <ul class="top-menu">

              <li class="top-menu__email"><a href="mailto:info@into-world-travel.com">info@into-world-travel.com</a></li>
              <li class="top-menu__tel"><a href="tel:02076035045" onclick="ga('send', 'event', 'Direct Phone Call', 'Click');">0207 603 5045 (UK)</a></li>
              <li class="top-menu__tel"><a href="tel:+14377009339" onclick="ga('send', 'event', 'Direct Phone Call', 'Click');">+1 437 700 9339 (CANADA, US)</a></li>
              <?php if ($view->containsModules('callback')) : ?>
                  <li class="top-menu__callback"><?php echo $view->position('callback', 'oba-nostyle'); ?></li>           
                <?php endif; ?>

            </ul>

          </div>
 <div class="header__select">


 <?php if ($view->containsModules('currency')) : ?>
                  <?php echo $view->position('currency', 'oba-nostyle'); ?>        
                <?php endif; ?>

               

            </div>

        <!--  <div class="headerbar__bottom  clearfix">

            <nav class="main-menu">

              <?php //echo $view->position('user3'); ?>

            </nav>


           

          </div>-->

        </div>

      </div>

      <!-- BEGIN BANNER-->
      <?php if ($view->containsModules('slider')) : ?>
      <section class="banner">
          
          
          
<div class="banner__carousel slick-initialized slick-slider"><div aria-live="polite" class="slick-list draggable"><div class="slick-track" role="listbox" style="opacity: 1; width: auto; transform: translate3d(0px, 0px, 0px);">

          
<div class="container" 
>
<style>section.banner>.banner__carousel.slick-initialized.slick-slider>.slick-list.draggable>.slick-track>.container {
    background: rgb(220, 220, 220, 0.9);
    margin-top: 6%;
    padding-bottom: 27px;
    border-radius: 8px;
    padding-top: 12px;
}

.banner{background: url(/images/uploads/832/knoxville_936414.jpg);}</style>
<h2 class="section-title">Find Your Hotel</h2>
<?php echo $view->position('slider2', 'oba-nostyle'); ?></div>
                 


</div></div></div>











                

   

      </section>
      <?php endif; ?>
      <!-- END BANNER -->
    </header>
    <!-- END HEADER -->

      <!-- BEGIN SEARCH -->
      <?php if ($view->containsModules('search')) : ?>
      <section class="search">
        <div class="container">
          <h2 class="section-title">Find Your Hotel</h2>
          <?php echo $view->position('search', 'oba-nostyle'); ?>        
        </div>
      </section>
      <?php endif; ?>
      <!-- END SEARCH -->

    <main>

      <div class="container">


   <?php     
//echo artxPost(array('content' => '<jdoc:include type="message" />', 'classes' => ' oba-messages'));
  echo '<jdoc:include type="component" />';?>

      <!-- BEGIN SPECIAL -->
      <?php if ($view->containsModules('special')) : ?>
     <section class="special">
        <div class="container4">

          <h2 class="section-title">What is Your Next Travel Destination ?</h2>

          <div class="section-row">
              
              <?php echo $view->position('special', 'oba-nostyle'); ?>


            <!--<div class="special__banner">

              <a href="/index.php?option=com_content&view=article&id=3">

                <img src="<?php //echo $templateUrl; ?>/img/special-banner.png" alt="">

                <p>Click to read our E-Brochure</p>

              </a>

            </div>-->

          </div>

        </div>
        <!-- <div class="container container5">

              <h2 class="section-title">Latest News</h2>

              <div class="section-row">


                  <div class="special__banner">

				      <?php //echo $view->position('blog', 'oba-nostyle'); ?>

                  </div>

                  <div class="special__banner">

              <a href="/index.php?option=com_content&view=article&id=3">

                <img src="<?php echo $templateUrl; ?>/img/special-banner.png" alt="">

                <p>Click to read our E-Brochure</p>

              </a>

            </div>

              </div>

          </div>-->
      </section>
      <?php endif; ?>
      <!-- END SPECIAL -->

  
 
  
      <!-- BEGIN BESTS -->
      <?php if ($view->containsModules('bests')) : ?>
       <section class="bests">
          <h2 class="section-title">Custom Made Tours</h2>
          <div class="section-row">
              <?php echo $view->position('bests', 'oba-nostyle'); ?> 
          </div>
      </section>
      <?php endif; ?>
      <!-- END BESTS -->

  
 
      <!-- BEGIN TRAVEL -->
     <!-- <?php //if ($view->containsModules('tips')) : ?>
      <section class="travel">

        <div class="container">

          <h2 class="section-title">Travel News and Tips</h2>

          <div class="section-row">

<?php //echo $view->position('tips', 'oba-nostyle'); ?> 
            
            
            <div class="travel__item">


                 <img class="jbimage tips_671_d640f005-8da7-47d9-85e9-18882f82d59f" alt="Russian Events Calendar" title="Russian Events Calendar" src="/images/russian_events_calendar_1_1e4ed3c0c3c23daf566767b119c031b2.jpg" width="268" height="191" data-template="default"> 
                             
                <h3 class="travel__title"> <a title="Russian Events Calendar" href="/calendar">Russian Events Calendar</a> </h3>
                            

                <a href="/calendar">Look more<img src="/templates/ir/img/arr-right.png" alt=""></a>
            </div>
            
            
            
            <div class="travel__item">


                 <img class="jbimage tips_671_d640f005-8da7-47d9-85e9-18882f82d59f" alt="Blog" title="Our blog" src="media/zoo/images/baikalsee_img_3250_fw___x_75fcacca23a5a6691d6a341a6488e818.jpg" width="268" height="191" data-template="default"> 
                             
                <h3 class="travel__title"> <a title="Our blog" href="/blog">Our blog</a> </h3>
                            

                <a href="/blog">Look more<img src="/templates/ir/img/arr-right.png" alt=""></a>
            </div>
            
            
            

          </div>

        </div>

      </section>
      <?php //endif; ?>
      <!-- END TRAVEL -->

  
  
      <!-- BEGIN REVIEWS -->
      <!--<?php //if ($view->containsModules('reviews')) : ?>
      <section class="reviews">

        <div class="container">

          <h2 class="section-title  section-title--blue">What Our Clients Say</h2>
          
          <?php //echo $view->position('reviews', 'oba-nostyle'); ?> 

          

        </div>

      </section>
      <?php //endif; ?>
      <!-- END REVIEWS -->

      <!-- BEGIN MAPS -->
      <?php if ($view->containsModules('map1', 'map2', 'map3', 'map4', 'map5')) : ?>
      <div class="maps">

        <h2 class="section-title ">Browse by Highlights</h2>


          <?php if ($view->containsModules('map1')) : ?><div id="maps1"><?php echo $view->position('map1', 'oba-nostyle'); ?> </div><?php endif; ?>
          <!--<div class="maps__tabs">

            <span class="maps__txt">Choose destination</span>

            <ul>
              <?php if ($view->containsModules('map1')) : ?><li><a href="#tabs-1">City Breaks</a></li><?php endif; ?>
              <?php if ($view->containsModules('map2')) : ?><li><a href="#tabs-2">Trans-Siberian Russian</a></li><?php endif; ?>
              <?php if ($view->containsModules('map3')) : ?><li><a href="#tabs-3">River Cruises</a></li><?php endif; ?>
              <?php if ($view->containsModules('map4')) : ?><li><a href="#tabs-4">Adventure & Discovery</a></li><?php endif; ?>
              <?php if ($view->containsModules('map5')) : ?><li><a href="#tabs-5">Visa Free Tours</a></li><?php endif; ?>

            </ul>


            <?php if ($view->containsModules('map1')) : ?><div id="tabs-1"><?php echo $view->position('map1', 'oba-nostyle'); ?> </div><?php endif; ?>

            <?php if ($view->containsModules('map2')) : ?><div id="tabs-2"><?php echo $view->position('map2', 'oba-nostyle'); ?></div><?php endif; ?>

            <?php if ($view->containsModules('map3')) : ?><div id="tabs-3"><?php echo $view->position('map3', 'oba-nostyle'); ?></div><?php endif; ?>

            <?php if ($view->containsModules('map4')) : ?><div id="tabs-4"><?php echo $view->position('map4', 'oba-nostyle'); ?></div><?php endif; ?>

            <?php if ($view->containsModules('map5')) : ?><div id="tabs-5"><?php echo $view->position('map5', 'oba-nostyle'); ?></div><?php endif; ?>

          </div>-->


      </div>
      <?php endif; ?>
      <!-- END MAPS -->

      <!-- BEGIN SUBSCRIBE -->
      <?php if ($view->containsModules('subscribe')) : ?>
      <section class="subscribe">
        <!-- <h2 class="section-title  section-title--subscribe">Feel Russia</h2>-->
        <!--   <p class="subscribe__desc">Find out why now is such an excellent time to visit this enchanting country:</p>-->
        <div class="clearfix">
        <!--   <div class="video">

             <span style="vertical-align: bottom; width: 100%; height: 240px;"><div class="custom-facebook-video">
               
               </div></span>

            </div>-->
          <?php echo $view->position('subscribe', 'oba-nostyle'); ?>
        </div>
      </section>
      <?php endif; ?>
      <!-- END SUBSCRIBE -->

      </div>

    </main>



    <footer class="footer">

      <div class="container">

        <div class="footerbar  clearfix">

          <div class="footer__logos  clearfix">

            <a href="/"><img src="<?php echo $templateUrl; ?>/img/logo-footer.png" alt=""></a>

            <ul class="logo-list">

              <li><img src="<?php echo $templateUrl; ?>/img/logo-iata.png" alt=""></li>
              <li><img src="<?php echo $templateUrl; ?>/img/logo-atol.png" alt=""></li>
              <li><img src="<?php echo $templateUrl; ?>/img/logo-abta.png" alt=""></li>

            </ul>
              <a href="https://www.facebook.com/intorussiatravel" target="_blank"><img class="socico" src="<?php echo $templateUrl; ?>/img/fb.png" alt=""></a>
              <a href="http://www.discoverwildlife.com/discover-your-planet-feature" target="_blank"><img class="wildfire" src="<?php echo $templateUrl; ?>/img/logo-wildlife-large-trans.png" alt="" style="padding-bottom: 13px;"></a>

          </div>


          <nav class="footer__menu">

            <?php echo $view->position('footer1'); ?>
           

          </nav>


          <div class="footer__office">

            <h3 class="footer__title">Booking Centers </h3>

           

            <div class="clearfix">

              <div class="office__left">

                <p class="link-label">Tel:</p>
                <a href="tel:+4402076035045">+44 (0) 207 603 5045 (UK)</a><br>
                <a href="tel:+4402076035045">+1 437 700 9339 (CANADA, US)</a><br>
<a href="tel:+79688226325">+7 968 822 6325 (RUSSIA)</a>
              </div>


              <div class="office__right">

                

              </div>

            </div>

            <p class="link-label">Booking Enquiries:</p>
            <a href="mailto:info@into-world-travel.com">info@into-world-travel.com</a>


            <div class="clearfix">

              


              

            </div>

          </div>

        </div>


        <div class="bottom">

          <p>Copyright &copy; Into World Travel Ltd. All Rights Reserved.</p>

        </div>

      </div>

    </footer>

    <!--<script src="<?php echo $templateUrl; ?>/js/jquery.min.js"></script>-->
    <script src="<?php echo $templateUrl; ?>/js/jquery-ui.min.js"></script>
    <script src="<?php echo $templateUrl; ?>/js/slick.js"></script>
    <script src="<?php echo $templateUrl; ?>/js/scripts.js"></script>

 

<?php echo $view->position('debug'); ?>
  <!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'WekCipvABc';var d=document;var w=window;function l(){
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->
  <script type="text/javascript">
jQuery(window).one("scroll", function() {
jQuery(".custom-facebook-video").load("<?php echo $templateUrl; ?>/facebook-video.html");
});
</script>  
</body>
</html>

