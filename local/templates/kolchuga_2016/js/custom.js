function YandexRG(rg)
{
  if (rg &&
      rg != 'undefined')
  {
    return window.yaCounter36451865.reachGoal(rg);
  }
}

jQuery(document).ready(function(){

  jQuery("*[rel_mc]").click(function(){

      YandexRG(jQuery(this).attr("rel_mc"));
  
  });

  
  jQuery(".sTabs").tabs();
  
   var owlbrand = $('.js_recommend');
  
   if (owlbrand.length > 0)
   {
        owlbrand.owlCarousel({
            loop:true,
            items:4,
            margin:10,
            dots:false,
            nav:true,
            navText:['<span class="icon-arrow-left3"></span>','<span class="icon-arrow-right3"></span>'],
            responsiveClass:true,
            responsive:{
                0:{
                    items:1
                },
                500:{
                    items:2
                },
                768:{
                    items:3
                },
                1024:{
                    items:4
                },
                1100:{
                    items:4
                }
            }
        });
   }
   
   
   var owlRecommend = $('.owl-recommend');
  
   if (owlRecommend.length > 0)
   {
        owlRecommend.owlCarousel({
            loop:false,
            items:4,
            margin:10,
            dots:false,
            nav:true,
            navText:['<span class="icon-arrow-left3"></span>','<span class="icon-arrow-right3"></span>'],
            responsiveClass:true,
            responsive:{
                0:{
                    items:1
                },
                500:{
                    items:2
                },
                768:{
                    items:3
                },
                1024:{
                    items:4
                },
                1100:{
                    items:4
                }
            }
        });
   }
   
   jQuery('.c_sort_form .sort_select').change(function(){
      console.log(232323);
      var sortOrder = jQuery(this).find('option:selected').data('order');
      if(sortOrder){
        var objSortOrder = jQuery('.c_sort_form input[name="sort_order"]');
        objSortOrder.val(sortOrder);
        function checkValSort(objSortOrder, sortOrder) {
          if(objSortOrder.val() == sortOrder){
            jQuery('.c_sort_form').submit();
          }
        }
        setTimeout(checkValSort(objSortOrder, sortOrder), 50);
      }
   });

   $('.tel_block_title span').click(function(){
      if ($(this).hasClass('tel_active')) {
        $('.header__top_tel_block_text .tel_block_text').slideUp();
        $(this).removeClass('tel_active');
      } else {
        $(this).addClass('tel_active');
        $('.header__top_tel_block_text .tel_block_text').slideDown();
      }
   });


   function clearSearch(objResultShowClass, objResultError, objResultInner){
    objResultShowClass.addClass('inv');
    objResultError.removeClass('inv');
    objResultInner.html('');
    BX.closeWait();
   }

   function initSearch(){
      BX.showWait('smart_search_query');
      var objParent = $('header .smart_search');
      var queryStr = objParent.find('.input_inside').val();
      var categoryId = objParent.find('input[name="section"]:checked').val();

      var objResultShowClass = objParent.find('.show_result');
      var objResultInner = objParent.find('.s_inner');
      var objResultError = objParent.find('.no_result');

      if(queryStr.length > 2){
          $.ajax({
              type: "POST",
              url: '/include/dev/ajax_search.php',
              data: 'search='+queryStr+'&categoryId='+categoryId,
              success: function(out){
                //console.log(out);
                if(out.indexOf('false') < 0){
                  objResultShowClass.removeClass('inv');
                  objResultInner.html(out);
                  objResultError.addClass('inv');
                  BX.closeWait();
                }else{
                  clearSearch(objResultShowClass, objResultError, objResultInner);
                }
              }
          });
      }else{
        clearSearch(objResultShowClass, objResultError, objResultInner);
      }

   }

  $('header .smart_search .input_inside').keyup(function(){
    initSearch();
  });
  $('header .smart_search input[name="section"]').change(function(){
    initSearch();
  });
  
	$(window).scroll(function() {
	  if($(this).scrollTop() != 0 && $(this).width() > 740 ) {
		$('#toTops').css('display','block');            
	  } else {
		$('#toTops').css('display','none');            
	  }
   });

   $('#toTops').click(function() {
				  $('body,html').animate({scrollTop:0},800);
   });

});

// Проверяем, можно ли использовать Webp формат
function canUseWebp() {
    // Создаем элемент canvas
    let elem = document.createElement('canvas');
    // Приводим элемент к булеву типу
    if (!!(elem.getContext && elem.getContext('2d'))) {
        // Создаем изображение в формате webp, возвращаем индекс искомого элемента и сразу же проверяем его
        return elem.toDataURL('image/webp').indexOf('data:image/webp') == 0;
    }
    // Иначе Webp не используем
    return false;
}
window.onload = function () {
    // Получаем все элементы с дата-атрибутом data-bg
    let images = document.querySelectorAll('[data-bg]');
    // Проходимся по каждому
    for (let i = 0; i < images.length; i++) {
        // Получаем значение каждого дата-атрибута
        let image = images[i].getAttribute('data-bg');
        // Каждому найденному элементу задаем свойство background-image с изображение формата jpg
        images[i].style.backgroundImage = 'url(' + image + ')';
    }

    // Проверяем, является ли браузер посетителя сайта Firefox и получаем его версию
    let isitFirefox = window.navigator.userAgent.match(/Firefox\/([0-9]+)\./);
    let firefoxVer = isitFirefox ? parseInt(isitFirefox[1]) : 0;

    // Если есть поддержка Webp или браузер Firefox версии больше или равно 65
    if (canUseWebp() || firefoxVer >= 65) {
        // Делаем все то же самое что и для jpg, но уже для изображений формата Webp
        let imagesWebp = document.querySelectorAll('[data-bg-webp]');
        for (let i = 0; i < imagesWebp.length; i++) {
            let imageWebp = imagesWebp[i].getAttribute('data-bg-webp');
            imagesWebp[i].style.backgroundImage = 'url(' + imageWebp + ')';
        }
    }
};

$(function () {

    $(window).scroll(function () {

        let eTop = $('.header__top_tel').outerHeight(),
            eBeyond = $('#panel').outerHeight(),
            eNavbar = $('.header__top_nav').outerHeight();

        let eGutter = eTop + eBeyond,
            eGutterTotal = eTop + eNavbar;

        if ($(this).scrollTop() >= eGutter) {
            $('body').css("padding-top", eGutterTotal);
            $('.site-header').addClass('navbar-stuck');
        } else if ($(this).scrollTop() < eGutter) {
            $('body').css("padding-top", 0);
            $('.site-header').removeClass('navbar-stuck');
        }
    });

});
