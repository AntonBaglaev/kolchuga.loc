<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult['ITEMS'] as $key => $arItem){
	$picture = $arItem['DETAIL_PICTURE'] ? $arItem['DETAIL_PICTURE'] : $arItem['PREVIEW_PICTURE'];
	if(!$picture) continue;
	$resized = \CFile::ResizeImageGet($picture, array('width' => 120, 'height' => 120), 'BX_RESIZE_IMAGE_PROPORTIONAL');
	$arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC'] = $resized['src'];
}

   

$obCache = \Bitrix\Main\Application::getInstance()->getManagedCache();
$res = \CIBlockPriceTools::GetCatalogPrices($arResult['ITEMS'][0]['IBLOCK_ID'], array('Розничная', ));

foreach($arResult['ITEMS'] as $key=>$arItem){
	if(empty($arItem['MIN_PRICE'])){
		$cacheTtl = 3600 * 24; 
		$cacheId = 'carousel_'.$arItem['ID'];
		$cachePath = 'fromcarousel_cache';
		if ($obCache->read($cacheTtl, $cacheId, $cachePath)) {
			$vars = $obCache->get($cacheId); // достаем переменные из кеша
		} else {
			// некоторые действия...
			
			
			$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => $arItem['IBLOCK_ID'], 'ID'=>$arItem['ID'], ), false, false, Array('ID','CATALOG_TYPE','DETAIL_PICTURE','PROPERTY_OLD_PRICE','CATALOG_GROUP_2'));
			while($arEl = $dbEl->Fetch())	
			{				
				
				$arEl["PRICES"] = array();
				$arEl['MIN_PRICE'] = false;		
				$arEl["PRICES"] = \CIBlockPriceTools::GetItemPrices($arItem['IBLOCK_ID'], $res, $arEl);
				if (!empty($arEl['PRICES'])){
					$arEl['MIN_PRICE'] = \CIBlockPriceTools::getMinPriceFromList($arEl['PRICES']);	
				}				
				
				$vars['PRICES']=$arEl['PRICES'];
				$vars['MIN_PRICE']=$arEl['MIN_PRICE'];
			}
			$obCache->set($cacheId, $vars); // записываем в кеш
		}
		$arResult['ITEMS'][$key]['PRICES']=$vars['PRICES'];
		$arResult['ITEMS'][$key]['MIN_PRICE']=$vars['MIN_PRICE'];		
	}
}
/*
CModule::IncludeModule('catalog');
$res = \CIBlockPriceTools::GetCatalogPrices($arResult['ITEMS'][0]['IBLOCK_ID'], array('Розничная', ));
foreach($arResult['ITEMS'] as $key=>$arItem){
	if(empty($arItem['MIN_PRICE'])){
		
		$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => $arItem['IBLOCK_ID'], 'ID'=>$arItem['ID'], ), false, false, Array('ID','CATALOG_TYPE','DETAIL_PICTURE','PROPERTY_OLD_PRICE','CATALOG_GROUP_2'));
		while($arEl = $dbEl->Fetch())	
		{				
			
			$arEl["PRICES"] = array();
			$arEl['MIN_PRICE'] = false;		
			$arEl["PRICES"] = \CIBlockPriceTools::GetItemPrices($arItem['IBLOCK_ID'], $res, $arEl);
			if (!empty($arEl['PRICES'])){
				$arEl['MIN_PRICE'] = \CIBlockPriceTools::getMinPriceFromList($arEl['PRICES']);	
			}				

			$arResult['ITEMS'][$key]['PRICES']=$arEl['PRICES'];
			$arResult['ITEMS'][$key]['MIN_PRICE']=$arEl['MIN_PRICE'];
		}
	}
}*/

/*?><!--pre><?print_r($arResult['ITEMS'][0]['PRICES']);?></pre--><?
?><!--pre><?print_r($arResult['ITEMS'][0]['MIN_PRICE']);?></pre--><?*/