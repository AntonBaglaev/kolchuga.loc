jQuery(function($){
	
	"use strict";	
	
	$.fn.partners = function (number = 4, newWidth = false)
	{
		var maxH = this.eq(0).innerHeight(),
			partnersLength = this.length,
			quantity = partnersLength - (partnersLength % number) - 1,
			borderLeft = partnersLength - (partnersLength % number),
			position = 0;

		if(newWidth)
			this.css({"border-bottom": "1px solid #e4e5e5"});

		$(".item_partners:gt("+ quantity +")").css({"border-bottom": "none"});
		
		if(partnersLength % number == 0)
		{
			$(".item_partners:gt("+ --number +")").css({"border-bottom": "none"});
			this.css({"border-left": "0", "width": ""});
		}
		
		if(borderLeft != partnersLength)
			$(".item_partners:eq("+ borderLeft +")").css({"border-left": "1px solid #e4e5e5", "width": this.innerWidth() + 1 + "px"});
		
		if(number == 4)
		{
			this.each(function(){
				var thisHeight = $(this).innerHeight();
				
				maxH = ( thisHeight > maxH ) ? thisHeight : maxH;
			});

			this.css({"height": maxH});

			this.each(function(){
				var $this = $(this);
				
				position = ($this.innerHeight() - $("img", $this).height() - parseInt($this.css("paddingBottom")) -  parseInt($this.css("paddingTop"))) / 2;
				$("img", $this).css({"margin-top": position +"px"});
			});
		}
	};
	
	var $blockPartners = $(".item_partners"),
		$window = $(window);
	
	$blockPartners.imagesLoaded(function() {
		if($window.width() <= 783)
			$blockPartners.partners(3, true);
		else
			$blockPartners.partners();
	});
	
	$window.on("resize", function(){
		if($window.width() <= 583)
			return false;
		
		if($window.width() <= 783)
			$blockPartners.partners(3, true);
		else
			$blockPartners.partners();
	});
});