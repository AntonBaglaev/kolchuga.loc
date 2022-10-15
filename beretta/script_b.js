$(document).ready(function(){
	$(window).scroll(function(){
		$navs = $('.block_bereta_baner');
		$h = $navs.offset().top;
	
		if($(this).scrollTop()>$h){
			$('.block_bereta_info').addClass('menufixed');
		}else if ($(this).scrollTop()<$h){
			$('.block_bereta_info').removeClass('menufixed');
		}
	});
	$('.fancybox').fancybox();
});