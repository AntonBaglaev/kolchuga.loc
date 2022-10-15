<?
    // вывод блока
    $rest = CIBLockElement::GetList (Array(), Array('ACTIVE'=>'Y', 'IBLOCK_ID' => '62'), false, false, Array('*'));
    while ($db_item = $rest->GetNextElement())
    {
    $ar_rest[] = $db_item->GetProperties();
    }
    
    ?>
<section id="banners">
	<div class="banners dflex">
	<?foreach ($ar_rest as $val){?>
	<?
	$arFile = \Kolchuga\Pict::getWebpImgSrc( \CFile::GetPath($val["PICTURE"]['VALUE']) , $intQuality = 90);
	if(!empty($val["PICTURE_MOB"]['VALUE'])){
		$arFilemob = \Kolchuga\Pict::getWebpImgSrc( \CFile::GetPath($val["PICTURE_MOB"]['VALUE']) , $intQuality = 90);
	}
	?>
		<div class="banners__item banner">
			<a href="<?=$val["LINK"]['VALUE']?>">
				<?/*<img src="<?=CFile::GetPath($val["PICTURE"]['VALUE'])?>" class="<?if(!empty($val["PICTURE_MOB"]['VALUE'])){?>d-none d-md-block<?}?>" />
				<?if(!empty($val["PICTURE_MOB"]['VALUE'])){?><img src="<?=CFile::GetPath($val["PICTURE_MOB"]['VALUE'])?>" class="d-md-none" /><?}?>*/?>
				
				<picture class="<?if(!empty($val["PICTURE_MOB"]['VALUE'])){?>d-none d-md-block<?}?>">
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" alt="<?=$val["NAME"]?>" />
				</picture>
				<?if(!empty($val["PICTURE_MOB"]['VALUE'])){?>
					<picture class="d-md-none">
						<?if ($arFilemob['DETAIL_PICTURE']['WEBP_SRC']) :?>
							<source type="image/webp" srcset="<?=$arFilemob['DETAIL_PICTURE']['WEBP_SRC']?>">
						<?endif;?>
						<img src="<?=$arFilemob["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$val["NAME"]?>" />
					</picture>
				<?}?>
			</a>
			<div class="banner__info">
				<div class="banner__title"><?=$val["TEXT_PICTURE"]['VALUE']?></div>
				<?if(!empty($val["TEXT_BTN"]['VALUE'])){?><div class="banner__btn main__btn"><a href="<?=$val["LINK"]['VALUE']?>"><?=$val["TEXT_BTN"]['VALUE']?></a></div><?}?>
			</div>
		</div>
	<?}?>
	</div>
</section>