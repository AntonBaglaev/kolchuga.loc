<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(empty($arResult["ITEMS"])){return false;}
?>
<div class="next_recomend ">
					<div class="recomend_title">Рекомендуем</div>
					<div class="recomend_list">
					<ul>
<?foreach($arResult["ITEMS"] as $arItem):?><!--pre><?print_r($arItem);?></pre-->
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

	<li><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?> >></a><br><span><?=$arItem['ACTIVE_FROM']?></span>
					</li>
	
<?endforeach;?>
</ul>
					<a target="_blank" href="/news/" class='btn-blue'>Все новости</a>
					
					<?if(!empty($arParams['BANNER_IMG'])){?>
					<br>
						<?if(!empty($arParams['BANNER_LINK'])){?>
						<a target="_blank" href="<?=$arParams['BANNER_LINK']?>" >
						<?}?>
						<img src="<?=$arParams['BANNER_IMG']?>" width="100%" />
						<?if(!empty($arParams['BANNER_LINK'])){?>
							</a>
						<?}?>
					<?}?>
					</div>
				</div>





