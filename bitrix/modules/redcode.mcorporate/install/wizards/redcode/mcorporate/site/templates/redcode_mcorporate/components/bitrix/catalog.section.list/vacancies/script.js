jQuery(function(){
	"use strict";

	if($(window).width() <= 883)
	{
		$(".vacancies").on("click", ".VE_accordion", function(){
			var $this = $(this);
			($this.hasClass("open") ? $this.removeClass("open") : $this.addClass("open"));

			$(".text[data-text='"+$(this).attr("data-toggle")+"']").slideToggle();
		});
	}
	else
	{
		$(".vacancies").on("click", ".name", function(){
			var parentBlock = $(this).parent();
			(parentBlock.hasClass("open") ? parentBlock.removeClass("open") : parentBlock.addClass("open"));

			$(".text[data-text='"+$(this).attr("data-toggle")+"']").slideToggle();
		});
	}

});