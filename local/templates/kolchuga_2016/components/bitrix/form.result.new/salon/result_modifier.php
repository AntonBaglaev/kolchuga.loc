<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 29/06/16
 * Time: 10:21
 */
if ($_GET['dev']==1) {
    /*echo "<pre>";
    var_dump($arResult['QUESTIONS']);
    echo "</pre>";*/
}
/*
foreach ($arResult['QUESTIONS'] as $k=>$fld) {
    if ($fld == 'AGREE') unset($arResult['QUESTIONS'][$k]);
//уничтожаем поле input AGREE для замены его кастомным чекбоксом
}



use \Bitrix\Iblock\ElementTable;

if(!isset($_REQUEST['webform_submit'])){

    CModule::IncludeModule("iblock");

    $res = CIBlockElement::GetList(
        array('sort' => 'asc'),
        array('IBLOCK_ID' => 7, 'PROPERTY_show_in_list_VALUE' => 'Да'),
        false,
        false,
        array('ID', 'IBLOCK_ID', 'NAME')
    );

    while($store = $res->Fetch()){
        $arResult['STORE_LIST'][] = $store;
    }

}
*/