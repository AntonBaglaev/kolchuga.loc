<?php
/**
 * User: dimasik142
 * Email: ivanov.dmytro.ua@gmail.com
 * Date: 10.09.2018
 * Time: 14:16
 */

namespace PickPoint;

use \Bitrix\Main\Web\HttpClient,
    \Bitrix\Main\Text\Encoding,
    \Bitrix\Main\Config\Option,
    \Bitrix\Main\SystemException,
    \Bitrix\Sale\Order;

/**
 * Class Request
 * @package PickPoint
 */
class Request extends Sql
{
    const MODULE_ID = 'pickpoint.deliveryservice';
    const FLOAT_NUMBER_FORMAT = 2;

    private $sessionId;
    private $arServiceTypesCodes;
    private $arOptionDefaults;
    private $arEnclosingTypesCodes;

    /**
     * Request constructor.
     * @param array $arServiceTypesCodes
     * @param array $arOptionDefaults
     * @param array $arEnclosingTypesCodes
     * @throws SystemException
     */
    public function __construct($arServiceTypesCodes, $arOptionDefaults, $arEnclosingTypesCodes)
    {
        $this->sessionId = $this->login();

        // const
        $this->arOptionDefaults = $arOptionDefaults;
        $this->arServiceTypesCodes = $arServiceTypesCodes;
        $this->arEnclosingTypesCodes = $arEnclosingTypesCodes;
        // const
    }

    /**
     * Request destructor.
     * @throws SystemException
     */
    public function __destruct()
    {
        $this->logout();
    }

    /**
     * Метод выполняет запрос в PickPoint
     *
     * @param string $method
     * @param array $arQuery
     * @return mixed
     * @throws SystemException
     */
    private function query($method, $arQuery)
    {
        $MODULE_ID = self::MODULE_ID;

        $bpp_test_mode = Option::get($MODULE_ID, 'pp_test_mode', '');
        if ($bpp_test_mode) {
            $apiUrl = '/apitest/';
        } else {
            $apiUrl = '/api/';
        }

        if (!(defined('BX_UTF') && BX_UTF == true)) {
            $arQuery = Encoding::convertEncoding($arQuery, 'windows-1251', 'utf-8');
        }

        $httpClient = new HttpClient();
        $httpClient->setHeader('Content-Type', 'application/json', true);

        $response = $httpClient->post(
            'https://e-solution.pickpoint.ru' . $apiUrl . $method,
            json_encode($arQuery)
        );

        $response = json_decode($response, true);

        return $response;
    }

    /**
     * Метод предназначен для начала сеанса работы.
     *
     * @return string|false
     * @throws SystemException
     */
    private function login()
    {
        $login = Option::get(self::MODULE_ID, 'pp_api_login', '');
        $password = Option::get(self::MODULE_ID, 'pp_api_password', '');

        $arQuery = array(
            'Login' => $login,
            'Password' => $password,
        );

        $response = self::query('login', $arQuery);

        if (!$response['ErrorMessage'] && $response['SessionId']) {
            return $response['SessionId'];
        } else {
            return false;
        }
    }

    /**
     * Метод предназначен для завершения сеанса работы.
     *
     * @throws SystemException
     */
    private function logout()
    {
        $arQuery = array('SessionId' => $this->sessionId);

        self::query('logout', $arQuery);
    }

    /**
     * Метод отменяет созданный заказ
     *
     * @param int $invoiceNumber
     * @param int $orderId
     * @return array
     * @throws SystemException
     */
    public function cancelInvoice($invoiceNumber, $orderId)
    {
        $iknNumber = Option::get(self::MODULE_ID, 'pp_ikn_number', '');

        $arQuery = array(
            'SessionId' => $this->sessionId,
            'IKN' => $iknNumber,
            'InvoiceNumber' => $invoiceNumber,
            'GCInvoiceNumber' => $orderId,
        );

        $queryResult = self::query('cancelInvoice', $arQuery);

        if ($queryResult['Result'])
        {
            self::setCanceledInvoiceStatus($orderId);

            return [
                'STATUS' => true,
            ];
        } else {
            return [
                'STATUS' => false,
                'TEXT' => $queryResult['Error']
            ];
        }
    }

    /**
     * Метод возвращает код статуса заказа из PickPoint
     *
     * @param $invoiceNumber
     * @param $orderId
     * @return bool
     * @throws SystemException
     */
    private function getInvoiceStatus($invoiceNumber, $orderId)
    {
        $arQuery = array(
            'SessionId' => $this->sessionId,
            'InvoiceNumber' => $invoiceNumber,
            'SenderInvoiceNumber' => $orderId
        );

        $queryResult = self::query('tracksending', $arQuery);

        if ($queryResult[0]['State']) {
            return $queryResult[0]['State'];
        } else {
            return false;
        }
    }

