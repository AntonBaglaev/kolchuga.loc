<?php
/**
 * User: dimasik142
 * Email: ivanov.dmytro.ua@gmail.com
 * Date: 05.09.2018
 * Time: 18:31
 */

namespace PickPoint;

use CSaleOrderProps,
    CSaleLocation,
    \Bitrix\Main\Service\GeoIp,
    \Bitrix\Main\Config\Option,
    Bitrix\Main\Localization\Loc,
    \Bitrix\Sale\Location\LocationTable;

Loc::loadMessages(__FILE__);

/**
 * Class Helper
 * @package PickPoint
 */
class Helper
{
    const MODULE_ID = 'pickpoint.deliveryservice';

    /**
     * метод возвращает масив свойств заказа
     *
     * @param bool $isLocation
     * @return array
     */
    public static function getOrderProps($isLocation = false)
    {
        $arAllProps = [];
        $arUTAllProps = [];

        $arFilter = [
            'ACTIVE' => 'Y',
        ];

        if ($isLocation) {
            $arFilter = array_merge($arFilter, [
                'IS_LOCATION' => 'Y'
            ]);
        }

        $hProps = CSaleOrderProps::GetList(
            [
                'SORT' => 'ASC'
            ],
            $arFilter,
            false,
            false,
            []
        );

        while ($row = $hProps->Fetch()) {
            $arAllProps[$row['ID']] = $row;
            $arUTAllProps[$row['PERSON_TYPE_ID']][$row['ID']] = $row;
        }

        return [
            'ALL_PROPS' => $arAllProps,
            'PERSON_PROPS' => $arUTAllProps
        ];
    }

    /**
     * Метод проверяет наличие города в файле cities.csv
     *
     * @param mixed $location Bitrix location ID or code
     * @return array
     */
    public static function checkPPCityAvailable($location)
    {
        $locationData = LocationTable::getList(
            [
                'filter' => [
                    [
                        'LOGIC' => 'OR',
                        'CODE' => $location,
                        'ID' => $location,
                    ],
                    '=NAME.LANGUAGE_ID' => LANGUAGE_ID
                ],
                'select' => [
                    'NAME_RU' => 'NAME.NAME'
                ]
            ]
        )->fetchAll()[0];

        if (self::isCityAvailable($locationData['NAME_RU'])
        ) {
            return [
                'STATUS' => true,
                'DATA' => $locationData
            ];
        } else {
            return [
                'STATUS' => false
            ];
        }
    }

    /**
     * Метод возвращает англ название города из cities.csv
     *
     * @param string $ruCityNameOrig
     * @param string $ruCityNameLang
     * @return false|string
     */
    public static function getEngCityName($ruCityNameOrig, $ruCityNameLang = '')
    {
        if (($citiesHandle = fopen($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/pickpoint.deliveryservice/cities.csv', 'r'))
            !== false
        ) {
            while (($row = fgets($citiesHandle)) !== false) {
                $data = explode(';', $row);
                if ($ruCityNameOrig == $data[1] || $ruCityNameLang == $data[1]) {
                    return $data[2];
                }
            }
            fclose($citiesHandle);
        }
        return false;
    }

    /**
     * Метод возвращает id адрес определяя по геолокации
     *
     * @return int
     */
    public static function getLocationIdByGeoPosition()
    {
        $ipAddress = GeoIp\Manager::getRealIp();

        return \Bitrix\Sale\Location\GeoIp::getLocationId($ipAddress);
    }

    /**
     * Проверка на наличие города в файле cities.csv
     *
     * @param string $cityName
     * @return bool
     */
    public static function isCityAvailable($cityName)
    {
        if (($citiesHandle = fopen($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/pickpoint.deliveryservice/cities.csv', 'r'))
            !== false
        ) {
            $convertedCityName = str_replace(
                Loc::getMessage('EPP_E'),
                Loc::getMessage('EPP_E_CONVERTED'),
                $cityName
            );

            while (($row = fgets($citiesHandle)) !== false) {
                $data = explode(';', $row);
                if ($cityName == $data[1] || $convertedCityName == $data[1]) {
                    return true;
                }
            }
            fclose($citiesHandle);
        }

        return false;
    }

    /**
     * @param int $paySystemId
     * @return bool
     * @throws \Bitrix\Main\SystemException
     */
    public static function checkPPPaySystem($paySystemId)
    {
        $dbRes = \Bitrix\Sale\Internals\PaySystemActionTable::getList(
            [
                'filter' => [
                    'ID' => $paySystemId,
                ],
                'select' => [
                    'ACTION_FILE'
                ]

            ]
        );

        if ($arPaySystem = $dbRes->fetch()) {
            if (substr_count($arPaySystem['ACTION_FILE'], 'pickpoint.deliveryservice')) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $value
     * @throws \Bitrix\Main\SystemException
     */
    public static function setPageElementsCount($value = 50)
    {
        Option::set(self::MODULE_ID, 'show_elements_count', $value);
    }
}