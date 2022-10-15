<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!empty($arResult["PROPERTIES"]["PRICE"]["VALUE"]))
{
	$arFilter = array(
		"IBLOCK_ID" => $arResult["PROPERTIES"]["PRICE"]["LINK_IBLOCK_ID"],
		"GLOBAL_ACTIVE" => "Y",
		"ACTIVE" => "Y",
		"SECTION_ID" => $arResult["PROPERTIES"]["PRICE"]["VALUE"],
	);
	
	$arSelect = array(
		"ID",
		"IBLOCK_ID",
		"NAME",
		"PROPERTY_*",
	);
	
	$arElement = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	while($rsElement = $arElement->GetNextElement())
	{
		$arItem = $rsElement->GetFields();
		$arItem["PROPERTIES"] = $rsElement->GetProperties();

		$arResult["PRICE"][] = $arItem;
	}
}