<?
global $filterpop;
$filterpop = \Kolchuga\DopViborka::getListIndexTovarPop('Y',25);
//echo "<pre style='text-align:left;display:none;'>";print_r($filterpop);echo "</pre>";
//\Kolchuga\Settings::xmp($filterpop,11460, __FILE__.": ".__LINE__);
?>


<?$APPLICATION->IncludeComponent("bitrix:catalog.top", "catalog_sale2", Array(
	"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/basket.php",	// URL, ведущий на страницу с корзиной покупателя
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"COMPARE_PATH" => "",	// Путь к странице сравнения
		"COMPATIBLE_MODE" => "Y",	// Включить режим совместимости
		"COMPONENT_TEMPLATE" => "carousel1",
		"CONVERT_CURRENCY" => "Y",	// Показывать цены в одной валюте
		"CURRENCY_ID" => "RUB",	// Валюта, в которую будут сконвертированы цены
		"CUSTOM_FILTER" => "",	// Фильтр товаров
		"DETAIL_URL" => "/internet_shop/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",	// URL, ведущий на страницу с содержимым элемента раздела
		"DISPLAY_COMPARE" => "Y",	// Разрешить сравнение товаров
		"ELEMENT_COUNT" => "1000",	// Количество выводимых элементов
		"ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем элементы
		"ELEMENT_SORT_FIELD2" => "",	// Поле для второй сортировки элементов
		"ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки элементов
		"ELEMENT_SORT_ORDER2" => "",	// Порядок второй сортировки элементов
		"FILTER_NAME" => "filterpop",	// Имя массива со значениями фильтра для фильтрации элементов
		"HIDE_NOT_AVAILABLE" => "N",	// Недоступные товары
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",	// Недоступные торговые предложения
		"IBLOCK_ID" => "40",	// Инфоблок
		"IBLOCK_TYPE" => "1c_catalog",	// Тип инфоблока
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "3",	// Количество элементов выводимых в одной строке таблицы
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"OFFERS_CART_PROPERTIES" => "",
		"OFFERS_FIELD_CODE" => "",
		"OFFERS_LIMIT" => "5",	// Максимальное количество предложений для показа (0 - все)
		"OFFERS_PROPERTY_CODE" => "",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "timestamp_x",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
		"PRICE_CODE" => array(	// Тип цены
			0 => "Розничная",
		),
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
		"PRODUCT_PROPERTIES" => "",	// Характеристики товара
		"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",	// Название переменной, в которой передается количество товара
		"PROPERTY_CODE" => array(	// Свойства
			0 => "",
			1 => "",
		),
		"ROTATE_TIMER" => "30",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "/internet_shop/#SECTION_CODE_PATH#/",	// URL, ведущий на страницу с содержимым раздела
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"SHOW_CLOSE_POPUP" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PAGINATION" => "Y",
		"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
		"TEMPLATE_THEME" => "blue",
		"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
		"USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
		"VIEW_MODE" => "BANNER",
		'NO_TITLE' => "ПОПУЛЯРНЫЕ ТОВАРЫ",
		//'LINK_TITLE' => "/internet_shop/sale/",
		//'LINK_CLASS' => "orange_width_border text-bold orange_animeorange",
		'PORYADOK'=>$filterpop['ID'],
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
); ?>