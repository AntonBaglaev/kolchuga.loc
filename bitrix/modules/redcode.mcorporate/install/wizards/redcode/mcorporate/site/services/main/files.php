<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

if(!defined("WIZARD_SITE_ID") || !defined("WIZARD_SITE_PATH") || !defined("WIZARD_SITE_DIR"))
{
	return;
}


/* COPY MEDIA FOR SITE */
CopyDirFiles(
	str_replace("//", "/", WIZARD_ABSOLUTE_PATH."/medialibrary"),
	$_SERVER["DOCUMENT_ROOT"]."/upload/medialibrary",
	true,
	true,
	false
);

/* COPY COMPONENTS */
CopyDirFiles(
	str_replace("//", "/", WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/local/components/"),
	$_SERVER["DOCUMENT_ROOT"]."/local/components/",
	$rewrite = true, 
	$recursive = true,
	false,
	$exclude = "bitrix"
);

/* COPY PUBLIC FILES */
CopyDirFiles(
	str_replace("//", "/", WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/"),
	WIZARD_SITE_PATH,
	$rewrite = true, 
	$recursive = true,
	false,
	$exclude = "bitrix"
);


/* ADD AGREEMENTS FOR PROCESSING OF PERSONAL DATA */
use Bitrix\Main\UserConsent\Internals\AgreementTable;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;

$arElements = \Bitrix\Main\UserConsent\Internals\AgreementTable::getList(
	array(
		"select" => array("ID"),
		"filter" => array("CODE" => "REDCODE_AGREEMENT_MCORPORATE")
	)
);

if(!$idAgreement = $arElements->fetch())
{
	$arFilds = array(
		"CODE" => "REDCODE_AGREEMENT_MCORPORATE",
		"DATE_INSERT" => new DateTime(),
		"ACTIVE" => "Y",
		"NAME" => Loc::getMessage("REDCODE_AGREEMENT_NAME"),
		"TYPE" => "C",
		"LABEL_TEXT" => Loc::getMessage("REDCODE_AGREEMENT_LABEL_TEXT"),
		"SECURITY_CODE" => Bitrix\Main\Security\Random::getString(6),
		"AGREEMENT_TEXT" => Loc::getMessage("REDCODE_AGREEMENT_TEXT"),
	);
	
	$obResult = AgreementTable::add($arFilds);
	$idAgreement = $obResult->getId();

	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include_areas/details-agreement.php", array("REDCODE_AGREEMENT" => $idAgreement));
}
else
{
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include_areas/details-agreement.php", array("REDCODE_AGREEMENT" => $idAgreement["ID"]));
}
/* ADD AGREEMENTS FOR PROCESSING OF PERSONAL DATA */


/* .HTACCESS */
WizardServices::PatchHtaccess(WIZARD_SITE_PATH);


/* SITE_DIR & SITE_ID */
CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, array("SITE_ID" => WIZARD_SITE_ID));


/* FUNCTION FOR CREATING / OVERWRITING A FILE WITH URLREWRITE */
$arUrlRewrite = array(); 
if(file_exists(WIZARD_SITE_ROOT_PATH."/urlrewrite.php"))
	include(WIZARD_SITE_ROOT_PATH."/urlrewrite.php");

$arNewUrlRewrite = array(
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."shares/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR."shares/index.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."services/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR."services/index.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."news/#",
		"RULE" => "", 
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR."news/index.php"
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."articles/#",
		"RULE" => "", 
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR."articles/index.php"
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."projects/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR."projects/index.php",
	),
);
foreach ($arNewUrlRewrite as $arUrl)
{
	if (!in_array($arUrl, $arUrlRewrite))
		CUrlRewriter::Add($arUrl);
}


/* FILE OVERWRITE FUNCTION */
function ___writeToAreasFile($fn, $text)
{
	if(file_exists($fn) && !is_writable($abs_path) && defined("BX_FILE_PERMISSIONS"))
		@chmod($abs_path, BX_FILE_PERMISSIONS);

	$fd = @fopen($fn, "wb");
	if(!$fd)
		return false;

	if(false === fwrite($fd, $text))
	{
		fclose($fd);
		return false;
	}

	fclose($fd);

	if(defined("BX_FILE_PERMISSIONS"))
		@chmod($fn, BX_FILE_PERMISSIONS);
}


/* OVERWRITING FILES IN THE INCLUDE FOLDER */
$wizard =& $this->GetWizard();

$sitePhone = $wizard->GetVar("sitePhone");
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include_areas/contact/phone.php", array("SITE_PHONE" => $sitePhone));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include_areas/contact/phoneContact.php", array("SITE_PHONE" => $sitePhone));

$siteAddress = $wizard->GetVar("siteAddress");
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include_areas/contact/address.php", array("SITE_ADDRESS" => $siteAddress));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include_areas/contact/addressContact.php", array("SITE_ADDRESS" => $siteAddress));

$siteEmail = $wizard->GetVar("siteEmail");
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include_areas/contact/email.php", array("SITE_EMAIL" => $siteEmail));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include_areas/contact/emailContact.php", array("SITE_EMAIL" => $siteEmail));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include_areas/contact/emailTopMenu.php", array("SITE_EMAIL" => $siteEmail));

$siteWorkingHours = $wizard->GetVar("siteWorkingHours");
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include_areas/contact/working_hours.php", array("SITE_WORKINGHOURS" => $siteWorkingHours));

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php",
	array(
		"SITE_DESCRIPTION" => htmlspecialcharsbx($wizard->GetVar("siteMetaDescription")),
		"SITE_KEYWORDS" => htmlspecialcharsbx($wizard->GetVar("siteMetaKeywords")),
	)
);


/* START IMG LOGO */
$siteLogo = $wizard->GetVar("siteLogo");
if($siteLogo > 0)
{
	$ff = CFile::GetByID($siteLogo);
	if($zr = $ff->Fetch())
	{
		$strNewFile = str_replace("//", "/", WIZARD_SITE_ROOT_PATH."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$zr["SUBDIR"]."/".$zr["FILE_NAME"]);
		$strOldFile = WIZARD_SITE_PATH."include_areas/header/logo.png";
		copy($strNewFile, $strOldFile);
		CWizardUtil::ReplaceMacros(WIZARD_TEMPLATE_ABSOLUTE_PATH."/header.php", array("SITE_LOGO" => "logo"));
		CFile::Delete($siteLogo);
	}
}
/* END IMG LOGO */
