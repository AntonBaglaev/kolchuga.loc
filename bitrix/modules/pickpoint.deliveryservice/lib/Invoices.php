<?php
/**
 * User: dimasik142
 * Email: ivanov.dmytro.ua@gmail.com
 * Date: 19.09.2018
 * Time: 15:54
 */

namespace PickPoint;

use \Bitrix\Main\Config\Option,
    \Bitrix\Sale\Internals\OrderTable;

/**
 * Class Invoices
 * @package PickPoint
 */
class Invoices extends Sql
{
    const REVERTED_STATUSES = [
        110,
        112,
        113,
        114,
        115,
        116,
        117,
    ];

    const READY_STATUSES = [
        111
    ];

    private $invoices = [];

    /**
     * Invoices constructor.
     * @throws \Bitrix\Main\SystemException
     */
    public function __construct()
    {
        $this->invoices = $this->getInvoicesData();
    }

    /**
     * @return array
     * @throws \Bitrix\Main\SystemException
     */
    private function getInvoicesData()
    {
        $invoices = self::getAllInvoices();
        $resultArray = [];

        $defaultWidth = Option::get('pickpoint.deliveryservice', 'pp_dimension_width', '50');
        $defaultHeight = Option::get('pickpoint.deliveryservice', 'pp_dimension_height', '50');
        $defaultDepth = Option::get('pickpoint.deliveryservice', 'pp_dimension_depth', '50');

        $ordersData = $this->getOrdersData($invoices);

        foreach ($invoices as $invoice) {

            $arSettings = unserialize($invoice['SETTINGS']);

            $item = [
                'ORDER_ID' => $invoice['ORDER_ID'],
                'ORDER_DATE' => $ordersData[$invoice['ORDER_ID']]['DATE_INSERT'],
                'PAYED_BY_PP' => Helper::CheckPPPaySystem(
                    $ordersData[$invoice['ORDER_ID']]['PAY_SYSTEM_ID']
                ),
                'PRICE' => $ordersData[$invoice['ORDER_ID']]['PRICE'],
                'PP_ADDRESS' => $invoice['ADDRESS'],
                'INVOICE_ID' => $invoice['PP_INVOICE_ID'],
                'STATUS' => $invoice['STATUS'],
                'SETTINGS' => $arSettings,
                'CANCELED' => $invoice['CANCELED']
            ];

            if (!empty($invoice['WIDTH'])){
                $item['WIDTH'] = $invoice['WIDTH'];
            } else {
                $item['WIDTH'] = $defaultWidth;
            }

            if (!empty($invoice['HEIGHT'])){
                $item['HEIGHT'] = $invoice['HEIGHT'];
            } else {
                $item['HEIGHT'] = $defaultHeight;
            }

            if (!empty($invoice['DEPTH'])){
                $item['DEPTH'] = $invoice['DEPTH'];
            } else {
                $item['DEPTH'] = $defaultDepth;
            }

            // распределение по групам
            if (!$invoice['STATUS'] && !$invoice['CANCELED'] && !$invoice['ARCHIVE']) {

                $resultArray['NEW'][] = $item;

            } elseif ($invoice['ARCHIVE']) {

                $resultArray['ARCHIVE'][] = $item;

            } elseif ($invoice['CANCELED']) {

                $resultArray['CANCELED'][] = $item;

            } elseif (in_array($invoice['STATUS'], self::REVERTED_STATUSES)) {

                $resultArray['REVERTED'][] = $item;

            } elseif (in_array($invoice['STATUS'], self::READY_STATUSES)) {

                $resultArray['READY'][] = $item;

            } else {

                $resultArray['FORWARDED'][] = $item;

            }
        }

        return $resultArray;
    }

    /**
     * Получает информацию о всех заказах
     *
     * @param array $invoices
     * @return array
     * @throws \Bitrix\Main\SystemException
     */
    private function getOrdersData($invoices)
    {
        $ordersId = [];
        $ordersArray = [];

        foreach ($invoices as $invoice) {
            $ordersId[] = $invoice['ORDER_ID'];
        }

        $dbQuery = OrderTable::getList(
            [
                'filter' => [
                    'ID' => $ordersId
                ],
                'select' => [
                    'DATE_INSERT',
                    'PAY_SYSTEM_ID',
                    'PERSON_TYPE_ID',
                    'PRICE',
                    'DELIVERY_ID',
                    'ID'
                ]
            ]
        );

        while ($order = $dbQuery->fetch()){
            $ordersArray[$order['ID']] = $order;
        }

        return $ordersArray;
    }

    /**
     * @return array
     */
    public function getInvoicesArray()
    {
        return $this->invoices;
    }
}