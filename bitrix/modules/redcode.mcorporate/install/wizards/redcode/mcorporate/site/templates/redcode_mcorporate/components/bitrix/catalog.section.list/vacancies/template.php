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

<div class="vacancies">
	<?if(!empty($arResult["DESCRIPTION"])){?>
		<p><i class="materialIcons">&#xE88E;</i><?=$arResult["DESCRIPTION"];?></p>
	<?}?>
	<?foreach($arResult["SECTIONS"] as $arSection){
		if(!isset($arSection["ELEMENTS"]))
			continue;
	?>
		<div class="vacanciesSection">
			<?if(!empty($arSection["NAME"])){?>
				<h2><?=$arSection["NAME"];?></h2>
			<?}?>
			<?foreach($arSection["ELEMENTS"] as $arElement){
				$this->AddEditAction($arElement["ID"], $arElement["EDIT_LINK"], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arElement["ID"], $arElement["DELETE_LINK"], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CSL_DELETE_CONFIRM")));	
			?>
				<div class="vacanciesElement" id="<?=$this->GetEditAreaId($arElement["ID"]);?>">
					<div class="VE_accordion" data-toggle="<?=$arElement["ID"];?>">
						<div class="name" data-toggle="<?=$arElement["ID"];?>">
							<?=$arElement["NAME"];?>
							<i class="materialIcons">&#xE5CF;</i>
						</div>
						<?if(!empty($arElement["PROPERTIES"]["WAGE"]["VALUE"])){?>
							<div class="price"><?=$arElement["PROPERTIES"]["WAGE"]["VALUE"];?></div>
						<?}?>
					</div>
					<div class="text" data-text="<?=$arElement["ID"];?>">
						<?
						if(isset($arElement["PROPERTIES"]["DUTIE"]["VALUE"]) && !empty($arElement["PROPERTIES"]["DUTIE"]["VALUE"])){
							echo "<p>".$arElement["PROPERTIES"]["DUTIE"]["NAME"].":</p><ul>";
							foreach($arElement["PROPERTIES"]["DUTIE"]["VALUE"] as $PROPERTIES)
								echo "<li>".$PROPERTIES."</li>";
							echo "</ul>";
						}

						if(isset($arElement["PROPERTIES"]["CONDITIONS"]["VALUE"]) && !empty($arElement["PROPERTIES"]["CONDITIONS"]["VALUE"])){
							echo "<p>".$arElement["PROPERTIES"]["CONDITIONS"]["NAME"].":</p><ul>";
							foreach($arElement["PROPERTIES"]["CONDITIONS"]["VALUE"] as $PROPERTIES)
								echo "<li>".$PROPERTIES."</li>";
							echo "</ul>";
						}

						if(isset($arElement["PROPERTIES"]["REQUIREMENTS"]["VALUE"]) && !empty($arElement["PROPERTIES"]["REQUIREMENTS"]["VALUE"])){
							echo "<p>".$arElement["PROPERTIES"]["REQUIREMENTS"]["NAME"].":</p><ul>";
							foreach($arElement["PROPERTIES"]["REQUIREMENTS"]["VALUE"] as $PROPERTIES)
								echo "<li>".$PROPERTIES."</li>";
							echo "</ul>";
						}
						?>
						<button data-name="<?=$arElement["NAME"];?>" data-id="sendSummary" class="vacanciesButton modalButton"><?=GetMessage("SEND_SUMMARY");?></button>
					</div>
				</div>
			<?}?>
		</div>
	<?}?>
</div>