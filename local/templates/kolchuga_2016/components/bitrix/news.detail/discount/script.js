$(document).ready(function () {    
	var fixed = false;
	
	 
		var hcont=$('.next_recomend').outerHeight();
		var hcont_anchor=$('.anchor_next_recomend').outerHeight();		
		var hosntext=$('.osntext').outerHeight();
		var raznica_hcont=hcont_anchor-hosntext;
		if(raznica_hcont>0){hcont=hcont+raznica_hcont;}
		var wcont=$('.next_recomend').outerWidth();
		var what_stop='foter';
		var elementstop =$('.footer').offset().top - hcont;
		
		if($('.next_tovar').length>0){
			elementstop = $('.next_tovar').offset().top - hcont -30;
			what_stop='next_tovar';
		}else if($('.next_service').length>0){
			elementstop = $('.next_service').offset().top - hcont;
			what_stop='next_service';
		}
        var action_top = $('.anchor_next_recomend').offset().top;
		
		
    $(window).scroll(function (event) {
		
		
       var st = $(document).scrollTop();
		
		
		//console.log(st+' -> '+elementstop+' -> '+action_top+' -> '+what_stop);
		
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
        }
 
 
    });
	
	$('.slider_set').owlCarousel({
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
			
    
        });
		
	$(document).on('click','span.element-razmer', function(){
		var dataSet = $(this).data();
		$('small.smallmetki'+ dataSet['bl'] + + dataSet['st'] + ' span').removeClass('thiselement');
		$(this).addClass('thiselement');
		$('#blockimetki'+ dataSet['bl'] + + dataSet['st']).val(dataSet['id']);		
	});
	
	$(document).on('click','a.addinbasket', function(){
		//var dataSet = $(this).parents('section').prop("classList");
		var dataSet = $(this).parents('section');
		var mmm=dataSet.find('form').serialize();
		$.ajax({
			type: "POST",
			url: "/ajax/landad.php",
			data: mmm,
			dataType: 'json',
			success: function(msg) {
				console.log(msg);
				if(msg.error=='Y'){
					dataSet.find('div.textresult').html(msg.error_text).addClass('error');
				}else{
					dataSet.find('div.textresult').html(msg.info).addClass('success');
				}
			}
		});
		console.log(mmm);
	});
})