/**
 * Created by Corndev on 29/06/16.
 */
;(function($){

    $(document).ready(function(){

        var form = $('.js-modal-reserve').find('form[name="SIMPLE_FORM_3"]'),
            url = '/local/tools/uncertainty.php';

        form.on('submit', function(e){

            var link = window.location + ''.split('?')[0];

            form.find('input[data-code="PRODUCT_URL"]').val(link);
        
            $.post(url, form.serialize() + '&web_form_submit=Y', function(data){

                if(data.errors){
                    form.find('.error').show().html(data.errors_text);
                } else {

                    data.success = '' + data.success;

                    form.html('<div>'+data.success+'</div>')
                }

            }, 'json').fail(function(xhr, status, error) {
                console.log(status+": "+error);
            });


            e.preventDefault();
        });

    });

}(jQuery));
