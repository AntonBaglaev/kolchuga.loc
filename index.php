<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->ShowTitle("Оружейный магазин \"Кольчуга\"");
$APPLICATION->SetPageProperty("title", "Кольчуга - оружейный магазин в Москве.");
$APPLICATION->SetPageProperty("tags", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords_inner", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords", "оружейный магазин, оружейный интернет-магазин, оружейный салон");
$APPLICATION->SetPageProperty("description", "Кольчуга - самый крупный оружейный магазин на российском рынке. Продажа оружия, патронов, оптики и многого другого на сайте Kolchuga.ru");
$APPLICATION->SetTitle("  ");?>

<?$APPLICATION->IncludeComponent(
	"bitrix:photo.section", 
	"brands.carousel", 
	array(
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "brands.carousel",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "arrFilter",
		"IBLOCK_ID" => "13",
		"IBLOCK_TYPE" => "users",
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
		"PAGE_ELEMENT_COUNT" => "100",
		"PROPERTY_CODE" => array(
			0 => "email",
			1 => "",
		),
		"SECTION_CODE" => "",
		"SECTION_ID" => "45",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N"
	),
	false
);?>
<?/*if ($USER->GetID()=="11460"){?><?}*/?>
	<?$APPLICATION->IncludeFile('/include/marquee.php', array(), array())?>	

<?$APPLICATION->IncludeFile('/include/twobanners.php', array(), array())?>	
<?$APPLICATION->IncludeFile('/include/wsalon2.php', array(), array())?>

<section id="catalog_banner">
	<?
	$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/block_catalog.jpg", $intQuality = 90)
	?>
	<div class="catalog_banner" onclick="javascript:location.href='/internet_shop/'" style="cursor: pointer;background-image: url(<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>)" data-bg="<?=$arFile['DETAIL_PICTURE']['SRC']?>" data-bg-webp="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
		<div class="catalog-banner-info">
			<div class="banner-info__title">Каталог оружия и боеприпасов</div>
			<div class="banner-info__text">Весь ассортимент оружейных салонов в едином электроном каталоге. Вы можете зарезервировать оружие и патроны он-лайн, а после оплатить и получить в одном из наших оружейных салонов.</div>
			<div class="banner__btn main__btn"><a href="/internet_shop/">Весь каталог </a></div>		
		</div>
	</div>
	<div class="catalog-list dflex">
		<div class="catalog-list__item">
			<a href="/internet_shop/oruzhie/">
				<div class="section_title"><span>ОРУЖИЕ</span></div>
				<?/* <img src="/images/cat_1.png" /> */?>
				<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/cat_1.png", $intQuality = 90);?>
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" alt="ОРУЖИЕ" />
				</picture>
			</a>
		</div>
		<div class="catalog-list__item">
			<a href="/internet_shop/patrony/">
				<div class="section_title"><span>патроны</span></div>
				<?/* <img class="l-hide" src="/images/cat_2.png" />
				<img class="d-hide" src="/images/main-icon/content-icon/mob-patron.png"> */?>
				<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/cat_2.png", $intQuality = 90);?>
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img class="l-hide" src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" alt="патроны" />
				</picture>
				<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/main-icon/content-icon/mob-patron.png", $intQuality = 90);?>
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img class="d-hide" src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" alt="патроны 2" />
				</picture>
			</a>
		</div>
		<div class="catalog-list__item">
			<a href="/internet_shop/nozhi/">
				<div class="section_title"><span>НОЖИ</span></div>
				<?/* <img class="l-hide" src="/images/cat_3.png" />
				<img class="d-hide" src="/images/main-icon/content-icon/mob-knife.png"> */?>
				<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/cat_3.png", $intQuality = 90);?>
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img class="l-hide" src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" alt="НОЖИ" />
				</picture>
				<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/main-icon/content-icon/mob-knife.png", $intQuality = 90);?>
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img class="d-hide" src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" alt="НОЖИ 2" />
				</picture>
			</a>
		</div>
	</div>
