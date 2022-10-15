<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!\Bitrix\Main\Loader::includeModule("iblock"))
	return;

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/map.xml"; 
$iblockCode = "map_".WIZARD_SITE_ID; 
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
	$result = CIBlockProperty::GetByID("MAP_COORDINATE", $iblockID);
	if($arResult = $result->GetNext())
	{
		$iproperty = new CIBlockProperty;
		$arFields = array(
			"HINT" => "Координаты для карты можно взять в \"Яндекс.Карты\"",
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


/* UPDATE MARKER FOR MAP */

$arSelect = array("ID", "IBLOCK_ID", "PROPERTY_*");
$arFilter = array("IBLOCK_ID" => $iblockID);
$result = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);

if($ob = $result->GetNextElement())
{
	$fields = $ob->GetFields();
	$properties = $ob->GetProperties();
}

$element = new CIBlockElement;

$arLoadProductArray = array(
	"PROPERTY_VALUES"=> array(
		"MAP_COORDINATE" => $properties["MAP_COORDINATE"]["VALUE"],
		"MORE_TEXT" => $properties["MORE_TEXT"]["VALUE"],
		"MARKER" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."_".WIZARD_THEME_ID."/themes/".WIZARD_THEME_ID."/images/".WIZARD_THEME_ID.".png")
	),
);

$element->Update($fields["ID"], $arLoadProductArray);


CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/contacts/index.php", array("MAP_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/_index.php", array("MAP_IBLOCK_ID" => $iblockID));