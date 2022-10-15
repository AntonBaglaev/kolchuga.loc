$(document).ready(function () {

    //Маская для телефонов
    $("#phone").mask("+7(999) 999-99-99");

    $(".city-input").click(function (evt) {

        evt.preventDefault();
        getListCities();

    });

    $("input[name='delivery']").change(function (evt) {

        getDeliveryBlock();

    });

    //Выбор населенного пункта
    $('body').on('input', '#input-city', function (e) {

        $('#loader-city').show();
        $('#order_submit .order-registration__list').html('');

        var cityName = $(this).val();

        var url = $("#order_submit input[name='PATH_TO_CITY']").val();

        $.ajax({
            type: 'POST',
            url: url,
            data: {'city': cityName},
            success: function (data) {

                $('#order_submit .order-registration__list').removeClass('checked');
                $('#order_submit .order-registration__list').html(data);
                getListCities();

            }
        });

    });

    //Открыть календарь
    $('body').on('click', '#data', function (e) {
        e.preventDefault();

        //Открываем календарь
        BX.calendar({node: this, value: new Date(), field: this, bTime: false});
        changeCalendar();

        //Проверяем строку адреса доставки
        var cityName = $("#order_submit input[name='LOCATION_CITY']").val();
        var deliveryAddress = $("#order_submit input[name='DELIVERY_ADDRESS']").val();

        if (deliveryAddress && cityName != 'moscow') {

            /*
            $('#order_submit .contacts-delivery-result-todoor').html('<span id="delivery-todoor">Получить варианты доставки</span>');
            $('#order_submit .contacts-delivery-result-todoor').show();

            //Получаем варианты доставки
            $('#delivery-todoor').click();
            */

        } else {

            $('#order_submit .contacts-delivery-result-todoor').hide();

        }

    });

    //Очистить дату в календаре
    $('body').on('click', '#order_submit .contacts-delivery i.fa', function (e) {
        e.preventDefault();

        $("#order_submit input[name='DELIVERY_DATE']").val('');

        //Проверяем строку адреса доставки
        var cityName = $("#order_submit input[name='LOCATION_CITY']").val();
        var deliveryAddress = $("#order_submit input[name='DELIVERY_ADDRESS']").val();

        if (deliveryAddress && cityName != 'moscow') {

            $('#order_submit .contacts-delivery-result-todoor').html('<span id="delivery-todoor">Получить варианты доставки</span>');
            $('#order_submit .contacts-delivery-result-todoor').show();

            //Получаем варианты доставки
            $('#delivery-todoor').click();

        } else {

            $('#order_submit .contacts-delivery-result-todoor').hide();

        }

    });

    //Получаем варианты доставки, курьер
    $('body').on('click', '#delivery-todoor', function (e) {

        $('#loader').show();

        var cityName = $("#order_submit input[name='LOCATION_CITY']").val();
        var deliveryDate = $("#order_submit input[name='DELIVERY_DATE']").val();
        var url = $("#order_submit input[name='PATH_TO_DELIVERY_TODOOR']").val();

        $.ajax({
            type: 'POST',
            url: url,
            data: {'city': cityName, 'date': deliveryDate},
            success: function (data) {

                $('#order_submit .contacts-delivery-result-todoor').html(data);

                //Сортировка вариантов доставки в таблице
                $('#todoor_table').DataTable({
                    "order": [[0, "asc"]],
                    "bPaginate": false,
                    "bFilter": false,
                    "bInfo": false,
                });

                $('#loader').hide();

            }
        });

    });

    //Получаем варианты доставки, служба доставки
    $('body').on('click', '#delivery-transport', function (e) {

        //Загружаем варианты доставки
        getdeliveryMap();

    });


    //Выбор варианта доставки из таблицы
    $('body').on('click', '#order_submit .offer-item-layout button', function (e) {

        $('.offer-item-layout button').removeClass('active');
        $(this).addClass('active');

        //Отмечаем выбранный вариант доставки в таблице и на карте
        var shtamp = $(this).attr('id');
        $('.' + shtamp).addClass('active');

        //Идентификатор службы доставки
        var deliveryId = $(this).attr('data-delivery');
        $("#order_submit input[name='DELIVERY_ID']").val(deliveryId);

        //Идентификатор тарифа доставки
        var tariffid = $(this).attr('data-tariffid');
        $("#order_submit input[name='DELIVERY_TARIFFID']").val(tariffid);

        //Идентификатор службы доставки для точки
        var yaDeliveryId = $(this).attr('date-pointdelivery');
        $("#order_submit input[name='YA_DELIVERY_ID']").val(yaDeliveryId);

        //Идентификатор точки доставки
        var yaPointId = $(this).attr('date-point');
        $("#order_submit input[name='YA_POINT_ID']").val(yaPointId);

        //Сводная информация
        var yaPointInfo = $(this).attr('date-info');
        $("#order_submit input[name='YA_POINT_INFO']").val(yaPointInfo);

        //Пересчитываем корзину с суммой доставки
        var deliveryPrice = $(this).attr('date-price');
        deliveryPriceUpdate(deliveryPrice);

    });

    //Выбор варианта доставки на карте
    $('body').on('click', '.offer-item-layout.map button', function (e) {

        $('.offer-item-layout button').removeClass('active');
        $(this).addClass('active');

        //Отмечаем выбранный вариант доставки в таблице и на карте
        var shtamp = $(this).attr('id');
        $('.' + shtamp).addClass('active');

        //Идентификатор службы доставки
        var deliveryId = $(this).attr('data-delivery');
        $("#order_submit input[name='DELIVERY_ID']").val(deliveryId);

        //Идентификатор тарифа доставки
        var tariffid = $(this).attr('data-tariffid');
        $("#order_submit input[name='DELIVERY_TARIFFID']").val(tariffid);

        //Идентификатор службы доставки для точки
        var yaDeliveryId = $(this).attr('date-pointdelivery');
        $("#order_submit input[name='YA_DELIVERY_ID']").val(yaDeliveryId);

        //Идентификатор точки доставки
        var yaPointId = $(this).attr('date-point');
        $("#order_submit input[name='YA_POINT_ID']").val(yaPointId);

        //Сводная информация
        var yaPointInfo = $(this).attr('date-info');
        $("#order_submit input[name='YA_POINT_INFO']").val(yaPointInfo);

        //Пересчитываем корзину с суммой доставки
        var deliveryPrice = $(this).attr('date-price');
        deliveryPriceUpdate(deliveryPrice);

    });

    //Фильтрация служб доставки открыть/закрыть
    $('body').on('click', '.dropdown .dropdown-open', function (e) {

        $(this).toggleClass('open');
        $('.dropdown-content').toggleClass('open');

    });

    //Выбор в фильтре
    $('body').on('click', '.dropdown-content span', function (e) {

        $(this).toggleClass('active');

        var deliveryList = $('.dropdown-content span');
        var arDeliveryList = [];

        $.each(deliveryList, function (index, value) {

            if ($(value).hasClass('active')) {

                arDeliveryList.push($(value).attr('id'));

            }

        });

        getdeliveryMap(arDeliveryList);

    });

    //Самовывоз
    $('body').on('click', '#pickup', function (e) {

        $("#order_submit input[name='DELIVERY_ID']").val('');
        $("#order_submit input[name='YA_DELIVERY_ID']").val('');
        $("#order_submit input[name='DELIVERY_TARIFFID']").val('');
        $("#order_submit input[name='YA_POINT_ID']").val('');
        $("#order_submit input[name='YA_POINT_INFO']").val('');
        $("#order_submit input[name='HOUSE']").val('');
        $('#order_submit .contacts-delivery-result-todoor').hide();
        $('#order_submit .contacts-delivery-result-transport').hide();

        //Стоимость доставки
        deliveryPriceUpdate();

    });

    //Курьерская доставка
    $('body').on('click', '#courier', function (e) {

        $("#order_submit input[name='DELIVERY_ID']").val('');
        $("#order_submit input[name='YA_DELIVERY_ID']").val('');
        $("#order_submit input[name='DELIVERY_TARIFFID']").val('');
        $("#order_submit input[name='YA_POINT_ID']").val('');
        $("#order_submit input[name='YA_POINT_INFO']").val('');
        $("#order_submit input[name='HOUSE']").val('');
        $('#order_submit .contacts-delivery-result-transport').hide();

        //Проверяем строку адреса доставки
        var cityName = $("#order_submit input[name='LOCATION_CITY']").val();
        var deliveryAddress = $("#order_submit input[name='DELIVERY_ADDRESS']").val();

        if (deliveryAddress.length > 1 && cityName != 'moscow') {

            $('#order_submit .contacts-delivery-result-todoor').html('<span id="delivery-todoor">Получить варианты доставки</span>');
            $('#order_submit .contacts-delivery-result-todoor').show();

            //Получаем варианты доставки
            $('#delivery-todoor').click();

        } else {

            $('#order_submit .contacts-delivery-result-todoor').hide();

        }

        //Доставка курьером по Москве всегда 300 руб.
        if (cityName == 'moscow') {

            //Стоимость доставки
            deliveryPriceUpdate(300);

        } else {

            //Стоимость доставки
            deliveryPriceUpdate();

        }

    });

    //Пункт выдачи транспортной компании
    $('body').on('click', '#transport', function (e) {

        $("#order_submit input[name='DELIVERY_ID']").val('');
        $("#order_submit input[name='YA_DELIVERY_ID']").val('');
        $("#order_submit input[name='DELIVERY_TARIFFID']").val('');
        $("#order_submit input[name='YA_POINT_ID']").val('');
        $("#order_submit input[name='YA_POINT_INFO']").val('');
        $("#order_submit input[name='HOUSE']").val('');
        $('#order_submit .contacts-delivery-result-todoor').hide();
        $('#order_submit .contacts-delivery-result-transport').html('<span id="delivery-transport">Получить варианты доставки</span>');
        $('#order_submit .contacts-delivery-result-transport').show();

        //Стоимость доставки
        //deliveryPriceUpdate();

        //Загружаем карту доставок
        getdeliveryMap();

    });

    //Выбор способа оплаты
    $('body').on('click', '#cash', function (e) {

        //Наличные
        var paymentId = parseInt($(this).attr('data-payment'));
        $("#order_submit input[name='PAY_SYSTEM_ID']").val(paymentId);

    });
    $('body').on('click', '#card', function (e) {

        //Яндекс.Касса
        var paymentId = parseInt($(this).attr('data-payment'));
        $("#order_submit input[name='PAY_SYSTEM_ID']").val(paymentId);

    });

    //Колличество товара, больше
    $('body').on('click', 'button.good-item__count-button.button-plus', function (e) {
        e.preventDefault();

        $('#loader').show();

        var productId = $(this).attr('date-basket');
        var quantity = parseInt($('#' + productId + ' .good-item__count-total').attr('date-quantity')) + 1;

        $('#' + productId + '').css('background', '#E4E5E6');

        $.ajax({
            type: 'GET',
            url: '/ajax/add_basket.php',
            data: {'ID_UPDATE': productId, 'QUANTITY': quantity},
            success: function (data) {

                basketUpdate();

            }
        });

    });

    //Колличество товара, меньше
    $('body').on('click', 'button.good-item__count-button.button-minus', function (e) {
        e.preventDefault();

        $('#loader').show();

        var productId = $(this).attr('date-basket');
        var quantity = parseInt($('#' + productId + ' .good-item__count-total').attr('date-quantity')) - 1;

        if (quantity == 0) {

            if (confirm('Товар будет удален из корзины?')) {

                $('#' + productId + '').css('background', '#E4E5E6');

                $.ajax({
                    type: 'GET',
                    url: '/ajax/add_basket.php',
                    data: {'ID_UPDATE': productId, 'QUANTITY': quantity},
                    success: function (data) {

                        basketUpdate();

                    }
                });

            } else {

                $('#loader').hide();

            }

        } else {

            $.ajax({
                type: 'GET',
                url: '/ajax/add_basket.php',
                data: {'ID_UPDATE': productId, 'QUANTITY': quantity},
                success: function (data) {

                    basketUpdate();

                }
            });

        }

    });

    //Отправка формы
    $('body').on('submit', '#order_submit', function (e) {
        e.preventDefault();

        $('#loader').show();

        $('#order_submit .submit-result').html('');

        var url = $("#order_submit input[name='PATH_TO_AJAX']").val();
        var msg = $('#order_submit').serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: msg,
            success: function (data) {

                var obj = JSON.parse(data);

                if (obj.errors) {

                    $('#order_submit .submit-result').html('Обнаружены ошибки: ' + obj.errors).css('color', 'red');
                    $('#loader').hide();

                } else {

                    var href = '/personal/order/make/';
                    window.location.href = href + '?ORDER_ID=' + obj.successes;

                }

            }
        });

    });

    basketUpdate();

});

