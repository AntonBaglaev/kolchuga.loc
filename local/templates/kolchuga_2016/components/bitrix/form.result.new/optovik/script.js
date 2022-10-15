;(function($){

    $(document).ready(function(){

         var form = $('#optovik_form').find('form'),
            url = '/local/tools/optovik.php';


        form.submit( function( e ) {
            var f = new FormData( this );
            $.ajax( {
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
            });
            e.preventDefault();
        } );

    });

}(jQuery));

