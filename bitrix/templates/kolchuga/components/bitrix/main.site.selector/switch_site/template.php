<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?foreach ($arResult["SITES"] as $key => $arSite):?>

	<?if ($arSite["CURRENT"] == "Y"):?>
		<span title="<?=$arSite["NAME"]?>" class="adventure"><?=$arSite["NAME"]?></span>
	<?else:?>
		<a class="adventure" href="<?if(is_array($arSite['DOMAINS']) && strlen($arSite['DOMAINS'][0]) > 0 || strlen($arSite['DOMAINS']) > 0):?>http://<?endif?><?=(is_array($arSite["DOMAINS"]) ? $arSite["DOMAINS"][0] : $arSite["DOMAINS"])?>
			<?=$arSite["DIR"]?>" title="<?=$arSite["NAME"]?>"><?=$arSite["NAME"]?></a>
	<?endif?>

<?endforeach;?>