<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?if(empty($arResult["ITEMS"])):?>
	<?//echo GetMessage("CT_BCSE_NOT_FOUND");?>
<?endif;?>

<?//echo "<pre style='text-align:left;'>";print_r($arResult["ITEMS"][0]['DISPLAY_PROPERTIES']['TOVAR']);echo "</pre>"; ?>

<section class="block_bereta_header container mb-5 pt-5 pb-5">
	<div class="row">
		<div class="col-12 text-center">
			<h2 class='grey'><?=$arResult['NAME']?></h2>
		</div>			
	</div>
</section>

<section class="block_bereta_items block_bereta_items2 container mb-5 ">
	<div class="row">
		<? foreach($arResult["ITEMS"] as $key => $arItem){
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
			$itemOpis=$arItem['DISPLAY_PROPERTIES']['TOVAR']['LINK_ELEMENT_VALUE'][$arItem['DISPLAY_PROPERTIES']['TOVAR']['VALUE']];
			/*<!--pre>cens <?print_r($itemOpis['CENS']);?></pre-->*/
			?>
			<div class="col-sm-6 pb-5" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
			  <div class="card h-100 pb-2">
				<div class="card-body pt-0 pl-0 pr-0">
					<?
						$galerea=[];
						$galereaId=[];
						$contslid=0;
						if(!empty($arItem['PREVIEW_PICTURE']['SRC'])){
							$galerea[]=$arItem['PREVIEW_PICTURE']['SRC']; 
							$galereaId[]=$arItem['PREVIEW_PICTURE']['ID']; 
							$contslid++;
						}
						if(!empty($itemOpis['CENS']['DETAIL_PICTURE'])){
							$galerea[]=\CFile::GetPath($itemOpis['CENS']['DETAIL_PICTURE']); 
							$galereaId[]=$itemOpis['CENS']['DETAIL_PICTURE']; 
							$contslid++;
						}
						if(!empty($itemOpis['CENS']['PROP_FOTO']['MORE_PHOTO']['VALUE'])){
							$contslid += count($itemOpis['CENS']['PROP_FOTO']['MORE_PHOTO']['VALUE']);
							foreach($itemOpis['CENS']['PROP_FOTO']['MORE_PHOTO']['VALUE'] as $kl=>$fto){
								$galerea[]=\CFile::GetPath($fto);
								$galereaId[]=$fto;
							}		
						}						
					?>
					<?
					if($contslid>1 /*&& $USER->GetID()=="11460"*/){?>					
						<div class="flexslider flexslider--theme-2 js_fx_slider"><ul class="slides aspect-ratio-box1">
							
							
							<?foreach($galerea as $kl=>$fto){?>
								<li class="slide-container aspect-ratio-box">
									<img src="<?=$fto?>" style="max-width:100%" />									
								</li>
							<?}?>
							
							
							<?/*foreach($galerea as $kl=>$fto){?>
								<input type="radio" name="radio-btn-<?=$arItem['ID']?>" class="no_check" id="img-<?=$galereaId[$kl]?>" <?if($kl<1){?>checked<?}?> />
								<li class="slide-container">
									<div class="slide">
										<a rel='fancibox'><img src="<?=$fto?>" style="max-width:100%" /></a>
									</div>
									<div class="nav">
										<label for="img-<?=(!empty($galereaId[$kl-1]) ? $galereaId[$kl-1] : $galereaId[$contslid-1])?>" class="prev">&#x2039;</label>
										<label for="img-<?=(!empty($galereaId[$kl+1]) ? $galereaId[$kl+1] : $galereaId[0])?>" class="next">&#x203a;</label>
									</div>
								</li>
							<?}*/?>
							
							
							
							<?/*foreach($itemOpis['CENS']['PROP_FOTO']['FOTO_BERETTA']['VALUE'] as $kl=>$fto){?>
								<input type="radio" name="radio-btn-<?=$arItem['ID']?>" class="no_check" id="img-<?=$fto?>" <?if($kl<1){?>checked<?}?> />
								<li class="slide-container">
									<div class="slide">
										<a rel='fancibox'><img src="<?=\CFile::GetPath($fto)?>" style="max-width:100%" /></a>
									</div>
									<div class="nav">
										<label for="img-<?=(!empty($itemOpis['CENS']['PROP_FOTO']['FOTO_BERETTA']['VALUE'][$kl-1]) ? $itemOpis['CENS']['PROP_FOTO']['FOTO_BERETTA']['VALUE'][$kl-1] : $itemOpis['CENS']['PROP_FOTO']['FOTO_BERETTA']['VALUE'][$contslid-1])?>" class="prev">&#x2039;</label>
										<label for="img-<?=(!empty($itemOpis['CENS']['PROP_FOTO']['FOTO_BERETTA']['VALUE'][$kl+1]) ? $itemOpis['CENS']['PROP_FOTO']['FOTO_BERETTA']['VALUE'][$kl+1] : $itemOpis['CENS']['PROP_FOTO']['FOTO_BERETTA']['VALUE'][0])?>" class="next">&#x203a;</label>
									</div>
								</li>
							<?}*/?>
						</ul></div>		
												
					<?}else{?>
						<a href="<?=$itemOpis['DETAIL_PAGE_URL']?>"  class="aspect-ratio-box">
							<img src="<?=(!empty($itemOpis['CENS']['PROPERTY_FOTO_BERETTA_VALUE']) ? \CFile::GetPath($itemOpis['CENS']['PROPERTY_FOTO_BERETTA_VALUE']) : $arItem['PREVIEW_PICTURE']['SRC'] )?>" style="max-width:100%">
						</a>
					<?}?>
					<div class="row mt-2 pl-2 pr-2 text-center">
						<div class="col">
							<h4 class='grey js-page-title-<?=$itemOpis['ID']?>'><a href="<?=$itemOpis['DETAIL_PAGE_URL']?>"><?=$itemOpis['NAME']?></a></h4>
							<small><?=(!empty($itemOpis['CENS']['PROPERTY_TEXT_BERETTA_VALUE']['TEXT']) ? $itemOpis['CENS']['PROPERTY_TEXT_BERETTA_VALUE']['TEXT'] : $arItem['PREVIEW_TEXT'])?></small>
						</div>
					</div>
				</div>
				<div class="card-footer p-0" style="background:none;border-top:0">
				  <div class="row pl-2 pr-2">
					<div class="col text-center">
					   <h5 class='grey'><b class="js-price-<?=$itemOpis['ID']?>"><?=$itemOpis['CENS']['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></b></h5>
					</div>
				  </div>
				  <div class="row pl-2 pr-2 mt-3">
					<div class="col pr-1"><a class="btn btn-block podrobnee-<?=$itemOpis['ID']?> rounded-0 " href="<?=$itemOpis['DETAIL_PAGE_URL']?>" data-id="<?=$arItem['ID']?>">Подробнее</a></div>
					<?/*if ($USER->GetID()!="11460"){?>
						<div class="col pl-1"><a href="<?=$itemOpis['DETAIL_PAGE_URL']?>" class="btn btn-block rounded-0 " data-code="<?=$arItem['ID']?>">Зарезервировать</a></div>
					<?}else{*/?>
						<?/* <div class="col pl-1"><a href="#modal-buyoneclick-list" rel="nofollow" rel_mc="rezerv" class="btn btn-block rounded-0 popup-modal js-popup-modal-store" data-code="<?=$itemOpis['ID']?>">Зарезервировать</a></div> */?>
					<?//}?>
				  </div>
				</div>
			  </div>
			</div>
			
		
		
		<?}?>		
	</div>
</section>

