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
 	$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID'=>40, 'PROPERTY_IDGLAVNOGO' => $arXmlIDGl, '>CATALOG_QUANTITY' => 0), false, false, Array('ID','CATALOG_QUANTITY','PROPERTY_IDGLAVNOGO'));
	while($obEl = $dbEl->Fetch()){
		$arResult['SKU2'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['QUANTITY']=$obEl['CATALOG_QUANTITY'];
		$VALUES = array();
		$res = \CIBlockElement::GetProperty(40, $obEl['ID'], Array("sort"=>"asc"), array("CODE" => "RAZMER"));
		while ($ob = $res->GetNext()){			
			$VALUES[] = $ob['VALUE'];
		}		
		$arResult['SKU2'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['RAZMER']=$VALUES[0];
	}
	//\Kolchuga\Settings::xmp($arResult['SKU2'],11460, __FILE__.": ".__LINE__);
foreach($arResult['ITEMS'] as $key => &$arItem){
	if(empty($arItem['DETAIL_PICTURE']['ID']) && empty($arItem['PREVIEW_PICTURE']) && $arParams['FILTER_NAME'] == 'brandfilter'){unset($arResult['ITEMS'][$key]);continue;}
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

if (isset($arParams["GSetSectMetaProp"]) &&
    !empty($arParams["GSetSectMetaProp"]) &&
    intval($arResult["NAV_RESULT"]->NavPageNomer) > 1)
{
  $arResult[$arParams["GSetSectMetaProp"]] = array("NAME" => $arResult["NAME"],
                                                   "PAGE" => intval($arResult["NAV_RESULT"]->NavPageNomer));
  
  $this->__component->setResultCacheKeys(array($arParams["GSetSectMetaProp"]));
}
?>