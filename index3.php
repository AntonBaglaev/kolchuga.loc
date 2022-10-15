<?
//echo print_r($_SESSION);

/*
if((int)$_COOKIE["intro_viewed"] == 0){
	header('Location: /intro.php');
	setcookie("intro_viewed", '1', time()+360000000, '/');
//        echo print_r($_SESSION);
	exit;
	
}	
*/
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->ShowTitle("Оружейный магазин \"Кольчуга\"");
$APPLICATION->SetPageProperty("title", "Кольчуга - оружейный магазин в Москве.");
$APPLICATION->SetPageProperty("tags", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords_inner", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords", "оружейный магазин, оружейный интернет-магазин, оружейный салон");
$APPLICATION->SetPageProperty("description", "Кольчуга - самый крупный оружейный магазин на российском рынке. Продажа оружия, патронов, оптики и многого другого на сайте Kolchuga.ru");
$APPLICATION->SetTitle("  ");?> <br>

 <?$APPLICATION->IncludeComponent(
	"bitrix:photo.section",
	"brands.carousel",
	Array(
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "brands.carousel",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"FIELD_CODE" => array(0=>"",1=>"",),
		"FILTER_NAME" => "arrFilter",
		"IBLOCK_ID" => "13",
		"IBLOCK_TYPE" => "users",
		"LINE_ELEMENT_COUNT" => "3",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Фотографии",
		"PAGE_ELEMENT_COUNT" => "100",
		"PROPERTY_CODE" => array(0=>"email",1=>"",),
		"SECTION_CODE" => "",
		"SECTION_ID" => "45",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(0=>"",1=>"",),
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N"
	)
);?>
<style>
.main__btn a{
	display: none;
}
</style>
 <a href="/brands/" class="allbrand">Все бренды</a>
<?
$arSelect = Array("ID", "NAME", "PROPERTY_LINK", "PREVIEW_PICTURE", );
$arFilter = Array("IBLOCK_ID" => 36, "ID" => array("686528", "552668", "552669", "552670"));
$resBanners = CIBlockElement::GetList(Array('SORT' => 'ASC'), $arFilter, false, Array(), $arSelect);
while($obBanners = $resBanners->GetNextElement()) {
	$arBanners = $obBanners->GetFields();

	if($arBanners['ID'] == "552669" || $arBanners['ID'] == "552670") {
        $fileBanners = CFile::ResizeImageGet($arBanners['PREVIEW_PICTURE'], array('width'=>426, 'height'=>269), BX_RESIZE_IMAGE_EXACT, true);
        $arBanners['IMG_RESIZE_SRC'] = $fileBanners['src'];
		$arResultBanners['SMALL_BANNERS'][] = $arBanners;
    } elseif ($arBanners['ID'] == "686528" || $arBanners['ID'] == "552668") {
    	$fileBanners = CFile::ResizeImageGet($arBanners['PREVIEW_PICTURE'], array('width'=>426, 'height'=>555), BX_RESIZE_IMAGE_EXACT, true);
        $arBanners['IMG_RESIZE_SRC'] = $fileBanners['src'];
		$arResultBanners['BIG_BANNERS'][] = $arBanners;
    }
}

GLOBAL $newlistfilterin;
if (!is_array($newlistfilterin))
   $newlistfilterin = array();
$newlistfilterin['>SORT'] = 1;

?>
<div class="banner-grid">
	<div class="banner-grid__row">
		 <?php foreach ( $arResultBanners['BIG_BANNERS'] as $arBanner ): ?>
		<div class="banner-grid__col banner-grid__col_left">
 <a class="banner-grid__item" href="<?=$arBanner['PROPERTY_LINK_VALUE']?>"> <img src="<?=$arBanner['IMG_RESIZE_SRC']?>" alt=""> </a>
		</div>
		 <?php endforeach ?> <?/*<div class="banner-grid__col">
				<? foreach ( $arResultBanners['SMALL_BANNERS'] as $arItem ): ?>
					<a class="banner-grid__item banner-grid__item_small" href="<?=$arItem['PROPERTY_LINK_VALUE']?>">
						<img src="<?=$arItem['IMG_RESIZE_SRC']?>" alt="">
					</a>
				<? endforeach ?>
			</div>*/?>
		<div class="banner-grid__col banner-grid__col_banner">
			<div class="news-grid__col">
				 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"article.list",
	Array(
		"ACTIVE_DATE_FORMAT" => "d/m/Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "article.list",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"NAME",1=>"PREVIEW_TEXT",2=>"PREVIEW_PICTURE",3=>"DETAIL_TEXT",4=>"DETAIL_PICTURE",5=>"",),
		"FILTER_NAME" => "newlistfilterin",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "news",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "4",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "300",
		"PROPERTY_CODE" => array(0=>"",1=>"",),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "",
		"SORT_ORDER2" => "ASC"
	)
);?> <style>
.knopka {
    display: table;
    padding: 5px 20px;
    margin: auto;
    background: #21385e;
}
</style> <br>
				<div align="center" class="knopka1">
 <a href="/news/" class="allbrand">Все новости</a>
				</div>
			</div>
		</div>
	</div>
