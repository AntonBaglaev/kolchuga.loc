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



  //$SetH1 = ((isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && !empty($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]))? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $arResult["NAME"]);
  $SetH1 = $arResult["NAME"];
  
  $APPLICATION->SetPageProperty("h1", $SetH1);  
  //$APPLICATION->SetPageProperty("title", ''.$SetH1.' – купить по низкой цене с доставкой в Москве в каталоге товаров магазина Kolchuga.ru');
  $APPLICATION->SetPageProperty("title", ''.$arResult["~NAME"].' – купить по низкой цене в Москве в каталоге товаров магазина Kolchuga.ru');
  //$APPLICATION->SetPageProperty("description", ''.$SetH1.'. '.($arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]?$arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]:$arResult["SECTION"]["NAME"]) .' и другие товары для охоты и активного отдыха в салонах Кольчуга.');
  $APPLICATION->SetPageProperty("description", ''.$arResult["SECTION"]["NAME"].' по низкой цене в Москве, выбрать '.$arResult["~NAME"].' вы можете в интернет-магазине Кольчуга');


  if (!empty($arResult["CANONICAL_URL"]))
  {
    $serverHost = 'http://'.$_SERVER["HTTP_HOST"];
    if($_SERVER['HTTPS'] == 'on'){
        $serverHost = 'https://'.$_SERVER["HTTP_HOST"];

    }
    $APPLICATION->AddHeadString('<link rel="canonical" href="'.$serverHost.$arResult["CANONICAL_URL"].'" />');
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
    "ELEMENT_ID" => $arResult["ID"],
), false, array("HIDE_ICONS" => "Y"));
?>

<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "psert", Array(
    "SEF_MODE" => "N",
    "WEB_FORM_ID" => 6,
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
    "ELEMENT_ID" => $arResult["ID"],
	"AJAX_MODE" => "Y"
), false, array("HIDE_ICONS" => "Y"));
?>

<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "uncertainty", array(
	"SEF_MODE" => "N",
		"WEB_FORM_ID" => "3",
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
		"VARIABLE_ALIASES" => "",
		"ELEMENT_ID" => $arResult["ID"],
		"AJAX_MODE" => "Y"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);


GLOBAL $lastModified;
if (!$lastModified)
   $lastModified = MakeTimeStamp($arResult['TIMESTAMP_X']);
else
   $lastModified = max($lastModified, MakeTimeStamp($arResult['TIMESTAMP_X']));
?>