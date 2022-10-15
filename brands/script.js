$(function () {

    if (component_ajax_id && $('.sidebar__menu a').length) {
        $('.sidebar__menu a:not(._file)').each(function () {

            var curUrl = $(this).attr('href');

            if (curUrl)
                $(this).attr("onClick", "BX.ajax.insertToNode('" + curUrl + (curUrl.indexOf('?') > -1 ? '&' : '?') + "bxajaxid=" + component_ajax_id + "', 'comp_" + component_ajax_id + "'); return false;");
        });
    }

    if (component_ajax_id && $('.section_brand a').length) {
        $('.section_brand a:not(._file)').each(function () {

            var curUrl = $(this).attr('href');

            if (curUrl)
                $(this).attr("onClick", "BX.ajax.insertToNode('" + curUrl + (curUrl.indexOf('?') > -1 ? '&' : '?') + "bxajaxid=" + component_ajax_id + "', 'comp_" + component_ajax_id + "'); return false;");
        });
    }

    $(document).on('click', '.sidebar__menu a:not(._file), .section_brand a:not(._file)', function (e) {
        e.preventDefault();

        $('.sidebar__menu li').removeClass('active');

        if ($(this).attr('href')) {
            window.history.pushState('', '', $(this).attr('href'));
            $(this).closest('li').addClass('active');

            if ($('#comp_' + component_ajax_id).length) {
                var intPosition = $('#comp_' + component_ajax_id).offset().top - 100;
                $('html, body').animate({scrollTop: intPosition}, 0);
            }
        }

        return true;
    });


    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();

        if ($(this).attr('href')) {
            window.history.pushState('', '', $(this).attr('href'));
            $(this).closest('li').addClass('active');

            if ($('#comp_' + component_ajax_id).length) {
                var intPosition = $('#comp_' + component_ajax_id).offset().top - 100;
                $('html, body').animate({scrollTop: intPosition}, 600);
            }
        }

        return true;
    });

    $nav = $('.sidebar__menu-sticky');
    $nav.css('width', $nav.outerWidth());
    $window = $(window);
    $intHeight = $nav.offset().top;

    $window.scroll(function () {
        if ($window.scrollTop() > $intHeight) {
            $nav.addClass('__sticky');
        } else {
            $nav.removeClass('__sticky');
        }
    });

    // Принудительная прокрутка в начало при обновлении страницы
    if (performance.navigation.type == 1) {
        $(this).scrollTop(30);
    }

});

$(document).on('ready', function () {
    $(window).on('load resize', function () {
        if ($(window).width() < 640) {
            $('.setslick').slick({
                infinite: true,
                dots: true,
                arrows: false,
                slidesToShow: 2,
                slidesToScroll: 2
            });
        } else {
            $(".setslick").slick("unslick");
        }
    });
});
