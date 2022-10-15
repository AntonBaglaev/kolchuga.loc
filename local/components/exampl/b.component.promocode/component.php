<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Sale\Internals\DiscountCouponTable;
use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Main\Web\Cookie;
use Bitrix\Main\Type\DateTime;

$request = Application::getInstance()->getContext()->getRequest();

//Получаем Cookie
$coupon404 = $request->getCookie('COUPON_404');

$arResult['COUPON'] = '';
$arResult['TIME'] = '';

if (Loader::includeModule('sale') && !empty($arParams['DISCOUNT_ID'])) {

    $arDiscountInfo = CSaleDiscount::GetByID($arParams['DISCOUNT_ID']);

    //Проверяем правило корзины
    if ($arDiscountInfo['ACTIVE'] == 'Y') {

        if (!empty($coupon404)) {

            $arCouponInfo = DiscountCouponsManager::getData($coupon404, true);

            //Проверяем купон
            if ($arCouponInfo['ACTIVE'] == 'Y') {

                //Дата активности купона
                $activeFrom = time();
                $activeTo = MakeTimeStamp($arCouponInfo['SYSTEM_DATA']['ACTIVE_TO'], 'DD.MM.YYYY HH:MI:SS');

                $arResult['COUPON'] = $coupon404;
                $arResult['TIME'] = $activeTo - $activeFrom;

            } else {

                $coupon404 = '';

            }

        }

        if (empty($coupon404)) {

            //Добавляем новый купон
            if ($arParams['COUPON_ADD'] == 'Y' && !empty($arParams['COUPON_ACTION_DAY']) && !empty($arParams['COUPON_ACTION_COUNT'])) {

                $coupon404 = DiscountCouponTable::generateCoupon(true);

                if (!empty($coupon404)) {

                    //Дата активности купона
                    $activeFrom = new DateTime();
                    $activeTo = new DateTime();
                    $activeTo = $activeTo->add($arParams['COUPON_ACTION_DAY'] . ' day');

                    $arCouponFields = [
                        'COUPON' => $coupon404,
                        'DISCOUNT_ID' => $arParams['DISCOUNT_ID'],
                        'ACTIVE_FROM' => $activeFrom,
                        'ACTIVE_TO' => $activeTo,
                        'TYPE' => DiscountCouponTable::TYPE_ONE_ORDER,
                        'MAX_USE' => $arParams['COUPON_ACTION_COUNT'],
                        'DESCRIPTION' => trim(strip_tags($_SERVER['HTTP_REFERER'])),
                    ];

                    $couponResult = DiscountCouponTable::Add($arCouponFields);

                    if ($couponResult->isSuccess()) {

                        $serverName = Option::get('main', 'server_name');

                        if (!empty($serverName)) {

                            $cookie = new Cookie('COUPON_404', $coupon404, time() + (86400 * $arParams['COUPON_ACTION_DAY']));
                            $cookie->setSpread(Cookie::SPREAD_DOMAIN);
                            $cookie->setDomain($serverName);
                            $cookie->setPath('/');
                            $cookie->setSecure(false);
                            $cookie->setHttpOnly(false);

                            Application::getInstance()->getContext()->getResponse()->addCookie($cookie);

                            $arResult['COUPON'] = $coupon404;
                            $arResult['TIME'] = 86400 * $arParams['COUPON_ACTION_DAY'];

                        } else {

                            file_put_contents(__DIR__ . '/log.txt', 'Не установлено поле "URL сервера" в настройках текущего сайта' . "\n", FILE_APPEND);

                        }

                    } else {

                        file_put_contents(__DIR__ . '/log.txt', 'Не удалось добавить новый купон ' . $couponResult->getErrorMessages() . "\n", FILE_APPEND);

                    }

                }

            }

        }

        //Удаляем активные купоны c истекшим периодом активности
        if ($arParams['COUPON_DELETE'] == 'Y' && !empty($arParams['COUPON_DELETE_COUNT'])) {

            $resDiscountCouponTable = DiscountCouponTable::getList([
                'select' => [
                    'ID',
                ],
                'filter' => [
                    'DISCOUNT_ID' => $arParams['DISCOUNT_ID'],
                    'ACTIVE' => 'Y',
                    '<ACTIVE_TO' => new DateTime(), //Активен до, меньше текущей даты
                ],
                'order' => ['ACTIVE_TO' => 'DESC'],
                'limit' => $arParams['COUPON_DELETE_COUNT'],
            ]);

            while ($arDiscountCouponTable = $resDiscountCouponTable->Fetch()) {

                //Удаляем купон
                DiscountCouponTable::delete($arDiscountCouponTable['ID']);

            }

        }

    }

}

//Подключаем шаблон
$this->IncludeComponentTemplate();

?>