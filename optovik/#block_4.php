<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit();
}/*
?>
<div>
				<p><strong>География нашего партнерства –  вся Россия</strong></p>
				<p>Оптовое направление компании «Кольчуга»   - объединяет в себе более 300 надежных партнеров и их число постоянно  растёт. </p>
				<p>Где бы вы ни находились, мы предложим вам отличные условия  сотрудничества, обеспечим лучшей продукцией, организуем быструю и надежную  доставку.</p>
				<div class="map-area hidden-sm">
					<div id="yandexMap" style="width:100%;height:600px;">
					</div>
				</div>
				</div>
				
				<script type="text/javascript" src="//api-maps.yandex.ru/2.1/?apikey=1cff83b8-af68-42b5-b57b-40e170f40831&lang=ru_RU"></script> 
    <script type="text/javascript">
            BX.ready(BX.defer(function () {
                ymaps.ready(function () {
                    var points = [];

                    var myMap = new ymaps.Map('yandexMap', {
                        center: [55.751798, 37.621564],
                        zoom: 10,
                        controls: []

                    }, {});

                    if ($(window).width() <= '768'){
                        myMap.behaviors.disable('scrollZoom');
                        myMap.behaviors.disable('drag');
                    }


                    var clusterer = new ymaps.Clusterer({
 
                        preset: 'islands#invertedPinkClusterIcons',
                        clusterNumbers: [100],
                        clusterIconContentLayout: null
                    });


                    <?foreach ($rsData as $store) {
                        ?>store<?=$store['ID']?> = new ymaps.Placemark([<?=$store['UF_SHIROTA']?>, <?=$store['UF_DOLGOTA']?>],                        
                        {
                            clusterCaption: '<?=$store['UF_NAME']?>',
                            balloonContentBody: '<div style="margin: 10px;">'
                            + '<?=$store['UF_GOROD']?> <br/>' 
                            + '<a href="<?=$store['DETAIL_PAGE_URL']?>" target="_blank"><b><?=$store['UF_TORGOVYYTSENTR']?></b></a><br>'
                            + '<?=$store['UF_ADRES']?><br>'
                            + '<?=$store['UF_GRAFIKRABOTY']?><br>'
                            + '</div>'
                        },
                        {
                            iconLayout: 'default#image',
                            iconImageHref: '<?=SITE_DIR?>local/include/tpl/img/flag.png',
                            iconImageSize: [25, 40],
                            iconImageOffset: [-12.5, -40],
                            
                        }
                    );

                    points.push(store<?=$store['ID']?>);<?php
                    
                    }?>

                    clusterer.add(points);
                    myMap.geoObjects.add(clusterer);
                    myMap.setBounds(clusterer.getBounds(), {checkZoomRange: true});

                });
            }));
        </script>
		*/?>
<?
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
die;

?><!--pre><?print_r($massiv0[3]);?></pre--><?



/*$res=$GLOBALS["APPLICATION"]->ConvertCharset($res, "UTF-8", LANG_CHARSET);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/xml.php");
$objXML = new CDataXML();
$objXML->LoadString($res);
$arData = $objXML->GetArray();*/
$arData=json_decode($res, true);
?><!--pre><?print_r($arData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']);?></pre--><?
?><!--pre><?print_r($arData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['text']);?></pre--><?
?>