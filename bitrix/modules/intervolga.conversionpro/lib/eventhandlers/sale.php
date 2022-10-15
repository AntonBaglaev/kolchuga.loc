<?
namespace Intervolga\ConversionPro\EventHandlers;

use Bitrix\Main\Event;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Sale
{
    const MODULE_ID = 'intervolga.conversionpro';

    /**
     * Original baskets before updates
     *
     * @var \Bitrix\Sale\Basket[]
     */
    protected static $basketsCache = array();


    /**
     * OnSaleBasketItemBeforeSaved safe callback
     *
     * Due to event OnSaleBasketBeforeSaved works with bugs we have to use this event to capture Basket before it saved
     * @param Event $event
     */
    public static function OnSaleBasketItemBeforeSaved(Event $event)
    {
        try {
            if (!Loader::includeModule(self::MODULE_ID)) {
                throw new \Bitrix\Main\Config\ConfigurationException(
                    Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                        array('#MODULE_NAME#' => self::MODULE_ID))
                );
            }
            if (!Loader::includeModule('sale')) {
                throw new \Bitrix\Main\Config\ConfigurationException(
                    Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                        array('#MODULE_NAME#' => 'sale'))
                );
            }

            self::handleOnSaleBasketItemBeforeSaved($event);
        } catch (\Exception $e) {
            \CEventLog::Add(array(
                'SEVERITY' => 'WARNING',
                'AUDIT_TYPE_ID' => 'INTERVOLGA_CONVERSIONPRO_SALE_ON_SALE_BASKET_ITEM_BEFORE_SAVED',
                'MODULE_ID' => self::MODULE_ID,
                'DESCRIPTION' => strval($e)
            ));
        }
    }


    /**
     * OnSaleBasketBeforeSaved safe callback
     *
     * @param Event $event
     */
    public static function OnSaleBasketBeforeSaved(Event $event)
    {
        try {
            if (!Loader::includeModule(self::MODULE_ID)) {
                throw new \Bitrix\Main\Config\ConfigurationException(
                    Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                        array('#MODULE_NAME#' => self::MODULE_ID))
                );
            }
            if (!Loader::includeModule('sale')) {
                throw new \Bitrix\Main\Config\ConfigurationException(
                    Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                        array('#MODULE_NAME#' => 'sale'))
                );
            }

            self::handleOnSaleBasketBeforeSaved($event);
        } catch (\Exception $e) {
            \CEventLog::Add(array(
                'SEVERITY' => 'WARNING',
                'AUDIT_TYPE_ID' => 'INTERVOLGA_CONVERSIONPRO_SALE_ON_SALE_BASKET_BEFORE_SAVED',
                'MODULE_ID' => self::MODULE_ID,
                'DESCRIPTION' => strval($e)
            ));
        }
    }


    /**
     * OnSaleBasketSaved safe callback
     *
     * @param Event $event
     */
    public static function OnSaleBasketSaved(Event $event)
    {
        try {
            if (!Loader::includeModule(self::MODULE_ID)) {
                throw new \Bitrix\Main\Config\ConfigurationException(
                    Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                        array('#MODULE_NAME#' => self::MODULE_ID))
                );
            }
            if (!Loader::includeModule('sale')) {
                throw new \Bitrix\Main\Config\ConfigurationException(
                    Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                        array('#MODULE_NAME#' => 'sale'))
                );
            }

            self::handleOnSaleBasketSaved($event);
        } catch (\Exception $e) {
            \CEventLog::Add(array(
                'SEVERITY' => 'WARNING',
                'AUDIT_TYPE_ID' => 'INTERVOLGA_CONVERSIONPRO_SALE_ON_SALE_BASKET_SAVED',
                'MODULE_ID' => self::MODULE_ID,
                'DESCRIPTION' => strval($e)
            ));
        }
    }


    /**
     * OnSaleOrderSaved safe callback
     *
     * @param Event $event
     */
    public static function OnSaleOrderSaved(Event $event)
    {
        try {
            if (!Loader::includeModule(self::MODULE_ID)) {
                throw new \Bitrix\Main\Config\ConfigurationException(
                    Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                        array('#MODULE_NAME#' => self::MODULE_ID))
                );
            }
            if (!Loader::includeModule('sale')) {
                throw new \Bitrix\Main\Config\ConfigurationException(
                    Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                        array('#MODULE_NAME#' => 'sale'))
                );
            }

            self::handleOnSaleOrderSaved($event);
        } catch (\Exception $e) {
            \CEventLog::Add(array(
                'SEVERITY' => 'WARNING',
                'AUDIT_TYPE_ID' => 'INTERVOLGA_CONVERSIONPRO_SALE_ON_SALE_ORDER_SAVED',
                'MODULE_ID' => self::MODULE_ID,
                'DESCRIPTION' => strval($e)
            ));
        }
    }


    /**
     * Handle OnSaleBasketItemBeforeSaved to capture Basket before it saved
     *
     * @param Event $event
     */
    protected static function handleOnSaleBasketItemBeforeSaved(Event $event)
    {
        /** @var \Bitrix\Sale\BasketItem $basketItemToBeSaved */
        $basketItemToBeSaved = $event->getParameter("ENTITY");

        /** @var \Bitrix\Sale\Basket $basketToBeSaved */
        $basketToBeSaved = $basketItemToBeSaved->getCollection();

        self::cacheBasket($basketToBeSaved);
    }


    /**
     * Handle OnSaleBasketBeforeSaved to capture Basket before it saved
     *
     * @param Event $event
     */
    protected static function handleOnSaleBasketBeforeSaved(Event $event)
    {
        /** @var \Bitrix\Sale\Basket $basketToBeSaved */
        $basketToBeSaved = $event->getParameter("ENTITY");

        self::cacheBasket($basketToBeSaved);
    }


    /**
     * Cache basket before it changed
     *
     * @param \Bitrix\Sale\Basket $basket
     */
    protected static function cacheBasket(\Bitrix\Sale\Basket $basket)
    {
        $basketKey = $basket->getFUserId(true) . '_' . $basket->getSiteId();

        if (null !== $basket->getOrderId()) {
            return;
        }

        if (array_key_exists($basketKey, self::$basketsCache)) {
            return;
        }

        $basketInDb = \Bitrix\Sale\Basket::loadItemsForFUser(
            $basket->getFUserId(true),
            $basket->getSiteId()
        );
        foreach ($basketInDb->getBasketItems() as $basketItemInDb) {
            /** @var \Bitrix\Sale\BasketItem $basketItemInDb */
            $basketItemInDb->getPropertyCollection(); // Trigger to load properties from DB
        }
        $basketInDb->rewind(); // Discount calculation rises fatal error without it

        self::$basketsCache[$basketKey] = $basketInDb;
    }

    /**
     * Handle OnSaleBasketSaved to capture Basket changes
     *
     * @param Event $event
     * @throws \Exception
     */
    protected static function handleOnSaleBasketSaved(Event $event)
    {
        /** @var \Bitrix\Sale\Basket $savedBasket */
        $savedBasket = $event->getParameter("ENTITY");
        $basketKey = $savedBasket->getFUserId(true) . '_' . $savedBasket->getSiteId();

        if (!array_key_exists($basketKey, self::$basketsCache)) {
            throw new \Exception(Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ORIGINAL_BASKET_NOT_FOUND', array(
                '#FUSER_ID#' => $savedBasket->getFUserId(true),
                '#SITE_ID#' => $savedBasket->getSiteId()
            )));
        }

        /** @var \Bitrix\Sale\Basket $originalBasket */
        $originalBasket = self::$basketsCache[$basketKey];
        unset(self::$basketsCache[$basketKey]);

        /**
         * Ugly hack.
         * Basket should be reloaded from DB after save for proper discounts calculation.
         */
        self::cacheBasket($savedBasket);
        $savedBasket = self::$basketsCache[$basketKey];
        unset(self::$basketsCache[$basketKey]);

        \Intervolga\ConversionPro\EQueue::updateBasket($originalBasket, $savedBasket);
    }


    /**
     * Handle OnSaleOrderSaved to capture Order and Payment changes
     *
     * @param Event $event
     */
    protected static function handleOnSaleOrderSaved(Event $event)
    {
        /** @var \Bitrix\Sale\Order $order */
        $order = $event->getParameter("ENTITY");

        \Intervolga\ConversionPro\EQueue::addOrder($order);
    }
}

