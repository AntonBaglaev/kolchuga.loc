<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="flexslider flexslider--theme-2 slider__salon js_salon_slider">
	<ul class="slides"><?

		foreach($arResult["ROWS"] as $arItems)
		{
			foreach($arItems as $arItem)
			{
				if(is_array($arItem))
				{
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BPS_ELEMENT_DELETE_CONFIRM')));

					if ($arItem["DISPLAY_PROPERTIES"]["REAL_PICTURE"]["FILE_VALUE"]["SRC"])
					{
						?><li id="<?=$this->GetEditAreaId($arItem['ID']);?>"><img src="<?=$arItem["DISPLAY_PROPERTIES"]["REAL_PICTURE"]["FILE_VALUE"]["SRC"]?>" class="bdr" alt="<?=$arItem["NAME"]?>" /></li><?
					}
					else
					{
						if(is_array($arItem["PICTURE"]))
						{
							?><li id="<?=$this->GetEditAreaId($arItem['ID']);?>"><img src="<?=$arItem["PICTURE"]["SRC"]?>" class="bdr" alt="<?=$arItem["NAME"]?>" /></li><?
						}
					}

				}
			}
		}

	?></ul>
</div>
<script>
	$(document).ready(function(){
		$('.js_salon_slider').flexslider({
			animation: "fade",
			slideshow: true,
			slideshowSpeed: 5000,
			animationSpeed: 700,
			prevText: "",
			nextText: "",
		});
	});
</script>
