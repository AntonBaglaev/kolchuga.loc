<?
use \PickPoint\DeliveryService\Bitrix\Tools;
use \Bitrix\Main\Localization\Loc;

// FAQ option tab
?>
<tr class="heading">
	<td colspan="2" valign="top" align="center"><?=Loc::getMessage('PICKPOINT_DELIVERYSERVICE_FAQ_HDR_MODULE');?></td>
</tr>
<tr>
	<td colspan="2">
		<?Tools::placeFAQ('ABOUT');?>		
	</td>
</tr>
<tr class="heading">
	<td colspan="2" valign="top" align="center"><?=Loc::getMessage('PICKPOINT_DELIVERYSERVICE_FAQ_HDR_SETUP');?></td>
</tr>
<tr>
	<td colspan="2">
		<?Tools::placeFAQ('INTRO');?>		
		<?Tools::placeFAQ('ACCOUNT');?>	
		<?Tools::placeFAQ('ORDERPROPS');?>	
		<?Tools::placeFAQ('SENDERREVERT');?>	
		<?Tools::placeFAQ('ZONES');?>	
		<?Tools::placeFAQ('DELIVERY');?>	
		<?Tools::placeFAQ('PAYSYSTEM');?>	
	</td>
</tr>
<tr class="heading">
	<td colspan="2" valign="top" align="center"><?=Loc::getMessage('PICKPOINT_DELIVERYSERVICE_FAQ_HDR_WORK');?></td>
</tr>
<tr>
	<td colspan="2">
		<?Tools::placeFAQ('SEND');?>				
	</td>
</tr>
<tr class="heading">
	<td colspan="2" valign="top" align="center"><?=Loc::getMessage('PICKPOINT_DELIVERYSERVICE_FAQ_HDR_INFO');?></td>
</tr>
<tr>
	<td colspan="2">
		<?Tools::placeFAQ('EVENTHANDLERS');?>
		<?Tools::placeFAQ('UPDATE');?>				
		<?Tools::placeFAQ('HELP');?>				
	</td>
</tr>