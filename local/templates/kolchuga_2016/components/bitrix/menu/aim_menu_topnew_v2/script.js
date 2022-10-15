$(function () {

    instantResize();

    $(window).resize(function () {
        instantResize();
    });

});

function instantResize() {
    if ($('.top-menu .with-submenu').length) {
        $('.top-menu .with-submenu').each(function () {

            let intWidth = $(this).find('.submenu').width();
            let intOffset = $(this).offset();
            let intWindowWidth = $(window).width();
            let intDimension = intWindowWidth - intOffset.left;

            if (intDimension < intWidth) {
                $(this).find('.submenu').css('right', 0);
            } else {
                $(this).find('.submenu').css('right', 'initial');
            }

        });
    }
}