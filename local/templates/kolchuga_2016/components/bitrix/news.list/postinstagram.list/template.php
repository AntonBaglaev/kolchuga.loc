<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="about__img" style="display: inline-block;float:none;" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	<?=$arItem["PREVIEW_TEXT"]?>
	
	</div>
	
<?endforeach;?>
<?$APPLICATION->AddHeadString('<script async src="//www.instagram.com/embed.js"></script>');?>
