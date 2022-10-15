<script type="text/javascript">
	jQuery(function() {

		$.fn.startCarousel = function() {
			var bodywidth = $('.img_block_gallery#brands').width(),
				itemwidth = $('.menu_img li').outerWidth(true),		
				mycontwidth = bodywidth > itemwidth ? bodywidth - bodywidth%itemwidth : itemwidth,
				licount = $('.menu_img li').size(),
				jscroll = 1;
				
			if(licount > mycontwidth/itemwidth){
				jscroll =  mycontwidth/itemwidth;
			} else {
				jscroll = 0;
				mycontwidth = licount * itemwidth;
			}
			
			$('.block_gallery_content').width(mycontwidth);
				
			$('.menu_img').jcarousel({
				scroll:jscroll,
				wrap:'circular'
			});
		};
		
		$(this).startCarousel();
		
		$(window).resize(function(){
			$(this).startCarousel();
		}); 
	});
</script>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
	<div id="brands" class="img_block_gallery"> 
	<div class="block_gallery_content">
		<ul class="menu_img">
		<?foreach($arResult["ROWS"] as $arItems):?>
				<?foreach($arItems as $arItem):?>
					
						<!-- <?//print_r ($arItem);?> -->
						<?if(is_array($arItem)):?>
							<li>
							<?
							$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
							$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BPS_ELEMENT_DELETE_CONFIRM')));
							?>
							<?if(is_array($arItem["PICTURE"])):?>
								<?if($arItem["DISPLAY_PROPERTIES"]["email"]["VALUE"]):?>
									<a href="<?=$arItem["DISPLAY_PROPERTIES"]["email"]["VALUE"]?>" target="_blank">
								<?endif?>
									<img src="<?=$arItem["PICTURE"]["SRC"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" width="<?=$arItem["PICTURE"]["WIDTH"]?>" height="<?=$arItem["PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
								<?if($arItem["DISPLAY_PROPERTIES"]["email"]["VALUE"]):?>
									</a>
								<?endif?>
							<?endif?>
							</li>
						<?endif;?>
					
				<?endforeach?>
		<?endforeach?>
		</ul>
	</div>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>

