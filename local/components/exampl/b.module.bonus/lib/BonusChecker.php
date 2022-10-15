<?php

namespace Bonus\Program;

use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use Bitrix\Highloadblock\HighloadBlockTable;

Loc::loadMessages(__FILE__);

class BonusChecker
{

    //Настройки модуля
    public static $MODULE_ID = 'bonus.program';
    public static $MODULE_EVENT_NAME = 'BONUS_MODULE_MAIL';
    public static $MODULE_AGENT_FUNCTION = '\Bonus\Program\BonusChecker::checkBonusExpired();';

    //Настройки бонусного счета
    public static $BONUS_CURRENCY = 'RUB';
    public static $BONUS_BALANCE = 0;
    public static $BONUS_TYPE_ZERO = 'ZERO';
    public static $BONUS_TYPE_PLUS = 'PLUS';
    public static $BONUS_TYPE_MINUS = 'MINUS';
    public static $BONUS_TYPE_ZERO_DETAIL = 'Сгорание бонусного баланса';
    public static $BONUS_TYPE_PLUS_DETAIL = 'Пополнение бонусного баланса';
    public static $BONUS_TYPE_MINUS_DETAIL = 'Списание бонусного баланса';
    public static $BONUS_PROGRAM_HIGHLOADBLOCK = 'BonusProgram';

    /**
     * Проверяет дату последней транзакции на счете, сгорание бонусов
     * @return string
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     */
    public static function checkBonusExpired()
    {

        $bonusActive = Option::get(self::$MODULE_ID, 'BONUS_ACTIVE');
        $agentActive = Option::get(self::$MODULE_ID, 'AGENT_ACTIVE');
        $agentInterval = Option::get(self::$MODULE_ID, 'AGENT_INTERVAL');
        $bonusInterval = Option::get(self::$MODULE_ID, 'BONUS_INTERVAL');
        $bonusNotification = Option::get(self::$MODULE_ID, 'BONUS_NOTIFICATION');
        $bonusPercent = Option::get(self::$MODULE_ID, 'BONUS_PERCENT');
        $bonusProduct = Option::get(self::$MODULE_ID, 'BONUS_PRODUCT');

        if (Loader::includeModule('sale') && $agentActive == 'Y' && $bonusActive == 'Y') {

            //Срок действия бонусных баллов
            $dateNotification = date('d.m.Y H:i:s', time() - (($bonusInterval - $bonusNotification) * 86400));
            $dateExpired = date('d.m.Y H:i:s', time() - ($bonusInterval * 86400));

            $stmpNotification = MakeTimeStamp($dateNotification, 'DD.MM.YYYY HH:MI:SS');
            $stmpExpired = MakeTimeStamp($dateExpired, 'DD.MM.YYYY HH:MI:SS');

            $arOrder = ['TIMESTAMP_X' => 'ASC'];
            $arSelect = [
                '*',
            ];
            $arFilter = [
                'ACTIVE' => 'Y',
                '>CURRENT_BUDGET' => self::$BONUS_BALANCE,
                '<=TIMESTAMP_X' => $dateNotification,
            ];

            $res = \CSaleUserAccount::GetList($arOrder, $arFilter, false, false, $arSelect);
            while ($arRes = $res->Fetch()) {

                //Дата последнего изменения
                $dateUpdate = MakeTimeStamp($arRes['TIMESTAMP_X'], 'DD.MM.YYYY HH:MI:SS');

                //Дата сгорания бонусного счета
                $dateExpiredDeadline = date('d.m.Y H:i:s', $dateUpdate + ($bonusInterval * 86400));

                if (($dateUpdate <= $stmpNotification) && ($dateUpdate >= $stmpExpired)) {

                    //Отправляем уведомление
                    self::sendNotification($arRes, self::getEmployeeInfo($arRes['USER_ID']), $dateExpiredDeadline);

                } else {

                    //Обнуляем бонусный счет
                    self::updateBonusAccount($arRes, self::$BONUS_TYPE_ZERO, $arRes['CURRENT_BUDGET']);

                }

            }

        }

        return self::$MODULE_AGENT_FUNCTION;

    }

