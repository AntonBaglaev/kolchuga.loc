<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

<?
$lastLevel = 0;
$selected = false;

foreach(array_reverse($arResult) as $arItem){
    if ($arItem["SELECTED"]>0) {
        $lastLevel = $arItem["DEPTH_LEVEL"];
        $selected = true;
    }
    if ($selected and $arItem["DEPTH_LEVEL"] < $lastLevel){
        $arResult[ $arItem["ITEM_INDEX"] ]["SELECTED"] = true;
        $lastLevel--;
    }
}
?>

<div class="menu-sitemap-tree">
<ul class="catalog_menu">
<?$previousLevel = 0;foreach($arResult as $arItem):?>
 
   <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
      <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
   <?endif?>

   <?if ($arItem["IS_PARENT"]):?>
         <li class="<?if (!$arItem["SELECTED"]):?>close<?else:?>activ_li<?endif?>">
            <a class="folder <?if($arItem["SELECTED"]):?>activ<?endif?>" href="<?=$arItem['LINK']?>"><?=$arItem["TEXT"]?></a>            
            <ul>

   <?else:?>

      <?if ($arItem["PERMISSION"] > "D"):?>
            <li>
               <div class="item-text">
				<a style="<?=$arItem["PARAMS"]["select"]?>" <?if ($arItem["SELECTED"]):?>class="activ"<?endif?> href="<?=$arItem["LINK"]?>">
			   <?=$arItem["TEXT"]?></a>
			   </div>
            </li>
      <?endif?>

   <?endif?>

   <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
   <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
</div>

<?endif?>