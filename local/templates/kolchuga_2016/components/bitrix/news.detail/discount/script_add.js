var stopScrollBasket = false,
    arStatusBasketPhoenix = {},
    contentSideHeight = 0,
    menuSideHeight = 0,
    basketPoolQuantity = {},
    cur_pos = 0,
    cart_page = "N",
    customEvent = false;


var paramsLazy = {
    scrollDirection: 'vertical',
    threshold: 500,
    visibleOnly: true,
    effect: 'fadeIn'
};


function generateMaps(container){
    var mapBlock = $(".iframe-map-area", container);
    mapBlock.after(mapBlock.attr("data-src"));
    mapBlock.remove();
}
function generateVideos(container){

    var videoBlock = $(".iframe-video-area", container);
        videoBlock.after(videoBlock.attr("data-src"));
        videoBlock.remove();
}


function showWaitSearch (form){
    form.find(".circleG-area").addClass('active');
}
function hideWaitSearch (form){
    form.find(".circleG-area").removeClass('active');
}

function openCart()
{
    $('.no-click-block').addClass('on');
    $('div.cart-parent').addClass('open');
    startBlurWrapperContainer();
    var cartOut = setTimeout(function() {
        $('div.cart-parent').addClass('on');
        clearTimeout(cartOut);
    }, 200);
}
function closeCart()
{
    stopBlurWrapperContainer();
    $('div.cart-parent').removeClass('on');
    $('.no-click-block').removeClass('on');
    var closeCartOut = setTimeout(function(){
        $('div.cart-parent').removeClass('open');
        clearTimeout(closeCartOut);
    }, 700);
}

function showFormOrder(){
    if($(window).width() <= 767)
        $(".right-p", ".basket-style.page").removeClass('d-none');
}
function hideFormOrder(){
    if($(window).width() <= 767)
        $(".right-p", ".basket-style.page").addClass('d-none');        
}

function showTabContent(arParams)
{
    var curUrlParam = "-1";
    var urlParams = getUrlParams();
    arParams = arParams || {};

  
    if(urlParams['url-tab'] !== undefined)
    {
        curUrlParam = urlParams['url-tab'];

        if(curUrlParam == "products" && arParams.products)
            curUrlParam = "products";
        
        else if (curUrlParam == "delayed" && arParams.delay)
            curUrlParam = "delayed";

        else if(arParams.products)
            curUrlParam = "products";
        
        else if(arParams.delay)
            curUrlParam = "delayed";
    }


    if($(".url-tab[data-url-tab='"+curUrlParam+"']").length > 0)
    {

        $(".url-tab[data-url-tab='"+curUrlParam+"']").parents(".url-tab-parent")
        .find(".url-tab").removeClass('active').parents(".url-tab-parent").find(".url-tab-content").removeClass('active');

        $(".url-tab[data-url-tab='"+curUrlParam+"']").addClass('active');
        $(".url-tab-content[data-url-tab='"+curUrlParam+"']").addClass('active');

        if(curUrlParam == "delayed")
            hideFormOrder();
        
    }
    
}

function getChar(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57)) {
        return null;
    }
    return true;
}

function menuOffset(li) {
    var mainPosition = $(li).parents('.main-menu-inner').width() + $(li).parents(
        '.main-menu-inner').offset().left;
    var liPosition = $(li).children('ul').offset().left + $(li).children('ul').width();
    if (liPosition >= mainPosition) $(li).addClass('reverse');
}

function mobileMenuPositionFooter() {
    if ($('.open-menu-mobile').height() > ($(
            'div.open-menu-mobile div.menu-mobile-inner').outerHeight() + $(
            'div.open-menu-mobile div.foot-wrap').outerHeight(true))) $(
        'div.open-menu-mobile div.foot-wrap').addClass('absolute');
    else {
        $('div.open-menu-mobile div.foot-wrap').removeClass('absolute');
    }
}

function openMenuFooterPos() {
    var totalHeight = $('.open-menu .head-menu-wrap').outerHeight(true) + $(
        '.open-menu .body-menu').outerHeight(true) + $(
        '.open-menu .footer-menu-wrap').outerHeight(true);
    var needHeight = $('.open-menu').height() - totalHeight + $(
        '.open-menu .body-menu').outerHeight();
    if ($(window).height() > totalHeight) $('.open-menu .body-menu').css(
        'min-height', needHeight + 'px');
}

function phoenixResizeVideo() {
    var win_height = $('div.video-modal').height();
    var modal = 590;
    if ($(window).width() > 767) {
        if (win_height > modal) $("div.video-modal div.phoenix-modal-dialog").addClass(
            'pos-absolute');
        else {
            $("div.video-modal div.phoenix-modal-dialog").removeClass('pos-absolute');
        }
    } else {
        $("div.video-modal div.phoenix-modal-dialog").addClass('pos-absolute');
    }
}

function scrollToBlock(dist, elem, offset) {
    var moreDist = 0;

    offset = offset || 0;
    elem = elem || 0;

    if ($('header').hasClass("fixed")) 
        moreDist = 69;

    if ($("div.catalog-card-wrap").length >0 || $("div.catalog-list-wrap").length>0 ) {
        moreDist = 0;

        if ($('header').hasClass("fixed")) moreDist = 80;
        if (elem) {
            if (elem.hasClass('review')) moreDist = 100;
        }
    }
    var destinationhref = parseInt($(dist).offset().top - moreDist - offset);

    
    $("html:not(:animated),body:not(:animated)").animate({
        scrollTop: destinationhref
    }, 1000, "linear", function() {

        setTimeout(
            function(){

                if( 100 < Math.abs(parseInt($(dist).offset().top - moreDist - offset) - destinationhref) )
                {
                    $("html:not(:animated),body:not(:animated)").animate({
                        scrollTop: parseInt($(dist).offset().top - moreDist - offset)
                    }, 300, "linear");
                }
            }, 300
        ); 
      }
    );
}


function timerCookie(form) {
    var timeout = true;
    var timer = form.find('input.timerVal').val();
    var forCookieTime = parseFloat(form.find('input.forCookieTime').val());
    var totalTime = 0;
    var mainTime = new Date().getTime();
    var idElem = form.find("input[name='element']").val();
    var idSect = form.find('input.idSect').val();
    var firstEnter = BX.getCookie($(".domen-url-for-cookie").val()+'_phoenixFirstEnter' + idSect + idElem);
    var firstEnterVal = BX.getCookie($(".domen-url-for-cookie").val()+'_phoenixFirstEnterVal' + idSect + idElem);
    setTimeout(function() {
        form.css('min-height', form.outerHeight());
    }, 100);

    if(forCookieTime <= 0)
        forCookieTime = 1;
    
    form.find('.phoenixtimer').addClass('active');
    if (typeof(firstEnter) == "undefined" || firstEnterVal != timer) {
        BX.setCookie($(".domen-url-for-cookie").val()+'_phoenixFirstEnter' + idSect + idElem, mainTime, {
            expires: forCookieTime * 60 * 60
        });
        BX.setCookie($(".domen-url-for-cookie").val()+'_phoenixFirstEnterVal' + idSect + idElem, timer, {
            expires: forCookieTime * 60 * 60
        });
        firstEnter = BX.getCookie($(".domen-url-for-cookie").val()+'_phoenixFirstEnter' + idSect + idElem);
        firstEnterVal = BX.getCookie($(".domen-url-for-cookie").val()+'_phoenixFirstEnterVal' + idSect + idElem);
    }
    totalTime = ((mainTime - firstEnter) / 1000).toFixed();
    if (totalTime < timer * 60) timer = timer * 60 - totalTime;
    else {
        timeout = false;
    }
    if (timeout) form.find('.phoenixtimer').countdown({
        until: timer,
        format: 'HMS',
        onExpiry: liftOff,
        layout: form.find('.phoenixtimer').html()
    }, $.countdown.regionalOptions['ru']);
    else {
        form.find('.questions').removeClass('active');
        form.find('.timeout_text').addClass('active');
    }

    function liftOff() {
        form.find('.questions').removeClass('active');
        form.find('.timeout_text').addClass('active');
    }
}

function parseCount(newVal, ratio, minVal) {

    var ost = newVal % ratio;
    var ratio_ = ratio - ost;



    newVal = newVal - minVal;
    newVal -= (newVal % ratio);

    if(ratio_ >= ost)
    {
        newVal += minVal;
    }

    else
    {
        newVal += minVal + ratio;
    }


    if (newVal <= minVal || isNaN(newVal))
        newVal = minVal;

    return newVal;

}

function formatNum(val) {
    val = String(val).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1 ');
    return val;
}

function formAttentionScroll(dist, parent) {
    $(parent).animate({
        scrollTop: dist
    }, 700);
}


function setHeaderBgImg (attr){
    if(typeof attr !== 'undefined')
        $('header').css({"background-image": "url('"+attr+"')"});
}

var lazyController = false,
    parentContainerSlide = {},
    parent = {},
    arImagesLazyload = {};




function updateLazyLoad(){

    $('.lazyload').Lazy(
        {
            scrollDirection: 'vertical',
            threshold: 500,
            visibleOnly: true,
            effect: 'fadeIn',

            afterLoad: function(element)
            {
                if(contentSideHeight>0)
                    contentSideHeight = $(".parent-fixedSrollBlock").outerHeight(true);

                parent = $(element).parent();
                parentContainerSlide = parent.find('.parent-slider-item-js');

                if($(element).hasClass("slider-start"))
                {

                    if(typeof arImagesLazyload["id"+$(element).attr("data-id")] === "undefined") 
                        arImagesLazyload["id"+$(element).attr("data-id")] = {"s": 0, "f": 0, "type": null};

                    arImagesLazyload["id"+$(element).attr("data-id")].s = 1;

          
                    arImagesLazyload["id"+$(element).attr("data-id")].type = parentContainerSlide;

                }


                if($(element).hasClass('slider-finish'))
                {

                    if(typeof arImagesLazyload["id"+$(element).attr("data-id")] === "undefined") 
                        arImagesLazyload["id"+$(element).attr("data-id")] = {"s": 0, "f": 0, "type": null};
                    
                    arImagesLazyload["id"+$(element).attr("data-id")].f = 1;
                    arImagesLazyload["id"+$(element).attr("data-id")].type = parentContainerSlide;

                }

                if($(element).hasClass('slider-finish') || $(element).hasClass("slider-start"))
                {
                    for (key in arImagesLazyload){

                        if(arImagesLazyload[key].s == 1 && arImagesLazyload[key].f == 1)
                        {

                            /*if( arImagesLazyload[key].type.hasClass('first-slider') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initFSlider(arImagesLazyload[key].type);*/


                            if( arImagesLazyload[key].type.hasClass('block-slider-list') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initSlider(arImagesLazyload[key].type);

                            if( arImagesLazyload[key].type.hasClass('slider') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initOpSlider(arImagesLazyload[key].type);

                            if( arImagesLazyload[key].type.hasClass('slider-mini') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initOpMiniSlider(arImagesLazyload[key].type);

                            if( arImagesLazyload[key].type.hasClass('slider_catalog_big_items') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initCSlider(arImagesLazyload[key].type);

                            if( arImagesLazyload[key].type.hasClass('partners-slider-list') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initPartnersSlider(arImagesLazyload[key].type);
                            

                            if( arImagesLazyload[key].type.hasClass('slider-gallery') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initGallerySlider(arImagesLazyload[key].type);

                            if( arImagesLazyload[key].type.hasClass('big-advantages-slide') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initAdvantagesBigSlider(arImagesLazyload[key].type);

                            if( arImagesLazyload[key].type.hasClass('small-advantages-slide') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initAdvantagesSmallSlider(arImagesLazyload[key].type);

                            if( arImagesLazyload[key].type.hasClass('slider-news-big') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initNewsBigSlider(arImagesLazyload[key].type);

                            if( arImagesLazyload[key].type.hasClass('slider-news-small') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initNewsSmallSlider(arImagesLazyload[key].type);

                            if( arImagesLazyload[key].type.hasClass('menu-banner-slider') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initBannersSlider(arImagesLazyload[key].type);

                            if( arImagesLazyload[key].type.hasClass('slider-news-detail') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initNewsDetailSlider(arImagesLazyload[key].type);

                            if( arImagesLazyload[key].type.hasClass('catalog-list-slider') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initCatalogDetailSlider(arImagesLazyload[key].type);

                            if( arImagesLazyload[key].type.hasClass('section-items-slider') && !arImagesLazyload[key].type.hasClass('slider-init'))
                                initCatalogSubSectionsSlider(arImagesLazyload[key].type);

                            


                            delete arImagesLazyload[key];
                        }
                    }
                }


                if($(element).parents(".parent-video-bg").find(".videoBG").length>0)
                    correctSizeVideoBg($(element).parents(".parent-video-bg").find(".videoBG"));

                
                if($(element).hasClass('map-start'))
                    generateMaps($(element).parents("div.block"));

                if($(element).hasClass('video-start'))
                    generateVideos($(element).parents("div.block"));

                if($(element).hasClass('video-start-js'))
                    generateVideos($(element).parents("div.video-start-parent"));

                if($(element).hasClass('videoBG-start'))
                    generateVideoBG($(element).parents("div.block"));

                if($(element).hasClass('videoBG-start-fb'))
                    generateVideoBG($(element).parents("div.first-block"));
                
            }
        }
    );
    
}

function initMobileSideMenu(){

    if( $(window).width() <= 991 && $(".menu-navigation-inner").length>0)
    {
        var clone = $(".menu-navigation-inner").clone();
        $(".menu-navigation-inner").remove();
        clone.addClass('wr-transform-to-dialog-by-mob d-none container-close-from-scroll').children().addClass('transform-to-dialog-by-mob').find(".scroll").addClass('from-modal');
        clone.appendTo("body");
    }

}


function setSharesValues()
{

    if($(".public_shares").length>0)
    {

        var title = "",
            description = "",
            image = "",
            url = "";

        if($("meta[property=\"og:title\"]").length)
            title = $("meta[property=\"og:title\"]").attr("content");

        if($("meta[property=\"og:description\"]").length)
            description = $("meta[property=\"og:description\"]").attr("content");

        if($("meta[property=\"og:image\"]").length)
            image = $("meta[property=\"og:image\"]").attr("content");

        if($("meta[property=\"og:url\"]").length)
            url = $("meta[property=\"og:url\"]").attr("content");


        $(".public_shares a.vkontakte").attr("onclick", "Share.vkontakte('"+url+"','"+title+"','"+image+"', '"+description+"')");
        $(".public_shares a.facebook").attr("onclick", "Share.facebook('"+url+"','"+title+"','"+image+"', '"+description+"')");
        $(".public_shares a.twitter").attr("onclick", "Share.twitter('"+url+"','"+title+"')");

    }
}


$(document).ready(function()
{
    setSharesValues();
    
    initMobileSideMenu();
    
    if ( $(window).width() >= 991 )
        $(".slide-hidden-lg").remove();
    
    else
    {
        $(".slide-hidden-xs").remove();
    }

    if ( $(window).width() >= 768)
    {
        /*$('div.wrap-first-slider.visible-xs').remove();*/
        setHeaderBgImg($('header').attr('data-src-lg'));
    }
    

    if ( $(window).width() < 768)
    {
        /*$('div.wrap-first-slider.hidden-xs').remove();*/
        setHeaderBgImg($('header').attr('data-src-xs'));

        if($(".error-404").length>0)
            $("div.wrapper").addClass('overflow-visible');
        
    }


    updateLazyLoad();

    if (window.frameCacheVars !== undefined) 
    {
        BX.addCustomEvent("onFrameDataReceived" , function(json) {
            customEvent = true;
        });
    }

    
    
});

function initZoomer(obj)
{
    /*if($(window).width() > 1024)
        obj.zoom();*/
}


function correctBgStyle(obj)
{
    $('div.lazyload', obj).each(
        function(index, element)
        {
            if(typeof $(element).attr("src") != "undefined")
            {
                $(element).attr( "style", "background-image: url("+$(element).attr("src")+");");
                $(element).removeAttr("src");
                
            }
        }
       
    ); 
}

function correctLazyloadInSlider(obj)
{
    if($('.lazyload', obj).length)
    {
        $('.lazyload', obj).each(
            function(index, element)
            {
                $(element).attr("src", $(element).attr("data-src"));
                $(element).removeAttr("data-src");
            }
           
        );

        if($('div.lazyload', obj).length)
            correctBgStyle(obj);
        
    }
}

function initNewsDetailSlider(obj){
    obj.on('init', function(event, slick){
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        correctLazyloadInSlider(obj);
        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }
    });

    obj.slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: false,
        infinite: true,
        centerPadding: 0,
        arrows: true,
        responsive: [{
            breakpoint: 991,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 575.98,
            settings: {
                slidesToShow: 1
            }
        },
        {
            breakpoint: 0,
            settings: "unslick"
        }]
    });
}

function initCatalogSubSectionsSlider(obj){

    if($(window).width() < 768)
    {
        obj.on('init', function(event, slick){
            obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
            obj.addClass("slider-init");
            correctLazyloadInSlider(obj);
        });

        obj.slick({
            arrows: false,
            slidesToShow: 3,
            slidesToScroll: 3,
            centerMode: false,
            variableWidth: true,
            infinite: false,
        });

    }
}

function initCatalogDetailSlider(obj){
    obj.on('init', function(event, slick){
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }

        correctLazyloadInSlider(obj);
    });


    obj.slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: false,
        infinite: true,
        centerPadding: 0,
        arrows: true,
        responsive: [{
            breakpoint: 991,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 575.98,
            settings: {
                slidesToShow: 2,
                adaptiveHeight: true
            }
        },
        {
            breakpoint: 0,
            settings: "unslick"
        }]
    });
}

function initNewsBigSlider(obj){
    obj.on('init', function(event, slick){
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        correctLazyloadInSlider(obj);
        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }
    });

    obj.slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: false,
        infinite: true,
        centerPadding: 0,
        centerMode: false,
        adaptiveHeight: false,
        focusOnSelect: false,
        arrows: true,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 3,
            }
        }, {
            breakpoint: 991,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 575.98,
            settings: {
                slidesToShow: 1,
                adaptiveHeight: true,
            }
        },
        {
            breakpoint: 0,
            settings: "unslick"
        }]
    });
}

function initNewsSmallSlider(obj){
    obj.on('init', function(event, slick){
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        correctLazyloadInSlider(obj);
        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }
    });

    obj.slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: false,
        infinite: true,
        centerPadding: 0,
        centerMode: false,
        adaptiveHeight: false,
        focusOnSelect: false,
        arrows: true,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 2,
            }
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 575.98,
            settings: {
                slidesToShow: 1
            }
        },
        {
            breakpoint: 0,
            settings: "unslick"
        }]
    });
}

function initAdvantagesBigSlider(obj){
    obj.on('init', function(event, slick){
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        correctLazyloadInSlider(obj);
        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }
    });

    obj.slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: false,
        infinite: true,
        centerPadding: 0,
        centerMode: false,
        adaptiveHeight: false,
        focusOnSelect: false,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 3,
            }
        }, {
            breakpoint: 991,
            settings: {
                slidesToShow: 2
            }
        },{
            breakpoint: 575.98,
            settings: {
                slidesToShow: 1
            }
        },{
            breakpoint: 0,
            settings: "unslick"
        }]
    });
}

function initBannersSlider(obj){
    obj.on('init', function(event, slick){
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        correctLazyloadInSlider(obj);

        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }
    });

    obj.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        dots: false,
        infinite: true,
        adaptiveHeight: false,
        speed: 500,
        arrows: false
    });
}


function initAdvantagesBigSlider(obj){
    obj.on('init', function(event, slick){
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        correctLazyloadInSlider(obj);
        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }
    });

    obj.slick({
        dots: true,
        adaptiveHeight: false
    });
}

function initAdvantagesSmallSlider(obj){
    obj.on('init', function(event, slick){
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        correctLazyloadInSlider(obj);

        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }
    });

    obj.slick({
        dots: true,
        slidesToShow: 2,
        adaptiveHeight: false,
        slidesToScroll: 2,
        responsive: [{
            breakpoint: 767,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        }, {
            breakpoint: 575.98,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        },{
            breakpoint: 0,
            settings: "unslick"
        }]
    });
}

function initOpMiniSlider(obj){
    obj.on('init', function(event, slick){
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        correctLazyloadInSlider(obj);
        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }
    });

    obj.slick({
        dots: true,
        infinite: true,
        adaptiveHeight: true,
        arrows: true
    });
}

function initOpSlider(obj){
    obj.on('init', function(event, slick){
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        correctLazyloadInSlider(obj);
        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }
    });

    var count = obj.attr('data-count');

    if (count == 1)
    {
        $('.slider-for', obj).slick({
            slidesToShow: 1,
            arrows: false,
            asNavFor: obj.find('.slider-nav'),
            appendArrows: obj.find('.slider-nav-wrap')
        });
        $('.slider-nav', obj).slick({
            slidesToShow: 1,
            asNavFor: obj.find('.slider-for'),
            centerPadding: 0,
            dots: false,
            centerMode: true,
            focusOnSelect: true,
        });
        obj.addClass("one-slide");
    }
    else if (count == 2)
    {
        $('.slider-for', obj).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 300,
            fade: true,
            adaptiveHeight: true,
            arrows: false,
            asNavFor: obj.find('.slider-nav'),
            appendArrows: obj.find('.slider-nav-wrap')
        });
        $('.slider-nav', obj).slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            speed: 300,
            asNavFor: obj.find('.slider-for'),
            centerPadding: 0,
            dots: false,
            centerMode: true,
            focusOnSelect: true,
            responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2
                }
            }, {
                breakpoint: 991,
                settings: {
                    slidesToShow: 1
                }
            }, {
                breakpoint: 0,
                settings: "unslick"
            }]
        });
    } 
    else
    {
        $('.slider-for', obj).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 300,
            fade: true,
            adaptiveHeight: true,
            arrows: false,
            asNavFor: obj.find('.slider-nav'),
            appendArrows: obj.find('.slider-nav-wrap')
        });
        $('.slider-nav', obj).slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            speed: 300,
            asNavFor: obj.find('.slider-for'),
            centerPadding: 0,
            dots: false,
            centerMode: true,
            focusOnSelect: true,
            responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3
                }
            }, {
                breakpoint: 991,
                settings: {
                    slidesToShow: 1
                }
            }, {
                breakpoint: 0,
                settings: "unslick"
            }]
        });
    }
}

function initCSlider(obj){

    var sliderCount = 0;

    if(obj.attr("data-count"))
        sliderCount = parseInt(obj.attr("data-count"));



    if(sliderCount > 1)
    {
        obj.on('init', function(event, slick){
            obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
            obj.addClass("slider-init");

            correctLazyloadInSlider(obj);
            if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
                correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
            }
        });

        obj.on('beforeChange', function(event, slick, currentSlide, nextSlide){
            correctLazyloadInSlider(obj);
        });

        obj.addClass("slider-init");

        obj.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            dots: true,
            infinite: false,
            adaptiveHeight: true,
            speed: 500,
            arrows: true,
            responsive: [{
                breakpoint: 767.98,
                settings: {
                    dots: false
                }
            }]
        });
    }
    else
    {
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
    }

    
}

function initGallerySlider(obj){

    var count = parseInt(obj.attr("data-slide-visible"));

    obj.on('init', function(event, slick){
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        correctLazyloadInSlider(obj);
        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }
    });

    obj.slick({
        dots: true,
        adaptiveHeight: true,
        slidesToScroll: count,
        slidesToShow: count,
        responsive: [{
            breakpoint: 767,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        }, {
            breakpoint: 0,
            settings: "unslick"
        }]
    });
}

function initPartnersSlider(obj){

    obj.on('init', function(event, slick){
        obj.find(".slick-slide").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        correctLazyloadInSlider(obj);
        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }
    });


    obj.slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        dots: false,
        infinite: true,
        adaptiveHeight: false,
        speed: 500,
        arrows: true,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 4,
            }
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: 1,
            }
        }, {
            breakpoint: 0,
            settings: "unslick"
        }]
    });
}


function setHeightForFirstSlider()
{

    if ( $(window).width() >= 768 || ($(window).width() < 768 && $(".wrap-first-slider").attr("data-full-height") == "Y"))
    {

        var height1 = 0,
            height2 = 0,
            sizeSlides = $('div.first-slider div.first-block').length;


        $('div.first-slider div.first-block').each(
            function(index){

                
                if ($(this).outerHeight() > height2){
                    height1 = $(this).height();
                    height2 = $(this).outerHeight();
                }
                

                if(sizeSlides == index+1)
                {

                    if(sizeSlides>1)
                        $('div.first-slider div.first-block-container').css("height", height1);

                    if ( $(".wrap-first-slider").attr("data-full-height") == "Y")
                    {
                        if ($(window).height() > $(".wrap-first-slider").height())
                            $(".wrap-first-slider").find(".slick-track").css("height", $(window).height() +
                            "px");
                    }

                    if ( ($(window).width() < 768 && $(".wrap-first-slider").attr("data-full-height") == "Y") )
                    {
                        if ($(window).height() > $(".wrap-first-slider").height())
                            $(".wrap-first-slider").find(".slick-track").css("height", $(window).height() +
                            "px");
                    }

                    if($('div.first-slider div.first-block').find(".videoBG").length>0)
                    {
                        $($('div.first-slider div.first-block').find(".videoBG")).each(
                            function(index)
                            {
                                correctSizeVideoBg($(this));
                            }
                        );
                    }
                    
                }

            }
        );
        
    }

}

function initFSlider(obj, size){
    var adaptiveMob = ($(window).width() < 768 && $(".wrap-first-slider").attr("data-full-height") == "Y") ? false : true,
        sizeSlides = $('div.first-slider div.first-block').length,
        params = {};

    if(size == "lg")
    {
        params = {
            dots: false,
            infinite: true,
            adaptiveHeight: false,
            speed: 500,
            pauseOnFocus: false,
            pauseOnHover: false
        };
    }
    else if(size == "xs")
    {
        params = {
            dots: false,
            infinite: true,
            adaptiveHeight: false,
            speed: 500,
            pauseOnFocus: false,
            pauseOnHover: false,
            responsive: [
                {

                    breakpoint: 767,
                    settings:{
                        adaptiveHeight: adaptiveMob,

                    }

                },
                {

                        breakpoint: 0,
                        settings: "unslick" 

                }]
        };
    }

    obj.on('init', function(event, slick){
        obj.find(".first-block").removeClass('noactive-slide-lazyload');
        setHeightForFirstSlider();
        
    });

    
    if($(".wrap-first-slider").attr("data-autoslide") == "Y")
    {
        params["autoplaySpeed"] = $(".wrap-first-slider").attr("data-autoslide-time");
        params["autoplay"] = true;
    }
    
    obj.slick(params);

}

function initSlider(obj){
    var speed = 0,
        params = {
            autoplay: false,
            autoplaySpeed: 0,
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            infinite: true,
            adaptiveHeight: false,
            speed: 500,
            arrows: true,
            responsive: [{
                breakpoint: 991,
                settings: {
                    adaptiveHeight: true
                }
            }, {
                breakpoint: 767,
                settings: {
                    dots: false
                }
            }, {
                breakpoint: 0,
                settings: "unslick"
            }]
        };

    if(typeof(obj.attr("data-scroll-speed")) != 'undefined')
        speed = +(obj.attr("data-scroll-speed"));
    

    if(obj.attr("data-count") == "1")
        params["dots"] = false;

    params["autoplay"] = false;
    params["autoplaySpeed"] = 0;

    if( speed > 0 )
    {
        params["autoplay"] = true;
        params["autoplaySpeed"] = speed * 1000;
    }

    obj.on('init', function(event, slick){
        obj.find(".block-slider-item").removeClass('noactive-slide-lazyload');
        obj.addClass("slider-init");
        correctLazyloadInSlider(obj);
        if(obj.parents(".parent-video-bg").find(".videoBG").length>0){
            correctSizeVideoBg(obj.parents(".parent-video-bg").find(".videoBG"));
        }
    });

    obj.slick(params);
}



var contentSidePosTop = 0,
    contentSidePosBot = 0,
    currentPosTop = 0,
    currentPosBot = 0,
    headerHeight = 0;


function setParamsScrollSide(){
    contentSideHeight = $(".parent-fixedSrollBlock").outerHeight(true);
    menuSideHeight = $(".selector-fixedSrollBlock-real-height").outerHeight(true);
    contentSidePosTop = $(".parent-fixedSrollBlock").offset().top;
    contentSidePosBot = contentSidePosTop + contentSideHeight;
    currentPosTop = $(document).scrollTop() + headerHeight;
    currentPosBot = currentPosTop + menuSideHeight;
}


function setPositionScrollSide(){

    setParamsScrollSide();

    if(contentSideHeight > menuSideHeight)
    {

        if(currentPosTop >= contentSidePosTop && currentPosBot <= contentSidePosBot)
        {
            $(".selector-fixedSrollBlock").removeClass('fixed-stop fixed-start');
            $(".selector-fixedSrollBlock").addClass('fixed-move');
        }

        else if(currentPosBot >= contentSidePosBot)
        {
            $(".selector-fixedSrollBlock").removeClass('fixed-move fixed-start');
            $(".selector-fixedSrollBlock").addClass('fixed-stop');
        }

        else
        {
            $(".selector-fixedSrollBlock").removeClass('fixed-move fixed-stop');
            $(".selector-fixedSrollBlock").addClass('fixed-start');
        }
    }
    else
    {
        $(".selector-fixedSrollBlock").removeClass('fixed-move fixed-stop');
        $(".selector-fixedSrollBlock").addClass('fixed-start');
    }
}
    

function setHeaderHeight(){
    if($(".fix-board").length > 0)
        headerHeight = 69;
}

function setStartParamsScrollSide(){
    $(".selector-fixedSrollBlock").css({"width": $(".wrapperWidthFixedSrollBlock").width()+"px", "top": headerHeight+"px"});
}

function scrollSideInit(){
   
    if($(".parent-fixedSrollBlock").length && $(window).width() > 1023)
    {
        setStartParamsScrollSide();
        setPositionScrollSide();

        $(window).scroll(
            function()
            {
                if($(".parent-fixedSrollBlock").length)
                    setPositionScrollSide();
            }
        );
    }

}


$(document).ready(function(){

    setHeaderHeight();
    scrollSideInit();
    correctColsHead();

});

function correctColsHead()
{
    if($(".correct-cols-head").length>0)
    {
        var cols="", selector="";

        $(".correct-cols-head").each(function(index)
        {
            cols = $(this).attr("data-head-cols");
            selector = $(this).attr("data-head-target");

            $("."+selector).addClass(cols);
        });
    }
}


function markProductAddBasket(id)
{
    arStatusBasketPhoenix = {};
    setInfoBasket("add2Basket");
}

function markProductDelayBasket(id, action)
{
    if(action == 'active')
        $('.add2delay[data-item='+id+']').addClass('active');
    
    if(action == 'delete')
        $('.add2delay[data-item='+id+']').removeClass('active');
    

    arStatusBasketPhoenix = {};
    setInfoBasket();
}


function markProductCompareBasket(id, action)
{
    if(action == 'active')
        $('.add2compare[data-item='+id+']').addClass('active');
    
    if(action == 'delete')
        $('.add2compare[data-item='+id+']').removeClass('active');

    arStatusBasketPhoenix = {};
    setInfoBasket();
}


function delParamURL(url, param)
{
    var a = url.split('?');
    var re = new RegExp('(\\?|&)'+param+'=[^&]+','g');

    if(url == "undefined")
        url = "";

    url=('?'+a[1]).replace(re,'');
    url=url.replace(/^&|\?/,'');

    if(url == "undefined")
        url = "";

    var dlm=(url=='')? '': '?';

    return a[0]+dlm+url;
}

