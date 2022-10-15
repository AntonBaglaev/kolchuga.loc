<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("fluid_container", "-fluid");
$APPLICATION->SetTitle("Beretta");
?>
<link rel="stylesheet" href="/beretta/style_b.css?<?=time()?>">
<div class="row">

<section class="block_bereta_info container-fluid  ">
	<nav class="navbar navbar-expand-lg navbar-dark bg-none navbar-mobile fixed-top affix-top pb-0 pt-0 main-nav main-nav-bg-none">
		<a class="navbar-brand" href="/weapons_salons/">
			<img src="/images/bereta/pb-logo-sm.png"><img src="/images/bereta/ber-toplogo.png" style="max-height:32px" class="pl-2">
		</a>
		<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerbr" aria-controls="navbarTogglerbr" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="navbar-collapse collapse" id="navbarTogglerbr" style="">
			<span class="text-light"></span>
			<ul class="navbar-nav abs-center-x">
				<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="customisation">Премиальное оружие</a></li>
				<li class="nav-item"><a class="nav-link" href="/weapons_salons/?salonfilter=112&salonfilter465=763119#product">Все товары галереи</a></li>
			</ul>
		</div>
	</nav>
</section>
<section class="block_bereta_baner container-fluid mb-5 ">
	<div class="row">
		<div class="col-12 pr-0 pl-0">					
				<img src="/images/bereta/19_1.jpg"  >
				<img src="/images/bereta/logo_s.png" class="homelogo"  >
				<h3 class="serif-header pt-3 pb-3  d-none d-sm-block">Москва, ул. Вараварка, д.3</h3> 
		</div>			
	</div>
</section>
<section class="block_bereta_1 container-fluid mb-5 ">
	<div class="row">
		<div class="col-12 text-center">					
				<img src="/images/bereta/lineart.png"  >
				<h3 class="mt-5">Галерея Beretta в Москве</h3>		 
		</div>			
	</div>
</section>
<section class="block_bereta_karta container-fluid mb-5 ">
	<div class="row">
		<div class="col-12 text-center">					
				<div id="yandexMap" style="width:100%;height:400px;"></div>	 
				<script type="text/javascript" src="//api-maps.yandex.ru/2.1/?apikey=1cff83b8-af68-42b5-b57b-40e170f40831&lang=ru_RU"></script>
    <script type="text/javascript">
    BX.ready(BX.defer(function(){
      ymaps.ready(function () {
        var points = [];

        var myMap = new ymaps.Map('yandexMap', { center: [55.751798, 37.621564], zoom: 15, controls: [] }, {} );

        var clusterer = new ymaps.Clusterer({
          preset: 'islands#invertedNightClusterIcons',
          clusterNumbers: [100],
          clusterIconContentLayout: null
        });

        store1 = new ymaps.Placemark([55.752703, 37.626214],                        
									{
										clusterCaption: 'ул. Варварка, 3',
										balloonContentBody: '<div style="margin: 10px;">'
										+ '<b>ул. Варварка, 3</b> <br/>' 
										+ ' Гостиный двор<br>'
										+ '	Пн-пт: 10:00-19:00; Сб: 10:00-17:00; Вс: выходной<br>'
										+ '</div>'
									},
									{
										
										preset: 'islands#nightDotIcon',								
										
									}
								);

								points.push(store1);
							
        clusterer.add(points);
        myMap.geoObjects.add(clusterer);
        /*myMap.setBounds(clusterer.getBounds(), { checkZoomRange: true });*/
      });
    }));
    </script>
		</div>			
	</div>
</section>


<section class="block_bereta_slider container mb-5">
	<div class="row">
		<div class="col-12  ">					
			<div class="recommend owl-carousel owl-theme js_recommend">
				<?//foreach($arResult['ITEMS'] as $arItem):?>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c4a2316da240321b74dddcadd51af964.jpg" alt="<?=$arItem['NAME']?>">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c867094acda335a317fbbe11c41feee0.jpg" alt="<?=$arItem['NAME']?>">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c4a2316da240321b74dddcadd51af964.jpg" alt="<?=$arItem['NAME']?>">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c867094acda335a317fbbe11c41feee0.jpg" alt="<?=$arItem['NAME']?>">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c4a2316da240321b74dddcadd51af964.jpg" alt="<?=$arItem['NAME']?>">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c867094acda335a317fbbe11c41feee0.jpg" alt="<?=$arItem['NAME']?>">
							</a>
						</div>                
					</div>
				<?//endforeach;?>
			</div>			 
		</div>			
	</div>
