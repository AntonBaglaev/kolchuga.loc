<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Политика в отношении обработки персональных данных");
$APPLICATION->SetPageProperty("title", "Соглашение на обработку персональных данных");
$APPLICATION->SetPageProperty("keywords", "Ключевые, слова, вашей, страницы");
$APPLICATION->SetPageProperty("description", "Описание страницы");
?>

<main class="fullMain">
	<div class="company">
		<?$APPLICATION->IncludeComponent(
			"redcode.mcorporate:userconsent.view", 
			".default", 
			array(
				"COMPONENT_TEMPLATE" => ".default",
				"ACTIVE_LIST" => "#REDCODE_AGREEMENT#",
				"PERSONAL_DATA" => array(
					0 => "NAME",
					1 => "SURNAME",
					2 => "PATRONYMIC",
					3 => "EMAIL",
					4 => "PHONE",
					5 => "",
				)
			),
			false
		);?>
	</div>
</main>

<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>