<?php
  if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }

  if (isset($arParams["SET_GLOBAL_SECTION_ID"]) &&
      !empty($arParams["SET_GLOBAL_SECTION_ID"]))
  {
    $GLOBALS[$arParams["SET_GLOBAL_SECTION_ID"]] = array();
    if (intval($arResult["IBLOCK_SECTION_ID"]) > 0)
    {
      $GLOBALS[$arParams["SET_GLOBAL_SECTION_ID"]]["SECTION_ID"] = intval($arResult["IBLOCK_SECTION_ID"]);
    }
    
    if (!empty($arResult["PROP_SIZES_VALUE"]))
    {
      $GLOBALS[$arParams["SET_GLOBAL_SECTION_ID"]]["PROPERTY_RAZMER"] = $arResult["PROP_SIZES_VALUE"];
    }
   
  }


  $SetH1 = ((isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) &&
             !empty($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]))? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $arResult["NAME"]);
  
  $APPLICATION->SetPageProperty("h1", $SetH1);

  if (!empty($arResult["CANONICAL_URL"]))
  {
    $APPLICATION->AddHeadString('<link rel="canonical" href="http://'.$_SERVER["HTTP_HOST"].$arResult["CANONICAL_URL"].'" />');
  }
?>
<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "preorder", Array(
    "SEF_MODE" => "N",
    "WEB_FORM_ID" => 1,
    "LIST_URL" => "",
    "EDIT_URL" => "",
    "SUCCESS_URL" => "",
    "CHAIN_ITEM_TEXT" => "",
    "CHAIN_ITEM_LINK" => "",
    "IGNORE_CUSTOM_TEMPLATE" => "Y",
    "USE_EXTENDED_ERRORS" => "Y",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "3600",
    "SEF_FOLDER" => "/",
    "VARIABLE_ALIASES" => Array(),
    "ELEMENT_ID" => $arResult["ID"]
));
?>