<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(empty($arResult['ITEMS'])) return false;?>
<? if (!empty($arParams["NO_TITLE"])): ?>
	<div class="section_title" style="line-height:28px;">
		<? if (!empty($arParams["LINK_TITLE"])){ ?><a href="<?=$arParams["LINK_TITLE"]?>" class="<?=$arParams["LINK_CLASS"]?>"><?}?>
		<span><?=$arParams["NO_TITLE"]?></span>
		<? if (!empty($arParams["LINK_TITLE"])){ ?></a><?}?>
	</div>
<? endif; ?>

<div class="recommend__wrapper">
    <div class="recommend owl-carousel owl-theme js_recommend">
        <?foreach($arResult['ITEMS'] as $arItem):?>
            <div class="recommend__item">
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
	<!--<a href="/internet_shop/oruzhie/" class="allbrand poptovar">Все товары</a>-->
	<div class="main__btn d-block d-lg-none"><a href="/internet_shop/sale/">Все товары со скидкой</a></div>
</div>