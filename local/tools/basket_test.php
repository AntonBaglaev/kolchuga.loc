<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 20/10/15
 * Time: 16:15
 */

include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');
CModule::IncludeModule('iblock');

//$items = array(659823, 659087, 657526);

$items = array();


$res = CIBlockElement::GetList(
    array('sort' => 'desc'),
    array('=PROPERTY_DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY_VALUE' => 'Да', 'IBLOCK_ID' => 40),
    false,
    array('nTopCount' => 3),
    array('ID', 'IBLOCK_ID', 'NAME', 'PROPERTY_DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY')
);

while($item = $res->Fetch()){
    echo $item['NAME'] . ' - ' . $item['PROPERTY_DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY_VALUE'] . '<br/>';
    $items[] = $item['ID'];
}

//unset($items);

$res = CIBlockElement::GetList(
    array(),
    array('!PROPERTY_DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY_VALUE' => 'Да', 'IBLOCK_ID' => 40, '>CATALOG_QUANTITY' => 0),
    false,
    array('nTopCount' => 1),
    array('ID', 'IBLOCK_ID')
);

while($item = $res->Fetch()){
    $items[] = $item['ID'];
}

foreach($items as $good){
    $r = Add2BasketByProductID($good, 1);
    var_dump($r);
}