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


	<div class="menu__line">

		<?$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);?>

		<?if($nothing || isset($_REQUEST["filter_history"])):?>
			<a class="btn" href="<?=$arResult["CURRENT_PAGE"]?>?show_all=Y"><?=GetMessage('SPOL_ORDERS_ALL')?></a>
		<?endif?>

		<?if($_REQUEST["filter_history"] == 'Y' || $_REQUEST["show_all"] == 'Y'):?>
			<a class="btn" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N"><?=GetMessage('SPOL_CUR_ORDERS')?></a>
		<?endif?>

		<?if($nothing || $_REQUEST["filter_history"] == 'N' || $_REQUEST["show_all"] == 'Y'):?>
			<a class="btn" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y"><?=GetMessage('SPOL_ORDERS_HISTORY')?></a>
		<?endif?>
	</div>

	<?if(!empty($arResult['ORDERS'])):?>

		<table class="table table__order">
			<thead>
				<tr>
					<th class="td__number"><?=GetMessage('SPOL_ORDER')?></th>
					<th class="td__date"><?=GetMessage('SPOL_DATE')?></th>
					<th class="td__good"><?=GetMessage('SPOL_BASKET')?></th>
					<th class="td__sum"><?=GetMessage('SPOL_PAY_SUM')?></th>
					<th class="td__status"><?=GetMessage('SPOL_STATE')?></th>
					<th class="td__doing"><?=GetMessage('SPOL_DO')?></th>
				</tr>
			</thead>
			<tbody>
				<?foreach($arResult["ORDER_BY_STATUS"] as $key => $group):?>
					<?foreach($group as $k => $order):?>
						<tr>
							<td class="td__number">
								<em><?=GetMessage('SPOL_ORDER')?></em>
								<div class="td__inner">
									<a href="<?=$order["ORDER"]["URL_TO_DETAIL"]?>"><?=$order["ORDER"]["ACCOUNT_NUMBER"]?></a>
								</div>
							</td>
							<td class="td__date">
								<em><?=GetMessage('SPOL_DATE')?>:</em>
								<div class="td__inner">
									<?if(strlen($order["ORDER"]["DATE_INSERT_FORMATED"])):?>
										<?=$order["ORDER"]["DATE_INSERT_FORMATED"];?>
									<?endif?>
								</div>
							</td>
							<td class="td__good">
								<em><?=GetMessage('SPOL_BASKET')?>:</em>
								<div class="td__inner">
									<?foreach ($order["BASKET_ITEMS"] as $item):?>
										<?if(strlen($item["DETAIL_PAGE_URL"])):?>
											<a href="<?=$item["DETAIL_PAGE_URL"]?>" target="_blank">
										<?endif?>
											<?=$item['NAME']?>
										<?if(strlen($item["DETAIL_PAGE_URL"])):?>
											</a>
										<?endif?>
									<?endforeach?>
								</div>
							</td>
							<td class="td__sum">
								<em><?=GetMessage('SPOL_PAY_SUM')?>:</em>
								<div class="td__inner">
									<div class="td__sum--price">
										<span class="price"><?=$order["ORDER"]["FORMATED_PRICE"]?></span>
									</div>
								</div>
							</td>
							<td class="td__status">
								<em><?=GetMessage('SPOL_STATE')?>:</em>
								<div class="td__inner"><?

									if($arResult["INFO"]["STATUS"][$key]['COLOR'] == 'green')
									{
										?><span class="text-success"><?=$arResult["INFO"]["STATUS"][$key]["NAME"]?></span><?
									}
									else if($arResult["INFO"]["STATUS"][$key]['COLOR'] == 'gray')
									{
										?><span class="text-default"><?=$arResult["INFO"]["STATUS"][$key]["NAME"]?></span><?
									}
									else if($arResult["INFO"]["STATUS"][$key]['COLOR'] == 'red')
									{
										?><span class="text-danger"><?=$arResult["INFO"]["STATUS"][$key]["NAME"]?></span><?
									}
									else if($arResult["INFO"]["STATUS"][$key]['COLOR'] == 'yellow')
									{
										?><span class="text-warning"><?=$arResult["INFO"]["STATUS"][$key]["NAME"]?></span><?
									}
									else
									{
										?><span><?=$arResult["INFO"]["STATUS"][$key]["NAME"]?></span><?
									}

								?></div>
							</td>
							<td class="td__doing">
								<em><?=GetMessage('SPOL_DO')?>:</em>
								<div class="td__inner">
									<div class="td__doing--btn"><?

										if ($order["ORDER"]["PAYED"] == "Y")
										{
											?><a href="<?=$order["ORDER"]["URL_TO_COPY"]?>">
												<i class="icon-loop"></i><span><?=GetMessage('SPOL_REPEAT_ORDER')?></span>
											</a><?
										}
										elseif($arResult['PAY_LINKS'][$order["ORDER"]["ID"]])
										{
//											?><a href="<?=$arResult['PAY_LINKS'][$order["ORDER"]["ID"]]?>" title="Оплатить"><i class="icon-wallet"></i><span>Оплатить</span></a><?//
										}
										elseif($order['PAYMENT'][0]['ACTION_FILE']=='assist')
										{
//											?><a target="_blank" href="/personal/order/payment/?ORDER_ID=<?=$order['PAYMENT'][0]['ORDER_ID']?>&PAYMENT_ID=<?=$order['PAYMENT'][0]['ID']?>" title="Оплатить"><i class="icon-wallet"></i><span>Оплатить</span></a><?//
										}
										

										if($order["ORDER"]["CANCELED"] != "Y")
										{
											?><a href="<?=$order["ORDER"]["URL_TO_CANCEL"]?>" title="<?=GetMessage('SPOL_CANCEL_ORDER')?>">
												<i class="icon-close"></i><span><?=GetMessage('SPOL_CANCEL_ORDER')?></span>
											</a><?
										}

									?></div>
								</div>
							</td>
						</tr>
					<?endforeach?>
				<?endforeach?>
			</tbody>
		</table>

		<?if(strlen($arResult['NAV_STRING'])):?>
			<?=$arResult['NAV_STRING']?>
		<?endif?>

	<?else:?>
		<?=GetMessage('SPOL_NO_ORDERS')?>
	<?endif?>

<?endif;