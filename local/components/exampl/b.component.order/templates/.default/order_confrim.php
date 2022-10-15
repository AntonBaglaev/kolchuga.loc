<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?php

//Оформление заказа

use Bitrix\Main\Application;
use Bitrix\Sale\Order;
use Bitrix\Sale\Basket;
use Bitrix\Main\UserTable;
use Bitrix\Sale\Delivery\Services;
use Bitrix\Main\Loader;
use Bitrix\Sale\Delivery\Services\Manager;
use Bitrix\Sale\PaySystem\Manager as PaySystemManager;
use Bitrix\Main\Localization\Loc;

$request = Application::getInstance()->getContext()->getRequest();

if ($request->isPost()) {

    if (Loader::includeModule('sale') && Loader::includeModule('catalog')) {

        $arResult = [];
        $arOrderItems = $_SESSION['ORDER_ITEMS'];

        //Обязательные
        $userId = $USER->GetID();
        $locationId = getLocation('ru'); //Россия
        $userType = getUserType('fiz'); //Физическое лицо
        $siteId = SITE_ID;

        $userName = trim(strip_tags($request->getPost('USER_NAME')));
        $userLastName = trim(strip_tags($request->getPost('USER_LAST_NAME')));
        $userSecondName = trim(strip_tags($request->getPost('USER_SECOND_NAME')));
        $userFullName = $userLastName . ' ' . $userName . ' ' . $userSecondName;

        $userPhone = trim(strip_tags($request->getPost('PROPERTY_PHONE')));
        $userEmail = trim(strip_tags($request->getPost('PROPERTY_EMAIL')));
        $userCityName = trim(strip_tags($request->getPost('LOCATION_CITY')));
        $userCityId = trim(strip_tags($request->getPost('LOCATION_CITY_ID')));

        $deliveryId = trim(strip_tags($request->getPost('DELIVERY_ID')));
        $deliveryType = trim(strip_tags($request->getPost('delivery')));
        $userAddress = trim(strip_tags($request->getPost('DELIVERY_ADDRESS')));
        $userStreet = trim(strip_tags($request->getPost('DELIVERY_STREET')));
        $userHouse = trim(strip_tags($request->getPost('DELIVERY_HOUSE')));
        $userAddressHouse = trim(strip_tags($request->getPost('HOUSE')));

        $userDistrict = trim(strip_tags($request->getPost('DELIVERY_DISTRICT')));

        $orderDeliveryPrice = $_SESSION['DELIVERY_PRICE'];
        $tariffId = trim(strip_tags($request->getPost('DELIVERY_TARIFFID')));

        $yaDeliveryId = trim(strip_tags($request->getPost('YA_DELIVERY_ID')));
        $yaPointId = trim(strip_tags($request->getPost('YA_POINT_ID')));
        $yaPointInfo = trim(strip_tags($request->getPost('YA_POINT_INFO')));

        $paySystemId = trim(strip_tags($request->getPost('PAY_SYSTEM_ID')));

        //Не обязательные
        $userComment = trim(strip_tags($request->getPost('PROPERTY_COMMENT')));
        $deliveryDate = trim(strip_tags($request->getPost('DELIVERY_DATE')));
        $deliveryService = trim(strip_tags($request->getPost('YA_POINT_INFO')));

        $deliveryServiceName = '';
        $orderPrice = '';

        //Проверяем
        if (empty($userName)) {

            $arResult['errors'][] = Loc::getMessage("userName");

        }

        if (empty($userLastName)) {

            $arResult['errors'][] = Loc::getMessage("userLastName");

        }

        if (empty($userSecondName)) {

            $arResult['errors'][] = Loc::getMessage("userSecondName");

        }

        if (empty($userPhone)) {

            $arResult['errors'][] = Loc::getMessage("userPhone");

        }

        if (empty($userEmail) || !check_email($userEmail)) {

            $arResult['errors'][] = Loc::getMessage("userEmail");

        }

        if (empty($userCityName) || empty($userCityId)) {

            $arResult['errors'][] = Loc::getMessage("userCityName");

        }

        if (empty($deliveryType) || empty($deliveryId)) {

            $arResult['errors'][] = Loc::getMessage("deliveryType");

        } else {

            if ($deliveryType == 'courier' && empty($userAddress)) {

                $arResult['errors'][] = Loc::getMessage("userAddress");

            }

        }

        if (empty($paySystemId)) {

            $arResult['errors'][] = Loc::getMessage("paySystem");

        }

        //Курьерская доставка
        if (in_array($deliveryId, getExpressDelivery()) && empty($userAddressHouse)) {

            $arResult['errors'][] = Loc::getMessage("userAddressHouse");

        }

        //Идентификатор службы доставки
        if ($userCityId != getCity() && empty($tariffId)) {

            $arResult['errors'][] = Loc::getMessage("userDelivery");

        } else {

            if (!in_array($deliveryId, getExpressDelivery()) && empty($tariffId)) {

                $arResult['errors'][] = Loc::getMessage("userDelivery");

            }

        }

        //Получаем активные службы доставки
        $deliveryRes = Services\Table::getList([
            'filter' => ['ACTIVE' => 'Y'],
        ]);

        while ($delivery = $deliveryRes->fetch()) {

            $arDeliveryServices[$delivery['ID']] = $delivery['NAME'];

        }

        //Регистрация пользователя
        if (empty($arResult['errors']) && empty($userId)) {

            //Ищем пользователя по Email
            $arUserFilter = [
                'select' => [
                    'ID',
                    'EMAIL',
                ],
                'filter' => [
                    '=EMAIL' => $userEmail,
                ],
                'order' => [
                    'ID' => 'ASC',
                ],
                'limit' => 1,
            ];

            $arUser = UserTable::getList($arUserFilter)->fetch();

            if (!empty($arUser['ID'])) {

                global $USER;
                $password = randString(7);
                $doplogin = time();
                $userRegister = $USER->Register($userEmail . '_' . $doplogin, $userName, $userLastName, $password, $password, $userEmail);

                if ($userRegister['TYPE'] == 'ERROR') {

                    $arResult['errors'][] = Loc::getMessage("userRegister");

                } else {

                    $userId = $USER->GetID();

                }

            } else {

                global $USER;
                $password = randString(7);
                $userRegister = $USER->Register($userEmail, $userName, $userLastName, $password, $password, $userEmail);

                if ($userRegister['TYPE'] == 'ERROR') {

                    $arResult['errors'][] = Loc::getMessage("userRegister");

                } else {

                    $userId = $USER->GetID();

                }

            }

        }

        //Оформляем заказ
        if (empty($arResult['errors']) && !empty($userId)) {

            //Корзина пользователя
            $basketItems = Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), $siteId)->getOrderableItems();

            //Проверяем корзину
            if (empty($basketItems)) {

                $arResult['errors'][] = Loc::getMessage("basketItems");

            }

            //Продолжаем оформление заказа
            if (empty($arResult['errors'])) {

                //Создаем заказ для пользователя
                $order = Order::create($siteId, $USER->GetID());

                //Устанавливаем тип плательщика
                $order->setPersonTypeId($userType);

                //Привязываем корзину к заказу
                $order->setBasket($basketItems);

                //Создание отгрузки
                $shipmentCollection = $order->getShipmentCollection();

                //Доставка курьером по Москве
                if ($userCityId == getCity('moscow') && $deliveryId == getDelivery('courier')) {

                    $deliveryServiceName = $arDeliveryServices[getDeliveryServices('courier')];
                    $shipment = $shipmentCollection->createItem(Manager::getObjectById(getDeliveryServices('courier')));

                } else {

                    $deliveryServiceName = $arDeliveryServices[$deliveryId];
                    $shipment = $shipmentCollection->createItem(Manager::getObjectById($deliveryId));

                }

                $shipmentItemCollection = $shipment->getShipmentItemCollection();
                foreach ($basket as $basketItem) {

                    $item = $shipmentItemCollection->createItem($basketItem);
                    $item->setQuantity($basketItem->getQuantity());

                }

                //Стоимость доставки
                $shipment->setField('PRICE_DELIVERY', $orderDeliveryPrice);

                //Создание оплаты
                $paymentCollection = $order->getPaymentCollection();
                $payment = $paymentCollection->createItem(PaySystemManager::getObjectById($paySystemId));
                $payment->setField('SUM', $order->getPrice());
                $payment->setField('CURRENCY', $order->getCurrency());

                //Стоимость товаров
                $orderPrice = $order->getPrice();

                //Личные данные
                $propertyCollection = $order->getPropertyCollection();

                $PROP_EMAIL = $propertyCollection->getItemByOrderPropertyId(getOrderProperty('email')); //E-Mail
                $PROP_EMAIL->setValue($userEmail);
                $PROP_PHONE = $propertyCollection->getItemByOrderPropertyId(getOrderProperty('phone')); //Телефон
                $PROP_PHONE->setValue($userPhone);
                $PROP_LOCATION = $propertyCollection->getItemByOrderPropertyId(getOrderProperty('location')); //Местоположение
                $PROP_LOCATION->setValue(getOrderProperty('location_code')); //Россия, Центр, Московская область, Москва

                //Данные для доставки
                $PROP_FIO = $propertyCollection->getItemByOrderPropertyId(getOrderProperty('name')); //Имя
                $PROP_FIO->setValue($userFullName);

                //Яндекс.Доставка
                $PROP_YANDEX_LOCALITY = $propertyCollection->getItemByOrderPropertyId(getOrderProperty('yandex_location')); //Населенный пункт
                $PROP_YANDEX_LOCALITY->setValue($userCityName);

                $PROP_YANDEX_ORDER_ID = $propertyCollection->getItemByOrderPropertyId(getOrderProperty('yandex_order')); //Идентификатор заказа
                $PROP_YANDEX_ORDER_ID->setValue('none');

                $PROP_YANDEX_DELIVERY_SERVICE = $propertyCollection->getItemByOrderPropertyId(getOrderProperty('yandex_delivery')); //Служба доставки
                $PROP_YANDEX_DELIVERY_SERVICE->setValue($deliveryServiceName);

                //Курьерская доставка
                if (in_array($deliveryId, getExpressDelivery())) {

                    $PROP_YANDEX_DELIVERY_ADDRESS = $propertyCollection->getItemByOrderPropertyId(getOrderProperty('yandex_address')); //Адрес доставки
                    $PROP_YANDEX_DELIVERY_ADDRESS->setValue($userAddress);
                    $YANDEX_DELIVERY_ADDRESS_HOUSE = $propertyCollection->getItemByOrderPropertyId(getOrderProperty('yandex_house')); //Номер квартиры
                    $YANDEX_DELIVERY_ADDRESS_HOUSE->setValue($userAddressHouse);

                    //Доставка курьером по Москве
                    if (empty($deliveryDate) && $userCityId == getCity('moscow')) {

                        $deliveryDate = strtotime("+1 day");
                        $deliveryDate = date("d.m.Y", $deliveryDate);

                        $PROP_YANDEX_DELIVERY_DATE = $propertyCollection->getItemByOrderPropertyId(getOrderProperty('yandex_date')); //Желаемая дата доставки
                        $PROP_YANDEX_DELIVERY_DATE->setValue($deliveryDate);

                    } else {

                        $PROP_YANDEX_DELIVERY_DATE = $propertyCollection->getItemByOrderPropertyId(getOrderProperty('yandex_date')); //Желаемая дата доставки
                        $PROP_YANDEX_DELIVERY_DATE->setValue($deliveryDate);

                    }

                } else {

                    $PROP_YANDEX_DELIVERY_ADDRESS = $propertyCollection->getItemByOrderPropertyId(getOrderProperty('yandex_address')); //Адрес доставки
                    $PROP_YANDEX_DELIVERY_ADDRESS->setValue($deliveryService);

                }

                //Дополнительная информация
                $order->setField('USER_DESCRIPTION', $userComment); //Комментарий пользователя

                //Сохраняем заказ
                $order->doFinalAction(true);
                $result = $order->save();
                $orderId = $order->getId();

                //Проверяем
                if (!empty($orderId)) {

                    $arResult['successes'] = $orderId;

                } else {

                    $arResult['errors'][] = Loc::getMessage("orderError");

                }

            }

        }

    }

    echo json_encode($arResult, true);

}

?>