    /**
     * Создает новый счет пользователя, по ID пользователя
     * @param $userId
     * @return bool|int
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     */
    public static function newBonusAccount($userId)
    {

        $bonusActive = Option::get(self::$MODULE_ID, 'BONUS_ACTIVE');

        $result = false;

        if (Loader::includeModule('sale') && $bonusActive == 'Y') {

            if (!empty($userId)) {

                $arFields = [
                    'USER_ID' => $userId,
                    'CURRENCY' => self::$BONUS_CURRENCY,
                    'CURRENT_BUDGET' => self::$BONUS_BALANCE,
                ];

                $accountId = \CSaleUserAccount::Add($arFields);

                if (!empty($accountId)) {

                    $result = $accountId;

                }

            }

        }

        return $result;

    }

    /**
     * Возвращает параметры счета пользователя, по ID пользователя
     * @param $userId
     * @return array|bool|mixed
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     */
    public static function checkBonusAccount($userId)
    {

        $bonusActive = Option::get(self::$MODULE_ID, 'BONUS_ACTIVE');

        $arResult = [];

        if (Loader::includeModule('sale') && $bonusActive == 'Y') {

            if (!empty($userId)) {

                $arResult = \CSaleUserAccount::GetByUserID($userId, self::$BONUS_CURRENCY);

            }

        }

        return $arResult;

    }

    /**
     * Изменяет сумму на бонусном счете пользователя
     * @param $arAccount
     * @param $type
     * @param $amount
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     */
    public static function updateBonusAccount($arAccount, $type, $amount)
    {

        $bonusActive = Option::get(self::$MODULE_ID, 'BONUS_ACTIVE');

        if (Loader::includeModule('sale') && $bonusActive == 'Y') {

            if (!empty($arAccount) && !empty($type)) {

                if ($type == 'PLUS') {

                    //Пополнение
                    $arFields = [
                        'userID' => $arAccount['USER_ID'],
                        'currency' => self::$BONUS_CURRENCY,
                        'sum' => $amount,
                        'description' => self::$BONUS_TYPE_PLUS_DETAIL,
                        'orderID' => $arAccount['ORDER_ID'],
                    ];

                } else if ($type == 'MINUS') {

                    //Списание
                    $arFields = [
                        'userID' => $arAccount['USER_ID'],
                        'currency' => self::$BONUS_CURRENCY,
                        'sum' => '-' . $amount,
                        'description' => self::$BONUS_TYPE_MINUS_DETAIL,
                    ];

                } else {

                    //Обнуление
                    $arFields = [
                        'userID' => $arAccount['USER_ID'],
                        'currency' => self::$BONUS_CURRENCY,
                        'sum' => '-' . $amount,
                        'description' => self::$BONUS_TYPE_ZERO_DETAIL,
                    ];

                }

                if (!empty($arFields)) {

                    \CSaleUserAccount::UpdateAccount($arFields['userID'], $arFields['sum'], $arFields['currency'], $arFields['description'], $arFields['orderID']);

                }

            }

        }

    }

