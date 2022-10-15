$(document).ready(function () {
    var fixed = false;
    $(window).scroll(function (event) {

        var st = $(document).scrollTop();
        var hcont = $('.next_recomend').outerHeight();
        var wcont = $('.next_recomend').outerWidth();
        var elementstop = $('.footer').offset().top - hcont;
        if ($('.service_item').length != 0) {
            elementstop = $('.service_item').offset().top - hcont - 30;
        }

        if ($('.anchor_next_recomend').length) {

            var action_top = $('.anchor_next_recomend').offset().top;
            //console.log(st+' -> '+elementstop);

            if (st > action_top) {
                if (elementstop > 0 && st < elementstop && !fixed) {
                    $('.next_recomend').addClass('fixed').css({"width": wcont + "px"});
                    fixed = true;
                } else if (elementstop < 1 && !fixed) {
                    $('.next_recomend').addClass('fixed').css({"width": wcont + "px"});
                    fixed = true;
                } else if (st > elementstop && fixed) {
                    $('.next_recomend').removeClass('fixed').css({"width": "auto"});
                    fixed = false;
                }
            } else {
                if (fixed) {
                    $('.next_recomend').removeClass('fixed').css({"width": "auto"});
                    fixed = false;
                }
            }
        }

    });
})