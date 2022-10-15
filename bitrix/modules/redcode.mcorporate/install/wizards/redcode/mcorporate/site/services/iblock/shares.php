<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!\Bitrix\Main\Loader::includeModule("iblock"))
	return;

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/shares.xml"; 
$iblockCode = "shares_".WIZARD_SITE_ID; 
$iblockType = "redcode_mcorporate";

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
$iblockID = false; 
if ($arIBlock = $rsIBlock->Fetch())
{
	$iblockID = $arIBlock["ID"]; 
	if (WIZARD_INSTALL_DEMO_DATA)
	{
		CIBlock::Delete($arIBlock["ID"]); 
		$iblockID = false; 
	}
}

if($iblockID == false)
{
	$permissions = array(
		"1" => "X",
		"2" => "R"
	);
	$dbGroup = CGroup::GetList($by = "", $order = "", array("STRING_ID" => "content_editor"));
	if($arGroup = $dbGroup -> Fetch())
		$permissions[$arGroup["ID"]] = "W";

	$iblockID = WizardServices::ImportIBlockFromXML(
		$iblockXMLFile,
		$iblockCode,
		$iblockType,
		WIZARD_SITE_ID,
		$permissions
	);

	if ($iblockID < 1)
		return;
	
	$iblock = new CIBlock;
	$arFields = array(
		"ACTIVE" => "Y",
		"FIELDS" => array(
			"ACTIVE_FROM" => array("IS_REQUIRED" => "Y", "DEFAULT_VALUE" => "=today"),
			"CODE" => array("IS_REQUIRED" => "Y", "DEFAULT_VALUE" => array("UNIQUE" => "Y", "TRANSLITERATION" => "Y", "TRANS_EAT" => "Y")),
		),
		"CODE" => $iblockCode,
		"NAME" => $iblock->GetArrayByID($iblockID, "NAME"),
	);
	
	$iblock->Update($iblockID, $arFields);
	
	# Update property
	$result = CIBlockProperty::GetByID("SIZE_TITLE", $iblockID);
	if($arResult = $result->GetNext())
	{
		$iproperty = new CIBlockProperty;
		$arFields = array(
			"HINT" => "Размер заголовка меняется на детальной странице (37-42-48 px)",
		);
		$iproperty->Update($arResult["ID"], $arFields);
	}
	
	$result = CIBlockProperty::GetByID("CATEGORY", $iblockID);
	if($arResult = $result->GetNext())
	{
		$iproperty = new CIBlockProperty;
		$arFields = array(
			"HINT" => "Чтобы вывести нужный элемент на странице, необходимо дополнительно выбрать нужные инфоблоки в параметрах компонента",
		);
		$iproperty->Update($arResult["ID"], $arFields);
	}
	
	$result = CIBlockProperty::GetByID("SHOW_IMAGE", $iblockID);
	if($arResult = $result->GetNext())
	{
		$iproperty = new CIBlockProperty;
		$arFields = array(
			"HINT" => "По умолчанию изображение показывается и берется из \"Картинка для анонса\"",
		);
		$iproperty->Update($arResult["ID"], $arFields);
	}
	
	$result = CIBlockProperty::GetByID("PHOTO_VERTICAL", $iblockID);
	if($arResult = $result->GetNext())
	{
		$iproperty = new CIBlockProperty;
		$arFields = array(
			"HINT" => "По умолчанию изображение берется из \"Картинка для анонса\". Но можно выбрать свое изображение для конкретного режима.",
		);
		$iproperty->Update($arResult["ID"], $arFields);
	}
	
	$result = CIBlockProperty::GetByID("PHOTO_HORIZONTAL", $iblockID);
	if($arResult = $result->GetNext())
	{
		$iproperty = new CIBlockProperty;
		$arFields = array(
			"HINT" => "По умолчанию изображение берется из \"Картинка для анонса\". Но можно выбрать свое изображение для конкретного режима.",
		);
		$iproperty->Update($arResult["ID"], $arFields);
	}
}
else
{
	$arSites = array(); 
	$db_res = CIBlock::GetSite($iblockID);
	while ($res = $db_res->Fetch())
		$arSites[] = $res["LID"]; 
	if (!in_array(WIZARD_SITE_ID, $arSites))
	{
		$arSites[] = WIZARD_SITE_ID;
		$iblock = new CIBlock;
		$iblock->Update($iblockID, array("LID" => $arSites));
	}
}

WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH, array("SHARES_IBLOCK_ID" => $iblockID));