<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Наши любимые сотрудники");
$APPLICATION->SetTitle("Сотрудники");
$APPLICATION->SetPageProperty("keywords", "Ключевые, слова, вашей, страницы");
$APPLICATION->SetPageProperty("description", "Описание страницы");
?>

<main>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"staff",
		array(
			"IBLOCK_TYPE" => "redcode_mcorporate",
			"IBLOCK_ID" => "#STAFF_IBLOCK_ID#",
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
			"COMPONENT_TEMPLATE" => "staff",
			"ELEMENT_PROPERTY" => array(
				0 => "POST",
				1 => "PHONE",
				2 => "EMAIL",
				3 => "",
			),
			"ELEMENT_FIELDS" => array(
				0 => "ID",
				1 => "NAME",
				2 => "PREVIEW_PICTURE",
				3 => "",
			),
			"SECTION_ID" => "",
			"SECTION_CODE" => "",
			"SECTION_URL" => "",
			"COUNT_ELEMENTS" => "",
			"TOP_DEPTH" => "",
			"ADD_SECTIONS_CHAIN" => "",
			"CHECK_DATES" => "Y",
			"SORT_BY" => "ID",
			"SORT_ORDER" => "ASC"
		),
		false
	);
		
	$APPLICATION->IncludeComponent(
		"bitrix:main.include", "",
		array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => SITE_DIR."include_areas/banners/bannerVacancies.php"
		),
		false,
		array(
		"ACTIVE_COMPONENT" => "N"
		)
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