function addParam2URL(param, value)
{
    var url = window.location.href;

    if (history.replaceState) {
        var baseUrl = delParamURL(url, param);
        baseUrl += (baseUrl.split('?')[1] ? '&':'?') + param+"="+value;
        history.replaceState(null, null, baseUrl);
    }
    else {
        console.warn('History API don`t support');
    }
}


function deleteProduct(id, params)
{

    params = params || null;

    showProcessLoad();

    if(params !== null)
    {
        var productsCount = $("input#products_count"),
            delayedCount = $("input#delayed_count");

        if(params.action == "product" && productsCount)
            addParam2URL("url-tab", "products");

        else if(params.action == "delayed" && delayedCount)
            addParam2URL("url-tab", "delayed");

        else{
            addParam2URL("url-tab", "-1");
        }
        
    }

    $.ajax({
        url: '/bitrix/tools/concept.phoenix/ajax/basket/delete_product_basket.php',
        type: 'POST',
        data: {
            site_id: $("input.site_id").val(),
            id: id
        },
        success: function(data){

            closeProcessLoad();

            if(data.OK == "Y")
            {
                arStatusBasketPhoenix = {};
                setInfoBasket();
            }
        }
    });
}

function clearBasket()
{
    showProcessLoad();
    $.ajax({
        url: '/bitrix/tools/concept.phoenix/ajax/basket/clear_basket.php',
        type: 'POST',
        data: {
            site_id: $("input.site_id").val()
        },
        success: function(data){
            closeProcessLoad();
            closeCart();
            arStatusBasketPhoenix = {};
            setInfoBasket();
        }
    });
}

$(document).on("click", ".basket-item-actions-remove", function()
{
    arStatusBasketPhoenix = {};
    setInfoBasket();
}
);

$(document).on("click", ".clear-cart", function()
{

    clearBasket();
    arStatusBasketPhoenix = {};
    setInfoBasket();
}
);


function setCountBasket(count, classValue, classParent)
{
    count = count || 0;

    if(count)
        $(classParent).addClass('active');
    

    else
    {
        $(classParent).removeClass('active');
    }
    
    
    $(classValue).text(count);
    
}

function setCountMiniBasket(count)
{
    count = count || 0;

    if(count)
        $(".open-cart").removeClass('cart-empty').addClass('no-empty');
    
    

    else
    {
        $(".open-cart").removeClass('no-empty').addClass('cart-empty');
    }
    
    
    $(".open-cart span.count").text(count);
    
}


function updateBasket(params)
{

    /*if($("input#shop-mode").val()!="Y")
        return false;*/

    basketPoolQuantity = new BasketPoolQuantity();

    if(params.type_mode == "fly")
    {
         $.post(
            '/bitrix/tools/concept.phoenix/ajax/basket/'+params.path, 
            {
                site_id: $("input.site_id").val()
            }, 
            function(html)
            {
                $(params.selector).html(html);
                basketPoolQuantity = new BasketPoolQuantity();                
            }
        );
    }

    else if(params.type_mode == "page")
    {
        var productsCount = 0,
            delayed_count = 0;

        function updateBasketProductsInfo()
        {

            if($("#products_count").length>0)
                productsCount = parseInt($("#products_count").val());
            
            if($("#delayed_count").length>0)
                delayed_count = parseInt($("#delayed_count").val());


            if(productsCount>0)
                $(".clear-basket-node-control").removeClass("d-none");
            
            
            else
            {
                $(".clear-basket-node-control").addClass("d-none");
            }

            if(productsCount>0 || delayed_count>0)
            {
                $(".basket-style.page .cart-advantage").removeClass('hidden');
                $(".basket-page-header-btn").removeClass('d-none');
            }
            
            else
            {
                $(".basket-style.page .cart-advantage").addClass('hidden')
            }


            if($("input.basketOrder").length>0)
            {
                if(productsCount>0)
                    $(".basketOrder-body").removeClass('d-none');
                else
                {
                    $(".basketOrder-body").addClass('d-none');
                }
            }

            if(productsCount<=0 && delayed_count<=0)
            {
                $(".basket-page-header-btn").addClass('d-none');
                $(".clear-basket-node-control").addClass('d-none');

                if($("input.basketOrder").length>0)
                    $(".basketOrder-side").addClass('d-none');
                
            }


            if(params.firstLoad != "Y")
            {
                if($("input.basketOrder").length>0 && (productsCount > 0 || delayed_count>0) )
                    BX.Sale.OrderAjaxComponent.sendRequest("refreshOrderAjax", "noRedirect");
            }

            
            



        }

        if(params.firstLoad != "Y")
        {

            showProcessLoad();
            $.post(
                "/bitrix/tools/concept.phoenix/ajax/basket/"+params.path,
                {
                    "site_id": $("input.site_id").val(),
                    "ajax_content": "products"
                },
                function(html){

                    $(".body-basket-ajax-left").html(html);

                    
                    basketPoolQuantity = new BasketPoolQuantity();


                    updateBasketProductsInfo();

                    
                    

                    $.post(
                        "/bitrix/tools/concept.phoenix/ajax/basket/"+params.path,
                        {
                            "site_id": $("input.site_id").val(),
                            "ajax_content": "side"
                        },
                        function(html){

                            $(".body-basket-ajax-right").html(html);

                            scrollSideInit();
                            closeProcessLoad();
                            
                        }
                    );
                    
                }
            );

        }

        else
        {
            updateBasketProductsInfo();
        }

    }

    
}


$(document).on("click", "div.switcher-wrap div.switcher-title", function() {
    var block = $(this).parents("div.switcher-wrap");
    if (!block.hasClass("active"))
    {
        $("div.switcher-content", block).slideDown(200, function() {
            block.addClass("active");
        });
    } 
    else
    {
        $("div.switcher-content", block).slideUp(200, function() {
            block.removeClass("active");
        });
    }
});

function correctSizeVideoBg(obj)
{
    
    var height = obj.parents('.parent-video-bg').outerHeight();
    var videoThis = obj.find(".video-bg-display");
    var width = $(window).width();
    var video_w = 0;
    var video_h = 0;
    var add = 4;

    if (width / height < 16 / 9){
        video_w = height * 16 / 9 + add;
        video_h = height + add;
    }

    else{
        video_w = width + add;
        video_h = width * 9 / 16 + add;
    }

    videoThis.width(video_w).height(video_h);
    videoThis.addClass('active');
}



function generateVideoBG(container)
{
    if($(window).width() >= 1200 || ($(window).width() >= 768 && $(window).width() < 1200 && !device.android() && !device.ios()) )
    {
        var videoBG = $(".videoBG", container),
            iframeType = videoBG.attr("data-type"),
            srcMP4 = videoBG.attr("data-srcMP4"),
            srcWEBM = videoBG.attr("data-srcWEBM"),
            srcOGG = videoBG.attr("data-srcOGG"),
            srcYB = videoBG.attr("data-srcYB"),
            html = "";



        if(iframeType == "file")
        {
            if(videoBG.children('video').length <= 0)
            {
                if( srcMP4 )
                    html += '<source src="'+srcMP4+'" type="video/mp4">';

                if( srcWEBM )
                    html += '<source src="'+srcWEBM+'" type="video/webm">';

                if( srcOGG )
                    html += '<source src="'+srcOGG+'" type="video/ogg">';


                html = '<video class="video-bg-display" autoplay="autoplay" loop="loop" preload="auto" muted="muted">'+html+'</video>';
            }
        }

        else if(iframeType == "iframe")
        {

            if(videoBG.children('iframe').length <= 0)
            {
                if( srcYB )
                    html += '<iframe src="'+srcYB+'" class="video-bg-display" allowfullscreen="" frameborder="0" height="100%" width="100%"></iframe>';
            }
        }

        if( html )
            videoBG.prepend(html);

        correctSizeVideoBg(videoBG);
                
    }
}

function updateMainMenu(menu)
{

    if (menu.length > 0)
    {
        menu.removeClass('full');
        menu.find('li.lvl1').removeClass('visible');
        menu.parents(".wrap-main-menu").removeClass('ready');
        var totalWidth = menu.parents("td.wrapper-menu").width();

        if ($(document).width() > 767)
        {
            var visible = 0;
            var size = menu.find('li.lvl1').length;
            
            menu.find('li.lvl1').each(function(index)
            {   

                if (visible > 4){
                    menu.addClass('full');
                }

                if (totalWidth > ($(this).width()))
                {
                    totalWidth = totalWidth - $(this).width();

                    $(this).addClass('visible');
                    visible++;

                    if (size == (index + 1)) 
                        menu.parents(".wrap-main-menu").addClass('ready');
                }
                else
                {
                    menu.parents(".wrap-main-menu").addClass('ready');
                    return false;
                }
            });
        }
    }
}

$(document).ready(function() {
    updateMainMenu($('nav.main-menu'));
});









var windowWidth = $(window).width();

$(window).resize(function() {
    phoenixResizeVideo();
    
    if(windowWidth != $(window).width())
    {
        mobileMenuPositionFooter();
        updateMainMenu($('nav.main-menu'));
    }
});

if ($(window).width() < 1199) {
    $(document).on("click", "header .open-list-contact", function() {
        $("header div.list-contacts").addClass('open');
    });
    $(document).mouseup(function(e) {
        var div = $("header div.list-contacts");
        if (!div.is(e.target) && div.has(e.target).length === 0) div.removeClass(
            'open');
    });

    $(document).on("click", "nav.main-menu li.parent.view_1", function() {
        var menu = $(this).parents('nav.main-menu');
        if (!$(this).children('a').hasClass("open")) {
            $('li.parent', menu).find("ul.child").removeClass("show-open").find(
                "ul.child2").removeClass("show-open");
            $('li.parent > a', menu).removeClass("open");
            $(this).find("ul.child").addClass("show-open");
            $(this).children('a').addClass("open");
            menuOffset(this);
            return false;
        }
    });


    $(document).on("click", "nav.main-menu li.parent.view_2", function() {

        if ( !$(this).children('a').hasClass("open") )
        {
            $(this).children('a').addClass("open");

            var th = $(this);
        
            $('.lazyload').Lazy(paramsLazy);
            $(this).find(".dropdown-menu-view-2").addClass('on');
            setTimeout(function() {
                th.find(".dropdown-menu-view-2").addClass('active');
            }, 100);

            return false;
        }
    });
    $(document).on("click", "nav.main-menu li.parent2", function() {

        var menu = $(this).parents('nav.main-menu');
        var menu_list = $("ul.child > li.parent2", menu);



        if (!$(this).children('a').hasClass("open")) {

            if($(this).find("ul.child").length > 0)
            {
                menu.find("ul.child2").removeClass("show-open");
                $(this).find("ul.child2").addClass("show-open");
                menuOffset(this);
            }
            

            $("a", menu_list).removeClass("open");
            $(this).children('a').addClass("open");


            return false;
        }
    });
    $(document).mouseup(function(e) {
        var div = $("nav.main-menu");
        if (!div.is(e.target) && div.has(e.target).length === 0) {
            $('li.parent > a', div).removeClass("open");
            $("ul.child", div).removeClass("show-open");
            $('li.parent2 > a', div).removeClass("open");
            $("ul.child2", div).removeClass("show-open");

            if($("li.parent", div).hasClass('catalog-view-flat'))
            {
                $("li.parent", div).find(".wrapper-catalog-menu-board").removeClass('active');
                setTimeout(function() {
                    $("li.parent", div).find(".wrapper-catalog-menu-board").removeClass('on');
                }, 100);

            }
        }
    });
}



$(document).on("click", ".universal-arrows-mini .arrow-prev", function(){
    $(this).parents(".universal-parent-slider").find('.universal-slider').slick("slickPrev");
});
$(document).on("click", ".universal-arrows-mini .arrow-next", function(){
    $(this).parents('.universal-parent-slider').find('.universal-slider').slick("slickNext");
});

$(document).on("click", ".cart-show", function(){

    if ($(this).hasClass('cart-empty')) 
        return false;

    openCart();
});

$(document).on("click", ".cart-close", function()
{
    closeCart();
});

$(document).on("keypress", "input.count-val", function(e) {
    e = e || event;

    if (e.ctrlKey || e.altKey || e.metaKey) return;

    var chr = getChar(e);

    if (chr == null) return false;
});


$(document).on('click', 'ul.switcher-tab li:not(.active)', function() {
    $(this).addClass('active').siblings().removeClass('active').closest(
        'div.switcher').find('div.switcher-wrap').removeClass('active').eq($(this)
        .index()).addClass('active');
});

$(document).on('click', 'a.map-show', function() {
    $(this).parent().hide();
    $(this).parents('div.map-block').find(".map-height").show();
});



$(document).on("click", ".bl-txt .wr-tabs li:not(.active)", function(){

    var img = $(this).closest('.wr-tabs').find('img').eq($(this).index());

    $(this).addClass('active').siblings().removeClass('active').closest(
        '.wr-tabs').find('img').removeClass(
        'active').eq($(this).index()).addClass('active');

    if(img.attr("data-src"))
        $(img).Lazy();
    
    
});

$(document).on("click", ".bl-txt .wr-tabs .title-mobile", function(){

    var block = $(this).parent(".item");

    if (!$(this).hasClass("active")){

        if($("img", block).attr("data-src"))
        {
            var _this = $(this);

            $("img", block).Lazy({afterLoad: function(element)
            {
                $("img", block).removeAttr('style');
                                
                _this.addClass("active");

                $("img", block).slideDown(200, function() {
                    $(this).addClass("active");
                });
                
                
            }});
        }
        else
        {
            $(this).addClass("active");
            $("img", block).slideDown(200, function() {
                $(this).addClass("active");
            });
        }
            
    }
    else
    {
        $(this).removeClass("active");
        $("img", block).slideUp(200, function() {
            $(this).removeClass("active");
        });
    }

});

$(document).on("click", "div.wrap-scroll-down .scroll-down", function(){
    var s_b = $(this).parents('div.parent-scroll-down').next(),
        heightOut = 70,
        destination = null;

    while (s_b.hasClass('hidden-lg')) {
        s_b = s_b.next();
    }

    destination = $(s_b).offset().top - heightOut;

    $("html:not(:animated),body:not(:animated)").animate({
        scrollTop: destination
    }, 700);
});

$(document).on('click', '.open-main-menu', function() {
    if ($(window).width() <= 767) {
        $('div.open-menu-mobile').addClass('show-open');
        setTimeout(function() {
            $('div.open-menu-mobile.show-open').addClass('on');
        }, 50);
        setTimeout(function() {
            $('a.close-menu.mobile').addClass('on');
        }, 1000);
        setTimeout(function() {
            mobileMenuPositionFooter();
        }, 100);
        $('body').addClass('modal-open');
    } else {
        $('div.open-menu').addClass('show-open');
        setTimeout(function() {
            openMenuFooterPos();
        }, 100);
        setTimeout(function() {
            $('div.open-menu').addClass('on');
        }, 150);
        $('div.wrapper').addClass('blur');
        $('div.menu-shadow').addClass('show-open');
        $('body').addClass('modal-open');
        $(".open-cart").addClass('off');
    }

    $('.lazyload').Lazy(paramsLazy);
});

$(document).on('click', '.close-menu', function() {
    if ($(window).width() <= 767) {
        $('div.open-menu-mobile').removeClass('on');
        $('body').removeClass('modal-open');
        $('a.close-menu.mobile').removeClass('on');
        setTimeout(function() {
            $('div.open-menu-mobile.show-open').removeClass('show-open');
        }, 500);
    } else {
        $('div.wrapper').removeClass('blur');
        $('div.open-menu').removeClass('show-open');
        $('div.menu-shadow').removeClass('show-open');
        $('body').removeClass('modal-open');
        $(".open-cart").removeClass('off');
    }
});


$(document).on("click", "div.list-menu li.parent", function() {
    var menu = $(this).parents('div.list-menu');
    var Li = $(this);
    menu.find('ul.child2').slideUp(200);
    if (!$(this).children('a').hasClass("open")) {
        $('li.parent > a', menu).removeClass("open");
        $("ul.child2", Li).slideDown(200);
        $(this).children('a').addClass("open");
        return false;
    } else if ($(this).children('a').hasClass("empty-link")) {
        menu.find('ul.child2').slideUp(200);
        $('li.parent > a', menu).removeClass("open");
    }
});

$(document).on('click', 'a.open-mobile-list', function() {
    $('ul.mobile-menu-list').removeClass('show-open');
    $("ul.mobile-menu-list[data-menu-list='" + $(this).attr('data-menu-list') +
        "']").addClass('show-open');
    mobileMenuPositionFooter();
});

$(document).on('click', 'div.open-menu-mobile div.open-list-contact', function() {
    var btn = $(this);
    
    btn.parents('div.contacts').find('div.list-contacts').addClass('open');
    btn.hide();

    if(btn.parents('div.contacts').find(".iframe-map-area").length>0)
        generateMaps(btn.parents('div.contacts').find(".contact-wrap.map"));
    
    mobileMenuPositionFooter();
});

$(document).on("click", ".scroll-after", function() {
    var elementClick = $(this).attr("href");

    setTimeout(function()
    {   
        scrollToBlock(elementClick, $(this));
    }, 200);
    return false;
});

$(document).on("click", "a.scroll", function() {
    var elementClick = $(this).attr("href");
    scrollToBlock(elementClick, $(this));

    if ($(this).hasClass('from-modal')) {
        $('div.wrap-modal').removeClass('open');
        $('div.no-click-block').removeClass('on');
        $('.shadow-detail').removeClass('active');
        $('body').removeClass('modal-open');
        $('div.wrapper').removeClass('blur');
        if (device.ios()) {
            window.scrollTo(0, cur_pos);
            $("body").removeClass("modal-ios");
        }

        if($(this).parents(".container-close-from-scroll").length>0)
            $(this).parents(".container-close-from-scroll").addClass('d-none');
        
    }

    return false;
});

$(document).on('click', 'div.tab-child:not(.active)', function() {
    $(this).addClass('active').siblings().removeClass('active').closest(
        'div.tab-parent').find('div.tab-content').removeClass('active').eq($(this)
        .index()).addClass('active');
});

$(document).on('click', '.select-list-choose', function() {
    $(this).parents('.form-select').addClass('open');
});

$(document).on('click', '.ar-down', function() {
    if ($(this).parents('.form-select').hasClass('open')) $(this).parents(
        '.form-select').removeClass('open');
    else {
        $(this).parents('.form-select').addClass('open');
    }
});

$(document).on('click', '.form-select .name', function() {
    $(this).parents('.form-select').find('.select-list-choose').removeClass(
        'first').find(".list-area").text($(this).text());
    $(this).parents('.form-select').removeClass('open');
});


function callModal(arParams)
{
    showProcessLoad();


    $.post("/bitrix/tools/concept.phoenix/ajax/popup/" + arParams.path,
    {
        arParams: arParams,
        site_id: $("input.site_id").val()
    }, 
    function(html)
    {
        closeProcessLoad();

        startBlurWrapperContainer();

        $('div.' + arParams.container).html(html);

        setTimeout(function()
        {
            $('div.' + arParams.container).find('.phoenix-modal').addClass('active');
        }, 100);


        if(arParams.from_modal == "Y")
        {
            $('div.' + arParams.container).find('.close-modal').addClass('remove-blur-container').attr('data-blur-container', arParams.element_id);
        }

        if( arParams.container == 'modalAreaForm')
        {
            /*$('div.' + arParams.container).find("form input[name='url']").val(location.href);*/

            $('div.modalAreaForm form.form .date').datetimepicker({
                timepicker: false,
                format: 'd/m/Y',
                scrollMonth: false,
                scrollInput: false,
                dayOfWeekStart: 1
            });
        }

        

        if(typeof(arParams.header) != "undefined" )
        {
            if(arParams.header.length>0)
            {
                $('div.' + arParams.container).find('input[name="header"]').val(arParams.header);
            }
            
        }

    });

}

$(document).on('click', '.call-modal', function()
{
    var arParams = {},
        element_id = $(this).attr("data-call-modal");

    
    if ($(this).hasClass('callform'))
    {
        arParams["path"] = "formmodal.php";
        arParams["element_id"] = element_id.replace("form", "");
        arParams["container"] = "modalAreaForm";
    }

    if ($(this).hasClass('callvideo'))
    {
        arParams["path"] = "videomodal.php";
        arParams["element_id"] = element_id;
        arParams["container"] = "modalAreaVideo";
    }

    if ($(this).hasClass('callmodal'))
    {
        arParams["path"] = "windowmodal.php";
        arParams["element_id"] = element_id.replace("modal", "");
        arParams["container"] = "modalAreaWindow";
    }
    if ($(this).hasClass('callagreement'))
    {
        arParams["path"] = "agreemodal.php";
        arParams["element_id"] = element_id.replace("agreement", "");
        arParams["container"] = "modalAreaAgreement";
    }


    if ($(this).hasClass("element-item"))
    {
        arParams["element_item_id"] = $(this).attr("data-element-item-id");
        arParams["element_item_type"] = $(this).attr("data-element-item-type");
        arParams["element_item_name"] = $(this).attr("data-element-item-name");
        arParams["element_item_price"] = $(this).attr("data-element-item-price");
    }



    if(typeof($(this).attr("data-header")) != "undefined" )
    {
        if($(this).attr("data-header").length>0)
        {
            arParams["header"] = $(this).attr("data-header");
        }
        
    }


    arParams["from_modal"] = "N";

    if ($(this).hasClass("from-modal"))
    {
        arParams["from_modal"] = "Y";
        $(this).parents(".blur-container").addClass('blur-active').attr("data-blur-container", arParams["element_id"]);
    }

    
    callModal(arParams);

});



$(document).on('click', '.close-modal', function()
{
    $('div.modalAreaForm form.form .date').datetimepicker('destroy');

    if($(this).hasClass('remove-blur-container'))
    {
        $(".blur-container[data-blur-container='"+$(this).attr("data-blur-container")+"']").removeClass('blur-active');
    }
    else
    {
        stopBlurWrapperContainer();
    }


    if ($(this).hasClass('wind-close'))
        $(this).parents("div.shadow-modal-wind-contact").removeClass('on');
    else
    {
        $(this).parents("div.modalArea").children().remove();
    }
});

$(document).on('click', '.open_modal_contacts', function() {
    $('div.shadow-modal-wind-contact').addClass('on');

    startBlurWrapperContainer();
});

$(document).on('click', '.tab-menu', function() {
    $(this).parents('.tab-control').find('.tab-menu').removeClass('active');
    $(this).parents('.tab-control').find('.tabb-content').removeClass('active');
    $(this).addClass('active');
    $('.tabb-content[data-tab="' + $(this).attr("data-tab") + '"]').addClass(
        'active');
});


$(document).on('click', '.show-hidden', function() {

    if($(this).parent().hasClass('off'))
    {
        $(this).parents('.show-hidden-parent').find('.show-hidden-child').addClass(
            'hidden');
        $(this).parent().removeClass('off');
    }
    else
    {
        $(this).parents('.show-hidden-parent').find('.show-hidden-child').removeClass(
            'hidden');
        $(this).parent().addClass('off');
    }
});

$(document).on("click", ".click-slide-show", function() {
    var block = $(this).parent(".parent-slide-show");
    if (!$(this).hasClass("active")) {
        $(this).addClass("active");
        $(".content-slide-show", block).slideDown(200, function() {
            $(this).addClass("active");
        });
    } else {
        $(this).removeClass("active");
        $(".content-slide-show", block).slideUp(200, function() {
            $(this).removeClass("active");
        });
    }
});

Share = {
    vkontakte: function(purl, ptitle, pimg, text) {
        url = 'http://vkontakte.ru/share.php?';
        url += 'url=' + encodeURIComponent(purl);
        url += '&title=' + encodeURIComponent(ptitle);
        url += '&description=' + encodeURIComponent(text);
        url += '&image=' + encodeURIComponent(pimg);
        url += '&noparse=true';
        Share.popup(url);
    },
    facebook: function(purl, ptitle, pimg, text) {
        url = 'https://www.facebook.com/sharer/sharer.php?';
        url += '&title=' + encodeURIComponent(ptitle);
        url += '&description=' + encodeURIComponent(text);
        url += '&u=' + encodeURIComponent(purl);
        url += '&picture=' + encodeURIComponent(pimg);
        Share.popup(url);
    },
    twitter: function(purl, ptitle) {
        url = 'http://twitter.com/share?';
        url += 'text=' + encodeURIComponent(ptitle);
        url += '&url=' + encodeURIComponent(purl);
        url += '&counturl=' + encodeURIComponent(purl);
        Share.popup(url);
    },

    ok: function(purl, ptitle) {
        url  = 'https://connect.ok.ru/dk?st.cmd=WidgetSharePreview';
        url += '&st.title=' + encodeURIComponent(ptitle);
        url += '&st.shareUrl='    + encodeURIComponent(purl);
        Share.popup(url);
    },

    mailRu: function(purl, ptitle) {
        url  = 'https://connect.mail.ru/share?';
        url += '&url=' + encodeURIComponent(purl);
        url += '&title='    + encodeURIComponent(ptitle);
        Share.popup(url);
    },

    wtsApp: function(purl, ptitle) {
        url  = 'https://api.whatsapp.com/send?';
        url += '&text=' + encodeURIComponent(ptitle) + ' ' + encodeURIComponent(purl);
        Share.popup(url);
    },

    telegram: function(purl, ptitle) {
        url  = 'https://telegram.me/share/url?';
        url += 'url=' + encodeURIComponent(purl);
        url += '&text=' + encodeURIComponent(ptitle);
        Share.popup(url);
    },
    skype: function(purl) {
        url  = 'https://web.skype.com/share?';
        url += 'url=' + encodeURIComponent(purl);
        Share.popup(url);
    },
    gPlus: function(purl) {
        url  = 'https://plus.google.com/share?';
        url += 'url=' + encodeURIComponent(purl);
        Share.popup(url);
    },

    reddit: function(purl) {
        url  = 'https://www.reddit.com/submit?';
        url += 'url=' + encodeURIComponent(purl);
        Share.popup(url);
    },

    popup: function(url) {
        window.open(url, '', 'toolbar=0,status=0,width=626,height=436');
    }
};

$(document).on('click', '.click-show-pic', function() {
    $(this).parents('.parent-show-pic').find('.item-show-pic').removeClass(
        'active');
    $(this).parents('.parent-show-pic').find('.click-show-pic').removeClass(
        'active');
    $(this).parents('.parent-show-pic').find('.item-show-pic[data-show-pic="' +
        $(this).attr("data-show-pic") + '"]').addClass('active');
    $(this).addClass('active');
});

$(document).on('click', '.scroll-next', function() {
    var dist = $(this).parents('.scroll-next-parent').next().offset().top - 40;
    if ($("header").hasClass("fixed")) dist -= 70;
    $("html:not(:animated),body:not(:animated)").animate({
        scrollTop: dist
    }, 700);
});

$(document).on("click", ".phoenix-alert-btn", function() {
    $("div.alert-block div.phoenix-alert-btn").addClass("on");
    $("div.alert-block div.alert-block-content").addClass("on");
});

$(document).on("click", "a.alert-close", function() {
    $("div.alert-block div.phoenix-alert-btn").removeClass("on");
    $("div.alert-block div.alert-block-content").removeClass("on");
});








function checkInput(input)
{
    if (input.val().length > 0)
    {
        input.parents('.search-panel-js').find('.hint-area').hide();
        input.parents('.search-panel-js').find('.search-btns-box').addClass('before-active');

        var timeOut = setTimeout(
            function(){
                input.parents('.search-panel-js').find('.search-btns-box').addClass('active');
                clearTimeout(timeOut);
            },100);
    }
    else
    {
        input.parents('.search-panel-js').find('.search-btns-box').removeClass('before-active active');
        input.parents('.search-panel-js').find('.hint-area').show();
    } 

}
$(document).on("keyup", "form.search-form input.search-js",
    function() {
        checkInput( $(this) );
    }
);

$('form.search-form input.search-js').focusout(function() {
    checkInput( $(this) );
});

$(document).on("click", "input.search-scroll-focus", function() {
    scrollToBlock($(this), '', 40);
});

$(document).on("focus", "form.search-form.fix-header input.search-js", function() {
    $(this).parents("form.search-form.fix-header").addClass('focus');
});

$(document).on("focusout", 'form.search-form.fix-header input.search-js', function() {
    if ($(this).val().length <= 0 )
        $(this).parents("form.search-form.fix-header").removeClass('focus');
});




$(document).on("click", ".open-search-top", function(){
    $(".search-top-js").addClass('fixed');

    if($('.open-menu').hasClass('show-open'))
        $('.open-menu').addClass('blur-active');
    
    else
    {
        startBlurWrapperContainer();
    }

    var st = setTimeout(function()
    {
        $(".no-click-block").addClass('on');
        $(".search-top-js").addClass('active');
        $(".search-top-js").find('input.search-js').focus();
        clearTimeout(st);
    }, 100);
});
$(document).on("click", ".close-search-top", function(){
    $(this).parents(".search-top-js").removeClass('active');
    var th = $(this);
    $(".no-click-block").removeClass('on');

    if($('.open-menu').hasClass('show-open'))
        $('.open-menu').removeClass('blur-active');
    else
    {
        stopBlurWrapperContainer();
    }

    var st = setTimeout(function()
    {
        th.parents(".search-top-js").removeClass('fixed');
        clearTimeout(st);
    }, 100);
    $(".ajax-search-results").hide();
});





function showContentCtTab(th, param, blockID)
{
    if(typeof param != 'undefined')
    {
        
        if(param.length>0)
        {
            th = th || "";

            if(th.length>0)
            {
                th.parents(".parent-tab").find(".tab-section").removeClass('active');
                th.addClass('active');

                th.parents(".parent-tab").find(".tab-element").removeClass('active');
                th.parents(".parent-tab").find(".tab-element."+th.attr("data-tab")).addClass('active');
            }
            
            else
            {
                var head = "";

                
                if(param.length>0)
                {
                    blockID = blockID || "";

                    head = $("#"+blockID).find(".parent-tab");
                }

                else
                {
                    head = $(".parent-tab");
                }

                head.find(".tab-section").removeClass('active');
                head.find(".tab-section[data-tab="+param+"]").addClass('active');

                head.find(".tab-element").removeClass('active');
                head.find(".tab-element."+param).addClass('active');
            }

            $('.lazyload').Lazy(paramsLazy);
            
        }
    }
}
$(document).on("click", ".tab-section", 
    function()
    {
        showContentCtTab($(this), $(this).attr("data-tab"));
    }
);

function getUrlParams()
{
    var params = window
        .location
        .search
        .replace('?','')
        .split('&')
        .reduce(
            function(p,e){
                var a = e.split('=');
                p[a[0]] = a[1];
                return p;
            },
            {}
        );

    return params;
}

$(document).ready(function() {

    var params = getUrlParams();

    showContentCtTab("", params["ct_tab"], params["ct_tab_blockID"]);
    
});