    /**
     * Отправляет почтовое уведомление о предстоящем сгорании бонусов
     * @param $arAccount
     * @param $arUser
     * @param $dateExpired
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    public static function sendNotification($arAccount, $arUser, $dateExpired)
    {

        $bonusActive = Option::get(self::$MODULE_ID, 'BONUS_ACTIVE');

        if ($bonusActive == 'Y') {

            $arEventFields = [
                'EMAIL' => $arUser['EMAIL'],
                'CLIENT_SUBJECT' => self::$BONUS_TYPE_ZERO_DETAIL,
                'CLIENT_MESSAGE' => self::$BONUS_TYPE_ZERO_DETAIL,
                'CURRENT_BUDGET' => $arAccount['CURRENT_BUDGET'],
                'DATE_EXPIRED' => $dateExpired,
            ];

            \CEvent::SendImmediate(self::$MODULE_EVENT_NAME, 's1', $arEventFields, 'N');

        }

    }

    /**
     * Возвращает контактную информацию по ID пользователя
     * @param $arEmployeeId
     * @return array
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    public static function getEmployeeInfo($arEmployeeId)
    {

        $bonusActive = Option::get(self::$MODULE_ID, 'BONUS_ACTIVE');

        $arResult = [];

        if (!empty($arEmployeeId) && $bonusActive == 'Y') {

            $rsUsers = \CUser::GetList(
                $by = 'id',
                $order = 'asc',
                ['ID' => implode('|', $arEmployeeId)],
                ['FIELDS' => ['ID', 'EMAIL']]
            );

            while ($arEmployee = $rsUsers->Fetch()) {

                $arResult = $arEmployee;

            }

        }

        return $arResult;

    }

    /**
     * Рассчитывает сумму бонусных баллов по ID заказа
     * @param $order
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function getBonusAmount($order)
    {

        $bonusActive = Option::get(self::$MODULE_ID, 'BONUS_ACTIVE');
        $bonusPercent = Option::get(self::$MODULE_ID, 'BONUS_PERCENT');
        $bonusProductSetting = Option::get(self::$MODULE_ID, 'BONUS_PRODUCT');

        if (!empty($bonusPercent) && $bonusActive == 'Y') {

            if (Loader::includeModule('catalog') && Loader::includeModule('sale')) {

                $bonusTotal = 0;
                $bonusProduct = 0;
                $bonusOrder = 0;

                $orderId = $order->getField('ID');
                $userId = $order->getUserId();
                $orderStatus = $order->getField('STATUS_ID');

                $orderPrice = $order->getPrice();
                $bonusOrder = ($orderPrice / 100) * $bonusPercent;

                //Бонусные баллы отдельно за каждый товар
                if ($bonusProductSetting == 'Y') {

                    $arProductId = [];

                    $arBasket = $order->getBasket()->getBasketItems();

                    foreach ($arBasket as $item) {

                        $arProductId[] = $item->getProductId();

                    }

                    if (!empty($arProductId)) {

                        $arOrder = ['ID' => 'DESC'];
                        $arSelect = [
                            'PROPERTY_BONUS_POINTS',
                        ];
                        $arFilter = [
                            'ACTIVE' => 'Y',
                            'ID' => $arProductId,
                            '!PROPERTY_BONUS_POINTS' => false,
                        ];

                        $res = \CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
                        while ($arRes = $res->Fetch()) {

                            $bonusProduct += $arRes['PROPERTY_BONUS_POINTS_VALUE'];

                        }

                    }

                }

                //Общее колличество бонусов
                $bonusTotal = round($bonusOrder + $bonusProduct, 2);

                if (!empty($bonusTotal)) {

                    $arBonusInfo = self::getOrderBonusInfo($orderId);

                    if (empty($arBonusInfo)) {

                        self::addOrderBonusInfo([
                            'ORDER_ID' => $orderId,
                            'USER_ID' => $userId,
                            'BONUS_AMOUNT' => $bonusTotal,
                        ]);

                    } else {

                        if ($orderStatus == 'F' && empty($arBonusInfo['UF_DATE_APPLY'])) {

                            self::updateOrderBonusInfo([
                                'ID' => $arBonusInfo['ID'],
                                'ORDER_ID' => $orderId,
                                'USER_ID' => $userId,
                                'BONUS_AMOUNT' => $bonusTotal,
                                'DATE_NOTIFICATION' => $arBonusInfo['UF_DATE_NOTIFICATION'],
                                'DATE_APPLY' => ConvertTimeStamp(time(), 'SHORT'),
                            ]);

                            //Начисление бонусных баллов
                            self::updateBonusAccount(['USER_ID' => $userId, 'ORDER_ID' => $orderId], self::$BONUS_TYPE_PLUS, $bonusTotal);

                        } else {

                            self::updateOrderBonusInfo([
                                'ID' => $arBonusInfo['ID'],
                                'ORDER_ID' => $orderId,
                                'USER_ID' => $userId,
                                'BONUS_AMOUNT' => $bonusTotal,
                                'DATE_NOTIFICATION' => $arBonusInfo['UF_DATE_NOTIFICATION'],
                                'DATE_APPLY' => $arBonusInfo['UF_DATE_APPLY'],
                            ]);

                        }

                    }

                }

            }

        }

    }

    /**
     * Добавляет информацию о колличестве бонусных баллов по ID заказа
     * @param $arOrder
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function addOrderBonusInfo($arOrder)
    {

        $bonusActive = Option::get(self::$MODULE_ID, 'BONUS_ACTIVE');

        if (Loader::includeModule('highloadblock') && $bonusActive == 'Y') {

            $hlbl = HighloadBlockTable::getList([
                'select' => [
                    'ID',
                ],
                'filter' => ['=NAME' => self::$BONUS_PROGRAM_HIGHLOADBLOCK],
                'limit' => 1,
                'cache' => ['ttl' => 86400],
            ])->fetch()['ID'];

            if (!empty($hlbl) && !empty($arOrder)) {

                $hlblock = HighloadBlockTable::getById($hlbl)->fetch();
                $entity = HighloadBlockTable::compileEntity($hlblock);
                $entityDataClass = $entity->getDataClass();

                $arData = [
                    'UF_ORDER_ID' => $arOrder['ORDER_ID'],
                    'UF_USER_ID' => $arOrder['USER_ID'],
                    'UF_BONUS_AMOUNT' => $arOrder['BONUS_AMOUNT'],
                    'UF_DATE_NOTIFICATION' => $arOrder['DATE_NOTIFICATION'],
                    'UF_DATE_APPLY' => $arOrder['DATE_APPLY'],

                ];

                $entityDataClass::add($arData);

            }

        }

    }

    /**
     * Обновляет информацию о колличестве бонусных баллов по ID заказа
     * @param $arOrder
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function updateOrderBonusInfo($arOrder)
    {

        $bonusActive = Option::get(self::$MODULE_ID, 'BONUS_ACTIVE');

        if (Loader::includeModule('highloadblock') && $bonusActive == 'Y') {

            $hlbl = HighloadBlockTable::getList([
                'select' => [
                    'ID',
                ],
                'filter' => ['=NAME' => self::$BONUS_PROGRAM_HIGHLOADBLOCK],
                'limit' => 1,
                'cache' => ['ttl' => 86400],
            ])->fetch()['ID'];

            if (!empty($hlbl) && !empty($arOrder)) {

                $hlblock = HighloadBlockTable::getById($hlbl)->fetch();
                $entity = HighloadBlockTable::compileEntity($hlblock);
                $entityDataClass = $entity->getDataClass();

                $arData = [
                    'UF_ORDER_ID' => $arOrder['ORDER_ID'],
                    'UF_USER_ID' => $arOrder['USER_ID'],
                    'UF_BONUS_AMOUNT' => $arOrder['BONUS_AMOUNT'],
                    'UF_DATE_NOTIFICATION' => $arOrder['DATE_NOTIFICATION'],
                    'UF_DATE_APPLY' => $arOrder['DATE_APPLY'],
                ];

                $entityDataClass::update($arOrder['ID'], $arData);

            }

        }

    }

    /**
     * Возвращает информацию о колличестве бонусных баллов по ID заказа
     * @param $orderId
     * @return array|false
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function getOrderBonusInfo($orderId)
    {

        $bonusActive = Option::get(self::$MODULE_ID, 'BONUS_ACTIVE');

        $arResult = [];

        if (Loader::includeModule('highloadblock') && $bonusActive == 'Y') {

            $hlbl = HighloadBlockTable::getList([
                'select' => [
                    'ID',
                ],
                'filter' => ['=NAME' => self::$BONUS_PROGRAM_HIGHLOADBLOCK],
                'limit' => 1,
                'cache' => ['ttl' => 86400],
            ])->fetch()['ID'];

            if (!empty($hlbl) && !empty($orderId)) {

                $hlblock = HighloadBlockTable::getById($hlbl)->fetch();
                $entity = HighloadBlockTable::compileEntity($hlblock);
                $entityDataClass = $entity->getDataClass();

                $arOrder = [
                    'ID' => 'ASC',
                ];
                $arSelect = [
                    '*',
                ];
                $arFilter = [
                    '=UF_ORDER_ID' => $orderId,
                ];

                $rsData = $entityDataClass::getList(['select' => $arSelect, 'filter' => $arFilter, 'limit' => 1, 'order' => $arOrder]);
                while ($arRes = $rsData->fetch()) {

                    $arResult = $arRes;

                }

            }

        }

        return $arResult;

    }

}

?>