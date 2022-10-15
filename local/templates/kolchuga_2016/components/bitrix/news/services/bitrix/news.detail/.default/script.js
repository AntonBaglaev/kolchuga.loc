$(document).ready(function () {    
	var fixed = false;
	
	if ($('.next_recomend').length) {

		var hcont=$('.next_recomend').outerHeight()  + 30; 
		var wcont=$('.next_recomend').outerWidth();
		/* var hcont_anchor=$('.anchor_next_recomend').outerHeight();	console.log(hcont_anchor);	
		var hosntext=$('.osntext').outerHeight();console.log(hosntext);	
		var raznica_hcont=hcont_anchor-hosntext;console.log(raznica_hcont);	
		if(raznica_hcont>1){hcont=hcont+raznica_hcont;}console.log(hcont);	
		var what_stop='foter';
		var ffff=$('.footer').offset().top;console.log(ffff);	
		var elementstop =$('.footer').offset().top - hcont;
		
		if($('.next_tovar').length>0){
			elementstop = $('.next_tovar').offset().top - hcont -30;
			what_stop='next_tovar';
		}else if($('.next_service').length>0){
			elementstop = $('.next_service').offset().top - hcont;
			what_stop='next_service';
		} */
        var action_top = $('.anchor_next_recomend').offset().top;
		
	var totop_rec = ( $('.next_recomend').offset().top + hcont );

	}

    $(window).scroll(function (event) {
		
		
       var st = $(document).scrollTop();
		/* 
		
		console.log(st+' -> '+elementstop+' -> '+action_top+' -> '+what_stop+' -- '+hcont);
		
        if (st > action_top) {
			if(elementstop>0 && st<elementstop && !fixed){
				$('.next_recomend').addClass('fixed').css({"width":wcont+"px"}); 
				fixed=true;
			}else if(elementstop<1 && !fixed){
				$('.next_recomend').addClass('fixed').css({"width":wcont+"px"}); 
				fixed=true;
			}else if(st>elementstop && fixed){
				$('.next_recomend').removeClass('fixed').css({"width":"auto"}); 
				fixed=false;
			}
        }
        else {
			if(fixed){
				$('.next_recomend').removeClass('fixed').css({"width":"auto"});
				fixed=false;
			}
        } */
		
		if($('.next_tovar').length>0){
			if (st > action_top) {
				if( (st + hcont) < $(".next_tovar").offset().top  ) {
					   if(!fixed){
							$('.next_recomend').addClass('fixed').css({"width":wcont+"px"}); 
							fixed=true;
					   }
				   }else{
					   $('.next_recomend').removeClass('fixed').css({"width":"auto"});
						fixed=false;
				   }
			}else{
			   $('.next_recomend').removeClass('fixed').css({"width":"auto"});
				fixed=false;
			}
		}else if($('.next_service').length>0){
			if (st > action_top) {
				if( (st + hcont) < $(".next_service").offset().top  ) {
					   if(!fixed){
							$('.next_recomend').addClass('fixed').css({"width":wcont+"px"}); 
							fixed=true;
					   }
				   }else{
					   $('.next_recomend').removeClass('fixed').css({"width":"auto"});
						fixed=false;
				   }
			}else{
			   $('.next_recomend').removeClass('fixed').css({"width":"auto"});
				fixed=false;
			}
		}else if($('.backtolist').length>0){
			if (st > action_top) {
				if( (st + hcont) < $(".backtolist").offset().top  ) {
					   if(!fixed){
							$('.next_recomend').addClass('fixed').css({"width":wcont+"px"}); 
							fixed=true;
					   }
				   }else{
					   $('.next_recomend').removeClass('fixed').css({"width":"auto"});
						fixed=false;
				   }
			}else{
			   $('.next_recomend').removeClass('fixed').css({"width":"auto"});
				fixed=false;
			}
		}else{
			if (st > action_top) {
				if( (st + hcont) < $(".footer").offset().top  ) {
					   if(!fixed){
							$('.next_recomend').addClass('fixed').css({"width":wcont+"px"}); 
							fixed=true;
					   }
				   }else{
					   $('.next_recomend').removeClass('fixed').css({"width":"auto"});
						fixed=false;
				   }
			}else{
			   $('.next_recomend').removeClass('fixed').css({"width":"auto"});
				fixed=false;
			}
		}
		
		/* if( totop_rec < $(".next_tovar").offset().top ) {
		   if (st > action_top) {
			   if($('.next_tovar').length>0){
				   if( (st + hcont + 30) < $(".next_tovar").offset().top  ) {
					   if(!fixed){
							$('.next_recomend').addClass('fixed').css({"width":wcont+"px"}); 
							fixed=true;
					   }
				   }else{
					   $('.next_recomend').removeClass('fixed').css({"width":"auto"});
						fixed=false;
				   }				   
			   }else if($('.next_service').length>0){
				   if( (st + hcont + 30) < $(".next_service").offset().top  ) {
					   if(!fixed){
							$('.next_recomend').addClass('fixed').css({"width":wcont+"px"}); 
							fixed=true;
					   }
				   }else{
					   $('.next_recomend').removeClass('fixed').css({"width":"auto"});
						fixed=false;
				   }
			   }else{
				   if( (st + hcont + 30) < $(".footer").offset().top  ) {
					   if(!fixed){
							$('.next_recomend').addClass('fixed').css({"width":wcont+"px"}); 
							fixed=true;
					   }
				   }else{
					   $('.next_recomend').removeClass('fixed').css({"width":"auto"});
						fixed=false;
				   }
			   }
		   }else{
			   $('.next_recomend').removeClass('fixed').css({"width":"auto"});
				fixed=false;
		   }
		}  */
    });
	
	/* $('.slider_set').owlCarousel({
            loop:true,
            items:4,
            margin:10,
            dots:false,
            nav:true,
            navText:['<span class="icon-arrow-left3"></span>','<span class="icon-arrow-right3"></span>'],
            responsive:{
                0:{
                    items:1
                },
                500:{
                    items:2
                },
                768:{
                    items:3
                },
                1024:{
                    items:4
                },
                1100:{
                    items:4
                }
            },
			
    
        }); */
		
		
		if (window.frameCacheVars !== undefined) 
		{
			BX.addCustomEvent("onFrameDataReceived" , function(json) {
				var owlbrand = $('.slider_set');  
			   if (owlbrand.length > 0)
			   {
					owlbrand.owlCarousel({
						loop:true,
						items:4,
						margin:10,
						dots:false,
						nav:true,
						navText:['<span class="icon-arrow-left3"></span>','<span class="icon-arrow-right3"></span>'],
						responsiveClass:true,
						responsive:{
							0:{
								items:1
							},
							500:{
								items:2
							},
							768:{
								items:3
							},
							1024:{
								items:4
							},
							1100:{
								items:4
							}
						}
					});
			   }
			});
		} else {
			BX.ready(function() {
				var owlbrand = $('.slider_set');  
				if (owlbrand.length > 0)
				   {
						owlbrand.owlCarousel({
							loop:true,
							items:4,
							margin:10,
							dots:false,
							nav:true,
							navText:['<span class="icon-arrow-left3"></span>','<span class="icon-arrow-right3"></span>'],
							responsiveClass:true,
							responsive:{
								0:{
									items:1
								},
								500:{
									items:2
								},
								768:{
									items:3
								},
								1024:{
									items:4
								},
								1100:{
									items:4
								}
							}
						});
				   }
			});
		}
		
		
})