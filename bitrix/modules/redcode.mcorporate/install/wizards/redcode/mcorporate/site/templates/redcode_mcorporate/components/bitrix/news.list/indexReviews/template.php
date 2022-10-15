<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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
?>

<div class="indexReviews">
	<?if(!empty($arParams["INFO_LIST_TITLE"])){?>
		<h2><?=$arParams["INFO_LIST_TITLE"];?></h2>
	<?}?>
	<div id="carouselReviews" class="owl-carousel">
		<?foreach($arResult["ITEMS"] as $arItem){?>
			<div class="item_reviews">
				<?if(!empty($arItem["PREVIEW_PICTURE"]["SRC"])){?>
					<div class="IR_img" style="background:url('<?=$arItem["PREVIEW_PICTURE"]["SRC"];?>') no-repeat center; background-size: cover;"></div>
				<?}?>
				<div class="IR_name"><?=$arItem["NAME"];?></div>
				<?if(!empty($arItem["DISPLAY_PROPERTIES"]["SERVICE"]["DISPLAY_VALUE"])){?>
					<div class="IR_position"><?=strip_tags($arItem["DISPLAY_PROPERTIES"]["SERVICE"]["DISPLAY_VALUE"]);?></div>
				<?}?>
				<div class="IR_text">
					<q class="open"></q><!--
				 --><div class="center"><?=$arItem["PREVIEW_TEXT"];?></div><!--
				 --><q class="close"></q>
				</div>
			</div>
		<?}?>
	</div>
	
	<div class="reviewsControls">
		<div class="reviewsDots"></div>
	</div>	
</div>