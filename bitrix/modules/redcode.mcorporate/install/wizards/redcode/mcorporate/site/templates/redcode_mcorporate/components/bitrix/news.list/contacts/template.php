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

<?foreach($arResult["ITEMS"] as $arItem){
	//$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	//$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
	if(!empty($arItem["PROPERTIES"]["MARKER"]["VALUE"]))
	{
		$markerImg = CFile::GetPath($arItem["PROPERTIES"]["MARKER"]["VALUE"]);
	}
	else
		$markerImg = "";
?>
	<script type="text/javascript">
		
		let myMap,
			myPlacemark;
		
		ymaps.ready(function(){
		
			myMap = new ymaps.Map("contactMap", {
				center: [<?=$arItem["PROPERTIES"]["MAP_COORDINATE"]["VALUE"];?>],
				zoom: <?=$arParams["ZOOM_MAP"];?>,
				controls: ["typeSelector", "fullscreenControl", "rulerControl", "zoomControl"]
			});
			
			myMap.behaviors.disable("scrollZoom");
			
			myPlacemark = new ymaps.Placemark([<?=$arItem["PROPERTIES"]["MAP_COORDINATE"]["VALUE"];?>], {
				balloonContent: '<?=$arItem["PROPERTIES"]["MORE_TEXT"]["VALUE"];?>'
			},
			{
				iconLayout: 'default#image',
				iconImageHref: '<?=$markerImg;?>',
				iconImageSize: [46, 65],
				iconOffset: [-10, -32]
			});
			myMap.geoObjects.add(myPlacemark);

		});
	</script>
<?}?>

<div id="contactMap" class="contactMap"></div>