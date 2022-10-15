<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Дилеры");
$APPLICATION->SetPageProperty("description", 'Список дилеров компании "Кольчуга".');
?><p>
	 За 25 лет работы на российском рынке оружия и боеприпасов, компания «Кольчуга» стала крупнейшим оружейным холдингом. Одно из наших главных достижений - надежные деловые отношения с российскими партнерами, успешное сотрудничество с которыми помогает компании развиваться и предлагать покупателям еще больше новой и качественной продукции от ведущих мировых оружейников.
</p>
<p>
	 Индивидуальный подход и гибкая система скидок являются приоритетом в нашей работе. Если вы хотите сотрудничать с нами, свяжитесь с менеджерами оптовых отделов. С подробной информацией вы можете ознакомиться на странице <a href="/optovik/">«Оптовым клиентам»</a>.
</p>
<div class="dealers">
	<div class="dealers--left">
		<h3>Оружие, оптика, ножи, аксессуары</h3>
		<div class="dealers__img">
 <img src="/upload/medialibrary/b1e/b1ea6e095cb5997dfd79497892b02371.png" alt="">
		</div>
		<div class="dealers__list">
			 Blaser, Bushnell, Clever, Crosman, CZ, Fabarm, Fiocchi, Gamo, Glock, H&amp;K, Mauser, Norma, Sauer, Sig Sauer, Swarovski, Walther, Zeiss, Zoli
		</div>
		<div class="dealers__phone">
 <b><a href="tel:+7 (495) 698-17-79">+7 (495) 698-17-79</a></b>
		</div>
	</div>
	<div class="dealers--right">
		<h3>Одежда, обувь, сувениры</h3>
		<div class="dealers__img">
 <img src="/upload/medialibrary/a59/a59ed8c2ed0bf512cf069386b5828acc.png" alt="">
		</div>
		<div class="dealers__list">
			 Blaser, Sportchief, James Purday, Habsburg, Jack Pyke, Lodenhut, Maremmano, Macwet, Euro PM, Monte Sport, Dedalo, Gien, Allen, Uzi
		</div>
		<div class="dealers__phone">
 <b><a href="tel:+7 (495) 698 31 91">+7 (495) 698-10-23</a></b>
		</div>
	</div>
</div>
 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"dealers.list",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array("NAME",""),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "45",
		"IBLOCK_TYPE" => "services",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "350",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array("CITY","PHONE",""),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "PROPERTY_320",
		"SORT_BY2" => "NAME",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC"
	)
);?> <br>
 <style>
.knopka {
    display: table;
    padding: 5px 20px;
    margin: auto;
    background: #21385e;
}
</style>
<div align="center" class="knopka">
 <a href="/information/Дилеры.pdf" style="color: #ffffff" target="_blank">Дилеры</a>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>