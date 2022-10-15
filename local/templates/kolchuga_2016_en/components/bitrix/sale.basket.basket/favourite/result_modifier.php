<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 17.12.15
 * Time: 15:39
 */

$arResult['HAS_NOT_AVAILABLE'] = false;
foreach ($arResult['ITEMS']['AnDelCanBuy'] as $key => $arItem){
    if($arItem['AVAILABLE_QUANTITY'] < 1 && $arItem['PROPERTY_POD_ZAKAZ_VALUE'] !== 'Да'){

//        if (CSaleBasket::Delete($arItem['ID'])) {
//            $arResult['HAS_NOT_AVAILABLE'] = true;
//        }
//
//        unset($arResult['ITEMS']['AnDelCanBuy'][$key]);

        if($arItem['PROPERTY_POD_ZAKAZ_VALUE'] == 'Да')
            $arResult['ITEMS']['AnDelCanBuy'][$key]['AVAILABLE_QUANTITY'] = 1000;

    }
}

