<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?if(empty($arResult["ITEMS"])):?>
	<?echo GetMessage("CT_BCSE_NOT_FOUND");?>
<?endif;?>

<?
$GLOBALS['COMPONENT_AJAX_ID'] = $arParams['AJAX_ID'];
?>

<?
$strBrandSection = $_REQUEST['sfilter'] ? addslashes(htmlspecialchars($_REQUEST['sfilter'])) : '';
$strBrandSection = (!$strBrandSection && $_REQUEST['bfilter']) ? addslashes(htmlspecialchars($_REQUEST['bfilter'])) : $strBrandSection;
?>
<br>
<h3 class="separator"><?= ($strBrandSection && $arResult['AR_SECTION_BRANDS'][$strBrandSection])
    ? $arResult['AR_SECTION_BRANDS'][$strBrandSection]
    : 'Все товары бренда' ?></h3>

<div class="catalog__list">

<section class="block_bereta_items block_bereta_items3 container mb-5">
	<div class="row" style="justify-content: center;">						
		<? 			//\Kolchuga\Settings::xmp($arResult["ITEMS"],11460, __FILE__.": ".__LINE__);				
		foreach($arResult["ITEMS"] as $key => $arItem){
			if($arItem['DETAIL_PICTURE']['ID'] > 0){
				if (empty($arItem['PREVIEW_PICTURE']) || !is_array($arItem['PREVIEW_PICTURE'])){
					$arItem['PREVIEW_PICTURE'] = $arItem['DETAIL_PICTURE'];
				}
				$arItem['PREVIEW_PICTURE']['SRC'] = \CFile::ResizeImageGet($arItem['DETAIL_PICTURE']["ID"], array('width' => 300, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL)['src'];
			}
			//\Kolchuga\Settings::xmp($arItem["PREVIEW_PICTURE"],11460, __FILE__.": ".__LINE__);
			$oldprice_init=0;
			$arItem['OLD_PRICE']=str_replace(',','.',$arItem['OLD_PRICE']);
			if(intval($arItem['OLD_PRICE'])>0){$oldprice_init=round(preg_replace("/[^0-9.]/", '', $arItem['OLD_PRICE']));}
		?>			
					
			<div class="col-6 col-sm-4 pl-1 pr-1 pt-3 pb-4" >
				<div class="card h-100 pb-2">
					<div class="card-body pt-1 pl-0 pr-0 "><a class="mb-5 aspect-ratio-box" href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" style="max-width:100%"></a>
						<div class="row mt-2 pl-2 pr-2 text-center">
							<div class="col">
							<h4  class='grey'><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></h4>
							<small><??></small></div>
						</div>
					</div>
					<div class="card-footer p-0" style="background:none;border-top:0">
						<div class="row pl-2 pr-2">
							<div class="col text-center">
								<? /* if($arItem['MIN_PRICE']['VALUE'] > 0){?>
									<div class="catalog__item-price">
										<?if (isset($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"])){?>
											<span class="old-price"><?=$arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"];?></span>
										<?}elseif($arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']){?>
											<span class="old-price"><?=$arItem['MIN_PRICE']['PRINT_VALUE'];?></span>
										<?}?>
										<span class="price"><?= $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></span>
									</div>
								<? }elseif($arItem['ITEM_PRICES'][0]['PRICE'] > 0){ ?>
									<div class="catalog__item-price">   
										<?if (isset($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"])){?>
											<span class="old-price"><?=$arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"];?></span>
										<?}elseif($arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']){?>
											<span class="old-price"><?=$arItem['MIN_PRICE']['PRINT_VALUE'];?></span>
										<?}?>					
										<span class="price"><?= $arItem['ITEM_PRICES'][0]['PRINT_PRICE'] ?></span>
									</div>
								<?} */?>
								
								 <? if($arItem['MIN_PRICE']['VALUE'] > 0){?>
									<div class="catalog__item-price">
										<span class="price line_price"><?= $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></span>
										
										<?if($arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']){?>
											<span class="old-price line_old_price"><?=$arItem['MIN_PRICE']['PRINT_VALUE']?></span>
											<span class="line_diff_price">(-<?=$arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>%)</span>
										<?}elseif($oldprice_init>0 && $oldprice_init>$arItem['MIN_PRICE']['DISCOUNT_VALUE']){?>
											<span class="old-price line_old_price"><?=$arItem['OLD_PRICE']?></span>
										<?}?>

									</div>
								 <? }elseif($arItem['ITEM_PRICES'][0]['PRICE'] > 0){ ?>
									<div class="catalog__item-price">   
										<span class="price"><?= $arItem['ITEM_PRICES'][0]['PRINT_PRICE'] ?></span>
										<?if ($oldprice_init > 0 && $arItem['ITEM_PRICES'][0]['PRICE'] < $oldprice_init){?>
											<span class="old-price line_old_price"><?=$arItem['OLD_PRICE']?></span>
											<span class="line_diff_price">(-<?=$arItem['ITEM_PRICES'][0]['PERCENT']?>%)</span>
										<?}?>					
									</div>
								<?} ?>
								<?/*<script data-skip-moving="true">console.log(<?echo \CUtil::PHPToJSObject($arItem['ITEM_PRICES'][0])?>);</script>*/?>
								
								<?if(!empty($arResult['SKU2'][$arItem["PROPERTIES"]['IDGLAVNOGO']['VALUE']])){
									$mmm=[];
									foreach( $arResult['SKU2'][$arItem["PROPERTIES"]['IDGLAVNOGO']['VALUE']] as $el){
										if(!empty($el['RAZMER'])){
											$mmm[]=$el['RAZMER'];
										}					
									}
									if(!empty($mmm)){
										?><div class="block_razmer" >Размеры: <?=implode(' | ',$mmm)?></div><?
									}
								}?>
							</div>
						</div>
					</div>
					<div class="row pl-2 pr-2 mt-3">
						<div class="col main__btn2"><a class=" btn-block  rounded-0 " href="<?=$arItem['DETAIL_PAGE_URL']?>" data-id="<?=$arItem['ID']?>">Подробнее</a></div>
					</div>
				</div>
			</div>													
		<?}?>		
	</div>
</section>

</div>
<? if($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <?= $arResult["NAV_STRING"] ?><br/>
<? endif; ?>