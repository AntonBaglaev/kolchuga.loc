<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
header('Content-Type: application/x-javascript; charset='.LANG_CHARSET);
define('INTERVOLGA_CONVERSION_AJAX',TRUE);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/intervolga.conversion/include.php");

$order = CIntervolgaConversion::getOrder();
if (is_array($order)) {
    echo('window.eshopOrder='.CUtil::PhpToJsObject($order).'; console.debug("Loaded order data");');
} else {

}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");