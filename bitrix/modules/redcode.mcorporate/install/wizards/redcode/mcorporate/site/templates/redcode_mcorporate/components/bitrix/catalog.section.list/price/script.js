document.addEventListener("DOMContentLoaded", function() {
	
	"use strict";
	
	var $priceMenu = $(".priceMenu");
	
	$priceMenu.on("click", "li", function(){
		$("li", $priceMenu).removeClass("selected");
		$(this).addClass("selected");
		$("html, body").stop().animate({scrollTop: $(".priceSection[data-number='"+ $(this).attr("data-number") +"']").offset().top}, 500);
	});
	
	$(".blockPrice").on("click", "h2", function(){
		$("+ .priceElements", this).slideToggle();
		($(this).hasClass("rotate") ? $(this).removeClass("rotate") : $(this).addClass("rotate"));
	});

});