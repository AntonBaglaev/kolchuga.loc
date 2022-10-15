<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?if (!empty($arResult)):?>

<div class="block_top_menu_child">
	<div class="block_menu_child_body">
		<div class="right_el_int">		
			<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
					"AREA_FILE_SHOW" => "sect", 
					"AREA_FILE_SUFFIX" => "fs", 
					"AREA_FILE_RECURSIVE" => "Y", 
					"EDIT_TEMPLATE" => "" 
				)
			);?>					
		</div>		
		<ul class="top_menu_child">
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
</div>

<?endif?>