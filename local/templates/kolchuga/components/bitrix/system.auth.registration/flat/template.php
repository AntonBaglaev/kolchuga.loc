<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");

if(!empty($arParams["~AUTH_RESULT"]))
{
	if(is_array($arParams["~AUTH_RESULT"]))
	{
		$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
	}
	else
	{
		$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]);
	}
	?><div class="alert dib <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>">
		<?=nl2br(htmlspecialcharsbx($text))?>
	</div><?
}
if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK")
{
	?><div class="alert dib alert-success"><?echo GetMessage("AUTH_EMAIL_SENT")?></div><?
}
else
{
	if($arResult["USE_EMAIL_CONFIRMATION"] === "Y")
	{
		?><div class="alert dib alert-warning"><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></div><?
	}
}
?>
<p><?=GetMessage('AUTH_REGISTER_TEXT')?></p>
<div class="row">
	<div class="col-sm-6 col-md-5 col-lg-4">
		<form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">
			<?if($arResult["BACKURL"] <> ''):?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<?endif?>
			<input type="hidden" name="AUTH_FORM" value="Y" />
			<input type="hidden" name="TYPE" value="REGISTRATION" />
			<div class="form-group">
				<label><?=GetMessage("AUTH_NAME")?><span class="req">*</span></label>
				<input type="text" name="USER_NAME" class="form-control" maxlength="255" value="<?=$arResult["USER_NAME"]?>" />
			</div>
			<div class="form-group">
				<label for=""><?=GetMessage("AUTH_LAST_NAME")?><span class="req">*</span></label>
				<input type="text" name="USER_LAST_NAME" class="form-control" maxlength="255" value="<?=$arResult["USER_LAST_NAME"]?>" />
			</div>
			<div class="form-group">
				<label><?=GetMessage("AUTH_LOGIN_MIN")?><span class="req">*</span></label>
				<input type="text" name="USER_LOGIN" class="form-control" maxlength="255" value="<?=$arResult["USER_LOGIN"]?>" />
			</div>
			<div class="form-group">
				<label><?=GetMessage("AUTH_PASSWORD_REQ")?><span class="req">*</span></label>
				<input type="password" name="USER_PASSWORD" class="form-control" maxlength="255" value="<?=$arResult["USER_PASSWORD"]?>" autocomplete="off" />
				<?if($arResult["SECURE_AUTH"]):?>
					<div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none">
						<div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div>
					</div>
					<script type="text/javascript">
					document.getElementById('bx_auth_secure').style.display = '';
					</script>
				<?endif?>
			</div>
			<div class="form-group">
				<label><?=GetMessage("AUTH_CONFIRM")?><span class="req">*</span></label>
				<input type="password" name="USER_CONFIRM_PASSWORD" class="form-control" maxlength="255" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" autocomplete="off" />
				<?if($arResult["SECURE_AUTH"]):?>
					<div class="bx-authform-psw-protected" id="bx_auth_secure_conf" style="display:none">
						<div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div>
					</div>
					<script type="text/javascript">
					document.getElementById('bx_auth_secure_conf').style.display = '';
					</script>
				<?endif?>
			</div>
			<div class="form-group">
				<label><?=GetMessage("AUTH_EMAIL")?><?if($arResult["EMAIL_REQUIRED"]):?><span class="req">*</span><?endif?></label>
				<input type="text" name="USER_EMAIL" maxlength="255" class="form-control" value="<?=$arResult["USER_EMAIL"]?>" />
			</div>
			<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
				<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
					<div class="form-group">
						<label><?=$arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="req">*</span><?endif?></label><?

						$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array(
								"bVarsFromForm" => $arResult["bVarsFromForm"],
								"arUserField" => $arUserField,
								"form_name" => "bform"
							),
							null,
							array("HIDE_ICONS"=>"Y")
						);

					?></div>
				<?endforeach;?>
			<?endif;?>
			<?if ($arResult["USE_CAPTCHA"] == "Y"):?>
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<div class="form-group">
					<label><?=GetMessage("CAPTCHA_REGF_PROMT")?><span class="req">*</span></label>
					<div class="input-group">
						<span class="input-group-addon captcha-img">
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
						</span>
						<input type="text" name="captcha_word" class="form-control" maxlength="50" value="" autocomplete="off"/>
					</div>
				</div>
			<?endif?>
			<div class="form-group">
				<input type="submit" class="btn btn-primary btn-block" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>" />
			</div>

		</form>
		<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
		<p><span class="req">*</span><?=GetMessage("AUTH_REQ")?></p>
		<p><a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_AUTH")?></a></p>
		<script type="text/javascript">
			document.bform.USER_NAME.focus();
		</script>
	</div>
	<div class="col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-1"><?

		if($arResult["AUTH_SERVICES"])
		{
			?><?
				$APPLICATION->IncludeComponent("bitrix:socserv.auth.form",
					"profile",
					array(
						"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
						"AUTH_URL" => $arResult["AUTH_URL"],
						"POST" => $arResult["POST"],
					),
					$component,
					array("HIDE_ICONS"=>"Y")
				);
			?><?
		}
		
	?></div>
</div>

