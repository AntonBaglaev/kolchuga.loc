<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$this->addExternalJS('//api-maps.yandex.ru/2.1/?lang=ru_RU');
?>

<?foreach($arResult['ITEMS'] as $arItem){
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	
	if(!empty($arItem['PROPERTIES']['MARKER']['VALUE']))
	{
		$markerImg = CFile::GetPath($arItem['PROPERTIES']['MARKER']['VALUE']);
	}
	else
		$markerImg = '';
?>
	<script type="text/javascript">
		let myMap,
			myPlacemark;
		
		ymaps.ready(function(){
		
			myMap = new ymaps.Map('indexMap', {
				center: [<?=$arItem['PROPERTIES']['MAP_COORDINATE']['VALUE'];?>],
				zoom: <?=$arParams['ZOOM_MAP'];?>,
				controls: ['typeSelector', 'fullscreenControl', 'rulerControl', 'zoomControl']
			});
			
			myMap.behaviors.disable('scrollZoom');
			
			myPlacemark = new ymaps.Placemark([<?=$arItem['PROPERTIES']['MAP_COORDINATE']['VALUE'];?>], {
				balloonContent: '<?=$arItem['PROPERTIES']['MORE_TEXT']['VALUE'];?>'
			},
			{
				iconLayout: 'default#image',
				iconImageHref: '<?=$markerImg;?>',
				iconImageSize: [46, 65],
				iconOffset: [-10, -32]
			});
			
			myMap.geoObjects.add(myPlacemark);
			
			let notForm = ($(window).width() <= 1163 ? true : false);
			
			<?php $massiv = explode(',', $arItem['PROPERTIES']['MAP_COORDINATE']['VALUE']);?>
			
			myMap.setCenter([<?=$massiv[0]?>, mapZoom(<?=$arParams['ZOOM_MAP'];?>, notForm)]);
			
			myMap.events.add('boundschange', function (event) {
				if (event.get('newZoom') != event.get('oldZoom'))
				{
					let state = myMap.action.getCurrentState();
					myMap.setCenter([<?=$massiv[0]?>, mapZoom(state.zoom, notForm)]);
				}
			}, this);

		});
		
		function mapZoom(zoom, notForm)
		{
			let coordinate = <?=$massiv[1];?>;

			if(notForm)
				return coordinate;

			switch(zoom)
			{
				case 22:
					coordinate -= 0.000140625;
				break;
				
				case 21:
					coordinate -= 0.00028125;
				break;
				
				case 20:
					coordinate -= 0.0005625;
				break;
				
				case 19:
					coordinate -= 0.001125;
				break;
				
				case 18:
					coordinate -= 0.00225;
				break;

				case 17:
					coordinate -= 0.0045;
				break;
				
				case 16:
					coordinate -= 0.009;
				break;

				case 15:
					coordinate -= 0.018;
				break;
				
				case 14:
					coordinate -= 0.036;
				break;
				
				case 13:
					coordinate -= 0.072;
				break;
				
				case 12:
					coordinate -= 0.144;
				break;
				
				case 11:
					coordinate -= 0.288;
				break;
				
				case 10:
					coordinate -= 0.576;
				break;
				
				case 9:
					coordinate -= 1.152;
				break;
				
				case 8:
					coordinate -= 2.304;
				break;
				
				case 7:
					coordinate -= 4.608;
				break;
				
				case 6:
					coordinate -= 9.216;
				break;
				
				case 5:
					coordinate -= 18.432;
				break;
				
				case 4:
					coordinate -= 36.864;
				break;
				
				case 3:
					coordinate -= 73.728;
				break;
			}
			
			return coordinate;
		}
	</script>
<?}?>

<div id="indexMap" class="indexMap" id="<?=$this->GetEditAreaId($arItem['ID']);?>"></div>