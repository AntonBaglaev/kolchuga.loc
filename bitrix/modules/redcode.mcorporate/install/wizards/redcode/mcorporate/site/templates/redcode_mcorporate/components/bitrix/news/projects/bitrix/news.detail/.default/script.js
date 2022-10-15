jQuery(function(){

	"use strict";

	var $tabulation = $("#tabulation"),
		$slider = $("#slider"),
		$carousel = $("#carousel");

	$tabulation.on("click", "h2", function(){
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

	$(".fancybox").fancybox({
		openEffect	: "elastic",
		closeEffect	: "fade",
		helpers : {
			title : {
				type : "inside"
			}
		}
	});

	$slider.owlCarousel({
		items: 1,
		dots: false,
		mouseDrag: false,
		touchDrag: false,
		nav: true,
		navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
	});
	
	$carousel.owlCarousel({
		items: 5,
		navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
		nav: true,
		dots: false,
		margin: 15,
		responsive : {
			0 : {
				items : 2,
			},
			480 : {
				items : 3,
			},
			630 : {
				items : 4,
			},
			760 : {
				items : 5,
			},
			901 : {
				items : 4,
			},
			1060 : {
				items : 5,
			}
		}
	});
	
	$(".owl-item", $carousel).on("click", function(){
		$("img", $carousel).css({"opacity": ".6"});
		$("img", this).css({"opacity": "1"});
		$slider.trigger("to.owl.carousel", [$(this).index()]);
	});

	$slider.on("translate.owl.carousel", function(event){
		$("img", $carousel).css({"opacity": ".6"});
		$(".owl-item:eq("+ event.item.index +") img", $carousel).css({"opacity": "1"});
	});
});