$(document).ready(function () {
    // Инициализируем карусель
    $('.home-slider-carousel').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        dots: true,
        items: 1,
        autoplay: true,
        autoplayTimeout: 7000,
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
        autoplayHoverPause: true,
        navText: ['<span class="icon-arrow-left3"></span>', '<span class="icon-arrow-right3"></span>'],
        autoHeight: true
    });
});

function homeSliderCounter(event) {
    if (!event.namespace) {
        return;
    }
}

function instantLocation(href) {
    if (!href)
        return;

    window.location.href = href;
}
