<!DOCTYPE HTML>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title>Сеть оружейных салонов "Кольчуга"</title>	<link href="/css/design_start.css" rel="stylesheet" type="text/css">
	<!--[if lte IE 7]>
		<link href="/css/design_ie.css" type="text/css" rel="stylesheet">
	<![endif]-->
	<script src="/js/jquery-1.8.1.js" type="text/javascript"></script>
	<!-- <script src="/js/jquery.jparallax.js" type="text/javascript"></script> -->
	<script src="/js/cufon-yui.js" type="text/javascript"></script>
	<script src="/js/adventure_400.font.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			
			/**/
			$('.block_center *').css('display','none');
			setTimeout(function() {
				$('.light').before('<div class="ut_bb"></div>');
			}, 0);
			setTimeout(function() {
				$('.light').before('<div class="ut_bbt"></div>');
			}, 900);
			setTimeout(function() {
				$('.light').before('<div class="pt_r1"></div>');
			}, 1390);			
			setTimeout(function() {
				$('.light').before('<div class="pt_l"></div>');
			}, 1630);
			setTimeout(function() {
				$('.light').before('<div class="grass_ll2"></div>');
			}, 2200);
			setTimeout(function() {$('.grass_lt_png, .grass_rt_png, .grass_lb_png, .pt_r2_png, .grass_ll_png, .grass_rb_png, .ut_l_png, .ut_b1, .ut_b2, .ut_b3, .ut_b4').fadeIn(1000);}, 3700);
			setTimeout(function() {$('.logo, .logo_text, .ru, .en, .discr').fadeIn(2000);}, 4500);
			Cufon.replace('.adventure', {hover: 'true'});
		});
		/*jQuery(document).ready(function(){
			$('.block_center .parallax-layer').parallax({
				yparallax: 0
			});
		});	*/	
	</script>
	<div class="container">
		<div class="block_center">
			<div class="bg_center"></div>
			<span class="light"></span>		
			<div class="grass_lt_png"></div>
			<div class="grass_rt_png"></div>
			<div class="grass_lb_png"></div>
			<div class="pt_r2_png"></div>
			<div class="ut_b1"></div>
			<div class="ut_b2"></div>
			<div class="ut_b3"></div>
			<div class="ut_b4"></div>
			<div class="grass_ll_png"></div>
			<div class="grass_rb_png"></div><div class="ut_l_png"></div>
			<a href="/" class="logo"></a><a href="/" class="logo_text"></a>
			<span class="adventure discr color_gray">Сеть оружейных салонов</span>
			<a href="/" class="ru color_blue adventure">русский</a><a href="/en/" class="en color_blue adventure">english</a>
		</div>
		
	</div>