(function(window){


    window.JCCatalogElement = function(arParams)
    {
        this.productType = 0;

        this.config = {
            useCatalog: true,
            showQuantity: true,
            showPrice: true,
            showAbsent: true,
            showOldPrice: true,
            showPercent: true,
            alt: '',
            title: '',
            changeArticle: true,
            changeStoreQuantity: true,
            storeQuantityOn: false,
            usePriceCount: false,
            useDelay: false,
            useCompare: false,
            showOfferGroup: false
        };

        this.useUrlParam = "Y";
        this.obCallFormBetterPrice = null;
        this.formBetterPrice = "";
        this.formPreorder = "";


        this.obProduct = null;
        this.obQuantity = null;
        this.obQuantityUp = null;
        this.obQuantityDown = null;
        this.obPrice = {
            wrapper: null,
            price: null,
            full: null,
            discount: null,
            percent: null,
            total: null
        };
        this.obMeasure = null;

        this.obPriceRanges = null;

        this.obArticleAvailable = null;
        /*this.obArticle = null;*/
        /*this.obAvailable = null;*/
        this.obSkuChars = null;

        this.product = {
            article: null,
            checkQuantity: false,
            maxQuantity: 0,
            stepQuantity: 1,
            startQuantity: 1,
            isDblQuantity: false,
            canBuy: true,
            name: '',
            pict: {},
            id: 0,
            quantity_for_many: null,
            quantity_for_few: null,
            slider: {},
            sliderCount: 0,
            sliderPict: [],
            zoom: '',
            photo: null
        };

        this.precision = 6;
        this.precisionFactor = Math.pow(10, this.precision);

        this.checkQuantity = false;
        this.maxQuantity = 1;
        this.minQuantity = 1;
        this.stepQuantity = 1;
        this.isDblQuantity = false;
        this.canBuy = true;

        this.node = {};
        this.obTree = null;
        this.visual = {};
        this.offers = [];
        this.offerNum = 0;
        this.treeProps = [];
        this.selectedValues = {};

        this.obBasketActions = null;
        this.obMove2Basket = null;
        this.obAdd2BasketBtn = null;
        this.obPreorderBtn = null;
        this.obFastOrder = null;

        this.obDelay = null;
        this.obCompare = null;

        this.obSubscribe = null;
        
        

        this.currentImgGallery = null;

        this.errorCode = 0;

        this.smallCardNodes = {};

        this.currentItemId = 0;


        this.currentPriceMode = '';
        this.currentPrices = [];
        this.currentPriceSelected = 0;
        this.currentQuantityRanges = [];
        this.currentQuantityRangeSelected = 0;

        this.obPriceMatrix = null;

        this.compareUrl = '';
        this.compareUrlAdd = '';
        this.compareUrlDelete = '';
        this.obName = '';

        this.isTouchDevice = BX.hasClass(document.documentElement, 'bx-touch');

        this.firstPictureSrcSmall = '';

        this.firstLoad = true;
        

        if (typeof arParams === 'object')
        {
            this.params = arParams;
            this.initConfig();


            switch (this.productType)
            {
                case 0: 
                case 1: 
                case 2:
                    this.initProductData();
                    break;
                case 3:
                    this.initOffersData();
                    break;
                default:
                    this.errorCode = -1;
            }

            this.initCompareData();

        }

        if (this.errorCode === 0)
            BX.ready(BX.delegate(this.init, this));


        this.params = {};
        
    };

    window.JCCatalogElement.prototype = 
    {
        initCompareData: function()
        {
            this.compareUrl = this.params.COMPARE_URL;

            if(this.compareUrl)
            {
                this.compareUrlAdd = this.compareUrl+'?action=ADD_TO_COMPARE_LIST&id=#ID#';
                this.compareUrlDelete = this.compareUrl+'?action=DELETE_FROM_COMPARE_LIST&id=#ID#';
            }
        },

        getEntity: function(parent, entity, additionalFilter)
        {
            if (!parent || !entity)
                return null;

            additionalFilter = additionalFilter || '';

            return parent.querySelector(additionalFilter + '[data-entity="' + entity + '"]');
        },

        getEntities: function(parent, entity, additionalFilter)
        {
            if (!parent || !entity)
                return {length: 0};

            additionalFilter = additionalFilter || '';

            return parent.querySelectorAll(additionalFilter + '[data-entity="' + entity + '"]');
        },

        initConfig: function()
        {
            
            if (this.params.PRODUCT_TYPE)
            {
                this.productType = parseInt(this.params.PRODUCT_TYPE, 10);
            }

            if (this.params.CONFIG.USE_CATALOG !== 'undefined' && BX.type.isBoolean(this.params.CONFIG.USE_CATALOG))
            {
                this.config.useCatalog = this.params.CONFIG.USE_CATALOG;
            }

            if(this.params.CONFIG.USE_URL_PARAM)
            {
                this.useUrlParam = this.params.CONFIG.USE_URL_PARAM;
            }

            this.obName = this.params.OB_NAME;

            this.config.showQuantity = this.params.CONFIG.SHOW_QUANTITY;
            this.visual = this.params.VISUAL;
            this.config.showPrice = this.params.CONFIG.SHOW_PRICE;
            this.config.showPercent = this.params.CONFIG.SHOW_DISCOUNT_PERCENT;
            this.config.showOldPrice = this.params.CONFIG.SHOW_OLD_PRICE;
            this.config.alt = this.params.CONFIG.ALT || '';
            this.config.title = this.params.CONFIG.TITLE || '';

            this.config.useDelay = this.params.CONFIG.USE_DELAY == "Y" ? true : false;
            this.config.useCompare = this.params.CONFIG.USE_COMPARE == "Y" ? true : false;
            this.config.useSubscribe = this.params.CONFIG.USE_SUBSCRIBE;

            if (this.params.CONFIG.OFFER_GROUP !== 'undefined')
                this.config.showOfferGroup = this.params.CONFIG.OFFER_GROUP;

            if (this.config.useSubscribe)
                this.obSubscribe = BX(this.visual.SUBSCRIBE_LINK);


            
            if(this.params.CONFIG.STORE_QUANTITY_ON == "Y")
                this.config.storeQuantityOn = this.params.CONFIG.STORE_QUANTITY_ON;

            this.config.viewStoreQuantity = this.params.CONFIG.VIEW_STORE_QUANTITY;


            if (parseInt(this.params.CONFIG.ADD2BASKET_SHOW))
                this.config.add2BasketShow = parseInt(this.params.CONFIG.ADD2BASKET_SHOW);

            if (this.params.CONFIG.FAST_ORDER_SHOW)
                this.config.fastOrderShow = parseInt(this.params.CONFIG.FAST_ORDER_SHOW);



            if(this.params.FORM_BETTER_PRICE_ID)
                this.formBetterPrice = this.params.FORM_BETTER_PRICE_ID;

            if(this.params.FORM_PREORDER_ID)
                this.formPreorder = this.params.FORM_PREORDER_ID;
            
            

        },

        initProductData: function()
        {
            var j = 0;

            if (this.params.PRODUCT && typeof this.params.PRODUCT === 'object')
            {
                if (this.config.showQuantity)
                {
                    this.product.checkQuantity = this.params.PRODUCT.CHECK_QUANTITY;


                    this.product.isDblQuantity = this.params.PRODUCT.QUANTITY_FLOAT;

                    if (this.config.showPrice)
                    {
                        this.currentPriceMode = this.params.PRODUCT.ITEM_PRICE_MODE;
                        this.currentPrices = this.params.PRODUCT.ITEM_PRICES;
                        this.currentPriceSelected = this.params.PRODUCT.ITEM_PRICE_SELECTED;
                        this.currentQuantityRanges = this.params.PRODUCT.ITEM_QUANTITY_RANGES;
                        this.currentQuantityRangeSelected = this.params.PRODUCT.ITEM_QUANTITY_RANGE_SELECTED;


                    }

                    if (this.product.checkQuantity)
                    {
                        this.product.maxQuantity = this.product.isDblQuantity
                            ? parseFloat(this.params.PRODUCT.MAX_QUANTITY)
                            : parseInt(this.params.PRODUCT.MAX_QUANTITY, 10);
                    }

                    this.product.stepQuantity = this.product.isDblQuantity
                        ? parseFloat(this.params.PRODUCT.STEP_QUANTITY)
                        : parseInt(this.params.PRODUCT.STEP_QUANTITY, 10);
                    this.checkQuantity = this.product.checkQuantity;
                    this.isDblQuantity = this.product.isDblQuantity;
                    this.stepQuantity = this.product.stepQuantity;
                    this.maxQuantity = this.product.maxQuantity;
                    this.minQuantity = this.currentPriceMode === 'Q' ? parseFloat(this.currentPrices[this.currentPriceSelected].MIN_QUANTITY) : this.stepQuantity;

                    if (this.isDblQuantity)
                    {
                        this.stepQuantity = Math.round(this.stepQuantity * this.precisionFactor) / this.precisionFactor;
                    }
                }



                if(this.params.PRODUCT.PHOTO.length)
                    this.product.photo = this.params.PRODUCT.PHOTO;

                this.product.canBuy = this.params.PRODUCT.CAN_BUY;

                if(this.params.PRODUCT.ARTICLE)
                    this.product.article = this.params.PRODUCT.ARTICLE;

                this.product.name = this.params.PRODUCT.NAME;

                if(this.params.PRODUCT.PICT)
                    this.product.pict = this.params.PRODUCT.PICT;
                this.currentItemId = this.product.id = this.params.PRODUCT.ID;

                this.product.category = this.params.PRODUCT.CATEGORY;


                this.product.detail_page_url = this.params.PRODUCT.DETAIL_PAGE_URL;
                
            }

            else
            {
                this.errorCode = -1;
            }
        },

        initOffersData: function()
        {
            
            if (this.params.OFFERS && BX.type.isArray(this.params.OFFERS))
            {
                this.offers = this.params.OFFERS;
                
                /*this.offersID = this.params.OFFERS_ID;*/

                this.offerNum = parseInt(this.params.OFFER_SELECTED, 10) || 0;

                if(this.useUrlParam == "Y")
                {
                    this.addParameterToURL("oID", this.offers[this.offerNum].ID);
                }

                if (this.params.TREE_PROPS)
                {
                    this.treeProps = this.params.TREE_PROPS;
                }



                if (this.params.PRODUCT && typeof this.params.PRODUCT === 'object')
                {
                    this.product.id = parseInt(this.params.PRODUCT.ID, 10);
                    this.product.name = this.params.PRODUCT.NAME;
                    this.product.category = this.params.PRODUCT.CATEGORY;
                    this.no_photo_src = this.params.NO_PHOTO_SRC;

                    

                    if(this.params.PRODUCT.ZOOM)
                    {
                        this.product.zoom = this.params.PRODUCT.ZOOM;
                    }

                    /*this.product.detail_page_url = this.params.PRODUCT.DETAIL_PAGE_URL;*/



                    if(this.params.PRODUCT.QUANTITY_FOR_MANY)
                    {
                        if(this.params.PRODUCT.QUANTITY_FOR_MANY_IS_FLOAT)
                        {
                            this.product.quantity_for_many = parseFloat(this.params.PRODUCT.QUANTITY_FOR_MANY);
                        }
                        else
                        {
                            this.product.quantity_for_many = parseInt(this.params.PRODUCT.QUANTITY_FOR_MANY, 10);
                        }
                    }

                    if(this.params.PRODUCT.QUANTITY_FOR_FEW)
                    {

                        if(this.params.PRODUCT.QUANTITY_FOR_FEW_IS_FLOAT)
                        {
                            this.product.quantity_for_few = parseFloat(this.params.PRODUCT.QUANTITY_FOR_FEW);
                        }
                        else
                        {
                            this.product.quantity_for_few = parseInt(this.params.PRODUCT.QUANTITY_FOR_FEW, 10);
                        }
                    }


                }


            }
            else
            {
                this.errorCode = -1;
            }
        },


        init: function()
        {
            var i = 0,
                j = 0,
                treeItems = null;

            this.obProduct = BX(this.visual.ID);

            if (!this.obProduct)
            {
                this.errorCode = -1;
            }



            this.obBigSlider = BX(this.visual.BIG_SLIDER_ID);


            if (this.productType === 3)
            {
                if (this.visual.TREE_ID)
                {
                    this.obTree = BX(this.visual.TREE_ID);
                    if (!this.obTree)
                    {
                        this.errorCode = -256;
                    }
                }

                if (this.visual.QUANTITY_MEASURE)
                {
                    this.obMeasure = BX(this.visual.QUANTITY_MEASURE);
                }

                if (this.visual.ARTICLE_AVAILABLE)
                {
                    this.obArticleAvailable = BX(this.visual.ARTICLE_AVAILABLE);
                    /*this.obArticle = this.getEntity(this.obArticleAvailable, "article");
                    this.obAvailable = this.getEntity(this.obArticleAvailable, "available");*/

                }

                if (this.visual.SKU_CHARS)
                {
                    this.obSkuChars = BX(this.visual.SKU_CHARS);
                }

                if (this.visual.PRICE_MATRIX)
                {
                    this.obPriceMatrix = BX(this.visual.PRICE_MATRIX);
                }

            }

            if (this.config.showPrice)
            {

                this.obPrice.price = BX(this.visual.PRICE_ID);
                if (!this.obPrice.price && this.config.useCatalog)
                {
                    this.errorCode = -16;
                }
                else
                {
                    this.obPrice.total = BX(this.visual.PRICE_TOTAL);

                    

                    if (this.config.showOldPrice)
                    {
                        this.obPrice.full = BX(this.visual.OLD_PRICE_ID);
                        this.obPrice.discount = BX(this.visual.DISCOUNT_PRICE_ID);



                        if (!this.obPrice.full || !this.obPrice.discount)
                        {
                            this.config.showOldPrice = false;
                        }
                    }

                    if (this.config.showPercent)
                    {
                        this.obPrice.percent = BX(this.visual.DISCOUNT_PERCENT_ID);
                        if (!this.obPrice.percent)
                        {
                            this.config.showPercent = false;
                        }
                    }
                }

                this.obBasketActions = BX(this.visual.BASKET_ACTIONS);

                this.obPreorderBtn = BX(this.visual.PREORDER);


                if (this.obBasketActions)
                {

                    if (this.config.fastOrderShow)
                    {
                        this.obFastOrder = BX(this.visual.FAST_ORDER);
                    }


                    if (this.config.add2BasketShow)
                    {
                        this.obAdd2BasketBtn = BX(this.visual.ADD2BASKET);
                        this.obMove2Basket = BX(this.visual.MOVE2BASKET);
                    }

                }

            }

            if (this.config.showQuantity)
            {
                this.obQuantity = BX(this.visual.QUANTITY_ID);

                this.node.quantity = this.getEntity(this.obProduct, 'quantity-block');

                if (this.visual.QUANTITY_UP_ID)
                {
                    this.obQuantityUp = BX(this.visual.QUANTITY_UP_ID);
                }

                if (this.visual.QUANTITY_DOWN_ID)
                {
                    this.obQuantityDown = BX(this.visual.QUANTITY_DOWN_ID);
                }
            }


            
            if (this.errorCode === 0)
            {
                

                if(this.visual.CALL_FORM_BETTER_PRICE)
                {
                    this.obCallFormBetterPrice = BX(this.visual.CALL_FORM_BETTER_PRICE);
                    BX.bind(this.obCallFormBetterPrice, 'click', BX.delegate(this.callFormBetterPrice, this));

                }

                this.node.parentSku = this.getEntity(this.obProduct, 'parent-sku');

                

                if(this.config.useDelay && this.visual.DELAY)
                    this.obDelay = BX(this.visual.DELAY);

                if(this.config.useCompare && this.visual.COMPARE)
                    this.obCompare = BX(this.visual.COMPARE);

               

                if (this.config.showQuantity)
                {
                    var startEventName = this.isTouchDevice ? 'touchstart' : 'mousedown';
                    var endEventName = this.isTouchDevice ? 'touchend' : 'mouseup';

                    if (this.obQuantityUp)
                    {
                        BX.bind(this.obQuantityUp, startEventName, BX.proxy(this.startQuantityInterval, this));
                        BX.bind(this.obQuantityUp, endEventName, BX.proxy(this.clearQuantityInterval, this));
                        BX.bind(this.obQuantityUp, 'mouseout', BX.proxy(this.clearQuantityInterval, this));
                        BX.bind(this.obQuantityUp, 'click', BX.delegate(this.quantityUp, this));

                    }

                    if (this.obQuantityDown)
                    {
                        BX.bind(this.obQuantityDown, startEventName, BX.proxy(this.startQuantityInterval, this));
                        BX.bind(this.obQuantityDown, endEventName, BX.proxy(this.clearQuantityInterval, this));
                        BX.bind(this.obQuantityDown, 'mouseout', BX.proxy(this.clearQuantityInterval, this));
                        BX.bind(this.obQuantityDown, 'click', BX.delegate(this.quantityDown, this));
                    }

                    if (this.obQuantity)
                    {
                        BX.bind(this.obQuantity, 'change', BX.delegate(this.quantityChange, this));
                    }
                }

                switch (this.productType)
                {
                    case 0:
                    case 1: 
                    case 2:

                        this.checkQuantityControls();
                        /*this.fixFontCheck();*/
                        break;

                    case 3: 

                        treeItems = this.obTree.querySelectorAll('li');


                        for (i = 0; i < treeItems.length; i++)
                        {
                            BX.bind(treeItems[i], 'click', BX.delegate(this.selectOfferProp, this));
                            
                        }
                        for (i = 0; i < this.offers.length; i++)
                        {
                            this.offers[i].MORE_PHOTOS_COUNT = parseInt(this.offers[i].MORE_PHOTOS_COUNT, 10) || 0;
                        }


                        this.obPreviewText = BX(this.visual.PREVIEW_TEXT);
                        

                        this.setCurrent();
                    break;
                }

                this.obAdd2BasketBtn && BX.bind(this.obAdd2BasketBtn, 'click', BX.proxy(this.add2Basket, this));

                this.obFastOrder && BX.bind(this.obFastOrder, 'click', BX.proxy(this.fastOrder, this));


                this.obPreorderBtn && BX.bind(this.obPreorderBtn, 'click', BX.proxy(this.preOrder, this));


                if(this.config.useDelay)
                    this.obDelay && BX.bind(this.obDelay, 'click', BX.proxy(this.add2Delay, this));

                if(this.config.useCompare)
                    this.obCompare && BX.bind(this.obCompare, 'click', BX.proxy(this.add2Compare, this));
                
            }

        },

        preOrder: function()
        {
            var arParams = {
                    path: "formmodal.php",
                    element_id: this.formPreorder,
                    container: "modalAreaForm",
                    element_item_type: "PREORDER",
                    element_item_name: this.product.name
                },
                element_id = $(this).attr("data-call-modal"),
                header = $(this).attr("data-header");

                
                
            switch (this.productType)
            {
                case 1:
                case 2: 
                    arParams["element_item_id"] = this.product.id.toString();
                    arParams["element_item_input"] = this.product.name;
                    arParams["ARTICLE"] = this.product.article;
                    arParams["PHOTO"] = this.product.photo;
                    break;
                case 3:
                    arParams["element_item_id"] = this.offers[this.offerNum].ID;
                    arParams["element_item_offers"] = this.offers[this.offerNum].TREE_INFO;
                    arParams["element_item_input"] = getStringNameItem(this.product.name, this.offers[this.offerNum].TREE_INFO);
                    arParams["ARTICLE"] = this.offers[this.offerNum].ARTICLE;

                    if(this.offers[this.offerNum].MORE_PHOTOS && BX.type.isArray(this.offers[this.offerNum].MORE_PHOTOS))
                        arParams["PHOTO"] = this.offers[this.offerNum].MORE_PHOTOS[0].MIDDLE.SRC;
                    break;

                default:
                    break;
            }


            callModal(arParams);
        },

        callFormBetterPrice: function()
        {

            var arParams = {
                    path: "formmodal.php",
                    element_id: this.formBetterPrice,
                    container: "modalAreaForm",
                    element_item_type: "BETTER_PRICE",
                    element_item_name: this.product.name
                },
                element_id = $(this).attr("data-call-modal"),
                header = $(this).attr("data-header");

                
                
            switch (this.productType)
            {
                case 1:
                case 2: 
                    arParams["element_item_id"] = this.product.id.toString();
                    arParams["element_item_input"] = this.product.name;
                    arParams["ARTICLE"] = this.product.article;
                    arParams["PHOTO"] = this.product.photo;
                    break;
                case 3:
                    arParams["element_item_id"] = this.offers[this.offerNum].ID;
                    arParams["element_item_offers"] = this.offers[this.offerNum].TREE_INFO;
                    arParams["element_item_input"] = getStringNameItem(this.product.name, this.offers[this.offerNum].TREE_INFO);
                    arParams["ARTICLE"] = this.offers[this.offerNum].ARTICLE;

                    if(this.offers[this.offerNum].MORE_PHOTOS && BX.type.isArray(this.offers[this.offerNum].MORE_PHOTOS))
                        arParams["PHOTO"] = this.offers[this.offerNum].MORE_PHOTOS[0].MIDDLE.SRC;
                    break;

                default:
                    break;
            }


            callModal(arParams);

        },

        fastOrder: function()
        {
            if (!this.canBuy)
                return;


            var productID = '',
                value = 1,
                productItem = {};


            if(this.obQuantity)
                value = this.obQuantity.value;

            productItem = {
                "QUANTITY": value,
                "PRICE": this.currentPrices[this.currentPriceSelected],
                "NAME": this.product.name
            };


            switch (this.productType)
            {
                case 1:
                case 2: 
                    productItem["PRODUCT_ID"] = this.product.id.toString();
                    productItem["ARTICLE"] = this.product.article;
                    productItem["PHOTO"] = this.product.photo;
                    break;
                case 3:
                    productItem["PRODUCT_ID"] = this.offers[this.offerNum].ID;
                    productItem["ARTICLE"] = this.offers[this.offerNum].ARTICLE;

                    if(this.offers[this.offerNum].MORE_PHOTOS && BX.type.isArray(this.offers[this.offerNum].MORE_PHOTOS))
                        productItem["PHOTO"] = this.offers[this.offerNum].MORE_PHOTOS[0].MIDDLE.SRC;

                    productItem["element_item_offers"] = this.offers[this.offerNum].TREE_INFO;
                    break;

                default:
                    break;
            }

            showProcessLoad();


            BX.ajax({
                method: 'POST',
                dataType: 'html',
                url: '/bitrix/tools/concept.phoenix/ajax/basket/call_form_fast_order.php',
                data: {
                    productItem: productItem,
                    site_id: $("input.site_id").val()
                },
                onsuccess: BX.proxy(this.callFormResult, this)
            });
        },



        callFormResult: function(html)
        {
            closeProcessLoad();
            startModalMode("div.modalAreaForm");
            $('div.modalAreaForm').html(html);
        },


        add2Delay: function()
        {
            var productID = '',
                value = 1;
                
            if(this.obQuantity)
                value = this.obQuantity.value;


            switch (this.productType)
            {
                case 1:
                case 2: 
                    productID = this.product.id.toString();
                    break;
                case 3:
                    productID = this.offers[this.offerNum].ID;
                    break;

                default:
                    break;
            }


            BX.ajax({
                method: 'POST',
                dataType: 'json',
                url: '/bitrix/tools/concept.phoenix/ajax/basket/wishlist.php',
                data: {
                    product_id: productID,
                    price_id: this.currentPrices[this.currentPriceSelected].ID,
                    price: this.currentPrices[this.currentPriceSelected].PRICE,
                    name: this.product.name,
                    detail_page: this.product.detail_page_url,
                    can_buy: this.canBuy,
                    quantity: value,
                    currency: this.currentPrices[this.currentPriceSelected].CURRENCY,
                    site_id: $("input.site_id").val()
                },
                onsuccess: BX.proxy(this.delayResult, this)
            });
        },

        delayResult: function(arResult)
        {
            if(arResult["OK"]=="Y")
            {
                if(this.productType == 3)
                {
                    if(arResult["ACTION"] == 'active')
                        this.offers[this.offerNum].IN_DELAY = true;
                    
                    if(arResult["ACTION"] == 'delete')
                        this.offers[this.offerNum].IN_DELAY = false;
                }

                markProductDelayBasket(this.currentItemId, arResult["ACTION"]);             
            }
            else
                console.log(arResult["OK"]);
        },

        add2Compare: function()
        {

            var checked = false;


            switch (this.productType)
            {
                case 1:
                case 2: 
                    productID = this.product.id.toString();
                    break;
                case 3:
                    productID = this.offers[this.offerNum].ID;
                    break;
                default:
                    break;
            }

            if(!BX.hasClass(this.obCompare, "active"))
                checked = true;


            var url = checked ? this.compareUrlAdd : this.compareUrlDelete, compareLink;
                
            if(url)
            {

                switch (this.productType)
                {
                    case 0:
                    case 1:
                    case 2:
                        compareLink = url.replace('#ID#', this.product.id.toString());
                        break;
                    case 3:
                        compareLink = url.replace('#ID#', this.offers[this.offerNum].ID);
                        break;
                }



                BX.ajax({
                    method: 'POST',
                    dataType: checked ? 'json' : 'html',
                    url: compareLink + (compareLink.indexOf('?') !== -1 ? '&' : '?') + 'ajax_action=Y',
                    onsuccess: checked
                        ? BX.proxy(this.compareResult, this)
                        : BX.proxy(this.compareDeleteResult, this)
                });



            }

        

        },

        compareResult: function(arResult)
        {
            /*if (!BX.type.isPlainObject(arResult))
                return;

            

            if (arResult.STATUS === 'OK')
            {*/
                if (this.offers.length > 0)
                    this.offers[this.offerNum].IN_COMPARE = true;
                

                markProductCompareBasket(this.currentItemId, 'active'); 
            /*}*/
        },

        compareDeleteResult: function(arResult)
        {

            if (this.offers.length > 0)
                this.offers[this.offerNum].IN_COMPARE = false;
            

            markProductCompareBasket(this.currentItemId, 'delete'); 
        
        },

        add2Basket: function()
        {

            if (!this.canBuy)
                return;

            var productID = '',
                value = 1;

            if(this.obQuantity)
                value = this.obQuantity.value;

            switch (this.productType)
            {
                case 1:
                case 2: 
                    productID = this.product.id.toString();
                    break;
                case 3:
                    productID = this.offers[this.offerNum].ID;
                    break;

                default:
                    break;
            }

            

            productItem = {
                PRODUCT_ID: productID,
                QUANTITY: value,
                PRICE_ID: this.currentPrices[this.currentPriceSelected].ID
            };

            $(this.obAdd2BasketBtn).addClass("btn-processing");

            BX.ajax({
                method: 'POST',
                dataType: 'json',
                url: '/bitrix/tools/concept.phoenix/ajax/basket/add2basket.php',
                data: {
                    productItem: productItem,
                    site_id: $("input.site_id").val()
                },
                onsuccess: BX.proxy(this.basketResult, this)
            });
        },

        basketResult: function(arResult)
        {

            /*if (!BX.type.isPlainObject(arResult))
                return;*/

            if(arResult["OK"]=="Y")
            {
                if(this.productType === 3)
                    this.offers[this.offerNum].IN_BASKET = true;

                markProductAddBasket(this.currentItemId);

                if(arResult["SCRIPTS"])
                    $('body').append(arResult["SCRIPTS"]);
            }
            
            $(this.obAdd2BasketBtn).removeClass("btn-processing");
            
            
        },

        deleteParameterURL: function (url, param) {
            var a = url.split('?');
            var re = new RegExp('(\\?|&)'+param+'=[^&]+','g');

            if(url == "undefined")
                url = "";

            url=('?'+a[1]).replace(re,'');
            url=url.replace(/^&|\?/,'');

            if(url == "undefined")
                url = "";

            var dlm=(url=='')? '': '?';
            return a[0]+dlm+url;
        },

        addParameterToURL: function (param, value){

            var url = window.location.href;
            

            if (history.replaceState) {
                var baseUrl = this.deleteParameterURL(url, param);
                baseUrl += (baseUrl.split('?')[1] ? '&':'?') + param+"="+value;
                history.replaceState(null, null, baseUrl);
            }
            else {
                console.warn('History API don`t support');
            }
        },

        selectOfferProp: function()
        {
            var i = 0,
                strTreeValue = '',
                arTreeItem = [],
                rowItems = null,
                target = BX.proxy_context,
                smallCardItem;


            if (target && target.hasAttribute('data-treevalue'))
            {
                if (BX.hasClass(target, 'active'))
                    return;



                if (typeof document.activeElement === 'object')
                {
                    document.activeElement.blur();
                }



                strTreeValue = target.getAttribute('data-treevalue');
                arTreeItem = strTreeValue.split('_');

                this.searchOfferPropIndex(arTreeItem[0], arTreeItem[1]);


                rowItems = BX.findChildren(target.parentNode, {tagName: 'li'}, false);


                if (rowItems && rowItems.length)
                {
                    for (i = 0; i < rowItems.length; i++)
                    {
                        BX.removeClass(rowItems[i], 'active');
                    }
                }

                
                BX.addClass(target, 'active');

            }
        },


        searchOfferPropIndex: function(strPropID, strPropValue)
        {
            var strName = '',
                arShowValues = false,
                arCanBuyValues = [],
                allValues = [],
                index = -1,
                i, j,
                arFilter = {},
                tmpFilter = [];



            for (i = 0; i < this.treeProps.length; i++)
            {
                if (this.treeProps[i].ID === strPropID)
                {
                    index = i;
                    break;
                }
            }

            if (index > -1)
            {
                for (i = 0; i < index; i++)
                {
                    strName = 'PROP_' + this.treeProps[i].ID;
                    arFilter[strName] = this.selectedValues[strName];
                }

                
                strName = 'PROP_' + this.treeProps[index].ID;
                arFilter[strName] = strPropValue;



                for (i = index + 1; i < this.treeProps.length; i++)
                {

                    strName = 'PROP_' + this.treeProps[i].ID;
                    arShowValues = this.getRowValues(arFilter, strName);



                    if (!arShowValues)
                        break;

                    allValues = [];

                    if (this.config.showAbsent)
                    {
                        
                        arCanBuyValues = [];
                        tmpFilter = [];
                        tmpFilter = BX.clone(arFilter, true);

                        for (j = 0; j < arShowValues.length; j++)
                        {
                            tmpFilter[strName] = arShowValues[j];
                            allValues[allValues.length] = arShowValues[j];
                            if (this.getCanBuy(tmpFilter))
                                arCanBuyValues[arCanBuyValues.length] = arShowValues[j];
                        }
                    }
                    else
                    {
                        arCanBuyValues = arShowValues;
                    }




                    if (this.selectedValues[strName] && BX.util.in_array(this.selectedValues[strName], arCanBuyValues))
                    {
                        arFilter[strName] = this.selectedValues[strName];

                    }
                    else
                    {

                        if (this.config.showAbsent)
                        {
                            arFilter[strName] = (arCanBuyValues.length ? arCanBuyValues[0] : allValues[0]);
                        }
                        else
                        {
                            arFilter[strName] = arCanBuyValues[0];
                        }
                    }


                    this.updateRow(i, arFilter[strName], arShowValues, arCanBuyValues);

                }

                
                this.selectedValues = arFilter;


                this.changeInfo();

            }

            if(this.useUrlParam == "Y")
            {
                this.addParameterToURL("oID", this.offers[this.offerNum].ID);
            }


        },

        setCurrent: function()
        {
            var i,
                j = 0,
                strName = '',
                arShowValues = false,
                arCanBuyValues = [],
                arFilter = {},
                tmpFilter = [],
                current = this.offers[this.offerNum].TREE;

                

            for (i = 0; i < this.treeProps.length; i++)
            {
                strName = 'PROP_' + this.treeProps[i].ID;
                arShowValues = this.getRowValues(arFilter, strName);


                if (!arShowValues)
                    break;

                if (BX.util.in_array(current[strName], arShowValues))
                {
                    arFilter[strName] = current[strName];
                }
                else
                {
                    arFilter[strName] = arShowValues[0];
                    this.offerNum = 0;
                }

                if (this.config.showAbsent)
                {
                    arCanBuyValues = [];
                    tmpFilter = [];
                    tmpFilter = BX.clone(arFilter, true);

                    for (j = 0; j < arShowValues.length; j++)
                    {
                        tmpFilter[strName] = arShowValues[j];

                        if (this.getCanBuy(tmpFilter))
                        {
                            arCanBuyValues[arCanBuyValues.length] = arShowValues[j];
                        }
                    }
                }
                else
                {
                    arCanBuyValues = arShowValues;
                }
            
                
                this.updateRow(i, arFilter[strName], arShowValues, arCanBuyValues);
            }

            this.selectedValues = arFilter;

            this.changeInfo();
        },

        getRowValues: function(arFilter, index)
        {
            var arValues = [],
                i = 0,
                j = 0,
                boolSearch = false,
                boolOneSearch = true;



            if (arFilter.length === 0)
            {
                for (i = 0; i < this.offers.length; i++)
                {
                    if (!BX.util.in_array(this.offers[i].TREE[index], arValues))
                    {
                        arValues[arValues.length] = this.offers[i].TREE[index];

                    }
                }
                boolSearch = true;
            }
            else
            {
                for (i = 0; i < this.offers.length; i++)
                {
                    boolOneSearch = true;

                    for (j in arFilter)
                    {
                        if (arFilter[j] !== this.offers[i].TREE[j])
                        {
                            boolOneSearch = false;
                            break;
                        }
                    }

                    if (boolOneSearch)
                    {
                        if (!BX.util.in_array(this.offers[i].TREE[index], arValues))
                        {
                            arValues[arValues.length] = this.offers[i].TREE[index];
                            
                        }

                        boolSearch = true;
                    }
                }
            }



            return (boolSearch ? arValues : false);
        },

        updateRow: function(intNumber, activeId, showId, canBuyId)
        {

            var i = 0,
                value = '',
                isCurrent = false,
                rowItems = null;


            var lineContainer = this.getEntities(this.obTree, 'sku-line-block');


            if (intNumber > -1 && intNumber < lineContainer.length)
            {
                rowItems = lineContainer[intNumber].querySelectorAll('li');


                for (i = 0; i < rowItems.length; i++)
                {
                    value = rowItems[i].getAttribute('data-onevalue');
                    isCurrent = value === activeId;


                    if (isCurrent)
                    {
                        BX.addClass(rowItems[i], 'active');
                    }
                    else
                    {
                        BX.removeClass(rowItems[i], 'active');
                    }

                    if (BX.util.in_array(value, canBuyId))
                    {
                        BX.removeClass(rowItems[i], 'notallowed');
                    }
                    else
                    {
                        BX.addClass(rowItems[i], 'notallowed');
                    }

                    rowItems[i].style.display = BX.util.in_array(value, showId) ? '' : 'none';

                    if (isCurrent)
                    {
                        lineContainer[intNumber].style.display = (value == 0 ) ? 'none' : '';
                    }
                }
            }
        },

        changeInfo: function()
        {
            var index = -1,
                j = 0,
                boolOneSearch = true,
                eventData = {
                    currentId: (this.offerNum > -1 ? this.offers[this.offerNum].ID : 0),
                    newId: 0
                },
                descTitle = null,
                rowItems = null;

            var i;

            for (i = 0; i < this.offers.length; i++)
            {


                boolOneSearch = true;

                for (j in this.selectedValues)
                {

                    if (this.selectedValues[j] !== this.offers[i].TREE[j])
                    {
                        boolOneSearch = false;
                        break;
                    }

                }

                if (boolOneSearch)
                {
                    index = i;
                    break;
                }
            }
            

            this.offerNum = index;

            this.changeCharsBlock();

            if (index > -1)
            {   
                this.currentItemId = this.offers[this.offerNum].ID;

                if(this.offers[this.offerNum].USE_PRICE_COUNT)
                    this.setPriceMatrix(this.offers[index].PRICE_MATRIX);
                
                this.updateInfoBasketOffer(this.offers[index].ID, this.visual.ID);

           



                for (i = 0; i < this.offers.length; i++)
                {
                    if (this.config.showOfferGroup && this.offers[i].OFFER_GROUP)
                    {
                        if (offerGroupNode = BX(this.visual.OFFER_GROUP + this.offers[i].ID))
                            offerGroupNode.style.display = (i == index ? '' : 'none');
                        
                    }
                }



                if(this.offers[index].MORE_PHOTOS && BX.type.isArray(this.offers[index].MORE_PHOTOS))
                    this.firstPictureSrcSmall = this.offers[index].MORE_PHOTOS[0].SMALL.SRC;
                else
                {
                    this.firstPictureSrcSmall = this.no_photo_src;
                }

                $("input.product-"+this.product.id+"-picture-src-small").val(this.firstPictureSrcSmall);



                if(this.product.zoom)
                {
                    $(this.obProduct).find('.zoom-offer').trigger('zoom-offer.destroy');
                    initZoomer($(this.obProduct).find(".zoom-offer"));
                }


                if( this.offers[this.offerNum].IN_BASKET == true
                    || this.offers[this.offerNum].IN_DELAY == true
                    || this.offers[this.offerNum].IN_COMPARE == true
                    )
                {

                    setItemButtonStatus(
                        this.currentItemId, 
                        '', 
                        this.offers[this.offerNum].IN_BASKET,
                        this.offers[this.offerNum].IN_DELAY,
                        this.offers[this.offerNum].IN_COMPARE
                    );

           
                    setItemButtonStatus(this.currentItemId, '', 'offer_delay_added');
                    setItemButtonStatus(this.currentItemId, '', 'compare_added');
                    
                }
                    

                else
                {
                    setItemButtonStatus(arStatusBasketPhoenix);
                }
            }

            this.quantitySet(index);
            this.setPrice();
                
            if(!this.firstLoad)
            {
                this.drawImages(this.offers[index].MORE_PHOTOS);
                this.btnsControl();
            	this.showArticleStoreQuantity();

                getHtmlStoreList(this.currentItemId, this.offers[index].STORE);
            }
            this.firstLoad = false;

            this.product.detail_page_url = this.product.detail_page_url + '?oID=' + this.offers[this.offerNum].ID;
        },


        hideBtns: function()
        {

        	if(this.config.fastOrderShow)
	            $(".cart-info-block .wrapper-btns .right-btn").addClass('d-none');


	        if(this.config.add2BasketShow)
	            $(".cart-info-block .wrapper-btns .left-btn").addClass('d-none');

	        $(".cart-info-block .wrapper-btns").addClass('d-none');
	        $(".cart-info-block .wrapper-quantity").addClass('d-none');
        },

        showBtns: function()
        {
        	$(".cart-info-block .wrapper-btns").removeClass('d-none');
	       

        	if(this.config.fastOrderShow)
	            $(".cart-info-block .wrapper-btns .right-btn").removeClass('d-none');
            
            else
            {
                $(".cart-info-block .wrapper-btns .right-btn").addClass('d-none');
            }




	        if(this.config.add2BasketShow)
            {
	            $(".cart-info-block .wrapper-btns .left-btn").removeClass('d-none');
                $(".cart-info-block .wrapper-quantity").removeClass('d-none');
            }
        },

        btnsControl: function()
        {
        	

        	if(this.offers[this.offerNum].SHOWPREORDERBTN || this.offers[this.offerNum].MODE_ARCHIVE)
			{
				if(this.offers[this.offerNum].SHOWPREORDERBTN)
					$(".cart-info-block .wr-preorder").removeClass('d-none');
				else
				{
					$(".cart-info-block .wr-preorder").addClass('d-none');
				}

				this.hideBtns();
			}

			else
			{
				$(".cart-info-block .wr-preorder").addClass('d-none');

				if(this.offers[this.offerNum].CAN_BUY && this.offers[this.offerNum].MODE_DISALLOW_ORDER !="Y")
			    {
			        this.showBtns();
			    }
			    else
			    {
			        this.hideBtns();
			    }
			}

        },

        updateInfoBasketOffer: function(id, parent)
        {
            parent = parent || '';

            if(parent.length>0)
                parent = "#"+parent;

            
            $(parent+' .add2basket').attr('data-item', id);
            $(parent+' .move2basket').attr('data-item', id);
            $(parent+' .quantity-block').attr('data-item', id);
            $(parent+' .delay').attr('data-item', id);
            $(parent+' .compare').attr('data-item', id);
        },

        setPriceMatrix: function(sPriceMatrix)
        {
            if(sPriceMatrix.length > 0)
            {
                BX.adjust(this.obPriceMatrix, {style: {display: ''}, html: sPriceMatrix});
            }
            else
            {
                BX.adjust(this.obPriceMatrix, {style: {display: 'none'}, html: ''});
            }
        },

        changeCharsBlock: function()
        {
            
            var html = "";

            if(this.obSkuChars)
            {
                $(".chars-link").removeClass("d-none");
                if(this.offers[this.offerNum].SKU_LIST_CHARS.length)
                {
                    for (i = 0; i < this.offers[this.offerNum].SKU_LIST_CHARS.length; i++)
                    {
                        html += "<table class='cart-char-table mobile-break show-hidden-child'>";
                            html += "<tbody>";
                                html += "<tr>";
                                    html += "<td class='left'>"+this.offers[this.offerNum].SKU_LIST_CHARS[i].NAME+"</td>";
                                    html += "<td class='dotted'>";
                                        html += "<div class='dotted'></div>";
                                    html += "</td>";
                                    html += "<td class='sku-value right bold'>"+this.offers[this.offerNum].SKU_LIST_CHARS[i].VALUE+"</td>";
                                html += "</tr>";
                            html += "</tbody>";
                        html += "</table>";
                    }
                }
                else
                {
                    $(".chars-link").addClass("d-none");
                }

                BX.adjust(this.obSkuChars, {
                    html: html
                });
            }

            if(html.length<=0 && $(this.obSkuChars).parents(".cart-char-col-left").find(".cart-char-table").length<=0)
                $(this.obSkuChars).parents(".cart-char-col-left").hide();
            
            else
            {
                $(this.obSkuChars).parents(".cart-char-col-left").show();
            }
        },

        showArticleStoreQuantity: function()
        {
            var showArticle = false,
                showQuantity = false,
                html = "";

            if(this.offers[this.offerNum].ARTICLE)
            {
            	html += "<div class=\"detail-article italic\">" + BX.message("ARTICLE") + this.offers[this.offerNum].ARTICLE+"</div>";
            	
                showArticle = true;
            }

            
            if(this.offers[this.offerNum].QUANTITY_HTML.length>0)
            {
                html+=this.offers[this.offerNum].QUANTITY_HTML;
                showQuantity = true;

            }

            if(showArticle || showQuantity)
            {
            	BX.adjust(this.obArticleAvailable,
                    {
                        style: {display: ''},
                        html: html
                    }
                );
                
            }
            else
            {
            	BX.adjust(this.obArticleAvailable,
                    {
                        style: {display: ''},
                        html: ""
                    }
                );
            }

        },

        setPrice: function()
        {
            var economyInfo = '', price, hidePrice = false;

            if (this.obQuantity)
            {
                this.checkPriceRange(this.obQuantity.value);
            }

            this.checkQuantityControls();

            price = this.currentPrices[this.currentPriceSelected];

            var blockPrice = this.getEntity(this.obProduct, 'block-price');

            if(typeof price == "undefined")
                price = this.offers[this.offerNum].PRICE;
            
            
            if (this.obPrice.price)
            {

                if(price.PRICE == "-1")
                {
                    BX.adjust(this.obPrice.price, {html: ''});
                    BX.adjust(blockPrice, {style:{display: "none"}});
                }
                else
                {   
                    BX.adjust(this.obPrice.price, {html: BX.Currency.currencyFormat(price.PRICE, price.CURRENCY, true), style:{display: ""}} );
                    BX.adjust(blockPrice, {style:{display: ""}});
                }


                if(this.productType == 3)
                {
                	if(this.offers[this.offerNum].MODE_ARCHIVE == "Y")
	                    hidePrice = true;

	                if(hidePrice)
	                {
	                    BX.adjust(this.obPrice.price, {html: ''});
	                    BX.adjust(blockPrice, {style:{display: "none"}});
	                }
                }


                if (price && price.RATIO_PRICE !== price.RATIO_BASE_PRICE)
                {
                    if (this.config.showOldPrice)
                    {
                        this.obPrice.full && BX.adjust(this.obPrice.full, {
                            style: {display: ''},
                            html: BX.Currency.currencyFormat(price.BASE_PRICE, price.CURRENCY, true)
                        });


                        if (this.obPrice.discount)
                        {
                            economyInfo = "<span class='item-style desc-discount'>"+BX.message('ECONOMY_INFO_MESSAGE')+"</span>"
                            +"<span class='item-style actual-econom bold'>"+BX.Currency.currencyFormat(price.DISCOUNT, price.CURRENCY, true)+"</span>";
                            

                            
                            if (this.config.showPercent)
                            {
                                economyInfo += "<span id='"+this.visual.DISCOUNT_PERCENT_ID+"' class='item-style actual-discount'>"+(-price.PERCENT)+"%<span>";
                            }


                            BX.adjust(this.obPrice.discount, {style: {display: ''}, html: economyInfo});
                        }
                    }

                    
                }
                else
                {
                    if (this.config.showOldPrice)
                    {
                        this.obPrice.full && BX.adjust(this.obPrice.full, {style: {display: 'none'}, html: ''});
                        this.smallCardNodes.oldPrice && BX.adjust(this.smallCardNodes.oldPrice, {style: {display: 'none'}, html: ''});
                        this.obPrice.discount && BX.adjust(this.obPrice.discount, {style: {display: 'none'}, html: ''});
                    }

                    if (this.config.showPercent)
                    {
                        this.obPrice.percent && BX.adjust(this.obPrice.percent, {style: {display: 'none'}, html: ''});
                    }
                }

                if (this.obPrice.total)
                {

                    if (price && this.obQuantity && this.obQuantity.value != this.stepQuantity)
                    {
                        BX.adjust(this.obPrice.total, {
                            html:  "<span class='desc-total'>" + BX.message('PRICE_TOTAL_PREFIX') + "</span>" + "<span class='total-value bold' title='"+BX.Currency.currencyFormat(price.PRICE * this.obQuantity.value, price.CURRENCY, true)+"'>" +BX.Currency.currencyFormat(price.PRICE * this.obQuantity.value, price.CURRENCY, true) + "</span>",
                            style: {display: ''}
                        });
                    }
                    else
                    {
                        BX.adjust(this.obPrice.total, {
                            html: '',
                            style: {display: 'none'}
                        });
                    }
                    
                }
            }
           
            


        },

        checkQuantityControls: function()
        {
            if (!this.obQuantity)
                return;



            var reachedTopLimit = this.checkQuantity && parseFloat(this.obQuantity.value) + this.stepQuantity > this.maxQuantity,
                reachedBottomLimit = parseFloat(this.obQuantity.value) - this.stepQuantity < this.minQuantity;

            if (reachedTopLimit)
            {
                BX.addClass(this.obQuantityUp, 'product-item-amount-field-btn-disabled');
            }
            else if (BX.hasClass(this.obQuantityUp, 'product-item-amount-field-btn-disabled'))
            {
                BX.removeClass(this.obQuantityUp, 'product-item-amount-field-btn-disabled');
            }

            if (reachedBottomLimit)
            {
                BX.addClass(this.obQuantityDown, 'product-item-amount-field-btn-disabled');
            }
            else if (BX.hasClass(this.obQuantityDown, 'product-item-amount-field-btn-disabled'))
            {
                BX.removeClass(this.obQuantityDown, 'product-item-amount-field-btn-disabled');
            }

            if (reachedTopLimit && reachedBottomLimit)
            {
                this.obQuantity.setAttribute('disabled', 'disabled');
            }
            else
            {
                this.obQuantity.removeAttribute('disabled');
            }
        },

        checkPriceRange: function(quantity)
        {
            if (typeof quantity === 'undefined'|| this.currentPriceMode !== 'Q')
            {
                return;
            }

            var range, found = false;

            for (var i in this.currentQuantityRanges)
            {
                if (this.currentQuantityRanges.hasOwnProperty(i))
                {
                    range = this.currentQuantityRanges[i];

                    if (
                        parseFloat(quantity) >= parseFloat(range.SORT_FROM)
                        && (
                            range.SORT_TO === 'INF'
                            || parseFloat(quantity) <= parseFloat(range.SORT_TO)
                        )
                    )
                    {
                        found = true;
                        this.currentQuantityRangeSelected = range.HASH;
                        break;
                    }
                }
            }

            if (!found && (range = this.getMinPriceRange()))
            {
                this.currentQuantityRangeSelected = range.HASH;
            }

            for (var k in this.currentPrices)
            {
                if (this.currentPrices.hasOwnProperty(k))
                {
                    if (this.currentPrices[k].QUANTITY_HASH == this.currentQuantityRangeSelected)
                    {
                        this.currentPriceSelected = k;
                        break;
                    }
                }
            }
        },

        checkQuantityRange: function(quantity, direction)
        {
            if (typeof quantity === 'undefined'|| this.currentPriceMode !== 'Q')
            {
                return quantity;
            }

            quantity = parseFloat(quantity);

            var nearestQuantity = quantity;
            var range, diffFrom, absDiffFrom, diffTo, absDiffTo, shortestDiff;

            for (var i in this.currentQuantityRanges)
            {
                if (this.currentQuantityRanges.hasOwnProperty(i))
                {
                    range = this.currentQuantityRanges[i];

                    if (
                        parseFloat(quantity) >= parseFloat(range.SORT_FROM)
                        && (
                            range.SORT_TO === 'INF'
                            || parseFloat(quantity) <= parseFloat(range.SORT_TO)
                        )
                    )
                    {
                        nearestQuantity = quantity;
                        break;
                    }
                    else
                    {
                        diffFrom = parseFloat(range.SORT_FROM) - quantity;
                        absDiffFrom = Math.abs(diffFrom);
                        diffTo = parseFloat(range.SORT_TO) - quantity;
                        absDiffTo = Math.abs(diffTo);

                        if (shortestDiff === undefined || shortestDiff > absDiffFrom)
                        {
                            if (
                                direction === undefined
                                || (direction === 'up' && diffFrom > 0)
                                || (direction === 'down' && diffFrom < 0)
                            )
                            {
                                shortestDiff = absDiffFrom;
                                nearestQuantity = parseFloat(range.SORT_FROM);
                            }
                        }

                        if (shortestDiff === undefined || shortestDiff > absDiffTo)
                        {
                            if (
                                direction === undefined
                                || (direction === 'up' && diffFrom > 0)
                                || (direction === 'down' && diffFrom < 0)
                            )
                            {
                                shortestDiff = absDiffTo;
                                nearestQuantity = parseFloat(range.SORT_TO);
                            }
                        }
                    }
                }
            }

            return nearestQuantity;
        },

        getMinPriceRange: function()
        {
            var range;

            for (var i in this.currentQuantityRanges)
            {
                if (this.currentQuantityRanges.hasOwnProperty(i))
                {
                    if (
                        !range
                        || parseInt(this.currentQuantityRanges[i].SORT_FROM) < parseInt(range.SORT_FROM)
                    )
                    {
                        range = this.currentQuantityRanges[i];
                    }
                }
            }

            return range;
        },


        startQuantityInterval: function()
        {
            var target = BX.proxy_context;
            var func = target.id === this.visual.QUANTITY_DOWN_ID
                ? BX.proxy(this.quantityDown, this)
                : BX.proxy(this.quantityUp, this);



            this.quantityDelay = setTimeout(
                BX.delegate(function() {
                    this.quantityTimer = setInterval(func, 150);
                }, this),
                300
            );
        },

        clearQuantityInterval: function()
        {
            clearTimeout(this.quantityDelay);
            clearInterval(this.quantityTimer);
        },

        quantityUp: function()
        {
            var curValue = 0,
                boolSet = true;



            if (this.errorCode === 0 && this.config.showQuantity && this.canBuy)
            {

                curValue = this.isDblQuantity ? parseFloat(this.obQuantity.value) : parseInt(this.obQuantity.value, 10);
                if (!isNaN(curValue))
                {
                    curValue += this.stepQuantity;

                    curValue = this.checkQuantityRange(curValue, 'up');

                    if (this.checkQuantity && curValue > this.maxQuantity)
                    {
                        boolSet = false;
                    }

                    if (boolSet)
                    {
                        if (this.isDblQuantity)
                        {
                            curValue = Math.round(curValue * this.precisionFactor) / this.precisionFactor;
                        }

                        this.obQuantity.value = curValue;

                        this.setPrice();
                    }
                }
            }
        },

        quantityDown: function()
        {
            var curValue = 0,
                boolSet = true;

            if (this.errorCode === 0 && this.config.showQuantity && this.canBuy && !this.isGift)
            {
                curValue = (this.isDblQuantity ? parseFloat(this.obQuantity.value) : parseInt(this.obQuantity.value, 10));
                if (!isNaN(curValue))
                {
                    curValue -= this.stepQuantity;

                    curValue = this.checkQuantityRange(curValue, 'down');

                    if (curValue < this.minQuantity)
                    {
                        boolSet = false;
                    }

                    if (boolSet)
                    {
                        if (this.isDblQuantity)
                        {
                            curValue = Math.round(curValue * this.precisionFactor) / this.precisionFactor;
                        }

                        this.obQuantity.value = curValue;

                        this.setPrice();
                    }
                }
            }
        },

        quantityChange: function()
        {
            var curValue = 0,
                intCount;

            if (this.errorCode === 0 && this.config.showQuantity)
            {
                if (this.canBuy)
                {

                    curValue = this.isDblQuantity ? parseFloat(this.obQuantity.value) : Math.round(this.obQuantity.value);


                    if (!isNaN(curValue))
                    {
                        curValue = this.checkQuantityRange(curValue);

                        if (this.checkQuantity)
                        {
                            if (curValue > this.maxQuantity)
                            {
                                curValue = this.maxQuantity;
                            }
                        }

                        this.checkPriceRange(curValue);

                        if (curValue < this.minQuantity)
                        {
                            curValue = this.minQuantity;
                        }
                        else
                        {
                            intCount = Math.round(
                                    Math.round(curValue * this.precisionFactor / this.stepQuantity) / this.precisionFactor
                                ) || 1;

                            
                            curValue = (intCount <= 1 ? this.stepQuantity : intCount * this.stepQuantity);

                            curValue = Math.round(curValue * this.precisionFactor) / this.precisionFactor;

                        }

                        this.obQuantity.value = curValue;
                    }
                    else
                    {
                        this.obQuantity.value = this.minQuantity;
                    }
                }
                else
                {
                    this.obQuantity.value = this.minQuantity;
                }

                this.setPrice();
            }
        },

        quantitySet: function(index)
        {

            var strLimit, resetQuantity;
            
            var newOffer = this.offers[index],
                oldOffer = this.offers[this.offerNum];


                
            if (this.errorCode === 0)
            {

                this.canBuy = newOffer.CAN_BUY;

                this.currentPriceMode = newOffer.ITEM_PRICE_MODE;
                this.currentPrices = newOffer.ITEM_PRICES;
                this.currentPriceSelected = newOffer.ITEM_PRICE_SELECTED;
                this.currentQuantityRanges = newOffer.ITEM_QUANTITY_RANGES;
                this.currentQuantityRangeSelected = newOffer.ITEM_QUANTITY_RANGE_SELECTED;



                if (this.canBuy)
                {
                    this.node.quantity && BX.style(this.node.quantity, 'display', '');
                    this.obBasketActions && BX.style(this.obBasketActions, 'display', '');
                    this.obSubscribe && BX.style(this.obSubscribe, 'display', 'none');
                }
                else
                {
                    this.node.quantity && BX.style(this.node.quantity, 'display', 'none');
                    this.obBasketActions && BX.style(this.obBasketActions, 'display', 'none');

                    if (this.obSubscribe)
                    {

                        if (newOffer.CATALOG_SUBSCRIBE === 'Y')
                        {
                            BX.style(this.obSubscribe, 'display', '');
                            this.obSubscribe.setAttribute('data-item', newOffer.ID);
                            BX(this.visual.SUBSCRIBE_LINK + '_hidden').click();
                        }
                        else
                        {
                            BX.style(this.obSubscribe, 'display', 'none');
                        }
                    }
                }

                this.isDblQuantity = newOffer.QUANTITY_FLOAT;
                this.checkQuantity = newOffer.CHECK_QUANTITY;



                if (this.isDblQuantity)
                {
                    this.stepQuantity = Math.round(parseFloat(newOffer.STEP_QUANTITY) * this.precisionFactor) / this.precisionFactor;
                    this.maxQuantity = parseFloat(newOffer.MAX_QUANTITY);
                    this.minQuantity = this.currentPriceMode === 'Q' ? parseFloat(this.currentPrices[this.currentPriceSelected].MIN_QUANTITY) : this.stepQuantity;
                }
                else
                {
                    this.stepQuantity = parseInt(newOffer.STEP_QUANTITY, 10);
                    this.maxQuantity = parseInt(newOffer.MAX_QUANTITY, 10);
                    this.minQuantity = this.currentPriceMode === 'Q' ? parseInt(this.currentPrices[this.currentPriceSelected].MIN_QUANTITY) : this.stepQuantity;
                }



                if (this.config.showQuantity)
                {
                    var isDifferentMinQuantity = oldOffer.ITEM_PRICES.length
                        && oldOffer.ITEM_PRICES[oldOffer.ITEM_PRICE_SELECTED]
                        && oldOffer.ITEM_PRICES[oldOffer.ITEM_PRICE_SELECTED].MIN_QUANTITY != this.minQuantity;

                    if (this.isDblQuantity)
                    {
                        resetQuantity = Math.round(parseFloat(oldOffer.STEP_QUANTITY) * this.precisionFactor) / this.precisionFactor !== this.stepQuantity
                            || isDifferentMinQuantity
                            || oldOffer.MEASURE !== newOffer.MEASURE
                            || (
                                this.checkQuantity
                                && parseFloat(oldOffer.MAX_QUANTITY) > this.maxQuantity
                                && parseFloat(this.obQuantity.value) > this.maxQuantity
                            );
                    }
                    else
                    {
                        resetQuantity = parseInt(oldOffer.STEP_QUANTITY, 10) !== this.stepQuantity
                            || isDifferentMinQuantity
                            || oldOffer.MEASURE !== newOffer.MEASURE
                            || (
                                this.checkQuantity
                                && parseInt(oldOffer.MAX_QUANTITY, 10) > this.maxQuantity
                                && parseInt(this.obQuantity.value, 10) > this.maxQuantity
                            );
                    }

                    this.obQuantity.disabled = !this.canBuy;

                    if (resetQuantity)
                    {
                        this.obQuantity.value = this.minQuantity;
                    }
                }

                if (this.obMeasure)
                {

                    if (newOffer.MEASURE_PRICE)
                    {
                        BX.adjust(this.obMeasure, {html: newOffer.MEASURE_PRICE, style: {display: ''}});
                    }
                    else
                    {
                        BX.adjust(this.obMeasure, {html: '', style: {display: 'none'}});
                    }
                }
        
            }
        },

        getCanBuy: function(arFilter)
        {
            var i,
                j = 0,
                boolOneSearch = true,
                boolSearch = false;

            for (i = 0; i < this.offers.length; i++)
            {
                boolOneSearch = true;

                for (j in arFilter)
                {
                    if (arFilter[j] !== this.offers[i].TREE[j])
                    {
                        boolOneSearch = false;
                        break;
                    }
                }

                if (boolOneSearch)
                {
                    if (this.offers[i].CAN_BUY)
                    {
                        boolSearch = true;
                        break;
                    }
                }
            }

            return boolSearch;
        },

        
        
        drawImages: function(images)
        {

            var nodeControlPics = $(this.obBigSlider).find(".controls-pictures"),
                nodeBigPics = $(this.obBigSlider).find(".wrapper-big-picture"),
                nodeControlPicsParent = nodeControlPics.parent(),
                nodeBigPicsParent = nodeBigPics.parent(),
                listControl = "",
                listBigPic = "",
                imagesIsset = images && BX.type.isArray(images),
                countMoreImages = 0,
                countImages = 0;

                
            nodeControlPics.removeClass('one-photo').html("");
            nodeBigPics.html("");


            if(imagesIsset)
            {
                countImages = images.length;
                if(countImages > 0)
                {

                    for (i = 0; i < images.length; i++)
                    {

                        if(i < 3)
                        {
                            listControl += "<div data-value='"+images[i].ID+"'";
                            listControl += "class='small-picture";

                                if(i == 0)
                                {
                                    listControl += " active";
                                }
                                listControl += "'>";


                            listControl += "<img src='"+images[i].SMALL.SRC+"' alt = '";

                                if(images[i].DESC)
                                    listControl += images[i].DESC;

                            listControl += "'/>";

                            listControl += "</div>";
                        }
                        


                        listBigPic += "<div data-id='"+images[i].ID+"'";
                            listBigPic += "class='big-picture";

                            if(i == 0)
                            {
                                listBigPic += " active";
                            }
                            listBigPic += "'>";

                        listBigPic += "<a class='cursor-loop d-block open-popup-gallery "+this.product.zoom+"-offer' data-popup-gallery='"+this.currentItemId+"_"+this.obName+"'>";

                            listBigPic += "<img class='d-block mx-auto img-fluid open-popup-gallery-item' data-src='"+images[i].BIG.SRC+"' src='"+images[i].BIG.SRC+"' title='"+this.config.title+"'";
                                listBigPic += " data-popup-gallery='"+this.currentItemId+"_"+this.obName+"'";
                                listBigPic += " data-small-src = '"+images[i].SMALL.SRC+"'";
                                listBigPic += " data-big-src = '"+images[i].BIG.SRC+"'";
                                listBigPic += " data-desc ='"+images[i].DESC+"'";
                                listBigPic += " alt ='"+images[i].DESC+"'";
                            listBigPic += ">";


                        listBigPic += "</a>";

                        listBigPic += "</div>";

                    }

                    if(images.length > 3)
                    {
                        countMoreImages = images.length - 3;
                        listControl += "<div class='more open-popup-gallery' data-popup-gallery='"+this.currentItemId+"_"+this.obName+"'><a>"+BX.message('MORE_PHOTOS')+' '+(images.length - 3)+"</a></div>";
                    }
                }

            }

            else
            {
                listBigPic += "<div";
                    listBigPic += "class='big-picture active'>";


                    listBigPic += "<img src='"+this.no_photo_src+"' title='"+this.config.title+"'>";



                listBigPic += "</div>";
            }




            if(countImages || nodeControlPicsParent.hasClass('video'))
            {
                nodeBigPics.html(listBigPic);
                nodeControlPics.html(listControl);

                nodeControlPicsParent.show();

                nodeControlPicsParent.addClass('col-2');
                nodeBigPicsParent.removeClass('col-12');
                nodeBigPicsParent.addClass('col-10');   

                if(countImages == 1)
                {
                    nodeControlPics.addClass('one-photo');
                    nodeControlPicsParent.addClass('col-2');
                    nodeBigPicsParent.addClass('col-12');
                    nodeBigPicsParent.removeClass('col-10');
                }

                
            }
            else
            {
                nodeControlPicsParent.hide();
                nodeBigPicsParent.removeClass('col-10');
                nodeBigPicsParent.addClass('col-12');
            }




            var previewText = this.getEntity(this.obPreviewText, 'preview-text');


            if(this.offers[this.offerNum].PREVIEW_TEXT)
                BX.adjust(previewText, {html: this.offers[this.offerNum].PREVIEW_TEXT, style: {display: ''}});
            
            else
            {
                BX.adjust(previewText, {html: "", style: {display: 'none'}});
            }
        }

    };



    window.JCCatalogItem = function (arParams)
    {
        
        this.productType = 0;
        this.showQuantity = true;
        this.showAbsent = true;
        this.viewBlock = "FLAT";
        
        this.showOldPrice = true;
        this.showPercent = false;
        this.useCompare = false;
        this.useDelay = false;
        this.firstLoad = true;

        this.visual = {
            ID: '',
            PICT_ID: '',
            QUANTITY_ID: '',
            QUANTITY_UP_ID: '',
            QUANTITY_DOWN_ID: '',
            PRICE_ID: '',
            PRICE_OLD_ID: '',
            DSC_PERC: '',
            PRICE_MATRIX: '',
        };
        this.product = {
            checkQuantity: false,
            maxQuantity: 0,
            stepQuantity: 1,
            isDblQuantity: false,
            canBuy: true,
            name: '',
            pict: {},
            id: 0,
        };
        this.no_photo_src = null;

        this.showAbsent = true;



        this.checkQuantity = false;
        this.maxQuantity = 0;
        this.minQuantity = 0;
        this.stepQuantity = 1;
        this.isDblQuantity = false;
        this.canBuy = true;
        this.precision = 6;
        this.precisionFactor = Math.pow(10, this.precision);

        this.currentPriceMode = '';
        this.currentPrices = [];
        this.currentPriceSelected = 0;
        this.currentQuantityRanges = [];
        this.currentQuantityRangeSelected = 0;

        this.offers = [];
        this.offerNum = 0;
        this.treeProps = [];
        this.selectedValues = {};

        this.obProduct = null;
        this.blockNodes = {};
        this.obQuantity = null;
        this.obQuantityUp = null;
        this.obQuantityDown = null;
        this.obPict = null;
        this.obDetailUrl = null;
        this.obSkuChars = null;
        this.obShortDescription = null;
        this.obPreviewText = null;
        this.obPriceMatrix = null;

        this.obPrice = null;
        this.obTree = null;

        this.currentItemId = 0;


        this.obMeasure = null;


        this.isTouchDevice = BX.hasClass(document.documentElement, 'bx-touch');

        this.storeQuantityOn = null;
        this.viewStoreQuantity = null;

        this.obArticle = null;
        this.obAvailable = null;

        this.basketMode = '';
        this.obBasketActions = null;
        this.obMove2Basket = null;
        this.obAdd2BasketBtn = null;

        this.obDscPerc = null;
        
        

        this.obDelay = null;
        this.obCompare = null;


        this.compareUrl = '';
        this.compareUrlAdd = '';
        this.compareUrlDelete = '';


        this.errorCode = 0;

        if (typeof arParams === 'object')
        {
            if (arParams.PRODUCT_TYPE)
            {
                this.productType = parseInt(arParams.PRODUCT_TYPE, 10);
            }

            this.showQuantity = arParams.SHOW_QUANTITY;
            this.showAbsent = arParams.SHOW_ABSENT;
            this.showPercent = arParams.SHOW_DISCOUNT_PERCENT;



            this.visual = arParams.VISUAL;



            switch (this.productType)
            {
                case 0: 
                case 1: 
                case 2: 

                    if (arParams.PRODUCT && typeof arParams.PRODUCT === 'object')
                    {
                        this.currentPriceMode = arParams.PRODUCT.ITEM_PRICE_MODE;
                        this.currentPrices = arParams.PRODUCT.ITEM_PRICES;
                        this.currentPriceSelected = arParams.PRODUCT.ITEM_PRICE_SELECTED;
                        this.currentQuantityRanges = arParams.PRODUCT.ITEM_QUANTITY_RANGES;
                        this.currentQuantityRangeSelected = arParams.PRODUCT.ITEM_QUANTITY_RANGE_SELECTED;
                        
                        if (this.showQuantity)
                        {
                            this.product.checkQuantity = arParams.PRODUCT.CHECK_QUANTITY;
                            this.product.isDblQuantity = arParams.PRODUCT.QUANTITY_FLOAT;

                            if (this.product.checkQuantity)
                            {
                                this.product.maxQuantity = (this.product.isDblQuantity ? parseFloat(arParams.PRODUCT.MAX_QUANTITY) : parseInt(arParams.PRODUCT.MAX_QUANTITY, 10));
                            }

                            this.product.stepQuantity = (this.product.isDblQuantity ? parseFloat(arParams.PRODUCT.STEP_QUANTITY) : parseInt(arParams.PRODUCT.STEP_QUANTITY, 10));

                            this.checkQuantity = this.product.checkQuantity;

                            this.isDblQuantity = this.product.isDblQuantity;
                            this.stepQuantity = this.product.stepQuantity;
                            this.maxQuantity = this.product.maxQuantity;
                            this.minQuantity = this.currentPriceMode === 'Q'
                                ? parseFloat(this.currentPrices[this.currentPriceSelected].MIN_QUANTITY)
                                : this.stepQuantity;

                            if (this.isDblQuantity)
                            {
                                this.stepQuantity = Math.round(this.stepQuantity * this.precisionFactor) / this.precisionFactor;
                            }
                        }

                        this.product.canBuy = arParams.PRODUCT.CAN_BUY;

                        this.canBuy = this.product.canBuy;

                        this.product.name = arParams.PRODUCT.NAME;
                        this.product.pict = arParams.PRODUCT.PICT;
                        this.currentItemId = this.product.id = arParams.PRODUCT.ID;
                        this.product.detail_page_url = arParams.PRODUCT.DETAIL_PAGE_URL;

                        if (arParams.PRODUCT.ADD_URL)
                        {
                            this.product.addUrl = arParams.PRODUCT.ADD_URL;
                        }

                        if (arParams.PRODUCT.BUY_URL)
                        {
                            this.product.buyUrl = arParams.PRODUCT.BUY_URL;
                        }

                        

                    }

                    else
                    {
                        this.errorCode = -1;
                    }

                    break;

                case 3:


                    if (arParams.PRODUCT && typeof arParams.PRODUCT === 'object')
                    {
                        this.product.name = arParams.PRODUCT.NAME;
                        this.product.id = arParams.PRODUCT.ID;
                        this.product.detail_page_url = arParams.PRODUCT.DETAIL_PAGE_URL;

                        if(arParams.PRODUCT.QUANTITY_FOR_MANY)
                        {
                            if(arParams.PRODUCT.QUANTITY_FOR_MANY_IS_FLOAT)
                            {
                                this.product.quantity_for_many = parseFloat(arParams.PRODUCT.QUANTITY_FOR_MANY);
                            }
                            else
                            {
                                this.product.quantity_for_many = parseInt(arParams.PRODUCT.QUANTITY_FOR_MANY, 10);
                            }
                        }


                        if(arParams.PRODUCT.QUANTITY_FOR_FEW)
                        {

                            if(arParams.PRODUCT.QUANTITY_FOR_FEW_IS_FLOAT)
                            {
                                this.product.quantity_for_few = parseFloat(arParams.PRODUCT.QUANTITY_FOR_FEW);
                            }
                            else
                            {
                                this.product.quantity_for_few = parseInt(arParams.PRODUCT.QUANTITY_FOR_FEW, 10);
                            }
                        }
                    }

                    this.no_photo_src = arParams.NO_PHOTO_SRC;

                    if (arParams.OFFERS && BX.type.isArray(arParams.OFFERS))
                    {

                        if(arParams.STORE_QUANTITY_ON == "Y")
                            this.storeQuantityOn = arParams.STORE_QUANTITY_ON;


                        
                        this.viewStoreQuantity = arParams.VIEW_STORE_QUANTITY;



                        this.offers = arParams.OFFERS;
                        this.offerNum = 0;



                        if (arParams.OFFER_SELECTED)
                        {
                            this.offerNum = parseInt(arParams.OFFER_SELECTED, 10);

                        }

                        if (isNaN(this.offerNum))
                        {
                            this.offerNum = 0;
                        }

                        if (arParams.TREE_PROPS)
                        {
                            this.treeProps = arParams.TREE_PROPS;
                        }

                            
                    }

                    break;
                default:
                    this.errorCode = -1;
                    
            }

            if (parseInt(arParams.ADD2BASKET_SHOW))
                this.add2BasketShow = parseInt(arParams.ADD2BASKET_SHOW);


            this.useDelay = arParams.USE_DELAY == "Y" ? true : false;
            this.useCompare = arParams.USE_COMPARE == "Y" ? true : false;

            if(arParams.VIEW_BLOCK)
                this.viewBlock = arParams.VIEW_BLOCK;

            if(this.useCompare)
            {
                this.compareUrl = arParams.COMPARE_URL;

                if(this.compareUrl)
                {
                    this.compareUrlAdd = this.compareUrl+'?action=ADD_TO_COMPARE_LIST&id=#ID#';
                    this.compareUrlDelete = this.compareUrl+'?action=DELETE_FROM_COMPARE_LIST&id=#ID#';
                }
            }
        }

        if (this.errorCode === 0)
        {
            BX.ready(BX.delegate(this.init,this));
        }
    };

    window.JCCatalogItem.prototype = {
        init: function()
        {

            var i = 0,
                treeItems = null;

            this.obProduct = BX(this.visual.ID);




            if (!this.obProduct)
            {
                this.errorCode = -1;
            }

            this.obPrice = BX(this.visual.PRICE_ID);
            this.obPriceOld = BX(this.visual.PRICE_OLD_ID);

            if (!this.obPrice)
            {
                this.errorCode = -16;
            }

            if (this.showQuantity && this.visual.QUANTITY_ID)
            {

                this.obQuantity = BX(this.visual.QUANTITY_ID);

                
                this.blockNodes.quantity = this.obProduct.querySelector('[data-entity="quantity-block"]');


                if (this.visual.QUANTITY_UP_ID)
                {
                    this.obQuantityUp = BX(this.visual.QUANTITY_UP_ID);

                }

                if (this.visual.QUANTITY_DOWN_ID)
                {
                    this.obQuantityDown = BX(this.visual.QUANTITY_DOWN_ID);
                }



            }
            if (this.productType === 3)
            {

                if (this.visual.SKU_TREE)
                {
                    this.obTree = BX(this.visual.SKU_TREE);
                    if (!this.obTree)
                    {
                        this.errorCode = -256;
                    }
                }


                if (this.visual.QUANTITY_MEASURE)
                {
                    this.obMeasure = BX(this.visual.QUANTITY_MEASURE);
                }

                if (this.visual.PRICE_MATRIX)
                {
                    this.obPriceMatrix = BX(this.visual.PRICE_MATRIX);
                }

            }


            
            if (this.showPercent)
            {
                if (this.visual.DSC_PERC)
                {
                    this.obDscPerc = BX(this.visual.DSC_PERC);
                }
            }

            if (this.errorCode === 0)
            {


                if (this.showQuantity)
                {
                    var startEventName = this.isTouchDevice ? 'touchstart' : 'mousedown';
                    var endEventName = this.isTouchDevice ? 'touchend' : 'mouseup';

                    if (this.obQuantityUp)
                    {
                        BX.bind(this.obQuantityUp, startEventName, BX.proxy(this.startQuantityInterval, this));
                        BX.bind(this.obQuantityUp, endEventName, BX.proxy(this.clearQuantityInterval, this));
                        BX.bind(this.obQuantityUp, 'mouseout', BX.proxy(this.clearQuantityInterval, this));
                        BX.bind(this.obQuantityUp, 'click', BX.delegate(this.quantityUp, this));

                    }


                    if (this.obQuantityDown)
                    {
                        BX.bind(this.obQuantityDown, startEventName, BX.proxy(this.startQuantityInterval, this));
                        BX.bind(this.obQuantityDown, endEventName, BX.proxy(this.clearQuantityInterval, this));
                        BX.bind(this.obQuantityDown, 'mouseout', BX.proxy(this.clearQuantityInterval, this));
                        BX.bind(this.obQuantityDown, 'click', BX.delegate(this.quantityDown, this));
                    }

                    if (this.obQuantity)
                    {
                        BX.bind(this.obQuantity, 'change', BX.delegate(this.quantityChange, this));
                    }
                }



                if (this.visual.PICT_ID)
                    this.obPict = BX(this.visual.PICT_ID);

                switch (this.productType)
                {
                    case 0:
                    case 1:
                    case 2:

                        this.checkQuantityControls();
                        break;

                    case 3:

                        if (this.visual.SKU_CHARS)
                            this.obSkuChars = BX(this.visual.SKU_CHARS);
                        

                        if (this.visual.DETAIL_URL_IMG)
                            this.obDetailUrlImg = BX(this.visual.DETAIL_URL_IMG);
                        

                        if (this.visual.SHORT_DESCRIPTION)
                            this.obShortDescription = BX(this.visual.SHORT_DESCRIPTION);
                        

                        if (this.visual.PREVIEW_TEXT)
                            this.obPreviewText = BX(this.visual.PREVIEW_TEXT);
                        
                    

                        if (this.visual.ARTICLE)
                            this.obArticle = BX(this.visual.ARTICLE);
                        

                        if (this.visual.AVAILABLE)
                            this.obAvailable = BX(this.visual.AVAILABLE);
                        

                        if (this.offers.length > 0)
                        {
                            treeItems = BX.findChildren(this.obTree, {tagName: 'li'}, true);

                            if (treeItems && treeItems.length)
                            {
                                for (i = 0; i < treeItems.length; i++)
                                {
                                    BX.bind(treeItems[i], 'click', BX.delegate(this.selectOfferProp, this));
                                }
                            }

                            this.setCurrent();
                        }

                        break;
                }


                if (this.add2BasketShow)
                {
                    this.obBasketActions = BX(this.visual.BASKET_ACTIONS);
                    if (this.obBasketActions)
                    {
                        this.obAdd2BasketBtn = BX(this.visual.ADD2BASKET);
                        this.obMove2Basket = BX(this.visual.MOVE2BASKET);
                        this.obAdd2BasketBtn && BX.bind(this.obAdd2BasketBtn, 'click', BX.proxy(this.add2Basket, this));
                    }
                }

                if(this.useDelay)
                {
                    this.obDelay = BX(this.visual.DELAY);
                    this.obDelay && BX.bind(this.obDelay, 'click', BX.proxy(this.add2Delay, this));
                }

                if(this.useCompare)
                {
                    this.obCompare = BX(this.visual.COMPARE);
                    this.obCompare && BX.bind(this.obCompare, 'click', BX.proxy(this.add2Compare, this));
                }

            }


        },

        add2Delay: function()
        {
            
            var productID = '',
                value = 1;

            if(this.obQuantity)
                value = this.obQuantity.value;


            switch (this.productType)
            {
                case 1:
                case 2: 
                    productID = this.product.id.toString();
                    break;
                case 3:
                    productID = this.offers[this.offerNum].ID;
                    break;

                default:
                    break;
            }



            BX.ajax({
                method: 'POST',
                dataType: 'json',
                url: '/bitrix/tools/concept.phoenix/ajax/basket/wishlist.php',
                data: {
                    product_id: productID,
                    price_id: this.currentPrices[this.currentPriceSelected].ID,
                    price: this.currentPrices[this.currentPriceSelected].PRICE,
                    name: this.product.name,
                    detail_page: this.product.detail_page_url,
                    can_buy: this.canBuy,
                    quantity: value,
                    currency: this.currentPrices[this.currentPriceSelected].CURRENCY,
                    site_id: $("input.site_id").val()
                },
                onsuccess: BX.proxy(this.delayResult, this)
            });
        },

        delayResult: function(arResult)
        {
            if(arResult["OK"]=="Y")
            {
                if(this.productType == 3)
                {
                    if(arResult["ACTION"] == 'active')
                        this.offers[this.offerNum].IN_DELAY = true;
                    
                    if(arResult["ACTION"] == 'delete')
                        this.offers[this.offerNum].IN_DELAY = false;
                }

            
                markProductDelayBasket(this.currentItemId, arResult["ACTION"]);             
            }
            else
                console.log(arResult["OK"]);
        },

        add2Compare: function()
        {

            var checked = false;


            switch (this.productType)
            {
                case 1:
                case 2: 
                    productID = this.product.id.toString();
                    break;
                case 3:
                    productID = this.offers[this.offerNum].ID;
                    break;
                default:
                    break;
            }

            if(!BX.hasClass(this.obCompare, "active"))
                checked = true;


            var url = checked ? this.compareUrlAdd : this.compareUrlDelete, compareLink;
                
            if(url)
            {

                switch (this.productType)
                {
                    case 0:
                    case 1:
                    case 2:
                        compareLink = url.replace('#ID#', this.product.id.toString());
                        break;
                    case 3:
                        compareLink = url.replace('#ID#', this.offers[this.offerNum].ID);
                        break;
                }



                BX.ajax({
                    method: 'POST',
                    dataType: checked ? 'json' : 'html',
                    url: compareLink + (compareLink.indexOf('?') !== -1 ? '&' : '?') + 'ajax_action=Y',
                    onsuccess: checked
                        ? BX.proxy(this.compareResult, this)
                        : BX.proxy(this.compareDeleteResult, this)
                });


            }

        },

        compareResult: function(arResult)
        {

           /*

            if (!BX.type.isPlainObject(arResult))
                return;

            if (arResult.STATUS === 'OK')
            {*/
                if (this.offers.length > 0)
                    this.offers[this.offerNum].IN_COMPARE = true;
                

                markProductCompareBasket(this.currentItemId, 'active'); 
            /*}*/
        },

        compareDeleteResult: function(arResult)
        {

            if (this.offers.length > 0)
                this.offers[this.offerNum].IN_COMPARE = false;
            

            markProductCompareBasket(this.currentItemId, 'delete'); 

        },
        add2Basket: function()
        {
            if (!this.canBuy)
                return;

            var productID = '',
                value = 1;

            if(this.obQuantity)
                value = this.obQuantity.value;

            switch (this.productType)
            {
                case 1:
                case 2: 
                    productID = this.product.id.toString();
                    break;
                case 3:
                    productID = this.offers[this.offerNum].ID;
                    break;

                default:
                    break;
            }

            productItem = {
                PRODUCT_ID: productID,
                QUANTITY: value,
                PRICE_ID: this.currentPrices[this.currentPriceSelected].ID
            };
            
            $(this.obAdd2BasketBtn).addClass('btn-processing');


            BX.ajax({
                method: 'POST',
                dataType: 'json',
                url: '/bitrix/tools/concept.phoenix/ajax/basket/add2basket.php',
                data: {
                    productItem: productItem,
                    site_id: $("input.site_id").val()
                },
                onsuccess: BX.proxy(this.basketResult, this)
            });
            
            
        },

        basketResult: function(arResult)
        {


            /*if (!BX.type.isPlainObject(arResult))
                return;*/

            if(arResult["OK"]=="Y")
            {
                if(this.productType === 3)
                    this.offers[this.offerNum].IN_BASKET = true;


                if($(".open-cart").length>0)
                {

                    if($(".open-cart").hasClass('semi_show no-empty') || $(".open-cart").hasClass('show'))
                    {

                        $(this.obPict).clone().css({
                            'width': 70 + 'px',
                            'height': 70 + 'px',
                            'position': 'absolute',
                            'z-index': '9999',
                            'borderRadius': 50 + '%',
                            top: $(this.obPict).offset().top + $(this.obPict).width() / 2,
                            left: $(this.obPict).offset().left + $(this.obPict).height() / 2
                        }).appendTo("body").animate({
                            opacity: 0.05,
                            left: $(".open-cart").offset().left,
                            top: $(".open-cart").offset().top,
                            width: 20,
                            height: 20
                        }, 700, function(){
                            $(this).remove();
                        });
                    }
                }

                if(arResult["SCRIPTS"])
                    $('body').append(arResult["SCRIPTS"]);

                markProductAddBasket(this.currentItemId);
            }
            
            $(this.obAdd2BasketBtn).removeClass('btn-processing');
        },


        getEntity: function(parent, entity, additionalFilter)
        {
            if (!parent || !entity)
                return null;

            additionalFilter = additionalFilter || '';

            return parent.querySelector(additionalFilter + '[data-entity="' + entity + '"]');
        },

        startQuantityInterval: function()
        {
            var target = BX.proxy_context;
            var func = target.id === this.visual.QUANTITY_DOWN_ID
                ? BX.proxy(this.quantityDown, this)
                : BX.proxy(this.quantityUp, this);

            this.quantityDelay = setTimeout(
                BX.delegate(function() {
                    this.quantityTimer = setInterval(func, 150);
                }, this),
                300
            );
        },

        clearQuantityInterval: function()
        {
            clearTimeout(this.quantityDelay);
            clearInterval(this.quantityTimer);
        },

        quantityUp: function()
        {

            var curValue = 0,
                boolSet = true;



            if (this.errorCode === 0 && this.showQuantity && this.canBuy)
            {
                curValue = (this.isDblQuantity ? parseFloat(this.obQuantity.value) : parseInt(this.obQuantity.value, 10));
                
                if (!isNaN(curValue))
                {
                    curValue += this.stepQuantity;
                    if (this.checkQuantity)
                    {
                        if (curValue > this.maxQuantity)
                        {
                            boolSet = false;
                        }
                    }

                    if (boolSet)
                    {
                        if (this.isDblQuantity)
                        {
                            curValue = Math.round(curValue * this.precisionFactor) / this.precisionFactor;
                        }

                        this.obQuantity.value = curValue;

                        this.setPrice();
                    }
                }
            }
        },

        quantityDown: function()
        {
            var curValue = 0,
                boolSet = true;



            if (this.errorCode === 0 && this.showQuantity && this.canBuy)
            {
                curValue = (this.isDblQuantity ? parseFloat(this.obQuantity.value) : parseInt(this.obQuantity.value, 10));
                if (!isNaN(curValue))
                {
                    curValue -= this.stepQuantity;

                    this.checkPriceRange(curValue);

                    if (curValue < this.minQuantity)
                    {
                        boolSet = false;
                    }

                    if (boolSet)
                    {
                        if (this.isDblQuantity)
                        {
                            curValue = Math.round(curValue * this.precisionFactor) / this.precisionFactor;
                        }

                        this.obQuantity.value = curValue;

                        this.setPrice();
                    }
                }
            }
        },

        quantityChange: function()
        {
            var curValue = 0,
                intCount;

            if (this.errorCode === 0 && this.showQuantity)
            {
                if (this.canBuy)
                {

                    curValue = this.isDblQuantity ? parseFloat(this.obQuantity.value) : Math.round(this.obQuantity.value);
                    if (!isNaN(curValue))
                    {
                        if (this.checkQuantity)
                        {
                            if (curValue > this.maxQuantity)
                            {
                                curValue = this.maxQuantity;
                            }
                        }

                        this.checkPriceRange(curValue);

                        if (curValue < this.minQuantity)
                        {
                            curValue = this.minQuantity;
                        }
                        else
                        {
                            intCount = Math.round(
                                    Math.round(curValue * this.precisionFactor / this.stepQuantity) / this.precisionFactor
                                ) || 1;
                            curValue = (intCount <= 1 ? this.stepQuantity : intCount * this.stepQuantity);
                            curValue = Math.round(curValue * this.precisionFactor) / this.precisionFactor;
                        }

                        this.obQuantity.value = curValue;
                    }
                    else
                    {
                        this.obQuantity.value = this.minQuantity;
                    }
                }
                else
                {
                    this.obQuantity.value = this.minQuantity;
                }

                this.setPrice();
            }
        },

        quantitySet: function(index)
        {
            

            var resetQuantity, strLimit;
            
            var newOffer = this.offers[index],
                oldOffer = this.offers[this.offerNum];



            if (this.errorCode === 0)
            {
                this.canBuy = newOffer.CAN_BUY;

                this.currentPriceMode = newOffer.ITEM_PRICE_MODE;
                this.currentPrices = newOffer.ITEM_PRICES;
                this.currentPriceSelected = newOffer.ITEM_PRICE_SELECTED;
                this.currentQuantityRanges = newOffer.ITEM_QUANTITY_RANGES;
                this.currentQuantityRangeSelected = newOffer.ITEM_QUANTITY_RANGE_SELECTED;


                if (this.canBuy)
                {
                    if (this.blockNodes.quantity)
                    {
                        BX.style(this.blockNodes.quantity, 'display', '');
                    }

                }
                else
                {
                    if (this.blockNodes.quantity)
                    {
                        BX.style(this.blockNodes.quantity, 'display', 'none');
                    }
                }

                this.isDblQuantity = newOffer.QUANTITY_FLOAT;
                this.checkQuantity = newOffer.CHECK_QUANTITY;


                if (this.isDblQuantity)
                {
                    this.stepQuantity = Math.round(parseFloat(newOffer.STEP_QUANTITY) * this.precisionFactor) / this.precisionFactor;
                    this.maxQuantity = parseFloat(newOffer.MAX_QUANTITY);
                    this.minQuantity = this.currentPriceMode === 'Q' ? parseFloat(this.currentPrices[this.currentPriceSelected].MIN_QUANTITY) : this.stepQuantity;
                }
                else
                {
                    this.stepQuantity = parseInt(newOffer.STEP_QUANTITY, 10);
                    this.maxQuantity = parseInt(newOffer.MAX_QUANTITY, 10);
                    this.minQuantity = this.currentPriceMode === 'Q' ? parseInt(this.currentPrices[this.currentPriceSelected].MIN_QUANTITY) : this.stepQuantity;
                }



                if (this.showQuantity)
                {
                    var isDifferentMinQuantity = oldOffer.ITEM_PRICES.length
                        && oldOffer.ITEM_PRICES[oldOffer.ITEM_PRICE_SELECTED]
                        && oldOffer.ITEM_PRICES[oldOffer.ITEM_PRICE_SELECTED].MIN_QUANTITY != this.minQuantity;





                    if (this.isDblQuantity)
                    {
                        resetQuantity = Math.round(parseFloat(oldOffer.STEP_QUANTITY) * this.precisionFactor) / this.precisionFactor !== this.stepQuantity
                            || isDifferentMinQuantity
                            || oldOffer.MEASURE !== newOffer.MEASURE
                            || (
                                this.checkQuantity
                                && parseFloat(oldOffer.MAX_QUANTITY) > this.maxQuantity
                                && parseFloat(this.obQuantity.value) > this.maxQuantity
                            );

                    }
                    else
                    {
                        resetQuantity = 
                            parseInt(oldOffer.STEP_QUANTITY, 10) !== this.stepQuantity
                            || isDifferentMinQuantity
                            || oldOffer.MEASURE !== newOffer.MEASURE
                            || (
                                this.checkQuantity
                                && parseInt(oldOffer.MAX_QUANTITY, 10) > this.maxQuantity
                                && parseInt(this.obQuantity.value, 10) > this.maxQuantity
                            );
                    }


                    this.obQuantity.disabled = !this.canBuy;

                    if (resetQuantity)
                    {
                        this.obQuantity.value = this.minQuantity;
                    }


                    
                }

                if (this.obMeasure)
                {
                    
                    if (newOffer.MEASURE_PRICE)
                    {
                        BX.adjust(this.obMeasure, {html: newOffer.MEASURE_PRICE, style: {display: ''}});
                    }
                    else
                    {
                        BX.adjust(this.obMeasure, {html: '', style: {display: 'none'}});
                    }
                }

            }
        },

        showArticleStoreQuantity: function()
        {
            var showArticle = false,
                showQuantity = false,
                html = "";


            if(this.viewBlock == "FLAT")
            {
                
                if(this.offers[this.offerNum].QUANTITY_HTML.length>0)
                {
                    html+=this.offers[this.offerNum].QUANTITY_HTML;
                    showQuantity = true;
                }

                if(this.offers[this.offerNum].ARTICLE)
                {
                    html += "<div class=\"detail-article italic\">" + BX.message("ARTICLE") + this.offers[this.offerNum].ARTICLE+"</div>";
                    showArticle = true;
                }

                
            }
            else if(this.viewBlock == "LIST")
            {

                if(this.offers[this.offerNum].ARTICLE)
                {
                    html += "<div class=\"detail-article italic\">" + BX.message("ARTICLE") + this.offers[this.offerNum].ARTICLE+"</div>";
                    showArticle = true;
                }

                if(this.offers[this.offerNum].QUANTITY_HTML.length>0)
                {
                    html+=this.offers[this.offerNum].QUANTITY_HTML;
                    showQuantity = true;
                }

            }

            if(showArticle || showQuantity)
            {
                $("#"+this.visual.ID+" .wrapper-article-available").html(html);
                
            }
            else
            {
                $("#"+this.visual.ID+" .wrapper-article-available").html("");
            }

            
        },

        eq: function(obj, i)
        {
            var len = obj.length,
                j = +i + (i < 0 ? len : 0);

            return j >= 0 && j < len ? obj[j] : {};
        },

        selectOfferProp: function()
        {
            var i = 0,
                value = '',
                strTreeValue = '',
                arTreeItem = [],
                rowItems = null,
                target = BX.proxy_context;

            if (target && target.hasAttribute('data-treevalue'))
            {
                if (BX.hasClass(target, 'active'))
                    return;

                strTreeValue = target.getAttribute('data-treevalue');
                arTreeItem = strTreeValue.split('_');
                if (this.searchOfferPropIndex(arTreeItem[0], arTreeItem[1]))
                {
                    rowItems = BX.findChildren(target.parentNode, {tagName: 'li'}, false);


                    if (rowItems && 0 < rowItems.length)
                    {
                        for (i = 0; i < rowItems.length; i++)
                        {
                            value = rowItems[i].getAttribute('data-onevalue');
                            if (value === arTreeItem[1])
                            {
                                BX.addClass(rowItems[i], 'active');
                            }
                            else
                            {
                                BX.removeClass(rowItems[i], 'active');
                            }
                        }
                    }
                }
            }
        },

        searchOfferPropIndex: function(strPropID, strPropValue)
        {
            var strName = '',
                arShowValues = false,
                i, j,
                arCanBuyValues = [],
                allValues = [],
                index = -1,
                arFilter = {},
                tmpFilter = [];



            for (i = 0; i < this.treeProps.length; i++)
            {
                if (this.treeProps[i].ID === strPropID)
                {
                    index = i;
                    break;
                }
            }
            

            if (-1 < index)
            {
                for (i = 0; i < index; i++)
                {
                    strName = 'PROP_'+this.treeProps[i].ID;
                    arFilter[strName] = this.selectedValues[strName];
                }
                strName = 'PROP_'+this.treeProps[index].ID;
                arShowValues = this.getRowValues(arFilter, strName);


                if (!arShowValues)
                {
                    return false;
                }
                if (!BX.util.in_array(strPropValue, arShowValues))
                {
                    return false;
                }

                arFilter[strName] = strPropValue;


                for (i = index+1; i < this.treeProps.length; i++)
                {
                    strName = 'PROP_'+this.treeProps[i].ID;

                    arShowValues = this.getRowValues(arFilter, strName);

                    if (!arShowValues)
                    {
                        return false;
                    }
                    allValues = [];
                    if (this.showAbsent)
                    {
                        arCanBuyValues = [];
                        tmpFilter = [];
                        tmpFilter = BX.clone(arFilter, true);
                        for (j = 0; j < arShowValues.length; j++)
                        {
                            tmpFilter[strName] = arShowValues[j];
                            allValues[allValues.length] = arShowValues[j];
                            if (this.getCanBuy(tmpFilter))
                                arCanBuyValues[arCanBuyValues.length] = arShowValues[j];
                        }
                    }
                    else
                    {
                        arCanBuyValues = arShowValues;
                    }
                    if (this.selectedValues[strName] && BX.util.in_array(this.selectedValues[strName], arCanBuyValues))
                    {
                        arFilter[strName] = this.selectedValues[strName];
                    }
                    else
                    {
                        if (this.showAbsent)
                            arFilter[strName] = (arCanBuyValues.length > 0 ? arCanBuyValues[0] : allValues[0]);
                        else{
                            arFilter[strName] = arCanBuyValues[0];
                        }
                    }


                    this.updateRow(i, arFilter[strName], arShowValues, arCanBuyValues);
                }
                this.selectedValues = arFilter;

                this.changeInfo();
            }
            return true;
        },

        updateRow: function(intNumber, activeID, showID, canBuyID)
        {
            var i = 0,
                value = '',
                isCurrent = false,
                rowItems = null;


            var lineContainer = this.obTree.querySelectorAll('[data-entity="sku-line-block"]'),
                listContainer;

            

            if (intNumber > -1 && intNumber < lineContainer.length)
            {
                listContainer = lineContainer[intNumber].querySelector('ul');
                rowItems = BX.findChildren(listContainer, {tagName: 'li'}, false);
                if (rowItems && 0 < rowItems.length)
                {
                    for (i = 0; i < rowItems.length; i++)
                    {
                        value = rowItems[i].getAttribute('data-onevalue');
                        isCurrent = value === activeID;


                        if (isCurrent)
                        {
                            BX.addClass(rowItems[i], 'active');
                        }
                        else
                        {
                            BX.removeClass(rowItems[i], 'active');
                        }

                        if (BX.util.in_array(value, canBuyID))
                        {
                            BX.removeClass(rowItems[i], 'notallowed');
                        }
                        else
                        {
                            BX.addClass(rowItems[i], 'notallowed');
                        }

                        rowItems[i].style.display = BX.util.in_array(value, showID) ? '' : 'none';

                        if (isCurrent)
                        {
                            lineContainer[intNumber].style.display = (value == 0 && canBuyID.length == 1) ? 'none' : '';
                        }
                    }
                }
            }
        },

        getRowValues: function(arFilter, index)
        {
            var i = 0,
                j,
                arValues = [],
                boolSearch = false,
                boolOneSearch = true;

            if (0 === arFilter.length)
            {
                for (i = 0; i < this.offers.length; i++)
                {
                    if (!BX.util.in_array(this.offers[i].TREE[index], arValues))
                    {
                        arValues[arValues.length] = this.offers[i].TREE[index];
                    }
                }
                boolSearch = true;
            }
            else
            {
                for (i = 0; i < this.offers.length; i++)
                {
                    boolOneSearch = true;
                    for (j in arFilter)
                    {
                        if (arFilter[j] !== this.offers[i].TREE[j])
                        {
                            boolOneSearch = false;
                            break;
                        }
                    }
                    if (boolOneSearch)
                    {
                        if (!BX.util.in_array(this.offers[i].TREE[index], arValues))
                        {
                            arValues[arValues.length] = this.offers[i].TREE[index];
                        }
                        boolSearch = true;
                    }
                }
            }
            return (boolSearch ? arValues : false);
        },

        getCanBuy: function(arFilter)
        {
            var i, j,
                boolSearch = false,
                boolOneSearch = true;

            for (i = 0; i < this.offers.length; i++)
            {
                boolOneSearch = true;
                for (j in arFilter)
                {
                    if (arFilter[j] !== this.offers[i].TREE[j])
                    {
                        boolOneSearch = false;
                        break;
                    }
                }
                if (boolOneSearch)
                {
                    if (this.offers[i].CAN_BUY)
                    {
                        boolSearch = true;
                        break;
                    }
                }
            }

            return boolSearch;
        },

        setCurrent: function()
        {

            var i,
                j = 0,
                arCanBuyValues = [],
                strName = '',
                arShowValues = false,
                arFilter = {},
                tmpFilter = [],
                current = this.offers[this.offerNum].TREE;



            for (i = 0; i < this.treeProps.length; i++)
            {

                strName = 'PROP_'+this.treeProps[i].ID;
                arShowValues = this.getRowValues(arFilter, strName);
                if (!arShowValues)
                {
                    break;
                }
                if (BX.util.in_array(current[strName], arShowValues))
                {
                    arFilter[strName] = current[strName];
                }
                else
                {
                    arFilter[strName] = arShowValues[0];
                    this.offerNum = 0;
                }

                if (this.showAbsent)
                {
                    arCanBuyValues = [];
                    tmpFilter = [];
                    tmpFilter = BX.clone(arFilter, true);
                    for (j = 0; j < arShowValues.length; j++)
                    {
                        tmpFilter[strName] = arShowValues[j];
                        if (this.getCanBuy(tmpFilter))
                        {
                            arCanBuyValues[arCanBuyValues.length] = arShowValues[j];
                        }
                    }
                }
                else
                {
                    arCanBuyValues = arShowValues;
                }
                this.updateRow(i, arFilter[strName], arShowValues, arCanBuyValues);
            }


            this.selectedValues = arFilter;
            this.changeInfo();
        },

        btnsControl: function()
        {
            
            if(this.offers[this.offerNum].SHOWPREORDERBTN || this.offers[this.offerNum].MODE_ARCHIVE)
            {

                $("#"+this.visual.ID+" .wrapper-inner-bot[data-entity=\"btns-quantity\"]").addClass('d-none');
                $("#"+this.visual.ID+" .wrapper-inner-bot[data-entity=\"link-to-detail-page\"]").addClass('d-lg-block d-none');
            }

            else
            {
                if(this.offers[this.offerNum].CAN_BUY && this.offers[this.offerNum].MODE_DISALLOW_ORDER !="Y")
                {
                    if(this.add2BasketShow)
                        $("#"+this.visual.ID+" .wrapper-inner-bot[data-entity=\"btns-quantity\"]").removeClass('d-none');

                    $("#"+this.visual.ID+" .wrapper-inner-bot[data-entity=\"link-to-detail-page\"]").removeClass('d-lg-block').addClass('d-none');
                }
                else
                {
                    $("#"+this.visual.ID+" .wrapper-inner-bot[data-entity=\"btns-quantity\"]").addClass('d-none');
                    $("#"+this.visual.ID+" .wrapper-inner-bot[data-entity=\"link-to-detail-page\"]").removeClass('d-lg-block d-none');
                }
            }

            if(!this.add2BasketShow)
                $("#"+this.visual.ID+" .wrapper-inner-bot[data-entity=\"link-to-detail-page\"]").addClass('d-lg-block d-none');

        },

        changeInfo: function()
        {

            var i, j,
                index = -1,
                boolOneSearch = true,
                quantityChanged;

            for (i = 0; i < this.offers.length; i++)
            {
                boolOneSearch = true;
                for (j in this.selectedValues)
                {
                    if (this.selectedValues[j] !== this.offers[i].TREE[j])
                    {
                        boolOneSearch = false;
                        break;
                    }
                }
                if (boolOneSearch)
                {
                    index = i;
                    break;
                }
            }

            if (index > -1)
            {
                this.offerNum = index;

                this.currentItemId = this.offers[this.offerNum].ID;
                
                this.quantitySet(index);
                this.setPrice();
                this.setCompared(this.offers[index].COMPARED);

                if(!this.firstLoad)
                {
                    
                    if(this.obShortDescription)
                        this.changeText(this.obShortDescription, this.offers[index].SHORT_DESCRIPTION);

                    if(this.obPreviewText)
                        this.changeText(this.obPreviewText, this.offers[index].PREVIEW_TEXT);
                    
                    this.showArticleStoreQuantity();
                    this.changeDetailUrl(this.offers[index].ID);
                    this.drawPicture(this.offers[index].PREVIEW_PICTURE_SRC, this.offers[index].PREVIEW_PICTURE_DESC);

                    this.btnsControl();
                }
                this.firstLoad = false;
                
                this.updateInfoBasketOffer(this.offers[index].ID, this.visual.ID);
                
                
                this.changeCharsBlock();



                if(this.offers[this.offerNum].USE_PRICE_COUNT && this.obPriceMatrix)
                {
                    this.setPriceMatrix(this.offers[index].PRICE_MATRIX);
                }

                if( this.offers[this.offerNum].IN_BASKET == true
                    || this.offers[this.offerNum].IN_DELAY == true
                    || this.offers[this.offerNum].IN_COMPARE == true
                    )
                {
                    
                    setItemButtonStatus(
                        this.currentItemId, 
                        this.visual.ID, 
                        this.offers[this.offerNum].IN_BASKET,
                        this.offers[this.offerNum].IN_DELAY,
                        this.offers[this.offerNum].IN_COMPARE
                    );

                    /*if(this.offers[this.offerNum].IN_BASKET)
                        setItemButtonStatus(this.currentItemId, this.visual.ID, 'offer_basket_item_added');

                    if(this.offers[this.offerNum].IN_DELAY)
                        setItemButtonStatus(this.currentItemId, this.visual.ID, 'offer_delay_added');

                    if(this.offers[this.offerNum].IN_COMPARE)
                        setItemButtonStatus(this.currentItemId, this.visual.ID, 'offer_compare_added');*/
                    
                }

                else
                {
                    setItemButtonStatus(arStatusBasketPhoenix);
                }

                
                this.updateSmallCartHtml();

            }
        },

        updateSmallCartHtml: function()
        {
            var blockPrice = this.getEntity(this.obProduct, 'block-price');

            var price = this.currentPrices[this.currentPriceSelected];

            if(typeof price == "undefined")
                price = this.offers[this.offerNum].PRICE;


            if(price.PRICE == "-1")
            {
                if(blockPrice)
                    BX.adjust(blockPrice, {style:{display: "none"}});
                
            }
            else
            {
                if(blockPrice)
                    BX.adjust(blockPrice, {style:{display: ""}});
            }


            hidePrice = false;

            if(this.offers[this.offerNum].MODE_ARCHIVE == "Y")
                hidePrice = true;

            if(hidePrice)
                BX.adjust(blockPrice, {style:{display: "none"}}); 
        },

        updateInfoBasketOffer: function(id, parent)
        {
            
            parent = parent || '';

            if(parent.length>0)
                parent = "#"+parent;

            
            $(parent+' .add2basket').attr('data-item', id);
            $(parent+' .move2basket').attr('data-item', id);
            $(parent+' .quantity-block').attr('data-item', id);
            $(parent+' .delay').attr('data-item', id);
            $(parent+' .compare').attr('data-item', id);
        },

        setPriceMatrix: function(sPriceMatrix)
        {

            if(sPriceMatrix.length > 0)
            {
                BX.adjust(this.obPriceMatrix, {style: {display: ''}, html: sPriceMatrix});
            }
            else
            {
                BX.adjust(this.obPriceMatrix, {style: {display: 'none'}, html: ''});
            }
        },

        changeText: function(ob, text)
        {

            if(text.length > 0)
            {
                BX.adjust(ob, {style: {display: ''}, html: text});
            }
            else
            {
                BX.adjust(ob, {style: {display: 'none'}, html: ""});
            }


        },

        getEntities: function(parent, entity, additionalFilter)
        {
            if (!parent || !entity)
                return {length: 0};

            additionalFilter = additionalFilter || '';

            return parent.querySelectorAll(additionalFilter + '[data-entity="' + entity + '"]');
        },

        changeCharsBlock: function()
        {

            var html = "";


            if(this.obSkuChars)
            {
                if(this.offers[this.offerNum].SKU_LIST_CHARS.length)
                {
                    if(this.viewBlock == "LIST")
                    {
                        for (i = 0; i < this.offers[this.offerNum].SKU_LIST_CHARS.length; i++)
                        {
                            html += "<div class='characteristics-item'>";
                                html += "<span class='characteristics-item-name'>"+this.offers[this.offerNum].SKU_LIST_CHARS[i].NAME+"&nbsp;—&nbsp;</span>";
                                html += "<span class='characteristics-item-value'>"+this.offers[this.offerNum].SKU_LIST_CHARS[i].VALUE+"</span>";
                            html += "</div>";
                        }
                    }
                    else
                    {
                        for (i = 0; i < this.offers[this.offerNum].SKU_LIST_CHARS.length; i++)
                        {
                            html += "<div class='characteristics-item'>";
                                html += "<span class='characteristics-item-name bold'>"+this.offers[this.offerNum].SKU_LIST_CHARS[i].NAME+":&nbsp;</span>";
                                html += "<span class='characteristics-item-value'>"+this.offers[this.offerNum].SKU_LIST_CHARS[i].VALUE+"</span>";
                            html += "</div>";
                        }
                    }
                    

                    html = "<div class='characteristics'>"+html+"</div>";
                }

                BX.adjust(this.obSkuChars, {
                    html: html
                });
            }

            

            if(html.length<=0 && $(this.obSkuChars).parents(".wrapper-characteristics").find(".characteristics").length<=0)
                $(this.obSkuChars).parents(".wrapper-characteristics").hide();
            
            else
            {
                $(this.obSkuChars).parents(".wrapper-characteristics").show();
            }
            

        },

        changeDetailUrl: function(ID)
        {

            if(this.obDetailUrlImg)
            {
                BX.adjust(this.obDetailUrlImg, {

                    props: {
                        href: this.product.detail_page_url + '?oID=' + ID,
                    },

                });

                $(this.obDetailUrlImg).parents(".item").find(".name-element").attr("href", this.product.detail_page_url + '?oID=' + ID);
            }

            
        },

        drawPicture: function(image_src, alt)
        {
            var src = this.no_photo_src;

            if(image_src.length > 0)
                src = image_src;

            if(this.obPict)
            {
               BX.adjust(this.obPict, {

                    props: {
                        src: src,
                        alt: alt
                    },

                }); 
            }

            
        },

        checkPriceRange: function(quantity)
        {
            if (typeof quantity === 'undefined'|| this.currentPriceMode != 'Q')
                return;

            var range, found = false;

            for (var i in this.currentQuantityRanges)
            {
                if (this.currentQuantityRanges.hasOwnProperty(i))
                {
                    range = this.currentQuantityRanges[i];

                    if (
                        parseInt(quantity) >= parseInt(range.SORT_FROM)
                        && (
                            range.SORT_TO == 'INF'
                            || parseInt(quantity) <= parseInt(range.SORT_TO)
                        )
                    )
                    {
                        found = true;
                        this.currentQuantityRangeSelected = range.HASH;
                        break;
                    }
                }
            }

            if (!found && (range = this.getMinPriceRange()))
            {
                this.currentQuantityRangeSelected = range.HASH;
            }

            for (var k in this.currentPrices)
            {
                if (this.currentPrices.hasOwnProperty(k))
                {
                    if (this.currentPrices[k].QUANTITY_HASH == this.currentQuantityRangeSelected)
                    {
                        this.currentPriceSelected = k;
                        break;
                    }
                }
            }
        },

        getMinPriceRange: function()
        {
            var range;

            for (var i in this.currentQuantityRanges)
            {
                if (this.currentQuantityRanges.hasOwnProperty(i))
                {
                    if (
                        !range
                        || parseInt(this.currentQuantityRanges[i].SORT_FROM) < parseInt(range.SORT_FROM)
                    )
                    {
                        range = this.currentQuantityRanges[i];
                    }
                }
            }

            return range;
        },

        checkQuantityControls: function()
        {
            if (!this.obQuantity)
                return;

            var reachedTopLimit = this.checkQuantity && parseFloat(this.obQuantity.value) + this.stepQuantity > this.maxQuantity,
                reachedBottomLimit = parseFloat(this.obQuantity.value) - this.stepQuantity < this.minQuantity;



            if (reachedTopLimit)
            {
                BX.addClass(this.obQuantityUp, 'btn-disabled');
            }
            else if (BX.hasClass(this.obQuantityUp, 'btn-disabled'))
            {
                BX.removeClass(this.obQuantityUp, 'btn-disabled');
            }

            if (reachedBottomLimit)
            {
                BX.addClass(this.obQuantityDown, 'btn-disabled');
            }
            else if (BX.hasClass(this.obQuantityDown, 'btn-disabled'))
            {
                BX.removeClass(this.obQuantityDown, 'btn-disabled');
            }

            if (reachedTopLimit && reachedBottomLimit)
            {
                this.obQuantity.setAttribute('disabled', 'disabled');
            }
            else
            {
                this.obQuantity.removeAttribute('disabled');
            }


        },

        setPrice: function()
        {
            var obData, price;

            if (this.obQuantity)
            {
                this.checkPriceRange(this.obQuantity.value);
            }

            this.checkQuantityControls();

            price = this.currentPrices[this.currentPriceSelected];

            if(typeof price == "undefined")
                price = this.offers[this.offerNum].PRICE;



            if (this.obPrice)
            {

                if (price.PRICE == "-1")
                {
                    BX.adjust(this.obPrice, {html: ''});
                }
                else
                {
                    BX.adjust(this.obPrice, {html: BX.Currency.currencyFormat(price.PRICE, price.CURRENCY, true)});
                }


                if (this.showOldPrice && this.obPriceOld)
                {
                    if (price && price.PRICE !== price.BASE_PRICE)
                    {
                        BX.adjust(this.obPriceOld, {
                            style: {display: ''},
                            html: BX.Currency.currencyFormat(price.BASE_PRICE, price.CURRENCY, true)
                        });
                    }
                    else
                    {
                        BX.adjust(this.obPriceOld, {
                            style: {display: 'none'},
                            html: ''
                        });
                    }
                }

                if (this.obPriceTotal)
                {
                    if (price && this.obQuantity && this.obQuantity.value != this.stepQuantity)
                    {
                        BX.adjust(this.obPriceTotal, {
                            html: BX.message('PRICE_TOTAL_PREFIX') + ' <strong>'
                            + BX.Currency.currencyFormat(price.PRICE * this.obQuantity.value, price.CURRENCY, true)
                            + '</strong>',
                            style: {display: ''}
                        });
                    }
                    else
                    {
                        BX.adjust(this.obPriceTotal, {
                            html: '',
                            style: {display: 'none'}
                        });
                    }
                }

                if (this.showPercent)
                {


                    if (price && parseInt(price.DISCOUNT) > 0)
                    {
                        obData = {style: {display: ''}, html: -price.PERCENT + '%'};
                    }
                    else
                    {
                        obData = {style: {display: 'none'}, html: ''};
                    }



                    if (this.obDscPerc)
                    {
                        BX.adjust(this.obDscPerc, obData);
                    }

                }
            }

        },

        setCompared: function(state)
        {
            if (!this.obCompare)
                return;

            var checkbox = this.obCompare.querySelector('[data-entity="compare-checkbox"]');
            if (checkbox)
            {
                checkbox.checked = state;
            }
        },
    };
    

})(window);


