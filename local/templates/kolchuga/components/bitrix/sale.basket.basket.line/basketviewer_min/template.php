<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($_REQUEST['ajax'] == 'Y' && ($_REQUEST['products'] || $_REQUEST['calc'] == 'Y')){
	echo json_encode(array('STATUS' => 'SUCCESS', 'COUNT' => $arResult["NUM_PRODUCTS"]));
	die();
}?>
<?
	if($arParams["SHOW_PERSONAL_LINK"] == "Y")
	{
		?><li>
			<a href="<?=$arParams["PATH_TO_PERSONAL"]?>" title="<?= GetMessage("TSB1_PERSONAL") ?>"><span class="icon-user"></span></a>
		</li><?
	}
?>
<li>
	<?
	if (IntVal($arResult["NUM_PRODUCTS"])>0)
	{
		?>
			<a href="<?=$arParams["PATH_TO_BASKET"]?>">
				<span id="bid" class="icon-shopping-bag js-cart-count">
					<b><?=$arResult["NUM_PRODUCTS"];?></b>
				</span>
			</a>
		<?
	}
	else
	{
		?><a href="<?=$arParams["PATH_TO_BASKET"]?>"><span id="bid" class="icon-shopping-bag js-cart-count"></span></a><?
		/*?><?=$arResult["ERROR_MESSAGE"]?><?*/
	}
	?>
	<?if (IntVal($arResult["NUM_PRODUCTS"])>0):?>
	<?endif;?>
</li>