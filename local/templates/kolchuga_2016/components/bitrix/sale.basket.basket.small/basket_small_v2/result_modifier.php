<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arProductIds = [];

foreach ($arResult['ITEMS'] as $arItem) {
    $arProductIds[$arItem['PRODUCT_ID']] = $arItem['PRODUCT_ID'];
}

$arResult['PRODUCT_IDS'] = $arProductIds;
