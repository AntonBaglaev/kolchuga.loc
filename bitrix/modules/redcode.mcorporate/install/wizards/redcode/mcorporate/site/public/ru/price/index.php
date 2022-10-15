<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Прайс-лист");
$APPLICATION->SetPageProperty("keywords", "Ключевые, слова, вашей, страницы");
$APPLICATION->SetPageProperty("description", "Описание страницы");
?>

<main>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"price",
		array(
			"IBLOCK_TYPE" => "redcode_mcorporate",
			"IBLOCK_ID" => "#PRICE_IBLOCK_ID#",
			"SECTION_FIELDS" => array(
				0 => "ID",
				1 => "NAME",
				2 => "",
			),
			"SECTION_USER_FIELDS" => array(
				0 => "",
				1 => "",
			),
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_NOTES" => "",
			"CACHE_GROUPS" => "Y",
			"COMPONENT_TEMPLATE" => "price",
			"IBLOCK_DESCRIPTION" => "Y",
			"ELEMENT_FIELD_CODE" => array(
				0 => "NAME",
				1 => "",
			),
			"ELEMENT_PROPERTY" => array(
				0 => "UNITS",
				1 => "PRICE",
				2 => "",
			),
			"SECTION_ID" => $_REQUEST["SECTION_ID"],
			"SECTION_CODE" => "",
			"COUNT_ELEMENTS" => "N",
			"TOP_DEPTH" => "2",
			"SECTION_URL" => "",
			"ADD_SECTIONS_CHAIN" => "N",
			"ELEMENT_FIELDS" => array(
				0 => "ID",
				1 => "NAME",
				2 => "",
			),
			"SORT_BY" => "ID",
			"SORT_ORDER" => "ASC"
		),
		false
	);?>
</main>
<div class="sidebar">
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include", "",
		array(
			"AREA_FILE_SHOW" => "sect",
			"AREA_FILE_SUFFIX" => "sidebar",
			"AREA_FILE_RECURSIVE" => "Y",
		),
		false
	);?>
</div>
<div class="clear"></div>

<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>