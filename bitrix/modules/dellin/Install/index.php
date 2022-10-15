<?

Class dellin extends CModule
{
var $MODULE_ID = "dellin";
var $MODULE_VERSION;
var $MODULE_VERSION_DATE;
var $MODULE_NAME;
var $MODULE_DESCRIPTION;
var $MODULE_CSS;

function dellin()
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

$this->MODULE_NAME = dellin::chToUTF("dellin_module – модуль с компонентом");
$this->MODULE_DESCRIPTION = dellin::chToUTF("После установки вы сможете использовать службу доставки \"Деловые линии\"");
}

function chToUTF($str){
$str = (LANG_CHARSET == 'UTF-8') ? iconv('Windows-1251','UTF-8',$str):$str;
return $str;
}

function InstallFiles($arParams = array())
{

CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/dellin/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sale_delivery", true, true);
return true;
}

function UnInstallFiles()
{

unlink($_SERVER["DOCUMENT_ROOT"].'/bitrix/php_interface/include/sale_delivery/delivery_dl.php');
unlink($_SERVER["DOCUMENT_ROOT"].'/bitrix/php_interface/include/sale_delivery/dellin_logo.png');
return true;
}

function DoInstall()
{
global $DOCUMENT_ROOT, $APPLICATION;
$this->InstallFiles();
RegisterModule("dellin");
$APPLICATION->IncludeAdminFile(dellin::chToUTF("Установка модуля dellin"), $DOCUMENT_ROOT."/bitrix/modules/dellin/install/step.php");
}

function DoUninstall()
{
global $DOCUMENT_ROOT, $APPLICATION;
$this->UnInstallFiles();
UnRegisterModule("dellin");
$APPLICATION->IncludeAdminFile(dellin::chToUTF("Деинсталляция модуля dellin"), $DOCUMENT_ROOT."/bitrix/modules/dellin/install/unstep.php");
}
}
?>