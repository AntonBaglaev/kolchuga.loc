<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
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

$this->addExternalJS(SITE_TEMPLATE_PATH."/js/owl.carousel.min.js");
$this->addExternalCSS(SITE_TEMPLATE_PATH."/css/owl.carousel.css");
$this->addExternalJS(SITE_TEMPLATE_PATH."/js/jquery.fancybox.pack.js");
$this->addExternalCSS(SITE_TEMPLATE_PATH."/css/jquery.fancybox.css");

$arParams["ASSET"]->addString("<meta property='og:image' content='".$arResult["PREVIEW_PICTURE"]["SRC"]."' />", true);
$templateData = $arResult["PROPERTIES"]["SIZE_TITLE"]["VALUE"];

$dopinfo = (!empty($arResult["PROPERTIES"]["TASK"]["VALUE"]) || !empty($arResult["DISPLAY_PROPERTIES"]["GALLERY"]["VALUE"]));
?>

<?if(!empty($arResult["PROPERTIES"]["TASK"]["VALUE"])):?>
	<div class="projectTask generalBackground">
		<p><?=$arResult["PROPERTIES"]["TASK"]["NAME"];?></p>
		<?=$arResult["PROPERTIES"]["TASK"]["VALUE"];?>
	</div>
<?endif;?>

<?if(!empty($arResult["DISPLAY_PROPERTIES"]["GALLERY"]["VALUE"])):
	$countImg = count($arResult["DISPLAY_PROPERTIES"]["GALLERY"]["VALUE"]);
	if($countImg < 2)
	{
		$fileValue = $arResult["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"];
		unset($arResult["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"]);
		$arResult["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"][] = $fileValue;
	}
?>
	<div class="projectGallery generalBackground">
		<div id="slider" class="owl-carousel">
			<?foreach($arResult["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"] as $file):?>
				<a href="<?=$file["SRC"];?>" class="fancybox" rel="document">
					<i class="materialIcons">&#xE56B;</i>
					<img src="<?=$file["SRC"];?>" alt="<?=$arResult["NAME"];?>" />
				</a>
			<?endforeach;?>
		</div>
		<?if($countImg > 1):?>
			<div id="carousel" class="owl-carousel">
				<?foreach($arResult["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"] as $file):?>
					<img src="<?=$file["SRC"];?>" alt="<?=$arResult["NAME"];?>" />
				<?endforeach;?>
			</div>
		<?endif;?>
	</div>
<?endif;?>

