<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;
use Bitrix\Main\Context;
use Bitrix\Main\Localization\Loc;

//Календарь
CJSCore::Init(['popup', 'date']);

$arResult = [];

//Получаем товары пользователя
$basket = Basket::loadItemsForFUser(Fuser::getId(), Context::getCurrent()->getSite());

//Стоимость корзины
$_SESSION['DELIVERY_PRICE'] = 0;
$arResult['BASKET_USER']['PRICE_TOTAL'] = $basket->getPrice();
$arResult['BASKET_USER']['DELIVERY_TOTAL'] = 0;
$arResult['BASKET_USER']['ORDER_TOTAL'] = $basket->getPrice();

global $USER;
if ($USER->IsAuthorized()) {

    $resUser = \CUser::GetByID($USER->GetID());
    $arUser = $resUser->Fetch();

    //Телефон пользователя
    $arResult['USER_INFO']['PHONE'] = $arUser['PERSONAL_PHONE'];

    //Имя пользователя
    $arResult['USER_INFO']['NAME'] = $arUser['NAME'];

    //Email пользователя
    $arResult['USER_INFO']['EMAIL'] = $arUser['EMAIL'];

    //ФИО пользователя
    $arResult['USER_INFO']['USER_NAME'] = $arUser['NAME'];
    $arResult['USER_INFO']['USER_LAST_NAME'] = $arUser['LAST_NAME'];
    $arResult['USER_INFO']['USER_SECOND_NAME'] = $arUser['SECOND_NAME'];

}

//Подключаем шаблон
$this->IncludeComponentTemplate();

?>