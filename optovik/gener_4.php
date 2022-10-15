<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use \Bitrix\Main\Web\HttpClient;
$httpClient = new HttpClient();
include_once $_SERVER["DOCUMENT_ROOT"].'/local/tools/SimpleXLSX.php';

if ( $xlsx = \SimpleXLSX::parse($_SERVER["DOCUMENT_ROOT"].'/upload/magazins.xlsx') ) {
	$massiv0 = $xlsx->rows();
}
$massiv1=[];
foreach($massiv0 as $key=> $el){
	if($key<1){continue;}
	$adress = urlencode($el[0].', '.$el[3]);
	$url = "http://geocode-maps.yandex.ru/1.x/?geocode={$adress}&apikey=1cff83b8-af68-42b5-b57b-40e170f40831&format=json";
	$httpClient->query("GET", $url);
	$res=$httpClient->getResult();
	$arData=json_decode($res, true);
	$el['coord']=$arData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
	$el['fulladress']=$arData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['text'];
	$massiv1[$el[0]][]=$el;
}


/* Формируем код массива в виде текста */
$arrayFile = "<?php\r\n\r\n"
          ."return " . var_export($massiv1, TRUE) . ";"
          ."\r\n?>";
 
/* перезаписываем массив в файле */
file_put_contents('magazins_array.php', $arrayFile);
