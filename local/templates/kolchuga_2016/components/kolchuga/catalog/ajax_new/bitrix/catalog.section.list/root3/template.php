<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="b-sections">

<?if(!empty($arResult['NEW_SECTIONS'])){?>
<div class="title-page c_h1">
    <h1 class="js-page-title"><?=$arResult['SECTION']['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']?></h1>
</div>

<?$razmer=[
	765708=>'col-12 col-md-6',
	765709=>'col-6  col-md-4',
	765710=>'col-6 col-md-2',
	765745=>'col-6 col-md-3',
];?>
<div class="container-fluid ">
	<div class="row">
		<?foreach ($arResult['NEW_SECTIONS'] as $arSection){?>
			<div class="<?=$razmer[$arSection['PROPERTY_RAZMER_ENUM_ID']]?> text-center mb-2 mlh pl10 pr0">
				<?/*<div class="title_line"><span><?=$arSection['NAME']?></span></div>*/?>
				<div class="separator"><?=$arSection['NAME']?></div>
				<?if(!empty($arSection['SECTION_PAGE_URL'])){?><a href="<?=$arSection['SECTION_PAGE_URL']?>"><?}?>
				<?/* <img src='<?=$arSection['DETAIL_PICTURE_SRC']?>' class=" img-0" /> */?>
				<?$arFile = \Kolchuga\Pict::getWebpImgSrc($arSection['DETAIL_PICTURE_SRC'], $intQuality = 80);?>
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" class=" img-0" />
				</picture>
				<?if(!empty($arSection['SECTION_PAGE_URL'])){?></a><?}?>
			</div>
		<?}?>

	</div>
</div>

<?}else{?>
   <?/* <div class="b-sections__row"><?
	foreach ($arResult['SECTIONS'] as $arSection)
	{
		?><a onclick="return true;" class="b-section" href="<?= $arSection['SECTION_PAGE_URL'] ?>">

			<?

             $arSection['PICTURE']['SRC'] =
                    CFile::ResizeImageGet($arSection['PICTURE']["ID"], 
                                          array('width' => 200, 'height' => 150), 
                                          BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 60)['src'];
             ?>

            <div class="b-section__img"><div class="b-section__img_cnt"><img src="<?= $arSection['PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>"/></div></div><span class="b-section__title"><?=$arSection['NAME']?></span>
        </a><? 
	}
	?></div>*/?>
<?}?>
</div>