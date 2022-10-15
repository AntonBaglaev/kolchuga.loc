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
CModule::IncludeModule('catalog');
$res = \CIBlockPriceTools::GetCatalogPrices($arResult['ITEMS'][0]['IBLOCK_ID'], array('Розничная', ));
foreach($arResult['ITEMS'] as $key=>$arItem){
	if(empty($arItem['MIN_PRICE'])){
		/*$arEl["PRICES"] = array();
		$arEl['MIN_PRICE'] = false;	
		$res = \CIBlockPriceTools::GetCatalogPrices($arItem['IBLOCK_ID'], array('Розничная', ));		
		$arEl["PRICES"] = \CIBlockPriceTools::GetItemPrices($arItem['IBLOCK_ID'], $res, $arItem);
		if (!empty($arEl['PRICES']))
			$arEl['MIN_PRICE'] = \CIBlockPriceTools::getMinPriceFromList($arEl['PRICES']);
		
		$arResult['ITEMS'][$key]['MIN_PRICE']=$arEl['MIN_PRICE'];*/
		
		$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => $arItem['IBLOCK_ID'], 'ID'=>$arItem['ID'], ), false, false, Array('ID','CATALOG_TYPE','DETAIL_PICTURE','PROPERTY_OLD_PRICE','CATALOG_GROUP_2'));
		while($arEl = $dbEl->Fetch())	
		{				
			
			$arEl["PRICES"] = array();
			$arEl['MIN_PRICE'] = false;		
			$arEl["PRICES"] = \CIBlockPriceTools::GetItemPrices($arItem['IBLOCK_ID'], $res, $arEl);
			if (!empty($arEl['PRICES'])){
				$arEl['MIN_PRICE'] = \CIBlockPriceTools::getMinPriceFromList($arEl['PRICES']);	
			}				
			
		/*?><!--pre><?print_r($arEl);?></pre--><?*/
			$arResult['ITEMS'][$key]['PRICES']=$arEl['PRICES'];
			$arResult['ITEMS'][$key]['MIN_PRICE']=$arEl['MIN_PRICE'];
		}
	}
}

/*?><!--pre><?print_r($arResult['ITEMS'][0]['PRICES']);?></pre--><?
?><!--pre><?print_r($arResult['ITEMS'][0]['MIN_PRICE']);?></pre--><?*/

if (!empty($arParams['PORYADOK'])) {
		
		$poryadok=array();
		$keyaaray=array_flip($arParams['PORYADOK']);
		
		foreach($arResult['ITEMS'] as $key=>$val){
			$poryadok[$keyaaray[$val['ID']]]=$val;
		}
		ksort($poryadok);		
		$arResult['ITEMS']=$poryadok;
	}