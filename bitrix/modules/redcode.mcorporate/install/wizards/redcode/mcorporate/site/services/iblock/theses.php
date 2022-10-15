<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!\Bitrix\Main\Loader::includeModule("iblock"))
	return;

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/theses.xml"; 
$iblockCode = "theses_".WIZARD_SITE_ID; 
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
			"CODE" => array("IS_REQUIRED" => "Y", "DEFAULT_VALUE" => array("UNIQUE" => "Y", "TRANSLITERATION" => "Y", "TRANS_EAT" => "Y")),
		),
		"CODE" => $iblockCode,
		"NAME" => $iblock->GetArrayByID($iblockID, "NAME"),
	);
	
	$iblock->Update($iblockID, $arFields);
	
	# Update property
	$result = CIBlockProperty::GetByID("ICON", $iblockID);
	if($arResult = $result->GetNext())
	{
		$iproperty = new CIBlockProperty;
		$arFields = array(
			"HINT" => "Если вам нужна иконка, то \"Картинка для анонса\" нужно удалить. Иконки нужно брать из \"Material icons\"",
		);
		$iproperty->Update($arResult["ID"], $arFields);
	}
	
	$result = CIBlockProperty::GetByID("URL", $iblockID);
	if($arResult = $result->GetNext())
	{
		$iproperty = new CIBlockProperty;
		$arFields = array(
			"HINT" => "Можно добавить ссылку для тезиса. Переход осуществляется по нажатию на тезис",
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

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/_index.php", array("THESES_IBLOCK_ID" => $iblockID));