<?
//echo print_r($_SESSION);

/*
if((int)$_COOKIE["intro_viewed"] == 0){
	header('Location: /intro.php');
	setcookie("intro_viewed", '1', time()+360000000, '/');
//        echo print_r($_SESSION);
	exit;
	
}	
*/
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->ShowTitle("Оружейный магазин \"Кольчуга\"");
$APPLICATION->SetPageProperty("title", "Кольчуга - оружейный магазин в Москве.");
$APPLICATION->SetPageProperty("tags", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords_inner", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords", "оружейный магазин, оружейный интернет-магазин, оружейный салон");
$APPLICATION->SetPageProperty("description", "Кольчуга - самый крупный оружейный магазин на российском рынке. Продажа оружия, патронов, оптики и многого другого на сайте Kolchuga.ru");
$APPLICATION->SetTitle("  ");?><?/*$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"slider.main", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "slider.main",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "DETAIL_TEXT",
			4 => "DETAIL_PICTURE",
			5 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "35",
		"IBLOCK_TYPE" => "banners",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
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
		"PROPERTY_CODE" => array(
			0 => "LINK",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	),
	false
);*/?> 
<style type="text/css">
.container-fluid.new_bread.d-none.d-md-block{display:none !important;}
</style>
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
<?
    // вывод блока
    $rest = CIBLockElement::GetList (Array(), Array('ACTIVE'=>'Y', 'IBLOCK_ID' => '62'), false, false, Array('*'));
    while ($db_item = $rest->GetNextElement())
    {
    $ar_rest[] = $db_item->GetProperties();
    }
    
    ?>
<section id="banners">
	<div class="banners dflex">
	<?foreach ($ar_rest as $val){?>
	<?
	$arFile = \Kolchuga\Pict::getWebpImgSrc( \CFile::GetPath($val["PICTURE"]['VALUE']) , $intQuality = 90);
	if(!empty($val["PICTURE_MOB"]['VALUE'])){
		$arFilemob = \Kolchuga\Pict::getWebpImgSrc( \CFile::GetPath($val["PICTURE_MOB"]['VALUE']) , $intQuality = 90);
	}
	?>
		<div class="banners__item banner">
			<a href="<?=$val["LINK"]['VALUE']?>">
				<?/*<img src="<?=CFile::GetPath($val["PICTURE"]['VALUE'])?>" class="<?if(!empty($val["PICTURE_MOB"]['VALUE'])){?>d-none d-md-block<?}?>" />
				<?if(!empty($val["PICTURE_MOB"]['VALUE'])){?><img src="<?=CFile::GetPath($val["PICTURE_MOB"]['VALUE'])?>" class="d-md-none" /><?}?>*/?>
				
				<picture class="<?if(!empty($val["PICTURE_MOB"]['VALUE'])){?>d-none d-md-block<?}?>">
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>"  />
				</picture>
				<?if(!empty($val["PICTURE_MOB"]['VALUE'])){?>
					<picture class="d-md-none">
						<?if ($arFilemob['DETAIL_PICTURE']['WEBP_SRC']) :?>
							<source type="image/webp" srcset="<?=$arFilemob['DETAIL_PICTURE']['WEBP_SRC']?>">
						<?endif;?>
						<img src="<?=$arFilemob["DETAIL_PICTURE"]["SRC"]?>" />
					</picture>
				<?}?>
			</a>
			<div class="banner__info">
				<div class="banner__title"><?=$val["TEXT_PICTURE"]['VALUE']?></div>
				<div class="banner__btn main__btn"><a href="<?=$val["LINK"]['VALUE']?>"><?=$val["TEXT_BTN"]['VALUE']?></a></div>
			</div>
		</div>
	<?}?>
	</div>
</section>

<?$APPLICATION->IncludeFile('/include/wsalon.php', array(), array())?>

