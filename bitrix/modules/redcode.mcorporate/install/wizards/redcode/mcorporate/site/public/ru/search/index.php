<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Результаты поиска");
$APPLICATION->SetPageProperty("title", "Поиск");
$APPLICATION->SetPageProperty("keywords", "Ключевые, слова, вашей, страницы");
$APPLICATION->SetPageProperty("description", "Описание страницы");
?>

<main>
	<?$APPLICATION->IncludeComponent(
		"bitrix:search.page",
		"redcode",
		array(
			"COMPONENT_TEMPLATE" => "redcode",
			"RESTART" => "N",
			"NO_WORD_LOGIC" => "N",
			"CHECK_DATES" => "N",
			"USE_TITLE_RANK" => "N",
			"DEFAULT_SORT" => "rank",
			"arrFILTER" => array(
				0 => "iblock_redcode_mcorporate",
			),
			"PAGE_RESULT_COUNT" => "3",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"USE_LANGUAGE_GUESS" => "Y",
			"USE_SUGGEST" => "Y",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "Результаты поиска",
			"PAGER_TEMPLATE" => "redcode",
			"arrFILTER_iblock_redcode_mcorporate" => array(
				0 => "#SERVICES_IBLOCK_ID#",
				1 => "#NEWS_IBLOCK_ID#",
				2 => "#ARTICLES_IBLOCK_ID#",
				3 => "#SHARES_IBLOCK_ID#",
				4 => "#PARTNERS_IBLOCK_ID#",
				5 => "#HISTORY_IBLOCK_ID#",
				6 => "#REVIEWS_IBLOCK_ID#",
				7 => "#VACANCIES_IBLOCK_ID#",
				8 => "#STAFF_IBLOCK_ID#",
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