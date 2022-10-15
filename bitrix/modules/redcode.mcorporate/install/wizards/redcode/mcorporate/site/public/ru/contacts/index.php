<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Реквизиты компании");
$APPLICATION->SetTitle("Контакты");
$APPLICATION->SetPageProperty("keywords", "Ключевые, слова, вашей, страницы");
$APPLICATION->SetPageProperty("description", "Описание страницы");
?>

<div class="requisitesWriteUs">
	<div>
		<div class="contactsData">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", "",
			array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => SITE_DIR."include_areas/contact/addressContact.php",
		),
		false,
		array(
		"ACTIVE_COMPONENT" => "Y"
		)
	);?>
		</div><!--
	 --><div class="contactsData">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include", "", 
				array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => SITE_DIR."include_areas/contact/phoneContact.php",
				)
			);?>
		</div><!--
	 --><div class="contactsData">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include", "", 
				array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => SITE_DIR."include_areas/contact/emailContact.php",
				)
			);?>
		</div>
	</div>
	
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.feedback",
		"mapCallBack",
		array(
			"EMAIL_TO" => "#EMAIL#",
			"REQUIRED_FIELDS" => array(
				0 => "NAME",
				1 => "EMAIL",
			),
			"COMPONENT_TEMPLATE" => "mapCallBack",
			"EVENT_MESSAGE_ID" => "#REDCODE_WRITE_US_ID#",
			"ELEMENT_FORM" => array(
				0 => "NAME",
				1 => "SUBJECT",
				2 => "PHONE",
				3 => "EMAIL",
				4 => "MESSAGE",
			),
			"OPTION_THEME" => $optionTheme,
			"FORM_TITLE" => "Отправить сообщение",
			"USE_CAPTCHA" => "",
			"OK_TEXT" => ""
		),
		false
	);?>
</div>

</div> <? // Закрывающий тег .workArea ?>

<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"contacts",
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "contacts",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "#MAP_IBLOCK_ID#",
		"IBLOCK_TYPE" => "redcode_mcorporate",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "redcode",
		"PAGER_TITLE" => "Контакты",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "MAP_COORDINATE",
			1 => "LOGO_POSITION",
			2 => "MORE_TEXT",
			3 => "",
		),
		"STRICT_SECTION_CHECK" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ID",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"FILE_404" => "",
		"ZOOM_MAP" => "16",
		"NEWS_COUNT" => "1",
		"ADD_SECTIONS_CHAIN" => "N"
	),
	false
);?>

<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"requisites",
	array(
		"ACTIVE_DATE_FORMAT" => "",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "requisites",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "#REQUISITES_IBLOCK_ID#",
		"IBLOCK_TYPE" => "redcode_mcorporate",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "redcode",
		"PAGER_TITLE" => "Партнеры",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "Y",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"PROPERTY_CODE" => array(
			0 => "REQUISITES",
			1 => "",
		),
		"FILE_404" => "",
		"INFO_LIST_TITLE" => "Реквизиты",
		"STRICT_SECTION_CHECK" => ""
	),
	false
);?>

<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>