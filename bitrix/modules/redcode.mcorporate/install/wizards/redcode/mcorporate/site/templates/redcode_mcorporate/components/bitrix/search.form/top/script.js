jQuery(function(){

	"use strict";
	
	/* Search open/close */
	$("#topSearch, .buttonSearch").on("click", function(){
		setTimeout(function(){
			$("#blackBack, .modalSearch").css({"display": "block"});
		}, 150);
	});

	$(".searchCross").on("click", function(){
		setTimeout(function(){
			$("#blackBack, .modalSearch").css({"display": "none"});
		}, 150);
	});
	
});