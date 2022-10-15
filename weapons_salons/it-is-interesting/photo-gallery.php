<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("tags", "фотогалерея");
$APPLICATION->SetPageProperty("keywords_inner", "фотогалерея");
$APPLICATION->SetPageProperty("keywords", "фотогалерея");
$APPLICATION->SetPageProperty("description", "Оружейный салон \"Кольчуга\"");
$APPLICATION->SetTitle("Фотогалерея");
?><?$APPLICATION->IncludeComponent("bitrix:photogallery", "template1", array(
	"USE_LIGHT_VIEW" => "Y",
	"IBLOCK_TYPE" => "gallery",
	"IBLOCK_ID" => "9",
	"PATH_TO_USER" => "",
	"DRAG_SORT" => "Y",
	"USE_COMMENTS" => "N",
	"SEF_MODE" => "N",
	"SEF_FOLDER" => "/weapons_salons/it-is-interesting/",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"SET_TITLE" => "Y",
	"ALBUM_PHOTO_SIZE" => "120",
	"THUMBNAIL_SIZE" => "100",
	"ORIGINAL_SIZE" => "1280",
	"PHOTO_LIST_MODE" => "Y",
	"SHOWN_ITEMS_COUNT" => "6",
	"USE_RATING" => "N",
	"SHOW_TAGS" => "N",
	"UPLOADER_TYPE" => "form",
	"UPLOAD_MAX_FILE_SIZE" => "50",
	"USE_WATERMARK" => "Y",
	"WATERMARK_RULES" => "USER",
	"PATH_TO_FONT" => "default.ttf",
	"WATERMARK_MIN_PICTURE_SIZE" => "800",
	"SHOW_LINK_ON_MAIN_PAGE" => array(
		0 => "rating",
		1 => "comments",
	),
	"SECTION_SORT_BY" => "UF_DATE",
	"SECTION_SORT_ORD" => "DESC",
	"ELEMENT_SORT_FIELD" => "sort",
	"ELEMENT_SORT_ORDER" => "desc",
	"DATE_TIME_FORMAT_DETAIL" => "d.m.Y",
	"DATE_TIME_FORMAT_SECTION" => "d.m.Y",
	"SECTION_PAGE_ELEMENTS" => "15",
	"ELEMENTS_PAGE_ELEMENTS" => "50",
	"PAGE_NAVIGATION_TEMPLATE" => "",
	"JPEG_QUALITY1" => "100",
	"JPEG_QUALITY" => "100",
	"ADDITIONAL_SIGHTS" => array(
	),
	"SHOW_NAVIGATION" => "N",
	"VARIABLE_ALIASES" => array(
		"SECTION_ID" => "SECTION_ID",
		"ELEMENT_ID" => "ELEMENT_ID",
		"PAGE_NAME" => "PAGE_NAME",
		"ACTION" => "ACTION",
	)
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>