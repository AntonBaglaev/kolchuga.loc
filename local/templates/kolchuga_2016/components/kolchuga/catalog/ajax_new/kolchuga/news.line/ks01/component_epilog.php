<?
if (!defined("B_PROLOG_INCLUDED") ||
    B_PROLOG_INCLUDED !== true)
{
  die();
}

  if (isset($arParams["CATALOG_FILTER_NAME"]) &&
      !empty($arParams["CATALOG_FILTER_NAME"]) &&
      is_array($arResult["SET_FILTER"]) &&
      !empty($arResult["SET_FILTER"]))
  {
    if (!isset($GLOBALS[$arParams["CATALOG_FILTER_NAME"]]))
    {
      $GLOBALS[$arParams["CATALOG_FILTER_NAME"]] = array();
    }
    
    $GLOBALS[$arParams["CATALOG_FILTER_NAME"]] = array_merge($GLOBALS[$arParams["CATALOG_FILTER_NAME"]],
                                                             $arResult["SET_FILTER"]);
  }

  if (isset($arParams["GLOBALS_EX_VAR"]) &&
      !empty($arParams["GLOBALS_EX_VAR"]) &&
      !empty($arResult["SEO_DATA"]))
  {
    $GLOBALS[$arParams["GLOBALS_EX_VAR"]] = $arResult["SEO_DATA"];
  }  
?>