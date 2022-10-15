$(document).ready(function () {
    //$('.js-change-q').click(function (e) {
	$(document).on('click', '.js-change-q', function (e) {
        e.preventDefault();

        var _b = $(this),
            _q = _b.parents('.js-q-item').find('.js-q-in'),
            _v = parseInt(_q.val()),
            _m = parseInt(_q.data('max'));

        if (isNaN(_v) || _v < 1) _v = 1;
        if (isNaN(_m) || _m < 1) _m = 1;

        if (_b.hasClass('minus') && _v > 1) _q.val(_v - 1);
        if (_b.hasClass('plus') && _v + 1 <= _m) _q.val(_v + 1);

        _q.trigger('change');

    });

    //$('.js-q-in').on('change', function () {
		$(document).on('change', '.js-q-in', function () {
        var _i = $(this),
            _v = parseInt(_i.val()),
            _m = parseInt(_i.data('max'));

        if (isNaN(_v) || _v < 1) _v = 1;
        if (isNaN(_m) || _m < 1) _m = 1;

        if (_v < 1) _i.val(1);
        if (_v > _m) _i.val(_m);

        $('.js-basket-table').trigger('recalc');

    });

    $(document).on('recalc', '.js-basket-table', function () {
		
        var _t = $(this),
            _f = _t.parents('form'),
            url = '/local/templates/kolchuga_2016/components/bitrix/sale.basket.basket/.default/ajax.php',
            urlCheckKomplekt = '/local/templates/kolchuga_2016/components/bitrix/sale.basket.basket/.default/ajax.php';
console.log(_t.serialize());

        $.ajax({
            url: url,
            method: 'POST',
            data: _t.serialize(),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if(data.KOMPLEKT){
                    $('.warningBlock .catalog__item').remove();
                    $.each(data.KOMPLEKT, function (key, item) {
                        console.log(item.KOMPLEKT.NAME);
                        var tovar = '<div class="catalog__item" style="text-align: center; width:24%">'+
                            '<div class="catalog__item-img">'+
                            '<a href="'+item.KOMPLEKT.DETAIL_PAGE_URL+'">'+
                            '<img src="'+item.KOMPLEKT.DETAIL_PICTURE.src+'" alt="'+item.KOMPLEKT.NAME+'title="'+item.KOMPLEKT.NAME+'">'+
                            '</a></div><div class="catalog__item-info">'+
                            '<div class="catalog__item-title"><a href="'+item.KOMPLEKT.DETAIL_PAGE_URL+'">'+item.KOMPLEKT.NAME+'</a></div>'+
                            '<a class="btn btn-primary" href="'+item.KOMPLEKT.DETAIL_PAGE_URL+'" style="margin-top: 15px;">Выбрать</a>'+
                            '</div></div>';
                        $('.warningBlock').append(tovar);
                    });
                    $('.warningBlock').show();
                    $('.order__btn').hide();
                }
                else{
                    $('.warningBlock').hide();
                    $('.order__btn').show();
                }

                if(data['VALID_COUPON'] && _t.find('.js-coupon-del-in').length < 1){
                    var succ_coupon = $('.js-basket-coupon').val(),
                        coupons = data.BASKET_DATA.COUPON_LIST;

                    $('.js-basket-coupon').val('');

                    $('.js-coupon-list').html('');
                    $.each(coupons, function(key, item){

                        $('<li><a href="#" class="coupon-cancel js-coupon-del" data-coupon="'+item.COUPON+'" title="Отменить купон">' +
                            '<span class="icon-delete"></span>' +
                            '</a><i>'+item.COUPON+'</i></li>').appendTo('.js-coupon-list');

                    });

                } else{
                    //COUPON_LIST
                    $.post(url, _f.serialize() + '&delete_coupon=' + $('.js-basket-coupon').val());
                }

                $('.js-coupon-del-in').each(function(){
                    $(this).remove();
                });

                /* var items = data.BASKET_DATA.ITEMS.AnDelCanBuy,
                    count = 0; 

                if (items == 'undefined') return false;

                var _fprice = _f.find('.js-result-price'),
                    _feco = _f.find('.js-result-eco'),
                    _fdiscount = _f.find('.js-result-discount'),
                    _fprice_val = data.BASKET_DATA.PRICE_WITHOUT_DISCOUNT.replace("руб.", "<span class='rouble'>a</span>"),
                    _feco_val = data.BASKET_DATA.DISCOUNT_PRICE_ALL_FORMATED.replace("руб.", "<span class='rouble'>a</span>"),
                    _fdisocunt_val = data.BASKET_DATA.allSum_FORMATED.replace("руб.", "<span class='rouble'>a</span>");

                $.each(items, function (key, item) {

                    var _r = _t.find('.js-row[data-id="' + item.ID + '"]'),
                        _r_sum = _r.find('.js-row-sum'),
                        _r_price = _r.find('.js-row-price'),
                        _q = _r.find('.js-q-in');

                    _r_sum.html(item.SUM.replace("руб.", "<span class='rouble'>a</span>"));

                    var p_html = '';

                    if (item.DISCOUNT_PRICE > 0)
                        p_html = p_html + '<span class="old-price">' + item.FULL_PRICE + ' <span class="rouble">a</span></span>';

                    if (item.DISCOUNT_PRICE_PERCENT > 0)
                        p_html = p_html + '<span class="discount">' + item.DISCOUNT_PRICE_PERCENT_FORMATED + '</span>';

                    p_html = p_html + '<span class="price">' + item.PRICE_FORMATED.replace("руб.", "<span class='rouble'>a</span>") + '</span>';

                    _r_price.html(p_html);

                    _q.val(item.QUANTITY);

                    count += item.QUANTITY;

                });

                $('.js-cart-count b').text(count);

                _fprice.html(_fprice_val);
                _feco.html(_feco_val);
                _fdiscount.html(_fdisocunt_val);

                if(_feco.length < 1 && data.BASKET_DATA.DISCOUNT_PRICE_ALL > 0){
                    $('<div class="basket-order-discount">' +
                        '<div class="discount">Скидка <span class="js-result-eco">'+_feco_val+'</span></div> </div>').prependTo('.js-result-prices');
                    $('<div class="basket-order-sum">Цена без скидки:  ' +
                        '<span class="js-result-price">'+_fprice_val+'</span></div>').prependTo('.js-result-prices');
                }

                if(data.BASKET_DATA.DISCOUNT_PRICE_ALL == 0){
                    $('.basket-order-discount').hide();
                    $('.basket-order-sum').hide();
                } else if(data.BASKET_DATA.DISCOUNT_PRICE_ALL > 0){
                    $('.basket-order-discount').show();
                    $('.basket-order-sum').show();
                } */
$('form.basket-order').load("/personal/cart/ form.basket-order  > *"); 
            }
        });
		
		
		

    });

    $('.js-basket-coupon').on('change', function () {

        var coupon = $(this).val();
        if(coupon.length < 1) return false;
        $('.js-basket-table').trigger('recalc');

    });

    $('body').on('click', '.js-coupon-del', function(e){
        e.preventDefault();

        var coupon = $(this).data('coupon');
        if(coupon && coupon.length > 0){
            $('<input type="hidden" name="delete_coupon" class="js-coupon-del-in" value="'+coupon+'">').appendTo('.js-basket-table');
            $('.js-basket-table').trigger('recalc');
            $(this).parents('li').remove();
			
			//add refresh page29082020, but need write nice code in future
			document.location.reload();

        }
    });
			$(document).on('click', '.minus', function () {

                var $input = $(this).parent().parent().find('input');				
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);
                //$input.change();
				$input.trigger('change');
                return false;
            });
			$(document).on('click', '.plus', function () {
            
                var $input = $(this).parent().parent().find('input');
                $input.val(parseInt($input.val()) + 1);
                //$input.change();
				$input.trigger('change');
                return false;
            });
});
function enterCoupon()
{
	$('.js-basket-table').trigger('recalc');
	document.location.reload();
}