<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<table class="order_table">
<tr>
	<td valign="top" width="60%">
		<h3 class="color_gray"><b><?echo GetMessage("STOF_PAYMENT_WAY")?></b></h3>
		<?
		if ($arResult["PAY_FROM_ACCOUNT"]=="Y")
		{
			?>
			<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="Y">
			<input type="checkbox" name="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT" value="Y"<?if($arResult["PAY_CURRENT_ACCOUNT"]!="N") echo " checked";?>> <label for="PAY_CURRENT_ACCOUNT"><b><?echo GetMessage("STOF_PAY_FROM_ACCOUNT")?></b></label><br />
			<?=GetMessage("STOF_ACCOUNT_HINT1")?> <b><?=$arResult["CURRENT_BUDGET_FORMATED"]?></b> <?echo GetMessage("STOF_ACCOUNT_HINT2")?>
			<br /><br />
			<?
		}
		?>
		<?
		if(count($arResult["PAY_SYSTEM"])>0)
		{
			?>
			<table class="sale_order_full_table" id="sale_order_full_table" <? if ($arResult["PAY_FROM_ACCOUNT"]=="Y") echo "style=\"display:none_\""; ?>>
				<tr>
					<td colspan="2">
						
						<?echo GetMessage("STOF_PAYMENT_HINT")?><br /><br />
						
					</td>
				</tr>
				<?
				foreach($arResult["PAY_SYSTEM"] as $arPaySystem)
				{
					?>
					<tr>
						<td valign="top" width="0%">
							<input type="radio" id="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>" name="PAY_SYSTEM_ID" value="<?= $arPaySystem["ID"] ?>"<?if ($arPaySystem["CHECKED"]=="Y") echo " checked";?>>
						</td>
						<td valign="top" width="100%">
							<label for="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>">
							<b><?= $arPaySystem["PSA_NAME"] ?></b><br />
							<?
							if (strlen($arPaySystem["DESCRIPTION"])>0)
							{
								?>
								<?=$arPaySystem["DESCRIPTION"]?>
								<br />
								<?
							}
							?>
							</label>
							
						</td>
					</tr>
					<?
				}
				?>
			</table>
		<?
		}
		if ($arResult["HaveTaxExempts"]=="Y")
		{
			?>
			<br />
			<input type="checkbox" name="TAX_EXEMPT" value="Y" checked> <b><?echo GetMessage("STOF_TAX_EX")?></b><br />
			<?echo GetMessage("STOF_TAX_EX_PROMT")?>
			<br /><br />
			<?
		}
		?>
	</td>
	<td valign="top" >
		<?echo GetMessage("STOF_PRIVATE_NOTES")?>
	</td>
</tr>
<tr>
	<td width="60%" colspan="2">
	<?if(!($arResult["SKIP_FIRST_STEP"] == "Y" && $arResult["SKIP_SECOND_STEP"] == "Y" && $arResult["SKIP_THIRD_STEP"] == "Y"))
	{
		?>
		<div class="button_gray prv">
			<input type="submit" name="backButton" value="<?echo GetMessage("SALE_BACK_BUTTON")?>">
		</div>?????
		<?
	}
	?>
		<div class="button_gray nxt">
			<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONTINUE")?>">
		</div>
	</td>
</tr>
</table>
