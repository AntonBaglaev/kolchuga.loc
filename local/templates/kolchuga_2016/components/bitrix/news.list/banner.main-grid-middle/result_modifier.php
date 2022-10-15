<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 08/10/15
 * Time: 16:23
 */

$arResult['MIDDLE_BANNERS'] = array();
foreach($arResult['ITEMS'] as $key => $arItem){
    if($key > 3 && $key < 6){
        $file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>645, 'height'=>330), BX_RESIZE_IMAGE_EXACT, true);
        $arItem['IMG_RESIZE_SRC'] = $file['src'];
        $arItem['PROPERTIES']['DESC']['VALUE'] = TruncateText($arItem['PROPERTIES']['DESC']['VALUE'], 170);
        //var_dump($arItem);
        $arResult['MIDDLE_BANNERS'][] = $arItem;
    }
}