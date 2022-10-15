/**
 * Created by Raven on 27.12.15.
 */
$(document).ready(function(){

	var btn = $('.js-buy-btn'),
		size_list = $('select[name="SKU_SIZE"]'),
		q_in = $('.js-q');

	size_list.on('selectric-change', function(e){

		var v = $(this).val(),
			m = 1;

		if(v > 0){
			q_in.data('max', $(this).find('option[value="'+v+'"]').data('max'));
			btn.data('id', v);
		}


	});

	q_in.on('change', function(e){
		var v = parseInt($(this).val()),
			m = parseInt($(this).data('max'));

		if(isNaN(m) || m < 1){
			m = 1;
		}

		if(isNaN(v)){
			q_in.val(1);
		}

		if(v > m){
			q_in.val(m);
		}

	});

    btn.click(function(e){

            e.preventDefault();
            
      		//$(this).parent().parent().append('<img src="/images/preload.gif" alt="" class="preload" />');

            //bigdata support
            var rcm_in = $('.js-rcm-param');
            
            if(rcm_in.length > 0 && items[0]['id'] == rcm_in.data('id')){
	            $.post(rcm_in.val(), {ajax_basket:'Y', rcm:'yes'}, function(){
		            $('.preload').remove();
		            $('.good_add_cart').show();
		            $.get('/local/tools/basket.php', {ajax: 'Y', calc: 'Y'}, function(out){
			            if(out.STATUS == 'SUCCESS'){
		                    $('.js-cart-count').html('<b>'+out.COUNT+'<b>');
		                }
		            }, 'json');
	            }, 'text');
            }     

            else{
		        	$.ajax({
		                type: "GET",
		                url: '/local/tools/basket.php',
		                data: {
		                    products: [{
								id: btn.data('id'),
								q: parseInt(q_in.val()) > 0 ? q_in.val() : 1
							}],
		                    ajax: 'Y'
		                },
		                dataType: "json",
		                success: function(out){

		                        $('.js-cart-count').html('<b>'+out.CART_COUNT+'<b>');
		                        $('.js-fav-count').html('<b>'+out.DELAY_COUNT+'<b>');

		                    $('.preload').remove();
		                    $('.add-cart').show();
		
							q_in.val(0);
		                }
	            	});    
            }
            
           
        }
    );

	$('.hide-success').on('click', function(e){
		$('.add-cart').fadeOut('slow');
		e.preventDefault();
	});
});