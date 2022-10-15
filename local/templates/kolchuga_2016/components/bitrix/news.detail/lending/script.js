;(function($){

    $(document).ready(function(){
		$('.js_fx_slider').flexslider({
			animation: "slide",
			slideshow: false,
			slideshowSpeed: 5000,
			animationSpeed: 700,
			prevText: "",
			nextText: "",
			controlNav: false,
			directionNav: true,
		});
	});
	$(document).on('click', '.js-popup-modal-store', function(){
		var tovar_id = $(this).attr('data-code');
		$('.form_hidden_listid').attr('value',tovar_id);
		$.post('/local/tools/list_store_byid.php', { 'product': tovar_id, '__ajax':'Y'}, function(data){                
                    $('#modal-buyoneclick-list .select_store_list').html(data);
					$('select').selectric({
						arrowButtonMarkup:'<b class="icon-arrow-down"></b>',
						disableOnMobile:false,
						maxHeight:'200'
					});
            });
	});	
    

}(jQuery));