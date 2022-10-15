<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit();
}
$rsData = include_once $_SERVER["DOCUMENT_ROOT"].'/optovik/magazins_array.php';

?>
<div>
	<p>
 <strong>География нашего партнерства – вся Россия</strong>
	</p>
	<p>
		 Оптовое направление компании «Кольчуга»&nbsp; - объединяет в себе более 300 надежных партнеров и их число постоянно растёт.
	</p>
	<p>
		 Где бы вы ни находились, мы предложим вам отличные условия сотрудничества, обеспечим лучшей продукцией, организуем быструю и надежную доставку. С полным списком дилеров можно ознакомиться <u><a href="javascript:void(0);" id="listdilers">здесь</a>.</u>
	</p>
	<div class="map-area hidden-sm">
		<div id="yandexMap" style="width:100%;height:400px;">
		</div>
	</div>
</div>
    <script type="text/javascript" src="//api-maps.yandex.ru/2.1/?apikey=1cff83b8-af68-42b5-b57b-40e170f40831&lang=ru_RU"></script>
    <script type="text/javascript">
    BX.ready(BX.defer(function(){
      ymaps.ready(function () {
        var points = [];

        var myMap = new ymaps.Map('yandexMap', { center: [55.751798, 37.621564], zoom: 4, controls: [] }, {searchControlProvider: 'yandex#search'} );

        var clusterer = new ymaps.Clusterer({
          preset: 'islands#invertedNightClusterIcons',
          clusterNumbers: [100],
          clusterIconContentLayout: null
        });

        <?$id=1000;
					foreach ($rsData as $gorod=>$store0) {
						if(id>1010){break;}
						foreach($store0 as $store){
							$coordinat=explode(' ',$store['coord']);
							$store['0']=trim(str_replace(array("\r\n", "\r", "\n"), ' ', $store['0']));
							$store['1']=trim(str_replace(array("\r\n", "\r", "\n"), ' ', $store['1']));
							$store['2']=trim(str_replace(array("\r\n", "\r", "\n"), ' ', $store['2']));
							?>store<?=$store[$id]?> = new ymaps.Placemark([<?=$coordinat['1']?>, <?=$coordinat['0']?>],                        
									{
										clusterCaption: '<?=$store['1']?>',
										balloonContentBody: '<div style="margin: 10px;">'
										+ '<b><?=$store['1']?></b> <br/>' 
										+ '<?=trim($store['fulladress'])?><br>'
										+ '<?=trim($store['2'])?><br>'
										+ '</div>'
									},
									{
										
										preset: 'islands#nightDotIcon',
										/*iconLayout: 'default#image',
										iconImageHref: '<?=SITE_DIR?>images/flag.png',
										iconImageSize: [25, 40],
										iconImageOffset: [-12.5, -40],*/
										
									}
								);

								points.push(store<?=$store[$id]?>);
								myMap.geoObjects.add(store<?=$store[$id]?>);
							<?
								$id++;
							}
						?>
							
					<?php }?>
        //clusterer.add(points);
        //myMap.geoObjects.add(clusterer);
        //myMap.setBounds(clusterer.getBounds(), { checkZoomRange: true });
      });
    }));
    </script>