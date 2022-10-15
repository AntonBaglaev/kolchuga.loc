<?php
  if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 26.12.15
 * Time: 17:40
 */

foreach($arResult['ITEMS'] as $key => &$arItem){
  
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