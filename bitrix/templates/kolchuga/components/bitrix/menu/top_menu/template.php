<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?if (!empty($arResult)):?>

<div class="top_menu_wrapper">
<ul class="top_menu ">
	<?
	$previousLevel = 0;
	$len = count($arResult);
	foreach($arResult as $index =>$arItem):
	?>
			<?if ($arItem['DEPTH_LEVEL'] == 1):?>
				<?if ($arItem["PERMISSION"] > "D"):?>
						<li class="<?if ($index == 0):?>first_li<?endif?> <?if ($index == $len - 1):?>last_li<?endif?>">
							<div class="item-text adventure">
								<a href="<?=$arItem["LINK"]?>" <?if($arItem["SELECTED"]):?>class="activ"<?endif?>>
									<?=$arItem["TEXT"]?>
								</a>
							</div>
							<?if ($arItem["IS_PARENT"]):?>
								<?if($arItem["SELECTED"]):?>
									<?if (!empty($arResult)):?>
									<?else:?>
										<i></i>
									<?endif?>
								<?endif?>
							<?endif?>
						</li>
				<?endif?>
			<?endif?>
		
	<?endforeach?>
</ul>
</div>
<?endif?>