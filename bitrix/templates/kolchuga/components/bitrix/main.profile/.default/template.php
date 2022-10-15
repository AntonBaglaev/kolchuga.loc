<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<?ShowError($arResult["strProfileError"]);?>
<?
if ($arResult['DATA_SAVED'] == 'Y')
	ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>
	<script type="text/javascript">
	<!--
	var opened_sections = [<?
	$arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
	$arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
	if (strlen($arResult["opened"]) > 0)
	{
		echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
	}
	else
	{
		$arResult["opened"] = "reg";
		echo "'reg'";
	}
	?>];
	//-->

	var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
	</script>
	
<div>
	<div class="w50">
		<form class="form-profile" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
			<?=$arResult["BX_SESSION_CHECK"]?>
			<input type="hidden" name="lang" value="<?=LANG?>" />
			<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
			<?
				if($arResult["ID"]>0)
				{
					?><div class="form-group"><?/*
					
						if (strlen($arResult["arUser"]["TIMESTAMP_X"])>0)
						{

						?><div>
							<label><?=GetMessage('LAST_UPDATE')?></label>
							<?=$arResult["arUser"]["TIMESTAMP_X"]?>
						</div><?

						}

						if (strlen($arResult["arUser"]["LAST_LOGIN"])>0)
						{

						?><div>
							<label><?=GetMessage('LAST_LOGIN')?></label>
							<?=$arResult["arUser"]["LAST_LOGIN"]?>
						</div><?

						}
					*/?></div><?
				}
			?>
			<div class="form-group">
				<label><?=GetMessage('NAME')?></label>
				<input type="text" name="NAME" maxlength="50" class="form-control" value="<?=$arResult["arUser"]["NAME"]?>" />
			</div>
				
				<div class="form-group">
					<label><?=GetMessage('LAST_NAME')?></label>
					<input type="text" name="LAST_NAME" class="form-control" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
				</div>

			<div class="form-group">
				<label><?=GetMessage('SECOND_NAME')?></label>
				<input type="text" name="SECOND_NAME" maxlength="50" class="form-control" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
			</div>
			<div class="form-group">
				<label><?=GetMessage('USER_PHONE')?></label>
				<input type="text" name="PERSONAL_PHONE" class="form-control" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
			</div>
			<div class="form-group">
				<label><?=GetMessage('EMAIL')?><?if($arResult["EMAIL_REQUIRED"]):?><span class="req">*</span><?endif?></label>
				<input type="text" name="EMAIL" maxlength="50" class="form-control" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
			</div>
			<?if($arResult["TIME_ZONE_ENABLED"] == true):?>
				<div class="form-group">
					<div class="form-group-title"><?echo GetMessage("main_profile_time_zones")?></div>
					<label><?echo GetMessage("main_profile_time_zones_auto")?></label>
					<select name="AUTO_TIME_ZONE" onchange="this.form.TIME_ZONE.disabled=(this.value != 'N')">
						<option value=""><?echo GetMessage("main_profile_time_zones_auto_def")?></option>
						<option value="Y"<?=($arResult["arUser"]["AUTO_TIME_ZONE"] == "Y"? ' SELECTED="SELECTED"' : '')?>><?echo GetMessage("main_profile_time_zones_auto_yes")?></option>
						<option value="N"<?=($arResult["arUser"]["AUTO_TIME_ZONE"] == "N"? ' SELECTED="SELECTED"' : '')?>><?echo GetMessage("main_profile_time_zones_auto_no")?></option>
					</select>
				</div>
				<div class="form-group">
					<label><?echo GetMessage("main_profile_time_zones_zones")?></label>
					<select name="TIME_ZONE"<?if($arResult["arUser"]["AUTO_TIME_ZONE"] <> "N") echo ' disabled="disabled"'?>>
						<?foreach($arResult["TIME_ZONE_LIST"] as $tz=>$tz_name):?>
							<option value="<?=htmlspecialcharsbx($tz)?>"<?=($arResult["arUser"]["TIME_ZONE"] == $tz? ' SELECTED="SELECTED"' : '')?>><?=htmlspecialcharsbx($tz_name)?></option>
						<?endforeach?>
					</select>
				</div>
			<?endif?>
			
			<div class="form-group">
				<div>
					<label><?=GetMessage('USER_GENDER')?></label>
					<select name="PERSONAL_GENDER">
						<option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
						<option value="M"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "M" ? " SELECTED=\"SELECTED\"" : ""?>><?=GetMessage("USER_MALE")?></option>
						<option value="F"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "F" ? " SELECTED=\"SELECTED\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
					</select>
				</div>
				<div>
					<label><?=GetMessage("USER_BIRTHDAY_DT")?>:</label><?

						$APPLICATION->IncludeComponent(
							'bitrix:main.calendar',
							'',
							array(
								'SHOW_INPUT' => 'Y',
								'FORM_NAME' => 'form1',
								'INPUT_NAME' => 'PERSONAL_BIRTHDAY',
								'INPUT_VALUE' => $arResult["arUser"]["PERSONAL_BIRTHDAY"],
								'SHOW_TIME' => 'N'
							),
							null,
							array('HIDE_ICONS' => 'Y')
						);

						//=CalendarDate("PERSONAL_BIRTHDAY", $arResult["arUser"]["PERSONAL_BIRTHDAY"], "form1", "15")

				?></div>
			</div>
			<div class="form-group">
				<label><?=GetMessage("USER_PHOTO")?></label>
				<?=$arResult["arUser"]["PERSONAL_PHOTO_INPUT"]?>
				<?
				if (strlen($arResult["arUser"]["PERSONAL_PHOTO"])>0)
				{
					?><?=$arResult["arUser"]["PERSONAL_PHOTO_HTML"]?><?
				}
				?>
			</div>
			<div class="form-group">
				<label><?=GetMessage('USER_COUNTRY')?></label>
				<?=$arResult["COUNTRY_SELECT"]?>
			</div>
			<div class="form-group">
				<label><?=GetMessage('USER_STATE')?></label>
				<input type="text" name="PERSONAL_STATE" class="form-control" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_STATE"]?>" />
			</div>
			<div class="form-group">
				<label><?=GetMessage('USER_CITY')?></label>
				<input type="text" name="PERSONAL_CITY" class="form-control" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>" />
			</div>
			<div class="form-group">
				<label><?=GetMessage('USER_ZIP')?></label>
				<input type="text" name="PERSONAL_ZIP" class="form-control" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_ZIP"]?>" />
			</div>
			<div class="form-group">
				<label><?=GetMessage("USER_STREET")?></label>
				<textarea cols="30" s="5" name="PERSONAL_STREET" class="form-control"><?=$arResult["arUser"]["PERSONAL_STREET"]?></textarea>
			</div>
			<?/*<div class="form-group">
				<label><?=GetMessage('USER_MAILBOX')?></label>
				<input type="text" name="PERSONAL_MAILBOX" class="form-control" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_MAILBOX"]?>" />
			</div>*/?>
			<?/*<div class="form-group">
				<label><?=GetMessage("USER_NOTES")?></label>
				<textarea cols="30" s="5" name="PERSONAL_NOTES" class="form-control"><?=$arResult["arUser"]["PERSONAL_NOTES"]?></textarea>
			</div>*/?>
			<div class="form-group">
				<label><?=GetMessage('LOGIN')?><span class="req">*</span></label>
				<input type="text" name="LOGIN" maxlength="50" class="form-control" value="<? echo $arResult["arUser"]["LOGIN"]?>" />
			</div>
			<?if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == ''):?>
				<div class="form-group">
					<label><?=GetMessage('NEW_PASSWORD_REQ')?></label>
					<input type="password" name="NEW_PASSWORD" class="form-control" maxlength="50" value="" autocomplete="off" class="bx-auth-input" />
					<?if($arResult["SECURE_AUTH"]):?>
						<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
							<div class="bx-auth-secure-icon"></div>
						</span>
						<noscript>
							<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
								<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
							</span>
						</noscript>
						<script type="text/javascript">
						document.getElementById('bx_auth_secure').style.display = 'inline-block';
						</script>
					<?endif?>
				</div>
				<div class="form-group">
					<label><?=GetMessage('NEW_PASSWORD_CONFIRM')?></label>
					<input type="password" name="NEW_PASSWORD_CONFIRM" class="form-control" maxlength="50" value="" autocomplete="off" />
				</div>
			<?endif?>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">
				<?/*&nbsp;&nbsp;<input type="reset" class="btn btn-outline" value="<?=GetMessage('MAIN_RESET');?>">*/?>
			</div>
		</form>
	</div>
	<div class="w50">
		<?
		if($arResult["SOCSERV_ENABLED"])
		{
			$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", "", array(
					"SHOW_PROFILES" => "Y",
					"ALLOW_DELETE" => "Y"
				),
				false
			);
		}
		?>
	</div>
</div>