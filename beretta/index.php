<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("fluid_container", "-fluid");
$APPLICATION->SetTitle("Галерея бренда Beretta – премиальное оружие в салоне «Кольчуга»");
$APPLICATION->SetPageProperty('description', 'Московская Галерея Beretta была открыта в 2013 году в центральном оружейном салоне «Кольчуга». Формат shop-in-shop позволил органично представить все модельные линейки оружия Beretta, а так же предложить посетителям галереи комфортные условия для подбора фирменной одежды, обуви и аксессуаров для охоты и спортивной стрельбы.');
?>
<?Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/plugins/fancybox-2.1.7/source/jquery.fancybox.pack.js?v=2.1.5');?>
<?Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/js/plugins/fancybox-2.1.7/source/jquery.fancybox.css?v=2.1.5');?>
<?Bitrix\Main\Page\Asset::getInstance()->addJs('/beretta/script_b.js');?>
<?Bitrix\Main\Page\Asset::getInstance()->addCss('/beretta/style_b.css?'.time());?>

<div class="row">

<section class="block_bereta_info container-fluid  ">
	<nav class="navbar navbar-expand-lg navbar-dark bg-none navbar-mobile fixed-top affix-top pb-0 pt-0 main-nav main-nav-bg-none">
		<a class="navbar-brand" href="/beretta/">
			<img src="/images/bereta/pb-logo-sm.png"><img src="/images/bereta/ber-toplogo.png" style="max-height:32px" class="pl-2">
		</a>
		<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerbr" aria-controls="navbarTogglerbr" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="navbar-collapse collapse" id="navbarTogglerbr" style="">
			<span class="text-light"></span>
			<ul class="navbar-nav abs-center-x">
				<li class="nav-item dropdown1"><a class="nav-link dropdown-toggle1" href="/beretta/premium.php">Премиальное оружие</a></li>
				<li class="nav-item"><a class="nav-link" href="/weapons_salons/?salonfilter=112&salonfilter465=763119#product">Все товары галереи</a></li>
			</ul>
		</div>
	</nav>
</section>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.element",
	"beretta_baner1",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_DETAIL_TO_SLIDER" => "N",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_TO_BASKET_ACTION" => array("BUY"),
		"ADD_TO_BASKET_ACTION_PRIMARY" => array("BUY"),
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BRAND_USE" => "N",
		"BROWSER_TITLE" => "-",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_SECTION_ID_VARIABLE" => "N",
		"COMPATIBLE_MODE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_PICTURE_MODE" => array("POPUP", "MAGNIFIER"),
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PREVIEW_TEXT_MODE" => "E",
		"ELEMENT_CODE" => "",
		"ELEMENT_ID" => "698274",
		"GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
		"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
		"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
		"GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_MESS_BTN_BUY" => "Выбрать",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_IMAGE" => "Y",
		"GIFTS_SHOW_NAME" => "Y",
		"GIFTS_SHOW_OLD_PRICE" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "69",
		"IBLOCK_TYPE" => "banners",
		"IMAGE_RESOLUTION" => "16by9",
		"LABEL_PROP" => array(),
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"LINK_IBLOCK_ID" => "",
		"LINK_IBLOCK_TYPE" => "",
		"LINK_PROPERTY_SID" => "",
		"MAIN_BLOCK_PROPERTY_CODE" => array(),
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_COMMENTS_TAB" => "Комментарии",
		"MESS_DESCRIPTION_TAB" => "Описание",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"MESS_PRICE_RANGES_TITLE" => "Цены",
		"MESS_PROPERTIES_TAB" => "Характеристики",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_LIMIT" => "0",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_INFO_BLOCK_ORDER" => "sku,props",
		"PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",
		"PRODUCT_PROPERTIES" => array(),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array("", ""),
		"SECTION_CODE" => "",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_CANONICAL_URL" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SET_VIEWED_IN_COMPONENT" => "N",
		"SHOW_404" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DEACTIVATED" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_COMMENTS" => "N",
		"USE_ELEMENT_COUNTER" => "Y",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_GIFTS_DETAIL" => "Y",
		"USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"USE_RATIO_IN_RANGES" => "N",
		"USE_VOTE_RATING" => "N"
	)
);?>
<section class="block_bereta_1 container-fluid mb-5 ">
	<div class="row">
		<div class="col-12 text-center">					
				<img src="/images/bereta/lineart.png"  >
				<h3 class="mt-5 grey">Галерея Beretta в Москве</h3>		 
		</div>			
	</div>
</section>
<section class="block_bereta_karta container-fluid mb-5 ">
	<div class="row">
		<div class="col-12 text-center">					
				<div id="yandexMap" style=""></div>	 
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

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"slidbereta",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "70",
		"IBLOCK_TYPE" => "services",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LINE_ELEMENT_COUNT" => "3",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_LIMIT" => "5",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "18",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PROPERTY_CODE" => array("TOVAR", ""),
		"SECTION_CODE" => "",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array("", ""),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N"
	)
);?>


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
				<div class="main__btn"><a href="/beretta/premium.php">Премиальное оружие галереи Beretta</a></div>			 
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
				<img src="/images/bereta/gallery-guns.jpg"  >					 
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

</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>