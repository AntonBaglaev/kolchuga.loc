<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бренды");
$APPLICATION->SetPageProperty("description","Ассортимент оружейных салонов «Кольчуга» объединяет в себе более 100 брендов ведущих мировых производителей охотничьего снаряжения и аксессуаров для активного отдыха, одежды и обуви для охоты и туризма, сопутствующих товаров.");
?><p>
 <img src="/brands/images/1308х305_1.jpg">
</p>
<p>
	 Ассортимент оружейных салонов «Кольчуга» объединяет в себе более 100 брендов ведущих мировых производителей охотничьего снаряжения и аксессуаров для активного отдыха, одежды и обуви для охоты и туризма, сопутствующих товаров.
</p>
 <?$APPLICATION->IncludeComponent(
	"maxyss:hl_brand.filter",
	"brandfilter",
	Array(
		"BLOCK_ID" => "6",
		"CACHE_TIME" => "360000",
		"CACHE_TYPE" => "N",
		"CHECK_PERMISSIONS" => "N",
		"COMPONENT_TEMPLATE" => "brandfilter",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DETAIL_URL" => "",
		"FIELD_CODE" => "UF_NAME",
		"FILTER_NAME" => "brandfilter",
		"SORT_BY1" => "UF_NAME",
		"SORT_ORDER1" => "ASC"
	)
);?> <br>
 <br>
 <?$APPLICATION->IncludeComponent(
	"maxyss:hl_brand.list", 
	"brands", 
	array(
		"BLOCK_ID" => "6",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"CHECK_PERMISSIONS" => "N",
		"DETAIL_URL" => "/brands/detail.php",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "UF_FILE",
			1 => "UF_LOGO",
			2 => "",
		),
		"FILTER_NAME" => "brandfilter",
		"PAGEN_ID" => "",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "стр.",
		"ROWS_PER_PAGE" => "",
		"ROW_ID" => $_REQUEST["ID"],
		"ROW_KEY" => "ID",
		"SEF_MODE_HL" => "Y",
		"SEF_MODE_PARAM" => "/brands/#UF_LINK#/",
		"SORT_BY1" => "UF_NAME",
		"SORT_ORDER1" => "ASC",
		"COMPONENT_TEMPLATE" => "brands"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>