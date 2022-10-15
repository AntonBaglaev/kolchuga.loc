<?
//echo "<pre>";print_r($group);echo "</pre>";
//echo "<pre>";print_r($arResult['PROPERTIES']['PRODUCTS_SEVERAL']["SKU2"]);echo "</pre>";
ob_start();
?>
	<?if(!empty($group['GROUP'])){?>
		<section class="block_bereta_header container mb-5 pt-5 pb-5">
			<div class="row">
				<div class="col-12 text-center">
					<h2 class="grey"><?=$group['GROUP']?></h2>
				</div>			
			</div>
		</section>
	<?}?>
	
	<section class="block_bereta_items block_bereta_items3 container mb-5 <?=$metka?>">
			<form><?=bitrix_sessid_post()?>
		<div class="row" style="justify-content: center;">	
			<?foreach($group['INFO'] as $stolb=>$valid){?>
			
				<?$item_valid=$arResult['PROPERTIES']['PRODUCTS_SEVERAL']["DOPOLNITELNO"][$valid['ID']];
				$buyId=$valid['ID'];
				?>
				
				<div class="kolonk_<?=$valid['KOL']?> <?=($valid['KOL']<=2 ? 'col-sm-6' : ($valid['KOL']==3 ? 'col-sm-4' : 'col-sm-3') )?> pl-1 pr-1 pt-3 pb-4" >
				  <div class="card h-100 pb-2">
					<div class="card-body pt-0 pl-0 pr-0 mt-1"><a class="mb-5 aspect-ratio-box" href="<?=$item_valid['DETAIL_PAGE_URL']?>"><img src="<?=$item_valid['DETAIL_PICTURE_SRC']?>" style="max-width:100%"></a>
					  <div class="row mt-2 pl-2 pr-2 text-center">
						<div class="col">
						  <h4  class='grey'><?=$item_valid['NAME']?></h4>
						  <small><??></small></div>
					  </div>
					</div>
					<div class="card-footer p-0" style="background:none;border-top:0">
					  <div class="row pl-2 pr-2">
						<div class="col text-center">
						  <h5  class='grey'><b><?=$item_valid['MIN_PRICE']['PRINT_DISCOUNT_VALUE'].(!empty($item_valid['PROPERTY_OLD_PRICE_VALUE'])? ' <del>'.$item_valid['PROPERTY_OLD_PRICE_VALUE'].'</del>':'')?></b></h5>
						  
						  <?if(!empty($arResult['PROPERTIES']['PRODUCTS_SEVERAL']['SKU2'][$item_valid['PROPERTY_IDGLAVNOGO_VALUE']])){							  
								/* $mmm=[];					
								foreach( $arResult['PROPERTIES']['PRODUCTS_SEVERAL']['SKU2'][$item_valid['PROPERTY_IDGLAVNOGO_VALUE']] as $el){
									if(!empty($el['RAZMER'])){
										$mmm[]=$el['RAZMER'];
									}								
								}
								if(!empty($mmm)){?>
									<small class="">Размеры: <?=implode(' | ',$mmm)?></small>
								<?} */
								
								$set=0;
								foreach( $arResult['PROPERTIES']['PRODUCTS_SEVERAL']['SKU2'][$item_valid['PROPERTY_IDGLAVNOGO_VALUE']] as $kl=>$el){
									if($kl==$buyId){$set=$kl;}
								}
								if($set<1){
									
									if (!function_exists('array_key_first')) {
										$key_first = array_keys($arResult['PROPERTIES']['PRODUCTS_SEVERAL']['SKU2'][$item_valid['PROPERTY_IDGLAVNOGO_VALUE']]);
										$set = $key_first[0];
									}else{
										$set= array_key_first($arResult['PROPERTIES']['PRODUCTS_SEVERAL']['SKU2'][$item_valid['PROPERTY_IDGLAVNOGO_VALUE']]);
									}
									$buyId=$set;
								}
								
								?><small class="smallmetki<?=$group['BLOCK']?><?=$stolb?>">Размеры:<?
									foreach( $arResult['PROPERTIES']['PRODUCTS_SEVERAL']['SKU2'][$item_valid['PROPERTY_IDGLAVNOGO_VALUE']] as $kl=>$el){
										?><span class="element-razmer<?=($kl==$buyId ? ' thiselement':'')?>" data-razmer='<?=$el['RAZMER']?>' data-kol='<?=$el['QUANTITY']?>' data-id='<?=$kl?>' data-bl='<?=$group['BLOCK']?>' data-st='<?=$stolb?>'><?=$el['RAZMER']?></span><?
									}
								?></small><?								
							}?>
						  
						</div>
					  </div>
					  <div class="row pl-2 pr-2 mt-3">
						<div class="col main__btn2"><a class=" btn-block  rounded-0 " href="<?=$item_valid['DETAIL_PAGE_URL']?>" data-id="<?=$valid['ID']?>">Подробнее</a></div>						
					  </div>
					</div>
				  </div>
				</div>
				<input name='blockimetki[<?=$group['BLOCK']?>][<?=$stolb?>]' id='blockimetki<?=$group['BLOCK']?><?=$stolb?>' value='<?=$buyId?>' type='hidden' />
			<?}?>
		</div>
			</form>
				<div class="row">
					<div class=" main__btn" style='width:100%'><a href="javascript:void(0);" class="btn-block  rounded-0 addinbasket" style="max-width:220px;">В корзину</a></div>					
				</div>
				<div class="row">
					<div class="textresult"></div>
				</div>
	</section>
<?
$out1 = ob_get_contents(); 
ob_end_clean(); 
return $out1;
?>