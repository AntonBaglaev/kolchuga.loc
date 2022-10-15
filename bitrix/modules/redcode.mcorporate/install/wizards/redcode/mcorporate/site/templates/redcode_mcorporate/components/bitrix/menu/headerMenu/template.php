<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<div class="headerMenu">
	<?if (!empty($arResult)){?>
		<ul>
			<?foreach($arResult as $arItem){
				if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel)
					echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
			?>
				<?if($arItem["IS_PARENT"]){?>
					
					<?if($arItem["DEPTH_LEVEL"] == 1){?>
						<li>
							<a href="<?=$arItem["LINK"]?>" class="<?if($arItem["SELECTED"]) echo "root-item-selected"; else echo "root-item";?>">
								<?=$arItem["TEXT"]?>
							</a>
							<div>
								<ul class="root-item">
									<div class="triangle"></div>
									<div class="ulWrapper">
					<?}?>

				<?}else{?>

					<?if ($arItem["PERMISSION"] > "D"){?>

						<?if ($arItem["DEPTH_LEVEL"] == 1){?>
							<li>
								<a href="<?=$arItem["LINK"]?>" class="<?if($arItem["SELECTED"]) echo "root-item-selected"; else echo "root-item";?>">
									<?=$arItem["TEXT"]?>
								</a>
							</li>
						<?}else{?>
							<li>
								<a href="<?=$arItem["LINK"]?>" class="<?if($arItem["SELECTED"]) echo "item-selected";?>"><?=$arItem["TEXT"]?></a>
							</li>
						<?}?>

					<?}else{?>

						<?if ($arItem["DEPTH_LEVEL"] == 1){?>
							<li>
								<a href="#" class="<?if($arItem["SELECTED"]) echo "root-item-selected"; else echo "root-item";?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a>
							</li>
						<?}else{?>
							<li>
								<a href="#" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a>
							</li>
						<?}?>

					<?}?>

				<?}
				$previousLevel = $arItem["DEPTH_LEVEL"];
			}
			if ($previousLevel > 1)
				echo str_repeat("</div></ul></div></li>", ($previousLevel-1) );
			?>
			<div class="clear"></div>
		</ul>
	<?}?>
</div>
