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
?>

<div class="services">
	<?foreach($arResult["ITEMS"] as $arItem){
		$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
	?><!--
	 --><div class="servicesItem" id="<?=$this->GetEditAreaId($arItem["ID"]);?>">
			<div class="servicesItemWrap">
				<div class="servicesItem_img" style="background-image:url('<?=$arItem["PREVIEW_PICTURE"]["SRC"];?>');"></div>
				<div class="servicesItemInfo">
					<div class="servicesItem_name"><?=$arItem["NAME"];?></div>
					<?if(!empty($arItem["PREVIEW_TEXT"])){?>
						<div class="servicesItem_text"><?=$arItem["PREVIEW_TEXT"];?></div>
					<?}?>
					
					<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])){?>
						<a href="<?=$arItem["DETAIL_PAGE_URL"];?>" class="servicesItem_button"><?=GetMessage("LEARN_MORE");?></a>
					<?}?>
				</div>
			</div>
		</div><!--
	--><?}?>
	<?if ($arParams["DISPLAY_BOTTOM_PAGER"]){?>
		<?=$arResult["NAV_STRING"];?>
	<?}?>
</div>