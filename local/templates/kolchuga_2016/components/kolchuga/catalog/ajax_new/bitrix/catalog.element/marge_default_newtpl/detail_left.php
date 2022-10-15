<div class="catalog__gallery">
	<?if(count($photo_ids) > 0):?>
		<div class="catalog__gallery--big">
			<div id="slider" class="flexslider">
				<ul class="slides popup-gallery">
					<?foreach($photo_ids as $i=>$id):
						$orig =
							CFile::ResizeImageGet($id, array('width' => 1024, 'height' => 767), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 70)['src'];
						$middle =
							CFile::ResizeImageGet($id, array('width' => 544, 'height' => 399), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 60)['src'];
						?>
						<li<?if (!$i):?> class="flex-active-slide"<?endif;?>>
							<a href="<?= $orig?>">
								<img src="<?=$middle;?>" alt="<?=($detPicAlt.GetMessage('CT_ELEMENT_PICTURE_TMP', array('#N#' => ($i+1))));?>" title="<?=($detPicTitle.GetMessage('CT_ELEMENT_PICTURE_TMP', array('#N#' => ($i+1))));?>">
							</a>
						</li>
					<?endforeach;?>
				</ul>
			</div>
		</div>
		<div class="catalog__gallery--thumb">
			<div id="carousel" class="flexslider">
				<div class="flex-viewport">
					<ul class="slides">
						<?foreach($photo_ids as $i=>$id):
							$thumb =
								CFile::ResizeImageGet($id, array('width' => 112, 'height' => 85), BX_RESIZE_IMAGE_EXACT_PROPORTIONAL, false, false, false, 70)['src']?>
							<li>
								<span><img src="<?= $thumb?>" alt="<?=($detPicAlt.GetMessage('CT_ELEMENT_PICTURE_TMP', array('#N#' => ($i+1))));?>" title="<?=($detPicTitle.GetMessage('CT_ELEMENT_PICTURE_TMP', array('#N#' => ($i+1))));?>" ></span>
							</li>
						<?endforeach;?>
					</ul>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function () {
				$.post('/bitrix/components/bitrix/catalog.element/ajax.php', {
					AJAX: 'Y',
					SITE_ID: '<?=SITE_ID?>',
					PRODUCT_ID: '<?=$arResult['ID']?>',
					PARENT_ID: 0
				}, function(response){});
				
			});
		</script>
	<?else:?>
		<img src="/images/no_photo_kolchuga.jpg" >
	<?endif?>
	<div class="color-label">
		<?if($arResult["PROPERTIES"]['NOVINKA']['VALUE']){?>
			<span class="new">Новинка</span>
		<?}?>
		<?if($arResult["PROPERTIES"]['SALE']['VALUE']){?>
			<span class="sale">Sale</span>
		<?}?>
		<?if($arResult["PROPERTIES"]['SPECIAL_PRICE']['VALUE']){?>
			<span class="new">Лучшая цена</span>
		<?}?>
	</div>
</div>

<?if ($arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_NAME']) {?>
	<div class="catalog__param--title" style="margin-top: 15px;">Продается только в комплекте с:</div>
	<div class="catalog__item" id="" style="text-align: center; width:100%">
		<?if ($arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_DETAIL_PICTURE']){?>
			<div class="catalog__item-img">
				<a href="<?=$arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_URL']?>">
					<img src="<?echo CFile::ResizeImageGet($arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_DETAIL_PICTURE'], array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 60)['src']?>" alt="<?=$arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_NAME']?>" title="<?=$arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_NAME']?>">
				</a>
			</div>
		<?}?>
		<div class="catalog__item-info">
			<div class="catalog__item-title"><a href="<?=$arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_URL']?>"><?=$arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_NAME']?></a></div>
			<a class="btn btn-primary" href="<?=$arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_URL']?>" style="margin-top: 15px;">Выбрать</a>
		</div>
	</div>
<?}?>