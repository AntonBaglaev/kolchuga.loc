<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?if (!empty($arResult)):?>


<ul class="menu_img">
	<?
	$previousLevel = 0;
	$len = count($arResult);
	foreach($arResult as $index =>$arItem):
	?>
			<?if ($arItem['DEPTH_LEVEL'] == 1):?>
				<?if ($arItem["PERMISSION"] > "D"):?>
						<li class="<?if ($index == 0):?>first_li<?endif?> <?if ($index == $len - 1):?>last_li<?endif?>">
							<div class="item-text">
								<a href="<?=$arItem["LINK"]?>" <?if($arItem["SELECTED"]):?>class="activ"<?endif?>>
									<?=$arItem["TEXT"]?>
									<img src="<?=$arItem[PARAMS][logo_min]?>" alt="" />
								</a>
							</div>
							<?if ($arItem["IS_PARENT"]):?>
								<?if($arItem["SELECTED"]):?> <i></i><?endif?>
							<?endif?>
						</li>
				<?endif?>
			<?endif?>
		
	<?endforeach?>
</ul>

<?endif?>