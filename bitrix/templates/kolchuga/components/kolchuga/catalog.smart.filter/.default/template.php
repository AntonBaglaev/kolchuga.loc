<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/js/nouislider.min.css');
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/nouislider.min.js');
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/wNumb.js');
?>

<div id="filter" class="clearfix">
	<form class="b-filter" name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>" method="get">
		
		<? foreach ($arResult["HIDDEN"] as $arItem): 
			if($arItem["CONTROL_NAME"] == 'PICTURE_ONLY' || $arItem["CONTROL_NAME"] == 'NOT_PICTURE_ONLY') continue;
		?>
            <input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>"
                   value="<? echo $arItem["HTML_VALUE"] ?>"/>
        <? endforeach; ?>
		
		<div class="b-filter__row js-filter-row">
			<div class="b-filter__title">Фильтр товаров</div>
		</div>
		<? foreach ($arResult["PRICE_ITEMS"] as $key => $arItem)
		{
			$key = $arItem["ENCODED_ID"];
			if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
			continue; 
		?>
			<div class="b-filter__row js-filter-row">
				<div class="b-filter__item b-filter__item_nob filter_price">
					<div class="b-filter__name b-filter__name_price js-price-item"><span>Цена</span></div>
					<div class="b-filter-options b-filter-price">
						<span>от</span>
						<input type="text" 
								name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
								value="<?= intval($arItem['VALUES']['MIN']['HTML_VALUE'] ?
									   $arItem['VALUES']['MIN']['HTML_VALUE'] :
									   $arItem['VALUES']['MIN']['VALUE']) ?>"
								class="js-range-in">
						<span>до</span>
						<input type="text" 
							   name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
							   value="<?= intval($arItem['VALUES']['MAX']['HTML_VALUE'] ?
									   $arItem['VALUES']['MAX']['HTML_VALUE'] :
									   $arItem['VALUES']['MAX']['VALUE']) ?>"
								class="js-range-in">
						<span>рублей</span>
					</div>
					<div class="price-slider" id="priceSlider_<?=$arItem['ID']?>"></div>		
				</div>
			</div>	
		<?
		}
			if($arResult['BRAND_ITEM'] && $arResult['BRAND_ITEM']['VALUES']):
		?>
			<div class="b-filter__row js-filter-row">
				<div class="b-filter__item b-filter__item_full">
					<div class="b-filter__name"><span><?=$arResult['BRAND_ITEM']['NAME']?></span></div>
					<div class="b-filter-options">
						<?foreach($arResult['BRAND_ITEM']['VALUES'] as $arValue):?>
						<div class="b-filter-options__item">
							<input
								type="checkbox"
								name="<?= $arValue['CONTROL_NAME'] ?>"
								value="<?= $arValue['HTML_VALUE'] ?>"
								<?= $arValue["CHECKED"] ? ' checked' : '' ?>>
							<label><?=$arValue['VALUE']?></label>
						</div>
						<?endforeach;?>
					</div>	
				</div>
			</div>
            <?endif; 
	        foreach ($arResult['ITEMS'] as $key => $arChunk):?>
	        	<?

					foreach($arChunk as $key => $arItem)
					{
						if(!$arItem['VALUES']) continue;
						
						if ($arItem['DISPLAY_TYPE'] !== 'A' && $arItem['DISPLAY_TYPE'] !== 'B')
						{
							?><div class="b-filter__row js-filter-row">
								<div class="b-filter__item">
									<div class="b-filter__name"><span><?=$arItem['NAME']?></span></div>
									<div class="b-filter-options">
									<?foreach($arItem['VALUES'] as $arValue):?>
										<div class="b-filter-options__item">
											<input 
													type="checkbox"
													name="<?= $arValue['CONTROL_NAME'] ?>"
													value="<?= $arValue['HTML_VALUE'] ?>"
													<?= $arValue["CHECKED"] ? ' checked' : '' ?>>
											<label><?=$arValue['VALUE']?></label>
										</div>
										<?endforeach;?>	
									</div>	
								</div>
							</div><?
						}
					}
					?>
					<?/*if(count($arChunk) == 1):?>
					<div class="b-filter__item"></div>
					<?endif*/?>	
			<?endforeach;?>
				
		<?
			$sort = array(
				'NAME' => 'Названию',
				'CATALOG_PRICE_2' => 'Цене'
			);
		?>
				
		<div class="b-filter__row filter_result">
			<div class="filter_result_1 b-filter__item_nob">
				<div class="sort-item">
					<span>Сортировать по</span>&nbsp;
					<select class="js-sort-sel" name="sort_field">
						<?foreach($sort as $key=> $item):?>
						<option 
							<?if($_REQUEST['sort_field'] == $key && $_REQUEST['sort_order'] == 'asc'):?>selected<?endif?> 
							value="<?=$key?>" data-order="asc"><?=$item?> &uarr;</option>
						<option <?if($_REQUEST['sort_field'] == $key && $_REQUEST['sort_order'] == 'desc'):?>selected<?endif?> 
							value="<?=$key?>" data-order="desc"><?=$item?> &darr;</option>
						<?endforeach?>
					</select>
					<input type="hidden" name="sort_order" value="<?=$_REQUEST['sort_order'] ? $_REQUEST['sort_order'] : 'asc'?>">
				</div>
				<div class="sort-item">
					<span>Выводить по</span>&nbsp;
					<select name="PAGEN_SIZE">
						<option value="24" <?if($_GET['PAGEN_SIZE'] == 24) echo 'selected';?>>24 товара</option>
						<option value="48" <?if($_GET['PAGEN_SIZE'] == 48) echo 'selected';?>>48 товаров</option>
						<option value="99" <?if($_GET['PAGEN_SIZE'] == 99) echo 'selected';?>>99 товаров</option>
						<option value="500" <?if($_GET['PAGEN_SIZE'] == 500) echo 'selected';?>>все товары</option>
					</select>
				</div>
				<div class="sort-item">
					<label>Только с фото</label>
					<input 
							type="checkbox"
							name="PICTURE_ONLY"
							class="js-filter-pict"
							value="1"
							<?= $_GET["NOT_PICTURE_ONLY"] == 1 ? '' : 'checked';?>>
				</div>
			</div>
			<div class="filter_result_2">
				<a class="submit" href="<?=$APPLICATION->GetCurPage();?>" class="submit">Сбросить фильтр</a>
				<input class="submit" type="submit" name="set_filter" value="Показать">
			</div>
		</div>
	</form>
