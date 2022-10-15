<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?php

use Bitrix\Main\Application;
use Bitrix\Main\Context;

$request = Application::getInstance()->getContext()->getRequest();

if ($request->isPost()) {

    $arMap = [];

    foreach ($_SESSION['POINTS_MAP'] as $value) {

        $md5 = md5($value['coordinates'][0] . $value['coordinates'][1]);

        $arMap[$md5]['coordinates'] = [$value['coordinates'][0], $value['coordinates'][1]];
        $arMap[$md5]['name'][] = $value['name'];
        $arMap[$md5]['content'][] = $value['content'];
        $arMap[$md5]['close'] = $value['close'];

    }

    $arResult = [
        'map_list' => $arMap,
        'first_coordinates' => $_SESSION['POINTS_MAP'][0],
        'delivery_list' => $_SESSION['DELIVERY_LIST'],
    ];

    echo json_encode($arResult, true);

}

?>