    /**
     * Метод возвращает дание о заказе
     *
     * @param int $orderId
     * @param array $statusTable
     * @return array|bool
     * @throws SystemException
     */
    public function getOrderDataToMakeUpdateForm($orderId, $statusTable)
    {
        $invoiceData = self::getInvoiceData($orderId);
        $dimensionData = self::getDimensionsData($orderId);

        if ($invoiceData) {
            if ($invoiceData['PP_INVOICE_ID']) {
                $ppInvoiceStatus = $this->getInvoiceStatus($invoiceData['PP_INVOICE_ID'], $orderId);

                return [
                    'DATA' => $invoiceData,
                    'FIELDS' => $statusTable[$ppInvoiceStatus],
                    'ORDER_PRICE' => self::getOrderPrice($orderId),
                    'INVOICE_SEND' => true,
                    'DIMENSION' => $dimensionData
                ];
            } else {
                return [
                    'DATA' => $invoiceData,
                    'FIELDS_ALL' => true,
                    'ORDER_PRICE' => self::getOrderPrice($orderId),
                    'INVOICE_SEND' => false,
                    'DIMENSION' => $dimensionData
                ];
            }
        } else {
            return false;
        }
    }

    /**
     * Возваращает цену из заказа
     *
     * @param int $orderId
     * @return int
     * @throws SystemException
     */
    private function getOrderPrice($orderId)
    {
        $orderQuery = Order::getList(
            [
                'filter' => [
                    'ID' => $orderId
                ],
                'select' => [
                    'PRICE'
                ]
            ]
        );

        $order = $orderQuery->fetch();

        return $order['PRICE'];
    }

    /**
     * Метод меняет значения заказа
     *
     * @param false|int $invoiceNumber
     * @param int $orderId
     * @param array $arFields
     * @throws SystemException
     */
    public function changeInvoice($orderId, $arFields, $invoiceNumber = false)
    {
        if ($invoiceNumber) {
            // если заказ уже отправлен в PickPoint
            $oldInvoiceData = self::getInvoiceData($orderId);

            $arQuery = array(
                'SessionId' => $this->sessionId,
                'InvoiceNumber' => $invoiceNumber,
                'GCInvoiceNumber' => $orderId,
            );

            if (!empty($arFields['PP_PHONE']) && $arFields['PP_PHONE'] != $oldInvoiceData['SMS_PHONE']) {
                $arQuery = array_merge($arQuery, array('Phone' => $arFields['PP_PHONE']));
                self::updateInvoice($orderId, 'SMS_PHONE="'.$arFields['PP_PHONE'].'"');
            }

            if (!empty($arFields['PP_NAME']) && $arFields['PP_NAME'] != $oldInvoiceData['NAME']) {
                $arQuery = array_merge($arQuery, array('RecipientName' => $arFields['PP_NAME']));
                self::updateInvoice($orderId, 'NAME="'.$arFields['PP_NAME'].'"');
            }

            if (!empty($arFields['PP_EMAIL']) && $arFields['PP_EMAIL'] != $oldInvoiceData['EMAIL']) {
                $arQuery = array_merge($arQuery, array('Email' => $arFields['PP_EMAIL']));
                self::updateInvoice($orderId, 'EMAIL="'.$arFields['PP_EMAIL'].'"');

            }

            if (!empty($arFields['PP_POSTAMAT_ID']) && $arFields['PP_POSTAMAT_ID'] != $oldInvoiceData['POSTAMAT_ID']) {
                $arQuery = array_merge($arQuery, array('PostamatNumber' => $arFields['PP_POSTAMAT_ID']));
                self::updateInvoice($orderId, 'POSTAMAT_ID="'.$arFields['PP_POSTAMAT_ID'].'"');
            }

            self::query('updateInvoice', $arQuery);

        } else {
            // если не отправлен в PickPoint
            $oldInvoiceData = self::getInvoiceData($orderId);


            if (!empty($arFields['PP_PHONE']) && $arFields['PP_PHONE'] != $oldInvoiceData['SMS_PHONE']) {
                self::updateInvoice($orderId, 'SMS_PHONE="'.$arFields['PP_PHONE'].'"');
            }

            if (!empty($arFields['PP_NAME']) && $arFields['PP_NAME'] != $oldInvoiceData['NAME']) {
                self::updateInvoice($orderId, 'NAME="'.$arFields['PP_NAME'].'"');
            }

            if (!empty($arFields['PP_EMAIL']) && $arFields['PP_EMAIL'] != $oldInvoiceData['EMAIL']) {
                self::updateInvoice($orderId, 'EMAIL="'.$arFields['PP_EMAIL'].'"');
            }

            if (!empty($arFields['PP_POSTAMAT_ID']) && $arFields['PP_POSTAMAT_ID'] != $oldInvoiceData['POSTAMAT_ID']) {
                self::updateInvoice($orderId, 'POSTAMAT_ID="'.$arFields['PP_POSTAMAT_ID'].'"');
            }

            if (!empty($arFields['PP_WIDTH']) && $arFields['PP_WIDTH'] != $oldInvoiceData['WIDTH']) {
                self::updateInvoice($orderId, 'WIDTH="'.$arFields['PP_WIDTH'].'"');
            }

            if (!empty($arFields['PP_HEIGHT']) && $arFields['PP_HEIGHT'] != $oldInvoiceData['HEIGHT']) {
                self::updateInvoice($orderId, 'HEIGHT="'.$arFields['PP_HEIGHT'].'"');
            }

            if (!empty($arFields['PP_DEPTH']) && $arFields['PP_DEPTH'] != $oldInvoiceData['DEPTH']) {
                self::updateInvoice($orderId, 'DEPTH="'.$arFields['PP_DEPTH'].'"');
            }
        }
    }

