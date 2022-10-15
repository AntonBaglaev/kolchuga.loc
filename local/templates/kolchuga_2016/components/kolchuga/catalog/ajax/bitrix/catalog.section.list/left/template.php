<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(empty($arResult['SECTIONS'])) return false?>
<div class="sidebar__menu accordion-menu">
	<div class="sidebar__menu--title accordion-header accordion-open">
		<span><?=GetMessage('SIDEBAR_TITLE')?></span>
		<i></i>
	</div>
	<ul>
	<?foreach($arResult["SECTIONS"] as $arSection):
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));?>

		<li <?=$arSection['CURRENT'] ? 'class="active" ' : ''?>id="<?=$this->GetEditAreaId($arSection['ID'])?>">
			<a href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a>
		</li>

	<?endforeach;?>
	</ul>
</div>