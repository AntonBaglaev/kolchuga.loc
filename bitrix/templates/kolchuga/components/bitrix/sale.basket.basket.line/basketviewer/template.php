<li class="kor"> 
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?/*echo"<pre>"; print_r($arParams); echo"</pre>";*/?>

	<table class="table-basket-line">
		<?
		if (IntVal($arResult["NUM_PRODUCTS"])>0)
		{
			?>
			<tr>
				<td><!-- <a href="<?=$arParams["PATH_TO_BASKET"]?>" class="basket-line-basket"></a> --></td>
				<td><h2 class="item-text adventure"><a href="<?=$arParams["PATH_TO_BASKET"]?>">
				<span id="bid">
				<?=$arResult["PRODUCTS"];
					/*echo '<pre>';
					print_r ($arResult);
					echo '</pre>';
				*/?>
				</span>
				</a></h2></td>
			</tr>
			<?
		}
		else
		{
			?><!-- <tr>
				<td><div class="basket-line-basket"></div></td>
				<td><?=$arResult["ERROR_MESSAGE"]?></td>
			</tr> --><?
		}
		if($arParams["SHOW_PERSONAL_LINK"] == "Y")
		{
			?>
			<tr>
				<td><a href="<?=$arParams["PATH_TO_PERSONAL"]?>" class="basket-line-personal"></a></td>
				<td><a href="<?=$arParams["PATH_TO_PERSONAL"]?>"><?= GetMessage("TSB1_PERSONAL") ?></a></td>
			</tr>
			<?
		}
		?>
	</table>
	<?if (IntVal($arResult["NUM_PRODUCTS"])>0):?>
	<i></i> <em></em>
	<?endif;?>
</li>