</div>
 <?/*$APPLICATION->IncludeComponent(
	"bitrix:catalog.top",
	"carousel1",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/basket.php",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"COMPARE_PATH" => "",
		"COMPATIBLE_MODE" => "Y",
		"COMPONENT_TEMPLATE" => "carousel1",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"CUSTOM_FILTER" => "",
		"DETAIL_URL" => "/internet_shop/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		"DISPLAY_COMPARE" => "Y",
		"ELEMENT_COUNT" => "100",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "",
		"FILTER_NAME" => "saleFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "40",
		"IBLOCK_TYPE" => "1c_catalog",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"OFFERS_CART_PROPERTIES" => "",
		"OFFERS_FIELD_CODE" => "",
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => "",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "timestamp_x",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(0=>"Розничная",),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PROPERTY_CODE" => array(0=>"",1=>"",),
		"ROTATE_TIMER" => "30",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "/internet_shop/#SECTION_CODE_PATH#/",
		"SEF_MODE" => "N",
		"SHOW_CLOSE_POPUP" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PAGINATION" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "blue",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"VIEW_MODE" => "BANNER"
	),
false,
Array(
	'ACTIVE_COMPONENT' => 'Y'
)
);*/?> 
<?/*$APPLICATION->IncludeComponent(
	"bitrix:sale.bestsellers",
	"defa",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",
		"ADDITIONAL_PICT_PROP_40" => "MORE_PHOTO",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"BY" => "AMOUNT",
		"CACHE_TIME" => "86400",
		"CACHE_TYPE" => "A",
		"CART_PROPERTIES_3" => array("CORNER"),
		"CART_PROPERTIES_4" => array(),
		"CART_PROPERTIES_40" => array("",""),
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"DETAIL_URL" => "",
		"DISPLAY_COMPARE" => "N",
		"FILTER" => array("PU", "N", "A", "F", "S"),
		"HIDE_NOT_AVAILABLE" => "N",
		"LABEL_PROP_3" => "SPECIALOFFER",
		"LABEL_PROP_40" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"OFFER_TREE_PROPS_4" => array("-"),
		"PAGE_ELEMENT_COUNT" => "30",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PERIOD" => "30",
		"PRICE_CODE" => array("Розничная"),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE_3" => array("MANUFACTURER","MATERIAL"),
		"PROPERTY_CODE_4" => array("COLOR"),
		"PROPERTY_CODE_40" => array("",""),
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_IMAGE" => "Y",
		"SHOW_NAME" => "Y",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_PRODUCTS_3" => "Y",
		"SHOW_PRODUCTS_40" => "Y",
		"TEMPLATE_THEME" => "blue",
		"USE_PRODUCT_QUANTITY" => "N"
	)
);*/?>
<? //снова меняем условия отображения товаров

    $obCache = new CPHPCache(); 
    $cacheLifetime = 3600 * 4; 
    $cacheID = 'arrFilterShowTop'; 
    $cachePath = '/arrfiltershowtop_cache'; 
    

    if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath))// Если кэш валиден 
    { 
        $cache_vars = $obCache->GetVars(); 
        
    } elseif ($obCache->StartDataCache()) { 
		$fil = array(
			"IBLOCK_ID"=>40,
			"ACTIVE"=>"Y",
			'>CATALOG_PRICE_2' => 0,
			'=PROPERTY_IS_SKU_VALUE' => 'Нет',
			'SECTION_ID'=>18105,
			array(
				'LOGIC' => 'OR',
				'>CATALOG_QUANTITY' => 0,
				'>PROPERTY_SKU_QUANTITY' => 0
			)
		);

		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$fil['SECTION_ID']=18144;
		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$fil['SECTION_ID']=18107;
		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$fil['SECTION_ID']=18122;
		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$fil['SECTION_ID']=18146;
		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$fil['SECTION_ID']=17858;
		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$fil['SECTION_ID']=18118;
		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$obCache->EndDataCache($cache_vars); 
    }
$GLOBALS['arrFilterShowTop']=	$cache_vars;

