<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

<div class="allNews">
	<?foreach($arResult["ITEMS"] as $arItem)
	{
		$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
		
		if(!empty($arItem["PREVIEW_PICTURE"]["SRC"]) && $arItem["PROPERTIES"]["SHOW_IMAGE"]["VALUE"] != "no")
			$background = $arItem["PREVIEW_PICTURE"]["SRC"];
		else
			$background = "";
	?><!--
	 --><div class="elementNews" id="<?=$this->GetEditAreaId($arItem["ID"]);?>">
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])){?>
				<a class="img" style="background: #efefef url('<?=$background;?>') no-repeat center; background-size: cover;" href="<?=$arItem["DETAIL_PAGE_URL"];?>" title="<?=GetMessage("LEARN_MORE");?>"></a>
			<?}else{?>
				<span class="img" style="background: #efefef url('<?=$background;?>') no-repeat center; background-size: cover;"></span>
			<?}?>
			
			<div class="allText">
				<?if(!empty($arItem["PROPERTIES"]["TAG"]["VALUE"]) || !empty($arItem["DISPLAY_ACTIVE_FROM"])){?>
					<div class="title">
						<?if(!empty($arItem["PROPERTIES"]["TAG"]["VALUE"])){?>
							<div class="tag"><?=$arItem["PROPERTIES"]["TAG"]["VALUE"];?></div>
						<?}?>
						<?if(!empty($arItem["DISPLAY_ACTIVE_FROM"])){?>
							<div class="date"><?=$arItem["DISPLAY_ACTIVE_FROM"];?></div>
						<?}?>
					</div>
				<?}?>
				
				<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])){?>
					<a class="newsName" href="<?=$arItem["DETAIL_PAGE_URL"];?>" title="<?=GetMessage("LEARN_MORE");?>"><?=$arItem["NAME"];?></a>
				<?}else{?>
					<span class="newsName"><?=$arItem["NAME"];?></span>
				<?}?>
			</div>
		</div><!--
--><?}?>
</div>

<?if($arParams["DISPLAY_BOTTOM_PAGER"] && !empty($arResult["ITEMS"]) && ($arResult["NAV_RESULT"]->nStartPage != $arResult["NAV_RESULT"]->NavPageCount)){?>
	<div class="showMore">
		<a href="#" class="showMoreButton"><?=GetMessage("SHOW_MORE");?></a>
		<div class="moreAnimation">
			<div class="moreAnimationBlock"></div>
		</div>
	</div>
<?}?>

<div class="pageNews hidden"
data-sortOrder="<?=$arParams["SORT_ORDER1"];?>"
data-sortBy="<?=$arParams["SORT_BY1"];?>"
data-sortOrder2="<?=$arParams["SORT_ORDER2"];?>"
data-sortBy2="<?=$arParams["SORT_BY2"];?>"
data-pageEnd="<?=$arResult["NAV_RESULT"]->NavPageCount;?>"
data-iblockID="<?=$arParams["IBLOCK_ID"];?>"
data-pageSize="<?=$arParams["NEWS_COUNT"];?>"
data-page="<?=$arResult["NAV_RESULT"]->nStartPage;?>"></div>