<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("tags", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords_inner", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords", "инструкции, описания, технические данные");
$APPLICATION->SetPageProperty("description", "Инструкции для оружия");
$APPLICATION->SetTitle("Инструкции");
?><?$APPLICATION->IncludeComponent("bitrix:catalog", "instructions", Array(
	"IBLOCK_TYPE" => "instructions",	// Тип инфоблока
	"IBLOCK_ID" => "20",	// Инфоблок
	"BASKET_URL" => "/personal/basket.php",	// URL, ведущий на страницу с корзиной покупателя
	"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
	"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
	"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
	"PRODUCT_QUANTITY_VARIABLE" => "quantity",	// Название переменной, в которой передается количество товара
	"SEF_MODE" => "N",	// Включить поддержку ЧПУ
	"SEF_FOLDER" => "/weapons_salons/it-is-interesting/instructions/",	// Каталог ЧПУ (относительно корня сайта)
	"AJAX_MODE" => "N",	// Включить режим AJAX
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
	"CACHE_GROUPS" => "Y",	// Учитывать права доступа
	"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
	"SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
	"USE_FILTER" => "N",	// Показывать фильтр
	"USE_REVIEW" => "N",	// Разрешить отзывы
	"USE_COMPARE" => "N",	// Использовать компонент сравнения
	"PRICE_CODE" => "",	// Тип цены
	"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
	"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
	"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
	"PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
	"USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
	"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
	"SHOW_TOP_ELEMENTS" => "Y",	// Выводить топ элементов
	"TOP_ELEMENT_COUNT" => "9",	// Количество выводимых элементов
	"TOP_LINE_ELEMENT_COUNT" => "3",	// Количество элементов, выводимых в одной строке таблицы
	"TOP_ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем товары в разделе
	"TOP_ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки товаров в разделе
	"TOP_PROPERTY_CODE" => array(	// Свойства
		0 => "",
		1 => "",
	),
	"SECTION_COUNT_ELEMENTS" => "Y",	// Показывать количество элементов в разделе
	"PAGE_ELEMENT_COUNT" => "30",	// Количество элементов на странице
	"LINE_ELEMENT_COUNT" => "3",	// Количество элементов, выводимых в одной строке таблицы
	"ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем товары в разделе
	"ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки товаров в разделе
	"LIST_PROPERTY_CODE" => array(	// Свойства
		0 => "",
		1 => "",
	),
	"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
	"LIST_META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства раздела
	"LIST_META_DESCRIPTION" => "-",	// Установить описание страницы из свойства раздела
	"LIST_BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства раздела
	"DETAIL_PROPERTY_CODE" => array(	// Свойства
		0 => "",
		1 => "",
	),
	"DETAIL_META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
	"DETAIL_META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
	"DETAIL_BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
	"LINK_IBLOCK_TYPE" => "",	// Тип инфоблока, элементы которого связаны с текущим элементом
	"LINK_IBLOCK_ID" => "",	// ID инфоблока, элементы которого связаны с текущим элементом
	"LINK_PROPERTY_SID" => "",	// Свойство, в котором хранится связь
	"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",	// URL на страницу где будет показан список связанных элементов
	"USE_ALSO_BUY" => "N",	// Показывать блок "С этим товаром покупают"
	"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
	"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
	"PAGER_TITLE" => "Товары",	// Название категорий
	"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
	"PAGER_TEMPLATE" => "arrows_new",	// Название шаблона
	"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
	"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
	"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
	"VARIABLE_ALIASES" => array(
		"SECTION_ID" => "SECTION_ID",
		"ELEMENT_ID" => "ELEMENT_ID",
	)
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>