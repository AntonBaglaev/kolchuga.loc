<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?if(empty($arResult["ITEMS"])):?>
	<?//echo GetMessage("CT_BCSE_NOT_FOUND");?>
<?endif;?>

<?//echo "<pre style='text-align:left;'>";print_r($arResult["ITEMS"][0]['DISPLAY_PROPERTIES']['TOVAR']);echo "</pre>"; ?>

<section class="block_bereta_header container mb-5 ">
	<div class="row">
		<div class="col-12 text-center">
			<h2 class='grey'><?=$arResult['NAME']?></h2>
		</div>			
	</div>
</section>

<section class="block_bereta_items block_bereta_items3 container mb-5 ">
	<div class="row">
		<? foreach($arResult["ITEMS"] as $key => $arItem){
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
			
			$itemOpis=$arItem['DISPLAY_PROPERTIES']['TOVAR']['LINK_ELEMENT_VALUE'][$arItem['DISPLAY_PROPERTIES']['TOVAR']['VALUE']];
			?>
			
			
		<div class="col-sm-4 pt-3 pb-4" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
		  <div class="card h-100 pb-2">
			<div class="card-body pt-0 pl-0 pr-0 "><a class="aspect-ratio-box" href="<?=$arItem['DISPLAY_PROPERTIES']['TOVAR']['LINK_ELEMENT_VALUE'][$arItem['DISPLAY_PROPERTIES']['TOVAR']['VALUE']]['DETAIL_PAGE_URL']?>"><img src="<?=(!empty($itemOpis['CENS']['PROPERTY_FOTO_BERETTA_VALUE']) ? \CFile::GetPath($itemOpis['CENS']['PROPERTY_FOTO_BERETTA_VALUE']) : $arItem['PREVIEW_PICTURE']['SRC'] )?>" style="max-width:100%"></a>
			  <div class="row mt-2 pl-2 pr-2 text-center">
				<div class="col">
				  <h4  class='grey'><?=$itemOpis['NAME']?></h4>
				  <small><?=(!empty($itemOpis['CENS']['PROPERTY_TEXT_BERETTA_VALUE']['TEXT']) ? $itemOpis['CENS']['PROPERTY_TEXT_BERETTA_VALUE']['TEXT'] : $arItem['PREVIEW_TEXT'])?></small></div>
			  </div>
			</div>
			<div class="card-footer p-0" style="background:none;border-top:0">
			  <div class="row pl-2 pr-2">
				<div class="col text-center">
				  <h5  class='grey'><b><?=$itemOpis['CENS']['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></b></h5>
				</div>
			  </div>
			  <div class="row pl-2 pr-2 mt-3">
				<div class="col "><a class="btn btn-block  rounded-0 " href="<?=$itemOpis['DETAIL_PAGE_URL']?>" data-id="<?=$arItem['ID']?>">Подробнее</a></div>
				
			  </div>
			</div>
		  </div>
		</div>
		
		
		<?}?>		
	</div>
</section>

