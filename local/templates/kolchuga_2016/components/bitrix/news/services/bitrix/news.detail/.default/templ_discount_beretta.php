<?
ob_start(); 
//\Kolchuga\Settings::xmp($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["SKU2"],11460, __FILE__.": ".__LINE__);
?>       
<section class="block_bereta_items block_bereta_items3 container mb-5 <?=$mt?>">
						<div class="row" style="justify-content: center;">						
							<? 
							$colonok=count($vl);
							foreach($vl as $valid){
							?>								
							<div class="kolonk_<?=$colonok?> <?=($colonok<=2 ? 'col-sm-6' : 'col-sm-4' )?> pl-1 pr-1 pt-3 pb-4" >
							  <div class="card h-100 pb-2">
								<div class="card-body pt-0 pl-0 pr-0 "><a class="mb-5 aspect-ratio-box" href="<?=$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PAGE_URL']?>"><img src="<?=$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PICTURE_SRC_ORIG']?>" style="max-width:100%"></a>
								  <div class="row mt-2 pl-2 pr-2 text-center">
									<div class="col">
									  <h4  class='grey'><?=$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['NAME']?></h4>
									  <small><??></small></div>
								  </div>
								</div>
								<div class="card-footer p-0" style="background:none;border-top:0">
								  <div class="row pl-2 pr-2">
									<div class="col text-center">
									  <h5  class='grey'><b><?=$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['MIN_PRICE']['PRINT_DISCOUNT_VALUE'].(!empty($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'])? ' <del>'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'].'</del>':'')?></b></h5>
								  <?
									$glavgad=$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']['SKU2'][$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_IDGLAVNOGO_VALUE']];
										if(!empty($glavgad)){
										$mmm=[];
										foreach( $glavgad as $el){
											if(!empty($el['RAZMER'])){
												$mmm[]=$el['RAZMER'];
											}					
										}
										if(!empty($mmm)){
											?><div class="block_razmer" >Размеры: <?=implode(' | ',$mmm)?></div><?
										}
									}?>
									</div>
								  </div>
								  <div class="row pl-2 pr-2 mt-3">
									<div class="col main__btn2"><a class=" btn-block  rounded-0 " href="<?=$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PAGE_URL']?>" data-id="<?=$arItem['ID']?>">Подробнее</a></div>
									
								  </div>
								</div>
							  </div>
							</div>							
							<?}?>		
						</div>
					</section>
<?
//return ob_get_clean();
$out1 = ob_get_contents(); 
ob_end_clean(); 
return $out1; 
?>