<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?if (!empty($arResult)):?>
<div class="block_menu_sal">
	<ul>
		<?
		$previousLevel = 0;
		$len = count($arResult);		
		foreach($arResult as $index =>$arItem):
		?>		
			<?if ($arItem["PERMISSION"] > "D"):?>
					<li class="<?if ($index == 0):?>first_li<?endif?> <?if ($index == $len - 1):?>last_li<?endif?>">
						<div class="item-text">
							<a href="<?=$arItem["LINK"]?>" <?if($arItem["SELECTED"]):?>class="activ"<?endif?> <?if ($arItem["TEXT"] == "3D-тур"):?>target="_blank"<?endif?>>
								<?=$arItem["TEXT"]?>
							</a>
						</div>
					</li>
			<?endif?>		
		<?endforeach?>
	</ul>
</div>
<?endif?>