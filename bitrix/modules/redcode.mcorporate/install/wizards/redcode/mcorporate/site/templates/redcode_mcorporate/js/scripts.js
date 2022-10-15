jQuery(function($) {

	"use strict";

	/* SHOW MORE FOR (NEWS, ARTICLES AND SHARES) */
	$(".showMoreButton").on("click", function(event){
		event.preventDefault();
		
		var $pageNews = $(".pageNews"),
			$showMore = $(this);
		
		$.ajax({
			url: site_dir + "dev/moreNews.php",
			type: "post",
			dataType: "html",
			data: $pageNews[0].dataset,
			beforeSend: function(){
				$showMore.addClass("fade");
				$(".moreAnimation").css({"display": "block"});
			},
			success: function(data){
				$pageNews.attr("data-page", Number($pageNews.attr("data-page")) + 1);
				
				if(Number($pageNews.attr("data-page")) >= Number($pageNews.attr("data-pageEnd")))
					$showMore.parent().fadeOut();

				$(".allNews").append(data);
				$showMore.removeClass("fade");
				$(".moreAnimation").css({"display": "none"});
			},
			error: function(textStatus){
				console.log(textStatus);
			}
		});
	});
	
	/* OPEN / CLOSE BUTTONS SHARE */
	var flip = 0;
	$(".leftShareButton", ".leftShare").on("click", function(){
		$(".modalShare").toggle(flip++ % 2 === 0);
	});
	
	/* OPENING / CLOSING CONTACTS ON THE CARD */
	$(".mapContacts", ".map").on("click", function(){
		var $this = $(this);
		
		($this.hasClass("open") ? $this.removeClass("open") : $this.addClass("open"));
	});
	
	/* ON / OFF CHECKED PERSONAL INFO */
	$(".personalInfo").on("click", "label", function(event){
		if(event.target.nodeName != "A")
		{
			var $this = $(this);
			
			if($this.hasClass("ckecked"))
				$this.removeClass("ckecked");
			else
			{
				$this.addClass("ckecked");
				$(".checkboxError").css({"display": "none"});
			}
		}
	});

	
/*------------------------
--- MODAL WINDOWS ---
------------------------*/
	
	/* Adding classes (styles) if INPUT or DIV.MESSAGEFIELD is not empty */
	$(".inputField, .messageField").on("focus", function(){
		var $parent = $(this).parent();
		
		if(!$parent.hasClass("changeInput"))
			$parent.addClass("changeInput").css({"margin-bottom": "-=" + 1});
	});	

	$(".inputField, .messageField").on("focusout", function(){
		var $this = $(this),
			$parent = $this.parent();

		if($this.val() != "" || $this.text() != "")
			$parent.addClass("changeInput");
		else
		{
			$parent.removeClass("changeInput").css({"margin-bottom": "+=" + 1});
			$("span", $parent).html("");
		}
	});
	

	var $header = $("header"),
		$blackBack = $("#blackBack"),
		$body = $("body");


	/* CLOSING MODAL BLOCKS */
	$(".modalClose").on("click", function(){
		var $this = $(this);
		
		setTimeout(function()
		{
			$header.css({"right": ""});
			$blackBack.css({"display": "none"});
			$this.parents(".sendForm").css({"right": "", "display": "none"});
			$body.removeClass("modalOpen").attr("style", "");
		}, 150);
	});


	/* OPENING MODAL BLOCKS */
	$(".modalButton").on("click", function(){	
		var $this = $(this),
			$modalBlock = $("form[data-form="+ $this.attr("data-id") +"]");

		if($this.attr("data-name") != "")
			$("input[name='nameElement']", $modalBlock).val($this.attr("data-name"));

		setTimeout(function()
		{
			$header.css({"right": "17px"});
			$blackBack.css({"display": "block"});
			$modalBlock.css({"display": "block"});
			$body.addClass("modalOpen");
			
			if($(window).height() >= $modalBlock.children().outerHeight(true))
				$modalBlock.css({"right": "17px"});
			
			if($(window).height() < $body.height())
				$body.css({"paddingRight": "17px"});
		}, 150);	
	});


	/* SITE FOLDER */
	var site_dir = $("#siteDir").attr("data-dir");

	
	/* SEND ALL TYPES OF MESSAGES */
	$(".sendForm").on("submit", function(event)
	{
		event.preventDefault();
		
		var error = false,
			$modalName = $(this),
			$submit = $(".modalSend", $modalName),
			urlForForm = "dev/"+ $modalName.attr("data-form") +".php",
			objectInput = {"fileID": Number($(".fileID").text()), "userText": $(".messageField", $modalName).html()},
			modalInput = $modalName.find(":input");
			
		if($(".logo").length)
			objectInput["urlImg"] = $(".logo img").attr("src");
		else
			objectInput["urlImg"] = $(".logo_detail img").attr("src");

		modalInput.each(function(){
			var $input = $(this),
				inputParent = $input.parent();

			if($input.prop("required"))
			{
				if(!$input.val())
				{
					inputParent.addClass("errorInput");
					error = true;
				}
				if($input.attr("name") == "userEmail")
				{
					var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
					if(!pattern.test($input.val()))
					{
						inputParent.addClass("errorInput");
						error = true;
					}
				}
			}
			if($input.attr("type") == "checkbox")
			{
				if(!$input.is(":checked"))
				{
					$(".checkboxError").css({"display": "block"});
					error = true;
				}
			}
			
			objectInput[$input.attr("name")] = $input.val();
		});

		if(!error)
		{
			$.ajax({
				url: site_dir + urlForForm,
				type: "post",
				dataType: "html",
				data: objectInput,
				beforeSend: function(){
					$(".buttonAnimation", $modalName).addClass("active");
				},
				success: function()
				{
					setTimeout(function(){
						$(".buttonAnimation", $modalName).removeClass("active").addClass("send");
					}, 1500);
					setTimeout(function(){
						if($modalName.attr("data-form") === "sendSummary")
							$submit.addClass("disabled").attr("disabled", true).val($submit.attr("data-file"));
						else
							$submit.val($submit.attr("data-text"));
						
						$(".buttonAnimation", $modalName).removeClass("send");
					}, 3500);
					
					$("input:not([type='hidden'])", $modalName).val("").removeAttr("checked");
					$(".personalInfo label", $modalName).removeClass("ckecked");
					$(".fileForm span, .messageField", $modalName).text("");	
					$modalName.find(".changeInput").removeClass("changeInput").css({"borderBottomWidth": "1px", "margin-bottom": "+=" + 1});
				},
				error: function(textStatus)
				{
					console.log(textStatus);
				}
			});
		}

	});


	/* SAVING FILE */
	$(".sendForm").on("change", "input[type='file']", function()
	{
		var maxFileSize = 4 * 1024 * 1024, // THE MAXIMUM FILE SIZE IS - 4Mb
			file = this.files[0],
			$modalName = $(this).parents(".sendForm"),
			$inputParent = $(this).parent(),
			$submit = $(".modalSend", $modalName);
		
		if(typeof file === "undefined" || file.size > maxFileSize)
		{
			$inputParent.addClass("changeInput");
			$(".fileForm span", $modalName).text("Max file size 4Mb");
			$submit.addClass("disabled").attr("disabled", true).val($submit.attr("data-file"));
			return false;
		}
		
		var fileArray = this.files;
		var data = new FormData();
		$.each(fileArray, function(key, value){
			data.append(key, value);
		});

		$.ajax({
			url: site_dir + "dev/saveFile.php",
			type: "post",
			dataType: "json",
			processData: false,
			contentType: false,
			data: data,
			beforeSend: function(){
				$(".buttonAnimation", $modalName).addClass("active");
			},
			success: function(data)
			{
				$(".fileID").html(data[0]);
				$submit.removeClass("disabled").attr("disabled", false).val($submit.attr("data-text"));
				$(".buttonAnimation", $modalName).removeClass("active");
				$(".fileForm span", $modalName).text(data[1]);
				$inputParent.addClass("changeInput");
			},
			error: function(textStatus)
			{
				console.log(textStatus);
			}
		});
	});

/*------------------------
--- MODAL WINDOWS ---
------------------------*/


/*------------------------
--- DIFFERENT SETTINGS ---
------------------------*/
	
	var headerMenu = document.querySelector(".headerMenu"),
		topSearch = document.getElementById("topSearch");

	if(typeof headerMenu !== "undefined" && headerMenu !== null)
	{
		var parentHeaderMenu = headerMenu.parentNode;
		if(!parentHeaderMenu.hasAttribute("class"))
		{
			parentHeaderMenu.style.float = "right";
			$("#topSearch").parent().css({"float": "right"});
		}
	}
	
	if(typeof topSearch !== "undefined" && topSearch !== null)
	{
		var parentTopSearch = topSearch.parentNode;
		if(!parentTopSearch.hasAttribute("class"))
		{
			parentTopSearch.style.float = "right";
		}
	}


	/* SCROLL TO THE TOP */
	var buttonTop = document.querySelector(".buttonPosition"),
		duration = 600;

	buttonTop.addEventListener("click", function() {

		var start = performance.now(),
			from = window.pageYOffset || document.documentElement.scrollTop,
			to = document.querySelector("body").getBoundingClientRect().top;

		requestAnimationFrame(function animate(time){
				var timePassed = time - start;
				
				if (timePassed > duration)
					timePassed = duration;
				
				window.scrollTo(0, from + to * timePassed / duration);

				if (timePassed < duration)
					requestAnimationFrame(animate);	
		});
	});

	addEventListener("scroll", function(){
		var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

		if(scrollTop > 400)
		{
			buttonTop.style.bottom = "31px";
			/*
			if(scrollTop > 600)
			{
				$buttonMenu.css({"bottom": "100px"});
				if(scrollTop > 850)
					$buttonSearch.css({"bottom": "159px"});
				else
					$buttonSearch.css({"bottom": "-61px"});
			}
			else
				$buttonMenu.css({"bottom": "-61px"});
			*/
		}
		else
		{
			buttonTop.style.bottom = "-61px";
			//$buttonMenu.css({"bottom": "-61px"});
			//$buttonSearch.css({"bottom": "-61px"});
		}
	});

/*------------------------
--- DIFFERENT SETTINGS ---
------------------------*/

});