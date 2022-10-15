<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<ul class="article_list">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<li class="article_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="ov_hidden">
			<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
				<div class="fl_left">
					<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
							<img class="preview_picture bdr" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"  alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
						</a>
					<?else:?>
						<img class="preview_picture bdr" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"  alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
					<?endif;?>
				</div>
			<?endif?>
			<div class="article-body">
				<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
					<h3>
						<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
							<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a><br />
						<?else:?>
							<?echo $arItem["NAME"]?>
						<?endif;?>
					</h3>
				<?endif;?>
				<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
					<h4>
						<span class="article_date-time">
							<?echo $arItem["DISPLAY_ACTIVE_FROM"]?><?/*echo date("d/m/Y", strtotime($arItem[DATE_CREATE])) . "\n"; */?>
						</span>
					</h4>
				<?endif?>
				<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
					<?
					/*
						$no_tags = strip_tags($arItem["PREVIEW_TEXT"]);
						echo $no_tags.'<br>';
						$begin_pos = strpos(strip_tags($arItem["PREVIEW_TEXT"]), ' ', 260);
						echo $begin_pos.'<br>';
						$result_announce = substr($no_tags, 0, $begin_pos);
						if(strlen($result_announce) < strlen($no_tags))
							$descr_text = ' ';
						else
							$descr_text = '';
						echo $result_announce.$descr_text;
					*/
					?>
					<?=$arItem["PREVIEW_TEXT"]?>
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="article-more"><?=GetMessage('ARTICLE_MORE')?></a>
				<?endif;?>
			</div>
		</div>
	</li>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</ul>
