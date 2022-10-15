<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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
//s($arResult);
?>

<div class="projects">
	<?foreach($arResult["ITEMS"] as $arItem){
		$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
	?><!--
	 --><div class="projectsItem" id="<?=$this->GetEditAreaId($arItem["ID"]);?>">
			<div class="projectsItemWrap">
				<div class="projectsItem_img">
					<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"];?>" alt="<?=$arItem["NAME"];?>" title="<?=$arItem["NAME"];?>" />
					<p><?=$arItem["SECTION_NAME"];?></p>
				</div>
				<div class="projectsItemInfo">
					<a href="<?=$arItem["DETAIL_PAGE_URL"];?>"><?=$arItem["NAME"];?></a>
				</div>
			</div>
		</div><!--
	--><?}?>
	<?if ($arParams["DISPLAY_BOTTOM_PAGER"]){?>
		<?=$arResult["NAV_STRING"];?>
	<?}?>
</div>