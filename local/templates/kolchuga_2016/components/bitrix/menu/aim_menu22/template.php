<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (empty($arResult)) return false;?>



<?//\Kolchuga\Settings::xmp($arResult,11460, __FILE__.": ".__LINE__);

function getItems($a) {
	if($a[0]["DEPTH_LEVEL"]==3){
		$levelhid=count($a);
	}
	foreach($a as $key=>$arItem){?>
		<?
		$id = 'id_'.md5($arItem['TEXT'].$arItem['DEPTH_LEVEL']);
		$kol=$arItem['DEPTH_LEVEL'].'_'.$key.'_'.$arItem['ITEM_INDEX'];
		if($levelhid && $key>4){
			$arItem['PARAMS']['CLASS'] .= ' levelhid';
		}
		?>
			<?if($arItem["IS_PARENT"]){?>
                <? if ($arItem['TEXT'] != 'SALE'):?>
				<li class="<?=(!empty($arItem['PARAMS']['PERSONAL_CLASS'])? $arItem['PARAMS']['PERSONAL_CLASS'].' ':'')?>aim_parent <?=($arItem['PARAMS']['CLASS']!='aim_catalog' ? $arItem['PARAMS']['CLASS']:'aim_catalog22')?> lvl_<?=$arItem["DEPTH_LEVEL"]?>" data-submenu-id="<?=$id?>" data-label="<?=(!empty($arItem['PARAMS']['DOP_INFO_MENU'])? $arItem['PARAMS']['DOP_INFO_MENU']:'')?>">
					<input type="checkbox" name="toggle" class="no_check toggleSubmenu" id="sub_m<?=$kol?>">
					<label for="sub_m<?=$kol?>" class="tgs<?=$kol?> ur_<?=$arItem["DEPTH_LEVEL"]?> toggleSubmenu"><i class="fa"></i></label>
					<a href="<?=$arItem['LINK']?>" class="li_a_lvl_<?=$arItem["DEPTH_LEVEL"]?> <?=(!empty($arItem['PARAMS']['CLASS_A'])? $arItem['PARAMS']['CLASS_A'].' ':'')?><?=$arItem['SELECTED'] ? 'active' : ''?>" title="<?=$arItem['TEXT']?>"><?=$arItem['TEXT']?><?=(!empty($arItem['PARAMS']['DOP_INFO_MENU'])? '&nbsp;<span class="dop_info_menu">('.$arItem['PARAMS']['DOP_INFO_MENU'].')</span>':'')?></a>
					<?if('aim_catalog'==$arItem['PARAMS']['CLASS']){?><div class="vipad0"><div class="vipad1"><?}?>
					<ul id="<?=$id?>" class="dropdown-menu megamenu-content <?=('aim_catalog'==$arItem['PARAMS']['CLASS'] ? 'vipad':'')?>">
						<?getItems($arItem["CHILDREN"])?>
					</ul>
					<?if('aim_catalog'==$arItem['PARAMS']['CLASS']){?></div></div><?}?>
				</li>
                <? endif?>
			<?}else{?>
				<li class="<?=(!empty($arItem['PARAMS']['PERSONAL_CLASS'])? $arItem['PARAMS']['PERSONAL_CLASS'].' ':'')?><?=(!empty($arItem['PARAMS']['CLASS'])? $arItem['PARAMS']['CLASS'].' ':'')?>lvl_<?=$arItem["DEPTH_LEVEL"]?>" data-submenu-id="<?=$id?>" data-label="<?=(!empty($arItem['PARAMS']['DOP_INFO_MENU'])? $arItem['PARAMS']['DOP_INFO_MENU']:'')?>">
					<a href="<?=$arItem['LINK']?>" class="li_a_lvl_<?=$arItem["DEPTH_LEVEL"]?> <?=(!empty($arItem['PARAMS']['CLASS_A'])? $arItem['PARAMS']['CLASS_A'].' ':'')?><?=$arItem['SELECTED'] ? 'active' : ''?>" title="<?=$arItem['TEXT']?>"><?=$arItem['TEXT']?><?=(!empty($arItem['PARAMS']['DOP_INFO_MENU'])? '&nbsp;<span class="dop_info_menu">('.$arItem['PARAMS']['DOP_INFO_MENU'].')</span>':'')?></a>
				</li>
			<?}?>		
	<?}
	if($levelhid && $levelhid>5){
		?>
		<li class="pokazatvse"><a href="<?=$a[0]['PARENTLINK']?>" class="" >показать все >></a></li>
		<?
	}
}
?>

<ul class="nav navbar__nav variant_adp">
<?getItems($arResult);?>
</ul>
