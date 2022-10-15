<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 20/10/15
 * Time: 16:15
 */

include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if(
    $_REQUEST['ajax'] == 'Y' && (is_array($_REQUEST['products']) || $_REQUEST['calc'] == 'Y') &&
    CModule::IncludeModule('sale') &&
    CModule::IncludeModule('catalog')
){

    if(!$_REQUEST['calc'] == 'Y'){
        foreach($_REQUEST['products'] as $item)
            $basket_rec[] = Add2BasketByProductID(intval($item['id']), intval($item['q']));
    }

    //var_dump($basket_rec);

//    if (!$basket_rec) {
//        echo json_encode(array('STATUS' => 'ERROR'));
//        die();
//    }

    $APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "", Array(
            "PATH_TO_BASKET" => "/personal/cart/",
            "PATH_TO_ORDER" => "/personal/order/make/",
            "SHOW_DELAY" => "Y",
            "SHOW_NOTAVAIL" => "Y",
            "SHOW_SUBSCRIBE" => "N"
        )
    );

}
