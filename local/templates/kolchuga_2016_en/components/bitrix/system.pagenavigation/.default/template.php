<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}
?>
<nav class="paginate">
	<ul class="pagination"><?

	$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
	$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

	if($arResult["bDescPageNumbering"] === true):
		$bFirst = true;
		if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
			if($arResult["bSavePage"]):
	?>
				<li class="prev">
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
						<span><?=GetMessage("page_prev")?></span>
					</a>
				</li>
	<?
			else:
				if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):
	?>
				<li class="prev">
					<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
						<span><?=GetMessage("page_prev")?></span>
					</a>
				</li>
	<?
				else:
	?>
				<li class="prev">
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
						<span><?=GetMessage("page_prev")?></span>
					</a>
				</li>
	<?
				endif;
			endif;
			
			if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
				$bFirst = false;
				if($arResult["bSavePage"]):
	?>
				<li>
					<a class="modern-page-first" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">
						<span>1</span>
					</a>
				</li>
	<?
				else:
	?>
				<li>
					<a class="modern-page-first" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
						<span>1</span>
					</a>
				</li>
	<?
				endif;
				if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):
	?>	
				<li>
					<a class="modern-page-dots" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=intVal($arResult["nStartPage"] + ($arResult["NavPageCount"] - $arResult["nStartPage"]) / 2)?>">
						<span>...</span>
					</a>
				</li>
	<?
				endif;
			endif;
		endif;
		do
		{
			$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;
			
			if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
	?>
			<li class="active">
				<span class="<?=($bFirst ? "modern-page-first " : "")?>"><?=$NavRecordGroupPrint?></span>
			</li>
	<?
			elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
	?>
			<li>
				<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="<?=($bFirst ? "modern-page-first" : "")?>">
					<span><?=$NavRecordGroupPrint?></span>
				</a>
			</li>
	<?
			else:
	?>
			<li>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"<?
				?> class="<?=($bFirst ? "modern-page-first" : "")?>">
					<span><?=$NavRecordGroupPrint?></span>
				</a>
			</li>
	<?
			endif;
			
			$arResult["nStartPage"]--;
			$bFirst = false;
		} while($arResult["nStartPage"] >= $arResult["nEndPage"]);
		
		if ($arResult["NavPageNomer"] > 1):
			if ($arResult["nEndPage"] > 1):
				if ($arResult["nEndPage"] > 2):
	?>
			<li>
				<a class="modern-page-dots" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] / 2)?>">
					<span>...</span>
				</a>
			</li>
	<?
				endif;
	?>
			<li>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">
					<span><?=$arResult["NavPageCount"]?></span>
				</a>
			</li>
	<?
			endif;
		
	?>
			<li class="next">
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
					<span><?=GetMessage("page_next")?></span>
				</a>
			</li>
	<?
		endif; 

	else:
		$bFirst = true;

		if ($arResult["NavPageNomer"] > 1):
			if($arResult["bSavePage"]):
	?>
				<li class="prev">
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
						<span><?=GetMessage("page_prev")?></span>
					</a>
				</li>
	<?
			else:
				if ($arResult["NavPageNomer"] > 2):
	?>
				<li class="prev">
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
						<span><?=GetMessage("page_prev")?></span>
					</a>
				</li>
	<?
				else:
	?>
				<li class="prev">
					<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
						<span><?=GetMessage("page_prev")?></span>
					</a>
				</li>
	<?
				endif;
			
			endif;
			
			if ($arResult["nStartPage"] > 1):
				$bFirst = false;
				if($arResult["bSavePage"]):
	?>
				<li>
					<a class="modern-page-first" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">
						<span>1</span>
					</a>
				</li>
	<?
				else:
	?>
				<li>
					<a class="modern-page-first" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
						<span>1</span>
					</a>
				</li>
	<?
				endif;
				if ($arResult["nStartPage"] > 2):
	?>
				<li>
					<a class="modern-page-dots" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nStartPage"] / 2)?>">
						<span>...</span>
					</a>
				</li>
	<?
				endif;
			endif;
		endif;

		do
		{
			if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
	?>
			<li class="active">
				<span class="<?=($bFirst ? "modern-page-first " : "")?>">
					<?=$arResult["nStartPage"]?>
				</span>
			</li>
	<?
			elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
	?>
			<li>
				<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="<?=($bFirst ? "modern-page-first" : "")?>">
					<span><?=$arResult["nStartPage"]?></span>
				</a>
			</li>
	<?
			else:
	?>
			<li>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"<?
				?> class="<?=($bFirst ? "modern-page-first" : "")?>">
					<span><?=$arResult["nStartPage"]?></span>
				</a>
			</li>
	<?
			endif;
			$arResult["nStartPage"]++;
			$bFirst = false;
		} while($arResult["nStartPage"] <= $arResult["nEndPage"]);
		
		if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
			if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
				if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):

	?>
			<li>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)?>">
					<span>...</span>
				</a>
			</li>
	<?
				endif;
	?>
			<li>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">
					<span><?=$arResult["NavPageCount"]?></span>
				</a>
			</li>
	<?
			endif;
	?>
			<li class="next">
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
					<span><?=GetMessage("page_next")?></span>
				</a>
			</li>
	<?
		endif;
	endif;
	?>
	</ul>
</div>