<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php"); 
$APPLICATION->SetPageProperty("fluid_container", "-fluid");
$APPLICATION->SetTitle("Галерея Beretta Premium");?>
<?Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/plugins/fancybox-2.1.7/source/jquery.fancybox.pack.js?v=2.1.5');?>
<?Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/js/plugins/fancybox-2.1.7/source/jquery.fancybox.css?v=2.1.5');?>
<?//Bitrix\Main\Page\Asset::getInstance()->addJs('/beretta/script_b.js');?>
<?Bitrix\Main\Page\Asset::getInstance()->addJs('/local/templates/kolchuga_2016/js/jquery.touchSwipe.min.js');?>
<?Bitrix\Main\Page\Asset::getInstance()->addCss('/beretta/style_b.css?'.time());?>

<div class="row">

<section class="block_lend_ban container-fluid mb-5 ">
	<div class="row">
		<div class="col-12 text-center">					
				<img src="/images/bereta/DSC_0149_1_1.jpg"  >
				<div class="block_bereta_1 opis">
					<h3 class="mb-5 grey">Beretta SO10</h3>	
					<h4 class="grey">Бокфлинт премиум-класса</h4>
				</div>
		</div>
				
	</div>
</section>
<section class="block_lend_anons container mb-5 ">
	<div class="row">
		<div class="col-1 text-center"></div>
		<div class="col-10 grey text-center">					
			<p>Ружье Beretta SO10 - премиальный бокфлинт с авторской гравировкой. Ствольная коробка ружья подвергнута специальной никелированной обработке, повышающей уровень ее прочности и износостойкости. Приклад посажен на ствольную коробку без шва. Спусковой механизм позолочен, а также защищен от негативных внешних воздействий при помощи технического полимера, изготовленного из усиленного стекловолокна.</p>
			
		</div>
		<div class="col-1 text-center"></div>
	</div>
</section>

<section class="block_lend_slider container mb-5 ">
	<div class="row">
		
		<div class="col-12 ">					
			<div id="slider" class="flexslider ">
 <ul class="slides">
 <li class="block_slide_content"> <img src="/images/bereta/8U2A9066_2_1_b.jpg"> </li>
 <li class="block_slide_content"> <img src="/images/bereta/09-H1IM6G1TeW0.jpg"> </li>
 <li class="block_slide_content"> <img src="/images/bereta/10-f3Ab4OOLb_c.jpg"> </li>
  <li class="block_slide_content"> <img src="/images/bereta/8U2A9066_2_1_b.jpg"> </li>
 <li class="block_slide_content"> <img src="/images/bereta/09-H1IM6G1TeW0.jpg"> </li>
 <li class="block_slide_content"> <img src="/images/bereta/10-f3Ab4OOLb_c.jpg"> </li>
 </ul>
 </div>
 <div id="carousel" class="flexslider ">
 <ul class="slides">
 <li> <img src="/images/bereta/8U2A9066_2_1_b.jpg"> </li>
 <li> <img src="/images/bereta/09-H1IM6G1TeW0.jpg"> </li>
 <li> <img src="/images/bereta/10-f3Ab4OOLb_c.jpg"> </li>
  <li> <img src="/images/bereta/8U2A9066_2_1_b.jpg"> </li>
 <li> <img src="/images/bereta/09-H1IM6G1TeW0.jpg"> </li>
 <li> <img src="/images/bereta/10-f3Ab4OOLb_c.jpg"> </li>
 </ul>
 </div>
			
			<script>
			$(document).ready(function() {
 $('#carousel').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth:300,
    asNavFor: '#slider',
 easing: 'easeInElastic',
  });
 
  $('#slider').flexslider({
    animation: "slide",
			slideshow: false,
			slideshowSpeed: 5000,
			animationSpeed: 700,
			controlNav: false,
    sync: "#carousel",
 easing: 'easeInElastic',
  });
});
</script>
<style>
.block_slide_content {margin-right: -100px !important;
    margin-left: 110px !important;
    padding-left: 60px !important;
    padding-right: 50px !important;}

</style>
		</div>
		
	</div>
</section>

<section class="block_lend_srav container mb-5 ">
	<div class="row">
		<div class="col-12 text-center mb-5">
			<h4 class="grey">Характеристики</h4>
		</div>
		<div class="col-12">
			<table class="table table-bordered">
			  <thead>
				<tr>
				  <th scope="col" class='first' >Beretta SO10</th>
				  <th scope="col" >Цена</th>
				  <th scope="col" >Наличие</th>
				  <th scope="col" >Калибр</th>
				  <th scope="col" >Длина ствола</th>
				  <th scope="col" >Емкость магазина</th>
				  <th scope="col" >Патронник</th>
				  <th scope="col" >Дульные насадки</th>
				</tr>
			  </thead>
			  <tbody>
				<tr>
				  <td class='center'>Beretta SO5 Sport plus 12/76, 76 OCHP</td>
				  <td class='center'>1 726 704 руб</td>
				  <td class='center'>+</td>
				  <td class='center'>12</td>
				  <td class='center'>760 мм</td>
				  <td class='center'>2+1</td>
				  <td class='center'>76 мм</td>
				  <td class='center'>1/1, Cyl, 1/2 (ОСHP)</td>
				</tr>
				<tr>
				  <td class='center'>Beretta SO5 Sport plus 12/76, 76 OCHP</td>
				  <td class='center'>1 726 704 руб</td>
				  <td class='center'>+</td>
				  <td class='center'>12</td>
				  <td class='center'>760 мм</td>
				  <td class='center'>2+1</td>
				  <td class='center'>76 мм</td>
				  <td class='center'>1/1, Cyl, 1/2 (ОСHP)</td>
				</tr>
				
			  </tbody>
			</table>
		</div>
	</div>
</section>

<section class="block_lend_komplect container mb-5 ">
	<div class="row">
		<div class="col-8 text-center mb-5">
			
		</div>
		<div class="col-4">
			<h4 class="grey mb-5">Комплектация:</h4>
			<ol>
				<li>Кейс из натуральной кожи;</li>
				<li>Сменные дульные насадки и ключ для их замены;</li>
				<li>Масло для чистки.</li>
			</ol>
			<div>На кейске есть замок с кодом. Логотип выполен тиснением на крышке. </div>
		</div>
	</div>
</section>

<section class="block_lend_seo container mb-5 ">
	<div class="row">
		<div class="col-12">
			
			<div>Ружье Beretta SO10 - премиальный бокфлинт с авторской гравировкой. Ствольная коробка ружья подвергнута специальной никелированной обработке, повышающей уровень ее прочности и износостойкости. Приклад посажен на ствольную коробку без шва. Спусковой механизм позолочен, а также защищен от негативных внешних воздействий при помощи технического полимера, изготовленного из усиленного стекловолокна </div>
		</div>
	</div>
</section>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"beretta_2",
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
		"IBLOCK_ID" => "68",
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
		"PAGE_ELEMENT_COUNT" => "2",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PROPERTY_CODE" => array("TOVAR", ""),
		"SECTION_CODE" => "",
		"SECTION_ID" => "18381",
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
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>