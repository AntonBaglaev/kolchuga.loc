<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 26.12.15
 * Time: 17:40
 */

foreach($arResult['ITEMS'] as $key => $arItem){
    if(!$arItem['PROPERTIES']['RAZMER']['VALUE']) continue;
    foreach($arItem['PROPERTIES']['RAZMER']['VALUE'] as $v){
	    $size = $v;
	    $l = -strlen($size);
	    if(substr($arItem['NAME'], $l) == $size){
	        $arResult['ITEMS'][$key]['NAME'] = trim(substr($arItem['NAME'], 0, $l));
			break;
	    }
	}    
}