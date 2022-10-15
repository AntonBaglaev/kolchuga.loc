jQuery(function(){
	"use strict";

	$(".fancybox").fancybox({
		openEffect	: "elastic",
		closeEffect	: "fade",
		helpers : {
			title : {
				type : "inside"
			}
		}
	});
	
	if(navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/iPad/i))
		$(".documentsElement a span").css({"display": "block"});
});