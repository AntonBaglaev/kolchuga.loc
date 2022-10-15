<?php
  if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }
\CModule::IncludeModule('catalog');
  $it0=$$arResult["ITEMS"][0]['DISPLAY_PROPERTIES']['TOVAR'];
  
  $res = \CIBlockPriceTools::GetCatalogPrices($it0['LINK_ELEMENT_VALUE'][$it0['VALUE']]['IBLOCK_ID'], array('Розничная', ));
  $massa=[];
  foreach($arResult["ITEMS"] as $key => $arItem){
	
  
  
  $dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => $it0['LINK_ELEMENT_VALUE'][$it0['VALUE']]['IBLOCK_ID'], 'ID'=>$arItem['DISPLAY_PROPERTIES']['TOVAR']['VALUE'], ), false, false, Array('IBLOCK_ID','ID','CATALOG_TYPE','DETAIL_PICTURE','PROPERTY_FOTO_BERETTA','PROPERTY_TEXT_BERETTA','PROPERTY_OLD_PRICE','CATALOG_GROUP_2'));
	while($arEl = $dbEl->Fetch())	
	{
		$arEl["PRICES"] = array();
		$arEl["PRICE_MATRIX"] = false;
		$arEl['MIN_PRICE'] = false;		
		$arEl["PRICES"] = \CIBlockPriceTools::GetItemPrices($arEl['IBLOCK_ID'], $res, $arEl);
		if (!empty($arEl['PRICES']))
			$arEl['MIN_PRICE'] = \CIBlockPriceTools::getMinPriceFromList($arEl['PRICES']);
		
		
		$arResult["ITEMS"][$key]['DISPLAY_PROPERTIES']['TOVAR']['LINK_ELEMENT_VALUE'][$arEl['ID']]['CENS']=$arEl;
	}
 }
 /*?><!--pre>ber <?print_r($arResult["ITEMS"][0]);?></pre--><?*/
?>