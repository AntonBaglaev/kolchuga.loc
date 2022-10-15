<noindex>

<?
$buy_id = $arResult['SKU_COUNT'] <= 1 && $sku_id > 0 ? $sku_id : $arResult['ID'];

if($arResult['SKU'] && $arResult['SKU_COUNT'] > 1){
$buy_id = 0; /* client side must select offer */
}

//\Kolchuga\Settings::xmp($arResult['ID'],11460, __FILE__.": ".__LINE__);
//\Kolchuga\Settings::xmp($arResult['SKU'],11460, __FILE__.": ".__LINE__);
//\Kolchuga\Settings::xmp($arResult,11460, __FILE__.": ".__LINE__);
 /* ?><!--pre>arResultaaaIas <?print_r($arResult['SKU_ARR']);?></pre--><?*/

if(!$arResult['PROPERTIES']['TREBUETSYA_LITSENZIYA']['VALUE']){?>	
	<div class="alert-size">
		<div class="alert alert-warning">Выберите размер</div>
	</div>
	
	<?if($arResult['KOMPLEKT']['DISPLAY_NAME']){?>
		<?if(1==2){?>
			<strong>Временно оформление заказа в интернет-магазине недоступно.</strong>
		<?}else{?>
			<a class="order-btn js-buy-btn btn btn-primary popup-modal2" href="#modal-komplekt" style="<?=$arResult['CAN_BUY'] ? '' : 'display: none'?>" data-id="<?=$buy_id?>" rel_mc="kupit" rel="nofollow">Купить</a>
			<a class="popup-modal2 order-btn" href="#modal-komplekt" style="display: none" rel="nofollow" rel_mc="kupit">Купить</a>
		<?}?>
	<?}else{?>
		<?if($arResult['PROPERTIES']['SECT_ELEMENT']['VALUE']=='Обувь false'){?>			
			<a class="btn btn-primary" href="#" aria-disabled="true" disabled rel="nofollow">Доступно только к самовывозу</a>
		<?}else{?>
			<?if(1==2){?>
				<strong>Временно оформление заказа в интернет-магазине недоступно.</strong>
			<?}else{?>
				<?if(!$arResult['CAN_BUY']){?>
					<a class="btn btn-primary" href="#" aria-disabled="true" disabled rel="nofollow">Нет в наличии</a>
				<?}else{?>
						
						<?if($arResult['SKU'] && $arResult['SKU_COUNT'] > 1){
									 /* ?><!--pre>arResultaaaIas <?print_r($arResult['ID']);?></pre--><?   */
							foreach($arResult['SKU_ARR'] as $key=>$valueI){
									/* ?><!--pre>arResultaaaIas <?print_r($valueI['ID']);?></pre--><?  */
								if($valueI['ID']==$arResult['ID']){
									if(!empty($valueI['GET_BY_SKLAD'])){
										?><a class="order-btn js-buy-btn btn btn-primary " style="<?=$arResult['CAN_BUY'] ? '' : 'display: none'?>" href="#" data-id="0" rel="nofollow" rel_mc="kupit">Купить</a><?
									}else{
										if(!empty($valueI['SET_SKLAD']['114']['PRODUCT_ID'])){
											?><a href="/weapons_salons/leninsky-prospekt/"><strong>Покупка товара только в салоне</strong></a><?														
										}elseif(!empty($valueI['SET_SKLAD']['116']['PRODUCT_ID'])){
											?><a href="/weapons_salons/lyubertsy/"><strong>Покупка товара только в салоне</strong></a><?	
										}elseif(!empty($valueI['SET_SKLAD']['699777-1']['PRODUCT_ID'])){
											?><a href="/news/open_barvikha/"><strong>Покупка товара только в салоне</strong></a><?														
										}else{
											?><a class="js-buy-btn btn btn-primary order-btn" style="<?=$arResult['CAN_BUY'] ? '' : 'display: none'?>" href="#" data-id="0" rel="nofollow" rel_mc="kupit">Купить</a><?
										}
									}
								}
							}
						}else{
							if(is_array($arResult['LIST_DOSTUPNOST_ITEM'])){
							foreach($arResult['LIST_DOSTUPNOST_ITEM'] as $key=>$valueI){
								if($valueI['ID']==$arResult['ID']){
									if(!empty($valueI['GET_BY_SKLAD'])){
										?><a class="order-btn js-buy-btn btn btn-primary " style="<?=$arResult['CAN_BUY'] ? '' : 'display: none'?>" href="#" data-id="<?=$valueI['ID']?>" rel="nofollow" rel_mc="kupit">Купить</a><?
									}else{
										if(!empty($valueI['SET_SKLAD']['114']['PRODUCT_ID'])){
											?><a href="/weapons_salons/leninsky-prospekt/"><strong>Покупка товара только в салоне</strong></a><?														
										}elseif(!empty($valueI['SET_SKLAD']['116']['PRODUCT_ID'])){
											?><a href="/weapons_salons/lyubertsy/"><strong>Покупка товара только в салоне</strong></a><?	
										}elseif(!empty($valueI['SET_SKLAD']['699777-1']['PRODUCT_ID'])){
											?><a href="/news/open_barvikha/"><strong>Покупка товара только в салоне</strong></a><?
										}else{
											?><a class="js-buy-btn btn btn-primary order-btn" style="<?=$arResult['CAN_BUY'] ? '' : 'display: none'?>" href="#" data-id="<?=$valueI['ID']?>" rel="nofollow" rel_mc="kupit">Купить</a><?
										}
									}
								}
							}
							}
						}?>
					
				<?}?>
			<?}?>
		<?}?>
	<?}?>
<?}else{?>
	<?if($arResult["CATALOG_QUANTITY"]>0):?>
		<a class="order-btn btn btn-primary popup-modal" href="#modal-buyoneclick" rel="nofollow" rel_mc="rezerv">Зарезервировать</a>
		<?$APPLICATION->IncludeFile('/include/wasbanner_catalog.php', array(), array());?>
		
		<?/*foreach($arResult['SECTION']['PATH'] as $rrr){
			if(in_array($rrr['ID'],[17859, 17860])){
				?><strong>Резерв патронов осуществляется по 100% предоплате в  <a href="/weapons_salons/" style="text-decoration:underline">оружейных салонах «Кольчуга»</a></strong><?
				break;
			}		
		}*/?>
		<?/*<strong>Резервирование товара производится по 100% предоплате в  <a href="/weapons_salons/" style="text-decoration:underline">оружейных салонах «Кольчуга»</a></strong>*/?>
	<?else:?>
		<a class="btn btn-primary" href="#" aria-disabled="true" disabled rel="nofollow">Нет в наличии</a>
	<?endif;?>

	<?/*<div class="catalog__license">
		<div class="catalog__license__item">
			<span class="dopkrezerv">Только по документам</span><br/><a href="/information/rezerv-grazhdanskogo-oruzhiya-i-patronov.php" class="rules"><ins>Правила резервирования</ins></a>
		</div>
	</div>*/?>
<?}?>

