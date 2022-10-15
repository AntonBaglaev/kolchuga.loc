<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!\Bitrix\Main\Loader::includeModule("iblock"))
	return;

$arSelect = array("NAME", "CODE");
$arFilter = array("IBLOCK_ID" => "#PROJECTS_IBLOCK_ID#", "ACTIVE" => "Y");
$arOrder = array("SORT" => "DESC");

$arSections = \Bitrix\Iblock\SectionTable::getList(
	array(
		"select" => $arSelect,
		"filter" => $arFilter,
		"order" => $arOrder
	)
);

while($section = $arSections->fetch())
{
	$aMenuLinksExt[] = array(
		$section["NAME"],
		SITE_DIR."projects/".$section["CODE"]."/",
		array(),
		array(),
		""
	);
}

$aMenuLinks = $aMenuLinksExt;