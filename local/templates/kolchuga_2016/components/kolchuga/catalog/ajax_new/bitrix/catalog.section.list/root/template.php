<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="b-sections">
    <div class="b-sections__row"><?
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
	?></div>
</div>