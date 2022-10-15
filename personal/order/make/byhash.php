<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?>
<?
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
foreach($request as $key=>$vl){
	$requestArr[$key]=$vl;
}
if(!empty($requestArr['each_order_hash'])){
	if (CModule::IncludeModule("sale")){
		$listOrders=[];
	   $arFilter = Array(
		  "PROPERTY_CODE" => "EACH_ORDER_HASH",
		  "PROPERTY_VALUE" => $requestArr['each_order_hash'],
		  'CANCELED'=>'N',
		  'PAYED'=>'N',
		  );
	   $rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter, false, false, array('*'));
	   while ($arSales = $rsSales->Fetch())
	   {
		   $listOrders[]=$arSales['ID'];	
		   $pricedelivery[$arSales['ID']]=$arSales['PRICE_DELIVERY'];	
	   
	   }
	   
	   if(!empty($listOrders)){
		   if(count($listOrders)==1){
			   $hasAction = false;
			   foreach($listOrders as $id){
				   $order0 = \Bitrix\Sale\Order::load($id);
				   $paymentCollection = $order0->getPaymentCollection();					
					foreach($paymentCollection as $payment){
						$paid = $payment->isPaid();

						$paysystem = $payment->getPaySystem();
						if($paysystem->getField('ACTION_FILE') == 'assist' ){
							$hasAction = true;
						}							
					}
				   
			   }
			   if($hasAction){
				?><p>Спасибо за заказ! <br>Ожидайте письмо с ссылкой на оплату заказа на вашу электронную почту. Вы так же можете произвести оплату сейчас нажав на кнопку ниже.<br>В ближайшее время с вами свяжется менеджер для подтверждения заказа и согласования доставки.</p><?
			   }else{
				   ?><p>Спасибо за заказ! <br>В ближайшее время с вами свяжется менеджер для подтверждения заказа и согласования доставки.</p><?
			   }
		   }else{
				?><p>Спасибо за заказ! <br>
				Ваш Заказ разделен на несколько. 
				Каждый заказ оплачивается отдельно.</p>
				<br>
				
				<?foreach($listOrders as $id){
				   $order0 = \Bitrix\Sale\Order::load($id);
				   $paymentCollection = $order0->getPaymentCollection();					
					foreach($paymentCollection as $payment){
						$paid = $payment->isPaid();

						$paysystem = $payment->getPaySystem();
						if($paysystem->getField('ACTION_FILE') == 'assist' ){
							$hasAction = true;
						}							
					}
				   
			   }
			   if($hasAction){
				   ?><p>Не можете оплатить сейчас, ожидайте письмо с ссылкой на оплату заказа на вашу электронную почту.</p><?
			   }
		   }
		   
		   foreach($listOrders as $id){
			   $products = [];
			   $arResult['BASKET_ITEMS1'] = [];
				$res = CSaleBasket::GetList(
					array(
						"NAME" => "ASC",
						"ID" => "ASC"
					),
					array(
						"ORDER_ID" => $id
					),
					false,
					false,
					array("*")
				);
				while($item = $res->Fetch()){
					if((int)$item['PRODUCT_ID'] > 0){
					$products[] = $item['PRODUCT_ID'];}
					$item['ITEM']=\CCatalogProduct::GetByIDEx($item['PRODUCT_ID']);
					$arResult['BASKET_ITEMS1'][]=$item;
					
				}	
				//echo "<pre>";print_r($arResult['BASKET_ITEMS1']);echo "</pre>";
				?>
				<div class="container-fluid">
				<div class="row block_item">
					<div class="col-4 ">
						заказ <?=$id?>
					</div>
					<div class="col-8">
						<?
						$ule=[
							21=>'Cклад',
							18=>'Варварка',
							19=>'Ленинский проспект',
							20=>'Волоколамское шоссе',
							23=>'Барвиха',
						];
						$uleCompany=[
							2=>'Cклад',
							1=>'Варварка',
							3=>'Ленинский проспект',
							4=>'Волоколамское шоссе',
							5=>'Барвиха',
						];
						
						$order = \Bitrix\Sale\Order::load($id);
						$companyId=$order->getField('COMPANY_ID');
						
						$paymentCollection = $order->getPaymentCollection();
						
						$arPayments=[];
						foreach($paymentCollection as $payment){


							$paid = $payment->isPaid();

							$paysystem = $payment->getPaySystem();
							$cash = $paysystem->isCash();
							$hasAction = false;

							$pathToAction = \Bitrix\Main\Application::getDocumentRoot().$paysystem->getField('ACTION_FILE');

							$pathToAction = str_replace("\\", "/", $pathToAction);

							while (substr($pathToAction, strlen($pathToAction) - 1, 1) == "/")
								$pathToAction = substr($pathToAction, 0, strlen($pathToAction) - 1);


							if (file_exists($pathToAction))
							{
								if (is_dir($pathToAction) && file_exists($pathToAction."/payment.php"))
									$pathToAction .= "/payment.php";

								$hasAction = true;
							}

							if(!$paid && !$cash ){
								
									$link = '/personal/order/payment/' . '?ORDER_ID=' . $id . '&PAYMENT_ID=' . $payment->getId();
									$type = false;
								
							}
							else {
								$link = false;
							}

							$name = $payment->getField('PAY_SYSTEM_NAME');
							$arPayments = array(
								'PAY_SYSTEM_ID' => $payment->getField('PAY_SYSTEM_ID'),
								'NAME' => $name,
								'PAYMENT_ID' => $payment->getId(),
								'LINK' => $link,
								'PAID' => $paid,
								'TYPE' => $type,
							);
						}
						$allSum=0;
						?>
						
						<div class="soder_sklad"><?=(!empty($uleCompany[$companyId]) ? $uleCompany[$companyId]:$ule[$arPayments['PAY_SYSTEM_ID']])?></div>
					</div>
				</div>
		<? foreach ($arResult['BASKET_ITEMS1'] as $key => $arItem){ ?>
			<div class="row block_item">
				<div class="col-lg-4 d-none d-lg-block">
					<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
						<?if($arItem['ITEM']['PREVIEW_PICTURE']):?>
						<img src="<?=CFile::ResizeImageGet(
                $arItem['ITEM']['DETAIL_PICTURE'],
                array('width' => 250, 'height' => 187),
                BX_RESIZE_IMAGE_PROPORTIONAL
            )['src']?>" alt="<?=$arItem['NAME']?>">
						<?else:?>
							<div class="no-photo"></div>
						<?endif;?>
					</a>
				</div>
				<div class="col-12 col-lg-8 pr-lg-0 block_item--mob_item">
					
					<div class="row">
						<div class="col-8 col-lg-6 block_item--name">
							<div class="block_name"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
						</div>
						<!-- <div class="col-4 col-lg-6 pr-0 pl-0 block_item--doing">
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
						</div>	 -->					
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
							<div class="col-6 col-lg-6 block_item--mob_cena">
								<div class="otcentr1"><div class="opis_zg">
									Цена 
									<?if($arItem['BASE_PRICE']>$arItem['PRICE']){echo '<span class="oldprice">'. number_format($arItem['BASE_PRICE'], 0, '.', ' '); echo ' р.</span>';}?>
								</div>
								<div class="nowprice">
									<?= number_format($arItem['PRICE'], 0, '.', ' ') ?>  р.
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
								<div class="soder_sum"><?$sum=$arItem['PRICE']*$arItem['QUANTITY']; echo number_format($sum, 0, '.', ' '); echo ' р.'; $allSum=$allSum+$sum;?></div>							
							</div>
							<div class="col-lg-2 pr-lg-0">
								<?/* if($arItem['DISCOUNT_PRICE_PERCENT']>0){?>
									<div class="blokdiskount"><div class="opis_zg">Скидка</div>
									<div class="soder_skidka"><?=str_replace('руб','р.',$arItem['DISCOUNT_PRICE_PERCENT_FORMATED'])?></div></div>
								<?} */?>
							</div>
						</div></div>
					</div>
					<?if($arItem['ITEM']['PROPERTIES']['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY']['VALUE_ENUM'] != 'Да'){?>
					<div class="row">
						<div class="col-lg-12">
							<div class="opis_zg">Недоступно для оплаты онлайн</div>
						</div>												
					</div>
					<?}?>
					
				</div>
				
			</div>
		<?}?>
		<div class="row block_item">
				<div class="col-8 col-lg-4 pl-0">
					
				</div>
				<div class="col-4 col-lg-8 pr-0">
					<div class="container-fluid">
					<div class="row">
						
						<div class="col-12 col-lg-4 block_item--itogo">
							
								<div class="opis_zg">Итого</div>
								<div class="nowprice">
								<?if(intval($pricedelivery[$id])>0){
									$allSum=$allSum+$pricedelivery[$id];
								}?>
									<?echo number_format($allSum, 0, '.', ' '); echo ' р.'; ?>
								</div>
							
						</div>
						<div class="col-lg-2">
						
						</div>
						<div class="col-lg-4 pr-lg-0 d-none d-lg-block">
							<div class="opis_zg">&nbsp;</div>
							<div class="order__btn" <?=(!empty($arResult["KOMPLEKT"]))?"style='display:none'":""?>>
							<?if(!$arPayments['PAID'] && $arPayments['LINK']){?>
					
								<?/*<a href="<?=$arPayments['LINK']?>" class="btn btn-oforml">Оплатить сейчас</a>*/?>
								<?
								///local/templates/kolchuga_2016/payment/assist/template
								$params = array(
									'select' => array('ID'),
									'filter' => array(
										'LOGIC' => 'OR',
										'ID' => $arPayments['PAYMENT_ID'],
										'ACCOUNT_NUMBER' => $arPayments['PAYMENT_ID'],
									)
								);

								$data = \Bitrix\Sale\Internals\PaymentTable::getRow($params);
								$paymentItem = $paymentCollection->getItemById($data['ID']);
								foreach ($paymentCollection as $item)
								{
									if (!$item->isInner())
									{
										$paymentItem = $item;
										break;
									}
								}
								$service = \Bitrix\Sale\PaySystem\Manager::getObjectById($paymentItem->getPaymentSystemId());
								$context = \Bitrix\Main\Application::getInstance()->getContext();

								$service->initiatePay($paymentItem, $context->getRequest());
								/* $initResult = $service->initiatePay($paymentItem, $context->getRequest(), \Bitrix\Sale\PaySystem\BaseServiceHandler::STRING);
								$buffered_output = $initResult->getTemplate();
								*/

								?>
							
									<?}elseif(in_array($arPayments['PAY_SYSTEM_ID'], [1,11])){?>
									<?=$arPayments['NAME']?>
									<?}?>
							</div>
						</div>
						
					</div>
					
					</div>
				</div>
				<div class="col-12 pr-0 pl-0 d-block d-lg-none">							
							<div class="order__btn" <?=(!empty($arResult["KOMPLEKT"]))?"style='display:none'":""?>>
							<?if(!$arPayments['PAID'] && $arPayments['LINK']){?>
					
								<?/*<a href="<?=$arPayments['LINK']?>" class="btn btn-oforml">Оплатить сейчас</a>*/?>
								<?
								///local/templates/kolchuga_2016/payment/assist/template
								$params = array(
									'select' => array('ID'),
									'filter' => array(
										'LOGIC' => 'OR',
										'ID' => $arPayments['PAYMENT_ID'],
										'ACCOUNT_NUMBER' => $arPayments['PAYMENT_ID'],
									)
								);

								$data = \Bitrix\Sale\Internals\PaymentTable::getRow($params);
								$paymentItem = $paymentCollection->getItemById($data['ID']);
								foreach ($paymentCollection as $item)
								{
									if (!$item->isInner())
									{
										$paymentItem = $item;
										break;
									}
								}
								$service = \Bitrix\Sale\PaySystem\Manager::getObjectById($paymentItem->getPaymentSystemId());
								$context = \Bitrix\Main\Application::getInstance()->getContext();

								$service->initiatePay($paymentItem, $context->getRequest());
								/* $initResult = $service->initiatePay($paymentItem, $context->getRequest(), \Bitrix\Sale\PaySystem\BaseServiceHandler::STRING);
								$buffered_output = $initResult->getTemplate();
								*/

								?>
							
									<?}?>
							</div>
						</div>
				
			</div>
			
	</div>

	
	<?/*
				<table class="table table__order-list" >
                    <thead>
                    <tr>
                        <th class="td__name">Название</th>
                        <th class="td__price">Цена</th>
                        <th class="td__price-discount">Цена с учетом скидки</th>
                        <th class="td__number">Кол-во</th>
                        <th class="td__sum">Сумма</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    <? $items_count = 0;
                    $hasUnavailable = false;
                    foreach($arResult['BASKET_ITEMS1'] as $item):?>
                        <tr>
                            <td class="td__name">
                                <em>Название</em>
                                <div class="td__inner">
                                    <a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['NAME'] ?></a>
                                </div>
                            </td>
                            <td class="td__price">
                                <em>Цена:</em>
                                <div class="td__inner">
                                    <div class="price__block">
                                        <span class="price"><?= $item['BASE_PRICE'] ?></span>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="td__price-discount">
                                <em>Цена с учетом скидки</em>
                                <div class="td__inner">
                                    <div class="price__block">
                                        <span class="price"><?= $item['PRICE'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="td__number">
                                <em>Кол-во:</em>
                                <div class="td__inner">
                                    <span><?= $item['QUANTITY'] ?></span>
                                </div>
                            </td>
                            <td class="td__sum">
                                <em>Сумма:</em>
                                <div class="td__inner">
                                    <div class="td__sum--price">
                                        <span class="price"><?= $item['PRICE']*$item['QUANTITY'] ?></span>
                                    </div>
                                </div>
                            </td>
                            
                        </tr>
                        <? 
                    endforeach ?>
					<?if(intval($pricedelivery[$id])>0){
						?>
						<tr>
                        <th class="td__name">Доставка</th>
                        <th class="td__price"></th>
                        <th class="td__price-discount"></th>
                        <th class="td__number"></th>
                        <th class="td__sum"><?=$pricedelivery[$id]?></th>
                        
                    </tr>
						<?
					}?>
                    </tbody>
                </table>
				
				<?
				$order = \Bitrix\Sale\Order::load($id);

	
	$paymentCollection = $order->getPaymentCollection();
	
	$arPayments=[];
	foreach($paymentCollection as $payment){


		$paid = $payment->isPaid();

		
		$paysystem = $payment->getPaySystem();
		$cash = $paysystem->isCash();
		$hasAction = false;

		$pathToAction = \Bitrix\Main\Application::getDocumentRoot().$paysystem->getField('ACTION_FILE');

		$pathToAction = str_replace("\\", "/", $pathToAction);

		while (substr($pathToAction, strlen($pathToAction) - 1, 1) == "/")
			$pathToAction = substr($pathToAction, 0, strlen($pathToAction) - 1);


		if (file_exists($pathToAction))
		{
			if (is_dir($pathToAction) && file_exists($pathToAction."/payment.php"))
				$pathToAction .= "/payment.php";

			$hasAction = true;
		}

		if(!$paid && !$cash ){
			
				$link = '/personal/order/payment/' . '?ORDER_ID=' . $id . '&PAYMENT_ID=' . $payment->getId();
				$type = false;
			
		}
		else {
			$link = false;
		}

		$name = $payment->getField('PAY_SYSTEM_NAME');
		$picture = $paysystem->getField('LOGOTIP');

		if($picture > 0){
			$picture = CFile::ResizeImageGet($picture, array('width' => 40, 'height' => 40), BX_RESIZE_IMAGE_PROPORTIONAL)['src'];
		} else {
			$picture = SITE_TEMPLATE_PATH . '/images/nophoto.png';
			$picture = false;
		}

		$arPayments[] = array(
			'PAY_SYSTEM_ID' => $payment->getField('PAY_SYSTEM_ID'),
			'NAME' => $name,
			'PICTURE' => $picture,
			'LINK' => $link,
			'PAID' => $paid,
			'TYPE' => $type
		);
	}	
		if (!empty($arPayments))
		{
			?>
			
			
			<div class="payments-list" style="text-align: right;">
				<?foreach($arPayments as $payment):?>
				<div class="payments-list__item">
				<? if($payment['PICTURE']){?>
					<div class="payments-list__img">
						<img src="<?=$payment['PICTURE']?>" alt="">
					</div>
				<?} ?>
					<?if($payment['PAID']){?>
					<div class="payments-list__title">
						<?=$payment['NAME']?> [<span class="text-success">Оплачено</span>]
					</div><?}?>
					<?if(!$payment['PAID'] && $payment['LINK']){?>
					<div class="payments-list__submit" style=" display: inline-block;">
						<a href="<?=$link?>" target="_blank" class="btn btn-primary"><?=$type == 'PDF' ? 'Скачать счет' : 'Оплатить сейчас'?></a>
					</div>
					<?}?>
				</div>
				<?endforeach;?>
			</div>
		
			<?
		}
*/
	
		   }
		   
	   }
	   
	   
	}
}
?>
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
	.js-q-item{position:relative;}
	.uvel{display: block;position: absolute;top: 0px;right: 0px;}
	.block_item--doing .blokdiskount {display:none;}
	@media screen and (max-width: 576px) {
		.block_item .blokdiskount{display:none;}
		.block_item .block_name{line-height: 20px;}
		.block_item .oboloch_doing .opis_zg0{display:none;}
		.block_item .block_item--name{}
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
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>