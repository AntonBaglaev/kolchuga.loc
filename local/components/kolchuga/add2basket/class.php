<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

Loader::includeModule("catalog");
Loader::includeModule("sale");

class CAddBasket extends CBitrixComponent
{

    public function executeComponent()
    {

        if ($this->StartResultCache()) {

            $arParams = $this->arParams;

            if (!$arParams['PRODUCT_ID']) {
                $this->abortResultCache();
                return false;
            }

            if (!$arParams['POPUP_REQUIRED'])
                $arParams['POPUP_REQUIRED'] = 'N';

            $arItems = [];

            $arSelect = array("ID", "IBLOCK_ID", "NAME", 'CATALOG_GROUP_2', 'XML_ID');

            $arFilter = array("IBLOCK_ID" => 40, "ID" => IntVal($arParams['PRODUCT_ID']));
            $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1), $arSelect);
            if ($ob = $res->GetNextElement()) {
                $arFieldsMain = $ob->GetFields();
                $arPropsMain = $ob->GetProperties();

                $arItems[$arFieldsMain['ID']] = $arFieldsMain;
                $arItems[$arFieldsMain['ID']]['RAZMER_CURRENT'] = current($arPropsMain['RAZMER']['VALUE']);
                $arItems[$arFieldsMain['ID']]['QUANTITY'] = $arFieldsMain['CATALOG_QUANTITY'];
                $arItems[$arFieldsMain['ID']]['CAN_BUY'] = $arFieldsMain['CATALOG_CAN_BUY_2'];


                $arItems[$arFieldsNext['ID']]['QUANTITY'] = $arFieldsNext['CATALOG_QUANTITY'];
                $arItems[$arFieldsNext['ID']]['CAN_BUY'] = $arFieldsNext['CATALOG_CAN_BUY_2'];
            }

            if ($arFieldsMain['XML_ID']) {

                $arSelectNext = array(
                    'ID',
                    'IBLOCK_ID',
                    'NAME',
                    'CATALOG_GROUP_2'
                );

                $resNext1 = CIBlockElement::GetList(
                    array('sort' => 'asc'),
                    array("IBLOCK_ID" => 40, "PROPERTY_IDGLAVNOGO" => $arFieldsMain['XML_ID']),
                    false,
                    false,
                    $arSelectNext);
                while ($obNext = $resNext1->GetNextElement()) {
                    $arFieldsNext = $obNext->GetFields();

                    $arPropsNext = $obNext->GetProperties();

                    $arItems[$arFieldsNext['ID']] = $arFieldsNext;
                    $arItems[$arFieldsNext['ID']]['RAZMER_CURRENT'] = current($arPropsNext['RAZMER']['VALUE']);
                    $arItems[$arFieldsNext['ID']]['QUANTITY'] = $arFieldsNext['CATALOG_QUANTITY'];
                    $arItems[$arFieldsNext['ID']]['CAN_BUY'] = $arFieldsNext['CATALOG_CAN_BUY_2'];
                }
            }

            $sizes_sort = array('XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'XXXXL', 'XXXXXL');

            usort($arItems, function ($a, $b) {
                return strcmp($a['RAZMER_CURRENT'], $b['RAZMER_CURRENT']);
            });


            $this->arResult['ITEMS'] = $arItems;


            $this->endResultCache();
        }

        $this->IncludeComponentTemplate();
    }

}