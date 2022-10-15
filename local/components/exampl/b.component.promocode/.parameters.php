<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php

use Bitrix\Main\Loader;
use Bitrix\Sale\Internals\DiscountTable;

$arDiscountTableList[] = 'Не выбрано';

if (Loader::includeModule('sale')) {

    //Правила корзины
    $resDiscountTable = DiscountTable::getList([
        'select' => [
            'ID',
            'NAME',
        ],
        'filter' => [
            'ACTIVE' => 'Y',
        ],
        'order' => ['NAME' => 'ASC'],
        'cache' => ['ttl' => 86400],
    ]);

    while ($arDiscountTable = $resDiscountTable->Fetch()) {

        $arDiscountTableList[$arDiscountTable['ID']] = mb_substr($arDiscountTable['NAME'], 0, 50) . ' [' . $arDiscountTable['ID'] . ']';

    }

}

$arComponentParameters = [
    'PARAMETERS' => [
        "DISCOUNT_ID" => [
            "PARENT" => "BASE",
            "NAME" => "Выберите правило корзины для генерации купонов",
            "TYPE" => "LIST",
            "VALUES" => $arDiscountTableList,
            "DEFAULT" => "",
            "ADDITIONAL_VALUES" => "N",
            "REFRESH" => "N",
            "MULTIPLE" => "N",
        ],
        "COUPON_ADD" => [
            "PARENT" => "BASE",
            "NAME" => "Создавать новые купоны",
            "TYPE" => "CHECKBOX",
            "VALUE" => "N",
            "REFRESH" => "Y",
        ],
        "COUPON_ACTION_DAY" => [
            "PARENT" => "BASE",
            "NAME" => "Период активности нового купона (дней)",
            "TYPE" => "STRING",
            "DEFAULT" => 7,
            "REFRESH" => "N",
            "HIDDEN" => (isset($arCurrentValues['COUPON_ADD']) && $arCurrentValues['COUPON_ADD'] == 'N' ? 'Y' : 'N'),
        ],
        "COUPON_ACTION_COUNT" => [
            "PARENT" => "BASE",
            "NAME" => "Максимальное количество использований купона",
            "TYPE" => "STRING",
            "DEFAULT" => 1,
            "REFRESH" => "N",
            "HIDDEN" => (isset($arCurrentValues['COUPON_ADD']) && $arCurrentValues['COUPON_ADD'] == 'N' ? 'Y' : 'N'),
        ],
        "COUPON_DELETE" => [
            "PARENT" => "BASE",
            "NAME" => "Удалять активные купоны c истекшим периодом активности",
            "TYPE" => "CHECKBOX",
            "VALUE" => "N",
            "REFRESH" => "Y",
        ],
        "COUPON_DELETE_COUNT" => [
            "PARENT" => "BASE",
            "NAME" => "Количество удаляемых купонов за 1 проход (шт.)",
            "TYPE" => "STRING",
            "DEFAULT" => 5,
            "REFRESH" => "N",
            "HIDDEN" => (isset($arCurrentValues['COUPON_DELETE']) && $arCurrentValues['COUPON_DELETE'] == 'N' ? 'Y' : 'N'),
        ],
    ],
];


?>
