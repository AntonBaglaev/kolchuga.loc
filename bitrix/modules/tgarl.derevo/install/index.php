<?
global $MESS;
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang)-18);
include(GetLangFileName($strPath2Lang."/lang/", "/install/index.php"));

Class tgarl_derevo extends CModule
{
	var $MODULE_ID = "tgarl.derevo";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	function tgarl_derevo()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}
		else
		{
			$this->MODULE_VERSION = "2.0.0";
            $this->MODULE_VERSION_DATE = "2019-03-10 12:00:00";
		}

		$this->MODULE_NAME = GetMessage("TGARL_DEREVO_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("TGARL_DEREVO_MODULE_DESC");
		$this->PARTNER_NAME = GetMessage("TGARL_DEREVO_PARTNER");
		$this->PARTNER_URI = GetMessage("TGARL_DEREVO_SITE");
	}

	
	
	function InstallDB($arParams = array())
	{
		RegisterModule("tgarl.derevo");
		
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		UnRegisterModule("tgarl.derevo");

		return true;
	}

	function InstallEvents()
	{
		RegisterModuleDependences("main", "OnBuildGlobalMenu", $this->MODULE_ID, "tgarl_derevo_pr", "DoBuildGlobalMenuPr");
		RegisterModuleDependences('main', 'OnPanelCreate', $this->MODULE_ID, 'tgarl_derevo_pr', 'OnPanelCreateHandler');
		return true;
	}

	function UnInstallEvents()
	{
		UnRegisterModuleDependences("main", "OnBuildGlobalMenu", $this->MODULE_ID, "tgarl_derevo_pr", "DoBuildGlobalMenuPr"); 
		UnRegisterModuleDependences("main", "OnPanelCreate", $this->MODULE_ID, "tgarl_derevo_pr", "OnPanelCreateHandler"); 
		return true;
	}

	function InstallFiles($arParams = array())
	{
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/tgarl.derevo/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true);
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/tgarl.derevo/install/tools", $_SERVER["DOCUMENT_ROOT"]."/bitrix/tools", true, true);
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/tgarl.derevo/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
		DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/tgarl.derevo/install/tools", $_SERVER["DOCUMENT_ROOT"]."/bitrix/tools");
		return true;
	}

	function DoInstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->InstallFiles();
		$this->InstallDB(false);
		$this->InstallEvents();
		$APPLICATION->IncludeAdminFile(GetMessage("TGARL_DEREVO_INSTALL_TITLE"), $DOCUMENT_ROOT."/bitrix/modules/tgarl.derevo/install/step.php");
	}

	function DoUninstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->UnInstallFiles();
		$this->UnInstallDB();
		$this->UnInstallEvents();
		$APPLICATION->IncludeAdminFile(GetMessage("TGARL_DEREVO_UNINSTALL_TITLE"), $DOCUMENT_ROOT."/bitrix/modules/tgarl.derevo/install/unstep.php");
	}
}
?>