</section>

<section class="block_bereta_anons container mb-5">
	<div class="row">
		<div class="col-12 pr-0 pl-0 text-center">					
				<p>Московская Галерея Beretta была открыта в 2013 году в центральном оружейном салоне «Кольчуга».<br> 
Формат shop-in-shop позволил органично представить все модельные линейки оружия Beretta, а так же предложить посетителям галереи комфортные условия для подбора фирменной одежды, обуви и аксессуаров для охоты и спортивной стрельбы. </p>				 
		</div>			
	</div>
</section>



<section class="block_bereta_anons container mb-5">
	<div class="row justify-content-center">
		<div class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-xl-4 ">					
				<div class="main__btn"><a href="/">Премиальное оружие галереи Beretta</a></div>			 
		</div>			
	</div>
</section>
<section class="block_bereta_anons container mb-5">	
		<div class="row justify-content-center">
			<div class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-xl-4">				
				<small><div class="card">
				  <!-- Default panel contents -->
					<div class="card-header text-center">Часы работы галереи:</div>
						<!-- List group -->
						<ul class="list-group opening-hours text-left">
							<li class="list-group-item">ПН-СБ <span class="pull-right">10:00 - 20:00</span></li>
							<li class="list-group-item">ВС <span class="pull-right">10:00 - 17:00</span></li>
						</ul>
						
				</div>	</small>
			</div>
		</div>
	
</section>
<section class="block_bereta_anons container mb-5">
	<div class="row justify-content-center">
		<div class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-xl-4 ">					
				<div class="main__btn"><a href="/weapons_salons/?salonfilter=112&salonfilter465=763119#product">Все товары галереи Beretta</a></div>			 
		</div>			
	</div>
</section>

<section class="block_bereta_form container mb-5">
	<div class="row">
		<div class="col-12 pr-0 pl-0 text-center">					
				<p>Свяжитесь с галерей Beretta в Москве<br>
по тел.: +7 (495) 234-34-43 или заполните форму ниже </p>				 
		</div>			
	</div>
	<div class="row justify-content-center">
			<div class="col-md-8">
				
						
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"salon",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "Y",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => Array(),
		"WEB_FORM_ID" => 7
	)
);?>
			</div>
			
		</div>
</section>






<section class="block_bereta_baner_foot container-fluid ">
	<div class="row">
		<div class="col-12 pr-0 pl-0 ">					
				<img src="/images/bereta/8U2A9064_1.jpg"  >					 
		</div>			
	</div>
</section>
<section class="block_bereta_foot container-fluid ">
	<div class="row">
		<div class="col-12 text-center pb-5 pt-5">					
				<img src="/images/bereta/pb-logo.png"  >					 
		</div>	
		<div class="col-12 text-center pb-5 blok_txt">					
				<p>Посетите Галерею Beretta в Москве</p>					 
		</div>		
	</div>
</section>

</div>
<script>
$(document).ready(function(){
	$(window).scroll(function(){
		if($(this).scrollTop()>300){
			$('.block_bereta_info').addClass('menufixed');
		}else if ($(this).scrollTop()<300){
			$('.block_bereta_info').removeClass('menufixed');
		}
	});
});
</script>


<section class="container-fluid ">
	<div class="row">
		<div class="col-12">	

<div id="sync1" class="owl-carousel owl-theme">
    <div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c4a2316da240321b74dddcadd51af964.jpg" alt="<?=$arItem['NAME']?>">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c867094acda335a317fbbe11c41feee0.jpg" alt="<?=$arItem['NAME']?>">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c4a2316da240321b74dddcadd51af964.jpg" alt="<?=$arItem['NAME']?>">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c867094acda335a317fbbe11c41feee0.jpg" alt="<?=$arItem['NAME']?>">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c4a2316da240321b74dddcadd51af964.jpg" alt="<?=$arItem['NAME']?>">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c867094acda335a317fbbe11c41feee0.jpg" alt="<?=$arItem['NAME']?>">
							</a>
						</div>                
					</div>
