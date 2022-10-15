$(function(){
	$('.alt_section').on('click', '.as_title', function(e){
		var objThis = $(this);
		var objParent = $(e.delegateTarget);

		if(objParent.hasClass('as_0')){
			objParent.removeClass('as_0').addClass('as_1');
		}else{
			objParent.removeClass('as_1').addClass('as_0');
		}

		
	});
});