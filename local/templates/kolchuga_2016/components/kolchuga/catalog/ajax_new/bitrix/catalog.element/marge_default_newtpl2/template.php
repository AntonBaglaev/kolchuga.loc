<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$photo_ids = array();

$detPicAlt = ((isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && !empty($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]))? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] : $arResult["NAME"]);

$detPicTitle = ((isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && !empty($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]))? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] : $arResult["NAME"]);

if($arResult['DETAIL_PICTURE']['ID'] > 0) $photo_ids[] = $arResult['DETAIL_PICTURE']['ID'];

if(is_array($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])) $photo_ids = array_merge($photo_ids, $arResult['PROPERTIES']['MORE_PHOTO']['VALUE']);
?>

<div class="catalog__detail--item">
    <div class="catalog__detail--left">
        <?include ($_SERVER["DOCUMENT_ROOT"].$templateFolder."/detail_left.php");?>
    </div>
	
	<?$check_sizes = array();
	if(!empty($arResult['SKU_ARR'])){
		foreach($arResult['SKU_ARR'] as $item){
			$check_sizes[] = $item['PROPERTY_RAZMER_VALUE'];
		}
		$check_sizes = array_unique($check_sizes);
	}
	if(count($check_sizes) == 1 && $check_sizes[0] == ''){
		$arResult['SKU'] = false;

	}
	$sku_id = 0;
	if($arResult['SKU'] && $arResult['SKU_COUNT'] > 0){		
		foreach($arResult['SKU_ARR'] as $code => $item){
			$sku_id = $item['ID'];			
		}		
	}
	$arResult['OLD_PRICE']=str_replace(',','.',$arResult['OLD_PRICE']);
	 if(intval($arResult['OLD_PRICE'])>0){$oldprice_init=round(preg_replace("/[^0-9.]/", '', $arResult['OLD_PRICE']));}
	 $otPrice=0;
	 if($arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE_OT']){
		 $otPrice=round(preg_replace("/[^0-9.]/", '', $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE_OT']));
	 }else{
		 $otPrice=$arResult['MIN_PRICE']['DISCOUNT_VALUE'];
	 }
	 if($oldprice_init<=$otPrice){$arResult['OLD_PRICE']=false;}
	?>
	
	
	<div class="catalog__detail--right">
		<div class="detail-desc">

			<!-- title-block  *******************************************************************************************************-->
			<div class="title-block">
				<h1 class="js-page-title"><?=exCSite::ShowH1()?></h1>
				<?
				if(!empty($arResult['BRAND_IMG'])){?>
					<a href="#" class="brand-img"><img src="<?php echo $arResult['BRAND_IMG'] ?>"></a>
				<? } ?>
				<?if(!empty($arResult['PROPERTIES']['BREND_STRANITSA_BRENDA']['MASSA']['IBLOCK_13']['SRC'])){?>
					<a href="<?=(!empty($arResult['PROPERTIES']['BREND_STRANITSA_BRENDA']['MASSA']['UF_LINK']) ? '/brands/'.$arResult['PROPERTIES']['BREND_STRANITSA_BRENDA']['MASSA']['UF_LINK'].'/':'javascript:void(0);')?>" class="brand-img"><img src="<?php echo $arResult['PROPERTIES']['BREND_STRANITSA_BRENDA']['MASSA']['IBLOCK_13']['SRC'] ?>"></a>
				<?}?>
			</div>
			
			<!-- price-block  *******************************************************************************************************-->

			<div class="price-block">
			<?//if($arResult['PROPERTIES']['TREBUETSYA_LITSENZIYA']['VALUE']){?>
				<div class="price js-price-block">
					<?if(!$arResult['CAN_BUY']){?>
					<?}else{?>
					
						<span class="js-price new-price"><?= ($arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE_OT'] ? $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE_OT']:$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'])?></span>
						<? if ($arResult['OLD_PRICE']): ?>
						<div class="old-price">
							<span class="promo">Акция</span>
							<span class="crossed"><?=$arResult['OLD_PRICE']?></span>
						</div>
						<? endif ?>
						<? if ($arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']): ?>
							  <span class="line_diff_price">(-<?=$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>%)</span>
						<? endif ?>
					<?}?>
				</div>
				
				<div class="buy-block catalog__btn text-center">
					<?include ($_SERVER["DOCUMENT_ROOT"].$templateFolder."/buy_block.php");?>
				</div>
			<?//}else{
				/* ?>
				<span style="font-size:1.2em;color:#EA5B35;display: block;background-color: #f3f3f3; padding: 10px;  border-left: 2px solid #ea5b35">
					Салоны «Кольчуга» открыты <br>Интернет-магазин сегодня не работает<br>Спасибо за понимание.
					</span>
			<? */
			//}?>
			</div>
			
			<!-- size_list  *******************************************************************************************************-->
			
			<?if ( (is_array($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) && count($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) > 1) && $arResult['SKU_COUNT'] > 0 ){ ?>
				<?include ($_SERVER["DOCUMENT_ROOT"].$templateFolder."/size_list2.php");?>
			<?}?>
			
			<div class="desc-block">
				<!-- features  *******************************************************************************************************-->
				
				<div class="features">				
					<h4>Характеристики</h4>
					<ul>
						<?foreach($arResult['DISPLAY_PROPERTIES'] as $prop):
							if(!$prop['DISPLAY_VALUE'] || $prop['CODE'] == 'TREBUETSYA_LITSENZIYA') continue?>
							<li>
								<span class="caption"><?= $prop['NAME']?></span>
								<?if($prop['CODE'] == 'BREND' && !empty($arResult['PROPERTIES']['BREND_STRANITSA_BRENDA']['MASSA']['UF_LINK'])){?>
									<a href="/brands/<?=$arResult['PROPERTIES']['BREND_STRANITSA_BRENDA']['MASSA']['UF_LINK']?>/"><span><?=$prop['DISPLAY_VALUE']?></span></a>
								<?}else{?>
									<span><?= is_array($prop['DISPLAY_VALUE']) ? implode(' / ', $prop['DISPLAY_VALUE']) : $prop['DISPLAY_VALUE']?></span>
								<?}?>
							</li>
						<?endforeach;?>
					</ul>
				</div>
				
				<!-- availability  *******************************************************************************************************-->
				
				<?if ( (is_array($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) &&  count($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) > 1) && $arResult['SKU_COUNT'] > 0 ){ ?>
					<div class="availability">
						<div class="catalog__option-list">
							<?							
							if($arResult['SKU'] && $arResult['SKU_COUNT'] > 0):?>
								<div class="catalog__option-list__item">
									<select name="SKU_SIZE"<?=$arResult['SKU_COUNT'] > 1 ? '' : ' disabled'?>>
										<?if($arResult['SKU_COUNT'] > 1):?>
											<option value="">Выбрать размер</option>
										<?endif;
										foreach($arResult['TABLE_RAZMER_ARR']['SKU'] as $availSize0){ 
											foreach($availSize0 as $availSize){
												?>
												<option data-value="<?= $availSize['tovar']?>"
													data-price="<?= $availSize['price']?>"
													data-discount="<?= $availSize['discount']?>"
													data-percent="<?= $availSize['percent']?>"
													data-max="<?= $availSize['max']?>"><?=$availSize['razmer']?><?=$arResult['TABLE_RAZMER_ARR']['ONE'][$availSize['razmer']] == 1
													? ' (Только 1 в наличии)' : '';?></option>
												<?
											}
											break;
										}
										?>
									</select>																	
								</div>
							<?endif;?>
						</div>
						<input class="jq-q" type="hidden" value="1">
					</div>
				<?}elseif ($arResult["CATALOG_QUANTITY"] > 0 ) {?>
					<div class="availability">
						<h4><?=GetMessage("CT_CATALOG_AVAILABLE_".(($arResult['CAN_BUY'])? "Y" : "N"));?></h4>
						
						<ul>
						<?if(!empty($arResult['LIST_DOSTUPNOST_ITEM'])){?>
							<?foreach($arResult['LIST_DOSTUPNOST_ITEM'][0]['SET_SKLAD'] as $store):?>
								<li class="<?= $store['PRODUCT_ID'][$arResult['LIST_DOSTUPNOST_ITEM'][0]['ID']] > 0 ? 'onstock' : 'offstock'?>"><a href="<?= $store['DETAIL_PAGE_URL']?>"><?= $store['NAME']?></a></li>
							<?endforeach;?>
						<?}else{?>
							<?foreach($arResult['SKU_ARR'] as $store_prod):?>
								<?if($arResult['ID']==$store_prod['ID']){?>
									<?foreach($store_prod['SET_SKLAD'] as $avail_klad){ ?>
									<li class="<?= $avail_klad['PRODUCT_ID'][$store_prod['ID']] > 0 ? 'onstock' : 'offstock'?>"><a href="<?= $avail_klad['DETAIL_PAGE_URL']?>"><?= $avail_klad['NAME']?></a></li>
									<?}?>
								<?}?>
							<?endforeach;?>
						<?}?>
						</ul>
					</div>
				<? } ?>
				<?if(!empty($arResult['SETKA'])){?><div class=""><a class="popup-modal order-btn setka" href="#modal-setka" style="display: block" rel="nofollow" >Таблица размеров</a></div><?}?>
			</div>
			<?//now social?>
			<? if (/* !$arResult['CHECK_PAGE_SIZES'] ||  */count($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) < 2 && $arResult['SKU_COUNT'] < 1){ ?>
				<div class="social">
					<?$APPLICATION->IncludeComponent(
						"arturgolubev:yandex.share", 
						".default", 
						array(
							"COMPONENT_TEMPLATE" => ".default",
							"VISUAL_STYLE" => "counters",
							"SERVISE_LIST" => array(
								0 => "vkontakte",
								//1 => "facebook",
								//2 => "odnoklassniki",
								//3 => "moimir",
								//4 => "twitter",
								//5 => "linkedin",
								//6 => "lj",
								//7 => "tumblr",
								8 => "viber",
								9 => "whatsapp",
								10 => "telegram",
							),
							"TEXT_ALIGN" => "ar_al_left",
							"TEXT_BEFORE" => "Поделиться:",
							"DATA_TITLE" => "",
							"DATA_RESCRIPTION" => "",
							"DATA_IMAGE" => "",
							"DATA_URL" => "",
							"COUNT_FOR_SMALL" => "3"
						),
						false
					);?>
				</div>
			<?}?>
		</div>
	</div>   
</div>
<? if (/* $arResult['CHECK_PAGE_SIZES'] || */ is_array($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) && count($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) > 1 && $arResult['SKU_COUNT'] > 0){ ?>
	<div class="detail-desc">
		<div class="social">
			<?$APPLICATION->IncludeComponent(
				"arturgolubev:yandex.share", 
				".default", 
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"VISUAL_STYLE" => "counters",
					"SERVISE_LIST" => array(
						0 => "vkontakte",
						//1 => "facebook",
						//2 => "odnoklassniki",
						//3 => "moimir",
						//4 => "twitter",
						//5 => "linkedin",
						//6 => "lj",
						//7 => "tumblr",
						8 => "viber",
						9 => "whatsapp",
						10 => "telegram",
					),
					"TEXT_ALIGN" => "ar_al_left",
					"TEXT_BEFORE" => "Поделиться:",
					"DATA_TITLE" => "",
					"DATA_RESCRIPTION" => "",
					"DATA_IMAGE" => "",
					"DATA_URL" => "",
					"COUNT_FOR_SMALL" => "3"
				),
				false
			);?>
		</div>
	</div>
<?}?>
<div class="description-block item-description-block">
    <?= $arResult['DETAIL_TEXT']?>
</div>
<?$APPLICATION->IncludeComponent("intervolga:conversionpro.productdetail", ".default", array(
	"COMPONENT_TEMPLATE" => ".default",
		"ID" => $arResult["ID"],
		"NAME" => $arResult["NAME"],
		"PRICE" => $arResult["MIN_PRICE"]["DISCOUNT_VALUE"],
		"CURRENCY" => $arResult["MIN_PRICE"]["CURRENCY"]
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?>

<br><br>

<? if ($arResult['PROPERTIES']['RELAYTED']['VALUE']): ?>

    <?
    $GLOBALS["elementRelated"] = array("ID"                      => $arResult['PROPERTIES']['RELAYTED']['VALUE'],
                                       "!DETAIL_PICTURE"         => false,
                                       "!=PROPERTY_IS_SKU_VALUE" => "Да",
                                       "CATALOG_AVAILABLE"       => "Y",
    );
    ?>


    <? $APPLICATION->IncludeComponent("bitrix:catalog.top", "catalog_top_related", array(
        "ACTION_VARIABLE"            => "action",    // Название переменной, в которой передается действие
        "ADD_PICT_PROP"              => "-",
        "ADD_PROPERTIES_TO_BASKET"   => "Y",    // Добавлять в корзину свойства товаров и предложений
        "ADD_TO_BASKET_ACTION"       => "ADD",
        "BASKET_URL"                 => "/personal/basket.php",    // URL, ведущий на страницу с корзиной покупателя
        "CACHE_FILTER"               => "N",    // Кешировать при установленном фильтре
        "CACHE_GROUPS"               => "Y",    // Учитывать права доступа
        "CACHE_TIME"                 => "36000000",    // Время кеширования (сек.)
        "CACHE_TYPE"                 => "A",    // Тип кеширования
        "COMPARE_PATH"               => "",    // Путь к странице сравнения
        "COMPATIBLE_MODE"            => "Y",    // Включить режим совместимости
        "COMPONENT_TEMPLATE"         => "carousel1",
        "CONVERT_CURRENCY"           => "Y",    // Показывать цены в одной валюте
        "CURRENCY_ID"                => "RUB",    // Валюта, в которую будут сконвертированы цены
        "CUSTOM_FILTER"              => "",    // Фильтр товаров
        "DETAIL_URL"                 => "/internet_shop/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",    // URL, ведущий на страницу с содержимым элемента раздела
        "DISPLAY_COMPARE"            => "Y",    // Разрешить сравнение товаров
        "ELEMENT_COUNT"              => "1000",    // Количество выводимых элементов
        "ELEMENT_SORT_FIELD"         => "sort",    // По какому полю сортируем элементы
        "ELEMENT_SORT_FIELD2"        => "",    // Поле для второй сортировки элементов
        "ELEMENT_SORT_ORDER"         => "asc",    // Порядок сортировки элементов
        "ELEMENT_SORT_ORDER2"        => "",    // Порядок второй сортировки элементов
        "FILTER_NAME"                => "elementRelated",    // Имя массива со значениями фильтра для фильтрации элементов
        "HIDE_NOT_AVAILABLE"         => "N",    // Недоступные товары
        "HIDE_NOT_AVAILABLE_OFFERS"  => "N",    // Недоступные торговые предложения
        "IBLOCK_ID"                  => "40",    // Инфоблок
        "IBLOCK_TYPE"                => "1c_catalog",    // Тип инфоблока
        "LABEL_PROP"                 => "-",
        "LINE_ELEMENT_COUNT"         => "3",    // Количество элементов выводимых в одной строке таблицы
        "MESS_BTN_ADD_TO_BASKET"     => "В корзину",
        "MESS_BTN_BUY"               => "Купить",
        "MESS_BTN_COMPARE"           => "Сравнить",
        "MESS_BTN_DETAIL"            => "Подробнее",
        "MESS_NOT_AVAILABLE"         => "Нет в наличии",
        "OFFERS_CART_PROPERTIES"     => "",
        "OFFERS_FIELD_CODE"          => "",
        "OFFERS_LIMIT"               => "5",    // Максимальное количество предложений для показа (0 - все)
        "OFFERS_PROPERTY_CODE"       => "",
        "OFFERS_SORT_FIELD"          => "sort",
        "OFFERS_SORT_FIELD2"         => "timestamp_x",
        "OFFERS_SORT_ORDER"          => "asc",
        "OFFERS_SORT_ORDER2"         => "desc",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",    // Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
        "PRICE_CODE"                 => array(    // Тип цены
                                                  0 => "Розничная",
        ),
        "PRICE_VAT_INCLUDE"          => "Y",    // Включать НДС в цену
        "PRODUCT_DISPLAY_MODE"       => "N",
        "PRODUCT_ID_VARIABLE"        => "id",    // Название переменной, в которой передается код товара для покупки
        "PRODUCT_PROPERTIES"         => "",    // Характеристики товара
        "PRODUCT_PROPS_VARIABLE"     => "prop",    // Название переменной, в которой передаются характеристики товара
        "PRODUCT_QUANTITY_VARIABLE"  => "quantity",    // Название переменной, в которой передается количество товара
        "PROPERTY_CODE"              => array(    // Свойства
                                                  0 => "",
                                                  1 => "",
        ),
        "ROTATE_TIMER"               => "30",
        "SECTION_ID_VARIABLE"        => "SECTION_ID",
        "SECTION_URL"                => "/internet_shop/#SECTION_CODE_PATH#/",    // URL, ведущий на страницу с содержимым раздела
        "SEF_MODE"                   => "N",    // Включить поддержку ЧПУ
        "SHOW_CLOSE_POPUP"           => "Y",
        "SHOW_DISCOUNT_PERCENT"      => "N",
        "SHOW_OLD_PRICE"             => "N",
        "SHOW_PAGINATION"            => "Y",
        "SHOW_PRICE_COUNT"           => "1",    // Выводить цены для количества
        "TEMPLATE_THEME"             => "blue",
        "USE_PRICE_COUNT"            => "N",    // Использовать вывод цен с диапазонами
        "USE_PRODUCT_QUANTITY"       => "N",    // Разрешить указание количества товара
        "VIEW_MODE"                  => "BANNER",
        'NO_TITLE'                   => "ПОПУЛЯРНЫЕ ТОВАРЫ",
        //'LINK_TITLE' => "/internet_shop/sale/",
        //'LINK_CLASS' => "orange_width_border text-bold orange_animeorange",
        'PORYADOK'                   => $filterpop['ID'],
    ),
        false,
        array(
            "ACTIVE_COMPONENT" => "Y"
        )
    ); ?>

<? endif ?>
