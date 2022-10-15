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
    <div class="alert alert-danger"><?=GetMessage('SALE_NO_ITEMS')?></div>
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

	
	<div class="container-fluid">
		<? foreach ($arResult['ITEMS']['AnDelCanBuy'] as $key => $arItem){ ?>
			<div class="row block_item">
				<div class="col-lg-4 d-none d-lg-block">
					<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
						<?if($arItem['PREVIEW_PICTURE_SRC']):?>
						<img src="<?=$arItem['PREVIEW_PICTURE_SRC']?>" alt="<?=$arItem['NAME']?>">
						<?else:?>
							<!-- <div class="no-photo"></div> -->
							<img src="/images/no_photo_kolchuga.jpg">
						<?endif;?>
					</a>
				</div>
				<div class="col-12 col-lg-8 pr-lg-0 block_item--mob_item">
					<div class="container-fluid">
					<div class="row">
						<div class="col-8 col-lg-6 block_item--name">
							<div class="block_name"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
						</div>
						<div class="col-4 col-lg-6 pr-0 pl-0 block_item--doing">
							<div class="oboloch_doing">	
								<?/*<div class="opis_zg0 "><?=GetMessage('SALE_DELAY')?></div>
								<a class="block-doing--favourite" href="?<?=$arParams["ACTION_VARIABLE"]?>=delay&id=<?=$arItem['ID']?>" title="<?=GetMessage('SALE_DELAY')?>">
									<i class="fa fa-star-o" aria-hidden="true"></i>
								</a>*/?>
								<div class="opis_zg0 "><?=GetMessage('SALE_DELETE')?></div>
								<a class="block-doing--delete" href="?<?=$arParams["ACTION_VARIABLE"]?>=delete&id=<?=$arItem['ID']?>" title="<?=GetMessage('SALE_DELETE')?>">
									<span class="icon-close"></span>
								</a>
							</div>
							<?if($arItem['DISCOUNT_PRICE_PERCENT']>0){?>							
								<div class="blokdiskount">
									<div class="opis_zg">Скидка</div>
									<div class="soder_skidka"><?=str_replace('руб','р.',$arItem['DISCOUNT_PRICE_PERCENT_FORMATED'])?></div>
								</div>								
							<?}?>
						</div>						
					</div>
					<div class="row">
						
						<div class="col-4 d-none block_item--mob_photo">
							<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
								<?if($arItem['PREVIEW_PICTURE_SRC']):?>
									<img src="<?=$arItem['PREVIEW_PICTURE_SRC']?>" alt="<?=$arItem['NAME']?>">
								<?else:?>
									<div class="no-photo"></div>
								<?endif;?>
							</a>
						</div>
						
						<div class="col-8 col-md-12 block_item--mob_also"><div class="row">
						
							<div class="col-6 col-lg-2 block_item--mob_nal">
								<div class="opis_zg">Наличие</div>
								<div class="soder_sklad"><?=$arResult['KORZINA2'][$arItem['PRODUCT_ID']]?></div>
							</div>
							<div class="col-6 col-lg-4 block_item--mob_cena">
								<div class="otcentr"><div class="opis_zg">
									Цена 
									<?if($arItem['SUM_DISCOUNT_PRICE']>0){echo '<span class="oldprice">'. number_format($arItem['FULL_PRICE'], 0, '.', ' '); echo ' р.</span>';}?>
								</div>
								<div class="nowprice">
									<?=str_replace('руб','р.',$arItem['PRICE_FORMATED'])?>
								</div></div>
							</div>
							<div class="col-6 col-lg-2 block_item--mob_input">
							<div class="opis_zg">Заказано</div>
								<div class="js-q-item soder_input">							
								<input
									type="text"
									class="js-q-in"
									value="<?= $arItem['QUANTITY'] ?>"
									name="QUANTITY_<?=$arItem['ID']?>"								
									data-max="100"
									size="3">
									<div class="uvel">
										<span class="plus">+</span>
										<span class="minus">-</span>
									</div>
								</div>
							</div>
							<div class="col-6 col-lg-2 block_item--mob_amount">
								<div class="opis_zg">На сумму</div>
								<div class="soder_sum"><?=str_replace('руб','р.',$arItem['SUM'])?></div>							
							</div>
							<div class="col-lg-2 pr-lg-0">
								<?if($arItem['DISCOUNT_PRICE_PERCENT']>0){?>
									<div class="blokdiskount"><div class="opis_zg">Скидка</div>
									<div class="soder_skidka"><?=str_replace('руб','р.',$arItem['DISCOUNT_PRICE_PERCENT_FORMATED'])?></div></div>
								<?}?>
							</div>
						</div></div>
					</div>
					<?if($arItem['PROPERTY_DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY_VALUE'] != 'Да'){?>
					<div class="row">
						<div class="col-lg-12">
							<div class="opis_zg">Недоступно для оплаты онлайн</div>
						</div>												
					</div>
					<?}?>
					</div>
				</div>
				
			</div>
		<?}?>
		
		
		<div class="row block_item">
				<div class="col-8 col-lg-4 pl-0">
					<div class="opis_zg">Промо-код</div>
					<div class="bx_ordercart_order_pay_left" id="coupons_block">
						<?
						if ($arParams["HIDE_COUPON"] != "Y")
						{
						?>
							<div class="bx_ordercart_coupon">
								<input type="text" id="coupon" name="COUPON" value="" onchange="enterCoupon();" class="js-basket-coupon">&nbsp;<a class="bx_bt_button bx_big" href="javascript:void(0)" onclick="enterCoupon();" title="<?=GetMessage('SALE_COUPON_APPLY_TITLE'); ?>"><?=GetMessage('SALE_COUPON_APPLY'); ?></a>
							</div><?
								if (!empty($arResult['COUPON_LIST']))
								{ //\Kolchuga\Settings::xmp($arResult["COUPON_LIST"],11460, __FILE__.": ".__LINE__);
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
										<?if($couponClass == 'good' && $oneCoupon['DISCOUNT_ID']==69){
											$arGroupAvalaible = array(8,9,10); // массив групп, которые в которых нужно проверить доступность пользователя
											global $USER;
											$arGroups = $USER->GetUserGroupArray(); // массив групп, в которых состоит пользователь
											$result_intersect = array_intersect($arGroupAvalaible, $arGroups);// далее проверяем, если пользователь вошёл хотя бы в одну из групп, то 
											if(!empty($result_intersect)){
												?><br><br><span style="color:#ff0000;">Внимание!!! При использовании данного Промо-кода баллы по дисконтной карте за товары попавшие под скидку начисляться не будут.</span><br><br><?
											}
										}?>
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
				</div>
				<div class="col-4 col-lg-8 pr-0">
					<div class="container-fluid">
					<div class="row">
						
						<div class="col-lg-2 d-none d-lg-block">
							<?if($arResult['DISCOUNT_PRICE_ALL']>0){?>
							<div class="opis_zg">Экономия</div>
							<div class="soder_sklad"><?=str_replace('руб','р.',$arResult['DISCOUNT_PRICE_ALL_FORMATED'])?></div>
							<?}?>
						</div>
						<div class="col-12 col-lg-4 block_item--itogo">
							<div class="otcentr">
								<div class="opis_zg">Итого</div>
								<div class="nowprice">
									<?= str_replace('руб','р.',$arResult['allSum_FORMATED']) ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2">
						
						</div>
						<div class="col-lg-4 pr-lg-0 d-none d-lg-block">
							<div class="opis_zg">&nbsp;</div>
							<div class="order__btn" <?=(!empty($arResult["KOMPLEKT"]))?"style='display:none'":""?>>
							<?if(1==2){
								?><noindex><strong>Временно оформление заказа в интернет-магазине недоступно.</strong></noindex><?			
							}else{?>
							<?if($arResult['allSum']>1000){?>
								<a href="/personal/order/make/" class="btn btn-oforml">Оформить заказ</a>
							<?}else{?>
							<strong>Мы принимаем заказы от 1 000 р., дополните корзину</strong><br><br>
							<a href="/internet_shop/" class="btn btn-oforml">Продолжить покупки</a>
							<?}?>
									<?}?>
							</div>
						</div>
						
					</div>
					
					</div>
				</div>
				<div class="col-12 pr-0 pl-0 d-block d-lg-none">							
							<div class="order__btn" <?=(!empty($arResult["KOMPLEKT"]))?"style='display:none'":""?>>
							<?if(1==2){
								?><noindex><strong>Временно оформление заказа в интернет-магазине недоступно.</strong></noindex><?			
							}else{?>
							<?if($arResult['allSum']>1000){?>
								<a href="/personal/order/make/" class="btn btn-oforml">Оформить заказ</a>
							<?}else{?>
							<strong>Мы принимаем заказы от 1 000 р., дополните корзину</strong><br><br>
							<a href="/internet_shop/" class="btn btn-oforml">Продолжить покупки</a>
							<?}?>
									<?}?>
							</div>
						</div>
				
			</div>
			
			<?/* <div class="row block_item">
			<p style="color:#ff0000;font-size:110%">Салоны «Кольчуга» открыты <br>Интернет-магазин сегодня не работает</p>
			</div> */?>
	</div>


</form><!-- @end .basket-order -->

<?
if ($arParams['USE_GIFTS'] === 'Y' && $arParams['GIFTS_PLACE'] === 'BOTTOM') {
    ?>
    <div class="action_3pcs"><? $APPLICATION->IncludeComponent(
        "bitrix:sale.gift.basket",
        "action_3pcs",
        array(
            "SHOW_PRICE_COUNT"           => 1,
            "PRODUCT_SUBSCRIPTION"       => 'N',
            'PRODUCT_ID_VARIABLE'        => 'id',
            "PARTIAL_PRODUCT_PROPERTIES" => 'N',
            "USE_PRODUCT_QUANTITY"       => 'N',
            "ACTION_VARIABLE"            => "actionGift",
            "ADD_PROPERTIES_TO_BASKET"   => "Y",

            "BASKET_URL"            => $APPLICATION->GetCurPage(),
            "APPLIED_DISCOUNT_LIST" => $arResult["APPLIED_DISCOUNT_LIST"],
            "FULL_DISCOUNT_LIST"    => $arResult["FULL_DISCOUNT_LIST"],

            "TEMPLATE_THEME"    => $arParams["TEMPLATE_THEME"],
            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_SHOW_VALUE"],
            "CACHE_GROUPS"      => $arParams["CACHE_GROUPS"],

            'BLOCK_TITLE'               => 'Выберите подарок', //$arParams['GIFTS_BLOCK_TITLE'],
            'HIDE_BLOCK_TITLE'          => $arParams['GIFTS_HIDE_BLOCK_TITLE'],
            'TEXT_LABEL_GIFT'           => $arParams['GIFTS_TEXT_LABEL_GIFT'],
            'PRODUCT_QUANTITY_VARIABLE' => $arParams['GIFTS_PRODUCT_QUANTITY_VARIABLE'],
            'PRODUCT_PROPS_VARIABLE'    => $arParams['GIFTS_PRODUCT_PROPS_VARIABLE'],
            'SHOW_OLD_PRICE'            => $arParams['GIFTS_SHOW_OLD_PRICE'],
            'SHOW_DISCOUNT_PERCENT'     => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
            'SHOW_NAME'                 => $arParams['GIFTS_SHOW_NAME'],
            'SHOW_IMAGE'                => $arParams['GIFTS_SHOW_IMAGE'],
            'MESS_BTN_BUY'              => $arParams['GIFTS_MESS_BTN_BUY'],
            'MESS_BTN_DETAIL'           => $arParams['GIFTS_MESS_BTN_DETAIL'],
            'PAGE_ELEMENT_COUNT'        => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
            'CONVERT_CURRENCY'          => $arParams['GIFTS_CONVERT_CURRENCY'],
            'HIDE_NOT_AVAILABLE'        => $arParams['GIFTS_HIDE_NOT_AVAILABLE'],

            "LINE_ELEMENT_COUNT" => 3, //$arParams['GIFTS_PAGE_ELEMENT_COUNT'],
        ),
        false
    ); ?>
    </div><?
} ?>
