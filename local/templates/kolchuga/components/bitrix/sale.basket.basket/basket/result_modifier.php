<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 27.12.15
 * Time: 19:35
 */

$ids = array();
foreach($arResult['ITEMS']['AnDelCanBuy'] as $arItem){
    $ids[] = $arItem['PRODUCT_ID'];
}

if(count($ids) > 0) {
    $res = CIBlockElement::GetList(
        array(),
        array('ID' => $ids),
        false,
        false,
        array('ID', 'IBLOCK_ID', 'XML_ID', 'DETAIL_PICTURE', 'PROPERTY_IDGLAVNOGO')
    );

    while($item = $res->GetNext()){
        if($item['DETAIL_PICTURE'])
            $arResult['PICTURES'][$item['ID']] = thumbnail($item["DETAIL_PICTURE"], 90, 90, false, TRUE);
        elseif(strlen($item['PROPERTY_IDGLAVNOGO_VALUE']) > 0){
            $res_main = CIBlockElement::GetList(
                array(),
                array('XML_ID' => $item['PROPERTY_IDGLAVNOGO_VALUE'], '>DETAIL_PICTURE' => 0),
                false,
                false,
                array('ID', 'IBLOCK_ID', 'DETAIL_PICTURE')
            );

            if($main_item = $res_main->GetNext()){
                $arResult['PICTURES'][$item['ID']] = thumbnail($main_item["DETAIL_PICTURE"], 90, 90, false, TRUE);
            }
        }
    }
}