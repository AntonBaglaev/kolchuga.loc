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
        <? foreach ($arResult['BIG_BANNERS'] as $arItem): ?>
            <div class="banner-grid__col">
                <a class="banner-grid__item" href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>">
                    <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt=""/>
                </a>
            </div>
        <? endforeach ?>
        <div class="banner-grid__col">
            <? foreach ($arResult['SMALL_BANNERS'] as $arItem): ?>
                <a class="banner-grid__item banner-grid__item_small"
                   href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>">
                    <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt=""/>
                </a>
            <? endforeach ?>
        </div>
    </div>
</div>
