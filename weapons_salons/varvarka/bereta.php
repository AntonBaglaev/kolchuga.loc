<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("tags", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords_inner", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords", "Оружейный магазин в центре москвы, продажа оружия и аксессуаров");
$APPLICATION->SetPageProperty("description", "Оружейный салон на Варварке");
$APPLICATION->SetPageProperty("fluid_container", "-fluid");
$APPLICATION->SetTitle("Варварка");
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
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>