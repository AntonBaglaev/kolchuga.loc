ymaps.ready(init);

function init() {

    //Подключаем подсказки
    var suggestView = new ymaps.SuggestView('suggest', {
        provider: {
            suggest: (function (request, options) {

                var parseItems = ymaps.suggest(document.getElementsByName('LOCATION_CITY')[0].value + ', ' + request).then(function (items) {

                    for (var i = 0; i < items.length; i++) {

                        var displayNameArr = items[i].displayName.split(',');

                        var newDisplayName = [];

                        for (var j = 0; j < displayNameArr.length; j++) {

                            if (displayNameArr[j].indexOf('подъезд') == -1) {

                                newDisplayName.push(displayNameArr[j]);

                            } else {

                                break;

                            }

                        }

                        items[i].displayName = newDisplayName.join();

                    }

                    return items;

                });

                return parseItems;

            })
        }
    });

    //Проверяем адрес
    suggestView.events.add('select', function (e) {

        geocode();

    });

    //Проверяем адрес
    $('body').on('click', '.contacts-delivery ymaps', function (e) {

        geocode();

    });

    function geocode() {

        //Забираем запрос из поля ввода
        var request = $('#suggest').val();

        //Геокодируем введенные данные
        ymaps.geocode(request).then(function (res) {

            var obj = res.geoObjects.get(0);
            var error = '';
            var hint = '';

            if (obj) {

                switch (obj.properties.get('metaDataProperty.GeocoderMetaData.precision')) {
                    case 'exact':
                        break;
                    case 'number':
                    case 'near':
                    case 'range':
                        error = 'Неточный адрес, требуется уточнение';
                        hint = 'Уточните номер дома';
                        break;
                    case 'street':
                        error = 'Неполный адрес, требуется уточнение';
                        hint = 'Уточните номер дома';
                        break;
                    case 'other':
                    default:
                        error = 'Неточный адрес, требуется уточнение';
                        hint = 'Уточните адрес';
                }

            } else {

                error = 'Адрес не найден';
                hint = 'Уточните адрес';

            }

            //Проверяем на ошибки
            if (error) {

                $("#order_submit input[name='DELIVERY_ADDRESS']").val('');
                $("#order_submit input[name='DELIVERY_STREET']").val('');
                $("#order_submit input[name='DELIVERY_HOUSE']").val('');
                $('#order_submit .contacts-delivery-result-todoor').html(error + ': ' + hint + '.');
                $('#order_submit .contacts-delivery-result-todoor').show();

            } else {

                $("#order_submit input[name='DELIVERY_ADDRESS']").val([obj.getCountry(), obj.getAddressLine()].join(', '));

                var cityName = $("#order_submit input[name='LOCATION_CITY']").val();
                var arr = obj.properties.get('metaDataProperty.GeocoderMetaData.Address.Components');

                $.each(arr, function (index, value) {

                    if (arr[index]['kind'] == 'house') {

                        $("#order_submit input[name='DELIVERY_HOUSE']").val(arr[index]['name']);

                    }

                    if (arr[index]['kind'] == 'street') {

                        $("#order_submit input[name='DELIVERY_STREET']").val(arr[index]['name']);
                        $("#order_submit input[name='DELIVERY_DISTRICT']").val('');

                    }

                    if (arr[index]['kind'] == 'district') {

                        $("#order_submit input[name='DELIVERY_STREET']").val('');
                        $("#order_submit input[name='DELIVERY_DISTRICT']").val(arr[index]['name']);

                    }

                });

                if (cityName != 'moscow ') {

                    $('#order_submit .contacts-delivery-result-todoor').html('<span id="delivery-todoor">Получить варианты доставки</span>');
                    $('#order_submit .contacts-delivery-result-todoor').show();

                    //Получаем варианты доставки
                    $('#delivery-todoor').click();

                } else {

                    $('#order_submit .contacts-delivery-result-todoor').hide();

                }

            }

        }, function (e) {

            //console.log(e)

        });

    }

}
