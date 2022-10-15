<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
if (!$arResult['ITEMS']) return false;

?><div class="banner-grid">
    <div class="banner-grid__row">
        <? foreach ($arResult['MIDDLE_BANNERS'] as $arItem): ?>
            <div class="banner-grid__col_2">
                <a class="banner-grid__item" href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>">
                    <img src="<?= $arItem['IMG_RESIZE_SRC']?>" alt=""/>
                </a>
                <?/*<div class="desc_banner_middle">
	                <a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>">
	                	<?= $arItem['PROPERTIES']['DESC']['VALUE'] ?>
	                </a>
                </div>*/?>
            </div>
        <? endforeach ?>
    </div>
</div>