</section>
<section id="content-block">
	<div class="content-block dflex bird-mt-20">
		<div class="content-block__item">
			<div class="content__info">
				<h1 class="content-title">Интернет-магазин товаров для охоты, спортивной стрельбы и туризма</h1>
				<div class="content-text l-hide">Профессиональные консультанты помогут сориентироваться в большом ассортименте оптики, снаряжения и оружейных аксессуаров. Товары, не требующие лицензии, мы доставляем по всей России.</div>
			</div>
			<div class="content-icon dflex">
				<div class="content-icon__item">	
					<a href="/internet_shop/aksessuary_dlya_okhoty/sumki/"><img src="/images/main-icon/content-icon/4.png" alt="сумки" /><br>сумки</a>
				</div>
				<div class="content-icon__item">
					<a href="/internet_shop/suveniry/"><img src="/images/main-icon/content-icon/6.png" alt="сувениры" /><br>сувениры</a>
				</div>
				<div class="content-icon__item">
					<a href="/internet_shop/optika/"><img src="/images/main-icon/content-icon/5.png" alt="оптика" /><br>оптика</a>
				</div>
				<div class="content-icon__item">
					<a href="/internet_shop/oruzheynye_aksessuary/"><img src="/images/main-icon/content-icon/1.png" alt="ТЮНИНГ" /><br>ТЮНИНГ</a>
				</div>
				<div class="content-icon__item">
					<a href="/internet_shop/odezhda/"><img src="/images/main-icon/content-icon/2.png" alt="ОДЕЖДА" /><br>ОДЕЖДА</a>
				</div>
				<div class="content-icon__item">
					<a href="/internet_shop/soputstvuyushchie_tovary/"><img src="/images/main-icon/content-icon/3.png" alt="снаряжение" /><br>снаряжение</a>
				</div>
			</div>
		</div>
		<div class="content-block__item l-hide fixedfonutka" style="background-image: url(/images/A400_1.jpg);">
			<a href="/brands/beretta/beretta-ultraleggero/"><img src="/images/closeup-shot-flying-goose-with-clear-white4.png" alt="beretta ultraleggero"></a>
		</div>
	</div>
</section>
<section id="client">
	<div class="client">
		<div class="rewievs_block">
			<div class="section_title"><span>Отзывы</span></div>
			<div class="rewievs owl-carousel owl-theme">
				<div class="rewiev_item">
					<div class="rewiev_text">Отличный магазин. В наличии всегда гладкоствольное и нарезное оружие, одежда для охоты и стрелкового спорта. Много мелочей для ухода за оружием.</div>
					<div class="rewiev_author"><p class="author_name">Андрей,</p> Яндекс отзывы</div>
				</div>
				<div class="rewiev_item">
					<div class="rewiev_text">Отличный магазин! Большой выбор охотничьих ружей и аксессуаров. Продавцы знают товар. Рекомендую!</div>
					<div class="rewiev_author"><p class="author_name">Андрей Лобовкин,</p>Яндекс отзывы</div>
				</div>
                <div class="rewiev_item">
					<div class="rewiev_text">Невероятно красивый и ухоженный магазин! А какой ассортимент там холодного оружия! Музей, а не магазин!</div>
					<div class="rewiev_author"><p class="author_name">Вера,</p>Яндекс отзывы</div>
				</div>
                <div class="rewiev_item">
					<div class="rewiev_text">Отличный охотничий магазин. Приезжал сюда с Камчатки за ружьем)</div>
					<div class="rewiev_author"><p class="author_name">Павел Макаров,</p> Яндекс отзывы</div>
				</div>
                <div class="rewiev_item">
					<div class="rewiev_text">Лучший магазин про оружие! Все есть - ассортимент просто огонь. по ценам бывает дешевле чем на окраинах. Люди - ВСЕ про сервис! Станислав, Евгений, Дима из оружейного привет!</div>
					<div class="rewiev_author"><p class="author_name">maxim g,</p> Яндекс отзывы</div>
				</div>
			</div>
		</div>
		<div class="inst_block">
			<div class="section_title"><span>VK</span></div>
			<div class="instagram dflex">
				<?//$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/vinci.jpg", $intQuality = 90);?>
				<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/insta3.jpg", $intQuality = 90);?>
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" alt="VK 1" />
				</picture>				
				<div class="sub-inst-block">
					<img src="/images/logo_88x88.png" alt="logo subscribe instagram">
					<div class="inst-login">@kolchugashop</div>
					<div class="annonce__btn inst_btn"><a href="https://vk.com/kolchugashop">Подписаться</a></div>
				</div>
				<?//$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/beretta_krahmaleva.jpg", $intQuality = 90);?>
				<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/insta2.jpg", $intQuality = 90);?>
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img class="img-hide" src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" alt="VK 2" />
				</picture>				
			</div>
		</div>
	</div>
</section>
<script>
	$(document).ready(function(){
		$('.rewievs').owlCarousel({
			loop:true,
			items:1,
			dots:false,
			nav:true,
			navText:['<span class="icon-arrow-left3"></span>','<span class="icon-arrow-right3"></span>'],
		});
	});
</script>
<? $APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
    "AREA_FILE_SHOW" => "sect",
    "AREA_FILE_SUFFIX" => "sal",
    "AREA_FILE_RECURSIVE" => "N",
    "EDIT_TEMPLATE" => ""
),
    false,
    array(
        "ACTIVE_COMPONENT" => "Y"
    )
); ?>
<div class="l-hide">
<?

