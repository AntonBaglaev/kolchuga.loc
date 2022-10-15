<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Оплата заказа");
?>
<?
if(!$GLOBALS['USER']->IsAuthorized() && isset($_REQUEST['ORDER_ID']) && isset($_REQUEST['PAYMENT_ID'])){
$order_id=intval($_REQUEST['ORDER_ID']);
$order = \Bitrix\Sale\Order::load($order_id);
$paymentCollection = $order->getPaymentCollection();
	/** @var \Bitrix\Sale\Payment $payment */
	foreach($paymentCollection as $payment){

        	if(intval($_REQUEST['PAYMENT_ID'])==$payment->getId()){
			$GLOBALS['USER']->Authorize($order->getUserId());
		}

	}

}
?>

<?$APPLICATION->IncludeComponent(
	"datainlife:sale.order.payment",
	"",
	Array(
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>