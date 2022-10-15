<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use \Bitrix\Sale\Order,
	\Bitrix\Main;

if (!empty($arResult["ORDER"]))
{
	$id = $arResult['ORDER']['ID'];

	$arPayments = [];

	/** @var \Bitrix\Sale\Order $order */
	$order = Order::load($id);

	/** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
	$paymentCollection = $order->getPaymentCollection();
	/** @var \Bitrix\Sale\Payment $payment */
	foreach($paymentCollection as $payment){


		$paid = $payment->isPaid();

		/** @var \Bitrix\Sale\PaySystem\Service $paysystem */
		$paysystem = $payment->getPaySystem();
		$cash = $paysystem->isCash();
		$hasAction = false;

		$pathToAction = Main\Application::getDocumentRoot().$paysystem->getField('ACTION_FILE');

		$pathToAction = str_replace("\\", "/", $pathToAction);

		while (substr($pathToAction, strlen($pathToAction) - 1, 1) == "/")
			$pathToAction = substr($pathToAction, 0, strlen($pathToAction) - 1);


		if (file_exists($pathToAction))
		{
			if (is_dir($pathToAction) && file_exists($pathToAction."/payment.php"))
				$pathToAction .= "/payment.php";

			$hasAction = true;
		}

		if(!$paid && !$cash && ($hasAction || $paysystem->isAffordPdf())){
			if($paysystem->isAffordPdf()){
				$link = $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&PAYMENT_ID=".$payment->getId()."&pdf=1&DOWNLOAD=Y";
				$type = 'PDF';
			} else {
				$link = $arParams["PATH_TO_PAYMENT"] . '?ORDER_ID=' . $id . '&PAYMENT_ID=' . $payment->getId();
				$type = false;
			}
		}
		else {
			$link = false;
		}

		$name = $payment->getField('PAY_SYSTEM_NAME');
		$picture = $paysystem->getField('LOGOTIP');

		if($picture > 0){
			$picture = CFile::ResizeImageGet($picture, array('width' => 100, 'height' => 100), BX_RESIZE_IMAGE_PROPORTIONAL)['src'];
		} else {
			$picture = SITE_TEMPLATE_PATH . '/images/nophoto.png';
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

	?>
	<h2 class="text-default"><?=GetMessage("SOA_TEMPL_ORDER_COMPLETE")?></h2>
	<table class="sale_order_full_table">
		<tr>
			<td>
				<?= GetMessage("SOA_TEMPL_ORDER_SUC", Array("#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"], "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]))?>
				<br /><br />
				<?$ms=false;
				foreach($arPayments as $payment){
					if($payment['PAY_SYSTEM_ID']==3 || $payment['PAY_SYSTEM_ID']==17 ){ echo GetMessage("SOA_TEMPL_ORDER_SUC00"); $ms=true; }
				}
				if(!$ms){echo GetMessage("SOA_TEMPL_ORDER_SUC0");}
				?>
				<br /><br />
				<?= GetMessage("SOA_TEMPL_ORDER_SUC1", Array("#LINK#" => $arParams["PATH_TO_PERSONAL"])) ?>
			</td>
		</tr>
	</table>
	
	<?//Get basket ids
	$products = [];
	$res = CSaleBasket::GetList(
		array(
			"NAME" => "ASC",
			"ID" => "ASC"
		),
		array(
			"ORDER_ID" => $arResult['ORDER']['ID']
		),
		false,
		false,
		array("*")
	);
	while($item = $res->Fetch()){
		if((int)$item['PRODUCT_ID'] > 0){
		$products[] = $item['PRODUCT_ID'];}
		$arResult['BASKET_ITEMS1'][]=$item;
	}
	?>

	<?
	if (!empty($arResult["PAY_SYSTEM"]))
	{
		?>
		<br /><br />
		<h3 class="pay_name text-default"><?=GetMessage("SOA_TEMPL_PAY")?></h3>
		<div class="payments-list">
			<?foreach($arPayments as $payment):?>
			<div class="payments-list__item">
				<div class="payments-list__img">
					<img src="<?=$payment['PICTURE']?>" alt="">
				</div>
				<div class="payments-list__title">
					<?=$payment['NAME']?><?if($payment['PAID']){?> [<span class="text-success">Оплачено</span>]<?}?>
				</div>
				<?if(!$payment['PAID'] && $payment['LINK']):?>
				<div class="payments-list__submit">
					<a href="<?=$link?>" target="_blank" class="btn btn-primary"><?=$type == 'PDF' ? 'Скачать счет' : 'Оплатить'?></a>
				</div>
				<?endif?>
			</div>
			<?endforeach;?>
		</div>
    <script type="text/javascript">setTimeout(function(){YandexRG('send_kupit');}, 700);</script>
		<?
	}?>
	
	<h4>Состав вашего заказа</h4>
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
                    </tbody>
                </table>
	
<?}
else
{
	?>
	<b><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></b><br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>
	<?
}
?>