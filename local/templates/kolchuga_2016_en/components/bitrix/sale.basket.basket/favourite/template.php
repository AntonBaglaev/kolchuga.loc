<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixBasketComponent $component */
$curPage = $APPLICATION->GetCurPage() . '?' . $arParams["ACTION_VARIABLE"] . '=';
$arUrls = array(
    "delete" => $curPage . "delete&id=#ID#",
    "delay" => $curPage . "delay&id=#ID#",
    "add" => $curPage . "add&id=#ID#",
);
unset($curPage);


if (!$arResult['ITEMS']['DelDelCanBuy']): ?>
    <div class="alert alert-danger">
        <p>Товары отсутствуют</p>
    </div>
<? return false;
endif ?>
<? //echo '<script>console.log(' . json_encode($arResult['ITEMS']) . ')</script>';?>
<form class="basket-order profile-favourite js-basket-table" name="basket_form" method="post">
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="site_id" value="<?=SITE_ID?>">
    <input type="hidden" name="select_props" value="NAME,DISCOUNT,PRICE,QUANTITY,SUM,PROPS,DELETE,DELAY">
    <input type="hidden" name="offers_props" value="">
    <input type="hidden" name="action_var" value="action">
    <input type="hidden" name="quantity_float" value="N">
    <input type="hidden" name="count_discount_4_all_quantity" value="N">
    <input type="hidden" name="price_vat_show_value" value="Y">
    <input type="hidden" name="hide_coupon" value="N">
    <input type="hidden" name="use_prepayment" value="N">
    <input type="hidden" name="action" value="recalculate">
    <table class="table js-basket-table">
        <thead>
        <tr>
            <th class="td-name-favourite">Наименование</th>
            <th class="td-price">Цена</th>
            <th class="td-doing">Действия</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($arResult['ITEMS']['DelDelCanBuy'] as $key => $arItem): ?>
        <tr class="js-row" data-id="<?=$arItem['ID']?>">
            <td class="td-name-favourite">
                <div class="basket-order-title-wrapper">
                    <div class="basket-order-img">
                        <?if($arItem['PREVIEW_PICTURE_SRC']):?>
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?= $arItem['PREVIEW_PICTURE_SRC'] ?>" alt="<?=$arItem['NAME']?>"></a>
                        <?else:?>
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><div class="no-photo"></div></a>
                        <?endif?>
                    </div>
                    <div class="basket-order-title">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
                    </div>
                </div>
            </td>
            <td class="td-price">
                <div class="price-block js-row-price">
                    <?if($arItem['DISCOUNT_PRICE'] > 0):?>
                    <span class="old-price">
                        <?=number_format($arItem['FULL_PRICE'], 1, '.', ' ')?>
                        <span class="rouble">a</span>
                    </span>
                    <?endif;
                    if($arItem['DISCOUNT_PRICE_PERCENT'] > 0):?>
                    <span class="discount"><?=$arItem['DISCOUNT_PRICE_PERCENT_FORMATED']?></span>
                    <?endif?>
                    <span class="price"><?=showPrice($arItem['PRICE_FORMATED'])?></span>
                </div>
            </td>
            <td class="td-doing">
                <div class="basket-order-manage">
                    <a class="basket" href="?action=add&id=<?=$arItem['ID']?>" title="В корзину">
                        <span class="icon-cart"></span>
                        <i>В корзину</i>
                    </a>
                    <a class="delete" href="?action=delete&id=<?=$arItem['ID']?>">
                        <span class="icon-delete"></span>
                        <i>Удалить</i>
                    </a>
                </div>
            </td>
        </tr>
        <?endforeach?>
        </tbody>
    </table>


</form><!-- @end .basket-order -->

</div>

<div class="clearfix"></div>