<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?if(empty($arResult["ITEMS"])):?>
	<?echo GetMessage("CT_BCSE_NOT_FOUND");?>
<?endif;?>

<?//echo "<pre style='text-align:left;'>";print_r($arResult["ITEMS"][0]['DISPLAY_PROPERTIES']['TOVAR']);echo "</pre>"; ?>

<?
$arItem = $arResult["ITEMS"][0];
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
?>

<section class="block_bereta_baner container-fluid mb-5 " id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
	<div class="row">
		<div class="col-12 pr-0 pl-0">					
				<img src="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>"  >
				<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" class="homelogo"  >
				<h3 class="serif-header pt-3 pb-3  d-none d-sm-block"><?=$arItem['PREVIEW_TEXT']?></h3> 
		</div>			
	</div>
</section>
