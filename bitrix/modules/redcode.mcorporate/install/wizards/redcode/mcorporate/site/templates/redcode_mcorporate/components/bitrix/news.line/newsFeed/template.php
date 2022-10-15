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

$x = 0;
$i = 0;
?>

<div class="indexNews">
	<?if(!empty($arParams["INFO_LIST_TITLE"])){?>
		<h2><?=$arParams["INFO_LIST_TITLE"];?></h2>
	<?}?>
	<div class="mixNews">
		<?foreach($arResult["ITEMS"] as $arItem)
		{
			$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));

			if($i % 3 == 0 && $i != 0)
			{
				$x++;
				$i = 0;
			}
			
			if($x == $i)
				$big = true;
			else
				$big = false;
			
			if(
				(
					!empty($arItem["PREVIEW_PICTURE"]["SRC"]) || 
					!empty($arItem["PROPERTIES"]["PHOTO_VERTICAL"]["VALUE"]) || 
					!empty($arItem["PROPERTIES"]["PHOTO_HORIZONTAL"]["VALUE"])
				) && 
				$arItem["PROPERTIES"]["SHOW_IMAGE"]["VALUE_ENUM"] !== "Нет"
			)
			{
				$color = "#fff";
				$gradient = "gradient";
				$border = "1px solid rgba(255,255,255, .3)";
				$photoVertical = CFile::GetPath($arItem["PROPERTIES"]["PHOTO_VERTICAL"]["VALUE"]);
				$photoHorizontal = CFile::GetPath($arItem["PROPERTIES"]["PHOTO_HORIZONTAL"]["VALUE"]);
				
				if($big && !empty($photoHorizontal))
					$background = "url('".$photoHorizontal."') no-repeat center; background-size: cover";
				elseif(!$big && !empty($photoVertical))
					$background = "url('".$photoVertical."') no-repeat center; background-size: cover";
				else
					$background = "url('".$arItem["PREVIEW_PICTURE"]["SRC"]."') no-repeat center; background-size: cover";
			}
			else
			{
				$background = "";
				$color = "#131720";
				$gradient = "";
				$border = "";
			}
			
		?><!--
		 --><a id="<?=$this->GetEditAreaId($arItem["ID"]);?>" href="<?=$arItem["DETAIL_PAGE_URL"];?>" class="indexBlockNews indexNews_<?=($big) ? "big" : "small";?>" style="background:<?=$background;?>;">
				<span class="blockGradient <?=$gradient;?>"></span>
				<?if(!empty($arItem["DISPLAY_ACTIVE_FROM"])){?>
					<span class="date" style="color:<?=$color;?>;"><?=$arItem["DISPLAY_ACTIVE_FROM"];?></span>
				<?}?>
				<span class="text">
					<?if(!empty($arItem["IBLOCK_NAME"])){?>
						<span class="iblockName"><?=$arItem["IBLOCK_NAME"];?></span>
					<?}?>
					<span class="newsName" style="color:<?=$color;?>;">
						<span style="border-bottom:<?=$border;?>"><?=$arItem["NAME"];?></span>
					</span>
				</span>
			</a><!--
		--><?
			if($x == 2 && $i == 2)
			{
				$x = 0;
				$i = -1;
			}
			$i++;
		}
		?>
	</div>
	<div class="indexNewsButton">
		<a href="<?=SITE_DIR."news/";?>"><?=GetMessage("ALL_NEWS");?></a>
	</div>
</div>