$(document).on('click', '.small-picture', function()
{
    $(this).parents(".wrapper-picture").find(".big-picture").removeClass('active');
    $(this).parents(".wrapper-picture").find(".small-picture").removeClass('active');

    $(this).addClass('active');
    $(this).parents(".wrapper-picture").find(".big-picture[data-id='"+$(this).attr("data-value")+"']").addClass('active');

    if($(this).hasClass('popup-control'))
    {
        $('#sliderPopup').attr('data-current-image', $(this).attr("data-value"));
    }
});

var popupGalleryCollection = [];

function popupGallery(id)
{

    if(typeof($(".open-popup-gallery-item[data-popup-gallery='"+id+"']")) != "undefined")
    {

        if($(".open-popup-gallery-item[data-popup-gallery='"+id+"']").length>0)
        {
        
            $(".open-popup-gallery-item[data-popup-gallery='"+id+"']").each(
                function(index)
                {
                    popupGalleryCollection[index] = 
                    {
                        "smallSrc": $(this).attr("data-small-src"),
                        "bigSrc": $(this).attr("data-big-src"),
                        "desc": $(this).attr("data-desc"),
                    };

                    if($(this).parents(".big-picture").hasClass('active'))
                        popupGalleryCollection[index]["active"] = "Y";
                    
                    
                }
            );

            sliderPopup(popupGalleryCollection);

        }
    }
    
}
function sliderPopup(images)
{
    if(images && BX.type.isArray(images))
    {
        
        var nodeControlPics = $("#sliderPopup").find(".controls-pictures"),
            nodeBigPics = $("#sliderPopup").find(".wrapper-big-picture"),
            nodeControlPicsParent = nodeControlPics.parent(),
            nodeBigPicsParent = nodeBigPics.parent(),
            listControl = "",
            listBigPic = "";

        nodeControlPics.html("");
        nodeBigPics.html("");

        if(images.length > 0)
        {

            for (i = 0; i < images.length; i++)
            {

                listControl += "<div data-value='"+i+"'";
                    listControl += "class='small-picture popup-control";

                    if(images[i].active == "Y")
                    {
                        listControl += " active";
                        $("#sliderPopup").attr("data-current-image", i);
                    }
                    listControl += "'>";


                listControl += "<img src='"+images[i].smallSrc+"' alt = '";

                    if(images[i].desc)
                        listControl += images[i].desc;

                listControl += "'/>";

                listControl += "</div>";


                listBigPic += "<div data-id='"+i+"'";
                    listBigPic += "class='big-picture";

                    if(images[i].active == "Y")
                        listBigPic += " active";

                    if(images[i].desc)
                        listBigPic += " with-desc";
                    
                    listBigPic += "'>";


                    listBigPic += "<img src='"+images[i].bigSrc+"' class='d-block mx-auto img-fluid' alt = '";

                        if(images[i].desc)
                            listBigPic += images[i].desc;

                    listBigPic += "'/>";

                    if(images[i].desc)
                        listBigPic += "<div class='desc-img'>"+images[i].desc+"</div>";
                    

                listBigPic += "</div>";

            }

        }

        nodeBigPics.html(listBigPic);
        nodeControlPics.html(listControl);


    }
}

