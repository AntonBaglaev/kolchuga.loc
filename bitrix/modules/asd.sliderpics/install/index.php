<?
global $MESS;
$PathInstall = str_replace('\\', '/', __FILE__);
$PathInstall = substr($PathInstall, 0, strlen($PathInstall)-strlen('/index.php'));
IncludeModuleLangFile($PathInstall.'/install.php');
include($PathInstall.'/version.php');

if (class_exists('asd_sliderpics')) return;

class asd_sliderpics extends CModule
{
	var $MODULE_ID = "asd.sliderpics";
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;
	public $PARTNER_NAME;
	public $PARTNER_URI;
	public $MODULE_GROUP_RIGHTS = 'N';

	function __construct()
	{
		$arModuleVersion = array();

		$path = str_replace('\\', '/', __FILE__);
		$path = substr($path, 0, strlen($path) - strlen('/index.php'));
		include($path.'/version.php');

		if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		}

		$this->PARTNER_NAME = GetMessage("ASD_PARTNER_NAME");
		$this->PARTNER_URI = 'http://p1.d-it.ru/';

		$this->MODULE_NAME = GetMessage('ASD_SLP_NAME');
		$this->MODULE_DESCRIPTION = GetMessage('ASD_SLP_DESCRIPTION');
	}

	function DoInstall()
	{
		CopyDirFiles($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/asd.sliderpics/install/components/',
					$_SERVER['DOCUMENT_ROOT'].'/bitrix/components/bitrix/', true, true);
		RegisterModule('asd.sliderpics');
	}

	function DoUninstall()
	{
		UnRegisterModule('asd.sliderpics');
	}
}
?>