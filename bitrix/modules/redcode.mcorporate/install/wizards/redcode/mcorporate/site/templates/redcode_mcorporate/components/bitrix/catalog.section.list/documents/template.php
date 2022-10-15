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

$this->addExternalJS(SITE_TEMPLATE_PATH."/js/jquery.fancybox.pack.js");
$this->addExternalCss(SITE_TEMPLATE_PATH."/css/jquery.fancybox.css");
?>

<div class="documents">
	<?foreach($arResult["SECTIONS"] as $arSection){
		if(!isset($arSection["ELEMENTS"]))
			continue;
		
		if(!empty($arSection["~DESCRIPTION"]))
		{
			$descriptionLen = strlen($arSection["~DESCRIPTION"]);
			if($descriptionLen > 150)
				$arSection["~DESCRIPTION"] = rtrim(substr($arSection["~DESCRIPTION"], 0, 150), "!,.-")."...";
		}
	?>
		<div class="documentsSection"><!--
		--><div class="documentsTitle">
				<?if(!empty($arSection["NAME"])){?>
					<h2><?=$arSection["NAME"];?></h2>
				<?}?>
				<?if(!empty($arSection["~DESCRIPTION"])){?>
					<p><?=$arSection["~DESCRIPTION"];?></p>
				<?}?>
			</div><!--
		--><?foreach($arSection["ELEMENTS"] as $arElement){
				$this->AddEditAction($arElement["ID"], $arElement["EDIT_LINK"], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arElement["ID"], $arElement["DELETE_LINK"], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CSL_DELETE_CONFIRM")));
			?><!--
		--><div class="documentsElement" id="<?=$this->GetEditAreaId($arElement["ID"]);?>">
				<div class="text">
					<a href="<?=$arElement["PREVIEW_PICTURE"];?>" class="fancybox" title="<?=$arElement["PREVIEW_TEXT"];?>" rel="document">
						<i class="materialIcons">&#xE56B;</i>
						<img src="<?=$arElement["PREVIEW_PICTURE"];?>" title="<?=$arElement["NAME"];?>" alt="<?=$arElement["NAME"];?>" />
					</a>
					<div class="name"><?=$arElement["NAME"];?></div>
				</div>
			</div><!--
		--><?}?>
		</div>
	<?}?>
</div>