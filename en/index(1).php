<?

//echo print_r($_SESSION);

if((int)$_COOKIE["intro_viewed"] == 0){
	header('Location: /intro.php');
	setcookie("intro_viewed", '1', time()+360000000, '/');
//        echo print_r($_SESSION);
	exit;
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Сеть оружейных салонов \"Кольчуга\"");
?> 
<p>Работаем все праздники без выходных с 10 до 18, доставка день в день 9 - 22.</p>
 							 
<p>Добро пожаловать в мебельный интернет-магазин! Мы предлагаем широкий ассортимент качественной мебели по адекватным ценам. Покупая мебель в нашем Интернет-магазине, вы можете быть уверены в качестве мебели - ведь мы работаем только с крупными и проверенными производителями.</p><br>
 
<h1 class="border_circl color_blue">Это интересно<i></i><b></b></h1>
 <?$APPLICATION->IncludeComponent("bitrix:news.list", "article_list", array(
	"IBLOCK_TYPE" => "articles",
	"IBLOCK_ID" => "10",
	"NEWS_COUNT" => "3",
	"SORT_BY1" => "ACTIVE_FROM",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "SORT",
	"SORT_ORDER2" => "ASC",
	"FILTER_NAME" => "",
	"FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "",
		1 => "",
	),
	"CHECK_DATES" => "Y",
	"DETAIL_URL" => "",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_FILTER" => "N",
	"CACHE_GROUPS" => "Y",
	"PREVIEW_TRUNCATE_LEN" => "200",
	"ACTIVE_DATE_FORMAT" => "d/m/Y",
	"SET_TITLE" => "N",
	"SET_STATUS_404" => "N",
	"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
	"ADD_SECTIONS_CHAIN" => "Y",
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"PARENT_SECTION" => "",
	"PARENT_SECTION_CODE" => "",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "N",
	"PAGER_TITLE" => "Новости",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"DISPLAY_DATE" => "Y",
	"DISPLAY_NAME" => "Y",
	"DISPLAY_PICTURE" => "Y",
	"DISPLAY_PREVIEW_TEXT" => "Y",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>