<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * Поддержка сессий
 */
session_start();

/**
 * Подключение файла настроек
 */
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/rbs.payment22/config.php");

/**
 * Подключение класса RBS
 */
require_once("rbs.php");
if (CSalePaySystemAction::GetParamValue("TEST_MODE") == 'Y') {$test_mode = true;} else {$test_mode = false;}
if (CSalePaySystemAction::GetParamValue("TWO_STAGE") == 'Y') {$two_stage = true;} else {$two_stage = false;}
if (CSalePaySystemAction::GetParamValue("LOGGING") == 'Y') {$logging = true;} else {$logging = false;}
$rbs = new RBS(CSalePaySystemAction::GetParamValue("USER_NAME"), CSalePaySystemAction::GetParamValue("PASSWORD"), $two_stage, $test_mode, $logging);

/**
 * Запрос register.do или regiterPreAuth.do в ПШ
 */

/* DataInlife */
$entityId = $GLOBALS["SALE_INPUT_PARAMS"]["PAYMENT"]["ID"];
list($orderId, $paymentId) = \Bitrix\Sale\PaySystem\Manager::getIdsByPayment($entityId);

$order_number = CSalePaySystemAction::GetParamValue("ORDER_NUMBER") . '_' . $paymentId;
$amount = CSalePaySystemAction::GetParamValue("AMOUNT") * 100;

$return_url =
	'http://' . $_SERVER['SERVER_NAME'] . '/sale/payment22/result.php?payment_id=' . $paymentId;

for ($i = 0; $i <= 10; $i++) {
	$response = $rbs->register_order($order_number.'_'.$i, $amount, $return_url);
	if ($response['errorCode'] != 1) break;
}

/**
 * Разбор ответа
 */
if ($response['errorCode'] != 0) {
	$error = 'Ошибка №'.$response['errorCode'].': '.$response['errorMessage'];
	if(ENCODING) {echo $error;} else {echo iconv("utf-8", "windows-1251", $error);}
} else if ($response['errorCode'] == 0){
	$_SESSION['ORDER_NUMBER'] = $order_number;
	header("Location:".$response['formUrl']);
} else {
	$error = "Неизвестная ошибка. Попробуйте оплатить заказ позднее.";
	if(ENCODING) {echo $error;} else {echo iconv("utf-8", "windows-1251", $error);}
}