$(function(){



    /*function calcTotalPrice(objDelivery){
        var totalPrice = 0;
        var orderPrice = parseFloat($('#order_total_price').html());
        var deliveryPrice = parseFloat(objDelivery.data('price'));

        if(orderPrice && deliveryPrice){
            totalPrice = orderPrice + deliveryPrice;
        }
        console.log(totalPrice);
    }*/

    if($('input[name="DELIVERY_ID"]:checked').length){
        var deliveryId = $('input[name="DELIVERY_ID"]:checked').data('ident');
        if(deliveryId !== 1){
            $('.c_pay_cash').hide(100);
        }
    }

});


$.fn.makeOrder = function () {

    var _f = $(this);

    _f.on('lock', function(){

        if(_f.hasClass('js-locked')){
            return true;
        }

        _f.addClass('js-locked');

        _f.find('input[type="text"], select, textarea').each(function(){
            $(this).prop('disabled', true);
        });

        //_f.find('input[type="radio"], input[type="checkbox"]').iCheck('disable');
        _f.find('input[type="radio"]').iCheck('disable');


        _f.find('.js-btn-checkout').prop('disabled', true).addClass('disabled');

        $('<div class="loader-submit"></div>')
            .prependTo(_f.find('.js-btn-checkout'))
            .parent()
            .css('position', 'relative');
    });

    _f.on('unlock', function(){

        _f.removeClass('js-locked');

        _f.find('input, select, textarea').each(function(){
            $(this).prop('disabled', false);
        });

        //_f.find('input[type="radio"], input[type="checkbox"]').iCheck('enable');
        _f.find('input[type="radio"]').iCheck('enable');

        _f.find('.js-btn-checkout')
            .prop('disabled', false)
            .removeClass('disabled')
            .children('.loader-submit')
            .remove();

    });

    //_f.trigger('lock');

    _f.on('paramsChange', function (e) {

        var _c = _f.find('input[name="confirmorder"]');
        _c.val('N');
        _f.trigger('submit');

    });

    _f.on('submit', function (e, no_refresh) {

        if (no_refresh == 'N') {
            _f.find('input[name="is_ajax_post"]').remove();
            return true;
        }

        var f = $(this),
            d = f.serialize(),
            a = f.attr('action');

        _f.trigger('lock');

        $.post(a, d, function (out) {

            _f.trigger('unlock');

            var form_right = $(out).find('.form__order--right').html(),
                form_res = $(out).find('.js-order__result').html();
				if(typeof form_res === "undefined"){	
					var doc = document.documentElement.cloneNode();
					doc.innerHTML = out;
					form_res = $(doc.querySelector('div.js-order__result')).html();
				}
			var block_1_delivery=$(out).find('.block_oformlenie--delivery').html();
			if(typeof block_1_delivery !== "undefined"){
				f.find('.block_oformlenie--delivery').html(block_1_delivery);				
			}else{
				var doc = document.documentElement.cloneNode();
					doc.innerHTML = out;
					block_1_delivery = $(doc.querySelector('div.block_oformlenie--delivery')).html();
					f.find('.block_oformlenie--delivery').html(block_1_delivery);
			}
			
			var block_2_pay=$(out).find('.block_oformlenie--paysystem').html();
			if(typeof block_2_pay !== "undefined"){
				f.find('.block_oformlenie--paysystem').html(block_2_pay);				
			}else{
				var doc = document.documentElement.cloneNode();
					doc.innerHTML = out;
					block_2_pay = $(doc.querySelector('div.block_oformlenie--paysystem')).html();
					f.find('.block_oformlenie--paysystem').html(block_2_pay);
			}
			
			var delivery_pay=$(out).find('.delivery-pay').html();
			if(typeof delivery_pay !== "undefined"){
				f.find('.delivery-pay').html(delivery_pay);				
			}else{
				var doc = document.documentElement.cloneNode();
					doc.innerHTML = out;
					delivery_pay = $(doc.querySelector('div.delivery-pay')).html();
					f.find('.delivery-pay').html(delivery_pay);
			}

            f.find('.form__order--right').html(form_right);
            f.find('.js-order__result').html(form_res);

            f.find('input').iCheck();

            f.find('select').selectric({
                arrowButtonMarkup:'<b class="icon-arrow-down"></b>',
                disableOnMobile:false,
                maxHeight:'200'
            });

        });

        e.preventDefault();

    });

    //1.Change profile
    //_f.on('change', 'select', function(){
    //    _f.find('input[name="profile_change"]').val('Y');
    //    _f.trigger('paramsChange');
    //});

    //2.Radio goups
    _f.on('ifClicked', 'input[name="PERSON_TYPE"], input[name="PAY_SYSTEM_ID"], input[name="DELIVERY_ID"]', function (e) {


        var _in = $(this),
            n = _in.attr('name');

            //nah
            var totalPrice = 0;
            var currency = ' руб';
            var orderPrice = parseFloat($('#order_total_price').html());
            var deliveryPrice = parseFloat(_in.data('price'));
            var deliveryId = parseFloat(_in.data('ident'));


            if(orderPrice && isNaN(deliveryPrice) === false){
                totalPrice = orderPrice + deliveryPrice;
                var totalPriceFormatted = String(totalPrice).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
                totalPriceFormatted += currency;

                deliveryPrice += currency;
                $('#order_delivery').html(deliveryPrice);

                if(totalPriceFormatted){
                    $('#order_price').html(totalPriceFormatted);
                }
            }

            var objPayField = $('.c_pay_cash');
            if(deliveryId == 1){
                objPayField.slideDown(200);
            }else{
                objPayField.slideUp(200);
            }

        if (n == 'PERSON_TYPE') _f.find('input[name="profile_change"]').val('Y');

        if (n == 'PAY_SYSTEM_ID' && !_in.is(':checked')) {

            _f.find('input[name="PAY_SYSTEM_ID"]:checked').iCheck('uncheck');
            _f.find('input#PAY_CURRENT_ACCOUNT').iCheck('uncheck');
            _in.iCheck('check');

        } else {
            _in.iCheck('check');
        }

        _f.trigger('paramsChange');
    });

    //3.Pay from account
    _f.on('ifClicked', 'input#PAY_CURRENT_ACCOUNT', function (e) {
        $(this).iCheck('toggle');
        $(this).trigger('ifChecked');
        _f.trigger('paramsChange');
    });

    _f.on('ifChecked', 'input#PAY_CURRENT_ACCOUNT', function (e) {
        _f.find('input[name="PAY_SYSTEM_ID"]:checked').iCheck('uncheck');
    });
	
	_f.on('ifChecked', 'input#soglasiecheck', function (e) {
        _f.find('input[name="soglasiecheck"]:checked').iCheck('uncheck');
    });

    _f.on('ifChecked', 'input[name="PAY_SYSTEM_ID"]', function(e){
       parseInt($(this).val()) == 3 ? $('.js-unavailable').show() : $('.js-unavailable').hide();
    });

    _f.on('click', '.control-label', function (e) {
        $(this).next().find('.form-control').focus();
        return false;
    });

    //5.Submit
    _f.on('click', '.js-btn-checkout', function (e) {

        if (!_f.find('.icheckbox').hasClass('checked') && _f.find('.form_agree').length) {
            _f.find('.error-msg-agree').slideDown();
            return false;
        } else {
            _f.find('.error-msg-agree').slideUp();
        }

        _f.find('input[name="confirmorder"]').val('Y');

        _f.trigger('lock');
        _f.trigger('unlock');
		
		var razdel=_f.find('input[name="razdel"]').val();
		var validok=true;
		$('.js-order [required]').each(function() {
			var pole=$(this).val();
			if(pole.length<2){
				validok=false;
				$(this).css({'background-color':'#ff00000d'}).after('<span class="errorspanfield">This field is required</span>');
				//console.log($(this).attr('name'));
			}else{
				//$(this).prop('required', false);
				$(this).css({'background-color':'#ffffff'});
				var is_ml=$(this).attr('type');
				if(is_ml=='email'){
					if (/^([A-Za-z0-9_-]+\.)*[A-Za-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/.test(pole) == false) {
						validok=false;
						$(this).css({'background-color':'#ff00000d'}).after('<span class="errorspanfield">This field is required</span>');
					}else{
						$(this).css({'background-color':'#ffffff'});
					}
				}
			}
			
		});
		if(!validok){
			_f.find('.showerrortext').show();
			return false;
		}else{
			_f.find('.showerrortext').hide();
		}
		if(razdel==18 || razdel==19 || razdel==20 || razdel==21 || razdel==22 || razdel==23 || razdel==1 || razdel==11){
			$.ajax({
				url: '/ajax/order_by_sklad.php',
				data: _f.serialize(),
				dataType: 'json',
				type: 'post',
				success: function (html) {
					
					if (html.redirect) {document.location.href = html.redirect;}
				},
				error: function (xhr) {
					
					var response = xhr.responseText;
					console.log(response);
					
					if (response.redirect) {document.location.href = out.redirect;}		
					
				}
			});
		}else{

			$.ajax({
				url: _f.attr('action'),
				data: _f.serialize(),
				dataType: 'json',
				type: 'post',
				success: function (out) {
					if (out.redirect) location.href = out.redirect;
				},
				error: function (xhr) {
					var response = xhr.responseText + '';

					/* Test is stupid, but we get result from bitrix core .... */
					if(response.substr(0, 6) == '<input'){
						_f.trigger('submit');
					}

					return false;
				}
			});
		
		}

        e.preventDefault();
    });

    //auth or new reg
    _f.on('ifClicked', '.js-new-reg', function (e) {
        if ($(this).val() == 0)
            $('#modal-login').modal('show');
    });

    $('#modal-login').on('hidden.bs.modal', function (e) {
        _f.find('.js-new-reg-true').iCheck('check');
    })

}

$(document).ready(function () {
    $('.js-order').makeOrder();

    $('.search-loc').personalSearch({
        result: '.js-search-result-loc',
        dataProvider: '/local/templates/kolchuga_2016/components/bitrix/sale.order.ajax/.default/helpers/ajax_location.php',
        onSelect: function () {
            var input = $('.search-loc');
            input.val(this.NAME);
            input.prev().val(this.ID);
            input.parents('form').trigger('paramsChange');

        }
    });

    //$('body').on('mouseenter', '.popover-close', function(){
    //
    //});

    //$('body').on('click', '.popover-close', function(e){
    //
    //    $(this).parents('.hover').removeClass('hover');
    //
    //    return false;
    //    e.preventDefault();
    //});
	
												
});

function smenaKuda(e){
		if(e=='TO_PUNKT'){
			$('.cdek_block').removeClass('C_TO_HOME').removeClass('C_TO_PUNKT');
			$('.cdek_block').addClass('C_TO_PUNKT');
		}else{
			$('.cdek_block').removeClass('C_TO_HOME').removeClass('C_TO_PUNKT');
			$('.cdek_block').addClass('C_TO_HOME');
		}
	}
function changeFio(){
	var fio27= $('input[name="ORDER_PROP_27"]').val().split(" ").join("");
		$('input[name="ORDER_PROP_27"]').val(fio27);
	var fio28= $('input[name="ORDER_PROP_28"]').val().split(" ").join("");
		$('input[name="ORDER_PROP_28"]').val(fio28);
	var fio29= $('input[name="ORDER_PROP_29"]').val().split(" ").join("");
		$('input[name="ORDER_PROP_29"]').val(fio29);
	var fio272829='';
	if(fio27.length !== 0){
		fio272829=fio272829+fio27;
	}
	fio272829=fio272829.trim()
	if(fio28.length !== 0){
		fio272829=fio272829+' '+fio28;
	}
	fio272829=fio272829.trim();
	if(fio29.length !== 0){
		fio272829=fio272829+' '+fio29;
	}
	fio272829=fio272829.trim();
	$('input[name="ORDER_PROP_1"]').val(fio272829);
}
$(document).on('keyup','input[name="ORDER_PROP_27"]', changeFio);
$(document).on('keyup','input[name="ORDER_PROP_28"]', changeFio);
$(document).on('keyup','input[name="ORDER_PROP_29"]', changeFio);
$(document).on('keyup','.form__order .form__input input', function(){
	if($(this).attr('name')!='ORDER_PROP_6'){
		$(this).attr('value', $(this).val());	
	}else{
		 $('.search-loc').personalSearch({
			result: '.js-search-result-loc',
			dataProvider: '/local/templates/kolchuga_2016/components/bitrix/sale.order.ajax/.default/helpers/ajax_location.php',
			onSelect: function () {
				var input = $('.search-loc');
				input.val(this.NAME);
				input.prev().val(this.ID);
				input.parents('form').trigger('paramsChange');

			}
		});
	}
});
$(document).on('keyup','.form__order .form__input textarea', function(){
	$(this).attr('value', $(this).val());	
});