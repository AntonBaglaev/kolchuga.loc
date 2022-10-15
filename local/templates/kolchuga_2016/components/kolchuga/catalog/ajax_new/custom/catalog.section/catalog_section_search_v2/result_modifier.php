<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 26.12.15
 * Time: 17:40
 */

if (count($arResult['ITEMS']) > 0) { // Исправление ошибки с отсутствующими товарми

    $arResult['SKU2'] = [];
    $arXmlIDGl = [];
    foreach ($arResult['ITEMS'] as $key => $arItem) {
        $arXmlIDGl[$arItem['ID']] = $arItem['XML_ID'];
    }
    $resPrice = \CIBlockPriceTools::GetCatalogPrices(40, array('Розничная'));

    $obCache = \Bitrix\Main\Application::getInstance()->getManagedCache();
    $cacheTtl = 3600 * 3;
    $cacheId = md5('\\Bitrix\\Iblock\\ElementTable::getList' . serialize($arXmlIDGl));
    $cachePath = 'catcustom_cache';
    if ($obCache->read($cacheTtl, $cacheId, $cachePath)) {
        //$arResult['SKU2'] = $obCache->get($cacheId); // достаем переменные из кеша
        $arResultFromCache = $obCache->get($cacheId); // достаем переменные из кеша
        $arResult['SKU2'] = $arResultFromCache['SKU2']; // достаем переменные из кеша
        $arResult['SKU2_ALL'] = $arResultFromCache['SKU2_ALL']; // достаем переменные из кеша
    } else {
        \CModule::IncludeModule('catalog');
        \CModule::IncludeModule('sale');
        $dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 40, 'PROPERTY_IDGLAVNOGO' => $arXmlIDGl, '>CATALOG_QUANTITY' => 0), false, false, array('ID', 'IBLOCK_ID', 'NAME', 'CATALOG_QUANTITY', 'PROPERTY_IDGLAVNOGO', 'CATALOG_GROUP_2'));
        while ($obEl = $dbEl->GetNext()) {

            $VALUES = array();
            $res = \CIBlockElement::GetProperty(40, $obEl['ID'], array("sort" => "asc"), array("CODE" => "RAZMER"));
            while ($ob = $res->GetNext()) {
                $VALUES[] = $ob['VALUE'];
            }
            $obPrice = \CIBlockPriceTools::GetItemPrices(40, $resPrice, $obEl);
            if (!empty($obPrice)) {
                $obEl['MIN_PRICE'] = \CIBlockPriceTools::getMinPriceFromList($obPrice);
            }
            if ($obEl['CATALOG_QUANTITY'] > 0) {
                $arResult['SKU2'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['QUANTITY'] = $obEl['CATALOG_QUANTITY'];
                $arResult['SKU2'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['CATALOG_QUANTITY'] = $obEl['CATALOG_QUANTITY'];
                $arResult['SKU2'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['PRICES'] = $obPrice;
                $arResult['SKU2'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['MIN_PRICE'] = $obEl["MIN_PRICE"];
                $arResult['SKU2'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['RAZMER'] = $VALUES[0];
                $arResult['SKU2_ALL'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']] = $arResult['SKU2'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']];
            } else {
                $arResult['SKU2_ALL'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['QUANTITY'] = $obEl['CATALOG_QUANTITY'];
                $arResult['SKU2_ALL'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['CATALOG_QUANTITY'] = $obEl['CATALOG_QUANTITY'];
                $arResult['SKU2_ALL'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['PRICES'] = $obPrice;
                $arResult['SKU2_ALL'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['MIN_PRICE'] = $obEl["MIN_PRICE"];
                $arResult['SKU2_ALL'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['RAZMER'] = $VALUES[0];
            }
        }
        $obCache->set($cacheId, ['SKU2' => $arResult['SKU2'], 'SKU2_ALL' => $arResult['SKU2_ALL']]); // записываем в кеш
    }
    /* ?><script data-skip-moving="true">console.log(<?echo \CUtil::PHPToJSObject($arResult['SKU2'])?>);</script><?
    ?><script data-skip-moving="true">console.log(<?echo \CUtil::PHPToJSObject($arResult['SKU2_ALL'])?>);</script><? */
    if (!empty($arResult['SKU2_ALL'])) {
        foreach ($arResult['SKU2_ALL'] as $xmlcode => $item) {
            $arResult['SKU2_ALL'][$xmlcode] = \Kolchuga\DopViborka::getItemSkuMinMaxPrice($item);
        }
    }
    foreach ($arResult['ITEMS'] as $key => &$arItem) {


        /* $dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID'=>$arParam['IBLOCK_ID'], 'PROPERTY_IDGLAVNOGO' => $arItem['XML_ID'], '>CATALOG_QUANTITY' => 0), false, false, Array());
        if($dbEl->SelectedRowsCount()>0){
            while($obEl = $dbEl->GetNextElement())
            {
                $officeArr = $obEl->GetFields();
                $officeArr['PROPERTIES'] = $obEl->GetProperties([],['CODE'=>'RAZMER']);

                $arResult['SKU2'][$arItem['ID']][$officeArr['ID']]['RAZMER']=$officeArr['PROPERTIES']['RAZMER']['VALUE'][0];
                $arResult['SKU2'][$arItem['ID']][$officeArr['ID']]['QUANTITY']=$officeArr['CATALOG_QUANTITY'];
            }
        }  */

        //if ($USER->GetID()=="11460"){}

        //скидки на товар
        $arResult['ITEMS'][$key]['ARDISCOUNTS'] = \CCatalogDiscount::GetDiscountByProduct(
            $arItem['ID'],
            $USER->GetUserGroupArray(),
            "N",
            2,
            SITE_ID
        );

        // - вывод лейблов новинки и sale по категориям
        $arResult['ITEMS'][$key]['CHECK_NOVINKA'] = false;
        $arResult['ITEMS'][$key]['CHECK_SALE'] = false;
        $arResult['ITEMS'][$key]['CHECK_SPECIAL_PRICE'] = false;

        $objElemGroups = CIBlockElement::GetElementGroups($arItem['ID'], true);
        while ($dataElemGroups = $objElemGroups->Fetch()) {
            //новинки - 18018
            if ($dataElemGroups['ID'] == '18018' || $dataElemGroups['IBLOCK_SECTION_ID'] == '18018') {
                $arResult['ITEMS'][$key]['CHECK_NOVINKA'] = true;
            }
            //sale - 18061
            if ($dataElemGroups['ID'] == '18061' || $dataElemGroups['IBLOCK_SECTION_ID'] == '18061') {
                $arResult['ITEMS'][$key]['CHECK_SALE'] = true;
            }
            //специальная цена - 18096
            if ($dataElemGroups['ID'] == '18096' || $dataElemGroups['IBLOCK_SECTION_ID'] == '18096') {
                $arResult['ITEMS'][$key]['CHECK_SPECIAL_PRICE'] = true;
            }
        }


        foreach (array("PREVIEW_PICTURE", "DETAIL_PICTURE") as $code) {
            if (is_array($arItem[$code])) {
                foreach (array("ALT", "TITLE") as $tr) {
                    if (isset($arItem["IPROPERTY_VALUES"]["ELEMENT_" . $code . "_FILE_" . $tr]) &&
                        !empty($arItem["IPROPERTY_VALUES"]["ELEMENT_" . $code . "_FILE_" . $tr])) {
                        $arItem[$code][$tr] = $arItem["IPROPERTY_VALUES"]["ELEMENT_" . $code . "_FILE_" . $tr];
                    }
                }
            }
        }

        //nah
        if (!empty($arResult['SKU2_ALL'])) {

            //$arResult['SKU2'][$arItem['XML_ID']][$arItem['ID']]['PRICE_MAX']
            //$arResult['SKU2'][$arItem['XML_ID']][$arItem['ID']]['PRICE_MIN']

            if ($arResult['SKU2_ALL'][$arItem['XML_ID']][$arItem['ID']]['PRICE_MAX'] > $arItem['MIN_PRICE']['DISCOUNT_VALUE']) {
                $arItem['MIN_PRICE']['DISCOUNT_VALUE'] = $arResult['SKU2_ALL'][$arItem['XML_ID']][$arItem['ID']]['PRICE_MAX'];
                $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] = number_format($arResult['SKU2_ALL'][$arItem['XML_ID']][$arItem['ID']]['PRICE_MAX'], 0, '.', ' ');
                $arResult['ITEMS'][$key]['MIN_PRICE']['DISCOUNT_VALUE'] = $arResult['SKU2_ALL'][$arItem['XML_ID']][$arItem['ID']]['PRICE_MAX'];
            }
        }
        $arItem['OLD_PRICE'] = 0;
        if (isset($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"])) {
            $arItem['OLD_PRICE'] = $arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"];
            $arResult['ITEMS'][$key]['OLD_PRICE'] = $arItem['OLD_PRICE'];
        } else if ($arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']) {
            $arItem['OLD_PRICE'] = $arItem['MIN_PRICE']['PRINT_VALUE'];
            $arResult['ITEMS'][$key]['OLD_PRICE'] = $arItem['OLD_PRICE'];
        }


        if (!$arItem['PROPERTIES']['RAZMER']['VALUE']) continue;
        foreach ($arItem['PROPERTIES']['RAZMER']['VALUE'] as $v) {
            $size = $v;
            $l = -strlen($size);
            if (substr($arItem['NAME'], $l) == $size) {
                $arResult['ITEMS'][$key]['NAME'] = trim(substr($arItem['NAME'], 0, $l));
                break;
            }
        }
    }
    unset($arItem);
    /*?><!--pre>arItem <?print_r($arResult['SKU2']);?></pre--><?*/
    if (isset($arParams["GSetSectMetaProp"]) &&
        !empty($arParams["GSetSectMetaProp"]) &&
        intval($arResult["NAV_RESULT"]->NavPageNomer) > 1) {
        $arResult[$arParams["GSetSectMetaProp"]] = array("NAME" => $arResult["NAME"],
                                                         "PAGE" => intval($arResult["NAV_RESULT"]->NavPageNomer));

        $this->__component->setResultCacheKeys(array($arParams["GSetSectMetaProp"]));
    }

    $cp = $this->__component; // объект компонента
    if (is_object($cp))
        $cp->SetResultCacheKeys(array('TIMESTAMP_X'));

}

if (!empty($arParams['~ELEMENT_SORT_ORDER']) && is_array($arParams['~ELEMENT_SORT_ORDER'])) {

    $resultArray = [];

    foreach ($arParams['~ELEMENT_SORT_ORDER'] as $amplua) {
        foreach ($arResult['ITEMS'] as $key => $arr) {
            if ($amplua == $arr['ID'])
                $resultArray[] = $arr;
        }
    }

    $arResult['ITEMS'] = $resultArray;
}

?>