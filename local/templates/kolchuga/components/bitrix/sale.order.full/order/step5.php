<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<table border="0" cellspacing="0" cellpadding="5">

<tr>
	<td valign="top" width="60%">
		<?
		if(!empty($arResult["ORDER_PROPS_PRINT"]))
		{
			?>
			<h3 class="color_gray"><b><?echo GetMessage("STOF_ORDER_PARAMS")?></b></h3>
			<table class="sale_order_full_table">
				<?
				foreach($arResult["ORDER_PROPS_PRINT"] as $arProperties)
				{
					if ($arProperties["SHOW_GROUP_NAME"] == "Y")
					{
						?>
						<tr>
							<td colspan="2" class="group_name" align="center"><b><?= $arProperties["GROUP_NAME"] ?></b></td>
						</tr>
						<?
					}
					if(strLen($arProperties["VALUE_FORMATED"])>0)
					{
						?>
						<tr>
							<td width="50%" valign="top">
								<b><?= $arProperties["NAME"] ?></b>:
							</td>
							<td width="50%"><?=$arProperties["VALUE_FORMATED"]?></td>
						</tr>
						<?
					}
				}
				?>
			</table>
			<?
		}
		?>
		<h3 class="color_gray"><b><?echo GetMessage("STOF_PAY_DELIV")?></b></h3>

		<table class="sale_order_full_table">
			<tr>
				<td width="50%"><b><?= GetMessage("SALE_DELIV_SUBTITLE")?></b>:</td>
				<td width="50%">
					<?
					//echo "<pre>"; print_r($arResult); echo "</pre>";
					if (is_array($arResult["DELIVERY"]))
					{
						echo $arResult["DELIVERY"]["NAME"];
						if (is_array($arResult["DELIVERY_ID"]))
						{
							echo " (".$arResult["DELIVERY"]["PROFILES"][$arResult["DELIVERY_PROFILE"]]["TITLE"].")";
						}
					}
					elseif ($arResult["DELIVERY"]=="ERROR")
					{
						echo ShowError(GetMessage("SALE_ERROR_DELIVERY"));
					}
					else
					{
						echo GetMessage("SALE_NO_DELIVERY");
					}
					?>
				</td>
			</tr>
			<?if(is_array($arResult["PAY_SYSTEM"]) || $arResult["PAY_SYSTEM"]=="ERROR" || $arResult["PAYED_FROM_ACCOUNT"] == "Y")
			{
				?>
				<tr>
					<td width="50%"><b><?= GetMessage("SALE_PAY_SUBTITLE")?></b>:</td>
					<td width="50%">
						<?
						if($arResult["PAYED_FROM_ACCOUNT"] == "Y")
							echo " (".GetMessage("STOF_PAYED_FROM_ACCOUNT").")";
						elseif (is_array($arResult["PAY_SYSTEM"]))
						{
							echo $arResult["PAY_SYSTEM"]["PSA_NAME"];
						}
						elseif ($arResult["PAY_SYSTEM"]=="ERROR")
						{
							echo ShowError(GetMessage("SALE_ERROR_PAY_SYS"));
						}
						elseif($arResult["PAYED_FROM_ACCOUNT"] != "Y")
						{
							echo GetMessage("STOF_NOT_SET");
						}
						
						?>				
					</td>
				</tr>
				<?
			}
			?>
		</table>
		<h3 class="color_gray"><b><?= GetMessage("SALE_ORDER_CONTENT")?></b></h3>

		<table class="sale_order_full data-table">
			<tr>
				<th><?echo GetMessage("SALE_CONTENT_NAME")?></th>
				<th><?echo GetMessage("SALE_CONTENT_PROPS")?></th>
				<th><?echo GetMessage("SALE_CONTENT_PRICETYPE")?></th>
				<th><?echo GetMessage("SALE_CONTENT_DISCOUNT")?></th>
				<th><?echo GetMessage("SALE_CONTENT_WEIGHT")?></th>
				<th><?echo GetMessage("SALE_CONTENT_QUANTITY")?></th>
				<th><?echo GetMessage("SALE_CONTENT_PRICE")?></th>
			</tr>
			<?
			foreach($arResult["BASKET_ITEMS"] as $arBasketItems)
			{
				?>
				<tr>
					<td><?=$arBasketItems["NAME"]?></td>
					<td>
						<?
						foreach($arBasketItems["PROPS"] as $val)
						{
							echo $val["NAME"].": ".$val["VALUE"]."<br />";
						}
						?>
					</td>
					<td><?=$arBasketItems["NOTES"]?></td>
					<td><?=$arBasketItems["DISCOUNT_PRICE_PERCENT_FORMATED"]?></td>
					<td><?=$arBasketItems["WEIGHT_FORMATED"]?></td>
					<td><?=$arBasketItems["QUANTITY"]?></td>
					<td align="right"><?=$arBasketItems["PRICE_FORMATED"]?></td>
				</tr>
				<?
			}
			?>
			<tr>
				<td align="right"><b><?=GetMessage("SALE_CONTENT_WEIGHT_TOTAL")?>:</b></td>
				<td align="right" colspan="6"><?=$arResult["ORDER_WEIGHT_FORMATED"]?></td>
			</tr>
			<tr>
				<td align="right"><b><?=GetMessage("SALE_CONTENT_PR_PRICE")?>:</b></td>
				<td align="right" colspan="6"><?=$arResult["ORDER_PRICE_FORMATED"]?></td>
			</tr>
			<?
			if (doubleval($arResult["DISCOUNT_PRICE_FORMATED"]) > 0)
			{
				?>
				<tr>
					<td align="right"><b><?echo GetMessage("SALE_CONTENT_DISCOUNT")?>:</b></td>
					<td align="right" colspan="6"><?echo $arResult["DISCOUNT_PRICE_FORMATED"]?>
						<?if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"])>0):?>
							(<?echo $arResult["DISCOUNT_PERCENT_FORMATED"];?>)
						<?endif;?>
					</td>
				</tr>
				<?
			}
			if (doubleval($arResult["VAT_PRICE"]) > 0)
			{
				?>
				<tr>
					<td align="right">
						<b><?echo GetMessage("SALE_CONTENT_VAT")?>:</b>
					</td>
					<td align="right" colspan="6"><?=$arResult["VAT_PRICE_FORMATED"]?></td>
				</tr>
				<?
			}
			if(!empty($arResult["arTaxList"]))
			{
				foreach($arResult["arTaxList"] as $val)
				{
					?>
					<tr>
						<td align="right"><?=$val["NAME"]?> <?=$val["VALUE_FORMATED"]?>:</td>
						<td align="right" colspan="6"><?=$val["VALUE_MONEY_FORMATED"]?></td>
					</tr>
					<?
				}
			}
			if (doubleval($arResult["DELIVERY_PRICE"]) > 0)
			{
				?>
				<tr>
					<td align="right">
						<b><?echo GetMessage("SALE_CONTENT_DELIVERY")?>:</b>
					</td>
					<td align="right" colspan="6"><?=$arResult["DELIVERY_PRICE_FORMATED"]?></td>
				</tr>
				<?
			}
			?>
			<tr>
				<td align="right"><b><?= GetMessage("SALE_CONTENT_ITOG")?>:</b></td>
				<td align="right" colspan="6"><b><?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></b>
				</td>
			</tr>
			<?
			if (doubleval($arResult["PAYED_FROM_ACCOUNT_FORMATED"]) > 0)
			{
				?>
				<tr>
					<td align="right"><b><?echo GetMessage("STOF_PAY_FROM_ACCOUNT1")?></b></td>
					<td align="right" colspan="6"><?=$arResult["PAYED_FROM_ACCOUNT_FORMATED"]?></td>
				</tr>
				<?
			}
			?>
		</table>

		<br /><br />
		<h3 class="color_gray"><b><?= GetMessage("SALE_ADDIT_INFO")?></b></h3>

		<table class="sale_order_full_table">
			<tr>
				<td width="50%" valign="top">
					<?= GetMessage("SALE_ADDIT_INFO_PROMT")?>
				</td>
				<td width="50%" valign="top">
					<textarea rows="4" class="input_inside" cols="40" name="ORDER_DESCRIPTION"><?=$arResult["ORDER_DESCRIPTION"]?></textarea>
				</td>
			</tr>
		</table>
	</td>
	<td valign="top" >
		<?echo GetMessage("STOF_CORRECT_PROMT_NOTE")?><br /><br />
		<?echo GetMessage("STOF_CONFIRM_NOTE")?><br /><br />
		<?echo GetMessage("STOF_CORRECT_ADDRESS_NOTE")?><br /><br />
		<?echo GetMessage("STOF_PRIVATE_NOTES")?>
	</td>
</tr>
<tr>
	<td width="60%">
		<?if(!($arResult["SKIP_FIRST_STEP"] == "Y" && $arResult["SKIP_SECOND_STEP"] == "Y" && $arResult["SKIP_THIRD_STEP"] == "Y" && $arResult["SKIP_FORTH_STEP"] == "Y"))
		{
			?>
			<div class="button_gray prv">
				<input type="submit" name="backButton" value="<?echo GetMessage("SALE_BACK_BUTTON")?>">
			</div>     
			<?
		}
		?>
		<div class="button_gray nxt">
			<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONFIRM")?>">
		</div>
	</td>
</tr>
</table>