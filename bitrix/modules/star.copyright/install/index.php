<?
global $MESS;
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang)-18);
include(GetLangFileName($strPath2Lang."/lang/", "/install/index.php"));

Class star_copyright extends CModule {
	var $MODULE_ID = "star.copyright";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	
	function star_copyright() {
		$arModuleVersion = array();
		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");
		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}
		$this->PARTNER_NAME = GetMessage("STAR_COPYRIGHT_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("STAR_COPYRIGHT_PARTNER_URI");
		$this->MODULE_NAME = GetMessage("STAR_COPYRIGHT_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("STAR_COPYRIGHT_MODULE_DESC");
	}

	function InstallFiles() {
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/assets/js/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js/".$this->MODULE_ID, true, true);
			return true;
		}

		function UnInstallFiles() {
			DeleteDirFilesEx("/bitrix/js/".$this->MODULE_ID."/");

			$res = CFile::GetList(array(), array("MODULE_ID" => $this->MODULE_ID));
			while($res_arr = $res->GetNext()) {
				CFile::Delete($res_arr["ID"]);
			}

			return true;
		}
	

	function DoInstall() {
		$this->InstallFiles();
		RegisterModule($this->MODULE_ID);
		RegisterModuleDependences("main", "OnEpilog", $this->MODULE_ID);
	}
	
	

	function DoUninstall() {
		$this->UnInstallFiles();
		UnRegisterModuleDependences("main", "OnEpilog", $this->MODULE_ID);
		UnRegisterModule($this->MODULE_ID);
		
	}
}
?>