<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="section_title"><span>ОРУЖИЕ и СПОРТИВНОЕ СНАРЯЖЕНИЕ ЗАРУБЕЖНЫХ БРЕНДОВ</span></div>
<div class="brands-carousel-wrapper">
	<div class="brands-carousel owl-carousel owl-theme js-brands"><?
		foreach($arResult["ROWS"] as $arItems)
		{
			foreach($arItems as $arItem)
			{
				if(($arItem['ID']=='232')or($arItem['ID']=='239')or($arItem['ID']=='224'))   {
                    $noFollow = 'rel="nofollow"';
				}else{
                    $noFollow = '';
				}
				if(is_array($arItem))
				{
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BPS_ELEMENT_DELETE_CONFIRM')));

					if(is_array($arItem["PICTURE"]))
					{
						?><div class="brands-carousel-item"><?

							if($arItem["DISPLAY_PROPERTIES"]["email"]["VALUE"])
							{
								?><a <?=$noFollow?> href="<?=$arItem["DISPLAY_PROPERTIES"]["email"]["VALUE"]?>" target="_blank"><?
							}

								?><img src="<?=$arItem["PICTURE"]["SRC"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /><?

							if($arItem["DISPLAY_PROPERTIES"]["email"]["VALUE"])
							{
								?></a><?
							}

						?></div><?
					}
				}
			}
		}

	?></div>
</div>
<div class="main__btn"><a href="/brands/">Все бренды</a></div> 
<script>
	$(document).ready(function(){
		var owlbrand = $('.js-brands');
		owlbrand.owlCarousel({
			loop:true,
			items:7,
			margin:10,
			dots:false,
			nav:true,
			navText:['<span class="icon-arrow-left3"></span>','<span class="icon-arrow-right3"></span>'],
			responsiveClass:true,
			responsive:{
				0:{
					items:1
				},
				360:{
					items:2,
					slideBy: 2,
				},
				480:{
					items:3,
					slideBy: 3,
				},
				768:{
					items:5
				},
				1024:{
					items:6
				},
				1100:{
					items:7
				}
			}
		});
	});
</script>
