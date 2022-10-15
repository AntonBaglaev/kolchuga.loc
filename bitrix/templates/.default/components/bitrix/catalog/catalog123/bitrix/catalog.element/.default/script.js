/**
 * Created by Raven on 27.12.15.
 */
$(document).ready(function(){

    $('.js-buy-btn').click(
        function(e){
            e.preventDefault();
            var btn = $(this),
                offers = $('.js-offers'),
                items = [];

            if(offers.length > 0){

                var items = [];
                offers.find('.js-row').each(function(){

                    var id = $(this).data('id'),
                        q = parseInt($(this).find('.js-q').val());

                    if(q > 0){
                        items.push({
                            id: id,
                            q: q
                        });
                    }
                });

                if(items.length < 1) return false;

            } else{

                items.push({
                    id: btn.data('id'),
                    q: 1
                });

            }
            
      		$(this).parent().parent().append('<img src="/images/preload.gif" alt="" class="preload" />');
      		      
            //bigdata support
            var rcm_in = $('.js-rcm-param');
            
            if(rcm_in.length > 0 && items[0]['id'] == rcm_in.data('id')){
	            $.post(rcm_in.val(), {ajax_basket:'Y', rcm:'yes'}, function(){
		            $('.preload').remove();
		            $('.good_add_cart').show();
		            $.get('/bitrix/templates/kolchuga/tools/basket.php', {ajax: 'Y', calc: 'Y'}, function(out){
			            if(out.STATUS == 'SUCCESS'){
		                    $('.js-cart-count').html('<b>'+out.COUNT+'<b>');
		                }
		            }, 'json');
	            }, 'text');
            }     

            else{
		        	$.ajax({
		                type: "GET",
		                url: '/bitrix/templates/kolchuga/tools/basket.php',
		                data: {
		                    products: items,
		                    ajax: 'Y'
		                },
		                dataType: "json",
		                success: function(out){
		                    if(out.STATUS == 'SUCCESS')
		                        $('.js-cart-count').html('<b>'+out.COUNT+'<b>');
		
		                    $('.preload').remove();
		                    $('.good_add_cart').show();
		
		                    if(offers.length > 0){
		                        offers.find('.js-q').each(function(){
		                            $(this).val('');
		                        });
		                    }
		                }
	            	});    
            }
            
           
        }
    );
});