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
use Bitrix\Sale\DiscountCouponsManager;
$curPage = $APPLICATION->GetCurPage() . '?' . $arParams["ACTION_VARIABLE"] . '=';
$arUrls = array(
    "delete" => $curPage . "delete&id=#ID#",
    "delay" => $curPage . "delay&id=#ID#",
    "add" => $curPage . "add&id=#ID#",
);
unset($curPage);


if (!$arResult['ITEMS']['AnDelCanBuy']): ?>
    <div class="alert alert-danger1"><?=GetMessage('SALE_NO_ITEMS')?></div>
<? return false;
endif ?>
<? 
$obuv=false;
foreach ($arResult['ITEMS']['AnDelCanBuy'] as $key => $arItem){ 
	if(!empty($arItem['SECT'][18115]) || !empty($arItem['SECT'][18108]) || !empty($arItem['SECT'][18132]) || !empty($arItem['SECT'][18147])  ){$obuv=true;}
}

if($obuv){
	/*?><p>
 <span style="color: #ff0000;"></span><span style="color: #ff0000;">Обращаем ваше внимание, что при заказе обуви через интернет-магазин «Кольчуга» оплата возможна только онлайн при оформлении заказа. Это временно, мы уже работаем над исправлением этой проблемы.</span>
</p><?*/
}
?>
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
            <th class="td__discount"><?=GetMessage('SALE_DISCOUNT_TABLE')?></th>
            <th class="td__price-discount"><?=GetMessage('SALE_W_DISCOUNT')?></th>
            <th class="td__number"><?=GetMessage('SALE_QUANTITY')?></th>
            <th class="td__sum"><?=GetMessage('SALE_SUM')?></th>
            <th class="td__sum">Online оплата</th>
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
                <em><?=GetMessage('SALE_DISCOUNT_TABLE')?></em>
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
            <td class="td__sum">
                <em>Online оплата</em>
                <div class="td__inner"><?=$arItem['PROPERTY_DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY_VALUE'] == 'Да' ?
                        '<div class="text-success">Да</div>' :
                        '<div class="text-warning">Нет</div>'?></div>
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

    <div class="text-left flw75 warningBlock" <?=(!empty($arResult["KOMPLEKT"]))?"style='display:block'":""?>>
        <p class="warning">
            Чтобы продолжить оформление заказа, необходимо доукомплектовать товары в корзине. Нужно докупить следующие товары:
        </p>
        <?foreach($arResult["KOMPLEKT"] as $arProdukt):?>

                <div class="catalog__item" id="" style="text-align: center; width:24%">

                    <div class="catalog__item-img">
                        <a href="<?=$arProdukt["KOMPLEKT"]["DETAIL_PAGE_URL"]?>">
                            <img src="<?echo CFile::ResizeImageGet($arProdukt["KOMPLEKT"]['DETAIL_PICTURE'], array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL)['src']?>" alt="<?=$arProdukt["KOMPLEKT"]["NAME"]?>" title="<?=$arProdukt["KOMPLEKT"]["NAME"]?>">
                        </a>
                    </div>
                    <div class="catalog__item-info">
                        <div class="catalog__item-title"><a href="<?=$arProdukt["KOMPLEKT"]["DETAIL_PAGE_URL"]?>"><?=$arProdukt["KOMPLEKT"]["NAME"]?></a></div>
                        <a class="btn btn-primary" href="<?=$arProdukt["KOMPLEKT"]["DETAIL_PAGE_URL"]?>" style="margin-top: 15px;">Выбрать</a>
                    </div>
                </div>

        <?endforeach;?>
    </div>
    <? /* ?><div class="text-right frw25"><? */ ?>
	
	
	<div class="bx_ordercart_order_pay_left" id="coupons_block">
		<?
		if ($arParams["HIDE_COUPON"] != "Y")
		{
		?>
			<div class="bx_ordercart_coupon">
				<span><?=GetMessage("STB_COUPON_PROMT")?></span><input type="text" id="coupon" name="COUPON" value="" onchange="enterCoupon();" class="js-basket-coupon">&nbsp;<a class="bx_bt_button bx_big" href="javascript:void(0)" onclick="enterCoupon();" title="<?=GetMessage('SALE_COUPON_APPLY_TITLE'); ?>"><?=GetMessage('SALE_COUPON_APPLY'); ?></a>
			</div><?
				if (!empty($arResult['COUPON_LIST']))
				{
					foreach ($arResult['COUPON_LIST'] as $oneCoupon)
					{
						$couponClass = 'disabled';
						switch ($oneCoupon['STATUS'])
						{
							case DiscountCouponsManager::STATUS_NOT_FOUND:
							case DiscountCouponsManager::STATUS_FREEZE:
								$couponClass = 'bad';
								break;
							case DiscountCouponsManager::STATUS_APPLYED:
								$couponClass = 'good';
								break;
						}
						?><div class="bx_ordercart_coupon"><input disabled readonly type="text" name="OLD_COUPON[]" value="<?=htmlspecialcharsbx($oneCoupon['COUPON']);?>" class="<? echo $couponClass; ?>"><span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span><div class="bx_ordercart_coupon_notes"><?
						if (isset($oneCoupon['CHECK_CODE_TEXT']))
						{
							echo (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
						}
						?>
						<a href="javascript:void(0)" data-coupon='<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>'  class="btn-blue js-coupon-del">Удалить купон</a>
						</div></div><?
					}
					unset($couponClass, $oneCoupon);
				}
		}
		else
		{
			?>&nbsp;<?
		}
?>
		</div>
	
	
	
	
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
        <div class="order__btn" <?=(!empty($arResult["KOMPLEKT"]))?"style='display:none'":""?>>
		<?if(1==2){
			?><noindex><strong>Временно оформление заказа в интернет-магазине недоступно.</strong></noindex><?			
		}else{?>
		<?if($arResult['allSum']>1000){?>
            <a href="/personal/order/make/" class="btn btn-primary">Оформить заказ</a>
		<?}else{?>
		<strong>Мы принимаем заказы от 1 000 р., дополните корзину</strong><br><br>
		<a href="/internet_shop/" class="btn btn-primary">Продолжить покупки</a>
		<?}?>
				<?}?>
        </div>
    </div>

</form><!-- @end .basket-order -->