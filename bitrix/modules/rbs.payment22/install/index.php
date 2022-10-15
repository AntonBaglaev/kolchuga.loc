<?

class RBS_Payment22 extends CModule 
{
	const MODULE_ID = 'rbs.payment22';
	var $MODULE_ID = 'rbs.payment22';
	var $module_name;
	var $module_description;
	var $partner_name;
	var $partner_uri;

	function rbs_payment22() 
	{
		require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/rbs.payment22/config.php");
		
		$module_name = $mess['module_name'];
		$module_description = $mess['module_description'];
		$partner_name = $mess['partner_name'];
		$partner_uri = $mess['partner_uri'];
		
		/**
		 * Выбор кодировки в зависимости от payment/settings
		 */
		if(ENCODING) {
			$this->MODULE_NAME = $module_name;
			$this->MODULE_DESCRIPTION = $module_description;
			$this->PARTNER_NAME = $partner_name;
			$this->PARTNER_URI = $partner_uri;
		} else {
			$this->MODULE_NAME = iconv("utf-8", "windows-1251", $module_name);
			$this->MODULE_DESCRIPTION = iconv("utf-8", "windows-1251", $module_description);
			$this->PARTNER_NAME = iconv("utf-8", "windows-1251", $partner_name);
			$this->PARTNER_URI = iconv("utf-8", "windows-1251", $partner_uri);
		}
		
		$this->MODULE_VERSION = VERSION;
		$this->MODULE_VERSION_DATE = VERSION_DATE;
	}
	
	function InstallFiles($arParams = array()) 
	{
		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/rbs.payment22/install/sale_payment/payment/",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sale_payment/payment22/"
		);
		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/rbs.payment22/install/sale/payment",
			$_SERVER["DOCUMENT_ROOT"]."/sale/payment22/"
		);
	}

	function UnInstallFiles() 
	{
		DeleteDirFilesEx("/bitrix/php_interface/include/sale_payment/payment22");
		DeleteDirFilesEx("/sale/payment22/");
	}

	function DoInstall() 
	{
		$this->InstallFiles();
		RegisterModule(self::MODULE_ID);
	}

	function DoUninstall() 
	{
		UnRegisterModule(self::MODULE_ID);
		$this->UnInstallFiles();
	}
}