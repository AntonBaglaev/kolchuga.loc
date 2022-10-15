/**
 * Created by Corndev on 29/06/16.
 */
;(function($){

    $(document).ready(function(){

        var form = $('.js-modal-reserve').find('form[name="SIMPLE_FORM_1"]'),
            url = '/local/tools/preorder.php';

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

                    data.success = '' + data.success + '<br/>Номер заказа: ' + order_id;

                    form.html('<div>'+data.success+'</div>')
                }

            }, 'json').fail(function(xhr, status, error) {
                console.log(status+": "+error);
            });


            e.preventDefault();
        });

    });

}(jQuery));
