jQuery(document).ready(function(){

  
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
  
});