function destroyPopupGallery()
{
    popupGalleryCollection = [];
    $('#sliderPopup').removeClass('active');
    $('body').removeClass('modal-open');

    $('#sliderPopup').find(".wrapper-big-picture").children().remove();
    $('#sliderPopup').find(".controls-pictures").children().remove();
    
    
}

$(document).on('click', '.open-popup-gallery', function()
{
    $('.popup-slider').addClass('active');
    $('body').addClass('modal-open');
    popupGallery($(this).attr("data-popup-gallery"));
    
});


$(document).on('click', '.wrapper-select-input', function()
{
    if(!$(this).hasClass('open'))
        $(this).addClass('open');
    
    else
    {
        $(this).removeClass('open');
    }
    
});







function setCurrentPopupSlide (slideID)
{
    $('#sliderPopup').find(".small-picture").removeClass('active');
    $('#sliderPopup').find(".big-picture").removeClass('active');

    $('#sliderPopup').find(".small-picture[data-value='"+slideID+"']").addClass('active');
    $('#sliderPopup').find(".big-picture[data-id='"+slideID+"']").addClass('active');

    $('#sliderPopup').attr("data-current-image", slideID);
}

function slidePopupControl(btn, action)
{
    var arSlider = $('#sliderPopup').find(".controls-pictures").children(),
        curSlide = $('#sliderPopup').attr("data-current-image");


    for (var i = 0; arSlider.length > i; i++)
    {
        if(i == curSlide)
        {
            if(action == "prev")
            {
                curSlide = i - 1;
            }

            if(action == "next")
            {
                curSlide = i + 1;
            }

            if(curSlide > arSlider.length -1)
            {
                curSlide = 0;
            }
            if(curSlide < 0)
            {
                curSlide = arSlider.length-1;
            }

            if(typeof curSlide !== "undefined")
            {
                setCurrentPopupSlide (curSlide);
            }

            return;
        }
    }
}

