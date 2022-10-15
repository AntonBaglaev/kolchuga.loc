<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php"); 
$APPLICATION->SetPageProperty("fluid_container", "-fluid");
$APPLICATION->SetTitle("Галерея Beretta Premium");?>
<?Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/plugins/fancybox-2.1.7/source/jquery.fancybox.pack.js?v=2.1.5');?>
<?Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/js/plugins/fancybox-2.1.7/source/jquery.fancybox.css?v=2.1.5');?>
<?//Bitrix\Main\Page\Asset::getInstance()->addJs('/beretta/script_b.js');?>
<?Bitrix\Main\Page\Asset::getInstance()->addJs('/local/templates/kolchuga_2016/js/jquery.touchSwipe.min.js');?>
<?Bitrix\Main\Page\Asset::getInstance()->addCss('/beretta/style_b.css?'.time());?>



<?Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/plugins/slick/slick.js');?>
<?Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/plugins/slick/slick.css');?>
<?Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/plugins/slick/slick-theme.css');?>


 
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

<section class="block_lend_slider container-fluid mb-5 ">
	<div class="row">
		
		<div class="col-12 ">					
<div class="slider-wrap1">
  <ul class="slider-for">
  <li class="block_slide_content"> <img src="/upload/iblock/9e5/9e5c094f82425c8b87a751d03861d7e9.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/a74/a7438a40b5212a36c2d7fd1a0985ddb8.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/64b/64b086522609d87bbab31f81c1a6c3be.jpg"> </li>
  <li class="block_slide_content"> <img src="/upload/iblock/9e5/9e5c094f82425c8b87a751d03861d7e9.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/a74/a7438a40b5212a36c2d7fd1a0985ddb8.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/64b/64b086522609d87bbab31f81c1a6c3be.jpg"> </li>
 </ul>

  <ul class="slider-nav">
  <li class="block_slide_content"> <img src="/upload/iblock/9e5/9e5c094f82425c8b87a751d03861d7e9.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/a74/a7438a40b5212a36c2d7fd1a0985ddb8.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/64b/64b086522609d87bbab31f81c1a6c3be.jpg"> </li>
  <li class="block_slide_content"> <img src="/upload/iblock/9e5/9e5c094f82425c8b87a751d03861d7e9.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/a74/a7438a40b5212a36c2d7fd1a0985ddb8.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/64b/64b086522609d87bbab31f81c1a6c3be.jpg"> </li>
 </ul>
  </div>
			
			<script>
			$(document).ready(function() {
  $('.slider-wrap1 .slider-for').slick({
  asNavFor: '.slider-wrap1 .slider-nav',
 variableWidth: true,
        centerPadding: '80px',
        centerMode: true,
        slidesToShow: 1,
        slidesToScroll: 1,
		lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true,
		arrows: false,
});
$('.slider-wrap1 .slider-nav').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  asNavFor: '.slider-wrap1 .slider-for',
  dots: false,
  centerMode: true,
  focusOnSelect: true,
  centerPadding: '80px',
  lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true,
		responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
});
});
</script>
<style>
.slider-wrap1 .slider-for, .slider-wrap1 .slider-nav{display:none;}
.slider-wrap1 .slider-for.slick-initialized, .slider-wrap1 .slider-nav.slick-initialized{display:block;}
.slider-wrap1 .slick-arrow:before{color:gray;}
.slider-wrap1{width:95%;margin:0 auto;}
.slider-wrap1 .slick-slide {   margin: 0px 20px;  }

    .slider-wrap1 .slider-for .slick-slide img {
      max-width: 600px;
    }
	.slider-wrap1 .slider-nav .slick-slide img {
      width: 100%;
    }

    .slider-wrap1 .slick-prev:before,
    .slider-wrap1 .slick-next:before {
      color: black;
    }


    .slider-wrap1 .slick-slide {
      transition: all ease-in-out .3s;
      opacity: .2;
    }
    
    .slider-wrap1 .slick-active {
      opacity: .5;
    }

    .slider-wrap1 .slick-current {
      opacity: 1;
    }
	@media (min-width: 1000px){
	.slider-wrap1 .slider-for .slick-current.slick-active{border: 1px solid #14315C;padding: 1px;}
	}
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
		<div class="table-responsive">
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
	</div>
</section>

<section class="block_lend_komplect container mb-5 ">
	<div class="row">
		<div class="col-12 col-md-8 text-center mb-5">
			
			<div class="slider-wrap2">
  <ul class="slider-for">
  <li class="block_slide_content"> <img src="/upload/iblock/9e5/9e5c094f82425c8b87a751d03861d7e9.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/a74/a7438a40b5212a36c2d7fd1a0985ddb8.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/64b/64b086522609d87bbab31f81c1a6c3be.jpg"> </li>
  <li class="block_slide_content"> <img src="/upload/iblock/9e5/9e5c094f82425c8b87a751d03861d7e9.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/a74/a7438a40b5212a36c2d7fd1a0985ddb8.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/64b/64b086522609d87bbab31f81c1a6c3be.jpg"> </li>
 </ul>

  <ul class="slider-nav">
  <li class="block_slide_content"> <img src="/upload/iblock/9e5/9e5c094f82425c8b87a751d03861d7e9.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/a74/a7438a40b5212a36c2d7fd1a0985ddb8.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/64b/64b086522609d87bbab31f81c1a6c3be.jpg"> </li>
  <li class="block_slide_content"> <img src="/upload/iblock/9e5/9e5c094f82425c8b87a751d03861d7e9.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/a74/a7438a40b5212a36c2d7fd1a0985ddb8.jpg"> </li>
<li class="block_slide_content"> <img src="/upload/iblock/64b/64b086522609d87bbab31f81c1a6c3be.jpg"> </li>
 </ul>
  </div>
			
			<script>
			$(document).ready(function() {
  $('.slider-wrap2 .slider-for').slick({
  asNavFor: '.slider-wrap2 .slider-nav',
 variableWidth: true,
        centerMode: true,
        slidesToShow: 1,
        slidesToScroll: 1,
		lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true,
		arrows: true,
});
$('.slider-wrap2 .slider-nav').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  asNavFor: '.slider-wrap2 .slider-for',
  dots: false,
  centerMode: true,
  focusOnSelect: true,
  centerPadding: '40px',
  lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true,
		responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
});
});
</script>
<style>
.slider-wrap2 .slider-for, .slider-wrap2 .slider-nav{display:none;padding-left:0;}
.slider-wrap2 .slider-for.slick-initialized, .slider-wrap2 .slider-nav.slick-initialized{display:block;}
.slider-wrap2 .slick-arrow:before{color:gray;}
.slider-wrap2{width:95%;margin:0 auto;}


    
	.slider-wrap2 .slick-slide img {
      width: 100%;
    }

    .slider-wrap2 .slick-prev:before,
    .slider-wrap2 .slick-next:before {
      color: black;
    }


    .slider-wrap2 .slick-slide {
      transition: all ease-in-out .3s;
      opacity: .2;
    }
    
    .slider-wrap2 .slick-active {
      opacity: .5;
    }

    .slider-wrap2 .slick-current {
      opacity: 1;
    }
	@media (min-width: 1000px){
	.slider-wrap2 .slider-for {border: 1px solid #14315C;}
	}
</style>
			
		</div>
		<div class="col-12 col-md-4">
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