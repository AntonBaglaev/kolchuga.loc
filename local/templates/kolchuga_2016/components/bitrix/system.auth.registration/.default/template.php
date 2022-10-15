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

LocalRedirect('/register/'); die();

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");
?>

<?
if(!empty($arParams["~AUTH_RESULT"])):
	$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
?>
	<div class="alert <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
<?endif?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
	<div class="alert alert-success"><?echo GetMessage("AUTH_EMAIL_SENT")?></div>
<?else:?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
	<div class="alert alert-warning"><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></div>
<?endif?>


<div class="registration">
	<div class="registration--left">

		<form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform" class="form__horizontal form__register">
			<input type="hidden" name="backurl" value="/personal/profile/" />
			<input type="hidden" name="AUTH_FORM" value="Y" />
			<input type="hidden" name="TYPE" value="REGISTRATION" />

			<div class="form__group">
				<label for=""><?=GetMessage("AUTH_LOGIN_MIN")?><span class="req">*</span></label>
				<div class="form__input">
					<input type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["USER_LOGIN"]?>" />
				</div>
			</div>
			<div class="form__group">
				<label for=""><?=GetMessage("AUTH_PASSWORD_REQ")?><span class="req">*</span></label>
				<div class="form__input">
					<?if($arResult["SECURE_AUTH"]):?>
						<div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>
						<script type="text/javascript">
						document.getElementById('bx_auth_secure').style.display = '';
						</script>
					<?endif?>
					<input type="password" name="USER_PASSWORD" maxlength="255" value="<?=$arResult["USER_PASSWORD"]?>" autocomplete="off" />
				</div>
			</div>
			<div class="form__group">
				<label for=""><?=GetMessage("AUTH_CONFIRM")?><span class="req">*</span></label>
				<div class="form__input">
					<?if($arResult["SECURE_AUTH"]):?>
						<div class="bx-authform-psw-protected" id="bx_auth_secure_conf" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

						<script type="text/javascript">
							document.getElementById('bx_auth_secure_conf').style.display = '';
						</script>
					<?endif?>
					<input type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" autocomplete="off" />
				</div>
			</div>
			<div class="form__group">
				<label for=""><?=GetMessage("AUTH_EMAIL")?><?if($arResult["EMAIL_REQUIRED"]):?><span class="req">*</span><?endif?></label>
				<div class="form__input">
					<input type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" />
				</div>
			</div>
			<?/*<div class="form__group">
				<label for=""><?=GetMessage("AUTH_NAME")?></label>
				<div class="form__input">
					<input type="text" name="USER_NAME" maxlength="255" value="<?=$arResult["USER_NAME"]?>" />
				</div>
			</div>
			<div class="form__group">
				<label for=""><?=GetMessage("AUTH_LAST_NAME")?></label>
				<div class="form__input">
					<input type="text" name="USER_LAST_NAME" maxlength="255" value="<?=$arResult["USER_LAST_NAME"]?>" />
				</div>
			</div> */?>
			<?

			if($arResult["USER_PROPERTIES"]["SHOW"] == "Y")
			{
				foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField)
				{
					?><div class="form__group">
						<label for="">
							<?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="req">*</span><?endif;?>
						</label>
						<div class="form__input">
							<?
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
							?>
						</div>
					</div><?
				}
			}

			/* CAPTCHA */
			if ($arResult["USE_CAPTCHA"] == "Y")
			{

				?><div class="form__group form__group--captcha">
					<label for="">
						<?=GetMessage("CAPTCHA_REGF_PROMT")?>:<span class="req">*</span>
					</label>
					<div class="form__input">
						<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
						<span class="form__input__img">
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" alt="CAPTCHA" />
						</span>
						<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
					</div>
				</div><?

			}
			/* !CAPTCHA */
			?>
			<div class="form__group">
				<label class="label--checkbox">
					<input type="checkbox" value="">
					Оповещать меня об акциях, скидках и новостях "Кольчуги"
				</label>
			</div>
			<div class="form__group form__group--nolabel">
				<div class="form__input">
					<input type="submit" class="btn btn-primary" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>">
				</div>
			</div>

		</form>

	</div>
	<div class="registration--right">
		<?$APPLICATION->IncludeComponent("bitrix:system.auth.form","social",Array(
			"REGISTER_URL" => "/register/",
			"FORGOT_PASSWORD_URL" => "",
			"PROFILE_URL" => "/personal/profile/",
			"SHOW_ERRORS" => "Y"
		));?>
	</div>
</div>
<?if(!$USER->IsAuthorized()):?>
	<div class="registration__info">
		После регистрации на сайте Вам будет доступно отслеживание состояния заказов, онлайн-оплата заказа, личный кабинет, возможность использовать вашу скидочную карту и другие новые возможности.
	</div>
<?endif?>


<script type="text/javascript">
	document.bform.USER_NAME.focus();
</script>

<?endif?>