?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top",
	"carousel1",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/basket.php",
		"BRAND_PROPERTY" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
		"COMPARE_PATH" => "",
		"COMPATIBLE_MODE" => "N",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"OR\",\"True\":\"True\"},\"CHILDREN\":[]}",
		"DATA_LAYER_NAME" => "dataLayer",
		"DETAIL_URL" => "",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"DISPLAY_COMPARE" => "N",
		"ELEMENT_COUNT" => "9",
		"ELEMENT_SORT_FIELD" => "shows",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrFilterShowTop",
		"HIDE_NOT_AVAILABLE" => "L",
		"HIDE_NOT_AVAILABLE_OFFERS" => "L",
		"IBLOCK_ID" => "40",
		"IBLOCK_TYPE" => "1c_catalog",
		"LABEL_PROP" => array(),
		"LABEL_PROP_MOBILE" => array(),
		"LABEL_PROP_POSITION" => "top-left",
		"LINE_ELEMENT_COUNT" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"MESS_RELATIVE_QUANTITY_FEW" => "мало",
		"MESS_RELATIVE_QUANTITY_MANY" => "много",
		"MESS_SHOW_MAX_QUANTITY" => "Наличие",
		"OFFERS_CART_PROPERTIES" => array("COLOR_REF","SIZES_SHOES","SIZES_CLOTHES"),
		"OFFERS_FIELD_CODE" => array("",""),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array("SIZES_SHOES","SIZES_CLOTHES","MORE_PHOTO",""),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"OFFER_TREE_PROPS" => array("COLOR_REF","SIZES_SHOES"),
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array("Розничная"),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(""),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array("",""),
		"PROPERTY_CODE_MOBILE" => array(),
		"RELATIVE_QUANTITY_FACTOR" => "5",
		"ROTATE_TIMER" => "30",
		"SECTION_URL" => "",
		"SEF_MODE" => "N",
		"SEF_RULE" => "",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PAGINATION" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "N",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "Y",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
		"VIEW_MODE" => "SLIDER"
	)
);?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.bigdata.products",
	".default",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADDITIONAL_PICT_PROP_17" => "MORE_PHOTO",
		"ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",
		"ADDITIONAL_PICT_PROP_40" => "MORE_PHOTO",
		"ADDITIONAL_PICT_PROP_41" => "",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"BASKET_URL" => "/internet_shop/basket/",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"CART_PROPERTIES_17" => "",
		"CART_PROPERTIES_3" => "",
		"CART_PROPERTIES_40" => array(0=>"",1=>"",),
		"CART_PROPERTIES_41" => "",
		"COMPONENT_TEMPLATE" => ".default",
		"CONVERT_CURRENCY" => "N",
		"DEPTH" => "",
		"DETAIL_URL" => "",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "40",
		"IBLOCK_TYPE" => "1c_catalog",
		"ID" => $_REQUEST["PRODUCT_ID"],
		"LABEL_PROP_17" => "-",
		"LABEL_PROP_3" => "-",
		"LABEL_PROP_40" => "-",
		"LABEL_PROP_41" => "",
		"LINE_ELEMENT_COUNT" => "3",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"PAGE_ELEMENT_COUNT" => "100",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(0=>"Розничная",),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE_17" => "",
		"PROPERTY_CODE_3" => "",
		"PROPERTY_CODE_40" => array(0=>"",1=>"",),
		"PROPERTY_CODE_41" => "",
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_ELEMENT_CODE" => "",
		"SECTION_ELEMENT_ID" => "",
		"SECTION_ID" => "",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_IMAGE" => "Y",
		"SHOW_NAME" => "Y",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_PRODUCTS_17" => "N",
		"SHOW_PRODUCTS_3" => "N",
		"SHOW_PRODUCTS_40" => "Y",
		"SHOW_PRODUCTS_41" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_PRODUCT_QUANTITY" => "N"
	),
false,
Array(
	'ACTIVE_COMPONENT' => 'N'
)
);?> <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"banner.main-grid-middle",
	Array(
		"ACTIVE_DATE_FORMAT" => "d/m/Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "banner.main-grid-middle",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"NAME",1=>"PREVIEW_TEXT",2=>"PREVIEW_PICTURE",3=>"DETAIL_TEXT",4=>"DETAIL_PICTURE",5=>"",),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "36",
		"IBLOCK_TYPE" => "banners",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "10",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"LINK",1=>"",),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	)
);?> <br>
 <br>
<h1 align="center" class="inpolosa">Интернет-магазин&nbsp;товаров для охоты и активного отдыха</h1>
 <br>
 <br>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"",
	Array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_NOTES" => "",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"COUNT_ELEMENTS" => "N",
		"IBLOCK_ID" => "40",
		"IBLOCK_TYPE" => "",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => "",
		"SECTION_ID" => "",
		"SECTION_URL" => "/internet_shop/#SECTION_CODE_PATH#/",
		"SECTION_USER_FIELDS" => "",
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => "1",
		"VIEW_MODE" => "TEXT"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>