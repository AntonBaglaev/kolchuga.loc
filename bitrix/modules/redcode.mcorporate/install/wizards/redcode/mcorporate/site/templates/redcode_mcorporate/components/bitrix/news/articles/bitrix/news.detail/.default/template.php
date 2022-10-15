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

$arParams["ASSET"]->addString("<meta property='og:image' content='".$arResult["PREVIEW_PICTURE"]["SRC"]."' />", true);
$templateData = $arResult["PROPERTIES"]["SIZE_TITLE"]["VALUE"];
?> 

<div class="newsDetailTitle">
	<div>
		<i class="materialIcons">&#xE916;</i>
		<?=strtolower($arResult["DISPLAY_ACTIVE_FROM"]);?>
	</div>
	<div><?=$arResult["PROPERTIES"]["TAG"]["VALUE"];?></div>
</div>

<div class="newsDetail">
	<?
	if(!empty($arResult["DETAIL_TEXT"]))
		echo $arResult["DETAIL_TEXT"];
	else
		echo "<p>".GetMessage("PAGE_PROCESS_FILLING")."</p>";
	?>
	<div class="backAndShare">
		<div class="buttonBack">
			<a href="<?=$arParams["SEF_FOLDER"];?>"><?=GetMessage("NS_BACK");?></a>
		</div>
		<?if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] === "Y")
		{
			$APPLICATION->IncludeComponent(
				"bitrix:main.include", "",
				array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => SITE_DIR."include_areas/banners/leftShare.php",
					"AREA_FILE_RECURSIVE" => "N",
				)
			);
		}
		?>
		<div class="clear"></div>
	</div>
</div>