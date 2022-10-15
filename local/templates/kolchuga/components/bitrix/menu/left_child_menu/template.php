<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<style type="text/css">
	.center .content{
		padding-left:275px;
	}
</style>
<div class="fl_left block_left_menu">
<ul>
	<?
	$previousLevel = 0;
	$len = count($arResult);
	foreach($arResult as $index =>$arItem):
	?>		
		<?if ($arItem["PERMISSION"] > "D"):?>
				<li class="<?if ($index == 0):?>first_li<?endif?> <?if ($index == $len - 1):?>last_li<?endif?>">
					<div class="item-text">
						<a href="<?=$arItem["LINK"]?>" <?if($arItem["SELECTED"]):?>class="activ"<?endif?>>
							<?=$arItem["TEXT"]?>
						</a>
					</div>
				</li>
		<?endif?>		
	<?endforeach?>
</ul>
</div>
<?endif?>
