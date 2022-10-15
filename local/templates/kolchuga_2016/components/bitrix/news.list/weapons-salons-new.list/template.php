<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$yandex_map_api_key = \Bitrix\Main\Config\Option::get("fileman", "yandex_map_api_key");
$this->addExternalJS("https://api-maps.yandex.ru/2.1/?lang=ru-RU&amp;apikey=".$yandex_map_api_key);
//\Kolchuga\Settings::xmp($arResult["ITEMS"][1],11460, __FILE__.": ".__LINE__);
$jsParams=array(
	"type"=> "FeatureCollection",
	"features"=>array()
);
$kl=0;
?>
<div class=" wsalon">
	<?foreach($arResult["ITEMS"] as $arItem){
		
		if (in_array($arItem['ID'], [705387]))
			$arItem['DETAIL_PAGE_URL'] = '/internet_shop/';
		
		if($arItem['PROPERTIES']['show_in_list']['VALUE_XML_ID'] == 'NO'){ continue;}
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="row borderhover no-gutters" id="<?=$this->GetEditAreaId($arItem['ID']);?>">	
			<div class="col-lg-6 pb-5 pt-5">
				<div class="row">
					<div class="col-1 col-lg-1 locationimg"><? if ($arItem['PROPERTIES']['DOP_YANDEX']['VALUE']):?><div class="row"><img  src="/images/main-icon/location.png"></div><?endif?></div>
					<div class="col-11 col-lg-5 a_adress"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['PROPERTIES']['DOP_NAME']['VALUE']?></a></div>
					<div class="col-6 col-lg-3"><? if ($arItem['PROPERTIES']['DOP_YANDEX']['VALUE']):?><a class="a_flex" href="https://yandex.ru/maps/?rtext=~<?=$arItem['PROPERTIES']['DOP_YANDEX']['VALUE']?>&rtt=auto" target="_blank"><img src="/images/main-icon/gps.png"><span>Построить<br> маршрут</span></a><?endif?></div>
					<div class="col-6 col-lg-3"><? if ($arItem['PROPERTIES']['e_mail']['VALUE']):?><a class="a_flex" href="mailto:<?=$arItem['PROPERTIES']['e_mail']['VALUE']?>"><img src="/images/main-icon/post.png"><span>Отправить<br> E-mail</span></a><?endif?></div>
				</div>
				<div class="row <?= in_array($arItem['ID'], [705387]) ? 'hide_this' : 'pb-5 pt-5' ?>">
					<div class="col-1 col-lg-1">
						<?if(!empty($arItem['PROPERTIES']['DOP_COLOR']['VALUE'])){?>
							<div class="row"><span style="display: block; width: 10px; height: 10px; background-color: <?=$arItem['PROPERTIES']['DOP_COLOR']['VALUE']?>; border-radius: 50%; margin: 10px auto 0;" class="l-hide"></span></div>
							<?if($arItem['ID']==112){?>
								<div class="row"><span style="display: block; width: 10px; height: 10px; background-color: #003399; border-radius: 50%; margin: 10px auto 0;" class="l-hide"></span></div>
							<?}?>
						<?}?>
					</div>
					<div class="col-11 col-lg-5 a_metro">
						<?if(!empty($arItem['PROPERTIES']['metro_station']['VALUE'])){?>
							<a href="<?=$arItem['DETAIL_PAGE_URL']?>">м. <?=$arItem['PROPERTIES']['metro_station']['VALUE']?></a>
							<?if($arItem['ID']==112){?>
								<br><a href="<?=$arItem['DETAIL_PAGE_URL']?>">м. Площадь Революции</a><br>
							<?}?>
						<?}elseif(!empty($arItem['PROPERTIES']['address']['VALUE'])){?>
							<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['PROPERTIES']['address']['VALUE']?></a>
						<?}?>
					</div>
					<div class="col-1 d-block d-sm-none"></div>
					<div class="col-11 col-lg-6 a_metro_descr">
						<!-- <a href="https://yandex.ru/maps/?rtext=~<?=$arItem['PROPERTIES']['DOP_YANDEX']['VALUE']?>&rtt=pd" target="_blank">пешком от метро</a> -->
						<!-- https://yandex.ru/maps/213/moscow/?ll=37.578181%2C55.704197&mode=routes&rtext=55.707251%2C37.585683~55.701294%2C37.566816&rtt=pd&ruri=~&z=16.18 -->
						
						
							
							<?
							switch ($arItem['ID']) {
							case "115":
								?><a href="https://yandex.ru/maps/?rtext=55.826401,37.437746~<?=$arItem['PROPERTIES']['DOP_YANDEX']['VALUE']?>&rtt=pd" target="_blank">10 мин. пешком от метро</a><?
								?><br><a href="https://yandex.ru/maps/?mode=search&z=18&text=55.821995,37.444370" target="_blank">есть парковка</a><?
								break;
							case "114":
								?><a href="https://yandex.ru/maps/?rtext=55.707251,37.585683~<?=$arItem['PROPERTIES']['DOP_YANDEX']['VALUE']?>&rtt=pd" target="_blank">20 мин. пешком от метро</a><?
								?><br><a href="https://yandex.ru/maps/?rtext=55.706688,37.586313~<?=$arItem['PROPERTIES']['DOP_YANDEX']['VALUE']?>&rtt=mt" target="_blank">15 мин. на общественном транспорте</a><?
								?><br><a href="https://yandex.ru/maps/?mode=search&z=18&text=55.701783,37.568435" target="_blank">есть парковка</a><?
								break;
							case "116":
								?><a href="https://yandex.ru/maps/?rtext=55.674158,37.858356~<?=$arItem['PROPERTIES']['DOP_YANDEX']['VALUE']?>&rtt=mt" target="_blank">20 мин. на общественном транспорте</a><?
								?><br><a href="https://yandex.ru/maps/?mode=search&z=18&text=55.668270,37.888840" target="_blank">есть парковка</a><?
								
								break;
							case "112":
								?><a href="https://yandex.ru/maps/?rtext=55.753093,37.633003~<?=$arItem['PROPERTIES']['DOP_YANDEX']['VALUE']?>&rtt=pd" target="_blank">5 мин. пешком от метро</a><?
								
								
								break;
							}
							?>
						
							
						
					</div>
					
				</div>
				<div class="row">
					<div class="col-1 col-lg-1"></div>
					<div class="col-11 col-lg-5 tfonsa">
					
						<?if(!empty($arItem['PROPERTIES']['phones']['VALUE'])){?>
							<div class="t_salon">
								<span><?= in_array($arItem['ID'], [705387]) ? 'телефон' : 'оружейный салон' ?></span><br>
								<a href="tel:<?=$arItem['PROPERTIES']['phones']['VALUE']?>"><?=$arItem['PROPERTIES']['phones']['VALUE']?></a>
							</div>
						<?}?>
						<?if(!empty($arItem['PROPERTIES']['clock']['VALUE'])){?>
							<div class="v_time_clock">
								<span class="v_title">График работы оружейного салона:</span><br> 
								<span><?=$arItem['PROPERTIES']['clock']['VALUE']?></span>
							</div>
						<?}?>
						<?if(!empty($arItem['PROPERTIES']['phones_service']['VALUE'])){?>
						
						<?
							$arCurPhone = explode('доб.', $arItem['PROPERTIES']['phones_service']['VALUE']);
						
						?>
						
							<div class="t_scentr">
								<span>сервисный центр</span><br>
								<a href="tel:<?=current($arCurPhone)?>"><?=$arItem['PROPERTIES']['phones_service']['VALUE']?></a>
							</div>
						<?}?>
						<?if(!empty($arItem['PROPERTIES']['masterskaya']['VALUE'])){?>
							<div class="v_time">
								<span class="v_title">График работы сервисного центра:</span><br> 
								<span><?=$arItem['PROPERTIES']['masterskaya']['VALUE']?></span>
							</div>
						<?}?>
						
						<? if ($arItem['ID'] == '705387'):?>
						<div class="v_time">
								<span class="v_title">График работы интернет-магазина:</span><br> 
								<span>Пн-Пт: 10:00 - 19:00; Сб-Вс: выходной</span>
							</div>
						<? endif ?>
						
						<?if (!empty($arItem["PROPERTIES"]["DOP_DESCRIPTION"]["VALUE"])){
								?><div class="d_description"><?=$arItem["PROPERTIES"]["DOP_DESCRIPTION"]["~VALUE"]['TEXT'];?></div><?
							}?>
					</div>
					<div class="col-lg-4">
						<?if(!empty($arItem['PROPERTIES']['WHATSAPP_PHONE']['VALUE'])){?>
							<a class="a_flex whapp_tel" href="whatsapp://send?phone=<?=$arItem['PROPERTIES']['WHATSAPP_PHONE']['VALUE']?>"><img src="/images/svg/whatsapp-svgrepo-com.svg" style=" width: 30px;"><span><?=$arItem['PROPERTIES']['WHATSAPP_PHONE']['VALUE']?></span></a>
						
						<?}?>
					</div>
					<div class="col-lg-2"></div>
				</div>
				
			</div>
			<div class="col-lg-6">
				<div class="block_img">
					<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="thumb-wrap">
						<?$arFile = \Kolchuga\Pict::getWebpImgSrc( \CFile::GetPath($arItem['PROPERTIES']['DOP_FOTO_SALONA']['VALUE']), $intQuality = 90);?>
						<?/* <img border="0" src="<?=CFile::GetPath($arItem['PROPERTIES']['DOP_FOTO_SALONA']['VALUE'])?>" width="100%" alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>" class="bdr0"> */?>
						<picture>
							<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
								<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
							<?endif;?>
							<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" width="100%" alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>" />
						</picture>
					</a>
					<div class="main__btn btnitem <?if($arItem['ID']!=112){?>noblockberetta<?}?>"><a href="<?=$APPLICATION->GetCurPageParam("salonfilter=".$arItem["ID"], array("salonfilter"))?>#product">Посмотреть товары</a></div>
					<?if($arItem['ID']==112){?>
						<div class="blockberetta">
							<a class="navbar-brand" href="/beretta/">
								<img src="/images/bereta/pb-logo-sm.png" style="height: 48px;">
								<img src="/images/bereta/ber-toplogo.png" style="max-height:48px" class="pl-2">
							</a><br>
							<a href="/beretta/" class="atext">Галерея Beretta</a>		
							<div class="main__btn btnitemberetta"><a href="/weapons_salons/?salonfilter=112&salonfilter465=763119#product">Товары галереи</a></div>					
						</div>
					<?}?>
				</div>
			</div>
		</div>
		
		<?
        if ($arItem['PROPERTIES']['DOP_YANDEX']['VALUE']) {
		$jsParams["features"][]=array(
			"type"=> "Feature", 
			"id"=> $kl, 
			"geometry"=> array(
				"type"=> "Point", 
				"coordinates"=> explode(',', $arItem['PROPERTIES']['DOP_YANDEX']['VALUE'])
			), 
			"properties"=> array(
				"balloonContentHeader"=> "<font size=3><b><a target='_blank' href='https://kolchuga.ru".$arItem['DETAIL_PAGE_URL']."'>".$arItem['PROPERTIES']['DOP_NAME']['VALUE']."</a></b></font>", 
				"balloonContentBody"=> "<p>ОРУЖЕЙНЫЙ САЛОН<br> <a href='tel:".$arItem['PROPERTIES']['phones']['VALUE']."'>".$arItem['PROPERTIES']['phones']['VALUE']."</a></p>", 
				"balloonContentFooter"=> "<font size=1>".$arItem['PROPERTIES']['clock']['VALUE']."</font>", 
				"clusterCaption"=> $arItem['NAME'], 
				"hintContent"=> "<strong>".$arItem['NAME']."</strong>"
			)
		);
		$kl++;
        }
		?>
	<?}?>
	
	<?/*<div class="row borderhover no-gutters">	
		<div class="col-lg-6 pb-5 pt-5">
			<div class="row">
				<div class="col-1 col-lg-1 locationimg"><div class="row"><img  src="/images/main-icon/location.png"></div></div>
				<div class="col-11 col-lg-5 a_adress"><a href="javascript:void(0);">ТК “БАРВИХА Luxury Village”</a></div>	
				<div class="col-6 col-lg-3"><a class="a_flex" href="https://yandex.ru/maps/?rtext=~55.73833374657,37.263638891541&rtt=auto&z=10.6" target="_blank"><img src="/images/main-icon/gps.png"><span>Построить<br> маршрут</span></a></div>
				<div class="col-6 col-lg-3"><a class="a_flex" href="mailto:barvikha@kolchuga.ru"><img src="/images/main-icon/post.png"><span>Отправить<br> E-mail</span></a></div>
			</div>
			<div class="row pb-5 pt-5">
				<div class="col-1 col-lg-1"><div class="row"></div></div>
				<div class="col-11 col-lg-5 a_metro"><a href="javascript:void(0);">8-й км Рублево-Успенского шоссе</a></div>
				
			</div>	
				<div class="row">
					<div class="col-1 col-lg-1"></div>
					<div class="col-11 col-lg-5 tfonsa">
					
						
							<div class="t_salon">
								<span>оружейный салон</span><br>
								<a href="tel:+74952252990">+7 (495) 225-29-90</a>
							</div>
							<div class="v_time">
								<span class="v_title">График работы:</span><br> 
								<span>Пн-чт: 10:00-22:00; Пт-вс: 10:00-23:00</span>
							</div>
						
					</div> 
					
				</div>			
		</div>
		<div class="col-lg-6">
			<div class="block_img">
				<!-- <div style="height: 193px; background: #21385E;"></div> -->
				<a href="javascript:void(0);" class="thumb-wrap">
						<img border="0" src="/images/news/6e6d73f07d1af43763bee3d4f95ecad3.jpeg" width="100%" alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>" class="bdr0">
					</a>
				<div class="main__btn btnitem noblockberetta"><a href="/news/open_barvikha/">Мы открылись</a></div>
				
			</div>
		</div>
	</div>
	<?
		$jsParams["features"][]=array(
			"type"=> "Feature", 
			"id"=> $kl, 
			"geometry"=> array(
				"type"=> "Point", 
				"coordinates"=> ['55.73833374657','37.263638891541']
			), 
			"properties"=> array(
				"balloonContentHeader"=> "<font size=3><b><a target='_blank' href='https://kolchuga.ru/news/open_barvikha/'>ТК “БАРВИХА Luxury Village”</a></b></font>", 
				"balloonContentBody"=> "<p>ОРУЖЕЙНЫЙ САЛОН<br> <a href='tel:+74952252990'>+7 (495) 225-29-90</a></p>", 
				"balloonContentFooter"=> "<font size=1>Пн-чт: 10:00-22:00; Пт-вс: 10:00-23:00</font>", 
				"clusterCaption"=> 'Барвиха', 
				"hintContent"=> "<strong>Барвиха</strong>"
			)
		);
		$kl++;*/
		?>