<section id="catalog_banner">
	<?
	$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/banner_cat_1.png", $intQuality = 90)
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
					<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>"  />
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
					<img class="l-hide" src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>"  />
				</picture>
				<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/main-icon/content-icon/mob-patron.png", $intQuality = 90);?>
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img class="d-hide" src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>"  />
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
					<img class="l-hide" src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>"  />
				</picture>
				<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/main-icon/content-icon/mob-knife.png", $intQuality = 90);?>
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img class="d-hide" src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>"  />
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
					<a href="/internet_shop/aksessuary_dlya_okhoty/sumki/"><img src="/images/main-icon/content-icon/4.png"/><br>сумки</a>
				</div>
				<div class="content-icon__item">
					<a href="/internet_shop/suveniry/"><img src="/images/main-icon/content-icon/6.png"/><br>сувениры</a>
				</div>
				<div class="content-icon__item">
					<a href="/internet_shop/optika/"><img src="/images/main-icon/content-icon/5.png"/><br>оптика</a>
				</div>
				<div class="content-icon__item">
					<a href="/internet_shop/oruzheynye_aksessuary/"><img src="/images/main-icon/content-icon/1.png"/><br>ТЮНИНГ</a>
				</div>
				<div class="content-icon__item">
					<a href="/internet_shop/odezhda/"><img src="/images/main-icon/content-icon/2.png"/><br>ОДЕЖДА</a>
				</div>
				<div class="content-icon__item">
					<a href="/internet_shop/soputstvuyushchie_tovary/"><img src="/images/main-icon/content-icon/3.png"/><br>снаряжение</a>
				</div>
			</div>
		</div>
		<div class="content-block__item l-hide fixedfonutka" style="background-image: url(/images/A400_1.jpg);">
			<a href="/brands/beretta/beretta-ultraleggero/"><img src="/images/closeup-shot-flying-goose-with-clear-white4.png"></a>
		</div>
	</div>
