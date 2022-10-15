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
//\Kolchuga\Settings::xmp($arResult['ITEMS'],11460, __FILE__.": ".__LINE__);
?>


<section class="slider-full-main slider-full-main-big container-fluid mb-5 d-none d-md-block">
	<div class="row">
	
	<div class="flexslider js_slider">
    <ul class="slides bigslides"><?
        foreach ($arResult['ITEMS'] as $arItem)
        {
            if (!$arItem['PREVIEW_PICTURE']['SRC']) continue; 
			
			if ($arItem['PREVIEW_PICTURE']['CONTENT_TYPE']!='image/gif'){
			
				$arItem['PREVIEW_PICTURE']['SRC_old']=$arItem['PREVIEW_PICTURE']['SRC'];
				$arItem['PREVIEW_PICTURE'] = \Kolchuga\Pict::getWebp($arItem['PREVIEW_PICTURE'],90);

				?><li style="background:<?=(!empty($arItem['PROPERTIES']['COLOR_FON']['VALUE'])?$arItem['PROPERTIES']['COLOR_FON']['VALUE']:"#000")?> url('<?= $arItem['PREVIEW_PICTURE']['WEBP_SRC'] ?>') center center no-repeat;" onclick="locationgo('<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>')" data-bg="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" data-bg-webp="<?= $arItem['PREVIEW_PICTURE']['WEBP_SRC'] ?>">
			<?}else{?>
				<li style="background:<?=(!empty($arItem['PROPERTIES']['COLOR_FON']['VALUE'])?$arItem['PROPERTIES']['COLOR_FON']['VALUE']:"#000")?> url('<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>') center center no-repeat;" onclick="locationgo('<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>')" >
			<?}?>
		<div class="container">
		<div class="row">
		<div class="col-12 ">
			
			<div class="slider-name" style=""><?=(!empty($arItem['PROPERTIES']['NAME_HTML']['VALUE'])? $arItem['PROPERTIES']['NAME_HTML']['~VALUE']:$arItem['NAME'])?></div>
		
            <?if (!empty($arItem['PROPERTIES']['LINK']['VALUE']) && !empty($arItem['PROPERTIES']['LINK_TITLE']['VALUE'])):?><a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>" class="biga"
				style="<?= $arItem['PROPERTIES']['BUTTON_COLOR']['VALUE'] ? 'color:' . $arItem['PROPERTIES']['BUTTON_COLOR']['VALUE'] . ';' : '' ?><?= $arItem['PROPERTIES']['BUTTON_BG_COLOR']['VALUE'] ? 'background-color:' . $arItem['PROPERTIES']['BUTTON_BG_COLOR']['VALUE'] . ';' : '' ?>"><? endif?>		
                <?=$arItem['PROPERTIES']['LINK_TITLE']['VALUE']?>
            <?if (!empty($arItem['PROPERTIES']['LINK']['VALUE']) && !empty($arItem['PROPERTIES']['LINK_TITLE']['VALUE'])):?></a><?endif?>
			
			<div class="slider-text" style=""><?=$arItem['PREVIEW_TEXT']?></div>
			<?if(!empty($arItem['DISPLAY_PROPERTIES']['LOGO_USER']['FILE_VALUE'])){?>
				<div class="slider-logo" style=""><img src="<?=$arItem['DISPLAY_PROPERTIES']['LOGO_USER']['FILE_VALUE']['SRC']?>" width="100" alt="<?=$arItem['NAME']?> - логотип" /></div>
			<?}?>
		</div>
			
			
			</div></div>
        </li><?	
		
        }

    ?></ul>
</div>
		
	</div>
</section>
<section class="slider-full-main slider-full-main-mini container-fluid mb-5 d-block d-md-none">
	<div class="row">
	
	<div class="flexslider js_slider">
    <ul class="slides minslaides"><?
        foreach ($arResult['ITEMS'] as $arItem)
        {
            if (!$arItem['DETAIL_PICTURE']['SRC']) continue;     
			$arItem['DETAIL_PICTURE']['SRC_old']=$arItem['DETAIL_PICTURE']['SRC'];
			$arItem['DETAIL_PICTURE'] = \Kolchuga\Pict::getWebp($arItem['DETAIL_PICTURE'],90);

        ?><li style="background:<?=(!empty($arItem['PROPERTIES']['COLOR_FON']['VALUE'])?$arItem['PROPERTIES']['COLOR_FON']['VALUE']:"#000")?> url('<?= $arItem['DETAIL_PICTURE']['WEBP_SRC'] ?>') center center no-repeat;" onclick="locationgo('<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>')" data-bg="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>" data-bg-webp="<?= $arItem['DETAIL_PICTURE']['WEBP_SRC'] ?>">
		<div class="container">
		<div class="row">
		<div class="col-12 ">
			
			<div class="slider-name" style=""><?=(!empty($arItem['PROPERTIES']['NAME_HTML_MOB']['VALUE'])? $arItem['PROPERTIES']['NAME_HTML_MOB']['~VALUE']:(!empty($arItem['PROPERTIES']['NAME_HTML']['VALUE'])? $arItem['PROPERTIES']['NAME_HTML']['~VALUE']:$arItem['NAME']))?></div>
		
            <?if (!empty($arItem['PROPERTIES']['LINK']['VALUE']) && !empty($arItem['PROPERTIES']['LINK_TITLE']['VALUE'])):?><a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>" class="biga" style=""><? endif?>		
                <?=$arItem['PROPERTIES']['LINK_TITLE']['VALUE']?>
            <?if (!empty($arItem['PROPERTIES']['LINK']['VALUE']) && !empty($arItem['PROPERTIES']['LINK_TITLE']['VALUE'])):?></a><?endif?>
			
			<div class="slider-text" style=""><?=$arItem['DETAIL_TEXT']?></div>
			<?if(!empty($arItem['DISPLAY_PROPERTIES']['LOGO_USER']['FILE_VALUE'])){?>
					<div class="slider-logo" style=""><img src="<?=$arItem['DISPLAY_PROPERTIES']['LOGO_USER']['FILE_VALUE']['SRC']?>" width="100" alt="<?=$arItem['NAME']?> - логотип" /></div>
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
