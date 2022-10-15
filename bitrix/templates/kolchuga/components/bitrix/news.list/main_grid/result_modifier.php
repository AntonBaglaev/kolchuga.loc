<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 08/10/15
 * Time: 16:23
 */

$arResult['BIG_BANNERS'] = array();
$arResult['SMALL_BANNERS'] = array();
foreach($arResult['ITEMS'] as $key => $arItem){
    if($key < 2)
        $arResult['BIG_BANNERS'][] = $arItem;
    elseif($key < 4)
        $arResult['SMALL_BANNERS'][] = $arItem;
}