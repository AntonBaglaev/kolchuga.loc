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

<div class="blockPrice">
	<?foreach($arResult["SECTIONS"] as $key => $arSection){
		if(!isset($arSection["ELEMENTS"]))
			continue;
	?>
		<div class="priceSection" data-number="#<?=$key;?>#">
			<?if(!empty($arSection["NAME"])){?>
				<h2>
					<?=$arSection["NAME"];?>
					<i class="materialIcons">&#xE5CE;</i>
				</h2>
			<?}?>
			<div class="priceElements">
				<div class="priceHeader">
					<div class="td_1"><?=GetMessage("NUMBER");?></div><!--
				 --><div class="td_2"><?=GetMessage("NAME");?></div><!--
				 --><div class="td_3"><?=GetMessage("UNITS");?></div><!--
				 --><div class="td_4"><?=GetMessage("PRICE");?></div>
				</div>
				<?
				$serialNumber = 1;
				foreach($arSection["ELEMENTS"] as $arElement){
					$this->AddEditAction($arElement["ID"], $arElement["EDIT_LINK"], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arElement["ID"], $arElement["DELETE_LINK"], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CSL_DELETE_CONFIRM")));
				?>
					<div class="priceElement" id="<?=$this->GetEditAreaId($arElement["ID"]);?>">
						<div class="td_1"><?=$serialNumber;?></div><!--
					 --><div class="td_2"><?=$arElement["NAME"];?></div><!--
					 --><div class="td_3"><?=$arElement["PROPERTY_UNITS_VALUE"];?></div><!--
					 --><div class="td_4"><?=$arElement["PROPERTY_PRICE_VALUE"];?></div>
					</div>
				<?
					$serialNumber++;
				}
				?>
			</div>
		</div>
	<?}?>
</div>