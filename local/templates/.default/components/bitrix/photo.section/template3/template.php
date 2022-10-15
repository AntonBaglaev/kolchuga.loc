<script type="text/javascript" src="/js/jquery.nivo.slider.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		 $('#slider_nivo').nivoSlider({
			effect: 'fade', // Specify sets like: 'fold,fade,sliceDown'
			slices: 15, // For slice animations
			boxCols: 8, // For box animations
			boxRows: 4, // For box animations
			animSpeed: 700, // Slide transition speed
			pauseTime: 5000, // How long each slide will show
			startSlide: 0, // Set starting Slide (0 index)
			directionNav: true, // Next & Prev navigation
			controlNav: false, // 1,2,3... navigation
			controlNavThumbs: false, // Use thumbnails for Control Nav
			pauseOnHover: true,
			prevText: ' ',
			nextText: ' '
		 
		 });
	});
</script>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="photo-section">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>

	<div id="slider_nivo">		
		<?foreach($arResult["ROWS"] as $arItems):?>
				<?foreach($arItems as $arItem):?>
					
					<?if(is_array($arItem)):?>
						<?
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BPS_ELEMENT_DELETE_CONFIRM')));
						?>

						<!-- <img src="<?=$arItem["DISPLAY_PROPERTIES"]["REAL_PICTURE"]["FILE_VALUE"]["SRC"]?>" alt="" /> -->
						
						
						<?if ($arItem["DISPLAY_PROPERTIES"]["REAL_PICTURE"]["FILE_VALUE"]["SRC"]):?>						
							<img src="<?=$arItem["DISPLAY_PROPERTIES"]["REAL_PICTURE"]["FILE_VALUE"]["SRC"]?>" class="bdr" id="<?=$this->GetEditAreaId($arItem['ID']);?>" width="<?=$arItem["DISPLAY_PROPERTIES"]["REAL_PICTURE"]["FILE_VALUE"]["WIDTH"]?>" height="<?=$arItem["DISPLAY_PROPERTIES"]["REAL_PICTURE"]["FILE_VALUE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
						<?else:?>	
							<?if(is_array($arItem["PICTURE"])):?>
								<img src="<?=$arItem["PICTURE"]["SRC"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="bdr" width="<?=$arItem["PICTURE"]["WIDTH"]?>" height="<?=$arItem["PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
							<?endif?>
						<?endif?>
						
						
						
					<?endif;?>
				<?endforeach?>
				<!-- <?foreach($arItems as $arItem):?>
					<?if(is_array($arItem)):?>						
							<?foreach($arParams["FIELD_CODE"] as $code):?>
								<small><?=GetMessage("IBLOCK_FIELD_".$code)?>&nbsp;:&nbsp;<?=$arItem[$code]?></small><br />
							<?endforeach?>
							<?foreach($arItem["DISPLAY_PROPERTIES"] as $arProperty):?>
								<small><?=$arProperty["NAME"]?>:&nbsp;<?
									if(is_array($arProperty["DISPLAY_VALUE"]))
										echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
									else
										echo $arProperty["DISPLAY_VALUE"];?></small><br />
							<?endforeach?>
					
					<?endif;?>
				<?endforeach?> -->
		<?endforeach?>
	</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