</noindex>

<?if($arResult['KOMPLEKT']['DISPLAY_NAME']):?>
	<div id="modal-komplekt" class="mfp-modal mfp-hide">
		<div class="mfp-modal-header">Продается только в комплекте с:</div>
		<div class="mfp-modal-content js-modal-reserve">
			<div class="catalog__item" id="" style="text-align: center; width:100%">
				<?if ($arResult['KOMPLEKT']['DISPLAY_DETAIL_PICTURE']){?>
					<div class="catalog__item-img">
						<a href="<?=$arResult['KOMPLEKT']['DISPLAY_URL']?>">
							<img src="<?echo CFile::ResizeImageGet($arResult['KOMPLEKT']['DISPLAY_DETAIL_PICTURE'], array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 60)['src']?>" alt="<?=$arResult['KOMPLEKT']['DISPLAY_NAME']?>" title="<?=$arResult['KOMPLEKT']['DISPLAY_NAME']?>">
						</a>
					</div>
				<?}?>
				<div class="catalog__item-info">
					<div class="catalog__item-title"><a href="<?=$arResult['KOMPLEKT']['DISPLAY_URL']?>"><?=$arResult['KOMPLEKT']['DISPLAY_NAME']?></a></div>
					<a class="btn btn-primary" href="<?=$arResult['KOMPLEKT']['DISPLAY_URL']?>" style="margin-top: 15px;">Выбрать</a>
				</div>
			</div>
		</div>
	</div>
<?endif;?>

<?if(!empty($arResult['SETKA'])){?>
	<div id="modal-setka" class="mfp-modal mfp-hide">
		<div class="mfp-modal-header">Размерная сетка</div>
		<div class="mfp-modal-content js-modal-reserve">
			<div class="catalog__item" id="" style="text-align: center; width:100%">
				<div class="catalog__item-info">
					<div class="table-responsive"><?=$arResult['SETKA']['DETAIL_TEXT']?></div>
				</div>
			</div>
		</div>
	</div>
<?}?>