<div id="tabulation" <?echo ($dopinfo ?: "class='firstBlock'");?>>
	<div class="tabulationHeader">
		<?if(!empty($arResult["DETAIL_TEXT"])):?>
			<div class="tab">
				<h2 class="active" data-tab="<?=$arResult["ID"];?>"><?=GetMessage("NS_DETAIL_TEXT");?></h2>
			</div>
		<?endif;?>
		<?if(!empty($arResult["PROPERTIES"]["CHARACTERISTICS"]["VALUE"])):?>
			<div class="tab">
				<h2 data-tab="<?=$arResult["PROPERTIES"]["CHARACTERISTICS"]["ID"];?>"><?=GetMessage("NS_CHARACTERISTICS");?></h2>
			</div>
		<?endif;?>
		<?if(!empty($arResult["PROPERTIES"]["DOCUMENTS"]["VALUE"])):?>
			<div class="tab">
				<h2 data-tab="<?=$arResult["PROPERTIES"]["DOCUMENTS"]["ID"];?>"><?=GetMessage("NS_DOCUMENTS");?></h2>
			</div>
		<?endif;?>
	</div>
	<div class="tabulationBody">
		<?if(!empty($arResult["DETAIL_TEXT"])):?>
			<div class="detailText" data-tab="<?=$arResult["ID"];?>">
				<?=$arResult["DETAIL_TEXT"];?>
			</div>
		<?endif;?>
	
		<?if(!empty($arResult["PROPERTIES"]["CHARACTERISTICS"]["VALUE"])):?>
			<div class="characterElements" data-tab="<?=$arResult["PROPERTIES"]["CHARACTERISTICS"]["ID"];?>">
				<?foreach($arResult["PROPERTIES"]["CHARACTERISTICS"]["VALUE"] as $key => $element):?>
					<div>
						<p>
							<span><?=$element;?></span>
						</p><!--
					 --><p>
							<span><?=$arResult["PROPERTIES"]["CHARACTERISTICS"]["DESCRIPTION"][$key];?></span>
						</p>
					</div>
				<?endforeach;?>
			</div>
		<?endif;?>

		<?if(!empty($arResult["PROPERTIES"]["DOCUMENTS"]["VALUE"]))
		{
			if(count($arResult["DISPLAY_PROPERTIES"]["DOCUMENTS"]["VALUE"]) < 2)
			{
				$fileValue = $arResult["DISPLAY_PROPERTIES"]["DOCUMENTS"]["FILE_VALUE"];
				unset($arResult["DISPLAY_PROPERTIES"]["DOCUMENTS"]["FILE_VALUE"]);
				$arResult["DISPLAY_PROPERTIES"]["DOCUMENTS"]["FILE_VALUE"][] = $fileValue;
			}
		?>
			<div class="documentElements" data-tab="<?=$arResult["PROPERTIES"]["DOCUMENTS"]["ID"];?>">
				<?foreach($arResult["DISPLAY_PROPERTIES"]["DOCUMENTS"]["FILE_VALUE"] as $document)
				{
					$nameFormat = explode(".", $document["ORIGINAL_NAME"]);
					if($document["FILE_SIZE"] > 1024)
					{
						$document["FILE_SIZE"] /= 1024;
						if($document["FILE_SIZE"] > 1024)
							$document["FILE_SIZE"] = number_format(($document["FILE_SIZE"] / 1024), 2)." ".GetMessage("NS_MBYTE");
						else
							$document["FILE_SIZE"] = number_format($document["FILE_SIZE"], 2)." ".GetMessage("NS_KBYTE");
					}
					else
						$document["FILE_SIZE"] = $document["FILE_SIZE"]." ".GetMessage("NS_BYTE");
					
					switch (substr($nameFormat[1], 0, 3))
					{
						case "doc":
							$background = "#3070B0";
							$angle = "#154B9F";
							break;
						case "xls":
							$background = "#3A8D3E";
							$angle = "#24702A";
							break;
						case "pdf":
							$background = "#D32F2F";
							$angle = "#B71C1C";
							break;
						case "txt":
							$background = "#4F4F4F";
							$angle = "#363636";
							break;
						default:
							$background = "#b5b5b5";
							$angle = "#717171";
					}
				?><!--
				 --><div class="documentElement">
						<div>
							<div style="background: <?=$background;?>;">
								<span class="format"><?=substr($nameFormat[1], 0, 3);?></span>
								<span style="border-bottom-color: <?=$angle;?>;" class="angle"></span>
							</div>
						</div><!--
					 --><div>
							<a title="<?=$document["ORIGINAL_NAME"];?>" href="<?=$document["SRC"];?>" target="_blank"><?=$nameFormat[0];?></a>
							<p><?=$document["FILE_SIZE"];?></p>
						</div>
					</div><!--
				--><?}?>
			</div>
		<?}?>
	</div>
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

<?if(!empty($arResult["DISPLAY_PROPERTIES"]["REVIEWS"]["VALUE"])):?>
	<div class="projectReview generalBackground">
		<div class="reviewsImg">
			<?if(!empty($arResult["REVIEWS"]["PREVIEW_PICTURE"])){?>
				<div style="background:url('<?=$arResult["REVIEWS"]["PREVIEW_PICTURE"];?>') no-repeat center; background-size: cover;"></div>
			<?}?>
		</div><!--
	 --><div class="reviewsText">
			<div class="title">
				<div><?=$arResult["REVIEWS"]["NAME"];?></div><!--
			 --><?if(!empty($arResult["REVIEWS"]["PROPERTIES_NAME"])){?><!--
				 --><p><?=$arResult["REVIEWS"]["PROPERTIES_NAME"];?></p><!--
			 --><?}?><!--
			 --><?if(!empty($arResult["REVIEWS"]["ACTIVE_FROM"])){?><!--
				 --><div class="reviewsDate">
						<i class="materialIcons">&#xE916;</i>
						<?=strtolower($arResult["REVIEWS"]["ACTIVE_FROM"]);?>
					</div>
				<?}?>
			</div>
			<q></q>
			<p><?=$arResult["REVIEWS"]["PREVIEW_TEXT"];?></p>
		</div>
	</div>
<?endif;?>

<?if(isset($arParams["BLOCK_QUESTION"]) && $arParams["BLOCK_QUESTION"] == "Y"):?>
	<div id="askQuestion" class="boxShadow">
		<div class="markQuestion">
			<p class="materialIcons">&#xE0BF;</p>
		</div><!--
	 --><div class="textBlock">
			<div>
				<p><span><?=GetMessage("NS_TEXT");?> </span> <?=GetMessage("NS_TEXT2");?></p>
			</div><!--
		 --><a data-name="<?=$arResult["NAME"];?>" data-id="serviceConsultation" class="modalButton"><?=GetMessage("NS_ASK_QUESTION");?></a><!--
		 --><a data-name="<?=$arResult["NAME"];?>" data-id="projectOrder" class="modalButton"><?=GetMessage("NS_ORDER_PROJECT");?></a>
		</div>
	</div>
<?endif;?>