</div>

<script>
$(document).ready(function(){

	<?foreach($arResult['PRICE_ITEMS'] as $key => $arItem):?>
	if($('#priceSlider_<?=$arItem['ID']?>').length > 0){
		var slider_<?=$arItem['ID']?> = document.getElementById('priceSlider_<?=$arItem['ID']?>');
	
		noUiSlider.create(slider_<?=$arItem['ID']?>, {
			start: [
				<?= intval($arItem['VALUES']['MAX']['HTML_VALUE'] ? $arItem['VALUES']['MIN']['HTML_VALUE'] : $arItem['VALUES']['MIN']['VALUE']) ?>, 
				<?= intval($arItem['VALUES']['MAX']['HTML_VALUE'] ? $arItem['VALUES']['MAX']['HTML_VALUE'] : $arItem['VALUES']['MAX']['VALUE']) ?>
			],
			connect: true,
			range: {
				'min': <?=intval($arItem['VALUES']['MIN']['VALUE'])?>,
				'max': <?=intval($arItem['VALUES']['MAX']['VALUE'])?>
			},
			step: 100,
			format: wNumb({
				decimals: 0,
				thousand: ' ',
				postfix: ''
			})
		});
		
		slider_<?=$arItem['ID']?>.noUiSlider.on('update', function( values, handle ) {
			$('#priceSlider_<?=$arItem['ID']?>').parents('.js-filter-row').find('.js-range-in').eq(handle).val(values[handle]);
		});
		
		$('.js-range-in').change(function(){
			var inputs = $('#priceSlider_<?=$arItem['ID']?>').parents('.js-filter-row').find('.js-range-in');
			slider_<?=$arItem['ID']?>.noUiSlider.set([inputs.eq(0).val(), $('.js-range-in').eq(1).val()]);	
		});
	}
		
	<?endforeach;?>
	$('.b-filter__name span').click(function(){
		$(this).parent().toggleClass('active');
	});
	$('.js-sort-sel').change(function(){
		var order = $(this).find('option:selected').data('order');
		$(this).next().val(order);
	});
	
	$('.b-filter').submit(function(e){
		$(this).find('.js-range-in').each(function(){
			var _v = wNumb({
					mark: '',
					thousand: ' ',
					prefix: '',
					postfix: ''
				}).from($(this).val());
			
			$(this).val(_v);	
		})
	});

});
</script>


