$(document).ready(function(){
	$('.js-filter-pict').on('change', function(e){
		var _i = $(this);
		//console.log(_i.is(':checked'));	
		if(!_i.is(':checked')) 
			$('<input name="NOT_PICTURE_ONLY" value="1" type="hidden" class="js-filter-pict-hid">').insertAfter(_i);
		else
			_i.parents('form').find('.js-filter-pict-hid').remove();	
	});
});