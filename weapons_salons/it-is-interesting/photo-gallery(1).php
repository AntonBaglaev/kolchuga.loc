<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Фотогалерея");
?> <?$APPLICATION->IncludeComponent(
	"bitrix:photogallery",
	"",
	Array(
		"SHOW_LINK_ON_MAIN_PAGE" => array(),
		"USE_LIGHT_VIEW" => "Y",
		"SEF_MODE" => "N",
		"IBLOCK_TYPE" => "gallery",
		"IBLOCK_ID" => "9",
		"SECTION_SORT_BY" => "UF_DATE",
		"SECTION_SORT_ORD" => "DESC",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "desc",
		"PATH_TO_USER" => "",
		"SECTION_PAGE_ELEMENTS" => "15",
		"ELEMENTS_PAGE_ELEMENTS" => "50",
		"ALBUM_PHOTO_SIZE" => "200",
		"THUMBNAIL_SIZE" => "200",
		"JPEG_QUALITY1" => "100",
		"ORIGINAL_SIZE" => "900",
		"JPEG_QUALITY" => "100",
		"ADDITIONAL_SIGHTS" => array(),
		"PHOTO_LIST_MODE" => "Y",
		"SHOWN_ITEMS_COUNT" => "6",
		"SHOW_NAVIGATION" => "N",
		"DATE_TIME_FORMAT_DETAIL" => "d.m.Y",
		"DATE_TIME_FORMAT_SECTION" => "d.m.Y",
		"SET_TITLE" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"USE_RATING" => "N",
		"SHOW_TAGS" => "N",
		"DRAG_SORT" => "Y",
		"UPLOADER_TYPE" => "applet",
		"APPLET_LAYOUT" => "extended",
		"UPLOAD_MAX_FILE_SIZE" => "50",
		"USE_WATERMARK" => "Y",
		"WATERMARK_RULES" => "USER",
		"WATERMARK_MIN_PICTURE_SIZE" => "800",
		"USE_COMMENTS" => "N",
		"VARIABLE_ALIASES" => Array(
			"SECTION_ID" => "SECTION_ID",
			"ELEMENT_ID" => "ELEMENT_ID",
			"PAGE_NAME" => "PAGE_NAME",
			"ACTION" => "ACTION"
		)
	),
false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>