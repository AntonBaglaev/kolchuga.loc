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
	foreach(reset($arResult['SKU']) as $item){
		$check_sizes[] = $item['PROPERTY_RAZMER_VALUE'];
	}
	$check_sizes = array_unique($check_sizes);
	if(count($check_sizes) == 1 && $check_sizes[0] == ''){
		$arResult['SKU'] = false;

	}
	$sku_id = 0;
	if($arResult['SKU'] && $arResult['SKU_COUNT'] > 0){
		foreach(reset($arResult['SKU']) as $code => $item){
			$sku_id = $item['ID'];
		}			
		$arResult['MIN_PRICE'] = reset($arResult['SKU'])[0]['MIN_PRICE'];
	}?>
	
	
	<div class="catalog__detail--right">
		<div class="detail-desc">

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

			<div class="price-block">
				<div class="price js-price-block">
					<?if(!$arResult['CAN_BUY']){?>
					<?}else{?>
						<span class="js-price new-price"><?= $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></span>
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
			</div>
			
			<?if ( (/* $arResult['CHECK_PAGE_SIZES'] ||  */count($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) > 1) && $arResult['SKU_COUNT'] > 0 ){ ?>
				<?include ($_SERVER["DOCUMENT_ROOT"].$templateFolder."/size_list.php");?>
			<?}?>
			<div class="desc-block">
				<div class="features">
				<?//\Kolchuga\Settings::xmp($arResult['PROPERTIES']['BREND_STRANITSA_BRENDA'],11460, __FILE__.": ".__LINE__);?>
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
				
				<?if ( (/* $arResult['CHECK_PAGE_SIZES'] || */ count($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) > 1) && $arResult['SKU_COUNT'] > 0 ){ ?>
					<div class="availability">
						<div class="catalog__option-list">
							<?
							/* check sizes */
							$check_sizes = array();
							foreach(reset($arResult['SKU']) as $item){
								$check_sizes[] = $item['PROPERTY_RAZMER_VALUE'];
							}
							$check_sizes = array_unique($check_sizes);
							if(count($check_sizes) == 1 && $check_sizes[0] == ''){
								$arResult['SKU'] = false;

							}
							$sku_id = 0;
							if($arResult['SKU'] && $arResult['SKU_COUNT'] > 0):?>
								<div class="catalog__option-list__item">
									<select name="SKU_SIZE"<?=$arResult['SKU_COUNT'] > 1 ? '' : ' disabled'?>>
										<?if($arResult['SKU_COUNT'] > 1):?>
											<option value="">Выбрать размер</option>
										<?endif;
										foreach(reset($arResult['SKU']) as $code => $item):?>
											<option value="<?= $item['ID']?>"
													data-price="<?=$item['MIN_PRICE']['PRINT_VALUE']?>"
													data-discount="<?=$item['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?>"
													data-percent="<?=$item['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>"
													data-max="<?=$item['CATALOG_QUANTITY']?>"><?= $item['PROPERTY_RAZMER_VALUE']?><?=$item['CATALOG_QUANTITY'] == 1
													? ' (Только 1 в наличии)' : '';?></option>
											<?$sku_id = $item['ID'];
										endforeach;?>
									</select>								
									<?/* <div class="alert-size">
										<div class="alert alert-warning">Выберите размер</div>
									</div> */?>
								</div>
								<?$arResult['MIN_PRICE'] = reset($arResult['SKU'])[0]['MIN_PRICE'];
							endif;?>
						</div>
						<input class="jq-q" type="hidden" value="1">
					</div>
				<?}elseif ($arResult["CATALOG_QUANTITY"] > 0 ) {?>
					<div class="availability">
						<h4><?=GetMessage("CT_CATALOG_AVAILABLE_".(($arResult['CAN_BUY'])? "Y" : "N"));?></h4>
						<!-- <span class="caption">Склад:</span> -->
						<ul>
							<?foreach($arResult['STORES'] as $store):?>
								<li class="<?= $store['AMOUNT'] > 0 ? 'onstock' : 'offstock'?>"><a href="<?= $store['LINK']?>"><?= $store['NAME']?></a></li>
							<?endforeach;?>
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
								1 => "facebook",
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
<? if (/* $arResult['CHECK_PAGE_SIZES'] || */ count($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) > 1 && $arResult['SKU_COUNT'] > 0){ ?>
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
						1 => "facebook",
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
