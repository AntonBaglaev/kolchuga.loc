<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?php

use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();

if ($request->isPost()) {

    $cityTo = trim(strip_tags($request->getPost('city')));
    $deliveryTo = $request->getPost('delivery');

    if (!empty($cityTo)) {

        $deliveryStr = '';

        $_SESSION['POINTS_MAP'] = [];
        $_SESSION['DELIVERY_LIST'] = [];

        $href = 'https://delivery.yandex.ru/api/last/searchDeliveryList';
        $methodKey = '';
        $client_id = '';
        $sender_id = '';
        $cityFrom = '';
        $deliveryType = 'pickup';
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