</div>

<div id="sync2" class="owl-carousel owl-theme">
    <div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c4a2316da240321b74dddcadd51af964.jpg" alt="<?=$arItem['NAME']?>" width="50%">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c867094acda335a317fbbe11c41feee0.jpg" alt="<?=$arItem['NAME']?>" width="50%">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c4a2316da240321b74dddcadd51af964.jpg" alt="<?=$arItem['NAME']?>" width="50%">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c867094acda335a317fbbe11c41feee0.jpg" alt="<?=$arItem['NAME']?>" width="50%">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c4a2316da240321b74dddcadd51af964.jpg" alt="<?=$arItem['NAME']?>" width="50%">
							</a>
						</div>                
					</div>
					<div class="recommend__item">            
						<div class="recommend__img">
							<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
								<img src="/images/bereta/c867094acda335a317fbbe11c41feee0.jpg" alt="<?=$arItem['NAME']?>" width="50%">
							</a>
						</div>                
					</div>
</div>
</div>		
	</div>
</section>
<style>
#sync1 {
  .item {
    background: #0c83e7;
    padding: 80px 0px;
    margin: 5px;
    color: #fff;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    text-align: center;
  }
}

#sync2 {
  .item {
    background: #c9c9c9;
    padding: 10px 0px;
    margin: 5px;
    color: #fff;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    text-align: center;
    cursor: pointer;
    h1 {
      font-size: 18px;
    }
  }
  .current .item {
    background: #0c83e7;
  }
}

.owl-theme {
  .owl-nav {
    /*default owl-theme theme reset .disabled:hover links */
    [class*="owl-"] {
      transition: all 0.3s ease;
      &.disabled:hover {
        background-color: #d6d6d6;
      }
    }
  }
}

//arrows on first carousel
#sync1.owl-theme {
  position: relative;
  .owl-next,
  .owl-prev {
    width: 22px;
    height: 40px;
    margin-top: -20px;
    position: absolute;
    top: 50%;
  }
  .owl-prev {
    left: 10px;
  }
  .owl-next {
    right: 10px;
  }
}

</style>
<script>
$(document).ready(function() {

    var sync1 = $("#sync1");
    var sync2 = $("#sync2");
    var slidesPerPage = 6; //globaly define number of elements per page
    var syncedSecondary = true;

    sync1.owlCarousel({
        items: 3,
        slideSpeed: 2000,
        nav: true,
      center: true,
        autoplay: false, 
        dots: false,
        loop: true,
        responsiveRefreshRate: 200,
        navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>', '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
    }).on('changed.owl.carousel', syncPosition);

    sync2
        .on('initialized.owl.carousel', function() {
            sync2.find(".owl-item").eq(0).addClass("current");
        })
        .owlCarousel({
            items: slidesPerPage,
            dots: false,
            nav: true,
            smartSpeed: 200,
            slideSpeed: 500,
            slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
            responsiveRefreshRate: 100
        }).on('changed.owl.carousel', syncPosition2);

    function syncPosition(el) {
        //if you set loop to false, you have to restore this next line
        //var current = el.item.index;

        //if you disable loop you have to comment this block
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - (el.item.count / 2) - .5);

        if (current < 0) {
            current = count;
        }
        if (current > count) {
            current = 0;
        }

        //end block

        sync2
            .find(".owl-item")
            .removeClass("current")
            .eq(current)
            .addClass("current");
        var onscreen = sync2.find('.owl-item.active').length - 1;
        var start = sync2.find('.owl-item.active').first().index();
        var end = sync2.find('.owl-item.active').last().index();

        if (current > end) {
            sync2.data('owl.carousel').to(current, 100, true);
        }
        if (current < start) {
            sync2.data('owl.carousel').to(current - onscreen, 100, true);
        }
    }

    function syncPosition2(el) {
        if (syncedSecondary) {
            var number = el.item.index;
            sync1.data('owl.carousel').to(number, 100, true);
        }
    }

    sync2.on("click", ".owl-item", function(e) {
        e.preventDefault();
        var number = $(this).index();
        sync1.data('owl.carousel').to(number, 300, true);
    });
});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>