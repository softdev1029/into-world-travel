jQuery(function($) {
	show_country = function (selector) {
		var self = this;
		self.slct = $(selector);
		self.info = $('.data-country');
		self.popup = null;
		cur_cur = $.cookie('cur_country');
		var c_close = (cur_cur != null)?1:0;
		
		self.bild_form = function(){
			var cname = self.info.attr('data-nlonge').split(','),
					ccur = self.info.attr('data-nshort').split(','),
					cdata = '';
					ci = cname.length;
			cdata += '<div class="ccform_overlay"></div>'
			cdata += '<div class="ccform">';
			cdata += '<div class="ccform_close" data-ccform-close="">×</div>';
			cdata += '<div class="ccform_title">Choose your country</div>';
			cdata += '<div class="ccform_data">';	
			for (i = 0; i < ci; i++){
				cdata += '<a href="#" data-cur="'+ ccur[i] +'" class="ccform_link">'
							+'<img src="/modules/mod_select_country/images/'+ccur[i]+'.png"><span>'+ cname[i] +'</span>'
							+'</a>';
			}		
			cdata += '</div></div>';
			$('body').prepend(cdata);
			self.popup = $('.ccform');
		}		
		self.bild_form();
		self.form_show = function(){
      $('.ccform_overlay').show();
			var modalWindowHeight  = self.popup.innerHeight();
			self.popup.fadeIn();
			self.popup.animate({
          top: $(window).scrollTop() + ($(window).height() - modalWindowHeight)/2
      });
		}
		self.flag = function () {
				self.info.html('<a href="#" data-ccform-open title="Choose your country"><img src="/modules/mod_select_country/images/'+self.slct.val()+'.png">');
		};

		self.slct.on('change',function(){
			self.flag();
		})

		$(document).on('click', '[data-ccform-close]', function() {
            self.popup.hide();
            $('.ccform_overlay').hide();
            return false;
    });

		self.info.on('click', '[data-ccform-open]', function() {
            self.form_show();
            return false;
    });

		self.popup.find('.ccform_link').on('click', function () {
			link_attr = $(this).attr('data-cur');
			self.slct.val(link_attr).change();
			$.cookie('cur_country',link_attr);
			self.popup.hide();
			$('.ccform_overlay').hide();
			return false;
		});

		self.flag();

		if (!c_close){
      self.form_show();
		}
		$(window).scroll(function(){
			if($('.ccform_overlay').is(":visible")){
				var modalWindowHeight  = self.popup.innerHeight();
				self.popup.css('top',$(window).scrollTop() + ($(window).height() - modalWindowHeight)/2);
				
			}
		})
	};
});