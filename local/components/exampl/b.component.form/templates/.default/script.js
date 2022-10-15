$(document).ready(function () {

    //Валидация полей формы
    $('body').on('input click', "#simple-form input[name='name'], #simple-form input[name='email'], #simple-form input[name='phone'], #simple-form textarea[name='message'], #simple-form input[name='file']", function (e) {

        var id = $(this).attr('id');
        var value = $(this).val();

        $('.simple-form .mf-error').removeClass('active');
        $('.simple-form input').removeClass('error');
        $('.simple-form textarea').removeClass('error');

        if (id == 'name') {

            if (value.length) {

                $(this).removeClass('error');
                $(this).closest('.simple-form').find('.mf-error.' + id).removeClass('active');

            } else {

                $(this).addClass('error');
                $(this).closest('.simple-form').find('.mf-error.' + id).addClass('active');
            }

        } else if (id == 'email') {

            var pattern = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (value.length && pattern.test(value)) {

                $(this).removeClass('error');
                $(this).closest('.simple-form').find('.mf-error.' + id).removeClass('active');

            } else {

                $(this).addClass('error');
                $(this).closest('.simple-form').find('.mf-error.' + id).addClass('active');

            }

        } else if (id == 'phone') {

            var phoneNumber = $(this).val().replace(/[^\d.]/ig, '');
            var phoneMask = $(this).attr('data-mask');

            if (phoneMask) {

                $(this).inputmask('mask', {
                    'mask': phoneMask,
                    'showMaskOnHover': false
                });

            }

            if (phoneNumber.length == 10) {

                $(this).removeClass('error');
                $(this).closest('.simple-form').find('.mf-error.' + id).removeClass('active');

            } else {

                $(this).addClass('error');
                $(this).closest('.simple-form').find('.mf-error.' + id).addClass('active');

            }

        } else if (id == 'message') {

            if (value.length) {

                $(this).removeClass('error');
                $(this).closest('.simple-form').find('.mf-error.' + id).removeClass('active');

            } else {

                $(this).addClass('error');
                $(this).closest('.simple-form').find('.mf-error.' + id).addClass('active');

            }

        }

    });

    //Отправка формы
    $('#simple-form').submit(function (e) {

        //Прелоадер
        $('#loader').show();

        var form = $("input[name='FORM_ID']", this).val();
        var ajaxMode = $("input[name='AJAX_MODE']", this).val();

        if (ajaxMode == 'Y') {

            e.preventDefault();

            var url = $("input[name='PATH_TO_AJAX']", this).val();
            var msg = new FormData($(this).get(0));

            $.ajax({
                url: url,
                type: 'POST',
                data: msg,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {

                    $('.simple-form.' + form).html($('#simple-form', data).html());
                    $('#loader').hide();

                }
            });

        }

    });

});
