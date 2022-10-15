<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Вакансии в нашу компанию");
$APPLICATION->SetTitle("Вакансии");
$APPLICATION->SetPageProperty("keywords", "Ключевые, слова, вашей, страницы");
$APPLICATION->SetPageProperty("description", "Описание страницы");
?>

<main>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"vacancies",
		array(
			"IBLOCK_TYPE" => "redcode_mcorporate",
			"IBLOCK_ID" => "#VACANCIES_IBLOCK_ID#",
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
			"COMPONENT_TEMPLATE" => "vacancies",
			"ELEMENT_FIELDS" => array(
				0 => "ID",
				1 => "NAME",
				2 => "",
			),
			"ELEMENT_PROPERTY" => array(
				0 => "DUTIE",
				1 => "CONDITIONS",
				2 => "REQUIREMENTS",
				3 => "WAGE",
				4 => "",
			),
			"CHECK_DATES" => "Y",
			"SORT_BY" => "NAME",
			"SORT_ORDER" => "DESC",
			"SECTION_ID" => "",
			"SECTION_CODE" => "",
			"SECTION_URL" => "",
			"COUNT_ELEMENTS" => "",
			"TOP_DEPTH" => "",
			"ADD_SECTIONS_CHAIN" => "",
			"IBLOCK_DESCRIPTION" => "Y"
		),
		false
	);?>

	<?$APPLICATION->IncludeComponent(
		"bitrix:main.feedback", 
		"sendSummary", 
		array(
			"EMAIL_TO" => "#EMAIL#",
			"REQUIRED_FIELDS" => array(
				0 => "FILE",
			),
			"COMPONENT_TEMPLATE" => "sendSummary",
			"EVENT_MESSAGE_ID" => "#REDCODE_SUMMARY_ID#",
			"ELEMENT_FORM" => array(
				0 => "FILE",
			),
			"OPTION_THEME" => $optionTheme,
			"FORM_TITLE" => "Отправка резюме",
			"FORM_NAME_SUBMIT" => "Отправить",
			"USE_CAPTCHA" => "",
			"OK_TEXT" => ""
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
			"EDIT_MODE" => "html",
		),
		false
	);?>
</div>
<div class="clear"></div>

<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>