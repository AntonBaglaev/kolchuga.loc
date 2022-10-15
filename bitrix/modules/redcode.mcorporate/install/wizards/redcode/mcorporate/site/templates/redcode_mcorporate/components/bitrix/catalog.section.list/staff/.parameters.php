<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!\Bitrix\Main\Loader::includeModule("iblock"))
	return;


$arFilter = array(
	"IBLOCK_ID" => $arCurrentValues["IBLOCK_ID"],
	"ACTIVE" => "Y",
);
$rsProp = \Bitrix\Iblock\PropertyTable::getList(
	array(
		"filter" => $arFilter
	)
);
while($arr = $rsProp->fetch())
{
	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	if(in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "E")))
	{
		$arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arSorts = array("ASC" => GetMessage("T_IBLOCK_DESC_ASC"), "DESC" => GetMessage("T_IBLOCK_DESC_DESC"));
$arSortFields = array(
	"ID" => GetMessage("T_IBLOCK_DESC_FID"),
	"NAME" => GetMessage("T_IBLOCK_DESC_FNAME"),
	"ACTIVE_FROM" => GetMessage("T_IBLOCK_DESC_FACT"),
	"SORT" => GetMessage("T_IBLOCK_DESC_FSORT")
);

$arTemplateParameters = array(
	"SECTION_ID" => array(
		"HIDDEN" => "Y",
	),
	"SECTION_CODE" => array(
		"HIDDEN" => "Y",
	),
	"TOP_DEPTH" => array(
		"HIDDEN" => "Y",
	),
	"ADD_SECTIONS_CHAIN" => array(
		"HIDDEN" => "Y",
	),
	"COUNT_ELEMENTS" => array(
		"HIDDEN" => "Y",
	),
	"SECTION_URL" => array(
		"HIDDEN" => "Y",
	),

	"CHECK_DATES" => array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_CHECK_DATES"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"SORT_BY" => array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_IBORD"),
		"TYPE" => "LIST",
		"DEFAULT" => "NAME",
		"VALUES" => $arSortFields,
	),
	"SORT_ORDER" => array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_IBBY"),
		"TYPE" => "LIST",
		"DEFAULT" => "DESC",
		"VALUES" => $arSorts,
	),
	"ELEMENT_FIELDS" => CIBlockParameters::GetFieldCode(
		GetMessage("CP_BCSL_ELEMENT_FIELDS"),
		"DATA_SOURCE",
		array()
	),
	"ELEMENT_PROPERTY" => array(
		"PARENT" => "DATA_SOURCE",
		"NAME" => GetMessage("T_IBLOCK_PROPERTY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty_LNS,
		"ADDITIONAL_VALUES" => "Y",
	),
);