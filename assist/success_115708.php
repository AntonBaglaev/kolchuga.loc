<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Спасибо за заказ");
?>

<?
	$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
	foreach($request as $key=>$vl){
		$requestArr[$key]=$vl;
	}
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/assist_success.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($requestArr, true), FILE_APPEND | LOCK_EX);
if(intval($requestArr['ordernumber'])>0){
	array_map('CModule::IncludeModule', ['iblock', 'catalog', 'sale']);

	$payments = array();
	$select = array(
		'ID', 'ORDER_ID', 'PAID', 'PAY_SYSTEM_ID'
	);
	$params = array(
		'select' => $select,
		'filter' => array('ID' => $requestArr['ordernumber'], 'PAY_SYSTEM_ID'=>21),
		'limit'  => 1,		
	);

	$dbResultList = \Bitrix\Sale\Internals\PaymentTable::getList($params);
	$payments = $dbResultList->fetchAll();
		
	//echo "<pre>";print_r($payments[0]);echo "</pre>";
	if(intval($payments[0]['ORDER_ID'])>0){
		$order = \Bitrix\Sale\Order::load($payments[0]['ORDER_ID']);
		$cancel=$order->getField("CANCELED");
		$sttus=$order->getField("STATUS_ID");
		$nuno_oplatit='N';

		if($cancel!='Y' && $sttus!='O' && $payments[0]['PAID']=='N'){
			$nuno_oplatit='Y';
		}

		if($nuno_oplatit=='Y'){
			\CSaleOrder::PayOrder($payments[0]['ORDER_ID'], "Y"); // статус оплачен (Y/N)
			\CSaleOrder::StatusOrder($payments[0]['ORDER_ID'], 'PU'); 
		}
		
		if($cancel=='Y'){
			?><p>Ваш заказ отменён.</p><?
		}elseif($sttus=='O'){
			?><p>Ваш заказ отменён.</p><?
		}elseif($payments[0]['PAID']=='Y'){
			?><p>Ваш заказ оплачен.</p><?
		}else{
			?><p>Ваш заказ оплачен.</p><?
		}
	}
}else{
	
}
//echo "<pre>";print_r($nuno_oplatit);echo "</pre>";

?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>