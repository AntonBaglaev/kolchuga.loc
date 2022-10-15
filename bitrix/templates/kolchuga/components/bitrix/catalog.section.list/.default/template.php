<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="b-sections">
    <div class="b-sections__row"><?
	foreach ($arResult['SECTIONS'] as $arSection)
	{
		?><a class="b-section" href="<?= $arSection['SECTION_PAGE_URL'] ?>">
            <div class="b-section__img"><div class="b-section__img_cnt"><img src="<?= $arSection['PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>"/></div></div><span class="b-section__title"><?=$arSection['NAME']?></span>
        </a><? 
	}
	?></div>
</div>