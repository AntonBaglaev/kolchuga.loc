<?php
  if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 26.12.15
 * Time: 17:40
 */
	$arResult['SKU2']=[];	
	$arXmlIDGl=[];
	foreach($arResult['ITEMS'] as $key => $arItem){
		$arXmlIDGl[$arItem['ID']]=$arItem['XML_ID'];
	}
 	
	$arResult['SKU2'] = \Kolchuga\DopViborka::getItemRazmerSku($arXmlIDGl);		
	
foreach($arResult['ITEMS'] as $key => &$arItem){
	if(empty($arItem['DETAIL_PICTURE']['ID']) && empty($arItem['PREVIEW_PICTURE']) && $arParams['FILTER_NAME'] == 'brandfilter'){
		//unset($arResult['ITEMS'][$key]);continue;
		$arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC']='/images/no_photo_kolchuga.jpg';
	}else{
		foreach(array("PREVIEW_PICTURE", "DETAIL_PICTURE") as $code)
		{
		  if (is_array($arItem[$code]))
		  {
			foreach(array("ALT", "TITLE") as $tr)
			{
			  if (isset($arItem["IPROPERTY_VALUES"]["ELEMENT_".$code."_FILE_".$tr]) &&
				  !empty($arItem["IPROPERTY_VALUES"]["ELEMENT_".$code."_FILE_".$tr]))
			  {
				 $arItem[$code][$tr] = $arItem["IPROPERTY_VALUES"]["ELEMENT_".$code."_FILE_".$tr];
			  }
			}
		  }
		}
	}
  
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
unset($arItem);

	foreach($arResult['ITEMS'] as $key => $arItem){
		$arItem['OLD_PRICE'] = 0;
		if (isset($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"])){
			$arItem['OLD_PRICE'] = $arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"];	  
		} else if($arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']){
			$arItem['OLD_PRICE'] = $arItem['MIN_PRICE']['PRINT_VALUE'];	
		}else if($arItem['ITEM_PRICES'][0]['PRICE'] > 0 && $arItem['ITEM_PRICES'][0]['DISCOUNT']>0){
			$arItem['OLD_PRICE'] = $arItem['ITEM_PRICES'][0]['PRINT_BASE_PRICE'];
		}
		$arResult['ITEMS'][$key]['OLD_PRICE']=$arItem['OLD_PRICE'];
		
	}
if (isset($arParams["GSetSectMetaProp"]) &&
    !empty($arParams["GSetSectMetaProp"]) &&
    intval($arResult["NAV_RESULT"]->NavPageNomer) > 1)
{
  $arResult[$arParams["GSetSectMetaProp"]] = array("NAME" => $arResult["NAME"],
                                                   "PAGE" => intval($arResult["NAV_RESULT"]->NavPageNomer));
  
  $this->__component->setResultCacheKeys(array($arParams["GSetSectMetaProp"]));
}

// Название раздела бренда

$arBrandFilter["IBLOCK_ID"] = 40; // Основной каталог товаров
$arBrandFilter["IBLOCK_TYPE"] = '1c_catalog';
$arBrandFilter["ACTIVE"] = 'Y';
$arBrandFilter["!PROPERTY_253"] = '298882';
$arBrandFilter[">CATALOG_PRICE_2"] = '0';
$arBrandFilter['!DETAIL_PICTURE'] = false;
$arBrandFilter[] = array(
    'LOGIC'                  => 'OR',
    '>CATALOG_QUANTITY'      => 0,
    '>PROPERTY_SKU_QUANTITY' => 0
);

$dbEl = \CIBlockElement::GetList([], $arBrandFilter, false, false, array('ID', 'IBLOCK_SECTION_ID', 'PROPERTY_BRAND_SECTION'));
$arRazdel = [];
$arSectionBrands = [];

while ($obEl = $dbEl->Fetch()) {
    $arRazdel[$obEl['IBLOCK_SECTION_ID']]['ID'][] = $obEl['ID'];
    $arBrandParams = array("replace_space" => "_", "replace_other" => "_");
    $zn = \Cutil::translit($obEl['PROPERTY_BRAND_SECTION_VALUE'], "ru", $arBrandParams);
    $arSectionBrands[mb_strtolower($zn)] = $obEl['PROPERTY_BRAND_SECTION_VALUE'];
}

foreach ($arRazdel as $SectionID => $el) {
    $navChain = \CIBlockSection::GetNavChain(40, $SectionID);
    while ($arNav = $navChain->GetNext()) {
        $arSectionBrands[$arNav['ID']] = $arNav['NAME'];
    }
}

$arResult['AR_SECTION_BRANDS'] = $arSectionBrands;
