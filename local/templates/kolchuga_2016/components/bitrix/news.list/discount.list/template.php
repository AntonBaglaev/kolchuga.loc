<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(!empty($arParams['MASONRY']) && $arParams['MASONRY']=='N'){?>
<div class="row">
<section class="container-fluid mason_block mb-5">
	<div class="row">
	<?foreach($arResult["ITEMS"] as $arItem){?>
		<div class="col-sm-6 col-md-4 text-center">
			<div class="item">
			<a href="<?=$arItem['DISPLAY_PROPERTIES']['LINK']['VALUE']?>" style="background: transparent url(<?=$arItem['PREVIEW_PICTURE']['SRC']?>) center center /contain no-repeat;" class="imgitem" ></a>
			<div class='textitem'><?=$arItem['NAME']?></div>
			<a href="<?=$arItem['DISPLAY_PROPERTIES']['LINK']['VALUE']?>"><strong>Подробнее&nbsp;»</strong></a> 
			</div>	
			
		</div>
		
	<?}?>	
	</div>
</section>
</div>
<?}else{?>
<div class="masonry">

<?foreach($arResult["ITEMS"] as $arItem){?>
	<?//echo "<pre style='text-align:left;margin:5px;'>";print_r($arItem);echo "</pre>";?>
	
	<div class="item">
		<a href="<?=$arItem['DISPLAY_PROPERTIES']['LINK']['VALUE']?>" class="aimg"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"></a>
		<br>
		<div class='textitem'><?=$arItem['NAME']?></div>
		<a href="<?=$arItem['DISPLAY_PROPERTIES']['LINK']['VALUE']?>"><strong>Подробнее&nbsp;»</strong></a>
	</div>
	
<?}?>
</div>
	
<?}?>