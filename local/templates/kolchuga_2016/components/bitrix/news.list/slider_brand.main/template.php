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
//echo "<pre>";print_r($arResult);echo "</pre>";die;

?>


<section class="container-fluid mb-5 d-none d-md-block">
	<div class="row">
	
	<div class="flexslider js_slider">
    <ul class="slides bigslides"><?
        foreach ($arResult['ITEMS'] as $arItem)
        {
            if (!$arItem['PREVIEW_PICTURE']['SRC']) continue;           

        ?><li style="background:<?=(!empty($arItem['PROPERTIES']['COLOR_FON']['VALUE'])?$arItem['PROPERTIES']['COLOR_FON']['VALUE']:"#000")?> url('<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>') center center no-repeat;" onclick="locationgo('<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>')">
		<div class="container">
		<div class="row">
		<div class="col-12 ">
			
			<?/*<div class="slider-name" style=""><?=(!empty($arItem['PROPERTIES']['NAME_HTML']['VALUE'])? $arItem['PROPERTIES']['NAME_HTML']['~VALUE']:$arItem['NAME'])?></div>
		
            <?if (!empty($arItem['PROPERTIES']['LINK']['VALUE'])):?><a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>" class="biga" style=""><? endif?>		
                <?=$arItem['PROPERTIES']['LINK_TITLE']['VALUE']?>
            <?if (!empty($arItem['PROPERTIES']['LINK']['VALUE'])):?></a><?endif?>
			
			<div class="slider-text" style=""><?=$arItem['PREVIEW_TEXT']?></div>*/?>
			<?if(!empty($arItem['DISPLAY_PROPERTIES']['LOGO_USER']['FILE_VALUE'])){?>
				<div class="slider-logo" style=""><img src="<?=$arItem['DISPLAY_PROPERTIES']['LOGO_USER']['FILE_VALUE']['SRC']?>" width="100" /></div>
			<?}?>
		</div>
			
			
			</div></div>
        </li><?	
		
        }

    ?></ul>
</div>
		
	</div>
</section>
<section class="container-fluid mb-5 d-block d-md-none">
	<div class="row">
	
	<div class="flexslider js_slider">
    <ul class="slides minslaides"><?
        foreach ($arResult['ITEMS'] as $arItem)
        {
            if (!$arItem['DETAIL_PICTURE']['SRC']) continue;           

        ?><li style="background:<?=(!empty($arItem['PROPERTIES']['COLOR_FON']['VALUE'])?$arItem['PROPERTIES']['COLOR_FON']['VALUE']:"#000")?> url('<?= $arItem['DETAIL_PICTURE']['SRC'] ?>') center center no-repeat;" onclick="locationgo('<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>')" >
		<div class="container">
		<div class="row">
		<div class="col-12 ">
			
			<?/*<div class="slider-name" style=""><?=$arItem['NAME']?></div>
		
            <?if (!empty($arItem['PROPERTIES']['LINK']['VALUE'])):?><a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>" class="biga" style=""><? endif?>		
                <?=$arItem['PROPERTIES']['LINK_TITLE']['VALUE']?>
            <?if (!empty($arItem['PROPERTIES']['LINK']['VALUE'])):?></a><?endif?>
			
			<div class="slider-text" style=""><?=$arItem['DETAIL_TEXT']?></div>*/?>
			<?if(!empty($arItem['DISPLAY_PROPERTIES']['LOGO_USER']['FILE_VALUE'])){?>
					<div class="slider-logo" style=""><img src="<?=$arItem['DISPLAY_PROPERTIES']['LOGO_USER']['FILE_VALUE']['SRC']?>" width="100" /></div>
			<?}?>
		</div>
			
			
			</div></div>
        </li><?	
		
        }

    ?></ul>
</div>
		
	</div>
</section>


<script>
    $(document).ready(function(){
        $('.js_slider').flexslider({
            animation: "fade",
            prevText: "",
            nextText: "",
			controlNav: true,
        });
    });
</script>
