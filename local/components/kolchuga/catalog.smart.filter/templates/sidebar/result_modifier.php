<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult['PRICE_ITEMS'] = array();

function SortSmartFilter($a, $b){
	return strcmp($a["VALUE"], $b["VALUE"]);
}

function SortSmartFilterSize($a, $b){
	return intval($a['VALUE']) - intval($b['VALUE']);
}

$sizes_sort = array('XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'XXXXL', 'XXXXXL');

foreach($arResult['ITEMS'] as $key => $arItem){
	
	if($arItem['PRICE']) continue;
	
	//Size
	if($arItem['CODE'] == 'RAZMER'){
		usort($arItem['VALUES'], 'SortSmartFilterSize');
		
		$size_values = array();
		foreach($arItem['VALUES'] as $i => $v){
			$pos = array_search($v['VALUE'], $sizes_sort);
			if($pos === FALSE) continue;
			
			$size_values[$pos] = $v;
			unset($arItem['VALUES'][$i]); 
		}
		
		ksort($size_values);
		
		$arItem['VALUES'] = array_merge($arItem['VALUES'], $size_values);
		
		$arResult['ITEMS'][$key]['VALUES'] = $arItem['VALUES'];
		continue;
	}
	
	usort($arItem['VALUES'], 'SortSmartFilter');
	$arResult['ITEMS'][$key]['VALUES'] = $arItem['VALUES'];	
}



foreach($arResult['ITEMS'] as $key => $arItem){
	//var_dump($arItem);
	if($arItem['PRICE']){
		$arResult['PRICE_ITEMS'][$key] = $arItem;
		unset($arResult['ITEMS'][$key]);
	}
	elseif($arItem['CODE'] == 'BRAND'){
		$arResult['BRAND_ITEM'] = $arItem;
		unset($arResult['ITEMS'][$key]);
	}
	else
		continue;
}
$arResult['ITEMS'] = array_chunk($arResult['ITEMS'], 2);
//echo '<script>console.log('.json_encode($arResult).')</script>';