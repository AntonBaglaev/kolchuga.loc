jQuery(function() {
	"use strict";

	var $switchOptions = $("#switchOptions"),
		$buttonsColor = $("#buttonsColor");
	
	$("#switchButton").on("click", function(){
		($switchOptions.hasClass("animated")) ? $switchOptions.removeClass("animated") : $switchOptions.addClass("animated"); 
	});
	
	$buttonsColor.on("click", "div", function(){
		$("div", $buttonsColor).removeClass("active").css({"border-color": ""});
		$(this).addClass("active").css({"border-color": $("span", this).css("backgroundColor")});
		
		$("input[name='COLOR']", $switchOptions).val($(this).attr("data-key"));
		
		addStyleSheets($buttonsColor.attr("data-href")+ "/themes/" + $(this).attr("data-key") + "/style.css");
		
		if(typeof initMap === "function")
			initMap($buttonsColor.attr("data-href")+ "/themes/" + $(this).attr("data-key") + "/images/" + $(this).attr("data-key") + ".png");
	});
	
	$("form", $switchOptions).on("submit", function(){
		var modalInput = $(this).find(":input"),
			objectInput = {};
			
		modalInput.each(function(){
			var $input = $(this);
			
			objectInput[$input.attr("name")] = $input.val();
		});
		
		$.cookie("COOKIE_OPTIONS", JSON.stringify(objectInput), {expires: 30, path: "/"});
	});


	/* switch checkbox on/off */
	var $checkboxSwitchButton = $(".checkboxSwitchButton");
	
	$checkboxSwitchButton.on("click", function(){
		var $checkbox = $("> input[type='checkbox']", $(this).parents(".element")),
			$checkboxSwitchBar = $(".checkboxSwitchBar");
		
		if($(this).hasClass("checked"))
			$checkboxSwitchButton.add($checkboxSwitchBar).removeClass("checked");
		else
			$checkboxSwitchButton.add($checkboxSwitchBar).addClass("checked");
		
		if($checkbox.is(":checked"))
			$checkbox.prop("checked", false).val("N");
		else
			$checkbox.prop("checked", true).val("Y");
	});


	function addStyleSheets(href)
	{
		var linkId = document.getElementById("linkColor");
		if(linkId)
		{
			linkId.href = href;
			return false;
		}

		var $head = document.head,
			$link = document.createElement("link");

		$link.rel = "stylesheet";
		$link.href = href;
		$link.id = "linkColor";

		$head.appendChild($link);
	}
});