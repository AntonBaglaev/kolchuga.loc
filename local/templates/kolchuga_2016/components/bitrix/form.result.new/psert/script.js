;(function($){

    $(document).ready(function(){

         var form = $('#modal-psert').find('form'),
            url = '/local/tools/psert.php';


        form.submit( function( e ) {
            var f = new FormData( this );
            var link = window.location + ''.split('?')[0];
			form.find('input[data-code="ps"]').val(link);
            /*$.ajax( {
                url: url,
                type: 'POST',
                data: new FormData( this ),
                processData: false,
                contentType: false,
                dataType: 'json',
            } ).done(function( data ) {
                if(data.errors){
                    form.find('.error').show().html(data.errors_text);
                } else {
                    data.success = 'Ваш вопрос отправлен и будет обработан в течение нескольких часов';
                    form.html('<div style="color:green;">'+data.success+'</div>')
                }
            });*/
			$.post(url, form.serialize() + '&web_form_submit=Y', function(data){

                if(data.errors){
                    form.find('.error').show().html(data.errors_text);
                } else {
                    data.success = 'Ваш вопрос отправлен и будет обработан в течение нескольких часов';
                    form.html('<div style="color:green;">'+data.success+'</div>')
                }

            }, 'json').fail(function(xhr, status, error) {
                console.log(status+": "+error);
            });
            e.preventDefault();
        } );

    });

}(jQuery));

