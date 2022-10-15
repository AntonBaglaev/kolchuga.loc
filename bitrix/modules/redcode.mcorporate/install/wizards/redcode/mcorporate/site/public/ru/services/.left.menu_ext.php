<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

if(!\Bitrix\Main\Loader::includeModule("iblock"))
{
	return;
}

$arSelect = array("NAME", "CODE");
$arFilter = array("IBLOCK_ID" => "#SERVICES_IBLOCK_ID#", "ACTIVE" => "Y");
$arOrder = array("SORT" => "DESC");

$arElements = \Bitrix\Iblock\ElementTable::getList(
	array(
		"select" => $arSelect,
		"filter" => $arFilter,
		"order" => $arOrder
	)
);

while($arElement = $arElements->fetch())
{
	$aMenuLinksExt[] = array(
		$arElement["NAME"],
		SITE_DIR."services/".$arElement["CODE"]."/",
		array(),
		array(),
		""
	);
}

$aMenuLinks = $aMenuLinksExt;