</section>
<!--<div class="d-hide">
<? if($curPage == '/'){
    ?><? $APPLICATION->IncludeComponent("bitrix:main.include", "template23", Array(
	"AREA_FILE_SHOW" => "file",	// Показывать включаемую область
		"AREA_FILE_SUFFIX" => "inc",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_TEMPLATE" => "",	// Шаблон области по умолчанию
		"PATH" => SITE_DIR."en/include_content/footer.php",	// Путь к файлу области
	),
	false
); 
}?>
</div>-->
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
			<div class="section_title"><span>INSTAGRAM</span></div>
			<div class="instagram dflex">
				<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/vinci.jpg", $intQuality = 90);?>
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>"  />
				</picture>
				<?/* <img src="/images/vinci.jpg"> */?>
				<div class="sub-inst-block">
					<img src="/images/logo_88x88.png">
					<div class="inst-login">@kolchuga.ru</div>
					<div class="annonce__btn inst_btn"><a href="https://www.instagram.com/kolchuga.ru/">Подписаться</a></div>
				</div>
				<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/beretta_krahmaleva.jpg", $intQuality = 90);?>
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img class="img-hide" src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>"  />
				</picture>
				<?/* <img class="img-hide" src="/images/beretta_krahmaleva.jpg"> */?>
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
<?
/*$arSelect = Array("ID", "NAME", "PROPERTY_LINK", "PREVIEW_PICTURE", );
$arFilter = Array("IBLOCK_ID" => 36, "ID" => array("686528", "552668", "552669", "552670"));
$resBanners = CIBlockElement::GetList(Array('SORT' => 'ASC'), $arFilter, false, Array(), $arSelect);
while($obBanners = $resBanners->GetNextElement()) {
	$arBanners = $obBanners->GetFields();

	if($arBanners['ID'] == "552669" || $arBanners['ID'] == "552670") {
        $fileBanners = CFile::ResizeImageGet($arBanners['PREVIEW_PICTURE'], array('width'=>426, 'height'=>269), BX_RESIZE_IMAGE_EXACT, true);
        $arBanners['IMG_RESIZE_SRC'] = $fileBanners['src'];
		$arResultBanners['SMALL_BANNERS'][] = $arBanners;
    } elseif ($arBanners['ID'] == "686528" || $arBanners['ID'] == "552668") {
    	$fileBanners = CFile::ResizeImageGet($arBanners['PREVIEW_PICTURE'], array('width'=>426, 'height'=>555), BX_RESIZE_IMAGE_EXACT, true);
        $arBanners['IMG_RESIZE_SRC'] = $fileBanners['src'];
		$arResultBanners['BIG_BANNERS'][] = $arBanners;
    }
}*/
?>
	<!--<div class="banner-grid">
		<div class="banner-grid__row">

			<?php foreach ( $arResultBanners['BIG_BANNERS'] as $arBanner ): ?>
				<div class="banner-grid__col banner-grid__col_left">
					<a class="banner-grid__item" href="<?=$arBanner['PROPERTY_LINK_VALUE']?>">
						<img src="<?=$arBanner['IMG_RESIZE_SRC']?>" alt="">
					</a>
				</div>
			<?php endforeach ?>
			<?/*<div class="banner-grid__col">
				<? foreach ( $arResultBanners['SMALL_BANNERS'] as $arItem ): ?>
					<a class="banner-grid__item banner-grid__item_small" href="<?=$arItem['PROPERTY_LINK_VALUE']?>">
						<img src="<?=$arItem['IMG_RESIZE_SRC']?>" alt="">
					</a>
				<? endforeach ?>
			</div>*/?>
			<div class="banner-grid__col banner-grid__col_banner">
				<div class="news-grid__col">
					<? /*$APPLICATION->IncludeComponent(
						"bitrix:news.list",
						"article.list",
						Array (
							"ACTIVE_DATE_FORMAT" => "d/m/Y",
							"ADD_SECTIONS_CHAIN" => "Y",
							"AJAX_MODE" => "N",
							"AJAX_OPTION_ADDITIONAL" => "",
							"AJAX_OPTION_HISTORY" => "N",
							"AJAX_OPTION_JUMP" => "N",
							"AJAX_OPTION_STYLE" => "Y",
							"CACHE_FILTER" => "N",
							"CACHE_GROUPS" => "Y",
							"CACHE_TIME" => "36000000",
							"CACHE_TYPE" => "N",
							"CHECK_DATES" => "Y",
							"COMPONENT_TEMPLATE" => "article.list",
							"DETAIL_URL" => "",
							"DISPLAY_BOTTOM_PAGER" => "N",
							"DISPLAY_DATE" => "Y",
							"DISPLAY_NAME" => "Y",
							"DISPLAY_PICTURE" => "Y",
							"DISPLAY_PREVIEW_TEXT" => "Y",
							"DISPLAY_TOP_PAGER" => "N",
							"FIELD_CODE" => array ( 0 => "NAME", 1 => "PREVIEW_TEXT", 2 => "PREVIEW_PICTURE", 3 => "DETAIL_TEXT", 4 => "DETAIL_PICTURE", 5 => "", ),
							"FILTER_NAME" => "",
							"HIDE_LINK_WHEN_NO_DETAIL" => "N",
							"IBLOCK_ID" => "1",
							"IBLOCK_TYPE" => "news",
							"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
							"INCLUDE_SUBSECTIONS" => "Y",
							"MESSAGE_404" => "",
							"NEWS_COUNT" => "4",
							"PAGER_BASE_LINK_ENABLE" => "N",
							"PAGER_DESC_NUMBERING" => "N",
							"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
							"PAGER_SHOW_ALL" => "Y",
							"PAGER_SHOW_ALWAYS" => "N",
							"PAGER_TEMPLATE" => "",
							"PAGER_TITLE" => "Новости",
							"PARENT_SECTION" => "",
							"PARENT_SECTION_CODE" => "",
							"PREVIEW_TRUNCATE_LEN" => "300",
							"PROPERTY_CODE" => array ( 0 => "", 1 => "", ),
							"SET_BROWSER_TITLE" => "Y",
							"SET_LAST_MODIFIED" => "N",
							"SET_META_DESCRIPTION" => "N",
							"SET_META_KEYWORDS" => "N",
							"SET_STATUS_404" => "N",
							"SET_TITLE" => "N",
							"SHOW_404" => "N",
							"SORT_BY1" => "SORT",
							"SORT_BY2" => "SORT",
							"SORT_ORDER1" => "",
							"SORT_ORDER2" => "ASC"
						)
					);*/ ?>

