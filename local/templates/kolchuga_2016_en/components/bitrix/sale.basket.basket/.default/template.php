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


if (!$arResult['ITEMS']['AnDelCanBuy']): ?>
    <div class="alert alert-danger"><?=GetMessage('SALE_NO_ITEMS')?></div>
<? return false;
endif ?>
<form class="basket-order js-basket-table" name="basket_form" method="post">
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
    <table class="table table__goods table__basket js-basket-table">
        <thead>
        <tr>
            <th class="td__name"><?=GetMessage('SALE_NAME')?></th>
            <th class="td__price"><?=GetMessage('SALE_PRICE')?></th>
            <th class="td__discount"><?=GetMessage('SALE_DISCOUNT')?></th>
            <th class="td__price-discount"><?=GetMessage('SALE_W_DISCOUNT')?></th>
            <th class="td__number"><?=GetMessage('SALE_QUANTITY')?></th>
            <th class="td__sum"><?=GetMessage('SALE_SUM')?></th>
            <th class="td__doing"><?=GetMessage('SALE_ACTIONS')?></th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($arResult['ITEMS']['AnDelCanBuy'] as $key => $arItem): ?>
        <tr class="js-row" data-id="<?=$arItem['ID']?>">
            <td class="td__name">
                <em><?=GetMessage('SALE_NAME')?></em>
                <div class="td__inner">
                    <div class="td__name--inner">
                        <div class="td__name--img">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                <?if($arItem['PREVIEW_PICTURE_SRC']):?>
                                <img src="<?=$arItem['PREVIEW_PICTURE_SRC']?>" alt="<?=$arItem['NAME']?>">
                                <?else:?>
                                    <div class="no-photo"></div>
                                <?endif;?>
                            </a>
                        </div>
                        <div class="td__name--title">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
                        </div>
                    </div>
                </div>
            </td>

            <td class="td__price">
                <em><?=GetMessage('SALE_PRICE')?></em>
                <div class="td__inner">
                    <div class="price__block">
                        <span class="price">
                            <?=number_format($arItem['FULL_PRICE'], 1, '.', ' ')?> руб.
                        </span>
                    </div>
                </div>
            </td>
            <td class="td__discount">
                <em><?=GetMessage('SALE_DISCOUNT')?></em>
                <div class="td__inner">
                    <div class="price__block">
                        <?if($arItem['DISCOUNT_PRICE_PERCENT_FORMATED']):?>
                            <span class="discount"><?=$arItem['DISCOUNT_PRICE_PERCENT_FORMATED']?></span>
                        <?endif?>
                    </div>
                </div>
            </td>
            <td class="td__price-discount">
                <em><?=GetMessage('SALE_W_DISCOUNT')?></em>
                <div class="td__inner">
                    <div class="price__block">
                        <span class="price"><?=$arItem['PRICE_FORMATED']?></span>
                    </div>
                </div>
            </td>
            <td class="td__number">
                <em><?=GetMessage('SALE_QUANTITY')?></em>
                <div class="td__inner js-q-item">
                    <input
                        type="text"
                        class="js-q-in"
                        value="<?= $arItem['QUANTITY'] ?>"
                        name="QUANTITY_<?=$arItem['ID']?>"
                        id=""
                        data-max="100"
                        size="3">
                </div>
            </td>
            <td class="td__sum">
                <em><?=GetMessage('SALE_SUM')?></em>
                <div class="td__inner">
                    <span class="price-total js-row-sum"><?=$arItem['SUM']?></span>
                </div>
            </td>
            <td class="td__doing">
                <em><?=GetMessage('SALE_ACTIONS')?></em>
                <div class="td__inner">
                    <a class="td__doing--favourite" href="?<?=$arParams["ACTION_VARIABLE"]?>=delay&id=<?=$arItem['ID']?>" title="<?=GetMessage('SALE_DELAY')?>">
                        <span class="icon-heart-o"></span>
                        <i><?=GetMessage('SALE_DELAY')?></i>
                    </a>
                    <a class="delete td__doing--delete" href="?<?=$arParams["ACTION_VARIABLE"]?>=delete&id=<?=$arItem['ID']?>" title="<?=GetMessage('SALE_DELETE')?>">
                        <span class="icon-close"></span>
                        <i><?=GetMessage('SALE_DELETE')?></i>
                    </a>
                </div>
            </td>
        </tr>
        <?endforeach?>
        </tbody>
    </table>
    <?foreach($arResult['ITEMS']['DelDelCanBuy'] as $arItem):?>
        <input type="hidden" name="DELAY_<?=$arItem['ID']?>" value="Y">
    <?endforeach?>
    <div class="text-right">
        <div class="table__total--wrap">
            <table class="table table__total">
                <tbody>
                <tr class="order__sum">
                    <td><?=GetMessage('SALE_NO_DISCOUNT')?></td>
                    <td class="js-result-price"><?=$arResult['PRICE_WITHOUT_DISCOUNT']?></td>
                </tr>
                <tr class="order__discount">
                    <td><?=GetMessage('SALE_DISCOUNT')?></td>
                    <td class="js-result-eco"><?=$arResult['DISCOUNT_PRICE_ALL_FORMATED']?></td>
                </tr>
                <tr class="order__total">
                    <td><?=GetMessage('SALE_TOTAL')?></td>
                    <td class="js-result-discount"><?= $arResult['allSum_FORMATED'] ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="order__btn">
            <a href="/personal/order/make/" class="btn btn-primary">Оформить заказ</a>
        </div>
    </div>

</form><!-- @end .basket-order -->