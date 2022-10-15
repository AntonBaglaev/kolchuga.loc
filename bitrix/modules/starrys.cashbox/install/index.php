<?
use Bitrix\Main;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\EventManager;

Loc::loadMessages(__FILE__);


Class starrys_cashbox extends CModule
{
    var $MODULE_ID = "starrys.cashbox";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $MODULE_GROUP_RIGHTS = "Y";
    var $PARTNER_NAME;
    var $PARTNER_URI;


    public function starrys_cashbox()
    {
        $arModuleVersion = array();

        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_ID = 'starrys.cashbox';
        $this->MODULE_NAME = GetMessage('STARRYS.CASHBOX_MODULE_NAME');
        $this->MODULE_DESCRIPTION = GetMessage('STARRYS.CASHBOX_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = GetMessage('STARRYS.CASHBOX_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = 'http://chekonline.ru';
    }

    function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        $checkDate = Main\Type\DateTime::createFromTimestamp(strtotime('+5 minutes'));
        CAgent::AddAgent('\Starrys\Cashbox\CashboxStarrys::printChecks();', 'starrys.cashbox', 'N', 60*5, '', 'Y', $checkDate->toString(), 100, false, true);
        CAgent::AddAgent('\Starrys\Cashbox\CashboxStarrys::checkStatus();', 'starrys.cashbox', 'N', 60*1, '', 'Y', $checkDate->toString(), 100, false, true);
        unset($checkDate);

        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandler("sale", "OnGetCustomCashboxHandlers", $this->MODULE_ID, '\Starrys\Cashbox\EventHandler', 'OnGetCashboxHandler');
        $eventManager->registerEventHandler('sale', 'OnSaleOrderSaved', $this->MODULE_ID, '\Starrys\Cashbox\EventHandler', 'OnSaveOrder');
        $eventManager->registerEventHandler('sale', 'OnGetCustomCheckList', $this->MODULE_ID, '\Starrys\Cashbox\EventHandler', 'OnGetCustomCheckList');
    }

    function DoUninstall()
    {
        CAgent::RemoveModuleAgents('starrys.cashbox');
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler("sale", "OnGetCustomCashboxHandlers", $this->MODULE_ID, '\Starrys\Cashbox\EventHandler', 'OnGetCashboxHandler');
        $eventManager->unRegisterEventHandler('sale', 'OnSaleOrderSaved', $this->MODULE_ID, '\Starrys\Cashbox\EventHandler', 'OnSaveOrder');
        $eventManager->unregisterEventHandler('sale', 'OnGetCustomCheckList', $this->MODULE_ID, '\Starrys\Cashbox\EventHandler', 'OnGetCustomCheckList');

        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

}
?>