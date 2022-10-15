<?php

$arItemsNew = [];

if ($arResult['ITEMS']) {

    foreach ($arResult['ITEMS'] as $key => $arItem) {
        $arItemsNew[$key * 100] = $arItem;
    }

    $arResult['ITEMS'] = $arItemsNew;

    $intCounter = 1;

    $arSelect = array("ID", "IBLOCK_ID", "*", "PROPERTY_ANONS");
    $arFilter = array("IBLOCK_ID" => 10, "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(array("ID" => "DESC"), $arFilter, false, array("nPageSize" => $arParams['NEWS_COUNT']), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        /*    $arProps = $ob->GetProperties();
            print_r($arProps);*/

        $arFields['PREVIEW_PICTURE'] = [];

        $arFields['PREVIEW_PICTURE']['SRC'] = CFile::GetPath($arFields['~PREVIEW_PICTURE']);

        $arResult['ITEMS'][$intCounter * 50] = $arFields;

        $intCounter = $intCounter + 2;
    }

    ksort($arResult['ITEMS']);
}

?>