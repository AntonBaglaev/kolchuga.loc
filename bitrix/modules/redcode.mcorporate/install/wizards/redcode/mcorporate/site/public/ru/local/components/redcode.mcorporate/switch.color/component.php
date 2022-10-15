<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!\Bitrix\Main\Loader::includeSharewareModule("redcode.mcorporate"))
	die("Module 'redcode.mcorporate' not installed");

$asset = \Bitrix\Main\Page\Asset::getInstance();

$moduleClass = MODULE_CLASS;
$parametrsFromAdmin = $moduleClass::getParametrsFromAdmin(SITE_ID);

/* Update color from the admin */
if(isset($_COOKIE["COLOR_CUSTOM_".SITE_ID]) && !empty($_COOKIE["COLOR_CUSTOM_".SITE_ID]))
{
	$moduleClass::updateThemes($_COOKIE["COLOR_CUSTOM_".SITE_ID], SITE_ID);
	setcookie("COLOR_CUSTOM_".SITE_ID, "", time() - 60 * 60 * 24 * 30, "/");
}

/* Update color from the public part of the site 
if(isset($_COOKIE["COOKIE_OPTIONS"]) && !empty($_COOKIE["COOKIE_OPTIONS"]))
{
	$parametrsFromAdmin = json_decode($_COOKIE["COOKIE_OPTIONS"], true);
	$moduleClass::updateThemes($parametrsFromAdmin["COLOR_CUSTOM"]);
	
	$asset->addCss(SITE_TEMPLATE_PATH."/css/spectrum.css");
	$asset->addJs(SITE_TEMPLATE_PATH."/js/spectrum.js");
	$this->IncludeComponentTemplate();
}
*/

foreach($moduleClass::$massivParameters as $sectionCode => $section)
{
	foreach($section["OPTIONS"] as $elementCode => $element)
	{
		$arResult[$elementCode] = $element;
		
		if(is_array($parametrsFromAdmin) && !empty($parametrsFromAdmin))
			$arResult[$elementCode]["VALUE"] = $parametrsFromAdmin[$elementCode];
	}
}

$asset->addCss(SITE_TEMPLATE_PATH."/themes/".strtolower($arResult["COLOR"]["VALUE"])."/style.css", true);

return $arResult;