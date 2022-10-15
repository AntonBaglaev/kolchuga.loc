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

$dopinfo = (!empty($arResult["PROPERTIES"]["PRICE"]["VALUE"]) || !empty($arResult["PROPERTIES"]["DOCUMENTS"]["VALUE"]));
?>

<div class="newsDetail" <?if(!$dopinfo) echo "style='margin: 0 0 75px 0'";?>>
	<?
	if(!empty($arResult["DETAIL_TEXT"]))
		echo $arResult["DETAIL_TEXT"];
	else
		echo "<p>".GetMessage("NS_EMPTY_PAGE")."</p>";
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

<?if($dopinfo){?>
	<div id="tabulation" <?if($arParams["BLOCK_QUESTION"] != "Y") echo "style='margin: 0 0 75px 0;'";?>>
		<div class="tabulationHeader">
			<?if(!empty($arResult["PROPERTIES"]["PRICE"]["VALUE"])){?>
				<div class="tab">
					<h2 class="active" data-tab="<?=$arResult["PROPERTIES"]["PRICE"]["ID"];?>"><?=GetMessage("NS_PRICE_SERVICES");?></h2>
				</div>
			<?}?>
			<?if(!empty($arResult["PROPERTIES"]["DOCUMENTS"]["VALUE"])){?>
				<div class="tab">
					<h2 data-tab="<?=$arResult["PROPERTIES"]["DOCUMENTS"]["ID"];?>"><?=GetMessage("NS_DOCUMENTS");?></h2>
				</div>
			<?}?>
		</div>
		<div class="tabulationBody">
			<?if(!empty($arResult["PROPERTIES"]["PRICE"]["VALUE"])){
				$serialNumber = 1;
			?>
				<div class="priceElements" data-tab="<?=$arResult["PROPERTIES"]["PRICE"]["ID"];?>">
					<div class="priceHeader">
						<div class="td_1"><?=GetMessage("NS_NUMBER");?></div><!--
					 --><div class="td_2"><?=GetMessage("NS_NAME");?></div><!--
					 --><div class="td_3"><?=GetMessage("NS_UNITS");?></div><!--
					 --><div class="td_4"><?=GetMessage("NS_PRICE");?></div>
					</div>
					<?foreach($arResult["PRICE"] as $price)
					{
					?>
						<div class="priceElement">
							<div class="td_1"><?=$serialNumber;?></div><!--
						 --><div class="td_2"><?=$price["NAME"];?></div><!--
						 --><div class="td_3"><?=$price["PROPERTIES"]["UNITS"]["VALUE"];?></div><!--
						 --><div class="td_4"><?=$price["PROPERTIES"]["PRICE"]["VALUE"];?></div>
						</div>
					<?
						$serialNumber++;
					}
					?>
				</div>
			<?}?>

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
	</div>
<?}?>

<?if(isset($arParams["BLOCK_QUESTION"]) && $arParams["BLOCK_QUESTION"] == "Y"){?>
	<div id="askQuestion" class="boxShadow">
		<div class="markQuestion">
			<p class="materialIcons">&#xE0BF;</p>
		</div><!--
	 --><div class="textBlock">
			<div>
				<p><span><?=GetMessage("NS_TEXT");?> </span> <?=GetMessage("NS_TEXT2");?></p>
			</div><!--
		 --><a data-name="<?=$arResult["NAME"];?>" data-id="serviceConsultation" class="modalButton"><?=GetMessage("NS_ASK_QUESTION");?></a>
		</div>
	</div>
<?}?>