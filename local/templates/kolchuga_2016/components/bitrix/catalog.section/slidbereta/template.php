<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?if(empty($arResult["ITEMS"])):?>
	<?echo GetMessage("CT_BCSE_NOT_FOUND");?>
<?endif;?>

<?//echo "<pre style='text-align:left;'>";print_r($arResult["ITEMS"][0]['DISPLAY_PROPERTIES']['TOVAR']);echo "</pre>"; ?>




<section class="block_bereta_slider container mb-5">
	<div class="row">
		<div class="col-12  ">	
		
			<div class="recommend owl-carousel owl-theme js_recommend">
				<?foreach($arResult["ITEMS"] as $arItem){?>
					<?
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
					?>
					<div class="recommend__item" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">            
						<div class="recommend__img">
							<a data-gallery="gallery-1" class="fancybox" data-fancybox-group="gallery-1>" href="<?=$arItem['PREVIEW_PICTURE']['SRC']?>">
								<img src="<?=\CFile::ResizeImageGet(   $arItem['PREVIEW_PICTURE']['ID'],   ['width' => 280, 'height' => 158],BX_RESIZE_IMAGE_EXACT)['src']?>" >
							</a>
						</div>                
					</div>
				<?}?>
				<?
				if(count($arResult["ITEMS"])<5){
				foreach($arResult["ITEMS"] as $arItem){?>			
					
					<div class="recommend__item" >            
						<div class="recommend__img">
							<a data-gallery="gallery-1" class="fancybox" data-fancybox-group="gallery-1>" href="<?=$arItem['PREVIEW_PICTURE']['SRC']?>">
								<img src="<?=\CFile::ResizeImageGet(   $arItem['PREVIEW_PICTURE']['ID'],   ['width' => 280, 'height' => 158],BX_RESIZE_IMAGE_EXACT)['src']?>" >
							</a>
						</div>                
					</div>
				<?}
				}?>
			</div>			 
		</div>			
	</div>
</section>


