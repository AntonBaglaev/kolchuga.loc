$(function () {
    $(document).on('click', '.js-add2basket_price-buy_offer', function (e) {
        e.preventDefault();

        $(this)
            .closest('.add2basket_price-buy_wrapper')
            .find('.js-add2basket_price-buy_offer')
            .removeClass('_selected');

        $(this).not('[disabled]').addClass('_selected');

        return false;
    });

    $(document).on('click', '.js-add2basket_price-buy_button', function (e) {
        e.preventDefault();

        let __this = $(this);

        let productId = $(this)
            .parent()
            .find('.js-add2basket_price-buy_offer._selected:not(.in_the_cart)')
            .data('product');

        let productAvailable = $(this)
            .parent()
            .find('.js-add2basket_price-buy_offer:not(._selected):not(.in_the_cart)');

        if (productId) {
            $.post("/ajax/add_2_basket.php", {
                    id: productId,
                    quantity: 1
                },
                function (data) {

                    let objResult = $.parseJSON(data);

                    if (objResult.basket_count != undefined)
                        $('.js-cart-count').html('<b>' + objResult.basket_count + '<b>');

                    __this
                        .parent()
                        .find('.js-add2basket_price-buy_offer._selected')
                        .addClass('in_the_cart');

                    let productAvailable =
                        __this
                            .parent()
                            .find('.js-add2basket_price-buy_offer:not(._selected):not(.in_the_cart)');

                    if (productAvailable.length == 0) {
                        __this
                            .parent().parent()
                            .find('.js-add2basket_price-buy_button')
                            .css('background', '#21385E')
                            .text('В корзине');
                    }

                    if ($('.add-cart').length)
                        $('.add-cart').show();

                });
        } else if (productAvailable.length == 0) {
            __this
                .css('background', '#21385E')
                .text('В корзине');
        } else {

            $(this)
                .parent()
                .find('.js-add2basket_price-buy_offer:not(.in_the_cart)')
                .addClass('_flash');

            $(this)
                .parent()
                .find('.add2basket_notification')
                .addClass('_notify');

            setTimeout(() => {
                $(this)
                    .parent()
                    .find('.js-add2basket_price-buy_offer')
                    .removeClass('_flash');

                $(this)
                    .parent()
                    .find('.add2basket_notification')
                    .removeClass('_notify');
            }, 2000);

        }

        return false;
    });

    $(document).on('click', '.hide-success', function (e) {
        e.preventDefault();

        var $target = $(e.target);

        $('.add-cart').fadeOut(100);
    });

    $(document).on('click', '.add-cart', function (e) {
        var $target = $(e.target);

        if ($target.attr('class') != undefined)
            $('.add-cart').fadeOut(100);
    });

});

