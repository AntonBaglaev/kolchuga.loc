;(function($) {

	"use strict";

/*	==========================================================================
	Accordion Menu
	========================================================================== */

	function accordionMenu(){
		$('accordion-menu .accordion-header').each(function(){
			$(this).append('<i></i>');
		});
		$('.accordion-header').click(function(e) {
			if($(this).is('.accordion-close')){
				$(this).removeClass('accordion-close');
				$(this).addClass('accordion-open');
				$(this).next().slideDown(300);
			}else{
				$(this).removeClass('accordion-open');
				$(this).addClass('accordion-close');
				$(this).next().slideUp(300);
			}
			e.preventDefault();
		});
	}

/*	==========================================================================
   	magnificPopup
   	========================================================================== */

	function magnific(){

		if(typeof $.fn.magnificPopup != 'undefined'){
			$('.popup').magnificPopup({
				type: 'image',
				tClose: 'Закрыть',
				closeMarkup:'<button title="%title%" class="mfp-close"><span class="icon-close"></span></button>',
				closeOnContentClick: true,
				closeBtnInside: true,
				fixedContentPos: true,
				mainClass: 'mfp-with-zoom mfp-fade',
				image: {
					markup:'<div class="mfp-figure">'+
					'<div class="mfp-close"></div>'+
					'<div class="mfp-img"></div>'+
					'<div class="mfp-bottom-bar">'+
					'<div class="mfp-title"></div>'+
					'<div class="mfp-counter"></div>'+
					'</div>'+
					'</div>',
					tError:'<a href="%url%">Изображение</a> не может быть загружено.',
					verticalFit: true
				}
			});
			$('.popup-gallery').each(function(){
				$(this).magnificPopup({
					delegate: 'a',
					type: 'image',
					tClose: 'Закрыть',
					closeMarkup:'<button title="%title%" class="mfp-close"><span class="icon-close"></span></button>',
					closeOnContentClick: true,
					closeBtnInside: true,
					fixedContentPos: true,
					mainClass: 'mfp-with-zoom mfp-fade',
					gallery: {
						enabled: true,
						navigateByImgClick: true,
						preload: [0,2],
						arrowMarkup: '<span title="%title%" class="mfp-arrows icon-arrow-%dir%"></span>',
						tPrev: 'Назад',
						tNext: 'Вперед',
						tCounter: '%total%'
					},
					image: {
						markup:'<div class="mfp-figure">'+
						'<div class="mfp-close"></div>'+
						'<div class="mfp-img"></div>'+
						'<div class="mfp-bottom-bar">'+
						'<div class="mfp-title"></div>'+
						//'<div class="mfp-counter"></div>'+
						'</div>'+
						'</div>',
						tError:'<a href="%url%">Изображение</a> не может быть загружено.',
						verticalFit: true
					},
					callbacks: {
						buildControls: function() {
							if(this.arrowLeft)
							{
								this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
							}
						}
				    }
				});
			});
			$('.popup-modal').magnificPopup({
				tClose: 'Закрыть',
				closeMarkup:'<button title="%title%" class="mfp-close"><span class="icon-close"></span></button>',
	            closeBtnInside: true
			});
			$(document).on('click', '.mfp-close', function (e) {
				e.preventDefault();
				$.magnificPopup.close();
			});
		}
	}

	function mH(){
		$('.js-mh').matchHeight();
	}
    function handler(e){
        e.preventDefault();
    }
/*	==========================================================================
	When document is ready, do
	========================================================================== */
 
	$(document).ready(function() {

		$(".tel").mask("+7(999) 999-9999");
		$('select').selectric({
			arrowButtonMarkup:'<b class="icon-arrow-down"></b>',
			disableOnMobile:false,
			maxHeight:'200'
		});
		magnific();
		accordionMenu();
		$('input:not(.no_check)').iCheck();
		mH();
		$('.b-filter__name').click(function(){
			$.fn.matchHeight._update($('.js-mh'));
		});
		$('.search-toggle').click(function(){
			$(this).parent().find('form').toggleClass('open');

			//if($(window).width()<=991){
				$("body").addClass("dis-scroll");
				var winH = $(window).height() - 45;
				$(this).parent().find('form').css("height",winH);
				document.body.addEventListener('touchmove', handler);
			//}
		});
		$('.form__search_close').click(function(event){
			event.preventDefault();
			$(this).parent('form').toggleClass('open');
			//if($(window).width()<=991) {
				$("body").removeClass("dis-scroll");
				$(this).parent().find('form').css("height", "initial");
				document.body.removeEventListener('touchmove', handler);
			//}
		});

		$('body')
			.on('click', '.label-help', function(){

				$(this).parents('form').find('.popover-box.popover-open').removeClass('popover-open');
				$(this).parents('.popover').find('.popover-box').addClass('popover-open');

			})
			.on('click', '.popover-close', function(e){

				$(this).parents('.popover').find('.popover-box').removeClass('popover-open');
				e.preventDefault();

			});

	});

})(window.jQuery);
// non jQuery scripts below
