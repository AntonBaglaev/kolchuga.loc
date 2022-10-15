<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult['ITEMS'] as $key => $arItem){
	$picture = $arItem['DETAIL_PICTURE'] ? $arItem['DETAIL_PICTURE'] : $arItem['PREVIEW_PICTURE'];
	if(!$picture) continue;
	$resized = CFile::ResizeImageGet($picture, array('width' => 120, 'height' => 120), 'BX_RESIZE_IMAGE_PROPORTIONAL');
	$arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC'] = $resized['src'];
}
/*
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$i = 0;
foreach($arResult['ITEMS'] as $key => $arItem){
	if(!$arItem['DETAIL_PICTURE']['SRC']) continue;
	$i++;
	$resized = CFile::ResizeImageGet($arItem['DETAIL_PICTURE']['ID'], array('width' => 120, 'height' => 120), 'BX_RESIZE_IMAGE_PROPORTIONAL');
	$arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC'] = $resized['src'];
}
var_dump($i);
*/