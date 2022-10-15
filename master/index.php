<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Сервисный центр");
$APPLICATION->SetTitle("Сервисный центр");
?>

<?

$arServiceCenters = ["TITLE" => ['barvikha'      => 'ТК «БАРВИХА Luxury Village»',
                                 'varvarka'      => 'ул. Варварка, 3 «Гостиный двор»',
                                 'volokolamskoe' => 'Волоколамское шоссе, 86',
                                 'leninsky'      => 'Ленинский проспект, 44',
                                 'lyubertsy'     => 'г. Люберцы, ул. Котельническая, 24А',
]];

$APPLICATION->IncludeComponent(
    'kolchuga:master.timetable',
    '',
    array(
        'ITEM_CODE'       => $_REQUEST['ITEM_CODE'],
        'SERVICE_CENTERS' => $arServiceCenters,
        'CACHE_TYPE'      => 'A',
        'CACHE_TIME'      => '7200',
    )
);
?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>