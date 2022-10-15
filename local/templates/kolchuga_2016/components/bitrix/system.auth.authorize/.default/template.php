<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");

?><div class="auth">
	<div class="auth--left"><?

		if(!empty($arParams["~AUTH_RESULT"]))
		{
			$arParams["~AUTH_RESULT"] = str_replace('логин', 'E-Mail', $arParams["~AUTH_RESULT"]);
			$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
			?><div class="alert alert-danger"><?=nl2br(htmlspecialcharsbx($text))?></div><?
		}

		if($arResult['ERROR_MESSAGE'] <> '')
		{
			$text = str_replace(array("<br>", "<br />"), "\n", $arResult['ERROR_MESSAGE']);

			?><div class="alert alert-danger"><?=nl2br(htmlspecialcharsbx($text))?></div><?
		}

		?><form name="form_auth" method="post" target="_top" class="form__horizontal form__login" action="<?=$arResult["AUTH_URL"]?>">
			<input type="hidden" name="AUTH_FORM" value="Y" />
			<input type="hidden" name="TYPE" value="AUTH" />
			<?if (strlen($arResult["BACKURL"]) > 0):?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<?endif?>
			<?foreach ($arResult["POST"] as $key => $value):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endforeach?>
			<div class="form__group">
				<label for=""><?=GetMessage("AUTH_LOGIN")?><span class="req">*</span></label>
				<div class="form__input">
					<input type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
				</div>
			</div>
			<div class="form__group">
				<label for=""><?=GetMessage("AUTH_PASSWORD")?><span class="req">*</span></label>
				<div class="form__input">
					<?if($arResult["SECURE_AUTH"]):?>
						<div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>
						<script type="text/javascript">
						document.getElementById('bx_auth_secure').style.display = '';
						</script>
					<?endif?>
					<input type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off" />
				</div>
			</div>
			<?if ($arResult["CAPTCHA_CODE"]):?>
	            <div class="form__group form__group--captcha">
	        		<label for="">
	        			<?=GetMessage("AUTH_CAPTCHA_PROMT")?>:<span class="req">*</span>
	        		</label>
	        		<div class="form__input">
	        			<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
	        			<span class="form__input__img">
	        				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" alt="CAPTCHA" />
	        			</span>
	        			<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
	        		</div>
	        	</div>
	        <?endif?>
			<div class="form__group">
				<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
					<label class="label--checkbox">
						<input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" />
						<?=GetMessage("AUTH_REMEMBER_ME")?>
					</label>
				<?endif?>
				<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
					<a href="/personal/profile/?forgot_password=yes" class="form__link" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
				<?endif?>
			</div>
			<div class="form__group form__group--nolabel">
				<div class="form__input">
					<input type="submit" class="btn btn-primary" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
				</div>
			</div>
		</form>
	</div>
	<div class="auth__center">
		<?if($arResult["AUTH_SERVICES"]):?>
			<?
			$APPLICATION->IncludeComponent("bitrix:socserv.auth.form",
				"auth",
				array(
					"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
					"AUTH_URL" => $arResult["AUTH_URL"],
					"POST" => $arResult["POST"],
				),
				$component,
				array("HIDE_ICONS"=>"Y")
			);
			?>
		<?endif?>
	</div>
	<div class="auth--right">
		<?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
			<div class="auth__subtitle">
				<?=GetMessage('AUTH_NO_REGISTER')?>
			</div>
			<div class="auth__info">
				<?=GetMessage('AUTH_AFTER_REGISTER')?>
			</div>
			<div class="auth__btn">
				<a href="<?=$arResult["AUTH_REGISTER_URL"]?>" class="btn btn-primary"><?=GetMessage("AUTH_REGISTER")?></a>
			</div>
		<?endif?>
	</div>
</div>
<script type="text/javascript">
	<?if (strlen($arResult["LAST_LOGIN"])>0):?>
		try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
	<?else:?>
		try{document.form_auth.USER_LOGIN.focus();}catch(e){}
	<?endif?>
</script>
