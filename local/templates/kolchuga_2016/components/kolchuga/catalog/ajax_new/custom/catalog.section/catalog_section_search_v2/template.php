<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->setFrameMode(true); ?>

<? if (count($arResult['ITEMS']) < 1): ?>

    <div style="color: green">Товаров не найдено.</div>

    <style>
        .exFilterList {
            display: none;
        }
    </style>

<? else: ?>

    <div class="catalog__list">
        <? foreach ($arResult["ITEMS"] as $key => $arItem):
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));

            if ($arItem['DETAIL_PICTURE']['ID'] > 0) {
                if (empty($arItem['PREVIEW_PICTURE']) ||
                    !is_array($arItem['PREVIEW_PICTURE'])) {
                    $arItem['PREVIEW_PICTURE'] = $arItem['DETAIL_PICTURE'];
                }

                $arItem['PREVIEW_PICTURE']['SRC'] =
                    CFile::ResizeImageGet($arItem['DETAIL_PICTURE']["ID"],
                        array('width' => 200, 'height' => 150),
                        BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70)['src'];
            }
            ?>
            <div class="catalog__item" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
                <div class="catalog__item-img">
                    <div class="stickers">
                        <? /*if($arItem["DISPLAY_PROPERTIES"]['NOVINKA']){?>
    					<div class="new">Новинка</div>
    				<?}?>
    				<?if($arItem["DISPLAY_PROPERTIES"]['SALE']){?>
    					<div class="sale">SALE</div>
    				<?}?>
    				<?if($arItem["DISPLAY_PROPERTIES"]['SPECIAL_PRICE']){?>
    					<div class="new">Специальная цена</div>
    				<?}?>
    				<?if($arItem["DISPLAY_PROPERTIES"]['BESTPRICE']){?>
    					<div class="new">Лучшая цена</div>
    				<?}*/
                        ?>
                        <? if ($arItem['CHECK_NOVINKA']) {
                            ?>
                            <div class="new">Новинка</div>
                        <? } ?>
                        <? /*if($arItem['CHECK_SALE']){?>
                      <div class="sale">SALE</div>
                    <?}*/
                        ?>
                        <? if ($arItem['CHECK_SPECIAL_PRICE']) {
                            ?>
                            <div class="new">Специальная цена</div>
                        <? } ?>
                        <? if ($arItem["DISPLAY_PROPERTIES"]['BESTPRICE']) {
                            ?>
                            <div class="new">Лучшая цена</div>
                        <? } ?>
                        <? if ($arItem["DISPLAY_PROPERTIES"]['SPECIAL_PRICE']) {
                            ?>
                            <div class="new">Специальная цена</div>
                        <? } ?>


                    </div>

                    <?
                    $oldprice_init = 0;
                    $arItem['OLD_PRICE'] = str_replace(',', '.', $arItem['OLD_PRICE']);
                    if (intval($arItem['OLD_PRICE']) > 0) {
                        $oldprice_init = round(preg_replace("/[^0-9.]/", '', $arItem['OLD_PRICE']));
                    }

                    /* ?><script data-skip-moving="true">console.log(<?echo \CUtil::PHPToJSObject($oldprice_init)?>);</script><?
                    ?><script data-skip-moving="true">console.log(<?echo \CUtil::PHPToJSObject($arItem['MIN_PRICE']['DISCOUNT_VALUE'])?>);</script><? */


                    if ($arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0) {
                        ?>
                        <div class='procent_skidki_boll'>-<?= $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ?>%</div>
                        <?
                        if ($arItem['CHECK_SALE']) {
                            /* ?><div class="procent_skidki_boll_bf_img"><img src="/images/icon_blacksale.png" width="100%" ></div><? */
                        }
                        ?>
                    <? } elseif ($oldprice_init > 0 && $oldprice_init > $arItem['MIN_PRICE']['DISCOUNT_VALUE']) {
                        ?>

                        <div class='procent_skidki_boll'>
                            -<?= (round(100 - (intval($arItem['MIN_PRICE']['DISCOUNT_VALUE']) * 100 / $oldprice_init))) ?>
                            %
                        </div>
                        <?
                        if ($arItem['CHECK_SALE']) {
                            /* ?><div class="procent_skidki_boll_bf_img"><img src="/images/icon_blacksale.png" width="100%" ></div><? */
                        }
                        ?>
                    <? } ?>

                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" onclick="return true;">
                        <? if ($arItem['PREVIEW_PICTURE']['SRC']): ?>
                            <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                 alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>"
                                 title="<?= $arItem['PREVIEW_PICTURE']['TITLE'] ?>">
                        <? else: ?>
                            <? /*<div class="no-photo"></div>*/ ?>
                            <img src="/images/no_photo_kolchuga.jpg">
                        <? endif ?>
                    </a>
                </div>
                <div class="catalog__item-info">
                    <div class="catalog__item-title"><a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                                        onclick="return true;"><?= $arItem['NAME'] ?></a>
                    </div>
                    <? if ($arItem['MIN_PRICE']['VALUE'] > 0): ?>
                        <div class="catalog__item-price">
                            <span class="price line_price"><?= $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></span>

                            <? if ($arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']) { ?>
                                <span class="line_old_price"><?= $arItem['MIN_PRICE']['PRINT_VALUE'] ?></span>
                                <span class="line_diff_price">(-<?= $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ?>%)</span>
                                <? //}elseif($arItem['OLD_PRICE']){?>
                            <? } elseif ($oldprice_init > 0 && $oldprice_init > $arItem['MIN_PRICE']['DISCOUNT_VALUE']) { ?>
                                <span class="line_old_price"><?= $arItem['OLD_PRICE'] ?></span>
                            <? } ?>

                        </div>
                    <? endif ?>

                    <? if (!empty($arResult['SKU2'][$arItem["PROPERTIES"]['IDGLAVNOGO']['VALUE']])) {
                        ?>
                        <?
                        $mmm = [];

                        foreach ($arResult['SKU2'][$arItem["PROPERTIES"]['IDGLAVNOGO']['VALUE']] as $el) {
                            if (!empty($el['RAZMER'])) {
                                $mmm[] = $el['RAZMER'];
                            }

                        }
                        if (!empty($mmm)) {
                            ?>
                            <div class="">Размеры: <?= implode(' | ', $mmm) ?></div>
                            <?
                        }
                    } ?>
                </div>

                <?/*<div class="block_price-buy">
                    <?
                    $APPLICATION->IncludeComponent(
                        'kolchuga:add2basket',
                        '',
                        array(
                            'PRODUCT_ID'     => $arItem['ID'],
                            'POPUP_REQUIRED' => 'N',
                            'CACHE_TYPE'     => 'A',
                            'CACHE_TIME'     => 3600,
                        ),
                        false,
                        array('HIDE_ICONS' => 'Y')
                    )
                    ?>
                </div>*/?>

            </div>
        <? endforeach; ?>
    </div>

    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>

        <?= $arResult["NAV_STRING"] ?>

    <? endif; ?>

<? endif; ?>
