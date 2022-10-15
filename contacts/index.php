<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?><div class="tel_block_text" style="max-width:600px;">
    <div>
        <span class="tel_text_left">Салон в д. Барвиха:</span> <a href="tel:+74952252990" class="tel_text_right">+7 (495) 225-29-90</a>
    </div>
	<div>
 <span class="tel_text_left">Салон на Варварке:</span> <a href="tel:+74959252641" class="tel_text_right">+7 (495) 925-26-41</a>
	</div>
	<div>
 <span class="tel_text_left">Салон на Волоколамском шоссе:</span> <a href="tel:+74954901420" class="tel_text_right">+7 (495) 490-14-20</a>
	</div>
	<div>
 <span class="tel_text_left">Салон на Ленинском Проспекте:</span> <a href="tel:+74956512500" class="tel_text_right">+7 (495) 651-25-00</a>
	</div>
	<div>
 <span class="tel_text_left">Салон в г. Люберцы:</span> <a href="tel:+74955542240" class="tel_text_right">+7 (495) 554-22-40</a>
	</div>
    <div>
        <span class="tel_text_left">Интернет-магазин:</span> <a href="tel:88002349420" class="tel_text_right">8 (800) 234-94-20</a>
    </div>
</div>
<hr size="2">
 <style>.hide{display:none;}</style> <script type="text/javascript">
	swfobject.embedSWF("/weapons_salons/maps/kolchyga_map_varvarka_700x500_v2.swf", "varvarka", "700", "500", "9.0.0");
</script>
<div id="varvarka" class="cont_left">
 <br>
</div>
<div class="cont_right">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"contacts_new",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "Y",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => Array(),
		"WEB_FORM_ID" => 4
	)
);?>
</div>
<div class="clearfix">
</div>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>