if($curPage == '/'){
    ?><? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
	"AREA_FILE_SHOW" => "file",	// Показывать включаемую область
		"AREA_FILE_SUFFIX" => "inc",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_TEMPLATE" => "",	// Шаблон области по умолчанию
		"PATH" => SITE_DIR."en/include_content/footer.php",	// Путь к файлу области
	),
	false
); 
}?>
</div>

	
<?/* $APPLICATION->IncludeComponent("bitrix:catalog.top", "catalog_sale", Array(
	"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/basket.php",	// URL, ведущий на страницу с корзиной покупателя
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "Y",	// Тип кеширования
		"COMPARE_PATH" => "",	// Путь к странице сравнения
		"COMPATIBLE_MODE" => "Y",	// Включить режим совместимости
		"COMPONENT_TEMPLATE" => "carousel1",
		"CONVERT_CURRENCY" => "Y",	// Показывать цены в одной валюте
		"CURRENCY_ID" => "RUB",	// Валюта, в которую будут сконвертированы цены
		"CUSTOM_FILTER" => "",	// Фильтр товаров
		"DETAIL_URL" => "/internet_shop/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",	// URL, ведущий на страницу с содержимым элемента раздела
		"DISPLAY_COMPARE" => "Y",	// Разрешить сравнение товаров
		"ELEMENT_COUNT" => "100",	// Количество выводимых элементов
		"ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем элементы
		"ELEMENT_SORT_FIELD2" => "",	// Поле для второй сортировки элементов
		"ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки элементов
		"ELEMENT_SORT_ORDER2" => "",	// Порядок второй сортировки элементов
		"FILTER_NAME" => "saleFilter",	// Имя массива со значениями фильтра для фильтрации элементов
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
		"VIEW_MODE" => "BANNER"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
); */?>

<?$APPLICATION->IncludeFile('/include/populyar_index.php', array(), array())?>

<section id="content-block-2">
	<div class="content-block content-block-second dflex">
		<div class="content-block__item l-hide">
		<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/boar.png", $intQuality = 90);?>
			<picture>
				<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
					<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
				<?endif;?>
				<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" alt="boar" />
			</picture>
			
		</div>
		<div class="content-block__item">
			<div class="content__info">
				<div class="content-title">Цены на оружие, патроны и снаряжение</div>
				<div class="content-text"> Более 25 лет мы импортируем и реализуем продукцию ведущих зарубежных брендов с соблюдением всех норм законодательства. Предлагая на этих условиях высокий уровень сервиса и широкий ассортиментный ряд, мы сохраняем разумные цены на товары премиального качества. Дисконтная программа и регулярные акции помогут купить гражданское оружие, патроны, оптику и снаряжение в оружейных салонах «Кольчуга» с существенными скидками.</div>
				<div class="main__btn l-hide"><a href="/internet_shop/sale/">Все товары со скидкой</a></div>
			</div>
		</div>
		
	</div>
</section>
<?
/* global $filtersle;
$filtersle = \Kolchuga\DopViborka::getListIndexTovar('Y');
//echo "<pre style='text-align:left;display:none;'>";print_r($filtersle);echo "</pre>";
//\Kolchuga\Settings::xmp($filtersle,11460, __FILE__.": ".__LINE__);
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
		"FILTER_NAME" => "filtersle",	// Имя массива со значениями фильтра для фильтрации элементов
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
		'NO_TITLE' => "Распродажа",
		'LINK_TITLE' => "/internet_shop/sale/",
		'LINK_CLASS' => "orange_width_border text-bold orange_animeorange",
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
); */?>


<? $APPLICATION->IncludeComponent("bitrix:news.index", "action.list", array(
        "IBLOCK_TYPE"        => "",
        "IBLOCKS"            => array('63'),
        "NEWS_COUNT"         => "2",
        "FIELD_CODE"         => array("ID", "CODE", 'PREVIEW_PICTURE'),
        "SORT_BY1"           => "SORT",
        "SORT_ORDER1"        => "ASC",
        "SORT_BY2"           => "ACTIVE_FROM",
        "SORT_ORDER2"        => "DESC",
        "DETAIL_URL"         => "",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "CACHE_TYPE"         => "N",
        "CACHE_TIME"         => "300",
        "CACHE_GROUPS"       => "Y",
        "FILTER_NAME"        => "arrFilterNews",
        "PROPERTY_CODE"      => array("TITLE", "IMG", "TEXT", "LINK", "TEXT_BTN"),
    )
); ?>

<?$APPLICATION->IncludeFile('/include/wasbanner_catalog_index.php', array(), array());?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>