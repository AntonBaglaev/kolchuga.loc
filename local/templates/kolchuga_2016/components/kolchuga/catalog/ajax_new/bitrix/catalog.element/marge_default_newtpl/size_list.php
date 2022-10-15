<?$only_one='N';
	$proprazmerCount=[];
	$proprazmerZakaz=[];
	$podmena1=['XXL'=>'2XL','XXXL'=>'3XL','XXXXL'=>'4XL','XXXXXL'=>'5XL','XXXXXXL'=>'6XL',];
	$podmena2=['2XL'=>'XXL','3XL'=>'XXXL','4XL'=>'XXXXL','5XL'=>'XXXXXL','6XL'=>'XXXXXXL',];
	foreach(reset($arResult['SKU']) as $code => $item){
		$proprazmerCount[$item['PROPERTY_RAZMER_VALUE']]=$item['CATALOG_QUANTITY'];
		$proprazmerCount[$item['PROPERTY_RAZMER_VALUE']]=[
			'ID'=>$item['ID'],
			'price'=>$item['MIN_PRICE']['PRINT_VALUE'],
			'discount'=>$item['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
			'percent'=>$item['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'],
			'max'=>$item['CATALOG_QUANTITY'],
		];
		if(!empty($podmena1[$item['PROPERTY_RAZMER_VALUE']])){
			$proprazmerCount[$podmena1[$item['PROPERTY_RAZMER_VALUE']]]=[
				'ID'=>$item['ID'],
				'price'=>$item['MIN_PRICE']['PRINT_VALUE'],
				'discount'=>$item['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
				'percent'=>$item['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'],
				'max'=>$item['CATALOG_QUANTITY'],
			];
		}
		if(!empty($podmena2[$item['PROPERTY_RAZMER_VALUE']])){
			$proprazmerCount[$podmena2[$item['PROPERTY_RAZMER_VALUE']]]=[
				'ID'=>$item['ID'],
				'price'=>$item['MIN_PRICE']['PRINT_VALUE'],
				'discount'=>$item['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
				'percent'=>$item['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'],
				'max'=>$item['CATALOG_QUANTITY'],
			];
		}
		if($item['CATALOG_QUANTITY']==1){$only_one='Y';}
	}
	
	/* \Kolchuga\Settings::xmp($proprazmerCount,11460, __FILE__.": ".__LINE__);
	\Kolchuga\Settings::xmp($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE'],11460, __FILE__.": ".__LINE__);
	\Kolchuga\Settings::xmp($arResult['SKU_SIZES_IN_STORES'],11460, __FILE__.": ".__LINE__); 
	\Kolchuga\Settings::xmp($arResult['SKU'],11460, __FILE__.": ".__LINE__); */
	foreach($arResult['SKU_SIZES_IN_STORES'] as $key1=>$store){
		if(!empty($store["SIZES"])){
			foreach($store["SIZES"] as $rzmr){
				if(!empty($podmena1[$rzmr])){
					$arResult['SKU_SIZES_IN_STORES'][$key1]["SIZES"][$podmena1[$rzmr]]=$podmena1[$rzmr];
				}
				if(!empty($podmena2[$rzmr])){
					$arResult['SKU_SIZES_IN_STORES'][$key1]["SIZES"][$podmena2[$rzmr]]=$podmena2[$rzmr];
				}
			}
		}
	}
	?>
	
<div class="size_list">
	<table>
		<tr class="size_list_thead">
			<td class="in_store">Выбрать размер</td>
			<?$arrdatabuy=[];
						foreach($arResult['LIST_DOSTUPNOST_ITEM'] as $key=>$valueI){
							$arrdatabuy[$valueI['ID']]='N';											
								if(!empty($valueI['GET_BY_SKLAD'])){													
									$arrdatabuy[$valueI['ID']]='Y';
								}else{
									if(!empty($valueI['SET_SKLAD']['114']['PRODUCT_ID'])){
										$arrdatabuy[$valueI['ID']]='LENIN';
									}elseif(!empty($valueI['SET_SKLAD']['116']['PRODUCT_ID'])){
										$arrdatabuy[$valueI['ID']]='LUBER';
									}
									/* elseif(!empty($valueI['SET_SKLAD']['699777']['PRODUCT_ID'])){
										$arrdatabuy[$valueI['ID']]='BARVIHA';
									} */
								}
							
						}
						?>
			<? foreach($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE'] as $availSize): ?>
			<td class="size_list_thead_item <?=$arResult['SKU_COUNT'] < 2 && $proprazmerCount[$availSize]['max']==1 ? 'size_list_table_active' : ''?>" data-value="<?= $proprazmerCount[$availSize]['ID']?>"
					data-price="<?=$proprazmerCount[$availSize]['price']?>"
					data-discount="<?=$proprazmerCount[$availSize]['discount']?>"
					data-percent="<?=$proprazmerCount[$availSize]['percent']?>"
					data-buy="<?=$arrdatabuy[$proprazmerCount[$availSize]['ID']]?>"
					data-max="<?=$proprazmerCount[$availSize]['max']?>"><div class=""><?=$availSize?></div></td>
			<? endforeach ?>
		</tr>
		<?
		if($only_one=='Y'){
			?>
			<tr class="size_list_thead0">
				<td class="in_store0">В наличии</td>
				<? foreach($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE'] as $availSize){ ?>
				<td data-size="<?=$availSize?>"><?=($proprazmerCount[$availSize]['max']==1 ? '1 шт.':'&nbsp;')?></td>
				<? } ?>
			</tr>
			<?
		}
		?>
		<?foreach($arResult['SKU_SIZES_IN_STORES'] as $store):?>
			<tr>
				<td class="store_name"><?=$store['STORE']['NAME']?></td>
				<? foreach($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE'] as $availSize): ?>
				<td>
					<? if(in_array($availSize, $store["SIZES"])): ?>
						<!-- <input type="checkbox" checked="checked" disabled="disabled" /> -->
						<div class="check_size"></div>
					<? else : ?>
						<div class="offstock"></div>
					<? endif ?>
				</td>
				<? endforeach ?>
			</tr>
		<?endforeach;?>
	</table>
</div>