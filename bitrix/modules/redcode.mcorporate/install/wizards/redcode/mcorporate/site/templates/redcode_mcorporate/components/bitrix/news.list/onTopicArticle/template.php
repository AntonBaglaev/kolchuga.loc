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

<?foreach($arResult["ITEMS"] as $arItem){
	$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
?>
	<div class="onTopicArticle" id="<?=$this->GetEditAreaId($arItem["ID"]);?>">
		<a href="<?=$arItem["DETAIL_PAGE_URL"];?>" class="img" style="background: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"];?>') no-repeat center; background-size: cover;" title="<?=$arItem["NAME"];?>">
			<span><?=$arResult["NAME"];?></span>
		</a>
		<?if(!empty($arItem["ACTIVE_FROM"])){?>
			<p><?=$arItem["ACTIVE_FROM"];?></p>
		<?}?>
		<div class="name">
			<a title="<?=$arItem["NAME"];?>" href="<?=$arItem["DETAIL_PAGE_URL"];?>"><?=$arItem["NAME"];?></a>
		</div>
	</div>
<?}?>