<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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
?>
<div class="searchPage">
	<div class="boxShadow">
		<form action="" method="get">
			<input type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />
			<input type="submit" value="<?=GetMessage("SEARCH_GO")?>" />
			<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
		</form>
	
		<div class="sortedSearch">
			<?if($arResult["REQUEST"]["HOW"] == "d"){?>
				<a href="<?=$arResult["URL"]?>&amp;how=r<?echo $arResult["REQUEST"]["FROM"]? '&amp;from='.$arResult["REQUEST"]["FROM"]: ''?><?echo $arResult["REQUEST"]["TO"]? '&amp;to='.$arResult["REQUEST"]["TO"]: ''?>">
				<?=GetMessage("SEARCH_SORT_BY_RANK")?></a>&nbsp;|&nbsp;<b><?=GetMessage("SEARCH_SORTED_BY_DATE")?></b>
			<?}else{?>
				<b><?=GetMessage("SEARCH_SORTED_BY_RANK")?></b>&nbsp;|&nbsp;<a href="<?=$arResult["URL"]?>&amp;how=d<?echo $arResult["REQUEST"]["FROM"]? '&amp;from='.$arResult["REQUEST"]["FROM"]: ''?><?echo $arResult["REQUEST"]["TO"]? '&amp;to='.$arResult["REQUEST"]["TO"]: ''?>">
				<?=GetMessage("SEARCH_SORT_BY_DATE")?></a>
			<?}?>
		</div>
	
		<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])){?>
			<div class="searchLanguage">
				<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
			</div>
		<?}?>

		<?if($arResult["ERROR_CODE"] != 0){?>
			<p><?=GetMessage("SEARCH_ERROR")?></p>
			<?ShowError($arResult["ERROR_TEXT"]);?>
			<p><?=GetMessage("SEARCH_CORRECT_AND_CONTINUE")?></p>
			<br /><br />
			<p><?=GetMessage("SEARCH_SINTAX")?><br /><b><?=GetMessage("SEARCH_LOGIC")?></b></p>
			<table border="0" cellpadding="5">
				<tr>
					<td align="center" valign="top"><?=GetMessage("SEARCH_OPERATOR")?></td><td valign="top"><?=GetMessage("SEARCH_SYNONIM")?></td>
					<td><?=GetMessage("SEARCH_DESCRIPTION")?></td>
				</tr>
				<tr>
					<td align="center" valign="top"><?=GetMessage("SEARCH_AND")?></td><td valign="top">and, &amp;, +</td>
					<td><?=GetMessage("SEARCH_AND_ALT")?></td>
				</tr>
				<tr>
					<td align="center" valign="top"><?=GetMessage("SEARCH_OR")?></td><td valign="top">or, |</td>
					<td><?=GetMessage("SEARCH_OR_ALT")?></td>
				</tr>
				<tr>
					<td align="center" valign="top"><?=GetMessage("SEARCH_NOT")?></td><td valign="top">not, ~</td>
					<td><?=GetMessage("SEARCH_NOT_ALT")?></td>
				</tr>
				<tr>
					<td align="center" valign="top">( )</td>
					<td valign="top">&nbsp;</td>
					<td><?=GetMessage("SEARCH_BRACKETS_ALT")?></td>
				</tr>
			</table>
		<?}?>
	</div>
		
	<?if(count($arResult["SEARCH"]) > 0){?>
		<?foreach($arResult["SEARCH"] as $arItem){?>
			<div class="searchItem boxShadow">
				<a class="searchLink" href="<?=$arItem["URL"];?>"><?=$arItem["TITLE_FORMATED"];?></a>
				<p><?=$arItem["BODY_FORMATED"];?></p>
				<!--<small><?=GetMessage("SEARCH_MODIFIED");?> <?=$arItem["DATE_CHANGE"];?></small>-->
				<?if($arItem["CHAIN_PATH"]){?>
					<small><?=GetMessage("SEARCH_PATH");?>&nbsp;<?=$arItem["CHAIN_PATH"];?></small>
				<?}?>
			</div>
		<?}
	}?>

	
	<?
	if(strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"]))
	{
		$arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
		$obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
		$obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
	}

	if($arParams["DISPLAY_BOTTOM_PAGER"] != "N" && count($arResult["SEARCH"]) > 0)
		echo $arResult["NAV_STRING"];
	
	if(count($arResult["SEARCH"]) <= 0 && $arResult["ERROR_CODE"] == 0)
		ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));
	?>

</div>