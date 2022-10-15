<?php
define("NO_KEEP_STATISTIC", true);
define('BX_SESSION_ID_CHANGE', false);
define('NO_AGENT_CHECK', true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use \Bitrix\Main,
    \Bitrix\Main\Localization\Loc as Loc,
    Bitrix\Main\Loader,
    Bitrix\Main\Config\Option,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem,
    Bitrix\Sale,
    Bitrix\Catalog,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\DiscountCouponsManager,
    Bitrix\Main\Context;
use \Bitrix\Highloadblock as HL;

if (!Loader::includeModule("catalog") ||
    !Loader::includeModule("sale") ||
    !Loader::includeModule("main") ||
    !Loader::includeModule("iblock"))
    die();

global $USER;

$SITE_ID = Context::getCurrent()->getSite();
$CURRENCY_CODE = CurrencyManager::getBaseCurrency();
$arResult = [];

$data['id'] = addslashes(htmlspecialchars($_REQUEST['id']));
$data['quantity'] = addslashes(htmlspecialchars($_REQUEST['quantity']));

if (isset($data['id']) && isset($data['quantity'])) {

    Add2BasketByProductID($data['id'], $data['quantity']);

    global $APPLICATION;
    if ($ex = $APPLICATION->GetException()) {
        $arResult['error'] = $ex->GetString();
    }

    $cntBasketItems = CSaleBasket::GetList(
        array(),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL"
        ),
        array()
    );

    $arResult['status'] = 'ok';
    $arResult['product'] = $data['id'];
    $arResult['basket_count'] = $cntBasketItems;

} else {
    $arResult['status'] = 'error';
    $arResult['product'] = [];
}

echo json_encode($arResult);