$(document).on('click', '.nav-item.action_prev', function() {
    slidePopupControl($(this), 'prev');
});
$(document).on('click', '.nav-item.action_next', function() {
    slidePopupControl($(this), 'next');
});


$(document).on('click', '.btn-open-hidden-board', function() {
    $(".content-hidden-board[data-content="+$(this).attr("data-open")+"]").addClass('active');
    $(".catalog-list-wrap.z-index-99").removeClass('z-index-99');
});

$(document).on('click', '.btn-close-hidden-board', function() {
    $(".content-hidden-board[data-content="+$(this).attr("data-close")+"]").removeClass('active');
});

$(document).mouseup(function(e) {
    var div = $(".content-hidden-board.active");

    if (!div.is(e.target) && div.has(e.target).length === 0)
    {
        div.removeClass('active');
    }
});

if ($(window).width() > 1200) 
{
    $(document).on(
    {
        mouseenter: function (){

            var total = parseInt($(this).find('.elem-hover-height-more').css(
                'margin-bottom')) + $(this).find('.elem-hover-height').outerHeight(
                true);
                
            $(this).css({
                'height': total + 'px'
            });
            $(this).find('div.elem-hover-show').slideDown(250);
        },

        mouseleave: function (){
            $(this).find('div.elem-hover-show').slideUp(0);
        },
    },
    ".elem-hover"
    );
    
}

$(document).on('click', '.section-with-hidden-items .head-filter', 
    function()
    {
        var btn = $(this);
        var content = $(".content-animate-slide-down[data-show ='"+btn.attr("data-show")+"']");
        var btns = $(".click-animate-slide-down[data-show ='"+btn.attr("data-show")+"']");

        content.slideUp(400, function()
            {
                btns.addClass('noactive-mob').removeClass('active-mob');
                content.addClass('noactive-mob').removeClass('active-mob');
            }
        );
    }
);

$(document).on('click', '.click-animate-slide-down', 
    function()
    {
        var btn = $(this);
        var content = $(".content-animate-slide-down[data-show ='"+btn.attr("data-show")+"']");

        if($(window).width() > 768)
        {

            if(!btn.hasClass('active'))
            {
                content.slideDown(400, function()
                    {
                        btn.addClass('active').removeClass('noactive');
                        content.addClass('active').removeClass('noactive');
                    }
                );
                BX.setCookie($(".domen-url-for-cookie").val()+'_phoenix_catalog_tab_'+btn.attr("data-show")+$("input.site_id").val(), 'active', {expires: 60*60*60*60, path: "/"});
            }
            else
            {
                content.slideUp(400, function()
                    {
                        btn.addClass('noactive').removeClass('active');
                        content.addClass('noactive').removeClass('active');
                    }
                );
                BX.setCookie($(".domen-url-for-cookie").val()+'_phoenix_catalog_tab_'+btn.attr("data-show")+$("input.site_id").val(), 'noactive', {expires: 60*60*60*60, path: "/"});
            }

        }
        else
        {
            if(!btn.hasClass('active-mob'))
            {
                content.addClass('active-mob').removeClass('noactive-mob');
                content.slideDown(400, function()
                    {
                        btn.addClass('active-mob').removeClass('noactive-mob');
                    }
                );
                
            }
            else
            {
                content.slideUp(400, function()
                    {
                        btn.addClass('noactive-mob').removeClass('active-mob');
                        content.addClass('noactive-mob').removeClass('active-mob');
                    }
                );
            }
        }
        
    }
);

$(document).on('click', '.btn-hide-column', 
    function()
    {

        if(!$(this).hasClass('active'))
        {
            if($('div.menu-banner-slider').hasClass('slick-initialized'))
                $('div.menu-banner-slider').slick('unslick');

            $('div.menu-banner-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 5000,
                dots: false,
                infinite: true,
                adaptiveHeight: false,
                speed: 500,
                arrows: false
            });

            $(this).addClass('active');
            $('.parent-hide-column').removeClass('hide');
            /*$('.catalog-list-wrap .catalog-list').addClass('three-col').removeClass('four-col');*/
            BX.setCookie($(".domen-url-for-cookie").val()+'_phoenix_catalog_side_column_'+$("input.site_id").val(), 'Y', {expires: 60*60*60*60, path: "/"});
        }
        else
        {
            $('div.menu-banner-slider').slick('unslick');
            $(this).removeClass('active');
            $('.parent-hide-column').addClass('hide');
            /*$('.catalog-list-wrap .catalog-list').removeClass('three-col').addClass('four-col');*/
            BX.setCookie($(".domen-url-for-cookie").val()+'_phoenix_catalog_side_column_'+$("input.site_id").val(), 'N', {expires: 60*60*60*60, path: "/"});
        }
        
        showProcessLoad();

        

        updateCatalogList();
    }
);

function updateCatalogList($params)
{
    $params = $params || {"ajax_action": "Y"};
    showProcessLoad();

    $('.element-list-wrap').removeClass("active");
        
    $.post(
        location.href, 
        $params, 
        function(html)
        {
            closeProcessLoad();
            
            $('.element-list-wrap').html(html);
            $('.element-list-wrap').addClass("active");
            $('.lazyload').Lazy(paramsLazy);
            setInfoBasket("firstLoad");
        }
    );

}

$(document).on('click', '.sort_btn_js', 
    function()
    {
        var sort = $(this).attr("data-sort"),
            order = $(this).attr("data-order"),
            _th = $(this);

        _th.parents(".element-sort").find(".sort_btn_js").removeClass('active');
        _th.addClass('active');

        if(_th.hasClass('asc'))
        {
            _th.removeClass('asc').addClass('desc');
            _th.attr("data-order", "asc");
        }

        else if(_th.hasClass('desc'))
        {
            _th.removeClass('desc').addClass('asc');
            _th.attr("data-order", "desc");
        }

        var $params = {
            "ajax_action": "Y",
            "sort": sort,
            "order": order,
        };

        updateCatalogList($params);
        
    }
);

$(document).on('click', '.sort-available-js', 
    function()
    {
        var $params = {
                "ajax_action": "Y",
                "available": $(this).attr("data-available")
            };


        if($(this).attr("data-available") == "Y")
        {
            $(this).attr("data-available", "N");
            $(this).addClass("active");
        }
        else
        {
            $(this).attr("data-available", "Y");
            $(this).removeClass("active");
        }
        

        updateCatalogList($params);
    }
);

$(document).on('click', '.display-view-js', 
    function()
    {

        if(!$(this).hasClass('active'))
        {
            var $params = {
                "ajax_action": "Y",
                "view": $(this).attr("data-view")
            };

            $(this).parents('.view-list').find('.display-view-js').removeClass('active');
            $(this).addClass('active');

            updateCatalogList($params);

        }
        
    }
);

$(document).on('click', '.toogle-animate-click', 
    function()
    {
        var block = $(this).parents(".toogle-animate-parent");
        if (!block.hasClass("active"))
        {
            $(".toogle-animate-content", block).slideDown(200, function() {
                block.addClass("active");
            });
        } 
        else
        {
            $(".toogle-animate-content", block).slideUp(200, function() {
                block.removeClass("active");
            });
        }
    }
);

$(document).on('click', 'div.bx_sort_container ul.tabs-head li', 
    function()
    {
        if(!$(this).hasClass("current"))
           location.href = $(this).find("span").attr("data-href");
    }
);



BasketPoolQuantity = function()
{
    this.processing = false;
    this.poolQuantity = {};
    this.updateTimer = null;
    this.currentQuantity = {};
    this.lastStableQuantities = {};

    this.updateQuantity();
};


BasketPoolQuantity.prototype.updateQuantity = function()
{

    if(BX('basket_items'))
    {
        var items = BX('basket_items').querySelectorAll('div.product');

        if (!!items && items.length > 0)
        {
            for (var i = 0; items.length > i; i++)
            {
                var itemId = items[i].id;
                this.currentQuantity[itemId] = BX('QUANTITY_' + itemId).value;
            }
        }


        this.lastStableQuantities = BX.clone(this.currentQuantity, true);
    }
    

};

BasketPoolQuantity.prototype.changeQuantity = function(itemId)
{
    var quantity = BX('QUANTITY_' + itemId).value;
    var isPoolEmpty = this.isPoolEmpty();

    if (this.currentQuantity[itemId] && this.currentQuantity[itemId] != quantity)
    {
        this.poolQuantity[itemId] = this.currentQuantity[itemId] = quantity;
    }

    if (!isPoolEmpty)
    {
        this.enableTimer(true);
    }
    else
    {
        this.trySendPool();
    }
};


BasketPoolQuantity.prototype.trySendPool = function()
{
    
    if (!this.isPoolEmpty() && !this.isProcessing())
    {
        this.enableTimer(false);

        recalcBasketAjax({});
        
    }
};

BasketPoolQuantity.prototype.isPoolEmpty = function()
{
    return ( Object.keys(this.poolQuantity).length == 0 );
};

BasketPoolQuantity.prototype.clearPool = function()
{
    this.poolQuantity = {};
};

BasketPoolQuantity.prototype.isProcessing = function()
{
    return (this.processing === true);
};

BasketPoolQuantity.prototype.setProcessing = function(value)
{
    this.processing = (value === true);
};

