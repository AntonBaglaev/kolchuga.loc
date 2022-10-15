<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Sale\Order as Order;
use Bitrix\Main\Type\DateTime;

/**
 * Поддержка сессий
 */
session_start();

/**
 * Подключение файла настроек
 */
if (!CModule::IncludeModule('sale')) return;
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/rbs.payment22/config.php");

/**
 * Вывод ошибок
 */
// error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_WARNING);
// ini_set('display_errors', 1);


if(isset($_GET["orderId"])) {

	$order_id = $_GET["ORDER_ID"];
	$order_number = explode('_', $_SESSION['ORDER_NUMBER'])[0];
	$arOrder = CSaleOrder::GetByID($order_number);
	CSalePaySystemAction::InitParamArrays($arOrder, $arOrder["ID"]);


	/**
	 * Подключение класса RBS
	 */
	require_once("rbs.php");
	if (CSalePaySystemAction::GetParamValue("TEST_MODE") == 'Y') {$test_mode = true;} else {$test_mode = false;}
	if (CSalePaySystemAction::GetParamValue("TWO_STAGE") == 'Y') {$two_stage = true;} else {$two_stage = false;}
	if (CSalePaySystemAction::GetParamValue("LOGGING") == 'Y') {$logging = true;} else {$logging = false;}
	$rbs = new RBS(CSalePaySystemAction::GetParamValue("USER_NAME"), CSalePaySystemAction::GetParamValue("PASSWORD"), $two_stage, $test_mode, $logging);
	
	$response = $rbs->get_order_status_by_orderId($orderId);


	/* Datainlife */
	$order_params = explode('_', $response['orderNumber']);
	$order_id = $order_params[0];
	$payment_id = $order_params[1];

	if($order_id < 1){
		throw new \Exception('ORDER ID is incorrect, Wrong link');
	}

	/** @var \Bitrix\Sale\Order $order */
	$order = Order::load($order_id);

	/** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
	$paymentCollection = $order->getPaymentCollection();

	/** @var \Bitrix\Sale\Payment $payment */
	$payment = $paymentCollection->getItemById($payment_id);

	/* Datainlife */
	$result = new \Bitrix\Sale\PaySystem\ServiceResult();

	//var_dump($payment_id);
	//var_dump($payment);

    if(($response['errorCode'] == 0) && (($response['orderStatus'] == 1) || ($response['orderStatus'] == 2))) {
	    // Сохранение ифнормации о заказе
		$arOrderFields = array(
			"PS_SUM" => $response["amount"]/100,
			"PS_CURRENCY" => $response["currency"],
			"PS_RESPONSE_DATE" => new DateTime(),
			"PS_STATUS" => "Y",
			"PS_STATUS_DESCRIPTION" => $response["cardAuthInfo"]["pan"].";".$response['cardAuthInfo']["cardholderName"],
			"PS_STATUS_MESSAGE" => $response["paymentAmountInfo"]["paymentState"],
			"PS_STATUS_CODE" => "Y",
		);

		$result->setPsData($arOrderFields);
		$result->setOperationType(\Bitrix\Sale\PaySystem\ServiceResult::MONEY_COMING);

		$payment->setFields($arOrderFields);
		$payment->setPaid('Y');

		// Статус заказа
		//CSaleOrder::StatusOrder($order_number, "P");
		//CSaleOrder::PayOrder($order_number, "Y", true, true);
		//CSaleOrder::DeliverOrder($order_number, "Y");
        
		// Вывод на экран
		$title = "Спасибо за покупку!";
		if ($response['orderStatus'] == 1) {
			$message =
				'Проведена авторизация суммы заказа №<a href="/personal/order/detail/'.$order_id.'/">' . $order_id .'</a>.';
		} else {
			$message =
				'Проведена авторизация суммы заказа №<a href="/personal/order/detail/'.$order_id.'/">' . $order_id .'</a>.';
		}
        if(!ENCODING) {
	        $title = iconv("utf-8", "windows-1251", $title);
			$message = iconv("utf-8", "windows-1251", $message);
        }
    } else if ($response['errorCode'] == 0) {
		$arOrderFields["PS_STATUS_MESSAGE"] = "[".$response["orderStatus"]."] ".$response["actionCodeDescription"];
		$title = "Оплата заказа №".$order_number;
		$message = "Статус заказа №".$response["orderStatus"].": ".$response["actionCodeDescription"];
		if(!ENCODING) {
			$arOrderFields["PS_STATUS_MESSAGE"] = iconv("utf-8", "windows-1251", $arOrderFields["PS_STATUS_MESSAGE"]);
	        $title = iconv("utf-8", "windows-1251", $title);
			$message = iconv("utf-8", "windows-1251", $message);
        }
    } else {
		$arOrderFields["PS_STATUS_MESSAGE"] = "[".$response["errorCode"]."] ".$response["errorMessage"];
		$title = "Оплата заказа №".$order_number;
		$message = "Код ошибки №".$response["errorCode"].": ".$response["errorMessage"];
		if(!ENCODING) {
			$arOrderFields["PS_STATUS_MESSAGE"] = iconv("utf-8", "windows-1251", $arOrderFields["PS_STATUS_MESSAGE"]);
	        $title = iconv("utf-8", "windows-1251", $title);
			$message = iconv("utf-8", "windows-1251", $message);
        }
	}

	//$order->onPaymentCollectionModify('UPDATE', $payment);
	$order->save();

} else {
	$title = "Ошибка!";
	$message = 'Заказ №'.(!empty($_REQUEST['ORDER_ID']) ? $_REQUEST['ORDER_ID']:'').' не найден!';
	if(!ENCODING) {
	$title = iconv("utf-8", "windows-1251", $title);
	$message = iconv("utf-8", "windows-1251", $message);
	}
}
$APPLICATION->SetTitle($title);
echo $message;
?>