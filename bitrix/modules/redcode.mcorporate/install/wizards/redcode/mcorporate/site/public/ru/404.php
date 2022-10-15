<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/urlrewrite.php");

CHTTP::SetStatus("404 Not Found");

if(!defined("ERROR_404"))
	define("ERROR_404", "Y");

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Ошибка 404. Страница не найдена!");

$optionTheme = $APPLICATION->IncludeComponent("redcode.mcorporate:switch.color", "", array(), false, array("HIDE_ICONS" => "Y"));
$detailed = $APPLICATION->GetCurPage(false) != SITE_DIR;
$asset = \Bitrix\Main\Page\Asset::getInstance();
$loc = new \Bitrix\Main\Localization\Loc;
$loc->loadMessages(__FILE__);
?>

<div class="error404">
	<div>Ошибка </br> <span>404</span></div><!--
 --><div>
		<div class="description404">Неправильно набран адрес или такой страницы не существует</div>
		<a href="<?=SITE_DIR;?>" title="На главную" class="url404">
			<i class="materialIcons">&#xE88A;</i>
			На главную
		</a>
		<a href="#" title="Вернуться назад" class="back404" onclick="history.back()">Вернуться назад</a>
	</div>
</div>

<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>