BasketPoolQuantity.prototype.enableTimer = function(value)
{
    clearTimeout(this.updateTimer);
    if (value === false)
        return;

    this.updateTimer = setTimeout(function(){ basketPoolQuantity.trySendPool(); }, 1500);
};
function updateQuantity(controlId, basketId, ratio, bUseFloatQuantity)
{
    clearTimeout($.data(this, 'timer-quantity'));

    $.data(this, 'timer-quantity', setTimeout($.proxy(function() {

        var oldVal = BX(controlId).defaultValue,
            newVal = parseFloat(BX(controlId).value) || 0,
            bIsCorrectQuantityForRatio = false,
            autoCalculate = ((BX("auto_calculation") && BX("auto_calculation").value == "Y") || !BX("auto_calculation"));



        
        if (ratio === 0 || ratio == 1)
        {
            bIsCorrectQuantityForRatio = true;
        }
        else
        {

            var newValInt = newVal * 10000,
                ratioInt = ratio * 10000,
                reminder = newValInt % ratioInt,
                newValRound = parseInt(newVal);

            if (reminder === 0)
            {
                bIsCorrectQuantityForRatio = true;
            }
        }

        var bIsQuantityFloat = false;

        if (parseInt(newVal) != parseFloat(newVal))
        {
            bIsQuantityFloat = true;
        }

        newVal = (bUseFloatQuantity === false && bIsQuantityFloat === false) ? parseInt(newVal) : parseFloat(newVal).toFixed(4);
        newVal = correctQuantity(newVal);


        
        if (bIsCorrectQuantityForRatio)
        {
            BX(controlId).defaultValue = newVal;

            BX("QUANTITY_INPUT_" + basketId).value = newVal;

            BX("QUANTITY_" + basketId).value = newVal;

            if (autoCalculate)
            {
                basketPoolQuantity.changeQuantity(basketId);
            }
        }
        else
        {
            newVal = getCorrectRatioQuantity(newVal, ratio, bUseFloatQuantity);
            newVal = correctQuantity(newVal);

            if (newVal != oldVal)
            {
                BX("QUANTITY_INPUT_" + basketId).value = newVal;
                BX("QUANTITY_" + basketId).value = newVal;

                if (autoCalculate)
                {
                    basketPoolQuantity.changeQuantity(basketId);
                }
            }else
            {
                BX(controlId).value = oldVal;
            }
        }

        

    }, this), 700));


}
function correctQuantity(quantity)
{
    return parseFloat((quantity * 1).toString());
}


function recalcBasketAjax(params)
{
    
    
    if (basketPoolQuantity.isProcessing())
    {
        return false;
    }

    /*BX.showWait();*/
    

    var property_values = {},
        action_var = 'recalculate',
        delayedItems = '',
        items = BX('basket_items').querySelectorAll('div.product'),
        postData,
        i;

    if(BX('delayed_items'))
        delayedItems = BX('delayed_items').querySelectorAll('div.product');

    
    postData = {
        'sessid': BX.bitrix_sessid(),
        'site_id': $("input.site_id").val(),
        'action_var': action_var,
        'quantity_float': BX('quantity_float').value
    };

    postData[action_var] = 'recalculate';

    if (!!params && typeof params === 'object')
    {
        for (i in params)
        {
            if (params.hasOwnProperty(i))
                postData[i] = params[i];
        }
    }


    
    if (!!items && items.length > 0)
    {
        for (i = 0; items.length > i; i++)
        {
            postData['QUANTITY_' + items[i].id] = BX('QUANTITY_' + items[i].id).value;
        }
    }

    if (!!delayedItems && delayedItems.length > 0)
    {
        $('.show_items[data-items="delayed"]').css({"display":""});

        for (i = 1; delayedItems.length > i; i++)
            postData['DELAY_' + delayedItems[i].id] = 'Y';
    }
    else
    {
        $('.show_items[data-items="delayed"]').css({"display":"none"});
        showFormOrder();
    }

 

    basketPoolQuantity.setProcessing(true);
    basketPoolQuantity.clearPool();


    if($("input.basketOrder").length<=0)
        showProcessLoadTopRight();

    BX.ajax({
        url: '/bitrix/components/bitrix/sale.basket.basket/ajax.php',
        method: 'POST',
        data: postData,
        dataType: 'json',
        onsuccess: function(result)
        {

            
            /*BX.closeWait();*/
            if($("input.basketOrder").length<=0)
                closeProcessLoadTopRight();
            
            if($("input.basketOrder").length>0 && params.action != "stopRefreshOrder")
                BX.Sale.OrderAjaxComponent.sendRequest("refreshOrderAjax", "noRedirect");
            
           

            basketPoolQuantity.setProcessing(false);

            if (basketPoolQuantity.isPoolEmpty())
            {
                updateBasketTable(null, result);
                basketPoolQuantity.updateQuantity();
            }
            else
            {
                basketPoolQuantity.enableTimer(true);
            }

        }
    });
}

function setQuantity(basketId, ratio, sign, bUseFloatQuantity)
{
    var curVal = parseFloat(BX("QUANTITY_INPUT_" + basketId).value),
        newVal;

    newVal = (sign == 'up') ? curVal + ratio : curVal - ratio;

    if (newVal < 0)
        newVal = 0;

    if (bUseFloatQuantity)
    {
        newVal = parseFloat(newVal).toFixed(4);
    }
    newVal = correctQuantity(newVal);

    if (ratio > 0 && newVal < ratio)
    {
        newVal = ratio;
    }

    if (!bUseFloatQuantity && newVal != newVal.toFixed(4))
    {
        newVal = parseFloat(newVal).toFixed(4);
    }

    newVal = getCorrectRatioQuantity(newVal, ratio, bUseFloatQuantity);
    newVal = correctQuantity(newVal);

    BX("QUANTITY_INPUT_" + basketId).value = newVal;
    BX("QUANTITY_INPUT_" + basketId).defaultValue = newVal;

    updateQuantity('QUANTITY_INPUT_' + basketId, basketId, ratio, bUseFloatQuantity);
}

function getCorrectRatioQuantity(quantity, ratio, bUseFloatQuantity)
{
    var newValInt = quantity * 10000,
        ratioInt = ratio * 10000,
        reminder = (quantity / ratio - ((quantity / ratio).toFixed(0))).toFixed(6),
        result = quantity,
        bIsQuantityFloat = false,
        i;
    ratio = parseFloat(ratio);

    if (reminder == 0)
    {
        return result;
    }

    if (ratio !== 0 && ratio != 1)
    {
        for (i = ratio, max = parseFloat(quantity) + parseFloat(ratio); i <= max; i = parseFloat(parseFloat(i) + parseFloat(ratio)).toFixed(4))
        {
            result = i;
        }

    }else if (ratio === 1)
    {
        result = quantity | 0;
    }

    if (parseInt(result, 10) != parseFloat(result))
    {
        bIsQuantityFloat = true;
    }

    result = (bUseFloatQuantity === false && bIsQuantityFloat === false) ? parseInt(result, 10) : parseFloat(result).toFixed(4);
    result = correctQuantity(result);
    return result;
}

function correctQuantity(quantity)
{
    return parseFloat((quantity * 1).toString());
}



function updateBasketTable(basketItemId, res)
{

    var table = BX("basket_items"),
        rows,
        newBasketItemId,
        arItem,
        lastRow,
        newRow,
        arColumns,
        bShowDeleteColumn = false,
        bShowDelayColumn = false,
        bShowPropsColumn = false,
        bShowPriceType = false,
        bUseFloatQuantity,
        origBasketItem,
        oCellMargin,
        i,
        oCellName,
        imageURL,
        cellNameHTML,
        oCellItem,
        cellItemHTML,
        bSkip,
        j,
        val,
        propId,
        arProp,
        bIsImageProperty,
        countValues,
        full,
        fullWidth,
        itemWidth,
        arVal,
        valId,
        arSkuValue,
        selected,
        valueId,
        k,
        arItemProp,
        oCellQuantity,
        oCellQuantityHTML,
        ratio,
        isUpdateQuantity,
        oldQuantity,
        oCellPrice,
        fullPrice,
        id,
        oCellDiscount,
        oCellWeight,
        oCellCustom,
        customColumnVal,
        propsMap,
        selectedIndex,
        counter,
        marginLeft,
        createNewItem;



    

    if (!table || typeof res !== 'object')
    {
        return;
    }

    rows = table.querySelectorAll('div.product');
    lastRow = rows[rows.length - 1];
    bUseFloatQuantity = (res.PARAMS.QUANTITY_FLOAT === 'Y');
    
    
    if (!!res.BASKET_DATA)
    {
        for (id in res.BASKET_DATA.GRID.ROWS)
        {
            if (res.BASKET_DATA.GRID.ROWS.hasOwnProperty(id))
            {
                var item = res.BASKET_DATA.GRID.ROWS[id];

                if (BX('discount_value_' + id))
                    BX('discount_value_' + id).innerHTML = item.DISCOUNT_PRICE_PERCENT_FORMATED;

                if (BX('current_price_' + id))
                    BX('current_price_' + id).innerHTML = item.PRICE_FORMATED;

                if (BX('old_price_' + id))
                {


                    if(item.DISCOUNT_PRICE_PERCENT > 0)
                    {
                        BX('old_price_' + id).innerHTML = item.SUM_FULL_PRICE_FORMATED;
                        $('#old_price_' + id).css({"display": ""});
                    }
                    else
                    {
                        $('#old_price_' + id).css({"display": "none"});
                    }
                }

                if (BX('sum_' + id))
                    BX('sum_' + id).innerHTML = item.SUM;
                

                /* if the quantity was set by user to 0 or was too much, we need to show corrected quantity value from ajax response*/
                if (BX('QUANTITY_' + id))
                {
                    BX('QUANTITY_INPUT_' + id).value = item.QUANTITY;
                    BX('QUANTITY_INPUT_' + id).defaultValue = item.QUANTITY;

                    BX('QUANTITY_' + id).value = item.QUANTITY;
                }
            }
        }
    }
    

    if (!!res.BASKET_DATA)
        couponListUpdate(res.BASKET_DATA);
    

    /*
    if (res.hasOwnProperty('WARNING_MESSAGE'))
    {
        var warningText = '';

        for (i = res['WARNING_MESSAGE'].length - 1; i >= 0; i--)
            warningText += res['WARNING_MESSAGE'][i] + '<br/>';

        BX('warning_message').innerHTML = warningText;
    }
    */

    if (!!res.BASKET_DATA)
    {
        if (BX('allSum_FORMATED'))
            BX('allSum_FORMATED').innerHTML = res['BASKET_DATA']['allSum_FORMATED'];

        if (BX('DISCOUNT_PRICE_ALL'))
        {
            if(res['BASKET_DATA']['DISCOUNT_PRICE_ALL'] > 0)
            {
                $('.basket-style').find(".dynamic-show-hide-discount").css({"display": ""});
                $('.basket-style').find(".dynamic-show-hide-total-title").css({"display": "none"});
                BX('DISCOUNT_PRICE_ALL').innerHTML = res['BASKET_DATA']['DISCOUNT_PRICE_FORMATED'];
            }
            else
            {
                $('.basket-style').find(".dynamic-show-hide-total-title").css({"display": ""});
                $('.basket-style').find(".dynamic-show-hide-discount").css({"display": "none"});
            }
            
        }

        if($("input#min_sum").length>0)
        {
            if($("input#min_sum").val().length)
            {
                var minSum = $("input#min_sum").val();
                minSum = +minSum;


                if( res['BASKET_DATA']['allSum'] <= minSum )
                {
                    $(".alert-message-min-sum").css({"display": ""});
                    $(".basket-buttons").css({"display": "none"});
                    $(".clear-basket-node-control").addClass('hidden');
                }
                else
                {
                    $(".alert-message-min-sum").css({"display": "none"});
                    $(".basket-buttons").css({"display": ""});
                    $(".clear-basket-node-control").removeClass('hidden');
                }

            }
        }
    }
}

function couponListUpdate(res)
{
    if (!!res && typeof res !== 'object')
        return;
    

    var couponBlock = $('.coupons_block');


        
    if (couponBlock.length>0)
    {

        if (!!res.COUPON_LIST && BX.type.isArray(res.COUPON_LIST))
        {

            if ($('.input-coupon').length>0)
            {
                $('.input-coupon').val("");
                $('.input-coupon').parents(".in-focus").removeClass('in-focus');
            }


            couponsCollection = $(".coupons_block").find(".coupon-one");

            if(couponsCollection.length>0)
            {
                for (i = 0; i < res.COUPON_LIST.length; i++)
                {
                    couponFound = false;
                    key = -1;

                    for (j = 0; j < couponsCollection.length; j++)
                    {

                        if ($(couponsCollection[j]).find(".coupon-close").attr("data-coupon") === res.COUPON_LIST[i].COUPON)
                        {
                            couponFound = true;
                            key = j;
                            couponsCollection[j].couponUpdate = true;
                            break;
                        }
                    }
                    

                    if (couponFound)
                    {

                        couponClass = 'disabled';
                        if (res.COUPON_LIST[i].JS_STATUS === 'BAD')
                            couponClass = 'bad';
                        else if (res.COUPON_LIST[i].JS_STATUS === 'APPLYED')
                            couponClass = 'good';


                        $(couponsCollection[key]).removeClass("disabled bad good").addClass(couponClass)

                        /*BX.adjust(couponsCollection[key], {props: {className: couponClass}});
                        BX.adjust(couponsCollection[key].nextSibling, {props: {className: couponClass}});
                        BX.adjust(couponsCollection[key].nextSibling.nextSibling, {html: res.COUPON_LIST[i].JS_CHECK_CODE});*/

                    }
                    else
                    {
                        couponCreate(res.COUPON_LIST[i]);
                    }

                }

                for (j = 0; j < couponsCollection.length; j++)
                {
                    if (typeof (couponsCollection[j].couponUpdate) === 'undefined' || !couponsCollection[j].couponUpdate)
                    {
                        $(couponsCollection[j]).remove();
                        couponsCollection[j] = null;
                    }
                    else
                    {
                        couponsCollection[j].couponUpdate = null;
                    }
                }

            }
            else
            {
                for (i = 0; i < res.COUPON_LIST.length; i++)
                {
                    couponCreate(res.COUPON_LIST[i]);
                }
            }
        }

    }
}


function couponCreate(oneCoupon, order)
{
    var couponClass = 'disabled',
        removeClass = 'remove-coupon';
    order = order || false;

    if ($(".coupons_block").length<=0)
        return;

    if (oneCoupon.JS_STATUS === 'BAD')
        couponClass = 'bad';
    else if (oneCoupon.JS_STATUS === 'APPLYED')
        couponClass = 'good';

    if(order)
        removeClass = 'remove-order-coupon';


    html = "<div class=\"coupon-one "+couponClass+"\">"
        +"<span class=\"coupon-name\">"+oneCoupon.COUPON+"</span><span class=\"coupon-close "+removeClass+"\" data-coupon=\""+oneCoupon.COUPON+"\"></span>"
        +"</div>";


    $(html).appendTo(".coupons_block");
}



$(document).on("click", ".remove-coupon", function()
{
    var target = this,
        value;

    if (BX.type.isElementNode(target) && target.hasAttribute('data-coupon'))
    {
        value = target.getAttribute('data-coupon');
        if (BX.type.isNotEmptyString(value))
        {
            recalcBasketAjax({'delete_coupon' : value});
        }
    }
});


$(document).on("click", ".remove-order-coupon", function()
{
    var target = this,
        value;

    if (BX.type.isElementNode(target) && target.hasAttribute('data-coupon'))
    {
        value = target.getAttribute('data-coupon');
        if (BX.type.isNotEmptyString(value))
        {
            BX.Sale.OrderAjaxComponent.sendRequest("removeCoupon", value);
        }
    }
});

$(document).on("click", ".show_items", function()
{
    $(".show_items").removeClass('active');
    $(this).addClass('active');
    $(".basket_items_list").removeClass('active');
    $(".basket_items_list[data-items='"+$(this).attr("data-items")+"']").addClass('active');

    if($(this).attr("data-items") == "delayed")
        hideFormOrder();
    
    if($(this).attr("data-items") == "items")
        showFormOrder();

    BasketFilter($("input.basket-filter").val());
    
});

function enterCoupon()
{
    
    if ($('.input-coupon').length>0)
        recalcBasketAjax({'coupon' : $('.input-coupon').val()});
}

function enterOrderCoupon(){
    
    if ($('.input-coupon').length>0)
        BX.Sale.OrderAjaxComponent.sendRequest("enterCoupon", $('.input-coupon').val());
}

function add2Basket(productItem, target)
{
    productItem = productItem || "";
    target = target || "";


    if(productItem)
    {
        if(target.length>0)
            target.addClass('btn-processing');
        

        BX.ajax({
            method: 'POST',
            dataType: 'json',
            url: '/bitrix/tools/concept.phoenix/ajax/basket/add2basket.php',
            data: {
                productItem: productItem,
                site_id: $("input.site_id").val()
            },
            onsuccess: function(arResult)
            {
                /*if (!BX.type.isPlainObject(arResult))
                    return;*/

                if(arResult["OK"]=="Y")
                {
                    markProductAddBasket(productItem["PRODUCT_ID"]);

                    if(arResult["SCRIPTS"])
                        $('body').append(arResult["SCRIPTS"]);
                }
                else
                {
                    if(target.length>0)
                        target.removeClass('btn-processing');
                }
            }
        });
    }
    
}

function showProcessLoad()
{
    $('.loading').addClass('active');
}
function closeProcessLoad()
{
    $('.loading').removeClass('active');
}

function showProcessLoadItem(id)
{
    $('.preloader-item[data-preload="'+id+'"]').addClass('active');
}
function closeProcessLoadItem(id)
{
    $('.preloader-item[data-preload="'+id+'"]').removeClass('active');
}

function showProcessLoadTopRight()
{
    $('.loading-top-right').addClass('active');
}
function closeProcessLoadTopRight()
{
    $('.loading-top-right').removeClass('active');
}


function startBlurWrapperContainer()
{
    if(!$("body").hasClass('modal-open'))
    {
        $("body").addClass("modal-open");
        $('.wrapper').addClass('blur');

        if (device.ios())
        {
            cur_pos = $(document).scrollTop();
            $("body").addClass("modal-ios");
        }
    }
    
}

function stopBlurWrapperContainer()
{
    if($("body").hasClass('modal-open'))
    {
        $("body").removeClass("modal-open");
        $('.wrapper').removeClass('blur');

        if (device.ios())
        {
            $("body").removeClass("modal-ios");
            window.scrollTo(0, cur_pos);
        }
    }
}

function startModalMode(selectorArea)
{

    startBlurWrapperContainer();
    closeProcessLoad();

    setTimeout(function() {
        $(selectorArea).find('.phoenix-modal').addClass('active');
    }, 100);
}

function callFastOrderForm(fromBasket, productItem)
{
    fromBasket = fromBasket || "";
    productItem = productItem || "";


    $.ajax({
        method: 'POST',
        dataType: 'html',
        url: '/bitrix/tools/concept.phoenix/ajax/basket/call_form_fast_order.php',
        data: {
            site_id: $("input.site_id").val(),
            fromBasket: fromBasket,
            productItem: productItem
        },
        success: function(html)
        {

            closeProcessLoad();
            startModalMode("div.modalAreaForm");
            $('div.modalAreaForm').html(html);
        }
    });
}

function getStringNameItem(name, offers)
{
    var input = name;

    for( var i in offers )
    {
        input += offers[i].SKU_NAME + ": " + offers[i].NAME + "; ";
    }

    return input;
}

$(document).on("click", ".callFastOrder", 
    function()
    {
        var callDialog = "N";

        if($(".callFastOrder").hasClass("callDialog"))
            callDialog = "Y";

        if($(this).attr("data-param-product"))
            var productItem = eval("(" + $(this).attr("data-param-product") + ")");
        
        callFastOrderForm(callDialog, productItem);
    }
);

$(document).on("click", ".btn-add2basket", 
    function()
    {
        var productItem = eval("(" + $(this).attr("data-param-product") + ")");
        add2Basket(productItem, $(this));
    }
);



function AjaxQuickSearch(arParams)
{
        var _this = this;
        this.arParams = {
            'CONTAINER_ID': arParams.CONTAINER_ID,
            'INPUT_ID': arParams.INPUT_ID,
            'SHOW_RESULTS': arParams.SHOW_RESULTS,
            'LINE_VIEW_SIZE': "" 
        };

        if(arParams.LINE_VIEW_SIZE)
            this.arParams.LINE_VIEW_SIZE = arParams.LINE_VIEW_SIZE;


        this.arParams.AJAX_PAGE = "/bitrix/tools/concept.phoenix/ajax/search.php";
        this.arParams.MIN_QUERY_LEN = 3;

        this.cache = [];
        this.cache_key = null;

        this.startText = '';
        this.running = false;
        this.searchWait = 0;
        this.currentRow = -1;
        this.RESULT = null;
        this.RESULT_WRAPPER = null;
        this.CONTAINER = null;
        this.INPUT = null;
        this.WAIT = null;
        this.HINT_BTN = null;
        this.SEARCH_IN_BTN = null;
        this.FOCUS = false;
        this.searchIn = null;
        this.searchInOld = null;


        this.ShowResult = function(result)
        {
            if(BX.type.isString(result))
                _this.RESULT.innerHTML = result;

            if($.trim(_this.RESULT.innerHTML).length > 0)
            {
                setTimeout(function(){
                    _this.RESULT_WRAPPER.style.display = 'block';
                    var pos = _this.adjustResultNode();
                }, 450);
            }
            else
            {
                _this.RESULT_WRAPPER.style.display = 'none';
            }

        };

        this.onKeyPress = function(keyCode)
        {
            
            switch (keyCode)
            {
                case 27:
                    _this.RESULT_WRAPPER.style.display = 'none';
                    _this.currentRow = -1;
                    _this.UnSelectAll();
                return true;
            }

            return false;
        };

        this.onTimeout = function()
        {
            _this.onChange(function(){
                setTimeout(_this.onTimeout, 500);
            });
        };

        this.onChange = function(callback)
        {

            if($(window).width() >= 1199)
            {
                if(this.arParams.SHOW_RESULTS != "Y")
                    return;
                
                if(_this.running)
                {
                    _this.runningCall = true;
                    return;
                }

                _this.running = true;

                if( _this.INPUT.value != _this.oldValue || _this.searchIn != _this.searchInOld)
                {
                    _this.oldValue = _this.INPUT.value;
                    _this.searchInOld = _this.searchIn;

                    if(_this.INPUT.value.length >= _this.arParams.MIN_QUERY_LEN)
                    {
                        showWaitSearch ($("#"+_this.arParams.CONTAINER_ID));
                        clearTimeout(_this.searchWait);

                        _this.searchWait = setTimeout(
                            function() 
                            {
                                _this.cache_key = _this.arParams.INPUT_ID + '|' + _this.INPUT.value + '|' + _this.searchIn;
                                
                                if(_this.cache[_this.cache_key] == null)
                                {
                                    if(_this.INPUT.value.length >= _this.arParams.MIN_QUERY_LEN)
                                    {
                                        BX.ajax.post(
                                            _this.arParams.AJAX_PAGE,
                                            {
                                                'q':_this.INPUT.value,
                                                'searchIn': _this.searchIn,
                                                'LINE_VIEW_SIZE': _this.arParams.LINE_VIEW_SIZE,
                                                'ajax_mode': "Y",
                                                'site_id': $("input.site_id").val()
                                            },
                                            function(result)
                                            {

                                                _this.cache[_this.cache_key] = result;
                                                _this.ShowResult(result);
                                                if(_this.WAIT)
                                                    _this.WAIT.style.display = 'none';

                                                hideWaitSearch ($("#"+_this.arParams.CONTAINER_ID));

                                                if (!!callback)
                                                    callback();

                                                _this.running = false;

                                                if(_this.runningCall)
                                                {
                                                    _this.runningCall = false;
                                                    _this.onChange();
                                                }
                                            }
                                        );
                                        
                                        return;
                                    }
                                    else
                                    {
                                        hideWaitSearch ($("#"+_this.arParams.CONTAINER_ID));
                                    }

                                }
                                else
                                {
                                    _this.ShowResult(_this.cache[_this.cache_key]);
                                    _this.currentRow = -1;
                                    _this.EnableMouseEvents();
                                    hideWaitSearch ($("#"+_this.arParams.CONTAINER_ID));
                                }
                            }, 900);
                    }
                    else
                    {
                        _this.RESULT_WRAPPER.style.display = 'none';
                        _this.RESULT.innerHTML = "";
                        _this.currentRow = -1;
                        _this.UnSelectAll();
                    }

                   
                }

                if (!!callback)
                    callback();


                _this.running = false;
            }

        };

        this.onScroll = function ()
        {
            if(BX.type.isElementNode(_this.RESULT_WRAPPER) && _this.RESULT_WRAPPER.style.display !== "none" && _this.RESULT.innerHTML !== '')
                _this.adjustResultNode();
            
        };

        this.UnSelectAll = function()
        {
            var tbl = BX.findChild(_this.RESULT, {'tag':'table','class':'title-search-result'}, true);
            if(tbl)
            {
                var cnt = tbl.rows.length;
                for(var i = 0; i < cnt; i++)
                    tbl.rows[i].className = '';
            }
        };

        this.EnableMouseEvents = function()
        {

        };

        this.onFocusLost = function(hide)
        {
            setTimeout(function(){
                if(!_this.FOCUS)
                    _this.RESULT_WRAPPER.style.display = 'none';
            }, 250);
        
            _this.FOCUS = false;
        };

        this.onFocusGain = function()
        {
            if($.trim(_this.RESULT.innerHTML).length)
                _this.ShowResult();
        };

        this.onKeyDown = function(e)
        {
            if(!e)
                e = window.event;

            if(_this.RESULT_WRAPPER.style.display == 'block')
            {
                if(_this.onKeyPress(e.keyCode))
                    return BX.PreventDefault(e);
            }
        };

        this.adjustResultNode = function()
        {
            if(!(BX.type.isElementNode(_this.RESULT_WRAPPER)
                && BX.type.isElementNode(_this.CONTAINER))
            )
                return { top: 0, right: 0, bottom: 0, left: 0, width: 0, height: 0 };
            

            var pos = BX.pos(_this.CONTAINER);
            var bxpanel = document.getElementById("bx-panel");
            var bxheight = 0;

            if(bxpanel != null && !$("#"+this.arParams.CONTAINER_ID).hasClass('outside-div'))
                bxheight = parseInt(bxpanel.clientHeight);


            _this.RESULT_WRAPPER.style.position = 'absolute';
            _this.RESULT_WRAPPER.style.top = (pos.bottom - bxheight) + 'px';
            _this.RESULT_WRAPPER.style.left = (pos.left - 15) + 'px';
            _this.RESULT_WRAPPER.style.width = (pos.width + 30) + 'px';


            if($("#"+this.arParams.CONTAINER_ID).hasClass('outside-div'))
                _this.RESULT_WRAPPER.style.height = ($(window).height() - pos.height - 40) +'px';

            return pos;
        };

        this._onContainerLayoutChange = function()
        {
            if(BX.type.isElementNode(_this.RESULT_WRAPPER) && _this.RESULT_WRAPPER.style.display !== "none" && _this.RESULT.innerHTML !== '')
                _this.adjustResultNode();
            
        };

        this.SetSearchIn = function()
        {
            searchGet = $(BX.proxy_context);

            searchGet.parents(".show-search-list-parent").find(".search-cur").text(searchGet.text());
            searchGet.parents(".search-list").find('span.search-get').removeClass("active");
            searchGet.parents(".search-list").removeClass('active');
            searchGet.addClass('active');
            searchGet.parents("form.search-form").attr("action", searchGet.attr("data-url"));

            _this.searchIn = searchGet.attr("data-id");

            _this.onChange();
        };

        this.Init = function()
        {

            var parent = document.getElementById("phoenix-container");

            if($("#"+this.arParams.CONTAINER_ID).hasClass('outside-div'))
                parent = document.getElementById("body");
            

            this.searchIn = $("#"+this.arParams.CONTAINER_ID).find(".search-get.active").attr("data-id");

            this.RESULT_WRAPPER = parent.appendChild(document.createElement("DIV"));

            this.RESULT_WRAPPER.className = 'ajax-search-results';

            if($("#"+this.arParams.CONTAINER_ID).hasClass('outside-div'))
                this.RESULT_WRAPPER.className = 'ajax-search-results outside';


            this.RESULT = this.RESULT_WRAPPER.appendChild(document.createElement("DIV"));
            this.RESULT.className = 'ajax-search-results-inner';
            

            this.INPUT = BX(this.arParams.INPUT_ID);
            this.startText = this.oldValue = this.INPUT.value;
            
            BX.bind(this.INPUT, 'focus', function(){_this.onFocusGain()});
            BX.bind(this.INPUT, 'blur', function(){_this.onFocusLost()});

            this.INPUT.onkeydown = this.onKeyDown;
            BX.bind(this.INPUT, 'bxchange', function(){_this.onChange()});

            this.CONTAINER = BX(this.arParams.CONTAINER_ID);
            BX.addCustomEvent(this.CONTAINER, "OnNodeLayoutChange", this._onContainerLayoutChange);

            this.HINT_BTN = BX(this.arParams.CONTAINER_ID+"_hint");


            BX.bind(this.HINT_BTN, 'click', function(){
                
                _this.FOCUS = true;
                BX.focus(_this.INPUT);

                _this.INPUT.value = _this.HINT_BTN.innerHTML;

                if(!$("#"+_this.arParams.CONTAINER_ID).find(".search-panel-js").hasClass('top-panel'))
                    scrollToBlock($("#"+_this.arParams.INPUT_ID).parents(".search-panel-js").find(".search-scroll-focus"), '', 40);
                
                checkInput( $("#"+_this.arParams.INPUT_ID) );

                _this.onChange();

                setTimeout(function(){_this.FOCUS = false;}, 1000);
            });


            var searchGet = this.CONTAINER.querySelectorAll('.search-get');

            if(searchGet.length)
            {
                for (var i = 0; i < searchGet.length; i++)
                    BX.bind(searchGet[i], 'click', BX.delegate(this.SetSearchIn, this));
            }

            

            var fixedParent = BX.findParent(this.CONTAINER, BX.is_fixed);

            if(BX.type.isElementNode(fixedParent))
            {
                BX.bind(window, 'scroll', BX.throttle(this.onScroll, 100, this));
            }
        };

        
        BX.ready(
            function ()
            {
                _this.Init(arParams)
            }
        );
    
}

$(document).on("click", ".show-dialog-map", function()
{
    showProcessLoad();
    $.post(
        '/bitrix/tools/concept.phoenix/ajax/popup/dialog_map.php', 
        {site_id: $("input.site_id").val()}, 
        function(html)
        {
            closeProcessLoad();
            startBlurWrapperContainer();
            
            $("div.modalAreaWindow").html(html);
            
            setTimeout(function()
            {
                $("div.modalAreaWindow").find('.phoenix-modal').addClass('active');
            }, 100);
        
        }
    );
}
);

$(window).on("load", function() 
{


    if(customEvent)
    {
        updateLazyLoad();
    }
    else
    {
        var counter = 0;

        var timerId = setInterval(
            function()
            {
                if(counter > 5)
                    clearInterval(timerId);

                updateLazyLoad();
                counter++;
            },
            1000
        );

        
    }
});

$(document).on("click", ".show-fast-order-form", function()
{
    $(".form-order[data-target='"+$(this).attr("data-target")+"']").addClass('active');
    $(".info-table[data-target='"+$(this).attr("data-target")+"']").removeClass('active');
    $(".hide-fast-order-form[data-target='"+$(this).attr("data-target")+"']").addClass('active');
});

$(document).on("click", ".hide-fast-order-form", function()
{
    $(this).removeClass('active');
    $(".form-order[data-target='"+$(this).attr("data-target")+"']").removeClass('active');
    $(".info-table[data-target='"+$(this).attr("data-target")+"']").addClass('active');
});

$(document).on("click", ".btn-show-sort-board", function()
{
    $(this).children('.sort-dialog-content').addClass('active');
});
$(document).mouseup(function(e) {
    var div = $(".sort-dialog-content");
    if (!div.is(e.target) && div.has(e.target).length === 0) div.removeClass(
        'active');
});

$(document).on("click", ".show-side-menu", function()
{
    $(".wr-transform-to-dialog-by-mob").removeClass('d-none');
    startBlurWrapperContainer();
});
$(document).on("click", ".close-side-menu", function()
{
    $(".wr-transform-to-dialog-by-mob").addClass('d-none');
    stopBlurWrapperContainer();
});

if($(window).width() <= 1024)
{
    $(document).on(
    {
        click: function (){
            $(".soc-groups-in-menu").removeClass('d-none');
        }

        },
        ".show-soc-groups"
    );
}
$(document).on(
{
    click: function (){
        $(".soc-groups-in-menu").addClass('d-none');
    }

    },
    ".close-soc-groups"
);

