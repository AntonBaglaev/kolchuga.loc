<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($arResult['ERRORS']['FATAL'])):?>

	<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
		<?=ShowError($error)?>
	<?endforeach?>

	<?$component = $this->__component;?>
	<?if($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])):?>
		<?$APPLICATION->AuthForm('', false, false, 'N', false);?>
	<?endif?>

<?else:?>

	<?if(!empty($arResult['ERRORS']['NONFATAL'])):?>
		<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>
	<?endif?>

	<table class="table table__info">
		<tr>
			<th>Дата заказа</th>
			<td>
				<?if(strlen($arResult["DATE_INSERT_FORMATED"])):?>
					<?=$arResult["DATE_INSERT_FORMATED"]?>
				<?endif?>
			</td>
		</tr>
		<tr>
			<th><?=GetMessage('SPOD_ORDER_STATUS')?></th>
			<td>
				<?=$arResult["STATUS"]["NAME"]?>

				<?/* Отменен */?>
				<?if($arResult["CANCELED"] == "Y" || $arResult["CAN_CANCEL"] == "Y"):?>
					<?if($arResult["CANCELED"] == "Y"):?>
						<?=GetMessage('SPOD_ORDER_CANCELED')?>
						<?if(strlen($arResult["DATE_CANCELED_FORMATED"])):?>
							(<?=GetMessage('SPOD_FROM')?> <?=$arResult["DATE_CANCELED_FORMATED"]?>)
						<?endif?>
					<?endif?>
				<?endif?>

				<span class="text-warning">Ждет оплаты</span>
			</td>
		</tr>
		<tr>
			<th><?=GetMessage('SPOD_ORDER_PRICE')?>:</th>
			<td>
				<span class="price"><?=$arResult["PRICE_FORMATED"]?></span>
				<?if(floatval($arResult["SUM_PAID"])):?>
					(<?=GetMessage('SPOD_ALREADY_PAID')?>:&nbsp;<?=$arResult["SUM_PAID_FORMATED"]?>)
				<?endif?>
			</td>
		</tr>
		<tr>
			<th>Действия</th>
			<td>
				<a href="#" title="Оплатить" class="btn btn-primary"><span>Оплатить</span></a>

				<?if($arResult["CANCELED"] == "Y" || $arResult["CAN_CANCEL"] == "Y"):?>
					<?if($arResult["CANCELED"] == "Y"):?>
					<?elseif($arResult["CAN_CANCEL"] == "Y"):?>
						<a href="<?=$arResult["URL_TO_CANCEL"]?>" title="<?=GetMessage("SPOD_ORDER_CANCEL")?>" class="btn btn-primary"><span><?=GetMessage("SPOD_ORDER_CANCEL")?></span></a>
					<?endif?>
				<?endif?>
			</td>
		</tr>
		<?/*if(intval($arResult["USER_ID"])):?>
			<tr>
				<td colspan="2"><h4><?=GetMessage('SPOD_ACCOUNT_DATA')?></h4></td>
			</tr>
			<?if(strlen($arResult["USER_NAME"])):?>
				<tr>
					<th><?=GetMessage('SPOD_ACCOUNT')?></th>
					<td><?=$arResult["USER_NAME"]?></td>
				</tr>
			<?endif?>
			<tr>
				<th><?=GetMessage('SPOD_LOGIN')?></th>
				<td><?=$arResult["USER"]["LOGIN"]?></td>
			</tr>
			<tr>
				<th><?=GetMessage('SPOD_EMAIL')?></th>
				<td><a href="mailto:<?=$arResult["USER"]["EMAIL"]?>"><?=$arResult["USER"]["EMAIL"]?></a></td>
			</tr>
		<?endif*/?>
		<?if (isset($arResult["ORDER_PROPS"])):?>
			<?foreach($arResult["ORDER_PROPS"] as $prop):?>
				<?if($prop["SHOW_GROUP_NAME"] == "Y"):?>
					<tr>
						<td colspan="2"><h4><?=$prop["GROUP_NAME"]?></h4></td>
					</tr>
				<?endif?>
				<tr>
					<th><?=$prop['NAME']?></th>
					<td>
						<?if($prop["TYPE"] == "CHECKBOX"):?>
							<?=GetMessage('SPOD_'.($prop["VALUE"] == "Y" ? 'YES' : 'NO'))?>
						<?else:?>
							<?=$prop["VALUE"]?>
						<?endif?>
					</td>
				</tr>
			<?endforeach?>
		<?endif;?>
		<?foreach ($arResult['SHIPMENT'] as $shipment):?>
			<tr>
				<th><?=GetMessage("SPOD_ORDER_DELIVERY")?></th>
				<td>
					<?if (intval($shipment["DELIVERY_ID"])):?>
						<?=$shipment["DELIVERY"]["NAME"]?>
						<?if(intval($shipment['STORE_ID']) && !empty($arResult["DELIVERY"]["STORE_LIST"][$shipment['STORE_ID']])):?>
							<?$store = $arResult["DELIVERY"]["STORE_LIST"][$shipment['STORE_ID']];?>
							<div class="bx_ol_store">
								<div class="bx_old_s_row_title">
									<?=GetMessage('SPOD_TAKE_FROM_STORE')?>: <b><?=$store['TITLE']?></b>
									<?if(!empty($store['DESCRIPTION'])):?>
										<div class="bx_ild_s_desc">
											<?=$store['DESCRIPTION']?>
										</div>
									<?endif?>
								</div>
								<?if(!empty($store['ADDRESS'])):?>
									<div class="bx_old_s_row">
										<b><?=GetMessage('SPOD_STORE_ADDRESS')?></b>: <?=$store['ADDRESS']?>
									</div>
								<?endif?>
								<?if(!empty($store['SCHEDULE'])):?>
									<div class="bx_old_s_row">
										<b><?=GetMessage('SPOD_STORE_WORKTIME')?></b>: <?=$store['SCHEDULE']?>
									</div>
								<?endif?>
								<?if(!empty($store['PHONE'])):?>
									<div class="bx_old_s_row">
										<b><?=GetMessage('SPOD_STORE_PHONE')?></b>: <?=$store['PHONE']?>
									</div>
								<?endif?>
								<?if(!empty($store['EMAIL'])):?>
									<div class="bx_old_s_row">
										<b><?=GetMessage('SPOD_STORE_EMAIL')?></b>: <a href="mailto:<?=$store['EMAIL']?>"><?=$store['EMAIL']?></a>
									</div>
								<?endif?>
								<?if(($store['GPS_N'] = floatval($store['GPS_N'])) && ($store['GPS_S'] = floatval($store['GPS_S']))):?>
									<div id="bx_old_s_map">
										<div class="bx_map_buttons">
											<a href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" id="map-show">
												<?=GetMessage('SPOD_SHOW_MAP')?>
											</a>
											<a href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" id="map-hide">
												<?=GetMessage('SPOD_HIDE_MAP')?>
											</a>
										</div>
										<?ob_start();?>
											<div><?$mg = $arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE'];?>
												<?if(!empty($mg['SRC'])):?><img src="<?=$mg['SRC']?>" width="<?=$mg['WIDTH']?>" height="<?=$mg['HEIGHT']?>"><br /><br /><?endif?>
												<?=$store['TITLE']?></div>
										<?$ballon = ob_get_contents();?>
										<?ob_end_clean();?>
										<?
											$mapId = '__store_map';
											$mapParams = array(
											'yandex_lat' => $store['GPS_N'],
											'yandex_lon' => $store['GPS_S'],
											'yandex_scale' => 16,
											'PLACEMARKS' => array(
												array(
													'LON' => $store['GPS_S'],
													'LAT' => $store['GPS_N'],
													'TEXT' => $ballon
												)
											));
										?>
										<div id="map-container">
											<?$APPLICATION->IncludeComponent("bitrix:map.yandex.view", ".default", array(
												"INIT_MAP_TYPE" => "MAP",
												"MAP_DATA" => serialize($mapParams),
												"MAP_WIDTH" => "100%",
												"MAP_HEIGHT" => "200",
												"CONTROLS" => array(
													0 => "SMALLZOOM",
												),
												"OPTIONS" => array(
													0 => "ENABLE_SCROLL_ZOOM",
													1 => "ENABLE_DBLCLICK_ZOOM",
													2 => "ENABLE_DRAGGING",
												),
												"MAP_ID" => $mapId
												),
												false
											);?>
										</div>
										<?CJSCore::Init();?>
										<script>
											new CStoreMap({mapId:"<?=$mapId?>", area: '.bx_old_s_map'});
										</script>
									</div>
								<?endif?>
							</div>
						<?endif?>
					<?else:?>
						<?=GetMessage("SPOD_NONE")?>
					<?endif?>
				</td>
			</tr>
			<?if($shipment["TRACKING_NUMBER"]):?>
				<tr>
					<th><?=GetMessage('SPOD_ORDER_TRACKING_NUMBER')?></th>
					<td><?=$shipment["TRACKING_NUMBER"]?></td>
				</tr>
				<?if(isset($shipment["TRACKING_STATUS"])):?>
					<tr>
						<th><?=GetMessage('SPOD_ORDER_TRACKING_STATUS')?></th>
						<td><?=$shipment["TRACKING_STATUS"]?></td>
					</tr>
				<?endif?>
				<?if(!empty($shipment["TRACKING_DESCRIPTION"])):?>
					<tr>
						<th><?=GetMessage('SPOD_ORDER_TRACKING_DESCRIPTION')?></th>
						<td><?=$shipment["TRACKING_DESCRIPTION"]?></td>
					</tr>
				<?endif?>
			<?endif?>
			<?/*<tr>
				<th><?=GetMessage('SPOD_ORDER_SHIPMENT_BASKET')?></th>
				<td>
					<?foreach ($shipment['ITEMS'] as $item):?>
						<?=$item['NAME']." (".$item['QUANTITY'].' '.$item['MEASURE_NAME'].") "?><br>
					<?endforeach;?>
				</td>
			</tr>*/?>
		<?endforeach;?>
		<?/*
			<tr>
				<td colspan="2"><h4><?=GetMessage('SPOD_ORDER_PROPERTIES')?></h4></td>
			</tr>
			<tr>
				<th><?=GetMessage('SPOD_ORDER_PERS_TYPE')?></th>
				<td><?=$arResult["PERSON_TYPE"]["NAME"]?></td>
			</tr>
			<?if(!empty($arResult["USER_DESCRIPTION"])):?>
				<tr>
					<th><?=GetMessage('SPOD_ORDER_USER_COMMENT')?></th>
					<td><?=$arResult["USER_DESCRIPTION"]?></td>
				</tr>
			<?endif?>
		*/?>
		<tr>
			<td colspan="2"><h4><?=GetMessage("SPOD_ORDER_PAYMENT")?></h4></td>
		</tr>
		<?foreach ($arResult['PAYMENT'] as $payment):?>
			<tr>
				<th><?=GetMessage('SPOD_PAY_SYSTEM')?></th>
				<td>
					<?if(intval($payment["PAY_SYSTEM_ID"])):?>
						<?if ($payment['PAY_SYSTEM']):?>
							<?=$payment["PAY_SYSTEM"]["NAME"].' ('.$payment['PRICE_FORMATED'].')'?>
						<?else:?>
							<?=$payment["PAY_SYSTEM_NAME"].' ('.$payment['PRICE_FORMATED'].')';?>
						<?endif;?>
					<?else:?>
						<?=GetMessage("SPOD_NONE")?>
					<?endif?>
				</td>
			</tr>
			<tr>
				<th><?=GetMessage('SPOD_ORDER_PAYED')?></th>
				<td>
					<?if($payment["PAID"] == "Y"):?>
						<?=GetMessage('SPOD_YES')?>
						<?if(strlen($payment["DATE_PAID_FORMATED"])):?>
							(<?=GetMessage('SPOD_FROM')?> <?=$payment["DATE_PAID_FORMATED"]?>)
						<?endif;?>
					<?else:?>
						<?=GetMessage('SPOD_NO')?>
						<?if($payment["CAN_REPAY"]=="Y" && $payment["PAY_SYSTEM"]["PSA_NEW_WINDOW"] == "Y"):?>
							&nbsp;&nbsp;&nbsp;[<a href="<?=$payment["PAY_SYSTEM"]["PSA_ACTION_FILE"]?>" target="_blank"><?=GetMessage("SPOD_REPEAT_PAY")?></a>]
						<?endif;?>
					<?endif;?>
				</td>
			</tr>
			<?if($payment["CAN_REPAY"]=="Y" && $payment["PAY_SYSTEM"]["PSA_NEW_WINDOW"] != "Y")
				{
					if (array_key_exists('ERROR', $payment) && strlen($payment['ERROR']) > 0)
					{
						echo '<tr><td colspan="2">';
						ShowError($payment['ERROR']);
						echo '</td></tr>';
					}
					elseif (array_key_exists('BUFFERED_OUTPUT', $payment))
					{
						if($payment['BUFFERED_OUTPUT'] != '')
						{
							echo '<tr><td colspan="2">';
							echo $payment['BUFFERED_OUTPUT'];
							echo '</td></tr>';
						}
					}
				}
			?>
		<?endforeach;?>
	</table>

	<h4><?=GetMessage('SPOD_ORDER_BASKET')?></h4>
 	<table class="table table__goods">
		<thead>
			<tr>
				<th class="td__name"><?=GetMessage('SPOD_NAME')?></th>
				<th class="td__price"><?=GetMessage('SPOD_PRICE')?></th>
				<th class="td__discount"><?=GetMessage('SPOD_DISCOUNT')?></th>
				<th class="td__price-discount">Цена с учетом скидки</th>
				<th class="td__number"><?=GetMessage('SPOD_QUANTITY')?></th>
				<th class="td__sum">Сумма</th>
			</tr>
		</thead>
		<tbody>
		<?if (isset($arResult["BASKET"])):?>
			<?foreach($arResult["BASKET"] as $prod):?>
				<tr>
					<?$hasLink = !empty($prod["DETAIL_PAGE_URL"]);?>
					<td class="td__name">
						<em>Название</em>
						<div class="td__inner">
							<div class="td__name--inner">
								<div class="td__name--img">
									<?if($hasLink):?>
										<a href="<?=$prod["DETAIL_PAGE_URL"]?>" target="_blank">
									<?endif?>
									<?if($prod['PICTURE']['SRC']):?>
										<img src="<?=$prod['PICTURE']['SRC']?>" alt="<?=$prod['NAME']?>" />
									<?else:?>
										<div class="no-photo"></div>
									<?endif?>
									<?if($hasLink):?>
										</a>
									<?endif?>
								</div>
								<div class="td__name--title">
									<?if($hasLink):?>
										<a href="<?=$prod["DETAIL_PAGE_URL"]?>" target="_blank">
									<?endif?>
									<?=htmlspecialcharsEx($prod["NAME"])?>
									<?if($hasLink):?>
										</a>
									<?endif?>

									<?if($arResult['HAS_PROPS']):?>
										<?
										$actuallyHasProps = is_array($prod["PROPS"]) && !empty($prod["PROPS"]);
										?>
										<?if($actuallyHasProps):?><span class="fm"><?=GetMessage('SPOD_PROPS')?>:</span><?endif?>
										<table cellspacing="0" class="bx_ol_sku_prop">
											<?if($actuallyHasProps):?>
												<?foreach($prod["PROPS"] as $prop):?>
													<?if(!empty($prop['SKU_VALUE']) && $prop['SKU_TYPE'] == 'image'):?>
														<tr>
															<td colspan="2">
																<nobr><?=$prop["NAME"]?>:</nobr><br />
																<img src="<?=$prop['SKU_VALUE']['PICT']['SRC']?>" width="<?=$prop['SKU_VALUE']['PICT']['WIDTH']?>" height="<?=$prop['SKU_VALUE']['PICT']['HEIGHT']?>" title="<?=$prop['SKU_VALUE']['NAME']?>" alt="<?=$prop['SKU_VALUE']['NAME']?>" />
															</td>
														</tr>
													<?else:?>
														<tr>
															<td><nobr><?=$prop["NAME"]?>:</nobr></td>
															<td style="padding-left: 10px !important"><b><?=$prop["VALUE"]?></b></td>
														</tr>
													<?endif?>
												<?endforeach?>
											<?endif?>
										</table>
									<?endif?>

								</div>
							</div>
						</div>
					</td>
					<td class="td__price">
						<em><?=GetMessage('SPOD_PRICE')?></em>
						<div class="td__inner">
							<div class="price__block">
								<span class="price"><?=$prod["PRICE_FORMATED"]?></span>
							</div>
						</div>
					</td>
					<td class="td__discount">
						<em><?=GetMessage('SPOD_DISCOUNT')?></em>
						<div class="td__inner">
							<div class="price__block">
								<?if($arResult['HAS_DISCOUNT']):?>
									<span class="discount"><?=$prod["DISCOUNT_PRICE_PERCENT_FORMATED"]?></span>
								<?endif?>
							</div>
						</div>
					</td>
					<td class="td__price-discount">
						<em>Цена с учетом скидки</em>
						<div class="td__inner">
							<div class="price__block">
								<span class="price">16 690 руб.</span>
							</div>
						</div>
					</td>
					<td class="td__number">
						<em><?=GetMessage('SPOD_QUANTITY')?></em>
						<div class="td__inner">
							<span title="Количество"><?=$prod["QUANTITY"]?></span>
						</div>
					</td>
					<td class="td__sum">
						<em>Сумма</em>
						<div class="td__inner">
							<span class="price-total"></span>
						</div>
					</td>
				</tr>
			<?endforeach?>
		<?endif;?>
		</tbody>
	</table>

	<div class="text-right">
		<div class="table__total--wrap">
			<table class="table table__total">
				<? ///// WEIGHT ?>
				<?/*if(floatval($arResult["ORDER_WEIGHT"])):?>
					<tr>
						<td><?=GetMessage('SPOD_TOTAL_WEIGHT')?></td>
						<td><?=$arResult['ORDER_WEIGHT_FORMATED']?></td>
					</tr>
				<?endif*/?>
				<? ///// PRICE SUM ?>
				<tr class="order__sum">
					<td><?=GetMessage('SPOD_PRODUCT_SUM')?></td>
					<td><?=$arResult['PRODUCT_SUM_FORMATTED']?></td>
				</tr>
				<? ///// DISCOUNT ?>
				<?if(floatval($arResult["DISCOUNT_VALUE"])):?>
					<tr class="order__discount">
						<td><?=GetMessage('SPOD_DISCOUNT')?></td>
						<td><?=$arResult["DISCOUNT_VALUE_FORMATED"]?></td>
					</tr>
				<?endif?>
				<? ///// DELIVERY PRICE: print even equals 2 zero ?>
				<?if(strlen($arResult["PRICE_DELIVERY_FORMATED"])):?>
					<tr class="order__delivery">
						<td><?=GetMessage('SPOD_DELIVERY')?></td>
						<td><?=$arResult["PRICE_DELIVERY_FORMATED"]?></td>
					</tr>
				<?endif?>
				<? ///// TAXES DETAIL ?>
				<?/*foreach($arResult["TAX_LIST"] as $tax):?>
					<tr>
						<td><?=$tax["TAX_NAME"]?></td>
						<td><?=$tax["VALUE_MONEY_FORMATED"]?></td>
					</tr>
				<?endforeach*/?>
				<tr class="order__total">
					<td><?=GetMessage('SPOD_SUMMARY')?></td>
					<td><?=$arResult["PRICE_FORMATED"]?></td>
				</tr>
			</table>
		</div>
		<div class="order__btn">
			<?if($arResult["CANCELED"] == "Y" || $arResult["CAN_CANCEL"] == "Y"):?>
				<?if($arResult["CANCELED"] == "Y"):?>
				<?elseif($arResult["CAN_CANCEL"] == "Y"):?>
					<a href="<?=$arResult["URL_TO_CANCEL"]?>" title="<?=GetMessage("SPOD_ORDER_CANCEL")?>" class="btn btn-primary"><span><?=GetMessage("SPOD_ORDER_CANCEL")?></span></a>
				<?endif?>
			<?endif?>
			<a href="" class="btn btn-primary">Оплатить</a>
		</div>
	</div>

	<div class="text-left">
		<a href="<?=$arResult["URL_TO_LIST"]?>" class="btn btn-primary"><?=GetMessage('SPOD_GO_BACK')?></a>
	</div>

<?/*

	TODO:

	Доделать Столбец "Цена с учетом скидки", "Сумма"
	Функционал кнопок "Оплатить" в двух местах
	Функционал сообщений в таблице: Текущий статус заказа

*/?>

<?endif?>
