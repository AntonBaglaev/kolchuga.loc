<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($_REQUEST['ITEM_CODE'] && $arParams['SERVICE_CENTERS']['TITLE']) {
    $APPLICATION->SetPageProperty("title", $arParams['SERVICE_CENTERS']['TITLE'][addslashes(htmlspecialchars($_REQUEST['ITEM_CODE']))]);
    $APPLICATION->SetTitle($arParams['SERVICE_CENTERS']['TITLE'][addslashes(htmlspecialchars($_REQUEST['ITEM_CODE']))]);
}
