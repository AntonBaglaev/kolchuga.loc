<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<main class="fullMain">
	<div class="company">
		<?$APPLICATION->IncludeFile(SITE_DIR."include_areas/contact/newPage.php", array(), array("MODE" => "html"));?>
	</div>
</main>

<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>