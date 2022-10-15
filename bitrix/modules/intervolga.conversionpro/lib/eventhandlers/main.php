<?
namespace Intervolga\ConversionPro\EventHandlers;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Main
{
    const MODULE_ID = 'intervolga.conversionpro';


    /**
     * OnProlog safe callback
     */
    public static function OnProlog()
    {
        try {
            if (!Loader::includeModule(self::MODULE_ID)) {
                if (!Loader::includeModule(self::MODULE_ID)) {
                    throw new \Bitrix\Main\Config\ConfigurationException(
                        Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                            array('#MODULE_NAME#' => self::MODULE_ID))
                    );
                }
            }

            self::handleOnProlog();
        } catch (\Exception $e) {
            \CEventLog::Add(array(
                'SEVERITY' => 'WARNING',
                'AUDIT_TYPE_ID' => 'INTERVOLGA_CONVERSIONPRO_MAIN_ONPROLOG',
                'MODULE_ID' => self::MODULE_ID,
                'DESCRIPTION' => strval($e)
            ));
        }
    }


    /**
     * OnAfterUserAuthorize safe callback
     */
    public static function OnAfterUserAuthorize()
    {
        try {
            if (!Loader::includeModule(self::MODULE_ID)) {
                if (!Loader::includeModule(self::MODULE_ID)) {
                    throw new \Bitrix\Main\Config\ConfigurationException(
                        Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                            array('#MODULE_NAME#' => self::MODULE_ID))
                    );
                }
            }

            self::handleOnAfterUserAuthorize();
        } catch (\Exception $e) {
            \CEventLog::Add(array(
                'SEVERITY' => 'WARNING',
                'AUDIT_TYPE_ID' => 'INTERVOLGA_CONVERSIONPRO_MAIN_ONAFTERUSERAUTHORIZE',
                'MODULE_ID' => self::MODULE_ID,
                'DESCRIPTION' => strval($e)
            ));
        }
    }

    protected static function handleOnProlog()
    {
        \Intervolga\ConversionPro\Visitor::refreshVisitorId();
        \Intervolga\ConversionPro\Visitor::refreshIsAdmin();
        \Intervolga\ConversionPro\Visitor::refreshQueueState();

        \Intervolga\ConversionPro\Visitor::watch();
    }

    protected static function handleOnAfterUserAuthorize()
    {
        \Intervolga\ConversionPro\Visitor::refreshVisitorId();
        \Intervolga\ConversionPro\Visitor::refreshIsAdmin();
        \Intervolga\ConversionPro\Visitor::refreshQueueState();
    }
}
