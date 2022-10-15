<?
IncludeModuleLangFile(__FILE__);

if (strlen($_SESSION['PICKPOINT']['PP_NAME']) > 0) 
	$displayValue = 'block'; 
else 
	$displayValue = 'none';
?>
<div class="bx_result_price">
	<a class="btn btn-default" onclick="PickPoint.open(PickpointDeliveryservice.widgetHandler<?if ($widgetParamsString):?><?=$widgetParamsString?><?endif;?>); return false;" style="cursor:pointer;">
		<?=GetMessage('PP_CHOOSE')?>
	</a>
</div>
<table id="tPP" onclick="return false;" style="display:<?=$displayValue?>;">
	<tr>
		<td><?=GetMessage('PP_DELIVERY_IN_PLACE')?>:</td>
		<td>
			<span id="sPPDelivery"><?=($_SESSION['PICKPOINT']['PP_ADDRESS'] ? $_SESSION['PICKPOINT']['PP_ADDRESS']."<br/>".$_SESSION['PICKPOINT']['PP_NAME'] : GetMessage('PP_sNONE'))?></span>
		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
<?if (!$orderPhone):?>
	<tr>
		<td><?=GetMessage('PP_SMS_PHONE')?>:</td>
		<td>
			<input type="text" name="PP_SMS_PHONE" value="<?=htmlspecialcharsbx($_SESSION['PICKPOINT']['PP_SMS_PHONE'])?>" id="pp_sms_phone" style="width: 100%;" />
			<br/><?=GetMessage('PP_EXAMPLE')?>: +79160000000
			<input type="hidden" id="pp_phone_in_prop" value="N">
		</td>
	</tr>
<?else:?>
	<input type="hidden" id="pp_phone_in_prop" value="Y">
	<input type="hidden" name="PP_SMS_PHONE" value="<?=htmlspecialcharsbx($_SESSION['PICKPOINT']['PP_SMS_PHONE'])?>" id="pp_sms_phone"/>
<?endif;?>
</table>