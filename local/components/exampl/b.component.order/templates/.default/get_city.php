<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?php

use Bitrix\Main\Application;
use Bitrix\Main\Context;

$request = Application::getInstance()->getContext()->getRequest();

if ($request->isPost()) {

    $cityName = trim(strip_tags($request->getPost('city')));

    if (!empty($cityName)) {

        $cityStr = '';

        $href = 'https://delivery.yandex.ru/api/last/autocomplete';
        $methodKey = '';
        $client_id = '';
        $sender_id = '';
        $type = '';

        $arHeader = [
            'Content-Type: application/x-www-form-urlencoded'
        ];

        $date = [
            'client_id' => $client_id,
            'sender_id' => $sender_id,
            'type' => $type,
            'term' => $cityName,
        ];

    }


}

?>