//Обновляем корзину с товарами
function basketUpdate() {

    var url = $("#order_submit input[name='PATH_TO_BASKET']").val();

    if (url) {

        $('#loader').show();

        $.ajax({
            type: 'POST',
            url: url,
            success: function (data) {

                var obj = JSON.parse(data);

                if (obj.errors) {

                    location.reload();

                } else {

                    $('#order_submit .basket-goods__items .basket-goods__container').html(obj.BASKET_USER.PRODUCTS);
                    $('#order_submit .total-order__count').html(obj.BASKET_USER.PRICE_TOTAL);
                    $('#order_submit .total-order__price').html(obj.BASKET_USER.DELIVERY_TOTAL);
                    $('#order_submit .total-price__count').html(obj.BASKET_USER.ORDER_TOTAL);
                    $('#loader').hide();

                }

            }
        });

    }

}

//Обновляем стоимость доставки
function deliveryPriceUpdate(price) {

    var url = $("#order_submit input[name='PATH_TO_DELIVERY_PRICE']").val();

    if (url) {

        $('#loader').show();

        $.ajax({
            type: 'POST',
            url: url,
            data: {'price': price},
            success: function (data) {

                basketUpdate();

            }
        });

    }

}

//Выбор даты в календаре
function changeCalendar() {

    var el = $('[id ^= "calendar_popup_"]');
    var links = el.find(".bx-calendar-cell");

    $('.bx-calendar-left-arrow').attr({'onclick': 'changeCalendar();',});
    $('.bx-calendar-right-arrow').attr({'onclick': 'changeCalendar();',});
    $('.bx-calendar-top-month').attr({'onclick': 'changeMonth();',});
    $('.bx-calendar-top-year').attr({'onclick': 'changeYear();',});

    var date = new Date();
    date.setDate(date.getDate() + 1);

    for (var i = 0; i < links.length; i++) {

        var atrDate = links[i].attributes['data-date'].value;
        var d = date.valueOf();
        var g = links[i].innerHTML;

        if (date - atrDate > 24 * 60 * 60 * 1000) {

            $('[data-date="' + atrDate + '"]').addClass("bx-calendar-date-hidden disabled");

        } else {

            $('[data-date="' + atrDate + '"]').attr("onclick", "changeDay(this);");

        }

    }

}

