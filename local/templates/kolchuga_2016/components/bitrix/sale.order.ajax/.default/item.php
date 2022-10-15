<?/*<script>console.log(<?echo json_encode($arResult)?>);</script>*/?>

<div class="container-fluid">
		<? foreach ($arResult['BASKET_ITEMS'] as $key => $arItem){ ?>
			<div class="row block_item">
				<div class="col-lg-4 d-none d-lg-block">
					<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
						<?if($arItem['DETAIL_PICTURE_SRC']):?>
						<img src="<?=CFile::ResizeImageGet(
                $arItem['DETAIL_PICTURE'],
                array('width' => 250, 'height' => 187),
                BX_RESIZE_IMAGE_PROPORTIONAL
            )['src']?>" alt="<?=$arItem['NAME']?>">
						<?else:?>
							<div class="no-photo"></div>
						<?endif;?>
					</a>
				</div>
				<div class="col-12 col-lg-8 pr-lg-0 block_item--mob_item">
					<div class="container-fluid">
					<div class="row">
						<div class="col-12 block_item--name">
							<div class="block_name"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
						</div>
						<?/* <div class="col-4 col-lg-6 pr-0 pl-0 block_item--doing">
							<div class="oboloch_doing">	
								<div class="opis_zg0 "><?=GetMessage('SALE_DELAY')?></div>
								<a class="block-doing--favourite" href="?<?=$arParams["ACTION_VARIABLE"]?>=delay&id=<?=$arItem['ID']?>" title="<?=GetMessage('SALE_DELAY')?>">
									<i class="fa fa-star-o" aria-hidden="true"></i>
								</a>
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
						</div> */	?>					
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
									<?if($arItem['BASE_PRICE']>$arItem['PRICE']){echo '<span class="oldprice">'. number_format($arItem['BASE_PRICE'], 0, '.', ' '); echo ' р.</span>';}?>
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
									size="3" disabled>
									
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
					<?if($arItem['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY'] !== 'true'){?>
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
					<?/*<div class="opis_zg">Промо-код</div>
					<div class="bx_ordercart_order_pay_left" id="coupons_block">
						<?
						if ($arParams["HIDE_COUPON"] != "Y")
						{
						?>
							<div class="bx_ordercart_coupon">
								<input type="text" id="coupon" name="COUPON" value="" onchange="enterCoupon();" class="js-basket-coupon">&nbsp;<a class="bx_bt_button bx_big" href="javascript:void(0)" onclick="enterCoupon();" title="<?=GetMessage('SALE_COUPON_APPLY_TITLE'); ?>"><?=GetMessage('SALE_COUPON_APPLY'); ?></a>
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
					</div>*/?>
				</div>
				<div class="col-4 col-lg-8 pr-0">
					<div class="container-fluid">
					<div class="row">
						
						<div class="col-lg-2 d-none d-lg-block">
							<?$skidka=$arResult['PRICE_WITHOUT_DISCOUNT_VALUE'] - $arResult['ORDER_PRICE'];
							if($skidka>0){?>
							<div class="opis_zg">Экономия</div>
							<div class="soder_sklad"><?= number_format($skidka, 2, '.', ' ') . ' р.' ?></div>
							<?}?>
						</div>
						<div class="col-12 col-lg-4 block_item--itogo">
							<div class="otcentr">
								<div class="opis_zg">Итого</div>
								<div class="nowprice">
									<?= $arResult['ORDER_TOTAL_PRICE_FORMATED'] ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2">
						
						</div>
						<div class="col-lg-4 pr-lg-0 d-none d-lg-block">
							<div class="opis_zg">&nbsp;</div>
							
							<div class="order__btn">
								<a href="#" class="btn btn-oforml js-btn-checkout">Оформить заказ</a>
							</div>
						</div>
						
					</div>
					
					</div>
				</div>
				<div class="col-12 pr-0 pl-0 d-block d-lg-none">							
							<div class="order__btn">
								<a href="#" class="btn btn-oforml js-btn-checkout">Оформить заказ</a>
							</div>
						</div>
				
			</div>
			
	</div>
	<style>
	.block_item{border-top:1px solid #c4c4c4; padding-top: 20px; padding-bottom: 20px;	}
.block_item .soder_input input{border-width:1px;}
	.block_item .block_name{font-family: PT Sans; font-size: 16px; line-height: 45px;}
	.block_item .opis_zg{font-family: PT Sans; font-size: 12px;color: #5C5C5C;white-space: nowrap;line-height: 50px;}
	.block_item .opis_zg0{font-family: PT Sans; font-size: 12px;color: #5C5C5C;line-height: 50px;display:inline-block;padding-right: 5px; padding-left: 5px;}
	.block_item .soder_sklad{font-family: PT Sans; font-size: 14px; color: #EA5B35;}
	.block_item .oldprice{font-family: PT Sans; font-size: 12px; color: #5C5C5C;text-decoration-line: line-through;padding-left: 10px;}
	.block_item .nowprice{font-family: PT Sans; font-size: 16px; align-items: center;}
	.block_item .otcentr{  position: absolute; left: 50%; transform: translate(-50%);}
	.block_item .soder_sum{  font-family: PT Sans; font-size: 16px;white-space: nowrap;}
	.block_item .soder_skidka{  font-family: PT Sans; display:inline-block;width:50px;line-height:34px;color:#ffffff;background-color: #EA5B35;text-align:center;}
	.block_item .blokdiskount{  text-align:right;}
	.oboloch_doing{text-align:right;}
	.block-doing--favourite i {    padding: 5px;   border: 1px solid #ccc;  color: #ccc;}
	.block-doing--delete span{padding: 5px;   border: 1px solid #ccc;  color: #ccc;}
	.block-doing--favourite, .block-doing--delete, .block-doing--favourite:hover, .block-doing--delete:hover, .block-doing--favourite:visited, .block-doing--delete:visited {text-decoration:none;}
	.block-doing--favourite:hover i{background-color:#ccc;color: #fff;}
	.block-doing--delete:hover span{background-color:#EA5B35;color: #fff;}
	.block_item .order__btn {margin-top:0;}
	.block_item .order__btn .btn-oforml{background-color:#EA5B35; border-radius:0;font-size: 14px;width: 100%;}
	.block_item .bx_ordercart_order_pay_left{margin-top:-5px;}
	.plus, .minus{border: 1px solid; width: 20px; display: block; text-align: center; line-height: 15px; cursor: pointer;}
	.plus{border-bottom: none; padding-bottom: 1px;}
	.js-q-item{position:relative;}
	.uvel{display: block;position: absolute;top: 0px;right: 0px;}
	.block_item--doing .blokdiskount {display:none;}
	@media screen and (max-width: 576px) {
		.block_item .blokdiskount{display:none;}
		.block_item .block_name{line-height: 20px;}
		.block_item .oboloch_doing .opis_zg0{display:none;}
		.block_item .block_item--name{padding-left:0;}
		.block_item .block_item--doing{padding-right:0;}
		.block_item .block_item--mob_item{padding-right:0;padding-left:0;}
		.block_item .block-doing--favourite i {    padding: 10px;}
		.block-doing--delete span {    padding: 9px 10px 11px;}
		.block_item--doing .blokdiskount {display:block;}
		.block_item .block_item--doing .blokdiskount .opis_zg{display: inline-block;   line-height: 30px;}
		.block_item .block_item--doing .blokdiskount .soder_skidka{font-size: 14px; line-height: 20px;  width: 40px;}
		.block_item .block_item--mob_photo{display:block !important; padding-left:0; padding-top:15px;}
		.block_item .block_item--mob_photo img{position: absolute; margin: auto; left: 0; top: 0; bottom: 0; right: 0;}
		.block_item .block_item--mob_also{padding-top:0;}
		.block_item .block_item--mob_nal .opis_zg{display:none;}
		.block_item .block_item--mob_nal, .block_item .block_item--mob_input{padding-left:5px;padding-top:15px;}
		.block_item .block_item--mob_input, .block_item .block_item--mob_amount, .block_item .block_item--mob_cena{padding-top:15px;}
		.block_item .block_item--mob_input .opis_zg{line-height:20px;} 
		.block_item .block_item--mob_cena .otcentr{position: relative;} 
		.block_item .block_item--mob_cena .otcentr .opis_zg{line-height:20px;} 
		.block_item .block_item--mob_amount .opis_zg{line-height:20px;} 
		.block_item .block_item--itogo {padding:0;}
		.block_item .block_item--itogo .otcentr{position:relative;}
	}
	</style>