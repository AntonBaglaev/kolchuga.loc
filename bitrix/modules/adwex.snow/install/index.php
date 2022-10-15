<?
global $MESS;
IncludeModuleLangFile(__FILE__);

class adwex_snow extends CModule {
	const solutionName	= 'snow';
	const partnerName = 'adwex';
	const moduleClass = 'adwex_snow';

	var $MODULE_ID = 'adwex.snow';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = 'Y';

	function adwex_snow(){
		$arModuleVersion = array();

		$path = str_replace('\\', '/', __FILE__);
		$path = substr($path, 0, strlen($path) - strlen('/index.php'));
		include($path . '/version.php');
		$this->MODULE_VERSION = $arModuleVersion['VERSION'];
		$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		$this->MODULE_NAME = GetMessage('ADW_SNOW_INSTALL_NAME');
		$this->MODULE_DESCRIPTION = GetMessage('ADW_SNOW_INSTALL_DESCRIPTION');
		$this->PARTNER_NAME = GetMessage('ADW_SNOW_PARTNER');
		$this->PARTNER_URI = GetMessage('ADW_SNOW_PARTNER_URI');
	}
	
	function InstallDB($arParams = array()) {
		
	}

	
	function UnInstallDB($arParams = array()) {
		
	}

	function DoInstall() {
        global $DOCUMENT_ROOT, $APPLICATION;
        $this->installFiles();
        $this->InstallDB();
        RegisterModule($this->MODULE_ID);
        RegisterModuleDependences('main', 'OnEndBufferContent', $this->MODULE_ID, 'AdwexSnow\\EventListener', 'OnEndBufferContent');
        $APPLICATION->IncludeAdminFile(GetMessage('ADW_SNOW_INSTALL_TITLE') . ' ' . $this->MODULE_ID, $DOCUMENT_ROOT . '/bitrix/modules/' . $this->MODULE_ID . '/install/step.php');        
    }
     
    function DoUninstall() {
        global $DOCUMENT_ROOT, $APPLICATION;
        $this->deleteFiles();
        $this->UnInstallDB();
        UnRegisterModule($this->MODULE_ID);
        UnRegisterModuleDependences('main', 'OnEndBufferContent', $this->MODULE_ID, 'AdwexSnow\\EventListener', 'OnEndBufferContent');
        $APPLICATION->IncludeAdminFile(GetMessage('ADW_SNOW_UNINSTALL_TITLE') . ' ' . $this->MODULE_ID, $DOCUMENT_ROOT . '/bitrix/modules/' . $this->MODULE_ID . '/install/unstep.php');
    }
    
    public function installFiles() {
        return true;
    }

    public function deleteFiles() {
        return true;
    }
}