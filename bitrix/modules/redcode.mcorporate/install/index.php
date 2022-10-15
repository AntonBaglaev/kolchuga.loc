<?php

###########################
#						  #
# module REDCODE		  #
# @copyright 2017 REDCODE #
#						  #
###########################

IncludeModuleLangFile(__FILE__);

class redcode_mcorporate extends CModule
{
	var $MODULE_ID = "redcode.mcorporate";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	const partner = "redcode";
	const solution = "mcorporate";

	function redcode_mcorporate()
	{
		require(dirname(__FILE__)."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = GetMessage("REDCODE_CORPORATE_INSTALL_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("REDCODE_CORPORATE_INSTALL_DESCRIPTION");
		$this->PARTNER_NAME = GetMessage("REDCODE_CORPORATE_SPER_PARTNER");
		$this->PARTNER_URI = GetMessage("REDCODE_CORPORATE_PARTNER_URI");
	}

	function InstallDB($install_wizard = true)
	{
		global $DB, $DBType, $APPLICATION;

        RegisterModule($this->MODULE_ID);
		
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		global $DB, $DBType, $APPLICATION;

		UnRegisterModule($this->MODULE_ID);
		
		return true;
	}
	
	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}
	
	function InstallPublic(){}
	
	function InstallFiles()
	{
		
		CopyDirFiles(__DIR__."/admin/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true, true);
		CopyDirFiles(__DIR__."/css/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/css/".$this->MODULE_ID, true, true);
		CopyDirFiles(__DIR__."/images/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/images/".$this->MODULE_ID, true, true);
		CopyDirFiles(__DIR__."/wizards/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/wizards", true, true);
		
		return true;
	}
	
	function UnInstallFiles()
	{
		DeleteDirFiles(__DIR__."/admin/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
		DeleteDirFilesEx("/bitrix/css/".$this->MODULE_ID."/");
		DeleteDirFilesEx("/bitrix/images/".$this->MODULE_ID."/");
		DeleteDirFilesEx("/bitrix/wizards/".self::partner."/".self::solution."/");
		
		return true;
	}
	
	function DoInstall()
	{
		global $APPLICATION, $step;

		$this->InstallFiles();
		$this->InstallDB(false);
		$this->InstallEvents();
		$this->InstallPublic();
	}

	function DoUninstall()
	{
 		global $APPLICATION, $step;

		$this->UnInstallDB();
		$this->UnInstallFiles();
		$this->UnInstallEvents();
	}

}