    /**
     * Метод отправляет в PickPoint заказ
     *
     * @param array $ordersId
     * @return array
     * @throws SystemException
     */
    public function sendInvoice($ordersId)
    {
        $storeData = OrderOptions::getStoreOptionValues();
        $answers = [];

        $arQuery = [
            'SessionId' => $this->sessionId,
            'Sendings' => []
        ];

        foreach ($ordersId as $key => $orderId) {

            $orderData = self::getOrderData($orderId);
            $dimensionsData = $this->getDimensionsData($orderId);
			$goodsData = OrderOptions::getBasketItemsData($orderId);
			
			// Delivery fee
			$deliveryFee = 0;			
			if ($orderData['PRICE'] > 0)
			{
				$goodsPrice = 0;				
				foreach ($goodsData as $item)
					$goodsPrice += $item['Price'] * $item['Quantity'];				
					
				$deliveryFee = floatval($orderData['PRICE'] - $goodsPrice);
				if ($deliveryFee < 0)
					$deliveryFee = 0;				
			}
			
            $arQuery['Sendings'][$key] = [
                'EDTN' => $orderId,
                'IKN' => $storeData['IKN'],
                'Invoice' => [
                    'SenderCode' => $orderId,
                    'Description' => $storeData['ENCLOSURE'],
                    'RecipientName' => $orderData['OPTIONS']['FIO'] ? $orderData['OPTIONS']['FIO'] : $orderData['NAME'],
                    'PostamatNumber' => $orderData['PostamatNumber'],
                    'MobilePhone' => $orderData['PHONE'],
                    'Email' => $orderData['OPTIONS']['EMAIL'] ? $orderData['OPTIONS']['EMAIL'] : $orderData['EMAIL'],
                    'PostageType' => $orderData['PostageType'],
                    'GettingType' => $orderData['GettingType'],
                    'DeliveryVat' => DELIVERY_VAT_ARRAY[$storeData['DELIVERY_VAT']]['VALUE'] ? DELIVERY_VAT_ARRAY[$storeData['DELIVERY_VAT']]['VALUE'] : 0,
					'DeliveryFee' => $deliveryFee,
                    'PayType' => 1,
                    'Sum' => $orderData['PRICE'],
                    'Places' => [
                        0 => [
                            'Width' => $dimensionsData['WIDTH'],
                            'Height' => $dimensionsData['HEIGHT'],
                            'Depth' => $dimensionsData['DEPTH'],
                            'SubEncloses' => $goodsData
                        ]
                    ]
                ]
            ];

            if ($this->checkArrayByEmpty($storeData['returnAddress'])){
                $arQuery['Sendings'][$key]['Invoice']['ClientReturnAddress'] = $storeData['returnAddress'];
                $arQuery['Sendings'][$key]['Invoice']['UnclaimedReturnAddress'] = $storeData['returnAddress'];
            }
        }

        $queryAnswer = self::query('CreateShipment', $arQuery);

        foreach ($queryAnswer['CreatedSendings'] as $createdSending) {
            self::setOrderInvoice(
                $createdSending['EDTN'],
                $createdSending['InvoiceNumber']
            );
            $answers[$createdSending['EDTN']]['STATUS'] = true;
        }

        foreach ($queryAnswer['RejectedSendings'] as $rejectedSending) {
            $rejectedError = self::checkErrors($rejectedSending);
            $answers[$rejectedSending['EDTN']]['STATUS'] = false;

            if ($rejectedError) {
                $answers[$rejectedSending['EDTN']]['ERRORS'][] =  $rejectedError;
            }
        }

        $this->updateAllInvoicesStatus();

        return $answers;
    }

