<?php

if(!empty($arResult['PROPERTIES']['SALON_GALEREYA']['VALUE'])){
	$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => $arResult['PROPERTIES']['SALON_GALEREYA']['LINK_IBLOCK_ID'], 'SECTION_ID'=>$arResult['PROPERTIES']['SALON_GALEREYA']['VALUE'], ), false, false, Array());
	while($arEl0 = $dbEl->GetNextElement())	
	{
		$arEl=$arEl0->GetFields();
		$arEl['PROPERTIES']['REAL_PICTURE'] = $arEl0->GetProperties(array(), array("CODE" => "REAL_PICTURE"))['REAL_PICTURE']; 
		$arEl['PROPERTIES']['REAL_PICTURE']['BIG_F']= \CFile::GetPath($arEl['PROPERTIES']['REAL_PICTURE']['VALUE']);
		$arEl['PROPERTIES']['REAL_PICTURE']['SMALL_F']=\CFile::ResizeImageGet(   $arEl['PROPERTIES']['REAL_PICTURE']['VALUE'],   ['width' => 280, 'height' => 158],BX_RESIZE_IMAGE_EXACT)['src'];
		//$arEl['PROPERTIES'] = $arEl0->GetProperties(); 
		$arResult['PROPERTIES']['SALON_GALEREYA']['LINK_INFO'][]=$arEl;
	}
}