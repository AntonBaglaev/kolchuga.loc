<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!empty($arResult["PROPERTIES"]["REVIEWS"]["VALUE"]))
{
	$arFilter = array(
		"ID" => $arResult["PROPERTIES"]["REVIEWS"]["VALUE"],
		"IBLOCK_ID" => $arResult["PROPERTIES"]["REVIEWS"]["LINK_IBLOCK_ID"],
	);
	
	$arSelect = array(
		"ID",
		"IBLOCK_ID",
		"ACTIVE_FROM",
		"NAME",
		"PREVIEW_PICTURE",
		"PREVIEW_TEXT",
		"PROPERTY_*",
	);
	
	$arElement = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	while($rsElement = $arElement->GetNextElement())
	{
		$arItem = $rsElement->GetFields();
		$arItem["PROPERTIES"] = $rsElement->GetProperties();
		
		$arItem["PREVIEW_PICTURE"] = CFile::GetPath($arItem["PREVIEW_PICTURE"]);
		if(strlen($arItem["ACTIVE_FROM"]) > 0)
			$arItem["ACTIVE_FROM"] = CIBlockFormatProperties::DateFormat("j M Y", MakeTimeStamp($arItem["ACTIVE_FROM"], CSite::GetDateFormat()));

		$arResult["REVIEWS"] = $arItem;
		
		$result = CIBlockElement::GetByID($arResult["REVIEWS"]["PROPERTIES"]["SERVICE"]["VALUE"]);
		if($element = $result->GetNext())
		{
			$arResult["REVIEWS"]["PROPERTIES_NAME"] = $element["NAME"];
		}
	}
}