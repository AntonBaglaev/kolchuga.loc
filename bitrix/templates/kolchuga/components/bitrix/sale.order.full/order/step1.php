<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<table class="order_table">
<tr>
	<td valign="top" style="width:60%">
		
		<div class="p">
			<?echo GetMessage("STOF_SELECT_PERS_TYPE")?><br /><br />
			<?
			foreach($arResult["PERSON_TYPE_INFO"] as $v)
			{
				?><input type="radio" id="PERSON_TYPE_<?= $v["ID"] ?>" name="PERSON_TYPE" value="<?= $v["ID"] ?>"<?if ($v["CHECKED"]=="Y") echo " checked";?>> <label for="PERSON_TYPE_<?= $v["ID"] ?>"><?= $v["NAME"] ?></label><br /><?
			}
			?>
		</div>
		
	</td>
	<td>
		<div class="p"><?echo GetMessage("STOF_PROC_DIFFERS")?></div>
		<div class="p">
			<?echo GetMessage("STOF_PRIVATE_NOTES")?>
		</div>
	</td>
</tr>
<tr>
	<td colspan="2">
		<div class="button_gray nxt">
			<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONTINUE")?>" />
		<div>
	</td>
</tr>
</table>