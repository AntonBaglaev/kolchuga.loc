;(function($) {

	"use strict";

/*	==========================================================================
  	exists - Check if an element exists
  	========================================================================== */

	function exists(e) {
		return $(e).length > 0;
	}

/*	==========================================================================
	handleMobileMenu & showHideMobileMenu - navigation for header
	========================================================================== */

	var MOBILEBREAKPOINT = 767;
	function handleMobileMenu() {
		var $menu = $('.navbar__nav');
		if ($(window).width() > MOBILEBREAKPOINT) {
			$("#mobile-menu").hide();
			$(".mobile-menu-bar").removeClass("mobile-menu-opened").addClass("mobile-menu-closed");
		}
		else
		{
			if (!exists("#mobile-menu")) {
				$(".navbar__nav").clone().attr({
					"id": "mobile-menu",
					"class": "fixed"
				}).insertAfter(".header__middle");

				$("#mobile-menu > li > a, #mobile-menu > li > ul > li > a").each(function() {
					var $t = $(this);
					if ($t.next().is('ul')) {
						$t.append('<span class="icon-arrow-down3 mobile-menu-submenu-arrow mobile-menu-submenu-closed"></span>');
					}
				});
				$(".mobile-menu-submenu-arrow").click(function(event) {
					var $t = $(this);
					if ($t.hasClass("mobile-menu-submenu-closed")) {
						$t.parent().siblings("ul").slideDown(300);
						$t.removeClass("mobile-menu-submenu-closed icon-arrow-down3").addClass("mobile-menu-submenu-opened icon-arrow-up3");
					} else {
						$t.parent().siblings("ul").slideUp(300);
						$t.removeClass("mobile-menu-submenu-opened icon-arrow-up3").addClass("mobile-menu-submenu-closed icon-arrow-down3");
					}
					event.preventDefault();
				});
				$("#mobile-menu li, #mobile-menu li a, #mobile-menu ul").attr("style", "");
			}
		}
	}

	function showHideMobileMenu() {
		$(".mobile-menu-bar").click(function(event) {
			var $t = $(this);
			var $n = $("#mobile-menu");
			if ($t.hasClass("mobile-menu-opened")) {
				$t.removeClass("mobile-menu-opened").addClass("mobile-menu-closed");
				$n.slideUp(300);
			} else {
				$t.removeClass("mobile-menu-closed").addClass("mobile-menu-opened");
				$n.slideDown(300);
			}
			event.preventDefault();
		});
	}

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
				closeMarkup:'<button title="%title%" class="mfp-close"><span class="icon-close"></span></button>'
			});
		}
	}

	function mH(){
		$('.js-mh').matchHeight();
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
			$('input').iCheck();
			handleMobileMenu();
			showHideMobileMenu();
			mH();
			$('.b-filter__name').click(function(){
				$.fn.matchHeight._update($('.js-mh'));
			});
			$('.search-toggle').click(function(){
				$(this).parent().find('form').toggleClass('open');
			});

		});

/*	=========================================================================
	When the window is resized, do
	========================================================================== */

		$(window).resize(function() {

			handleMobileMenu();

		});

})(window.jQuery);
// non jQuery scripts below
