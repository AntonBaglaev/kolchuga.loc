/**
 * Created by Raven on 27.12.15.
 */

$(document).ready(function () {

      $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 126,
        itemMargin: 0,
        prevText: "",
        nextText: "",
        asNavFor: '#slider'
      });

      $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        prevText: "",
        nextText: "",
        sync: "#carousel"
      });
  
    var btn = $('.js-buy-btn'),
        size_list = $('select[name="SKU_SIZE"]'),
		size_list_table = $('.size_list .size_list_thead td'),
        q_in = $('.js-q');

	size_list_table.on('click', function (e) {
		size_list_table.removeClass('size_list_table_active');
		$(this).addClass('size_list_table_active');
		var v = $(this).data('value'),
            m = 1,      
			selected = $(this),
            price_tx = '';
		if($(this).data('max') < 1){
			$(this).removeClass('size_list_table_active');
			$(this).addClass('size_list_table_activeno');
			
		}else {
			
		}
		
		setTimeout(function() { $('.size_list_table_activeno').removeClass('size_list_table_activeno'); }, 2000);
		
		if(typeof $(this).data('uri') !== 'undefined'){
			window.location.href=$(this).data('uri');
		}
			
		if (v > 0 && $(this).data('max') > 0) {
            /*q_in.data('max', selected.data('max'));*/
            btn.data('id', v);


            /* Price render */
            price_tx += '<span class="js-price new-price">' + selected.data('discount') + '</span>';
            if (typeof selected.data('percent') !== 'undefined' && parseInt(selected.data('percent')) > 0) {
				
				price_tx += '<div class="old-price"><span class="promo">Акция</span><span class="crossed">' + selected.data('price') + '</span></div>' +
					'<span class="line_diff_price">(-' + selected.data('percent') + '%)</span>';                

            }


            $('.js-price-block').html(price_tx);

            $('.alert-size').hide();
        } else {
            btn.data('id', 0);
        }
		
	});	
	
    size_list.on('selectric-change', function (e) {

        var v = $(this).val(),
            m = 1,
            selected = $(this).find('option[value="' + v + '"]'),
            price_tx = '';
			
			if(typeof selected.data('uri') !== 'undefined'){
				window.location.href=selected.data('uri');
			}
		
		if(selected.data('max') < 1){
			btn.hide();
		} else {
			btn.show();
		}
				
        if (v > 0) {
            q_in.data('max', selected.data('max'));
            btn.data('id', v);


            /* Price render */
            /*if (typeof selected.data('percent') !== 'undefined' && parseInt(selected.data('percent')) > 0) {

                price_tx += '<span class="old-price">' + selected.data('price') + '</span> ' +
                    '<span class="discount">Скидка ' + selected.data('percent') + '%</span> ';

            }

            price_tx += '<span class="price">' + selected.data('discount') + '</span>';*/
			price_tx += '<span class="js-price new-price">' + selected.data('discount') + '</span>';
            if (typeof selected.data('percent') !== 'undefined' && parseInt(selected.data('percent')) > 0) {
				
				price_tx += '<div class="old-price"><span class="promo">Акция</span><span class="crossed">' + selected.data('price') + '</span></div>' +
					'<span class="line_diff_price">(-' + selected.data('percent') + '%)</span>';                

            }

            $('.js-price-block').html(price_tx);

            $('.alert-size').hide();
        } else {
            btn.data('id', 0);
        }

    });

    q_in.on('change', function (e) {
        var v = parseInt($(this).val()),
            m = parseInt($(this).data('max'));

        if (isNaN(m) || m < 1) {
            m = 1;
        }

        if (isNaN(v)) {
            q_in.val(1);
        }

        if (v > m) {
            q_in.val(m);
        }

    });

    btn.click(function (e) {

            e.preventDefault();

            //$(this).parent().parent().append('<img src="/images/preload.gif" alt="" class="preload" />');

            //bigdata support
            var rcm_in = $('.js-rcm-param');
            var data_id = parseInt(btn.data('id'));

            $('.add-cart').hide();

            if (rcm_in.length > 0 && data_id == rcm_in.data('id')) {
                                    
                $.post(rcm_in.val(), {ajax_basket: 'Y', rcm: 'yes'}, function () {
                    $('.preload').remove();
                    $('.good_add_cart').show();
                    $.get('/local/tools/basket.php', {ajax: 'Y', calc: 'Y'}, function (out) {
                        $('.js-cart-count').html('<b>' + out.CART_COUNT + '<b>');
                        $('.preload').remove();
                        $('.add-cart').show();

                    }, 'json');
                }, 'text');
            }

            else {

                if ((isNaN(data_id) || data_id < 1) && size_list.length > 0) {
                    $('.alert-size').show();
					$('.size_list .size_list_thead td.size_list_thead_item').addClass('size_list_table_activeno');
					setTimeout(function() { $('.size_list_table_activeno').removeClass('size_list_table_activeno'); }, 1000);
					setTimeout(function() { $('.size_list .size_list_thead td.size_list_thead_item').addClass('size_list_table_activeno'); }, 2000);
					setTimeout(function() { $('.size_list_table_activeno').removeClass('size_list_table_activeno'); }, 3000);

                } else {

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
                        success: function (out) {

                            $('.js-cart-count').html('<b>' + out.CART_COUNT + '<b>');
                            //$('.js-fav-count').html('<b>'+out.DELAY_COUNT+'<b>');

                            $('.preload').remove();
                            $('.add-cart').show();
                            $('.popup-modal2').magnificPopup({
                                tClose: 'Закрыть',
                                closeMarkup:'<button title="%title%" class="mfp-close"><span class="icon-close"></span></button>',
                                closeBtnInside: true
                            }).magnificPopup('open');
                            q_in.val(0);
                        }
                    });
                }
            }


        }
    );

    $('.hide-success').on('click', function (e) {
        $('.add-cart').fadeOut(300);
        e.preventDefault();
    });

	
	$('#slider li a').attr('href', function() {
		if(typeof $(this).attr('src-data') === "undefined"){
			//не установлен
		}else{			
			return $(this).attr('src-data');			
		}
	});
});