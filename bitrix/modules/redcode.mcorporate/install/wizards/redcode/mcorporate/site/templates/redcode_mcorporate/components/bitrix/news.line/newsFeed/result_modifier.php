<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!empty($arParams["PROPERTY_CODE"]))
{
	foreach($arResult["ITEMS"] as $key => $arItem)
	{
		foreach($arParams["PROPERTY_CODE"] as $arProperty)
		{
			if(!empty($arProperty))
			{
				$db_props = CIBlockElement::GetProperty($arItem["IBLOCK_ID"], $arItem["ID"], array(), array("CODE" => $arProperty));
				if($ar_props = $db_props->Fetch())
				{
					$arResult["ITEMS"][$key]["PROPERTIES"][$ar_props["CODE"]] = $ar_props;
				}
				if($arIBlock = GetIBlock($arItem["IBLOCK_ID"]))
				{
					$arResult["ITEMS"][$key]["IBLOCK_NAME"] = $arIBlock["NAME"];
				}
			}
		}
	}
}