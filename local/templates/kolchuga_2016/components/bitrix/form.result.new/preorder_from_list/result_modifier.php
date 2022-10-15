<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 29/06/16
 * Time: 10:21
 */

foreach ($arResult['QUESTIONS'] as $k=>$fld) {
    if ($fld == 'AGREE') unset($arResult['QUESTIONS'][$k]);
	if ($fld == 'AGE') unset($arResult['QUESTIONS'][$k]);
//уничтожаем поле input AGREE для замены его кастомным чекбоксом
}

use \Bitrix\Iblock\ElementTable;

if(!isset($_REQUEST['webform_submit'])){

    CModule::IncludeModule("iblock");

    /*$res = CIBlockElement::GetList(
        array('sort' => 'asc'),
        array('IBLOCK_ID' => 7, 'PROPERTY_show_in_list_VALUE' => 'Да'),
        false,
        false,
        array('ID', 'IBLOCK_ID', 'NAME')
    );

    while($store = $res->Fetch()){
        $arResult['STORE_LIST'][] = $store;
    }*/

    


        $arResult['STORE_LIST'] = array();
        //filials
        $f_res = CIBlockElement::GetList(
            array('SORT' => 'ASC'),
            array('IBLOCK_ID' => 7, ),
            false,
            false,
            array('ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL', 'PROPERTY_show_in_list')
        );

        while($ob = $f_res->GetNextElement()){

            $filial = $ob->GetFields();

            $store_list = $ob->GetProperties(array(), array('CODE' => 'stores'));
            $store_list = $store_list['stores']['VALUE'];

            if(!$store_list) continue;


            $res = CCatalogStore::GetList(array(), array('XML_ID' => $store_list), false, false, array('ID', 'XML_ID'));
            $store_ids = array();
            while($store = $res->fetch()){
                $store_ids[] = $store['ID'];
            }

            $filter = array(
                "ACTIVE" => "Y",
                "+SITE_ID" => SITE_ID,
                'STORE_ID' => $store_ids,
                'PRODUCT_ID' => $arParams["ELEMENT_ID"],
            );


            $storeIterator = CCatalogStoreProduct::GetList(array(), $filter, false, false, array('*'));
            while ($store = $storeIterator->Fetch()) {

                $arResult['STORE_LIST'][$filial['ID']] =
                    array('NAME' => $filial['NAME'], 'AMOUNT' => $store['AMOUNT'], 'SHOW_IN_LIST_ID'=>$filial['PROPERTY_SHOW_IN_LIST_ENUM_ID'], 'SHOW_IN_LIST_VALUE'=>$filial['PROPERTY_SHOW_IN_LIST_VALUE']);

                if($store['AMOUNT'] > 0)
                    break;
            }


        }








}