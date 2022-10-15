<?php

namespace Starrys\Cashbox;

use \Starrys\Cashbox\CashboxStarrys;
use \Bitrix\Main\Event;
use \Bitrix\Main\EventResult;
use \Bitrix\Sale\Cashbox\CheckManager;
use \Bitrix\Sale\Cashbox\Manager;
use Bitrix\Sale\Cashbox\Cashbox;

class EventHandler {
    public static function OnGetCashboxHandler(\Bitrix\Main\Event $event) {

        $handlerList = array(
            '\Starrys\Cashbox\CashboxStarrys' => '/bitrix/modules/starrys.cashbox/lib/cashboxstarrys.php'
        );
        return new EventResult(EventResult::SUCCESS, $handlerList);
    }

    public static function OnGetCustomCheckList(\Bitrix\Main\Event $event) {
        $handlerList = array(
            '\Starrys\Cashbox\PartPaymentCheck' => '/bitrix/modules/starrys.cashbox/lib/partpaymentcheck.php'
        );
        return new EventResult(EventResult::SUCCESS, $handlerList);
    }

    public static function OnSaveOrder(\Bitrix\Main\Event $event) {
        $order = $event->getParameter('ENTITY');
        $cashBoxes = CashboxStarrys::getStarrysCashboxes();
        //file_put_contents(__DIR__.'/cash.txt', var_export($cashBoxes,true));
        foreach($cashBoxes as $cashBoxId => $settings) {
            $checkRows = CheckManager::getPrintableChecks(array($cashBoxId), array($order->getId()));
            $cashbox = Manager::getObjectById($cashBoxId);
            foreach($checkRows as $checkRow) {
                $check = CheckManager::create($checkRow);
                $cashbox->enqueCheck($check);
            }
        }
    }



}
?>