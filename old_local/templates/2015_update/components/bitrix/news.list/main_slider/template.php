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
?>
<div class="b-main-slider">
    <ul class="b-main-slider_ul">
        <? foreach ($arResult['ITEMS'] as $arItem):
            if (!$arItem['PREVIEW_PICTURE']['SRC']) continue?>
            <li class="b-main-slider__item">
                <? if ($arItem['PROPERTIES']['LINK']['VALUE']):?><a
                    href="<?= $arItem['PROPERTIES']['LINK'] ?>"><? endif?>
                    <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>"/>
                    <? if ($arItem['PROPERTIES']['LINK']['VALUE']):?></a><? endif?>
            </li>
        <? endforeach ?>
    </ul>
</div>

