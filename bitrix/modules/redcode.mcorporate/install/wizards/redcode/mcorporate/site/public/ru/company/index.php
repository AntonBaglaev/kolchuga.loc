<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О компании");
$APPLICATION->SetPageProperty("title", "Компания ООО \"Компания\"");
$APPLICATION->SetPageProperty("keywords", "Ключевые, слова, вашей, страницы");
$APPLICATION->SetPageProperty("description", "Описание страницы");
?>

<main>
	<div class="company">
		<?$APPLICATION->IncludeFile(SITE_DIR."include_areas/contact/text.php", array(), array("MODE" => "html", "NAME" => "Текст"));?>
	</div>
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