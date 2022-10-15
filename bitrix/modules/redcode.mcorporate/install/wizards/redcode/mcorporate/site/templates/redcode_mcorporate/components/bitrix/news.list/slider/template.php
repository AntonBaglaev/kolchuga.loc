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

<script type="text/javascript">
jQuery(function($) {

	"use strict";
	
	var $bxpanel = $("#bx-panel"),
		$windowHeight = $(window).height(),
		$owl = $("#carouselSlider"),
		$videoButton = $(".videoButton"),
		minusHeight = 0,
		height;

	if($bxpanel.length)
		minusHeight = $bxpanel.height();

	if($windowHeight < 600)
		height = 600;
	else
		height = $windowHeight;
		
	$(".slide, .item-video, .videoBlock", $owl).height(height - minusHeight);
	
	$(".slideTextDetail", $owl).each(function(){
		var $this = $(this);
		
		if(!$this.has("a").length)
			$("p", $this).css({"margin-bottom": "+=" + 41});
	});

	$owl.owlCarousel({
		items: 1,
		dots: <?echo (isset($arParams["SHOW_DOTS"]) && $arParams["SHOW_DOTS"] === "Y" ? "true" : "false");?>,
		mouseDrag: <?echo (isset($arParams["MOUSE_DRAG"]) && $arParams["MOUSE_DRAG"] === "Y" ? "true" : "false");?>,
		touchDrag: false,
		nav: <?echo (isset($arParams["SHOW_NAV"]) && $arParams["SHOW_NAV"] === "Y" ? "true" : "false");?>,
		navText: ["&#xE5CB;", "&#xE5CC;"],
		smartSpeed: <?echo (isset($arParams["SLIDER_SPEED"]) && !empty($arParams["SLIDER_SPEED"]) ? $arParams["SLIDER_SPEED"] : "200");?>,
		autoplay: <?echo (isset($arParams["AUTOPLAY"]) && $arParams["AUTOPLAY"] === "Y" ? "true" : "false");?>,
		autoplaySpeed: <?echo (isset($arParams["AUTOPLAY_SPEED"]) && !empty($arParams["AUTOPLAY_SPEED"]) ? $arParams["AUTOPLAY_SPEED"] : "600");?>,
		loop: <?echo (isset($arParams["LOOP"]) && $arParams["LOOP"] === "Y" ? "true" : "false");?>,
		video: true,
		autoplayHoverPause: <?echo (isset($arParams["AUTOPLAY_HOVER_PAUSE"]) && $arParams["AUTOPLAY_HOVER_PAUSE"] === "Y" ? "true" : "false");?>,
		dotsContainer: ".owlDots",
		navContainer: ".owlNav",
		navClass: ["materialIcons owl-prev", "materialIcons owl-next"],
		animateOut: "<?echo (isset($arParams["ANIMATION_SLIDER"]) && !empty($arParams["ANIMATION_SLIDER"]) ? $arParams["ANIMATION_SLIDER"] : 'fadeOut');?>",
	});

	$owl.on("translate.owl.carousel", function(event){
		$(".sliderInside > div").removeClass("fadeInLeftBig").css({"opacity": "0"});
		$(".sliderInside .sliderImage").removeClass("fadeInUp").css({"opacity": "0"});
		
		$(".owl-item:eq("+ event.item.index +") .sliderInside > div").css({"opacity": "1"}).addClass("fadeInLeftBig");
		$(".owl-item:eq("+ event.item.index +") .sliderInside .sliderImage").css({"opacity": "1"}).addClass("fadeInUp");
	});

	$(".sliderInside .sliderImage").css({"marginTop": "-"+ $(".sliderInside .sliderImage").outerWidth() +"px"});
	
	$videoButton.on("click", function() {
		$(this).fadeOut(400);
        $("video", $(this).parent()).get(0).play();
    });
	
	$(".videoBlock").on("click", "video", function() {
		$videoButton.fadeIn(400);
		$(this).get(0).pause();
	});
	
	$(".videoBlock video").on("ended", function() {
		$videoButton.fadeIn(400);
		$(this).get(0).load();
	});
});
</script>

<div class="indexSlider">
	<div id="carouselSlider" class="owl-carousel">
		<?foreach($arResult["ITEMS"] as $key => $arItem){
			$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));

			$video = CFile::GetPath($arItem["PROPERTIES"]["VIDEO"]["VALUE"]);
			$imageVideo = CFile::GetPath($arItem["PROPERTIES"]["IMAGE_VIDEO"]["VALUE"]);
		?>
			<?if(!empty($arItem["PREVIEW_PICTURE"]["SRC"])){?>
				<div id="<?=$this->GetEditAreaId($arItem["ID"]);?>" class="slide" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"];?>') !important;">
					<div class="sliderInside">
						<div <?echo ($key == 0 ? "class='fadeInLeftBig'" : "");?>>
							<div class="slideText"><?=$arItem["NAME"];?></div><!--
						 --><div class="slideTextDetail">
								<div>
									<p><?=$arItem["PREVIEW_TEXT"];?></p>
									<?if(!empty($arItem["PROPERTIES"]["URL"]["VALUE"])){?>
										<a class="sliderDetail" target="_blank" href="<?=$arItem["PROPERTIES"]["URL"]["VALUE"];?>" title="<?=$arItem["NAME"];?>"><?=GetMessage("IL_SLIDER_DETAIL");?></a>
									<?}?>
								</div>
							</div>
						</div>
					</div>
					<div class="blackSlider"></div>
				</div>
			<?}elseif(!empty($arItem["PROPERTIES"]["VIDEO"]["VALUE"])){?>
				<div class="videoBlock" id="<?=$this->GetEditAreaId($arItem["ID"]);?>">
					<video poster="<?=$imageVideo;?>" src="<?=$video;?>" width="100%" preload="none"></video>
					<div class="videoButton"></div>
				</div>
			<?}else{?>
				<div id="<?=$this->GetEditAreaId($arItem["ID"]);?>" class="item-video">
					<a class="owl-video" href="<?=$arItem["PROPERTIES"]["URL_VIDEO"]["VALUE"];?>"></a>
				</div>
			<?}?>
		<?}?>
	</div>

	<div class="sliderControls">
		<div class="sliderControlsWrapper">
			<div class="owlDots"></div>
			<div class="owlNav"></div>
		</div>
	</div>

	<div class="mouseSlider"></div>
</div>