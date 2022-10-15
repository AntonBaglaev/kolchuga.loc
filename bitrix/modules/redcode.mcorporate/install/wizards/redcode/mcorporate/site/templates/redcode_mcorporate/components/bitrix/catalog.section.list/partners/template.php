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

<div class="partners">
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
		<div class="partnersSection"><!--
		--><div class="partnersTitle">
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
			--><div class="partnersElement" id="<?=$this->GetEditAreaId($arElement["ID"]);?>">
					<div class="text">
						<?if(!empty($arElement["PREVIEW_PICTURE"])){?>
							<div class="imgWrapp">
								<img src="<?=$arElement["PREVIEW_PICTURE"];?>" alt="<?=$arElement["NAME"];?>" title="<?=$arElement["NAME"];?>" />
							</div>
						<?}?>
						<?
						if(!empty($arElement["NAME"]))
							echo "<div class='name'>".$arElement["NAME"]."</div>";
						if(!empty($arElement["PROPERTY_PHONE_VALUE"]))
							echo "<div class='phone'>".$arElement["PROPERTY_PHONE_VALUE"]."</div>";
						if(!empty($arElement["PROPERTY_EMAIL_VALUE"]))
							echo "<div class='email'>".$arElement["PROPERTY_EMAIL_VALUE"]."</div>";
						?>
					</div>
				</div><!--
			--><?}?>
		</div>
	<?}?>
</div>