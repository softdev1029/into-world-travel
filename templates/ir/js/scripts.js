jQuery(function () {

  jQuery('.language-select span').click(function () {
    jQuery('.language-list').slideToggle();
  });

  jQuery('.currency-select span').click(function () {
    jQuery('.currency-list').slideToggle();
  });

  //var bgPuth = jQuery('.banner img').attr('src');
  //jQuery('.banner').css({
  //  backgroundImage: 'url(' + bgPuth + ')'
  //});
  
  jQuery('.banner__carousel').slick({
    dots: false,
    infinite: true,
    speed: 1000,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 4000
  });
  
   jQuery('.reviews__carousel').slick({
    dots: true,
    infinite: true,
    nextArrow: '<div class="next"><span>Next</span> <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></div>',
    prevArrow: '<div class="prev"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> <span>Previous</span></div>',
    speed: 600,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: false
  });
  
  jQuery('.maps__tabs').tabs();

});
