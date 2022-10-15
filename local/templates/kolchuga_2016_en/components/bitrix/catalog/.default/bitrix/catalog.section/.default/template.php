<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="catalog__list">
    <? foreach($arResult["ITEMS"] as $key => $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));

        if($arItem['DETAIL_PICTURE']['ID'] > 0){
            $arItem['PREVIEW_PICTURE']['SRC'] =
                CFile::ResizeImageGet($arItem['DETAIL_PICTURE'], array('width' => 150, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL)['src'];
            //var_dump($arItem['PREVIEW_PICTURE']['SRC']);
        }

        ?>
        <div class="catalog__item" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
            <div class="catalog__item-img">
                <? if($arItem["DISPLAY_PROPERTIES"]['NOVINKA']){
                    ?>
                    <div class="novinka"></div>
                <? }
                if($arItem["DISPLAY_PROPERTIES"]['SALE']){ ?>
                    <div class="sale"></div>
                <?
                }
                if($arItem["DISPLAY_PROPERTIES"]['BESTPRICE']){
                    ?>
                    <div class="bestprice"></div>
                <? } ?>
                <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                    <? if($arItem['PREVIEW_PICTURE']['SRC']):?>
                        <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>">
                        <? else: ?>
                        <div class="no-photo"></div>
                    <? endif ?>
                </a>
            </div>
            <div class="catalog__item-info">
                <div class="catalog__item-title"><a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><?= $arItem['NAME'] ?></a>
                </div>
                <? if($arItem['MIN_PRICE']['VALUE'] > 0):?>
                    <div class="catalog__item-price">
                        <? if($arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']):?>
                            <span class="old-price"><?= $arItem['MIN_PRICE']['PRINT_VALUE'] ?></span>
                        <? endif ?>
                        <span class="price"><?= $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></span>
                    </div>
                <? endif ?>
            </div>
        </div>
    <? endforeach; ?>
</div>
<? if($arParams["DISPLAY_TOP_PAGER"]): ?>
    <?= $arResult["NAV_STRING"] ?><br/>
<? endif; ?>