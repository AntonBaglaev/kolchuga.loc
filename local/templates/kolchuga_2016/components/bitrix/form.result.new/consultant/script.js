var popupTimeOut = 15;

function consultant_setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}
function consultant_fadeInPopUp(form_class){
    var $wrap = $('#'+form_class);
    $('#modal-consultant').removeClass('mfp-hide');
}

function consultant_fadeInPopUpTimeOut(){
    var now = new Date().getTime();
    var inTime = consultant_getCookie('popupTimeOut')*1;
    var wait = popupTimeOut*1000;
    var lastTime = (inTime + wait) - now;
    setTimeout(function(){
        consultant_fadeInPopUp('popup_timeout', '');
        consultant_setCookie('popupTimeOut', 'done','','/');
    }, lastTime);
}

function consultant_getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}

;(function($){

    $(document).ready(function(){

        if($('#bid').text() * 1 < 1 && $(window).innerWidth() > 768){
            if(!consultant_getCookie('popupTimeOut')){
                var now = new Date();
                consultant_setCookie('popupTimeOut', now.getTime(),0,'/');
                consultant_fadeInPopUpTimeOut();
            }else if(consultant_getCookie('popupTimeOut') != 'done'){
                consultant_fadeInPopUpTimeOut();
            }
    
    
            $('.close-consultant').on('click', function(){
                consultant_setCookie('consultant_hide', 1);
                $('#modal-consultant').remove();
            });
            
        }

        var form = $('#modal-consultant').find('form'),
            url = '/local/tools/consultant.php';


        form
            .submit( function( e ) {
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
                        consultant_setCookie('consultant_hide', 1);
                        data.success = 'Ваш вопрос отправлен и будет обработан в течение нескольких часов';
                        form.html('<div>'+data.success+'</div>')
                    }
                });
                e.preventDefault();
            } );

        form.on('submit', function(e){

            /*var date = new Date(),
                order_id = '#' + date.getFullYear() + date.getMonth() + date.getDate() + date.getHours() + date.getMinutes(),
                link = window.location + ''.split('?')[0],
                sum = $('.js-price').text(),
                name = $('.js-page-title').text();



            form.find('input[data-code="PRODUCT_URL"]').val(link);
            form.find('input[data-code="ORDERID"]').val(order_id);
            form.find('input[data-code="ORDER_SUM"]').val(sum);
            form.find('input[data-code="ORDER_NAME"]').val(name);
            console.log(form.serialize());
            $.post(url, form.serialize() + '&web_form_submit=Y', function(data){

                if(data.errors){
                    form.find('.error').show().html(data.errors_text);
                } else {
                    consultant_setCookie('consultant_hide', 1);
                    data.success = 'Ваш вопрос отправлен и будет обработан в течение нескольких часов';

                    form.html('<div>'+data.success+'</div>')
                }

            }, 'json');


            e.preventDefault();*/
        });

    });

}(jQuery));

