<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!\Bitrix\Main\Loader::includeModule("iblock"))
	return;

$arSelect = array("CODE", "NAME");
$arFilter = array(
	"IBLOCK_ID" => (isset($arCurrentValues["IBLOCK_ID"]) ? $arCurrentValues["IBLOCK_ID"] : $arCurrentValues["ID"]),
	"ACTIVE" => "Y"
);

$dbProperty = \Bitrix\Iblock\PropertyTable::getList(
	array(
		"select" => $arSelect,
		"filter" => $arFilter
	)
);

while($arr = $dbProperty->fetch())
{
	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
}

$arTemplateParameters = array(
	"INFO_LIST_TITLE" => array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("NF_INFO_LIST_TITLE"),
		"TYPE" => "STRING",
	),
	"PROPERTY_CODE" => array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("T_IBLOCK_PROPERTY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty,
		"ADDITIONAL_VALUES" => "Y",
	),

	"DETAIL_URL" => array(
		"HIDDEN" => "Y",
	),
);