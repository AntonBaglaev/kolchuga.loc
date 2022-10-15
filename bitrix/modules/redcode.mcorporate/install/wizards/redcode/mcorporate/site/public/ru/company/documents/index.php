<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Главные документы");
$APPLICATION->SetTitle("Документы");
$APPLICATION->SetPageProperty("keywords", "Ключевые, слова, вашей, страницы");
$APPLICATION->SetPageProperty("description", "Описание страницы");
?>

<main>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"documents",
		array(
			"IBLOCK_TYPE" => "redcode_mcorporate",
			"IBLOCK_ID" => "#DOCUMENTS_IBLOCK_ID#",
			"SECTION_FIELDS" => array(
				0 => "ID",
				1 => "NAME",
				2 => "DESCRIPTION",
				3 => "",
			),
			"SECTION_USER_FIELDS" => array(
				0 => "",
				1 => "",
			),
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_NOTES" => "",
			"CACHE_GROUPS" => "Y",
			"COMPONENT_TEMPLATE" => "documents",
			"IBLOCK_DESCRIPTION" => "Y",
			"SECTION_ID" => $_REQUEST["SECTION_ID"],
			"SECTION_CODE" => "",
			"COUNT_ELEMENTS" => "N",
			"TOP_DEPTH" => "2",
			"SECTION_URL" => "",
			"ADD_SECTIONS_CHAIN" => "Y",
			"ELEMENT_FIELDS" => array(
				0 => "ID",
				1 => "NAME",
				2 => "PREVIEW_TEXT",
				3 => "PREVIEW_PICTURE",
				4 => "",
			)
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