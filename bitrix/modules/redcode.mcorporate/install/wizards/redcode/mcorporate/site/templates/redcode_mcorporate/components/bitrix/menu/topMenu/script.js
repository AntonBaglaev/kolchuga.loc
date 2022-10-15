jQuery(function(){
	"use strict";

	var $body = $("body"),
		$modalMenu = $(".modalMenu"),
		$blackBack = $("#blackBack");
		
	$(".topMenu, .buttonMenu").on("click", function(){
		setTimeout(function()
		{
			$blackBack.css({"display": "block"});
			$modalMenu.addClass("fadeIn");
			$body.addClass("modalOpen");
			
			if($(window).height() < $body.height())
				$body.css({"paddingRight": "17px"});
		}, 150);
	});

	$(".closeMenu").on("click", function(){
		setTimeout(function()
		{
			$blackBack.css({"display": "none"});
			$modalMenu.removeClass("fadeIn");
			$body.removeClass("modalOpen").attr("style", "");
		}, 150);
	});
	
});