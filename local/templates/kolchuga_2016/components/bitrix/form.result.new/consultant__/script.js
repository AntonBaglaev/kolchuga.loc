/**
 * Created by Corndev on 29/06/16.
 */

function consultant_setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

;(function($){

    $(document).ready(function(){
        $('.close-consultant').on('click', function(){
            consultant_setCookie('consultant_hide', 1);
            $('#modal-consultant').remove();
        });

        var form = $('#modal-consultant').find('form'),
            url = '/local/tools/consultant.php';

        form.on('submit', function(e){

            var date = new Date(),
                order_id = '#' + date.getFullYear() + date.getMonth() + date.getDate() + date.getHours() + date.getMinutes(),
                link = window.location + ''.split('?')[0],
                sum = $('.js-price').text(),
                name = $('.js-page-title').text();



            form.find('input[data-code="PRODUCT_URL"]').val(link);
            form.find('input[data-code="ORDERID"]').val(order_id);
            form.find('input[data-code="ORDER_SUM"]').val(sum);
            form.find('input[data-code="ORDER_NAME"]').val(name);

            $.post(url, form.serialize() + '&web_form_submit=Y', function(data){

                if(data.errors){
                    form.find('.error').show().html(data.errors_text);
                } else {
                    consultant_setCookie('consultant_hide', 1);
                    data.success = 'Ваш вопрос отправлен и будет обработан в течение нескольких часов';

                    form.html('<div>'+data.success+'</div>')
                }

            }, 'json');


            e.preventDefault();
        });

    });

}(jQuery));