;(function($) {

	"use strict"; // mode ES5
	
/*	==========================================================================
	When document is ready, do
	========================================================================== */
	
	$(document).ready(function(){
		
		$(window).scroll(function(){
			ProcessScrollWindow('scroll');
		});
		document.addEventListener('touchmove', function(){
			ProcessScrollWindow('touchmove');
		});
	});
		
})(window.jQuery);

function ProcessScrollWindow(event_name){
	var scroll = $(window).scrollTop(),
		header_height = $('.header').not('.is_stuck').outerHeight();
	
		console.log(event_name + ' ' + header_height);	
		if (scroll >= header_height) {
			
			if($('.is_stuck').length < 1)
				$('.header').clone().addClass('is_stuck').prependTo('.main .all');
			
			$('.is_stuck').show();
		}
		else{
			$('.is_stuck').hide(); 
			//$('.is_stuck').remove();
			
		}	
}


// non jQuery scripts below
var a = 120;
$(document).ready(function(){
	a = 98; 
});

console.log(a);