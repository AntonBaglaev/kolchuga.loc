<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("tags", "оружейная выставка, arms and hunting,");
$APPLICATION->SetPageProperty("keywords_inner", "оружейная выставка, arms and hunting,");
$APPLICATION->SetPageProperty("title", "Московская международная выставка «ARMS & Hunting»");
$APPLICATION->SetPageProperty("description", 'Московская международная выставка «ARMS & Hunting» в Гостином Дворе зарубежных и отечественных производителей оружия.');
$APPLICATION->SetTitle("Московская международная выставка «ARMS & Hunting»");
?><p>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:photo.section",
	"weapon_salon.slider",
	Array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_NOTES" => "",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"FIELD_CODE" => array("",""),
		"FILTER_NAME" => "arrFilter",
		"IBLOCK_ID" => "9",
		"IBLOCK_TYPE" => "gallery",
		"LINE_ELEMENT_COUNT" => "3",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Фотографии",
		"PAGE_ELEMENT_COUNT" => "20",
		"PROPERTY_CODE" => array("APPROVE_ELEMENT","PUBLIC_ELEMENT","REAL_PICTURE",""),
		"SECTION_CODE" => "",
		"SECTION_ID" => "13270",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array("",""),
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N"
	)
);?> <br>
</p>
<p>
	 Московская международная выставка «ARMS &amp; Hunting» – это крупнейшее в России мероприятие, посвященное охоте, гражданскому охотничьему и спортивному оружию, роль которого в мировом оружейном сообществе становится все более значительной с каждым годом. Выставка ежегодно собирает лучших зарубежных и отечественных производителей, дилеров и дистрибьюторов оружия, аксессуаров и охотничьего снаряжения. Широчайший ассортимент продукции, представленный как заслуженными брендами с солидной историей, так и очень перспективными новинками, позволяет покупателю подобрать для себя оружие и снаряжение в любом ценовом и качественном сегменте.
</p>
<p>
	 Помимо представленных товаров, здесь есть возможность заказать у специализированных агентств и аутфиттеров охотничьи и рыболовные туры по всему миру, а также ознакомиться с достижениями ведущих специалистов в производстве одежды, принадлежностей, экипировки и аксессуаров для охоты, рыбной ловли, спортивной стрельбы и таксидермии.
</p>
<p>
 <strong>Организаторы:</strong>
</p>
<ul>
	<li>Группа компаний «Кольчуга»;</li>
	<li>ООО «Русская охота».</li>
</ul>
<p>
 <strong>При содействии: </strong>
</p>
<ul>
	<li>Росгвардии;</li>
	<li>Министерства внутренних дел РФ;</li>
	<li>Федеральной таможенной службы РФ;</li>
	<li>Правительства Москвы.</li>
</ul>
<p>
 <strong>Тематическое содержание: </strong>
</p>
<ul>
	<li>охотничье и спортивное оружие;</li>
	<li>оружие самообороны;</li>
	<li>охотничьи и спортивные патроны;</li>
	<li>снаряжение и оптика;</li>
	<li>средства ухода за оружием;</li>
	<li>одежда, принадлежности, экипировка и аксессуары для охоты;</li>
	<li>охотничьи хозяйства;</li>
	<li>охотничий туризм;</li>
	<li>таксидермия;</li>
	<li>сувениры и подарки.</li>
</ul>
<p>
 <strong>Контактная информация:</strong>
</p>
<p>
	 109012, Россия, г. Москва, ул. Ильинка, д. 4, офис 3А2А
</p>
<p>
	 Телефон/факс:
</p>
<p>
	 +7 (495) 698-16-76, +7 (495) 698-12-51
</p>
<p>
	 Официальный сайт Московской международной выставки «ARMS &amp; Hunting»&nbsp;<a href="http://armsandhunting.ru" title="Arms and Hunting" target="_blank">www.armsandhunting.ru</a>
</p><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>