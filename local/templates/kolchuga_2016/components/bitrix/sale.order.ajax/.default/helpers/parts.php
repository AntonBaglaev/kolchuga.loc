<div class="col-sm-6 col-md-4">
    <h4>Контактные данные</h4>
    <?if(!$USER->IsAuthorized()):?>
        <div class="form-group row">
            <label class="col-lg-6 control-label">
                <input type="radio" name="new_reg" class="js-new-reg js-new-reg-true" value="1" checked="checked">
                <span>Новый пользователь</span>
            </label>
            <label class="col-lg-6 control-label">
                <input type="radio" name="new_reg" class="js-new-reg" value="0">
                <span>Авторизация</span>
            </label>
        </div>
    <?endif?>
    <? include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/parts/person_type.php");
    include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/parts/props.php");
    ?>
</div>
<div class="col-sm-6 col-md-4">
    <h4>Доставка</h4>
    <? include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/parts/delivery.php"); ?>
    <?= PrintPropsForm($arResult["ORDER_PROP"]["DELIVERY"], $arParams["TEMPLATE_LOCATION"], $tmp_path); ?>
    <div class="form-group form-order-width">
        <div class="row">
            <div class="col-xs-6">Стоимость доставки</div>
            <div class="col-xs-6 text-right">
                <h5><b>
                    <?if($arResult['USER_VALS']['DELIVERY_ID'] == 'dil7pd:door' && $arResult['DELIVERY_PRICE'] == 0):?>
                        Расчет менеджером
                    <?else:?>
                        <?=showPrice($arResult['DELIVERY_PRICE_FORMATED'])?>
                    <?endif;?>
                </b></h5>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12 col-md-4">
    <h4>Оплата</h4>
    <div class="form-order-payment">
        <? include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/parts/paysystem.php");?>
    </div>
    <div class="row form-order-total">
        <?include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/parts/summary.php"); ?>
    </div>
</div>