//Выбор даты в календаре
function changeDay(e) {

    //Проверяем строку адреса доставки
    var cityName = $("#order_submit input[name='LOCATION_CITY']").val();
    var deliveryAddress = $("#order_submit input[name='DELIVERY_ADDRESS']").val();

    if (deliveryAddress && cityName != 'moscow') {

        $('#order_submit .contacts-delivery-result-todoor').html('<span id="delivery-todoor">Получить варианты доставки</span>');
        $('#order_submit .contacts-delivery-result-todoor').show();

        function dataSet() {

            //Получаем варианты доставки
            $('#delivery-todoor').click();

        }

        $('#loader').show();

        setTimeout(dataSet, 2000);

    } else {

        $('#order_submit .contacts-delivery-result-todoor').hide();

    }

}

//Выбор месяца в календаре
function changeMonth() {

    var el = $('[id ^= "calendar_popup_month_"]');
    var links = el.find(".bx-calendar-month");

    for (var i = 0; i < links.length; i++) {

        var func = links[i].attributes['onclick'].value;
        $('[onclick="' + func + '"]').attr({'onclick': func + '; changeCalendar();',});

    }

}

//Выбор года в календаре
function changeYear() {

    var el = $('[id ^= "calendar_popup_year_"]');
    var link = el.find(".bx-calendar-year-input");
    var func2 = link[0].attributes['onkeyup'].value;

    $('[onkeyup="' + func2 + '"]').attr({'onkeyup': func2 + '; changeCalendar();',});
    var links = el.find(".bx-calendar-year-number");

    for (var i = 0; i < links.length; i++) {

        var func = links[i].attributes['onclick'].value;
        $('[onclick="' + func + '"]').attr({'onclick': func + '; changeCalendar();',});

    }

}

