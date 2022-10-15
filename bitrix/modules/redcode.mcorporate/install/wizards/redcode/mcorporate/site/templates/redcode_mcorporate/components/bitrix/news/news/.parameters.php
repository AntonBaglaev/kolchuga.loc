<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!\Bitrix\Main\Loader::includeModule("iblock"))
	return;

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

// $arCurrentValues === $arParams

$arTemplateParameters = array(
	"USE_SEARCH" => array(
		"HIDDEN" => "Y",
	),
	"USE_RSS" => array(
		"HIDDEN" => "Y",
	),
	"USE_RATING" => array(
		"HIDDEN" => "Y",
	),
	"USE_REVIEW" => array(
		"HIDDEN" => "Y",
	),
	"USE_FILTER" => array(
		"HIDDEN" => "Y",
	),
	"USE_CATEGORIES" => array(
		"HIDDEN" => "Y",
	),
	"SET_LAST_MODIFIED" => array(
		"HIDDEN" => "Y",
	),
	"DISPLAY_TOP_PAGER" => array(
		"HIDDEN" => "Y",
	),
	"PAGER_DESC_NUMBERING" => array(
		"HIDDEN" => "Y",
	),
	"PAGER_DESC_NUMBERING_CACHE_TIME" => array(
		"HIDDEN" => "Y",
	),
	"PAGER_SHOW_ALL" => array(
		"HIDDEN" => "Y",
	),
	"PAGER_BASE_LINK_ENABLE" => array(
		"HIDDEN" => "Y",
	),
	"PAGER_SHOW_ALWAYS" => array(
		"HIDDEN" => "Y",
	),
	"PAGER_TITLE" => array(
		"HIDDEN" => "Y",
	),
	"DETAIL_DISPLAY_TOP_PAGER" => array(
		"HIDDEN" => "Y",
	),
	"DETAIL_DISPLAY_BOTTOM_PAGER" => array(
		"HIDDEN" => "Y",
	),
	"DETAIL_PAGER_TITLE" => array(
		"HIDDEN" => "Y",
	),
	"DETAIL_PAGER_TEMPLATE" => array(
		"HIDDEN" => "Y",
	),
	"DETAIL_PAGER_SHOW_ALL" => array(
		"HIDDEN" => "Y",
	),

	"USE_SHARE" => array(
		"NAME" => Loc::getMessage("T_IBLOCK_DESC_NEWS_USE_SHARE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" => "Y",
	),
	"USE_CATEGORY" => array(
		"PARENT" => "CATEGORY_SETTINGS",
		"NAME" => Loc::getMessage("T_IBLOCK_DESC_USE_CATEGORIES"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"REFRESH" => "Y",
	),
);

if($arCurrentValues["USE_CATEGORY"] == "Y")
{
	$arIBlockEx = array();
	
	$arSelect = array("NAME", "ID");
	$arFilter = array("IBLOCK_TYPE_ID" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE" => "Y");
	$arOrder = array("NAME" => "ASC");

	$rsIBlockEx = \Bitrix\Iblock\IblockTable::getList(
		array(
			"select" => $arSelect,
			"filter" => $arFilter,
			"order" => $arOrder
		)
	);
	
	while($arr = $rsIBlockEx->fetch())
		$arIBlockEx[$arr["ID"]] = $arr["NAME"]."[".$arr["ID"]."] ";

	$arTemplateParameters["CATEGORY_IBLOCK"] = array(
		"PARENT" => "CATEGORY_SETTINGS",
		"NAME" => Loc::getMessage("IBLOCK_CATEGORY_IBLOCK"),
		"TYPE" => "LIST",
		"VALUES" => $arIBlockEx,
		"MULTIPLE" => "Y",
		"REFRESH" => "Y",
	);
	$arTemplateParameters["CATEGORY_CODE"] = array(
		"PARENT" => "CATEGORY_SETTINGS",
		"NAME" => Loc::getMessage("IBLOCK_CATEGORY_CODE"),
		"TYPE" => "STRING",
		"DEFAULT" => "CATEGORY",
	);
	$arTemplateParameters["CATEGORY_ITEMS_COUNT"] = array(
		"PARENT" => "CATEGORY_SETTINGS",
		"NAME" => Loc::getMessage("IBLOCK_CATEGORY_ITEMS_COUNT"),
		"TYPE" => "STRING",
		"DEFAULT" => "2",
	);
}