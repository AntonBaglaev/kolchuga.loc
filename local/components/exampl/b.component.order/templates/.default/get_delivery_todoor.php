<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?php

use Bitrix\Main\Application;
use Bitrix\Main\Context;

$request = Application::getInstance()->getContext()->getRequest();

if ($request->isPost()) {

    $cityTo = trim(strip_tags($request->getPost('city')));
    $deliveryDate = trim(strip_tags($request->getPost('date')));

    if (!empty($cityTo)) {

        $deliveryStr = '';

        $href = 'https://delivery.yandex.ru/api/last/searchDeliveryList';
        $methodKey = '';
        $client_id = '';
        $sender_id = '';
        $cityFrom = '';
        $deliveryType = '';
        $weight = '10';
        $length = '10';
        $width = '10';
        $height = '0.5';

        $arHeader = [
            'Content-Type: application/x-www-form-urlencoded',
        ];

        $date = [
            'client_id' => $client_id,
            'sender_id' => $sender_id,
            'city_from' => $cityFrom,
            'city_to' => $cityTo,
            'delivery_type' => $deliveryType,
            'weight' => $weight,
            'length' => $length,
            'width' => $width,
            'height' => $height,
        ];

    }

}

?>