/*  */

function getListCities() {

    if (!$(".order-registration__list").hasClass("checked")) {

        $(".order-registration__list").addClass("checked");

        $(".order-registration__list-label").each(function (evt) {

            $(this).click(function (evt) {

                evt.preventDefault();

                var city_value = $(this).find('input[name="city"]').val();

                $(".city-input").val(city_value);

                //Действия по умолчанию, после выбора населенного пункта
                $("#order_submit input[name='LOCATION_CITY']").val(city_value);
                $("#order_submit input[name='LOCATION_CITY_ID']").val($(this).find('input[name="city"]').attr('date-geo'));
                $("#order_submit input[name='DELIVERY_ADDRESS']").val('');
                $('#suggest').val('');

                $(".order-registration__list").removeClass("checked");

                if (city_value == 'moscow') {

                    getMoscowBlock();
                    $('#pickup').click();

                } else {

                    getNoMoscowBlock();
                    $('#courier').click();
                }

            });

        });

    } else {

        $(".order-registration__list").removeClass("checked");

    }

    $('#loader-city').hide();

}

$(".order-registration__container input").focus(function () {

    removeOnFocus();

});

$(".order-registration__container textarea").focus(function () {

    removeOnFocus();

});

function removeOnFocus() {

    if ($(this).attr('id') !== 'input-city' && $(".order-registration__list").hasClass("checked")) {

        $(".order-registration__list").removeClass("checked");

    }

}