<style>
.knopka {
    display: table;
    padding: 5px 20px;
    margin: auto;
    background: #21385e;
}
</style>
<br>
<div align="center" class="knopka"><a href="https://www.kolchuga.ru/news/" style="color: #ffffff">ВСЕ НОВОСТИ</a></div>

				</div>
			</div>
		</div>
	</div>-->
	<?/*<!--pre>arSort1 <?print_r($saleFilter);?></pre-->*/?>
<?$APPLICATION->IncludeComponent("bitrix:catalog.top", "catalog_sale", Array(
	"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/basket.php",	// URL, ведущий на страницу с корзиной покупателя
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "N",	// Тип кеширования
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
);?>


<section id="content-block">
	<div class="content-block content-block-second dflex">
		<div class="content-block__item l-hide">
		<?$arFile = \Kolchuga\Pict::getWebpImgSrc("/images/boar.png", $intQuality = 90);?>
			<picture>
				<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
					<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
				<?endif;?>
				<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>"  />
			</picture>
			<?/* <img src="/images/boar.png"> */?>
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
global $filtersle;
$filtersle = \Kolchuga\DopViborka::getListIndexTovar('Y');
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
		"CACHE_TYPE" => "N",	// Тип кеширования
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
		'NO_TITLE' => "SALE"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?>


<?/*$APPLICATION->IncludeComponent("bitrix:catalog.bigdata.products", ".default", array(
	"ACTION_VARIABLE" => "action",
		"ADDITIONAL_PICT_PROP_17" => "MORE_PHOTO",
		"ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",
		"ADDITIONAL_PICT_PROP_40" => "MORE_PHOTO",
		"ADDITIONAL_PICT_PROP_41" => "",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"BASKET_URL" => "/internet_shop/basket/",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"CART_PROPERTIES_17" => "",
		"CART_PROPERTIES_3" => "",
		"CART_PROPERTIES_40" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_41" => "",
		"COMPONENT_TEMPLATE" => ".default",
		"CONVERT_CURRENCY" => "N",
		"DEPTH" => "",
		"DETAIL_URL" => "",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "40",
		"IBLOCK_TYPE" => "1c_catalog",
		"ID" => $_REQUEST["PRODUCT_ID"],
		"LABEL_PROP_17" => "-",
		"LABEL_PROP_3" => "-",
		"LABEL_PROP_40" => "-",
		"LABEL_PROP_41" => "",
		"LINE_ELEMENT_COUNT" => "3",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"PAGE_ELEMENT_COUNT" => "100",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "Розничная",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE_17" => "",
		"PROPERTY_CODE_3" => "",
		"PROPERTY_CODE_40" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE_41" => "",
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_ELEMENT_CODE" => "",
		"SECTION_ELEMENT_ID" => "",
		"SECTION_ID" => "",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_IMAGE" => "Y",
		"SHOW_NAME" => "Y",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_PRODUCTS_17" => "N",
		"SHOW_PRODUCTS_3" => "N",
		"SHOW_PRODUCTS_40" => "Y",
		"SHOW_PRODUCTS_41" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_PRODUCT_QUANTITY" => "N"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);*/?>
<?/*$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"banner.main-grid-middle", 
	array(
		"ACTIVE_DATE_FORMAT" => "d/m/Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "banner.main-grid-middle",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "DETAIL_TEXT",
			4 => "DETAIL_PICTURE",
			5 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "36",
		"IBLOCK_TYPE" => "banners",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "10",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "LINK",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	),
	false
);*/?>
<?/*<br/>
<br/>
<h1 align="center">Интернет-магазин оружия и товаров для охоты</h1>
<br/>
<br/>*/?>
<?/*$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"",
	Array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_NOTES" => "",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"COUNT_ELEMENTS" => "N",
		"IBLOCK_ID" => "40",
		"IBLOCK_TYPE" => "",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => "",
		"SECTION_ID" => "",
		"SECTION_URL" => "/internet_shop/#SECTION_CODE_PATH#/",
		"SECTION_USER_FIELDS" => "",
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => "1",
		"VIEW_MODE" => "TEXT"
	)
	
);*/?>
<?/*<section id="catalog-items">
	<div class="catalog-items dflex">
		<div class="cat__item">
			<div class="item__product">
				<a href="#">
					<div class="catalog-item__name">Куртка Beretta GU031/T0439//010X </div>
					<div class="catalog-item__price">5 922 руб.</div>
					<img src="/images/item_1.png">
				</a>
			</div>
		</div>
		<div class="cat__item">
			<div class="item__product">
				<a href="#">
					<div class="catalog-item__name">Ружьё Benelli Argo-E Battue .308</div>
					<div class="catalog-item__price">202 980 руб.</div>
					<img src="/images/item_2.png">
				</a>
			</div>
			<div class="item__product">
				<a href="#">
					<div class="catalog-item__name">Ружьё Beretta 694 Sport 12/76, 71 OCHP</div>
					<div class="catalog-item__price">373 115 руб.</div>
					<img src="/images/item_3.png">
				</a>
			</div>
			<div class="cat__item__bottom dflex">
				<div class="item__product">
					<a href="#">
						<div class="catalog-item__name">Прицел Zeiss Conquest DL 2-8x42 к 6 ASV-H 525441-9906-030</div>
						<div class="catalog-item__price">99 320 руб.</div>
						<img src="/images/item_4.png">
					</a>
				</div>
				<div class="item__product ">
					<a href="#">
						<div class="catalog-item__name">Нож складной Viper V4894BK</div>
						<div class="catalog-item__price">7 430 руб</div>
						<img src="/images/item_5.png">
					</a>
				</div>
			</div>
		</div>
	</div>
</section>*/?>
<?// вывод блока
$res = CIBLockElement::GetList (Array(), Array('ACTIVE'=>'Y', 'IBLOCK_ID' => '63'), false, false, Array('*'));
while ($db_item = $res->GetNextElement())
{
    $ar_res[] = $db_item->GetProperties();
}


//var_dump($ar_res);
?>
<section id="news-list">
	<div class="news-list dflex">
		<? foreach ($ar_res as $val){?>
		<div class="news-list__item news-item dflex">
			<?/*<?$arFile = \Kolchuga\Pict::getWebpImgSrc( \CFile::GetPath($val["IMG"]["VALUE"]), $intQuality = 90);?>
			<picture onclick="window.location.href='<?=$val["LINK"]["VALUE"]?>'">
				<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
					<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
				<?endif;?>
				<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>"  />
			</picture>*/?>
			<img src="<?=CFile::GetPath($val["IMG"]["VALUE"])?>" onclick="window.location.href='<?=$val["LINK"]["VALUE"]?>'">
			<div class="news-item_annonce annonce">
				<div class="annonce__title"><?=$val["TITLE"]["VALUE"]?></div>
				<div class="annonce__text"><?=$val["TEXT"]["VALUE"]?></div>
				<div class="annonce__btn"><a href="<?=$val["LINK"]["VALUE"]?>"><?=$val["TEXT_BTN"]["VALUE"]?></a></div>
			</div>
		</div>
		<?}?>
		
	</div>
</section>
<?$APPLICATION->IncludeFile('/include/wasbanner_catalog_index.php', array(), array());?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>