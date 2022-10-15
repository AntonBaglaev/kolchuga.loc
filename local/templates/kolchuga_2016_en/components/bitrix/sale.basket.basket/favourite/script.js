$(document).ready(function () {
    $('.js-change-q').click(function (e) {

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

    $('.js-q-in').on('change', function () {
        var _i = $(this),
            _v = parseInt(_i.val()),
            _m = parseInt(_i.data('max'));

        if (isNaN(_v) || _v < 1) _v = 1;
        if (isNaN(_m) || _m < 1) _m = 1;

        if (_v < 1) _i.val(1);
        if (_v > _m) _i.val(_m);

        $('.js-basket-table').trigger('recalc');

    });

    $('.js-basket-table').on('recalc', function () {

        var _t = $(this),
            _f = _t.parents('form'),
            url = '/local/templates/foto/components/bitrix/sale.basket.basket/.default/ajax.php';

        $.ajax({
           url: url,
           method: 'POST',
           data: _f.serialize(),
           dataType: 'json',
           success: function(data){
              //console.log(data);
               var items = data.BASKET_DATA.ITEMS.AnDelCanBuy;

               if (items == 'undefined') return false;

               var _fprice = _f.find('.js-result-price'),
                   _feco = _f.find('.js-result-eco'),
                   _fdiscount = _f.find('.js-result-discount');

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

               });

               _fprice.html(data.BASKET_DATA.PRICE_WITHOUT_DISCOUNT.replace("руб.", "<span class='rouble'>a</span>"));
               _feco.html(data.BASKET_DATA.DISCOUNT_PRICE_ALL_FORMATED.replace("руб.", "<span class='rouble'>a</span>"));
               _fdiscount.html(data.BASKET_DATA.allSum_FORMATED.replace("руб.", "<span class='rouble'>a</span>"));
           }
        });

    })
});
