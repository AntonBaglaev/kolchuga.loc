<?//echo "<pre style='text-align:left;'>";print_r($arResult['PROPERTIES']['TOVAR']['INFO']);echo "</pre>";?>
<section class="block_bereta_items block_bereta_items2 container mb-5 ">
	<div class="row">
<?foreach($arResult['PROPERTIES']['TOVAR']['INFO'] as $val){?>
	<div class="col-sm-6 pb-5">
			  <div class="card h-100 pb-2">
				<div class="card-body pt-0 pl-0 pr-0">
					<?
						$galerea=[];
						$galereaId=[];
						$contslid=0;
						if(!empty($val['PREVIEW_PICTURE']['SRC'])){
							$galerea[]=$val['PREVIEW_PICTURE']['SRC']; 
							$galereaId[]=$val['PREVIEW_PICTURE']['ID']; 
							$contslid++;
						}
						if(!empty($val['DETAIL_PICTURE'])){
							$galerea[]=\CFile::GetPath($val['DETAIL_PICTURE']); 
							$galereaId[]=$val['DETAIL_PICTURE']; 
							$contslid++;
						}
						if(!empty($val['PROP']['MORE_PHOTO']['VALUE'])){
							$contslid += count($val['PROP']['MORE_PHOTO']['VALUE']);
							foreach($val['PROP']['MORE_PHOTO']['VALUE'] as $kl=>$fto){
								$galerea[]=\CFile::GetPath($fto);
								$galereaId[]=$fto;
							}		
						}	
					
					?>
					<?
					if($contslid>1){?>					
						<div class="flexslider flexslider--theme-2 js_fx_slider"><ul class="slides aspect-ratio-box1">
							
							
							<?foreach($galerea as $kl=>$fto){?>
								<li class="slide-container aspect-ratio-box">
									<img src="<?=$fto?>" style="max-width:100%" />									
								</li>
							<?}?>
							
							
							
						</ul></div>		
												
					<?}else{?>
						<a href="<?=$val['DETAIL_PAGE_URL']?>"  class="aspect-ratio-box">
							<img src="<?=$galerea[0]?>" style="max-width:100%">
						</a>
					<?}?>
					<div class="row mt-2 pl-2 pr-2 text-center">
						<div class="col">
							<h4 class='grey js-page-title-<?=$val['ID']?>'><a href="<?=$val['DETAIL_PAGE_URL']?>"><?=$val['NAME']?></a></h4>
							<small><?=(!empty($val['PROP']['TEXT_BERETTA']['VALUE']['TEXT']) ? $val['PROP']['TEXT_BERETTA']['VALUE']['TEXT'] : '')?></small>
						</div>
					</div>
				</div>
				<div class="card-footer p-0" style="background:none;border-top:0">
				  <div class="row pl-2 pr-2">
					<div class="col text-center">
					   <h5 class='grey'><b class="js-price-<?=$val['ID']?>"><?=$val['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></b></h5>
					</div>
				  </div>
				  <div class="row pl-2 pr-2 mt-3">
					<div class="col <?if($val['CATALOG_AVAILABLE']=='Y_old' ){?>pr-1<?}?>"><a class="btn btn-block podrobnee-<?=$val['ID']?> rounded-0 " href="<?=$val['DETAIL_PAGE_URL']?>" data-id="<?=$val['ID']?>">Подробнее</a></div>
					
					<?if($val['CATALOG_AVAILABLE']=='Y_old' ){?>
						<div class="col pl-1"><a href="#modal-buyoneclick-list" rel="nofollow" rel_mc="rezerv" class="btn btn-block rounded-0 popup-modal js-popup-modal-store" data-code="<?=$val['ID']?>">Зарезервировать</a></div>
					<?}?>
				  </div>
				</div>
			  </div>
			</div>
<?}?>
	</div>
</section>