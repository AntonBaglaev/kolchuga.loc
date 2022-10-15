<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

foreach($arResult["ITEMS"] as $key => $arItem)
{
	$rSection = \Bitrix\Iblock\SectionTable::getList(
		array(
			"select" => array("NAME"),
			"filter" => array("ID" => $arItem["IBLOCK_SECTION_ID"]),
		)
	);

	if($arSection = $rSection->fetch())
	{
		$arResult["ITEMS"][$key]["SECTION_NAME"] = $arSection["NAME"];
	}
}