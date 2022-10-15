<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 17.12.15
 * Time: 15:39
 */

$arResult['HAS_NOT_AVAILABLE'] = false;
foreach ($arResult['ITEMS']['AnDelCanBuy'] as $key => $arItem){
    if((int)$arItem['DETAIL_PICTURE'] > 0){
        $arResult['ITEMS']['AnDelCanBuy'][$key]['PREVIEW_PICTURE_SRC'] =
            CFile::ResizeImageGet(
                $arItem['DETAIL_PICTURE'],
                array('width' => 75, 'height' => 75),
                BX_RESIZE_IMAGE_PROPORTIONAL
            )['src'];
    }
}

//Items phrase prepare
$cnt = count($arResult['ITEMS']['AnDelCanBuy']);
$last_num = substr($cnt, -1);
$lastnum2 = substr($cnt, -2);

if (($lastnum2 >= 10) && ($lastnum2 <= 20))
    $all_title = GetMessage('SALE_TITLE_STEP_1') .' '. $cnt.' '.GetMessage('SALE_COUNT_5');
elseif ($last_num == 0 || $last_num > 4)
    $all_title = GetMessage('SALE_TITLE_STEP_1') .' '. $cnt.' '.GetMessage('SALE_COUNT_5');
elseif ($last_num == 1 && $this->arResult['INFO']['CNT'] !== 11)
    $all_title = GetMessage('SALE_TITLE_STEP_1') .' '. $cnt.' '.GetMessage('SALE_COUNT_1');
else
    $all_title = GetMessage('SALE_TITLE_STEP_1') .' '. $cnt.' '.GetMessage('SALE_COUNT_2');

$arResult['COUNT_PHRASE'] = $all_title;