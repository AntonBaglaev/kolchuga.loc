<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 20/06/16
 * Time: 11:00
 */

CModule::IncludeModule('subscribe');

$sub = CSubscription::GetList(
    array(),
    array('USER_ID' => $arResult['ID'])
)->fetch();

$arResult['SET_SUBSCRIBE'] = $sub ? true : false;
