<?php

###########################
#						  #
# module REDCODE		  #
# @copyright 2017 REDCODE #
#						  #
###########################

AddEventHandler("main", "OnBuildGlobalMenu", "redcodeMenuMCorporate");

function redcodeMenuMCorporate(&$arGlobalMenu, &$arModuleMenu)
{
	IncludeModuleLangFile(__FILE__);
	$moduleName = "redcode.mcorporate";

	global $APPLICATION;
	$APPLICATION->SetAdditionalCss("/bitrix/css/".$moduleName."/menu.css");
	
	if($APPLICATION->GetGroupRight($moduleName) > "D")
	{
		$arMenu = array(
			"menu_id" => "redcode_mcorporate",
			"items_id" => "redcode_mcorporate",
			"text" => GetMessage("REDCODE_MC_MENU_TEXT"),
			"sort" => 900,
			"items" => array(
				array(
					"text" => GetMessage("REDCODE_MC_SUBMENU_TEXT"),
					"sort" => 10,
					"url" => "/bitrix/admin/".$moduleName."_colorSwitch.php",
					"items_id" => "redcode_mcorporate_main",
				),					
			),
		);
	
		$arGlobalMenu[] = $arMenu;
	}
}