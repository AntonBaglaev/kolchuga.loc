<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
<?if($arResult['strProfileError']){?>
    <div class="alert alert-danger"><?= $arResult["strProfileError"] ?></div>
<?}?>
<? if($arResult['DATA_SAVED'] == 'Y'){?>
    <div class="alert alert-success"><?= GetMessage('PROFILE_DATA_SAVED') ?></div>
<?}?>
<script type="text/javascript">
    <!--
    var opened_sections = [<?
        $arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"] . "_user_profile_open"];
        $arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
        if(strlen($arResult["opened"]) > 0){
            echo "'" . implode("', '", explode(",", $arResult["opened"])) . "'";
        } else{
            $arResult["opened"] = "reg";
            echo "'reg'";
        }
        ?>];
    //-->

    var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
</script>
<div class="profile"><? if($arResult["ID"] > 0){ ?>
        <div class="profile--left">
            <form method="post"
                  name="form1"
                  class="form__horizontal form__register"
                  action="<?= $arResult["FORM_TARGET"] ?>" enctype="multipart/form-data">
                <?= $arResult["BX_SESSION_CHECK"] ?>
                <input type="hidden" name="lang" value="<?= LANG ?>"/>
                <input type="hidden" name="ID" value="<?= $arResult["ID"] ?>">
                <input type="hidden" class="js-login" name="LOGIN" value="<?= $arResult["arUser"]["LOGIN"] ?>" />

                <div class="form__group">
                    <label><?= GetMessage('NAME') ?></label>
                    <div class="form__input">
                        <input type="text"
                               name="NAME"
                               maxlength="50"
                               class="form-control"
                               value="<?= $arResult["arUser"]["NAME"] ?>"/>
                    </div>
                </div>
                <div class="form__group">
                    <label><?= GetMessage('USER_PHONE') ?></label>
                    <div class="form__input">
                        <input type="text" name="PERSONAL_PHONE" class="form-control" maxlength="255"
                               value="<?= $arResult["arUser"]["PERSONAL_PHONE"] ?>"/>
                    </div>
                </div>
                <div class="form__group">
                    <label>
                        <?= GetMessage('EMAIL') ?><? if($arResult["EMAIL_REQUIRED"]): ?>
                            <span class="req">*</span><? endif ?>
                    </label>
                    <div class="form__input">
                        <input type="text"
                               name="EMAIL"
                               maxlength="50"
                               class="form-control"
                               onchange="$('.js-login').val($(this).val())"
                               value="<? echo $arResult["arUser"]["EMAIL"] ?>"/>
                    </div>
                </div>

                <div class="form__group">
                    <label><?= GetMessage('USER_CITY') ?></label>
                    <div class="form__input">
                        <input type="text" name="PERSONAL_CITY" class="form-control" maxlength="255"
                               value="<?= $arResult["arUser"]["PERSONAL_CITY"] ?>"/>
                    </div>
                </div>

                <div class="form__group">
                    <label><?= GetMessage("USER_STREET") ?></label>
                    <div class="form__input">
                    <textarea cols="30" rows="5" name="PERSONAL_STREET"
                              class="form-control"><?= $arResult["arUser"]["PERSONAL_STREET"] ?></textarea>
                    </div>
                </div>

                <div class="form__group">
                    <label><?= GetMessage('NEW_PASSWORD_REQ') ?></label>
                    <div class="form__input">
                        <input type="password" name="NEW_PASSWORD" class="form-control" maxlength="50" value=""
                               autocomplete="off" class="bx-auth-input"/>
                        <? if($arResult["SECURE_AUTH"]): ?>
                            <span class="bx-auth-secure" id="bx_auth_secure"
                                  title="<? echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
							<div class="bx-auth-secure-icon"></div>
						</span>
                            <noscript>
							<span class="bx-auth-secure" title="<? echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
								<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
							</span>
                            </noscript>
                            <script type="text/javascript">
                                document.getElementById('bx_auth_secure').style.display = 'inline-block';
                            </script>
                        <? endif ?>
                    </div>
                </div>
                <div class="form__group">
                    <label><?= GetMessage('NEW_PASSWORD_CONFIRM') ?></label>
                    <div class="form__input">
                        <input type="password" name="NEW_PASSWORD_CONFIRM" class="form-control" maxlength="50" value=""
                               autocomplete="off"/>
                    </div>
                </div>


                <div class="form__group">
                    <label class="label--checkbox">
                        <input type="checkbox"
                               <?if($arResult['SET_SUBSCRIBE']) echo 'checked="checked"'?>
                               name="SET_SUBSCRIBE"
                               value="1">
                        Оповещать меня об акциях, скидках и новостях "Кольчуги"
                    </label>
                </div>
                <div class="form__group form__group--nolabel">
                    <div class="form__input">
                        <input type="submit" class="btn btn-primary" name="save"
                               value="<?= GetMessage("MAIN_SAVE") ?>">
                    </div>
                </div>
            </form>
        </div>
        <div class="profile--right">
            <?
            if($arResult["SOCSERV_ENABLED"]){
                $APPLICATION->IncludeComponent("bitrix:socserv.auth.split", "", array(
                    "SHOW_PROFILES" => "Y",
                    "ALLOW_DELETE" => "Y"
                ),
                    false
                );
            }
            ?>
        </div>
    <? } ?>
</div><!-- @end profile -->