$(document).mouseup(function(e) {
    var div = $(".soc-groups-in-menu");
    if (!div.is(e.target) && div.has(e.target).length === 0) div.addClass(
        'd-none');
});





var ratingProducts = {},
    ratingProductsParse = {};

$(document).ready(function() {
    getRatingCookie();
    setVoteItems();
});

function setVoteItems(){
    for (key in ratingProductsParse){

        var collectVote =  $(".simple-rating[data-item-id='"+key+"']").children(),
            currentPoint = parseInt(ratingProductsParse[key]);

        $(".simple-rating[data-item-id='"+key+"']").addClass("disabled");

        $(collectVote).each(
            function(index, element)
            {
                if(parseInt($(element).attr("data-point")) <= currentPoint)
                    $(element).addClass('voted');
            }
        );
        
    }
}

function setVoteItem(id, vote){

    var collectVote =  $(".simple-rating[data-item-id='vote-block-"+id+"']").children(),
        currentPoint = parseInt(vote);

    $(".simple-rating[data-item-id='vote-block-"+id+"']").addClass("disabled");
    collectVote.removeClass('voted');

    $(collectVote).each(
        function(index, element)
        {
            if(parseInt($(element).attr("data-point")) <= currentPoint)
                $(element).addClass('voted');
        }
    ); 
}

function issetRatingCookie(id){
    return !(ratingProductsParse[id]  === undefined);
}

function getRatingCookie(){
    ratingProducts = BX.getCookie($(".domen-url-for-cookie").val()+'_phoenix_rating_products');

    if(ratingProducts)
        ratingProductsParse = JSON.parse(ratingProducts);
}
function setRatingCookie(id, vote){
    ratingProductsParse["vote-block-"+id] = vote;
    BX.setCookie($(".domen-url-for-cookie").val()+'_phoenix_rating_products', JSON.stringify(ratingProductsParse), {expires: 60*60*60*60, path: "/"});
}

function setReviewsCountProduct(id, review){
    $(".reviews-count[data-item-id=\""+id+"\"]").html(review);
}
function setRatingProduct(id, rating, selector){

    selector = selector || "";
    var collectVote =  $(selector+".stars_container[data-item-id='vote-block-"+id+"']").children(),
        currentPoint = parseInt(rating);

    $(selector+".stars_container[data-item-id='vote-block-"+id+"']").attr("data-rating", rating);



    if(currentPoint > 5)
        currentPoint = 5;

    else if(currentPoint < 0)
        return false;

    collectVote.removeClass('active');

    $(collectVote).each(
        function(index, element)
        {
            if(parseInt($(element).attr("data-point")) <= currentPoint)
                $(element).addClass('active');
        }
    );

    return true;
}

function showMessageSuccessVote(){

    $('#alert-vote').show();

    var voteAlertTimer = setTimeout(function() {
        $('#alert-vote').hide();
        clearTimeout(voteAlertTimer);
    }, 2000);
}

function updateRatingProduct(id, vote){

    $.ajax({
        url: '/bitrix/tools/concept.phoenix/ajax/update/rating.php',
        type: 'POST',
        data: {
            site_id: $("input.site_id").val(),
            id: id.replace('vote-block-',''),
            vote: vote
        },
        success: function(data){
            if(data.OK == "Y")
            {
                setRatingProduct(data.PRODUCT.ID, data.PRODUCT.RATING);
                setRatingCookie(data.PRODUCT.ID, data.PRODUCT.VOTE);
                setVoteItem(data.PRODUCT.ID, data.PRODUCT.VOTE);
                showMessageSuccessVote();
            }
            
        }
    });
}

$(document).on(
{
    mouseenter: function (){

        if($(this).parent().hasClass('simple-rating') && issetRatingCookie($(this).parent().attr("data-item-id")))
            return false;
        
        var collectVote = $(this).parent().children(),
            currentPoint = parseInt($(this).attr("data-point"));

        collectVote.removeClass('hover');

        $(collectVote).each(
            function(index, element)
            {
                if(parseInt($(element).attr("data-point")) <= currentPoint)
                    $(element).addClass('hover');
            }
           
        );
    },

    mouseleave: function (){
        $(this).parent().children().removeClass('hover');
    }
},
".stars_container.hover .star"
);


$(document).on("click", ".stars_container.simple-rating .star", function()
{
    getRatingCookie();

    if(!issetRatingCookie($(this).parent().attr("data-item-id")))
        updateRatingProduct($(this).parent().attr("data-item-id"), $(this).attr("data-point"));
}
);

$(document).on("click", ".stars_container.full-rating .star", function()
{
    setRatingProduct($(this).parent().attr("data-item-id").replace('vote-block-',''), $(this).attr("data-point"), ".full-rating");


    if($(this).parents(".wr-rating").length>0)
        $(this).parents(".wr-rating").removeClass('has-error');

    if($("input[name='review-vote'][data-item-id='"+$(this).parent().attr("data-item-id")+"']").length>0)
        $("input[name='review-vote'][data-item-id='"+$(this).parent().attr("data-item-id")+"']").val($(this).attr("data-point"));
    
}
);


function setRatingProgress(id, rating){

    var circleParent = $("svg.circle-progress-bar[data-item-id='"+id+"']"),
        circle = circleParent.find("circle.rating-progress-bar"),
        radius = parseInt(circle.css("r")),
        circumference = 2 * Math.PI * radius,
        offset = 0,
        rating = parseFloat(rating).toFixed(1) || 0;

    var color = "";

    if(rating == 0)
        color = "rating-0";

    else if(rating < 1)
        return false;

    else if(rating > 5)
        rating = 5.0;

    

    if(1 <= rating && rating <= 1.8)
        color = "rating-1";
    
    if(1.8 < rating && rating <= 2.8)
        color = "rating-2";

    if(2.8 < rating && rating <= 3.8)
        color = "rating-3";

    if(3.8 < rating && rating <= 4.8)
        color = "rating-4";

    if(4.8 < rating && rating <= 5)
        color = "rating-5";


    offset = circumference - rating / 5 * circumference;

    circle[0].style.strokeDasharray = circumference+" "+circumference;
    circle[0].style.strokeDashoffset = offset;

    circleParent.removeClass('rating-0 rating-1 rating-2 rating-3 rating-4 rating-5');
    circleParent.addClass(color);


    $(".rating-value[data-item-id='"+id+"']").text(rating);

    return true;
}








var noClickLayer = 0;

function openFlyBlock(id)
{
    if(noClickLayer == 0)
        startBlurWrapperContainer();
    
    noClickLayer++;

    $('body').append('<div class="click-ghost-area" data-fly-block-id="'+id+'"></div>');

    $('.fly-block[data-fly-block-id="'+id+'"]').addClass('active');
    
    var tOutShow = setTimeout(function() {
        $('.fly-block[data-fly-block-id="'+id+'"]').addClass('on');

        clearTimeout(tOutShow);
    }, 200);
}

function closeFlyBlock(id)
{
    if(noClickLayer == 1)
        stopBlurWrapperContainer();

    noClickLayer--;

    $('.click-ghost-area[data-fly-block-id="'+id+'"]').remove();
    $('.fly-block[data-fly-block-id="'+id+'"]').removeClass('on');


    var tOutHide = setTimeout(function(){
        $('.fly-block[data-fly-block-id="'+id+'"]').removeClass('active');

        clearTimeout(tOutHide);
    }, 700);
}

$(document).on("click", ".click-ghost-area", function()
{

    if(typeof($(this).attr("data-fly-block-id")) != "undefined")
        closeFlyBlock($(this).attr("data-fly-block-id"));
}
);

function setFlyBlockParams(_this){
    params = null;

    if(_this.hasClass('fly-block-review'))
    {
        params = {
            "PRODUCT_ID": _this.attr("data-product-id"),
            "NAME": $("input.product-"+_this.attr("data-product-id")+"-name").val(),
            "PICTURE_SRC": $("input.product-"+_this.attr("data-product-id")+"-picture-src-small").val(),
            "PATH": "/bitrix/tools/concept.phoenix/ajax/reviews/fly_block_review_html.php"
        };
    }


    return params;
}



var loadingFlyReviewFlag = false;

function loadingFlyReview(){
    loadingFlyReviewFlag = true;
}
function completedFlyReview(){
    loadingFlyReviewFlag = false;
}

function createFlyBlock(id, params){

    if(loadingFlyReviewFlag)
        return false;

    showProcessLoad();

    params = params || null;

    loadingFlyReview();

    $.post(
        params.PATH, 
        {
            site_id: $("input.site_id").val(),
            params: params
        }, 
        function(html)
        {
            closeProcessLoad();
            $('body').append(html);

            setRatingProduct(params.PRODUCT_ID, $(".stars_container.full-rating[data-item-id='vote-block-"+params.PRODUCT_ID+"']").attr("data-rating"), ".full-rating");
            openFlyBlock(id);
            completedFlyReview();

            $('[data-toggle="tooltip-ajax"]').tooltip({
                html:true
            });
        }
    );

}

$(document).on("click", ".open-fly-block", function()
{
    var id = $(this).attr("data-fly-block-id");

    if($('.fly-block[data-fly-block-id="'+id+'"]').length<=0)
    {
        var params = setFlyBlockParams($(this));
        
        createFlyBlock(id, params);
    }
    else
    {
        openFlyBlock(id);
    }

}
);

$(document).on("click", ".close-fly-block", function()
{
    closeFlyBlock($(this).attr("data-fly-block-id"));
}
);


$(document).on(
{
    click: function (){
        var label = $(this).parent();

        if(label.hasClass("selected"))
        {
            label.removeClass("selected");
            $(this).prop('checked', false);
        }
        else
        {
            $("input[type='radio'][name='"+$(this).attr("name")+"']").parent().removeClass("selected");
            label.addClass("selected");  
        }
    },
},
".btn-radio-simple:not(.disabled) input[type='radio']"
);


$(document).on('change', "input.load-file-simple[type='file']",
    function(){

        var inp = $(this);
        var file_list_name = "";

        $(inp[0].files).each(
            function(key){

                if(key == 10)
                    return false;

                if(key != 0)
                    file_list_name += ",&ensp;";

                file_list_name += "<span>"+inp[0].files[key].name+"</span>";
            }
        );


        if(!file_list_name.length)
            return;

        inp.parents('form').addClass('file-download');
        inp.parents('label').find('.area-files-name').html(file_list_name);
        inp.closest('.load-file').removeClass("has-error");

    }
);



$(document).on("focus", ".text-require, .input-simple input[type='email']", function() {
    $(this).removeClass("has-error");
});

function validForm(form, params){

    var valid = true;
    params = params || null;

    if (typeof($("input.agreecheck", form).val()) != "undefined") {
        if (!$("input.agreecheck", form).prop("checked")) {
            $("input.agreecheck", form).parents("div.wrap-agree").addClass("has-error");
            valid = false;
        }
    }

    $("input[type='email'], input[type='text'], input[type='password'], textarea", form).each(
        function(key, value)
        {
            if($(this).hasClass("text-require"))
            {
                if ($(this).val().trim().length <= 0){
                    $(this).val("");
                    $(this).addClass("has-error");
                    valid = false;
                }
            }
            

            else if ($(this).attr("type") == "email" && $(this).val().length > 0) {

                if (!(
                        /^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,15}$/i
                    ).test($(this).val())) {
                    $(this).addClass("has-error");
                    valid = false;
                }
            }
        }
    );

    $(".file-require", form).each(function(key, value)
    {
        if ($(this).parents('.label-require-file').find('span.area-file').hasClass(
                'area-file')) {
            $(this).parents('.label-require-file').addClass("has-error");
            valid = false;
        }
    });

    if(params !== null)
    {

        for (key in params){

            if(params[key].selector.length>0)
            {
                params[key].selector.removeClass('has-error');
                
                if(params[key].value.length<=0)
                {
                    params[key].selector.addClass('has-error');
                    valid = false;
                }
            }
        }
    }


    return valid;
}


function buildFormValues(form, params){

    params = params || null;

    var formSendAll = new FormData();


    if(params){
        for (key in params){
            formSendAll.append(key, params[key]);
        }
    }

    form_arr = form.find(':input,select,textarea').serializeArray();


    for (var i = 0; i < form_arr.length; i++)
    {
        if (form_arr[i].value.length > 0)
            formSendAll.append(form_arr[i].name, form_arr[i].value);
        
        
    };

    if (form.hasClass('file-download'))
    {
        form.find('input[type=file]').each(function(key)
        {

            var inp = $(this);
            var file_list_name = "";

            $(inp[0].files).each(
                function(k){
                    formSendAll.append(inp.attr('name'), inp[0].files[k], inp[0].files[k].name);
                }
            );

        });
    }

    return formSendAll;
}

$(document).on("click", ".btn-submit-review", function()
{
    var form = $(this).parents("form.form-review"),
        load = form.find(".preloader-simple"),
        btn = $(this),
        moderateMode = $("input.review-moderate-mode").val(),
        panelProcess = $(".wr-panel-process", form),
        panelSuccess = $(".wr-panel-success", form),
        footer = $("div.footer", form);

    paramsValid = {
        "rating": {
            "selector": $(".wr-rating", form),
            "value": $(".stars_container", form).attr('data-rating')
        }
    };


    if (!validForm(form, paramsValid))
    {
        formAttentionScroll(form.find('.has-error:first').offset().top - form.offset().top, ".fly-block");
        return false;
    }

    else
    {
        load.addClass('active');
        btn.removeClass('active');

        var params = {
            "send": "Y",
            "site_id": $("input.site_id").val(),
            "VOTE": $(".stars_container", form).attr('data-rating')
        };
        var formSendAll = buildFormValues(form, params);

        var path = "/bitrix/tools/concept.phoenix/ajax/reviews/add.php";


        $.ajax({
            url: path,
            type: "post",
            contentType: false,
            processData: false,
            data: formSendAll,
            dataType: 'json',
            success: function(json)
            {
                if(json.OK == "Y")
                {
                    panelProcess.addClass('d-none');
                    footer.addClass('d-none');
                    panelSuccess.removeClass('d-none');

                    $.ajax({
                        url: "/",
                        type: "post",
                        success: function(json) {}
                    });

                    /*setTimeout(function() {

                        location.href = location.href;
                    }, 3000);*/

                    
                }

                else if(json.OK == "N")
                {
                    load.removeClass('active');
                    btn.addClass('active');
                }
                
            }
        });
    }

    return true;

});

var reviewsLike = {},
    reviewsLikeParse = {};

function setReviewsLike(){

    for (key in reviewsLikeParse){
        $(".review-item[data-review-id='"+key.replace("like-", "")+"']").find(".review-like").addClass('selected');
    }

}

function getReviewsLikeCookie(){
    reviewsLike = BX.getCookie($(".domen-url-for-cookie").val()+'_phoenix_reviewsLike');

    if(reviewsLike)
        reviewsLikeParse = JSON.parse(reviewsLike);
}

function setReviewsLikeCookie(id, value){
    reviewsLikeParse["like-"+id] = value;
    BX.setCookie($(".domen-url-for-cookie").val()+'_phoenix_reviewsLike', JSON.stringify(reviewsLikeParse), {expires: 60*60*60*60, path: "/"});
}

function deleteReviewsLikeCookie(id){
    delete reviewsLikeParse["like-"+id];
    BX.setCookie($(".domen-url-for-cookie").val()+'_phoenix_reviewsLike', JSON.stringify(reviewsLikeParse), {expires: 60*60*60*60, path: "/"});
}


var likeProcess = false;

$(document).on("click", ".review-like", function()
{
    if(likeProcess)
        return false;

    var count = 0,
        btn = $(this),
        reviewNode = $(this).parents(".review-item"),
        reviewID = reviewNode.attr("data-review-id"),
        countLikeNode = reviewNode.find(".review-like-count"),
        countLikeValue = parseInt(countLikeNode.attr("data-count"));

    if($(this).hasClass('selected'))
    {
        count = -1;
    }
    else
    {
        count = 1;
    }
    

    var path = "/bitrix/tools/concept.phoenix/ajax/reviews/update_like.php";

    var formSendAll = new FormData();
    formSendAll.append("REVIEW_ID", reviewID);
    formSendAll.append("LIKE_COUNT", count);
    formSendAll.append("site_id", $("input.site_id").val());

    $.ajax({
        url: path,
        type: "post",
        contentType: false,
        processData: false,
        data: formSendAll,
        dataType: 'json',
        success: function(json)
        {
            likeProcess = false;

            if(json.OK == "Y")
            {
                if(btn.hasClass('selected'))
                {
                    btn.removeClass('selected');
                    deleteReviewsLikeCookie(reviewID);
                }
                else
                {
                    btn.addClass('selected');
                    setReviewsLikeCookie(reviewID, count);
                }

                if(parseInt(json.LIKE_COUNT) > 0)
                {
                    countLikeNode.html("+"+json.LIKE_COUNT);
                    countLikeNode.addClass('plus');
                }
                else
                {
                    countLikeNode.html(0);
                    countLikeNode.removeClass('plus');
                }

                countLikeNode.attr("data-count", json.LIKE_COUNT);

            }
            
        }
    });
});



function ajaxGetReviews(params)
{
    var path = "/bitrix/tools/concept.phoenix/ajax/reviews/reviews_block.php";
    params = params || 0;

    showProcessLoad();

    if(params.this.hasClass('btn-filter'))
        params.this.parents(".group-list-simple").find(".btn-filter").removeClass('selected'); 
    

    $.post(path, 
        {
            site_id: $("input.site_id").val(),
            id: $(".review-block-ajax").attr("data-product-id"),
            page: params.pageNum,
            filter: params.filter,
            mode: "list"

        }, 
        function(html)
        {
            closeProcessLoad();
            
            getReviewsLikeCookie();

            setTimeout(function() {
                setReviewsLike();
            }, 700);
            

            if(params.this.hasClass('getReviews'))
            {
                $(".review-block-ajax .wr-review-list").append(html);
                params.this.remove();
            }
            else if(params.this.hasClass('btn-filter'))
            {
                $(".review-block-ajax .wr-review-list").html(html);
                params.this. addClass('selected');
            }
        }
    );
}

$(document).on("click", ".getReviews", function()
{
    var params = {
        "this": $(this),
        "pageNum": $(this).attr("data-page"),
        "filter": $(this).attr("data-filter"),
    };
    ajaxGetReviews(params);
});

$(document).on("click", ".btn-filter.active:not(.selected)", function()
{
    var params = {
        "this": $(this),
        "pageNum": 0,
        "filter": $(this).attr("data-filter"),
        
    };
    ajaxGetReviews(params);
});



function ajaxReviewsBlock()
{

    if($(".review-block-ajax").length>0)
    {
        var path = "/bitrix/tools/concept.phoenix/ajax/reviews/reviews_block.php";

        $.post(path, 
            {
                site_id: $("input.site_id").val(),
                id: $(".review-block-ajax").attr("data-product-id"),
                mode: "full"
            }, 
            function(html)
            {
                $(".review-block-ajax").html(html);
                getReviewsLikeCookie();
                setReviewsLike();
                $('[data-toggle="tooltip-ajax"]').tooltip({
                    html:true
                });
            }
        );
    }
}

$(document).ready(function() {
    ajaxReviewsBlock();
});

$(document).on("click", ".btn-show-container", function()
{
    $(this).parents(".wr-hidden-container").find(".hidden-container").removeClass('d-none');
    $(this).remove();
});



var arrBasketFilter = {},
    arrDelayFilter = {};


function BasketFilter(query)
{
    query = query || "";

    if(query.length<=0)
        $(".basket-items-search-clear-btn").addClass('d-none');
    else{
        $(".basket-items-search-clear-btn").removeClass('d-none');
    }

    query = query.toLowerCase();

    var realKey = "",
        productName = "",
        arrSearchBasket = {},
        selector = "";


    if($(".tab_item[data-items='items']").hasClass('active'))
    {
        arrSearchBasket = arrBasketFilter;
        selector = $("#basket_items");
    }
    

    if($(".tab_item[data-items='delayed']").hasClass('active'))
    {
        arrSearchBasket = arrDelayFilter;
        selector = $("#delayed_items");
    }

    for (key in arrSearchBasket){

        realKey = key.replace('id_','');

        if(!(arrSearchBasket[key].QUERY.indexOf(query) !== -1))
            selector.find(".product#"+realKey).addClass('d-none').find(".product-name").html(arrSearchBasket[key].NAME);
        

        else{

            productName = arrSearchBasket[key].NAME.slice(arrSearchBasket[key].QUERY.indexOf(query), arrSearchBasket[key].QUERY.indexOf(query) + query.length);
            productName = arrSearchBasket[key].NAME.replace(productName, "<span class='highlight'>"+productName+"</span>");

            selector.find(".product#"+realKey).removeClass('d-none').find(".product-name").html(productName);
        }
    }

    delete arrSearchBasket;
    
    
}


$(document).on(
    {
        keyup: function (){
            BasketFilter($(this).val());
        },

        paste: function (){
            BasketFilter($(this).val());
        },

        cut: function (){
            BasketFilter($(this).val());
        },
        
        blur: function (){
            BasketFilter($(this).val());
        },
    },
    "input.basket-filter"
);


function clearInput(input){
    input.val("").attr("placeholder", input.attr("data-placeholder"));
}

$(document).on(
    {
        click: function (){
            BasketFilter("");
            clearInput($("input.basket-filter"));
        },
    },
    ".basket-items-search-clear-btn"
);

function initPhoneMask()
{
    $(document).on("focus", "form input.phone", 
        function()
        { 
            if(!device.android())
                $(this).mask($("input.mask-phone").val());
        }
    );
}


function getTermination(num, array){
    num = num.toString();
    var number = num.substring(num.length, -2);
    var term = "";

    if(number > 10 && number < 15)
    {
        term = array[3];
    }
    else
    { 
                     
        number = num.substring(num.length, -1);
         
        if(number == 0) {term = array[0];}
        if(number == 1 ) {term = array[1];}
        if(number > 1 ) {term = array[2];}
        if(number > 4 ) {term = array[3];}
    }
     
    return  term;
}


$(document).on("click", ".btn-modal-open", function() {
    cur_pos = $(document).scrollTop();

    var id = $(this).attr('data-element-id');
    var name = $(this).attr('data-detail');
    var btnColor = $(this).attr('data-btn-color');
    var all_id = $(this).attr('data-all-id');
    var section_id = $(this).attr('data-section-id');
    var block_header = $(this).attr('data-header');

    showProcessLoad();

    $.post("/bitrix/tools/concept.phoenix/ajax/popup/modal.php", {
        element_id: id,
        name: name,
        all_id: all_id,
        site_id: $("input.site_id").val(),
        section_id: section_id,
        block_header: block_header,
        btnColor: btnColor
    }, function(html){
        
        $('div.wrap-modal').addClass('open').html(html);
        $('div.wrapper').addClass('blur');
        $('body').addClass('modal-open');
        $('.shadow-detail').addClass('active');
        $(".wrap-modal-inner").addClass('open');
        $('div.no-click-block').addClass('on');
        closeProcessLoad();
    });
});

$(document).on("click", "a.wrap-modal-close", function() {
    $('div.wrap-modal').removeClass('open');
    $('div.no-click-block').removeClass('on');
    $('.shadow-detail').removeClass('active');
    $('body').removeClass('modal-open');
    $('div.wrapper').removeClass('blur');

    if (device.ios())
    {
        window.scrollTo(0, cur_pos);
        $("body").removeClass("modal-ios");
    }
});


function getHtmlStoreList(PRODUCT_ID, STORE_QUANTITY)
{
    if($("input.tab-store").length>0)
    {
        if(BX.type.isArray(STORE_QUANTITY))
        {
            $(".ajax_store_area").html("");
            return true; 
        }

        clearTimeout($.data(this, 'store_block'));

        $.data(this, 'store_block', setTimeout($.proxy(function() {

            showProcessLoadItem("store_block");

            $.ajax({
                url: '/bitrix/tools/concept.phoenix/ajax/store_list.php',
                type: 'POST',
                data: {
                    site_id: $("input.site_id").val(),
                    TAB: $("input.tab-store").val(),
                    PRODUCT_ID: PRODUCT_ID,
                    STORE_QUANTITY: STORE_QUANTITY
                },
                success: function(data){

                    setTimeout(function() {
                        closeProcessLoadItem("store_block");
                        $(".ajax_store_area").html(data);
                    }, 300);

                    
                }
            });
        }, this), 700));
    }
}

$(document).on("click", ".bx_storege .btn-tab", function()
{
    $(".bx_storege").find(".btn-tab").removeClass('active');
    $(".bx_storege").find(".tab-content").addClass('d-none');
    $(this).addClass('active');
    $(".tab-content[data-content='"+$(this).attr("data-content")+"']").removeClass('d-none');
}
);

$(document).on("click", ".bx_storege .list-item.flat", function()
{

    $(".bx_storege").find(".back2list").removeClass('d-none');
    $(".bx_storege").find(".list-item.flat").addClass('d-none');
    $(".bx_storege").find(".detail-item.flat").addClass('d-none');

    $(".detail-item.flat[data-content='"+$(this).attr("data-content")+"']").removeClass('d-none');
}
);


$(document).on("click", ".bx_storege .back2list", function()
{
    $(this).addClass('d-none');
    $(".bx_storege").find(".list-item.flat").removeClass('d-none');
    $(".bx_storege").find(".detail-item.flat").addClass('d-none');
}
);

function preparePopupBlockStore (){
	if($(".popup-block[data-popup='store-block']").length>0)
	{
		var clone = $(".popup-block[data-popup='store-block']").clone();
		$(".popup-block[data-popup='store-block']").remove();
		clone.appendTo('body');
	}
}

$(document).ready(function()
{
	preparePopupBlockStore();
});


PopupWindow = {

    init: function(container, params) {

    	if(container.length<=0)
        	return false;

        params = params || {};

    	if(params.ajax)
    	{
    		console.log('ajax');
    	}	
    	else
    	{
    		PopupWindow.show(container, params);
    	}
    },
    show: function(container, params)
    {

        if(container.hasClass('animated'))
        {



        }
        else
        {
        	container.removeClass("d-none");

    	    var cartOut = setTimeout(function() {
    	        container.addClass('active');
    	        clearTimeout(cartOut);
    	    }, 300);

        }

	    if(params.blur)
    		startBlurWrapperContainer();

        if(params.hideContainer)
            $(params.hideContainer).addClass('d-none');


    },
    hide: function(container, params)
    {
        var timeHide = 300;

        if(container.hasClass('animated'))
        {
            if(container.hasClass('fadeInUp'))
            {
                container.removeClass('fadeInUp');
                if(typeof container.attr("data-animate-out") != "undefined")
                {
                    var animateOut = container.attr("data-animate-out");
                    container.addClass(animateOut);

                    timeHide = 1500;
                }
                
            }
        }
        else
        {
        	container.removeClass('active');
        }

        var cartOut = setTimeout(function() {
            container.addClass('d-none');
            clearTimeout(cartOut);
        }, timeHide);

	    if(params.blur)
	    	stopBlurWrapperContainer();
    }
    
};


$(document).on('click', '.show-popup-block', function() {
	var container = $('.popup-block[data-popup="'+$(this).attr("data-popup")+'"]'),
    	params = {
    		"blur":true,
            "hideContainer": false
    	};

    if(typeof $(this).attr("data-hide-container") != 'undefined')
        params.hideContainer = $(this).attr("data-hide-container");
    

    PopupWindow.init(container, params);
});

$(document).on('click', '.info-right-side .show-popup-block-store', function() {
    var container = $('.popup-block[data-popup="store-block"]'),
    	params = {
    		"blur":true
    	};

    PopupWindow.init(container, params);
});



$(document).on('click', '.hide-popup-block-js', function(){

	var container = $(this).parents(".popup-block"),
    	params = {
    		"blur":true
    	};
    PopupWindow.hide(container, params);
});


function autocompleteRegionAreaSelected(th, ui)
{
    th.parents(".mode-select").addClass('ok');
    

    var favorites = th.parents("form").find("input[type='radio']");

    if(favorites.length>0)
    {
        $(favorites).each(
            function(index, element)
            {
                element.checked = false;
            }
           
        ); 
    }


    th.val( ui.item.label );
    $(".value-region").text(ui.item.label);

    if(ui.item.value.length>0)
    {
        $("input.region-id").val(ui.item.value);
    }
    else
    {
        $("input.region-id").val($("input.region-id-default").val());
    }

    $(".region-popup").find(".left-side").removeAttr('style');

    if(ui.item.icon.length>0)
        $(".region-popup").find(".left-side").css({"background-image": "url("+ui.item.icon+")"});

}


function autocompleteRegionAreaChange(th, flag)
{
    if($("input.autocompleteRegion").val().length>0)
    {
        $("input.autocompleteRegion").parents(".mode-select").addClass('ok');
        $("input.region-id").val($("input.region-id-default").val());


        var favorites = th.parents("form").find("input[type='radio']");

        if(favorites.length>0)
        {
            $(favorites).each(
                function(index, element)
                {
                    element.checked = false;
                }
               
            ); 
        }

    }
    else
    {
        $("input.autocompleteRegion").parents(".mode-select").removeClass('ok');
        $("input.region-id").val($("input.region-id-default").val());
    }
    
}


$(document).on('click', '.region-popup input[type="radio"]', function(){

    var form = $(this).parents("form");
    $("input.region-id").val($(this).val());
    form.find(".mode-select").removeClass('ok');

    $(".region-popup").find(".left-side").removeAttr('style');

    if($(this).attr("data-icon").length>0)
        $(".region-popup").find(".left-side").css({"background-image": "url("+$(this).attr("data-icon")+")"});

    $(".value-region").text($(this).attr("data-label"));
    $("input.autocompleteRegion").val("");

});


$(document).on("focus", "input.autocompleteRegion", function() {
    if ($(this).val().length <= 0) {
        $(this).parents(".mode-select").removeClass('ok');
    }
});
$(document).on("blur", "input.autocompleteRegion", function() {
    if ($(this).val().length <= 0) {
        $(this).parents(".mode-select").removeClass('ok');
    }
});



function setCookieRegion(regionID)
{
    BX.setCookie($(".domen-url-for-cookie").val()+'_phoenixRegion'+$("input.site_id").val(), regionID, {
        expires: 60 * 60 * 60
    });


    if($("input.autocompleteRegion").parent().hasClass('ok'))
    {
        var regionName = $("input.autocompleteRegion").val();

        if(regionName.length>0)
        {
            BX.setCookie($(".domen-url-for-cookie").val()+'_phoenixRegionName'+$("input.site_id").val(), regionName, {
                expires: 60 * 60 * 60
            });
        }
    }
}

$(document).on("click", ".submit-region", function()
{
    
    var regionID = $("input.region-id").val(),
        regionFirstID = $("input.region-first-id").val(),
        regionDefaultID = $("input.region-id-default").val(),
        container = $(this).parents(".popup-block"),
        params = {
            "blur":true
        };
        

    regionID = regionID || regionDefaultID;

    setCookieRegion(regionID);

    if(regionID!=regionFirstID)
    {
        if(regionDomains)
        {
            if(regionDomains["id_"+regionID])
            {

                BX.setCookie($(".domen-url-for-cookie").val()+'_phoenixRegionName'+$("input.site_id").val(), "", {
                    expires: -1
                });

                setTimeout(function() {
                    location.href = regionDomains["id_"+regionID];
                }, 1000);
            }
            else
            {
                setTimeout(function() {
                    location.href = location.href;
                }, 1000);
            }
        }
        else
        {
            setTimeout(function() {
                location.href = location.href;
            }, 1000);
        }
    }
    else{

        if($("input.autocompleteRegion").parent().hasClass('ok'))
        {
            var regionName = $("input.autocompleteRegion").val();

            if(regionName.length>0)
                $(".value-region").html(regionName);
            
        }
        PopupWindow.hide(container, params);
    }
}

);

$(document).ready(function() {
	$('.fancybox').fancybox();
});