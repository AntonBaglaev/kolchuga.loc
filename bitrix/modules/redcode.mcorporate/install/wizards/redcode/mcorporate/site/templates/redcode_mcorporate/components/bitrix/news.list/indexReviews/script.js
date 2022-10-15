jQuery(function() {
	
	"use strict";

	var $owl = $("#carouselReviews"),
		number = 0,
		$reviewsDots = $(".indexReviews .reviewsDots");

	if($(document).width() < 801)
		var zIndex = 0;
	else
		var zIndex = 1;

	$owl.owlCarousel({
		items: 3,
		navText: ["&#xE5CB;", "&#xE5CC;"],
		navClass: ["materialIcons owl-prev", "materialIcons owl-next"],
		nav: true,
		loop: true,
		mouseDrag: false,
		touchDrag: false,
		smartSpeed: 550,
		dotsEach: true,
		dotsContainer: ".reviewsDots",
		responsive : {
			0 : {
				items : 1,
				autoHeight: true,
				onInitialized : carouselInitializedLess800,
			},		
			801 : {
				items : 3,
				onInitialized : carouselInitializedMore800,
			}
		}
	});
	
	$reviewsDots.css({"margin-left": "-" + $reviewsDots.innerWidth() / 2 +"px"});
	$(".indexReviews .owl-prev").css({"margin-right": $reviewsDots.innerWidth() + 35 +"px"});
	
	function carouselInitializedMore800()
	{
		$(".owl-item", $owl).each(function(){
			if($(this).hasClass("active"))
			{
				number++;
				if(number == 2)
					$(".item_reviews", this).addClass("active");
			}
		});
	}
	
	function carouselInitializedLess800()
	{
		$(".owl-item.active .item_reviews", $owl).addClass("active");
	}
	
	$owl.on("translated.owl.carousel", function(event){
		$(".owl-item", $owl).each(function(index){
			if(index == event.item.index + zIndex)
				$(".item_reviews", this).addClass("active");
		});
	});
	
	$owl.on("translate.owl.carousel", function(){
		$(".owl-item", $owl).each(function(){
			$(".item_reviews", this).removeClass("active");
		});
	});

});