function getMoscowBlock() {

    $("#samovivoz").slideDown();
    $(".deliver").slideDown();
    addTotalPriceBlock();

}

function getNoMoscowBlock() {

    $("#samovivoz").css('display', 'none');
    $(".deliver").slideDown();
    addTotalPriceBlock();

}

function addTotalPriceBlock() {

    $(".total-order.order-delivery").slideDown({

        start: function () {
            $(this).css({
                display: "flex"
            })
        }

    });

    $(".total-price").slideDown({

        start: function () {
            $(this).css({
                display: "flex"
            })
        }

    });

}

function getDeliveryBlock() {

    var delivery_value = $("input[name='delivery']:checked").val();

    if (delivery_value == 'courier') {

        $(".contacts-delivery").removeClass("none");

    } else {

        $(".contacts-delivery").addClass("none");

    }

}

function getdeliveryMap(delivery) {

    $('#loader').show();

    //Очищаем карту
    $('#contacts-delivery-result-transport-map').html('');

    var cityName = $("#order_submit input[name='LOCATION_CITY']").val();
    var url = $("#order_submit input[name='PATH_TO_DELIVERY_TRANSPORT']").val();

    $.ajax({
        type: 'POST',
        url: url,
        data: {'city': cityName, 'delivery': delivery},
        success: function (data) {

            $('#order_submit .contacts-delivery-result-transport').html(data);

            //Сортировка пунктов выдачи в таблице
            $('#transport_table').DataTable({
                "order": [[0, "asc"]],
                "bPaginate": false,
                "bFilter": false,
                "bInfo": false,
            });

            //Карта пунктов выдачи
            var url = $("#order_submit input[name='PATH_TO_MAP']").val();

            $.post(url, function (data) {

                var shopList = JSON.parse(data);

                ymaps.ready(init);

                function init() {

                    var myMap = new ymaps.Map('contacts-delivery-result-transport-map', {
                        center: shopList['first_coordinates']['coordinates'],
                        zoom: 10,
                        controls: [
                            'zoomControl',
                        ]

                    });

                    var fullscreenControl = new ymaps.control.Button({
                        data: {
                            content: 'Раскрыть карту',
                        },
                        options: {
                            selectOnClick: false,
                            float: 'right',
                            maxWidth: '150',
                        }

                    });
                    fullscreenControl.events.add('press', function () {

                        if (!fullscreenControl.isSelected()) {

                            myMap.container.enterFullscreen();

                        } else {

                            myMap.container.exitFullscreen();

                        }

                    });
                    myMap.container.events.add('fullscreenenter', function () {

                        fullscreenControl.data.set({content: 'Свернуть карту'});
                        fullscreenControl.select();

                    });
                    myMap.container.events.add('fullscreenexit', function () {

                        fullscreenControl.data.set({content: 'Раскрыть карту'});
                        fullscreenControl.deselect();

                    });

                    myMap.controls.add(fullscreenControl);

                    //Коллекция меток
                    var cityCollection = new ymaps.GeoObjectCollection();

                    $.each(shopList['map_list'], function (index, value) {

                        var shopPlacemark = new ymaps.Placemark(
                            value.coordinates,
                            {
                                hintContent: value.name.join('<br /><br />'),
                                balloonContent: value.content.join('') + value.close,
                            }
                        );

                        //Добавляем метку в коллекцию
                        cityCollection.add(shopPlacemark);

                    });

                    //Добавляем коллекцию на карту
                    myMap.geoObjects.add(cityCollection);

                }

                //Фильтр служб доставки
                var deliveryList = '';

                $.each(shopList['delivery_list'], function (index, value) {

                    deliveryList += ' <span id=' + value['id'] + ' class=' + value['active'] + '>' + value['name'] + '</span>';

                });

                $('.dropdown-content').html(deliveryList);

            });

            $('#loader').hide();

        }
    });

}
