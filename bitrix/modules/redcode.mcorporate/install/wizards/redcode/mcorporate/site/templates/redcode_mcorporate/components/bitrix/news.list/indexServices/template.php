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

<div class="indexServices">
	<?if(!empty($arParams["INFO_LIST_TITLE"])){?>
		<h2><?=$arParams["INFO_LIST_TITLE"];?></h2>
	<?}?>
	<div class="indexServicesBlock">
		<?foreach($arResult["ITEMS"] as $arItem){
			$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
		?><!--
			--><div class="indexServicesItem" id="<?=$this->GetEditAreaId($arItem["ID"]);?>">
				<div class="indexServicesWrap">
					<div class="indexServices_img" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"];?>');"></div>
					<div class="indexServicesInfo">
						<div class="indexServices_name"><?=$arItem["NAME"];?></div>
						<div class="indexServices_text"><?=$arItem["PREVIEW_TEXT"];?></div>
						<a href="<?=$arItem["DETAIL_PAGE_URL"];?>" class="indexServices_button"><?=GetMessage("INDEX_SERVICES_MORE");?></a>
					</div>
				</div>
			</div><!--
		--><?}?>
	</div>
</div>