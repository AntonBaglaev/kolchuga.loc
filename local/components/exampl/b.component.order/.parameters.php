<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Localization\Loc;

$arComponentParameters = [
    'PARAMETERS' => [
        "CARD_PAYMENT_ID" => [
            "NAME" => Loc::getMessage("CARD_PAYMENT_ID"),
            "TYPE" => "STRING",
            "DEFAULT" => '11',
            "PARENT" => "BASE",
        ],
        "CASH_PAYMENT_ID" => [
            "NAME" => Loc::getMessage("CASH_PAYMENT_ID"),
            "TYPE" => "STRING",
            "DEFAULT" => '1',
            "PARENT" => "BASE",
        ],
    ],
];

?>