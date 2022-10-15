<?php
  if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 26.12.15
 * Time: 17:40
 */

foreach($arResult['ITEMS'] as $key => &$arItem){


    //nah - вывод лейблов новинки и sale по категориям
    $arResult['ITEMS'][$key]['CHECK_NOVINKA'] = false;
    $arResult['ITEMS'][$key]['CHECK_SALE'] = false;

    $objElemGroups = CIBlockElement::GetElementGroups($arItem['ID'], true);
    while($dataElemGroups = $objElemGroups->Fetch()){
      //новинки - 18018
      if($dataElemGroups['ID'] == '18018' || $dataElemGroups['IBLOCK_SECTION_ID'] == '18018'){
        $arResult['ITEMS'][$key]['CHECK_NOVINKA'] = true;
      }
      //sale - 18061
      if($dataElemGroups['ID'] == '18061' || $dataElemGroups['IBLOCK_SECTION_ID'] == '18061'){
        $arResult['ITEMS'][$key]['CHECK_SALE'] = true;
      }
    }

  
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

$cp = $this->__component; // объект компонента
if (is_object($cp))
   $cp->SetResultCacheKeys(array('TIMESTAMP_X'));
?>