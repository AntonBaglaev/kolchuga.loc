<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$frame = $this->createFrame()->begin();

?>
<?if(!$USER->IsAuthorized()):?>
    <?if($arResult["AUTH_SERVICES"]):?>
        <div class="bx-authform-social text-center">
            <div class="bx-authform-social-title">
                Регистрация, используя аккаунты социальных сетей
            </div>
            <?$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "profile",
                array(
                    "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                    "CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
                    "AUTH_URL"=> ($arParams["BACKURL"] ? $arParams["BACKURL"] : $arResult["BACKURL"]),
                    "POST"=>$arResult["POST"],
                    "SUFFIX" => $this->randString(8)
                ),
                $component,
                array("HIDE_ICONS"=>"Y")
            );?>
        </div>
    <?endif?>
    <form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>" class="form__horizontal form__login">
        <?if($arResult["BACKURL"] <> ''):?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?endif?>
        <div class="form__subtitle">
            Уже зарегистрированы?<br>
            <span>Зайти в профиль:</span>
        </div>
        <? 
        if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
            ShowMessage($arResult['ERROR_MESSAGE']);
        ?>
        <?foreach ($arResult["POST"] as $key => $value):?>
        	<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
        <?endforeach?>
    	<input type="hidden" name="AUTH_FORM" value="Y" />
    	<input type="hidden" name="TYPE" value="AUTH" />

        <div class="form__group">
            <label for=""><?/*=GetMessage("AUTH_LOGIN")*/?>E-mail<span class="req">*</span></label>
            <div class="form__input">
                <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" size="17" />
            </div>
        </div>
        <div class="form__group">
            <label for=""><?=GetMessage("AUTH_PASSWORD")?><span class="req">*</span></label>
            <div class="form__input">
                <input type="password" name="USER_PASSWORD" maxlength="50" size="17" autocomplete="off" />
                <?if($arResult["SECURE_AUTH"]):?>
                    <span class="bx-auth-secure" id="bx_auth_secure<?=$arResult["RND"]?>" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                        <div class="bx-auth-secure-icon"></div>
                    </span>
                    <noscript>
                        <span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                            <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                        </span>
                    </noscript>
                    <script type="text/javascript">
                        document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
                    </script>
                <?endif?>
            </div>
        </div>

        <?if ($arResult["STORE_PASSWORD"] == "Y"):?>
            <div class="form__group">
                <label class="label--checkbox" for="USER_REMEMBER_frm" title="<?=GetMessage("AUTH_REMEMBER_ME")?>">
                    <input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" />
                    <?echo GetMessage("AUTH_REMEMBER_SHORT")?>
                </label>
                <a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" class="form__link" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
            </div>
        <?endif?>

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
        			<input type="text" name="captcha_word" maxlength="50" value="" />
        		</div>
        	</div>
        <?endif?>
        <div class="form__group form__group--nolabel">
            <div class="form__input">
                <input type="submit" name="Login" class="btn btn-primary" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" />
            </div>
        </div>

    </form>
<?endif?>
