<?
use \Bitrix\Main\Localization\Loc;

// Zones setup option tab

Loc::loadMessages(__FILE__);

$hFile = fopen($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/pickpoint.deliveryservice/cities.csv', 'r');
$arCities = array();

while ($sStr = fgets($hFile)) 
{
	$arStr = explode(';', $sStr);
	//$arCity = CPickpoint::GetCity(Array("PP_ID"=>trim($arStr[0]),"CODE"=>trim($arStr[2])));
	if ('true' === trim($arStr[4])) 
	{
		$arCity['NAME'] = trim($arStr[1]);
		$arCities[] = $arCity;
	}
}
?>
<tr>
	<td valign="top" width="50%">
		<span class="required">*</span><?=Loc::getMessage('PP_STORE_LOCATION');?>
	</td>
	<td valign="top" width="50%">
		<select name="pp_from_city">
			<?foreach ($arCities as $iKey => $arCity) {?>
				<option <?if ($arOptions['OPTIONS']['pp_from_city'] == $arCity['NAME']) {?>selected="selected"<?}?>><?=$arCity['NAME'];?></option>
			<?}?>
		</select>
	</td>
</tr>
<?// VAT?>
<tr>
	<td valign="top" width="50%">
		<?=Loc::getMessage('PP_VAT_DELIVERY_VAT_TITLE');?>
	</td>
	<td valign="top" width="50%">
		<select name="pp_delivery_vat">
			<?foreach (DELIVERY_VAT_ARRAY as $key => $deliveryVatItem) {?>
				<option value="<?=$key;?>" <?if ($arOptions['OPTIONS']['pp_delivery_vat'] == $key) {?>selected="selected"<?}?>><?=$deliveryVatItem['TITLE'];?></option>
			<?}?>
		</select>
	</td>
</tr>
<?// REVERT?>
<tr class="heading">
	<td colspan="3"><?=Loc::getMessage('PP_REVERT_TITLE');?></td>
</tr>
<tr>
	<td valign="top" width="50%">
		<?=Loc::getMessage('PP_REVERT_REGION');?>
	</td>
	<td valign="top" width="50%">
		<input type="text" size="30" maxlength="255" value="<?=htmlspecialcharsbx($arOptions['OPTIONS']['pp_store_region']);?>" name="pp_store_region" />
	</td>
</tr>
<tr>
	<td valign="top" width="50%">
		<span class="required">*</span><?=Loc::getMessage('PP_REVERT_CITY');?>
	</td>
	<td valign="top" width="50%">
		<select name="pp_store_city">
			<?foreach ($arCities as $iKey => $arCity) {?>
				<option <?if ($arOptions['OPTIONS']['pp_store_city'] == $arCity['NAME']) {?>selected="selected"<?}?>><?=$arCity['NAME'];?></option>
			<?}?>
		</select>
	</td>
</tr>
<tr>
	<td valign="top" width="50%">
		<?/*<span class="required">*</span>*/?><?=Loc::getMessage('PP_STORE_ADDRESS');?>
	</td>
	<td valign="top" width="50%">
		<input type="text" size="30" maxlength="255" value="<?=htmlspecialcharsbx($arOptions['OPTIONS']['pp_store_address']);?>" name="pp_store_address" />
	</td>
</tr>
<tr>
	<td valign="top" width="50%">
		<?/*<span class="required">*</span>*/?><?=Loc::getMessage('PP_STORE_PHONE');?>
	</td>
	<td valign="top" width="50%">
		<input type="text" size="30" maxlength="255" value="<?=htmlspecialcharsbx($arOptions['OPTIONS']['pp_store_phone']);?>" name="pp_store_phone" />
	</td>
</tr>
<tr>
	<td valign="top" width="50%">
		<?=Loc::getMessage('PP_REVERT_FIO');?>
	</td>
	<td valign="top" width="50%">
		<input type="text" size="30" maxlength="255" value="<?=htmlspecialcharsbx($arOptions['OPTIONS']['pp_store_fio']);?>" name="pp_store_fio" />
	</td>
</tr>
<tr>
	<td valign="top" width="50%">
		<?=Loc::getMessage('PP_REVERT_POST');?>
	</td>
	<td valign="top" width="50%">
		<input type="text" size="30" maxlength="255" value="<?=htmlspecialcharsbx($arOptions['OPTIONS']['pp_store_post']);?>" name="pp_store_post" />
	</td>
</tr>
<tr>
	<td valign="top" width="50%">
		<?=Loc::getMessage('PP_REVERT_Organisation');?>
	</td>
	<td valign="top" width="50%">
		<input type="text" size="30" maxlength="255" value="<?=htmlspecialcharsbx($arOptions['OPTIONS']['pp_store_organisation']);?>" name="pp_store_organisation" />
	</td>
</tr>
<tr>
	<td valign="top" width="50%">
		<?=Loc::getMessage('PP_REVERT_COMMENT');?>
	</td>
	<td valign="top" width="50%">
		<input type="text" size="30" maxlength="255" value="<?=htmlspecialcharsbx($arOptions['OPTIONS']['pp_store_comment']);?>" name="pp_store_comment" />
	</td>
</tr>
<?// DIMENSIONS?>
<tr class="heading">
	<td colspan="3"><?=Loc::getMessage('PP_DIMENSIONS_TITLE');?></td>
</tr>
<tr>
	<td valign="top" width="50%">
		<span class="required">*</span><?=Loc::getMessage('PP_DIMENSIONS_WiDTH');?>
	</td>
	<td valign="top" width="50%">
		<input type="text" size="30" maxlength="255" value="<?=htmlspecialcharsbx($arOptions['OPTIONS']['pp_dimension_width']);?>" name="pp_dimension_width" />
	</td>
</tr>
<tr>
	<td valign="top" width="50%">
		<span class="required">*</span><?=Loc::getMessage('PP_DIMENSIONS_HEIGHT');?>
	</td>
	<td valign="top" width="50%">
		<input type="text" size="30" maxlength="255" value="<?=htmlspecialcharsbx($arOptions['OPTIONS']['pp_dimension_height']);?>" name="pp_dimension_height" />
	</td>
</tr>
<tr>
	<td valign="top" width="50%">
		<span class="required">*</span><?=Loc::getMessage('PP_DIMENSIONS_DEPTH');?>
	</td>
	<td valign="top" width="50%">
		<input type="text" size="30" maxlength="255" value="<?=htmlspecialcharsbx($arOptions['OPTIONS']['pp_dimension_depth']);?>" name="pp_dimension_depth" />
	</td>
</tr>
<?// ZONES?>
<tr>
	<td colspan="3" style="text-align: center; color: red;">
		<span><?=Loc::getMessage('PP_TARIF_TITLE');?></span>
	</td>
</tr>
<tr class="heading">
	<td><?=Loc::getMessage('PPOINT_ZONES_TAB_TITLE');?></td>
	<td><?=Loc::getMessage('PP_USER_PRICE');?></td>
	<td><?=Loc::getMessage('PP_DELIVERY_FREE_DISCOUNT');?></td>
</tr>
<?
$arZones=CPickpoint::GetZonesArray();
?>
<tr>
	<td style="text-align: center;"><?=Loc::getMessage('PP_ZONE');?> <?=-1?> <?=Loc::getMessage('PP_MOSKOV');?></td>
	<td style="text-align: center;">
		<?
		if (isset($_REQUEST['ZONES'][1]['PRICE'])) 
		{
			$iVal = $_REQUEST['ZONES'][1]['PRICE'];
			$iValFree = $_REQUEST['ZONES'][1]['FREE'];
		} 
		else
		{
			$iVal = $arZones[1]['PRICE'];
			$iValFree = $arZones[1]['FREE'];
		}
		?>
		<input type="text" name="ZONES[<?=1?>][PRICE]" value="<?=number_format($iVal, 2, '.', '');?>" />
	</td>
	<td style="text-align: center;">
		<input type="text" name="ZONES[<?=1?>][FREE]" value="<?=number_format($iValFree, 2, '.', '');?>" />
	</td>
</tr>
<tr>
	<td style="text-align: center;"><?=Loc::getMessage('PP_ZONE');?> <?=0?> <?=Loc::getMessage('PP_PITER');?></td>
	<td style="text-align: center;">
		<?
		if (isset($_REQUEST['ZONES'][2]['PRICE'])) 
		{
			$iVal = $_REQUEST['ZONES'][2]['PRICE'];
			$iValFree = $_REQUEST['ZONES'][2]['FREE'];
		} 
		else
		{
			$iVal = $arZones[2]['PRICE'];
			$iValFree = $arZones[2]['FREE'];
		}
		?>
		<input type="text" name="ZONES[<?=2?>][PRICE]" value="<?=number_format($iVal, 2, '.', '');?>" />
	</td>
	<td style="text-align: center;">
		<input type="text" name="ZONES[<?=2?>][FREE]" value="<?=number_format($iValFree, 2, '.', '');?>" />
	</td>
</tr>
<?for ($iKey=3; $iKey<=PP_ZONES_COUNT; ++$iKey) {?>
	<tr>
		<td style="text-align: center;"><?=Loc::getMessage('PP_ZONE');?> <?=$iKey-2;?></td>
		<td style="text-align: center;">
			<?
			if (isset($_REQUEST['ZONES'][$iKey]['PRICE'])) 
			{
				$iVal = $_REQUEST['ZONES'][$iKey]['PRICE'];
				$iValFree = $_REQUEST['ZONES'][$iKey]['FREE'];
			} 
			else 
			{
				$iVal = $arZones[$iKey]['PRICE'];
				$iValFree = $arZones[$iKey]['FREE'];
			}
			?>
			<input type="text" name="ZONES[<?=$iKey;?>][PRICE]" value="<?=number_format($iVal, 2, '.', '');?>" />
		</td>
		<td style="text-align: center;">
			<input type="text" name="ZONES[<?=$iKey;?>][FREE]" value="<?=number_format($iValFree, 2, '.', '');?> "/>
		</td>
	</tr>
<?}?>
<tr class="heading">
	<td colspan="3"><?=Loc::getMessage('PP_COEFF');?></td>
</tr>
<tr>
	<td valign="top">
		<input type="checkbox" id="pp_use_coeff" <?=$arOptions['OPTIONS']['pp_use_coeff'] ? 'checked' : ''?> name="pp_use_coeff" />
	</td>
	<td valign="top">
		<label for="pp_use_coeff"><?=Loc::getMessage('PP_USE_COEFF');?></label>
	</td>
</tr>
<?if ($arOptions['OPTIONS']['pp_use_coeff']) {?>
	<tr>
		<td align="left"><?=Loc::getMessage('PP_COEFF_CUSTOM');?></td>
		<td>
			<input type="text" name="pp_custom_coeff" value="<?=$arOptions['OPTIONS']['pp_custom_coeff'] ? number_format($arOptions['OPTIONS']['pp_custom_coeff'], 2, '.', '') : '' ?>" />
		</td>
	</tr>
<?}?>