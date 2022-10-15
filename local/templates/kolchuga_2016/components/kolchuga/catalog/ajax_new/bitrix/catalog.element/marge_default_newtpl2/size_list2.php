<div class="size_list">
	<table>
		<tr class="size_list_thead">
			<td class="in_store">Выбрать размер</td>
			<? foreach($arResult['TABLE_RAZMER_ARR']['SKU'] as $availSize0){ 
				foreach($availSize0 as $availSize){ 
				?><!--pre>arResultaaaI <?print_r($availSize);?></pre--><?
					$dostup='N';
					if($arResult['TABLE_RAZMER_ARR']['ONE'][$availSize['razmer']] > 0){$dostup='Y';}else{
						if($availSize['sklad_id']==114){$dostup='LENIN';}
						elseif($availSize['sklad_id']==116){$dostup='LUBER';}
						//elseif($availSize['sklad_id']==699777){$dostup='BARVIHA';}
					}			
					?>
					<td class="size_list_thead_item <?=$arResult['SKU_COUNT'] < 2 && $proprazmerCount[$availSize]['max']==1 ? 'size_list_table_active' : ''?>" 
						data-value="<?= $availSize['tovar']?>"
						data-price="<?= $availSize['price']?>"
						data-discount="<?= $availSize['discount']?>"
						data-percent="<?= $availSize['percent']?>"
						data-buy="<?=$dostup?>"
						data-max="<?= $availSize['max']?>"><div class=""><?=$availSize['razmer']?></div></td>
				<?}?>
				<?break;?>
			<?}?>
		</tr>	
		<?
		if($arResult['TABLE_RAZMER_ARR']['SET_ONE']=='Y'){
			?>
			<tr class="size_list_thead0">
				<td class="in_store0">В наличии</td>
				<? foreach($arResult['TABLE_RAZMER_ARR']['ONE'] as $razmr=>$availSize){ ?>
				<td data-size="<?=$razmr?>"><?=($availSize==1 ? '1 шт.':'&nbsp;')?></td>
				<? } ?>
			</tr>
			<?
		}
		?>
		<?foreach($arResult['TABLE_RAZMER_ARR']['SKU'] as $namestore=>$store):?>
			<tr>
				<td class="store_name"><?=$namestore?></td>
				<? foreach($store as $availSize): ?>
					<td>
						<? if($availSize['on_sklad']>0): ?>						
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