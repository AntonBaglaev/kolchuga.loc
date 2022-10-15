jQuery(function(){

	"use strict";

	var tabulation = $("#tabulation");

	tabulation.on("click", "h2", function(){
		var $this = $(this);

		if(!$this.hasClass("active")){
			$("h2", tabulation).removeClass("active");
			$this.addClass("active");
		
			setTimeout(function(){
				$(".tabulationBody > div").css({"display": "none"});
				$("div[data-tab="+ $this.attr("data-tab") +"]", tabulation).css({"display": "block"});
			}, 150);
		}
	});

});