    /**
     * Метод возвращает информацию о заказе
     *
     * @param int $orderId
     * @return array|false
     * @throws SystemException
     */
    private function getOrderData($orderId)
    {
        $orderData = [];
        $order = Order::load($orderId);

        $personType = $order->getPersonTypeId();

        $orderData['OPTIONS'] = OrderOptions::getOrderOptions($orderId, $personType, $this->arOptionDefaults);
        $orderPaySystemId = $order->getPaymentSystemId();

        if (Helper::CheckPPPaySystem($orderPaySystemId[0])) {
            $orderData['PostageType'] = $this->arServiceTypesCodes[1];
            $orderData['PRICE'] = $order->getPrice(); // Сумма заказа
        } else {
            $orderData['PostageType'] = $this->arServiceTypesCodes[0];
            $orderData['PRICE'] = 0;
        }

        $ppData = $this->getInvoiceData($orderId);

        $orderData['PostamatNumber'] = $ppData['POSTAMAT_ID'];
        $orderData['NAME'] = $ppData['NAME'];
        $orderData['EMAIL'] = $ppData['EMAIL'];
        $orderData['PHONE'] = $ppData['SMS_PHONE'] ? $ppData['SMS_PHONE'] : $orderData['OPTIONS']['ADDITIONAL_PHONES'];
        $orderData['GettingType'] = $this->arEnclosingTypesCodes[$_REQUEST['EXPORT'][$orderId]['ENCLOSING_TYPE']];

        return $orderData;
    }

    /**
     * Проверяет ошибки ответа от PickPoint
     *
     * @param $response
     * @return false|string
     */
    private static function checkErrors($response)
    {
        if ($response['ErrorMessage']) {
            if (defined('BX_UTF') && BX_UTF == true) {
                return $response['ErrorMessage'];
            } else {
                return Encoding::convertEncoding(
                    $response['ErrorMessage'],
                    'utf-8',
                    'windows-1251'
                );
            }
        }

        return false;
    }

    /**
     * Проверяет каждое значение масива на пустоту
     *
     * @param array $array
     * @return bool
     */
    private function checkArrayByEmpty($array)
    {
        foreach ($array as $item) {
            if (empty($item)){
                return false;
            }
        }

        return true;
    }

    /**
     * @param int $orderId
     * @return array
     * @throws SystemException
     */
    public static function getDimensionsData($orderId)
    {
        $dimensions = [];
        $invoiceData = self::getInvoiceData($orderId);

        if (!empty($invoiceData['WIDTH'])){
            $dimensions['WIDTH'] = $invoiceData['WIDTH'];
        } else {
            $dimensions['WIDTH'] = Option::get(self::MODULE_ID, 'pp_dimension_width', '50');
        }

        if (!empty($invoiceData['HEIGHT'])){
            $dimensions['HEIGHT'] = $invoiceData['HEIGHT'];
        } else {
            $dimensions['HEIGHT'] = Option::get(self::MODULE_ID, 'pp_dimension_height', '50');
        }

        if (!empty($invoiceData['DEPTH'])){
            $dimensions['DEPTH'] = $invoiceData['DEPTH'];
        } else {
            $dimensions['DEPTH'] = Option::get(self::MODULE_ID, 'pp_dimension_depth', '50');
        }

        return $dimensions;
    }

    /**
     * @throws SystemException
     */
    public function updateAllInvoicesStatus()
    {
        $invoices = self::getAllInvoices();
        $invoicesId = [];
        $statusArray = [];

        foreach ($invoices as $invoice) {
            if ($invoice['PP_INVOICE_ID']) {
                $invoicesId[] = $invoice['PP_INVOICE_ID'];
            }
        }

        $arQuery = [
            'SessionId' => $this->sessionId,
            'Invoices' => $invoicesId
        ];

        $answer = self::query('tracksendings', $arQuery);

        foreach ($answer['Invoices'] as $invoice) {
            if ($invoice['States']) {
                $statusArray[$invoice['SenderInvoiceNumber']] = end($invoice['States']);
            }
        }

        foreach ($invoices as $invoice) {
            if ($invoice['STATUS'] != $statusArray[$invoice['ORDER_ID']]){
                self::updateInvoice($invoice['ORDER_ID'], 'STATUS="'.$statusArray[$invoice['ORDER_ID']]['State'].'"');
            }
        }
    }

    /**
     * @param $orderId
     * @throws \Bitrix\Main\Db\SqlQueryException
     */
    public function changeArchiveStatus($orderId)
    {
        $invoiceData = self::getInvoiceData($orderId);

        if ($invoiceData['ARCHIVE']) {
            self::updateInvoiceArchiveStatus($orderId , 0);
        } else {
            self::updateInvoiceArchiveStatus($orderId , 1);
        }
    }
}