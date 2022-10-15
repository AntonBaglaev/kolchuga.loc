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

?><div class="flexslider js_slider">
    <ul class="slides"><?
        foreach ($arResult['ITEMS'] as $arItem)
        {
            if (!$arItem['PREVIEW_PICTURE']['SRC']) continue;

            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction( $arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

        ?><li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <?if ($arItem['PROPERTIES']['LINK']['VALUE']):?><a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>"><? endif?>
                <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>"/>
            <?if ($arItem['PROPERTIES']['LINK']['VALUE']):?></a><?endif?>
        </li><?

        }

    ?></ul>
</div>
<script>
    $(document).ready(function(){
        $('.js_slider').flexslider({
            animation: "fade",
            prevText: "",
            nextText: "",
        });
    });
</script>
