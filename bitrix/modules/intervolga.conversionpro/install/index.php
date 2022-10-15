<?
use Bitrix\Main;
use Bitrix\Main\IO;

/**
 * Can't use \Bitrix\Main\Localization\Loc in this file due to MarketPlace issue.
 * Support ticket #544928
 */
IncludeModuleLangFile(__FILE__);

/**
 * Module can be not installed
 */
require_once(__DIR__ . '/../lib/internal/queue.php');
require_once(__DIR__ . '/../lib/internal/orderslog.php');

Class intervolga_conversionpro extends CModule
{
    var $MODULE_ID = 'intervolga.conversionpro';
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $strError = '';

    function __construct()
    {
        $arModuleVersion = array();
        include(dirname(__FILE__) . "/version.php");

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = GetMessage("intervolga.CONVERSIONPRO_MODULE_NAME");
        $this->MODULE_DESCRIPTION = GetMessage("intervolga.CONVERSIONPRO_MODULE_DESC");
        $this->PARTNER_NAME = GetMessage("intervolga.CONVERSIONPRO_PARTNER_NAME");
        $this->PARTNER_URI = GetMessage("intervolga.CONVERSIONPRO_PARTNER_URI");
    }

    public function DoInstall()
    {
        try {
            $this->InstallFiles();
            $this->InstallDB();
            $this->InstallEvents();
            Main\ModuleManager::registerModule($this->MODULE_ID);

            $this->InstallAgents(); // should be after module registering
        } catch (\Exception $e) {
            global $APPLICATION;
            $APPLICATION->ThrowException($e->getMessage());

            return false;
        }

        return true;
    }

    public function DoUninstall()
    {
        try {
            $this->UnInstallAgents();
            Main\ModuleManager::unRegisterModule($this->MODULE_ID);
            $this->UnInstallEvents();
            $this->UnInstallDB();
            $this->UnInstallFiles();
        } catch (\Exception $e) {
            global $APPLICATION;
            $APPLICATION->ThrowException($e->getMessage());

            return false;
        }

        return true;
    }

    public function InstallFiles()
    {
        if (IO\Directory::isDirectoryExists(__DIR__ . '/components')) {
            CopyDirFiles(__DIR__ . '/components', Main\Application::getDocumentRoot() . '/bitrix/components/', true, true);
        }

        if (IO\Directory::isDirectoryExists(__DIR__ . '/js')) {
            CopyDirFiles(__DIR__ . '/js', Main\Application::getDocumentRoot() . '/bitrix/js/' . $this->MODULE_ID, true, true);
        }
    }

    public function UnInstallFiles()
    {
        $components = new IO\Directory(__DIR__ . '/components');
        if ($components->isExists()) {
            foreach ($components->getChildren() as $partner) {
                if (!$partner->isDirectory())
                    continue;

                foreach ($partner->getChildren() as $component) {
                    if (!$component->isDirectory())
                        continue;

                    $installedComponentPath = Main\Application::getDocumentRoot() . '/bitrix/components/' . $partner->getName() . '/'
                        . $component->getName();

                    if (IO\Directory::isDirectoryExists($installedComponentPath))
                        IO\Directory::deleteDirectory($installedComponentPath);
                }
            }
        }

        if (IO\Directory::isDirectoryExists(Main\Application::getDocumentRoot() . '/bitrix/js/' . $this->MODULE_ID)) {
            DeleteDirFilesEx('/bitrix/js/' . $this->MODULE_ID);
        }
    }

    public function InstallDB()
    {
        $connection = Main\Application::getConnection();

        $this->UnInstallDB();

        \Intervolga\ConversionPro\Internal\QueueTable::getEntity()->createDbTable();
        $connection->createIndex(\Intervolga\ConversionPro\Internal\QueueTable::getTableName(), 'CONVERSIONPRO_UUID_INDEX', 'VISITOR_UUID');


        \Intervolga\ConversionPro\Internal\OrdersLogTable::getEntity()->createDbTable();
    }

    public function UnInstallDB()
    {
        $connection = Main\Application::getConnection();

        try {
            $connection->dropTable(\Intervolga\ConversionPro\Internal\QueueTable::getTableName());
            $connection->dropTable(\Intervolga\ConversionPro\Internal\OrdersLogTable::getTableName());
        } catch (Main\DB\SqlQueryException $e) {
        }
    }

    public function InstallEvents()
    {
        Main\EventManager::getInstance()->registerEventHandler(
            'main', 'OnProlog', $this->MODULE_ID,
            '\Intervolga\ConversionPro\EventHandlers\Main', 'OnProlog'
        );
        Main\EventManager::getInstance()->registerEventHandler(
            'main', 'OnAfterUserAuthorize', $this->MODULE_ID,
            '\Intervolga\ConversionPro\EventHandlers\Main', 'OnAfterUserAuthorize'
        );

        Main\EventManager::getInstance()->registerEventHandler(
            'sale', 'OnSaleBasketItemBeforeSaved', $this->MODULE_ID,
            '\Intervolga\ConversionPro\EventHandlers\Sale', 'OnSaleBasketItemBeforeSaved'
        );
        Main\EventManager::getInstance()->registerEventHandler(
            'sale', 'OnSaleBasketBeforeSaved', $this->MODULE_ID,
            '\Intervolga\ConversionPro\EventHandlers\Sale', 'OnSaleBasketBeforeSaved'
        );
        Main\EventManager::getInstance()->registerEventHandler(
            'sale', 'OnSaleBasketSaved', $this->MODULE_ID,
            '\Intervolga\ConversionPro\EventHandlers\Sale', 'OnSaleBasketSaved'
        );
        Main\EventManager::getInstance()->registerEventHandler(
            'sale', 'OnSaleOrderSaved', $this->MODULE_ID,
            '\Intervolga\ConversionPro\EventHandlers\Sale', 'OnSaleOrderSaved'
        );
    }

    public function UnInstallEvents()
    {
        Main\EventManager::getInstance()->unRegisterEventHandler(
            'main', 'OnProlog', $this->MODULE_ID,
            '\Intervolga\ConversionPro\EventHandlers\Main', 'OnProlog'
        );
        Main\EventManager::getInstance()->unRegisterEventHandler(
            'main', 'OnAfterUserAuthorize', $this->MODULE_ID,
            '\Intervolga\ConversionPro\EventHandlers\Main', 'OnAfterUserAuthorize'
        );

        Main\EventManager::getInstance()->unRegisterEventHandler(
            'sale', 'OnSaleBasketItemBeforeSaved', $this->MODULE_ID,
            '\Intervolga\ConversionPro\EventHandlers\Sale', 'OnSaleBasketItemBeforeSaved'
        );
        Main\EventManager::getInstance()->unRegisterEventHandler(
            'sale', 'OnSaleBasketBeforeSaved', $this->MODULE_ID,
            '\Intervolga\ConversionPro\EventHandlers\Sale', 'OnSaleBasketBeforeSaved'
        );
        Main\EventManager::getInstance()->unRegisterEventHandler(
            'sale', 'OnSaleBasketSaved', $this->MODULE_ID,
            '\Intervolga\ConversionPro\EventHandlers\Sale', 'OnSaleBasketSaved'
        );
        Main\EventManager::getInstance()->unRegisterEventHandler(
            'sale', 'OnSaleOrderSaved', $this->MODULE_ID,
            '\Intervolga\ConversionPro\EventHandlers\Sale', 'OnSaleOrderSaved'
        );
    }

    public function InstallAgents()
    {
        \CAgent::AddAgent('\Intervolga\ConversionPro\Queue::cleanAgent();', $this->MODULE_ID, 'N', 3600);
    }

    public function UnInstallAgents()
    {
        \CAgent::RemoveModuleAgents($this->MODULE_ID);
    }
}

?>
