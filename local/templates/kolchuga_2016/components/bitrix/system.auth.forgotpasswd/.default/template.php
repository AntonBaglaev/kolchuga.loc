<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $APPLICATION->SetTitle('Восстановление пароля');?>
<h1 class="js-page-title"><?= $APPLICATION->ShowTitle() ?></h1>
<div class="forgot__password">
    <div class="text-center info__block">Для восстановления пароля учетной записи, введите адрес электронной почты, указанный вами при регистрации на сайте и нажмите на кнопку «Восстановить пароль»</div>
    <?if($arParams["~AUTH_RESULT"]):?>
    <?
        $arParams["~AUTH_RESULT"] = str_replace('EMail', 'E-Mail', $arParams["~AUTH_RESULT"]);
        if ($arParams["~AUTH_RESULT"]['TYPE'] == "ERROR") {?>
            <div class="info__block">
                <div class="alert alert-danger">Логин или E-Mail не найдены.<br> <a href="/register/">  Зарегистрироваться</a></div>
            </div>
        <? } elseif ($arParams['~AUTH_RESULT']['TYPE']=="OK") { ?>
            <div class="info__block">
                <div class="alert alert-success">Мы отправили регистрационные данные на ваш электронный адрес. Проверьте вашу почту и перейдите по ссылке, указанной в письме, для смены пароля!</div>
            </div>
        <? } else { ?>
        <?= ShowMessage($arParams["~AUTH_RESULT"]); ?>
            
        <? } ?>
    <?endif;?>
    <form action="" method="post" target="_top" class="form__horizontal form__forgot">
        <? if(strlen($arResult["BACKURL"]) > 0){ ?>
            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
        <? } ?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="SEND_PWD">
        <div class="form__group">
            <label for="field_1">E-mail</label>
            <div class="form__input">
                <input type="text" name="USER_EMAIL" maxlength="255" value=""/>
            </div>
        </div>
        <div class="form__group form__group--nolabel">
            <div class="form__input">
                <input type="submit" name="send_account_info" class="btn btn-primary" value="Восстановить пароль">
            </div>
            <div style="text-align: center"><a href="<?= $arResult["AUTH_AUTH_URL"] ?>"><b><?= GetMessage("AUTH_AUTH") ?></b></a></div>
        </div>
    </form>

</div>