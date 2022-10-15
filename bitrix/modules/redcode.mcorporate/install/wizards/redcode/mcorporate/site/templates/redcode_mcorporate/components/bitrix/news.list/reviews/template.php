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

<div class="reviews">
	<?if(!empty($arResult["DESCRIPTION"]) && $arParams["SHOW_DESCRIPTION_TEXT"] == "Y"){?>
		<p><i class="materialIcons">&#xE88E;</i><?=$arResult["DESCRIPTION"];?></p>
	<?}?>
	<div class="reviewsElements">
		<?foreach($arResult["ITEMS"] as $arElement){
			$this->AddEditAction($arElement["ID"], $arElement["EDIT_LINK"], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arElement["ID"], $arElement["DELETE_LINK"], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("IL_REVIEWS_DELETE_CONFIRM")));
		?>
			<div class="reviewsElement" id="<?=$this->GetEditAreaId($arElement["ID"]);?>">
				<div class="reviewsImg">
					<?if(!empty($arElement["PREVIEW_PICTURE"]["SRC"])){?>
						<div style="background:url('<?=$arElement["PREVIEW_PICTURE"]["SRC"];?>') no-repeat center; background-size: cover;"></div>
					<?}?>
				</div><!--
			 --><div class="reviewsText">
					<div class="title">
						<div><?=$arElement["NAME"];?></div><!--
					 --><?if(!empty($arElement["DISPLAY_PROPERTIES"]["SERVICE"]["DISPLAY_VALUE"])){?><!--
						 --><p><?=strip_tags($arElement["DISPLAY_PROPERTIES"]["SERVICE"]["DISPLAY_VALUE"]);?></p><!--
					 --><?}?><!--
					 --><?if(!empty($arElement["DISPLAY_ACTIVE_FROM"])){?><!--
						 --><div class="reviewsDate">
								<i class="materialIcons">&#xE916;</i>
								<?=strtolower($arElement["DISPLAY_ACTIVE_FROM"]);?>
							</div>
						<?}?>
					</div>
					<q></q>
					<p><?=$arElement["PREVIEW_TEXT"];?></p>
				</div>
			</div>
		<?}?>
	</div>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]){?>
		<?=$arResult["NAV_STRING"];?>
	<?}?>
</div>