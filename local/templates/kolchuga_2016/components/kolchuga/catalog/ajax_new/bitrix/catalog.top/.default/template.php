<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

$frame = $this->createFrame()->begin();
if(empty($arResult['ITEMS'])) {?><style>.description-block{display:none;}.item-description-block{display:block;}</style><?return false;}?>
<? if ($arParams["NO_SHOW_TITLE"] != "Y"): ?>
  <h2>Популярные товары</h2>
<? endif; ?>
<div class="recommend__wrapper">
    <div class="recommend owl-carousel owl-theme js_recommend3">
        <?foreach($arResult['ITEMS'] as $arItem):?>
            <div class="recommend__item">
  
            <? /*if($arItem['MIN_PRICE']['VALUE'] > $arItem['MIN_PRICE']['DISCOUNT_VALUE']):?>
                <span class="old_price"><?=$arItem['MIN_PRICE']['PRINT_VALUE']?></span>
            <? endif;*/ ?>
            <?/* if (isset($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]) &&
                   !empty($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"])): ?>
                <span class="old_price">
                  <?=$arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"];?>
                </span>
            <? endif; */?>
			<? if (isset($arItem['MIN_PRICE']["DISCOUNT_DIFF_PERCENT"]) && !empty($arItem['MIN_PRICE']["DISCOUNT_DIFF_PERCENT"])){ ?>
					<div class="procent_skidki_boll" style="z-index: 1;">-<?=$arItem['MIN_PRICE']["DISCOUNT_DIFF_PERCENT"]?>%</div>
				<?}elseif(!empty($arItem['PROPERTIES']['OLD_PRICE']['VALUE'])){?>
					<div class='procent_skidki_boll' style="z-index: 1;">-<?=(round(100-(intval($arItem['MIN_PRICE']['DISCOUNT_VALUE'])*100/round(preg_replace("/[^0-9.]/", '', $arItem['PROPERTIES']['OLD_PRICE']['VALUE'])))))?>%</div>
				<?}?>
                <div class="recommend__img">
                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">


                                 <?if($arItem['DETAIL_PICTURE']):
                                    $arItem['DETAIL_PICTURE']['SRC'] =
                                        CFile::ResizeImageGet(
                                            $arItem['DETAIL_PICTURE'],
                                            array('width' => 210, 'height' => 158),
                                            BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 60
                                        )['src'];
                                    ?>
                                    <img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>">
                                <?else:?>
                                    <div class="no-photo"></div>
                                <?endif?>



                    </a>
                </div>
                <div class="recommend__title">
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
                </div>
                <div class="recommend__price">
                    
                        <span><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></span>
						<? if (isset($arItem['MIN_PRICE']["DISCOUNT_DIFF_PERCENT"]) && !empty($arItem['MIN_PRICE']["DISCOUNT_DIFF_PERCENT"])){ ?>
							<del><?=$arItem['MIN_PRICE']['PRINT_VALUE']?></del>
						<?}elseif(!empty($arItem['PROPERTIES']['OLD_PRICE']['VALUE'])){?>
							<del><?=$arItem['PROPERTIES']['OLD_PRICE']['VALUE']?></del>
						<?}?> 
                 
                </div>
            </div>
        <?endforeach;?>
    </div>
</div>
<script type="text/javascript">
if (window.frameCacheVars !== undefined) 
{
        BX.addCustomEvent("onFrameDataReceived" , function(json) {
            var owlbrand = $('.js_recommend3');  
		   if (owlbrand.length > 0)
		   {
				owlbrand.owlCarousel({
					loop:true,
					items:4,
					margin:10,
					dots:false,
					nav:true,
					navText:['<span class="icon-arrow-left3"></span>','<span class="icon-arrow-right3"></span>'],
					responsiveClass:true,
					responsive:{
						0:{
							items:1
						},
						500:{
							items:2
						},
						768:{
							items:3
						},
						1024:{
							items:4
						},
						1100:{
							items:4
						}
					}
				});
		   }
        });
} else {
        BX.ready(function() {
            var owlbrand = $('.js_recommend3');  
			if (owlbrand.length > 0)
			   {
					owlbrand.owlCarousel({
						loop:true,
						items:4,
						margin:10,
						dots:false,
						nav:true,
						navText:['<span class="icon-arrow-left3"></span>','<span class="icon-arrow-right3"></span>'],
						responsiveClass:true,
						responsive:{
							0:{
								items:1
							},
							500:{
								items:2
							},
							768:{
								items:3
							},
							1024:{
								items:4
							},
							1100:{
								items:4
							}
						}
					});
			   }
        });
}
</script>
<?$frame->beginStub();?>
<?$frame->end();