</div>
<script>
	  var datametki = <?=CUtil::PhpToJSObject($jsParams, false, true)?>;
	</script>
<a name="map" id="map"></a>
<div class=" mb-5 pt-5" style="border-top: 1px solid #C4C4C4;">
	<div class="row">	
		<div class="col-12">			
			<p style="#3c3c3c; font-size:17px;">Оружейные салоны «Кольчуга» на карте Москвы</p>					
		</div>		
	</div>
	<div class="row">	
		<div class="col-12">			
			<div id="salonmap" style="width:100%;height:400px;"></div>
		</div>		
	</div>
</div>
<?








































/* 

?><div class="salon_list">
	<div class="table_salon_list"><?

$counter = 0;

foreach($arResult["ITEMS"] as $arItem)
{

	if(is_array($arItem))
	{
		if($arItem['PROPERTIES']['show_in_list']['VALUE_XML_ID'] != 'NO')
		{

			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

			?><div class="table_salon_list_td" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="block_salonBody">
					<?if($arItem['ID']==112){?>
					<h2 style="justify-content: space-between;display: flex;"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a><a href="/beretta/">Галерея Beretta</a></h2>
					<?}else{?>
					<h2><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h2>
					<?}?>
					<div class="block_img"><?
						if(is_array($arItem["PREVIEW_PICTURE"]))
						{
							?><a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
								<img border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" class="bdr">
							</a><?
						}
					?></div>
					<div class="block_menu_salon"><?

						if ($arItem["DISPLAY_PROPERTIES"]["salon"]["VALUE"] || $arItem["DISPLAY_PROPERTIES"]["catalog_link"]["VALUE"] || $arItem["DISPLAY_PROPERTIES"]["legal_information"]["VALUE"] || $arItem["DISPLAY_PROPERTIES"]["about_director"]["VALUE"])
						{
							?><ul class="menu_salon"><?
								if ($arItem["DISPLAY_PROPERTIES"]["salon"]["VALUE"]){
									?><li><a href="<?=$arItem["DISPLAY_PROPERTIES"]["salon"]["VALUE"];?>">О салоне</a></li><?
								}
								if ($arItem["DISPLAY_PROPERTIES"]["catalog_link"]["VALUE"]){
									?><li><a href="<?=$arItem["DISPLAY_PROPERTIES"]["catalog_link"]["VALUE"];?>">Каталог товаров</a></li><?
								}
								if ($arItem["DISPLAY_PROPERTIES"]["legal_information"]["VALUE"]){
									?><li><a href="<?=$arItem["DISPLAY_PROPERTIES"]["legal_information"]["VALUE"];?>">Юридическая информация</a></li><?
								}
								if ($arItem["DISPLAY_PROPERTIES"]["about_director"]["VALUE"]){
									?><li><a href="<?=$arItem["DISPLAY_PROPERTIES"]["about_director"]["VALUE"];?>">О руководителе</a></li><?
								}
								if ($arItem["DISPLAY_PROPERTIES"]["tur3d"]["VALUE"]){
									?><li><a href="<?=$arItem["DISPLAY_PROPERTIES"]["tur3d"]["VALUE"];?>" target="_blank">3D-тур</a></li><?
								}
								if ($arItem["DISPLAY_PROPERTIES"]["contact_link"]["VALUE"])	{
									?><li><a href="<?=$arItem["DISPLAY_PROPERTIES"]["contact_link"]["VALUE"];?>" target="_blank">Схема проезда</a></li><?
								}
							?></ul><?
						}

					?></div>
					<div class="ov_hidden"><?
						if ($arItem["DISPLAY_PROPERTIES"]["address"]["VALUE"])
						{
							?><h2 class="fl_left">Адрес</h2><?
						}
						?><div class="address_info_right"><?
							if ($arItem["DISPLAY_PROPERTIES"]["address"]["VALUE"]){
								?><p><?=$arItem["DISPLAY_PROPERTIES"]["address"]["VALUE"];?></p><?
							}
							if ($arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE"]){
								?><p <?if ($arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_alex ||$arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_chinasity || $arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_lenpr):?>class="metro_orange"<?endif?><?if ($arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_tuch || $arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_kotel){

									?>class="metro_purple"<?
								}
									?>><i class="bdr">м</i><?=$arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE"];?></p><?
							}
							if (!empty($arItem["PROPERTIES"]["DOP_DESCRIPTION"]["VALUE"])){
								?><div><?=$arItem["PROPERTIES"]["DOP_DESCRIPTION"]["~VALUE"]['TEXT'];?></div><?
							}
							if ($arItem["DISPLAY_PROPERTIES"]["e_mail"]["VALUE"]){
								?><p><a href="mailto:<?=$arItem["DISPLAY_PROPERTIES"]["e_mail"]["VALUE"];?>"><?=$arItem["DISPLAY_PROPERTIES"]["e_mail"]["VALUE"];?></a></p><?
							}
							if ($arItem["DISPLAY_PROPERTIES"]["clock"]["VALUE"]){
								?><p>График работы салона: <?=$arItem["DISPLAY_PROPERTIES"]["clock"]["VALUE"];?></p><?
							}
							if ($arItem["DISPLAY_PROPERTIES"]["masterskaya"]["VALUE"]){
								?><p>Сервисный центр: <?=$arItem["DISPLAY_PROPERTIES"]["masterskaya"]["VALUE"];?></p><?
							}
							if ($arItem["DISPLAY_PROPERTIES"]["phones"]["VALUE"] || $arItem["DISPLAY_PROPERTIES"]["fax"]["VALUE"]){
								?><p>Телефон: <?=$arItem["DISPLAY_PROPERTIES"]["phones"]["VALUE"];?></p><?
							}
						?></div>
						<div><?=$arItem["PREVIEW_TEXT"]?></div>
						<div class="main__btn"><a href="<?=$APPLICATION->GetCurPageParam("salonfilter=".$arItem["ID"], array("salonfilter"))?>#product">Посмотреть товары</a></div>
					</div>
				</div>
			</div>
			<?
			$counter++;
			if($counter % 2 == 0){
				echo '<hr class="tr_border">';
			}
		}
	}
}
?></div>
</div> 
<?*/