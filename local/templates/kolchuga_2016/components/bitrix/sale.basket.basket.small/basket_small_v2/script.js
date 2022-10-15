$(function () {

    if (typeof cart_product_ids != 'undefined') {

        $.each(cart_product_ids, function (index, value) {
            if (index) {

                let $offerItem =
                    $('.js-add2basket_price-buy_offer[data-product=' + index + ']');

                $offerItem
                    .addClass('in_the_cart');

                let productAvailable =
                    $offerItem
                        .parent()
                        .find('.js-add2basket_price-buy_offer:not(._selected):not(.in_the_cart)');

                if (productAvailable.length == 0) {
                    $offerItem
                        .parent().parent()
                        .find('.js-add2basket_price-buy_button')
                        .css('background', '#21385E')
                        .text('В корзине');
                }

            }
        });

    }

});
