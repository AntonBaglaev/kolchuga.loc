<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 23.04.2018
 * Time: 13:06
 */

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);

class litebox_kassa extends CModule
{
    public $MODULE_ID = 'litebox.kassa';
    public $MODULE_NAME = 'litebox.kassa';
    public $pathResources = 'local';
    public $componentPath = '/components/litebox/kassa';
    public $apiPath = '/api';

    public $urlRules = [
        "CONDITION" => '#^/api/#',
        "ID" => 'litebox:kassa',
        "PATH" => '/api/index.php',
        "RULE" => '',
    ];

    public function __construct()
    {
        if(file_exists(__DIR__."/version.php")){

            $arModuleVersion = array();
			
			$path = str_replace("\\", "/", __FILE__);
			$path = substr($path, 0, strlen($path) - strlen("/index.php"));
			include($path . "/version.php");

            $this->MODULE_ID = str_replace("_", ".", get_class($this));
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
            $this->MODULE_NAME = Loc::getMessage("RITG_SYNC_NAME");
            $this->MODULE_DESCRIPTION = Loc::getMessage("RITG_SYNC_DESCRIPTION");
            $this->PARTNER_NAME = Loc::getMessage("RITG_SYNC_PARTNER_NAME");
            $this->PARTNER_URI = Loc::getMessage("RITG_SYNC_PARTNER_URI");
        }

        return false;
    }

    public function DoInstall()
    {
        global $APPLICATION;

        if(CheckVersion(ModuleManager::getVersion("main"), "14.00.00")){

            $this->InstallFiles();
            $this->InstallRouter();
            $this->InstallDB();

            ModuleManager::registerModule($this->MODULE_ID);

            $this->InstallEvents();
        }else{

            $APPLICATION->ThrowException(
                Loc::getMessage("RITG_SYNC_INSTALL_ERROR_VERSION")
            );
        }

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("RITG_SYNC_INSTALL_TITLE")." \"".Loc::getMessage("RITG_SYNC_NAME")."\"", __DIR__."/step.php"
        );

        return false;
    }

    public function DoUninstall()
    {
        global $APPLICATION;

        $this->UnInstallFiles();
        $this->UnInstallRouter();
        $this->UnInstallDB();

        ModuleManager::unRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("RITG_SYNC_UNINSTALL_TITLE") . " \"" . Loc::getMessage("RITG_SYNC_NAME") . "\"",
            __DIR__ . "/unstep.php"
        );

        return false;
    }

    public function UnInstallFiles()
    {
        \Bitrix\Main\IO\Directory::deleteDirectory($_SERVER["DOCUMENT_ROOT"] . $this->apiPath);
        \Bitrix\Main\IO\Directory::deleteDirectory($_SERVER["DOCUMENT_ROOT"] . "/" . $this->pathResources . $this->componentPath);
    }

    public function UnInstallDB()
    {
        Option::delete($this->MODULE_ID);
        return false;
    }

    public function InstallFiles()
    {
        if(\Bitrix\Main\IO\Directory::isDirectoryExists(__DIR__ . $this->componentPath)) {
            CopyDirFiles(__DIR__ . $this->componentPath, $_SERVER["DOCUMENT_ROOT"] . "/" . $this->pathResources . $this->componentPath, true, true);
        } else {
            throw new \Bitrix\Main\IO\InvalidPathException(__DIR__ . $this->componentPath);
        }

        if(\Bitrix\Main\IO\Directory::isDirectoryExists(__DIR__ . $this->apiPath)) {
            CopyDirFiles(__DIR__ . $this->apiPath, $_SERVER["DOCUMENT_ROOT"] . $this->apiPath, true, true);
        } else {
            throw new \Bitrix\Main\IO\InvalidPathException(__DIR__ . $this->apiPath);
        }
    }

    public function InstallDB()
    {
        return false;
    }

    public function InstallRouter()
    {
        CUrlRewriter::Add($this->urlRules);
    }

    public function UnInstallRouter()
    {
        $sites = CSite::GetList($by="sort", $order="desc");
        $site = $sites->Fetch();
        $this->urlRules['SITE_ID'] = $site['LID'];
        unset($this->urlRules['SORT']);
        unset($this->urlRules['RULE']);
        CUrlRewriter::Delete($this->urlRules);
    }
	
}