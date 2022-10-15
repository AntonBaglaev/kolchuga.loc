<?php

$arFilter = array(
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"ACTIVE" => "Y",
);

if($arParams["CHECK_DATES"] != "N")
	$arFilter["ACTIVE_DATE"] = "Y";

$arOrder = array(
	$arParams["SORT_BY"] => $arParams["SORT_ORDER"]
);


// Get description iblock
if($arParams["IBLOCK_DESCRIPTION"] === "Y")
	$arResult["DESCRIPTION"] = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "DESCRIPTION");

/*
$arSelect = array("IBLOCK_ID");

if(array_key_exists("ELEMENT_FIELDS", $arParams) && !empty($arParams["ELEMENT_FIELDS"]) && is_array($arParams["ELEMENT_FIELDS"]))
{
	foreach($arParams["ELEMENT_FIELDS"] as $field)
	{
		if (!empty($field) && is_string($field))
			$arSelect[] = $field;
	}
}

if(array_key_exists("ELEMENT_PROPERTY", $arParams) && !empty($arParams["ELEMENT_PROPERTY"]) && is_array($arParams["ELEMENT_PROPERTY"]))
{
	foreach($arParams["ELEMENT_PROPERTY"] as $property)
	{
		if (!empty($property))
			$arSelect[] = "PROPERTY_".$property;
	}
}
*/

foreach($arResult["SECTIONS"] as $sectionKey => $section)
{
	$arFilter = array_merge($arFilter, array("SECTION_ID" => $section["ID"]));
	
	$arElement = CIBlockElement::GetList($arOrder, $arFilter, false, false);
	for($elementKey = 0; $obElement  = $arElement->GetNextElement(false, false); $elementKey++)
	{
		$arItem = $obElement->GetFields();
		$arItem["PROPERTIES"] = $obElement->GetProperties();
		
		//if(in_array("PREVIEW_PICTURE", $arSelect))
			//$arItem["PREVIEW_PICTURE"] = CFile::GetPath($arItem["PREVIEW_PICTURE"]);
		
		$arButtons = CIBlock::GetPanelButtons(
			$section["IBLOCK_ID"],
			$arItem["ID"],
			$section["ID"],
			array()
		);

		$arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
		$arItem["DELETE_LINK"] = $arButtons["edit"]["add_element"]["ACTION_URL"];

		$arResult["SECTIONS"][$sectionKey]["ELEMENTS"][$elementKey] = $arItem;
	}
}