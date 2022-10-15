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

<div class="history">
	<?if(!empty($arResult["DESCRIPTION"]) && $arParams["SHOW_DESCRIPTION_TEXT"] == "Y"){?>
		<p><i class="materialIcons">&#xE88E;</i><?=$arResult["DESCRIPTION"];?></p>
	<?}?>
	<div class="historyElements">
		<?foreach($arResult["ITEMS"] as $arElement){
			$this->AddEditAction($arElement["ID"], $arElement["EDIT_LINK"], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arElement["ID"], $arElement["DELETE_LINK"], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("IL_HISTORY_DELETE_CONFIRM")));
		?>
			<div class="historyElement" id="<?=$this->GetEditAreaId($arElement["ID"]);?>">
				<div class="historyDate"><?=$arElement["DISPLAY_ACTIVE_FROM"];?></div><!--
			 --><div class="historyText"><?=$arElement["PREVIEW_TEXT"];?></div>
			</div>
		<?}?>
	</div>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]){?>
		<?=$arResult["NAV_STRING"];?>
	<?}?>	
</div>