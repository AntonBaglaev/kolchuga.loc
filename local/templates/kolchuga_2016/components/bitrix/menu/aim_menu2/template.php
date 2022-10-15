<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (empty($arResult)) return false;?>
<ul class="nav navbar__nav variant_adp">
	<?$prev_lv = 0;
	$kol=0;
	foreach($arResult as $arItem):
		$id = 'id_'.md5($arItem['TEXT'].$arItem['DEPTH_LEVEL']);
		if ($prev_lv && $arItem["DEPTH_LEVEL"] < $prev_lv)
			echo str_repeat("</ul></li>", ($prev_lv - $arItem["DEPTH_LEVEL"]));

		if($arItem['IS_PARENT']):?>
		<li class="aim_parent <?=$arItem['PARAMS']['CLASS']?> lvl_<?=$arItem["DEPTH_LEVEL"]?>" data-submenu-id="<?=$id?>">
			<input type="checkbox" name="toggle" class="no_check toggleSubmenu" id="sub_m<?=$kol?>">
			<label for="sub_m<?=$kol?>" class="tgs<?=$kol?> ur_<?=$arItem["DEPTH_LEVEL"]?> toggleSubmenu"><i class="fa"></i></label>
			<a href="<?=$arItem['LINK']?>" class="<?=(!empty($arItem['PARAMS']['CLASS_A'])? $arItem['PARAMS']['CLASS_A'].' ':'')?><?=$arItem['SELECTED'] ? 'active' : ''?>" title="<?=$arItem['TEXT']?>"><?=$arItem['TEXT']?></a>
			<ul id="<?=$id?>">
		<?else:?>
			<li class="<?=(!empty($arItem['PARAMS']['CLASS'])? $arItem['PARAMS']['CLASS'].' ':'')?>lvl_<?=$arItem["DEPTH_LEVEL"]?>" data-submenu-id="<?=$id?>"><a href="<?=$arItem['LINK']?>" class="<?=(!empty($arItem['PARAMS']['CLASS_A'])? $arItem['PARAMS']['CLASS_A'].' ':'')?><?=$arItem['SELECTED'] ? 'active' : ''?>" title="<?=$arItem['TEXT']?>"><?=$arItem['TEXT']?></a></li>
		<?endif;
		$prev_lv = $arItem['DEPTH_LEVEL'];
		$kol++;
	endforeach;
	if($prev_lv > 1)
		echo str_repeat("</ul></li>", ($prev_lv-1) );?>
</ul>