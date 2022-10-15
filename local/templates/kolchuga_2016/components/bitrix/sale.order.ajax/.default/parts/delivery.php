<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if ($arResult["DELIVERY"]):?>
    <input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?= $arResult["BUYER_STORE"] ?>"/>

    <? foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery):
        if ($delivery_id !== 0 && intval($delivery_id) <= 0):
            foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile):

                if (count($arDelivery["LOGOTIP"]) > 0):

                    $arFileTmp = CFile::ResizeImageGet(
                        $arDelivery["LOGOTIP"]["ID"],
                        array("width" => "95", "height" => "55"),
                        BX_RESIZE_IMAGE_PROPORTIONAL,
                        true
                    );

                    $deliveryImgURL = $arFileTmp["src"];
                else:
                    $deliveryImgURL = $templateFolder . "/images/logo-default-d.gif";
                endif;

                ?>
                <div class="form-group row">
                    <label class="col-lg-6 control-label">
                        <input type="radio"
                               name="<?= htmlspecialcharsbx($arProfile["FIELD_NAME"]) ?>"
                               value="<?= $delivery_id . ":" . $profile_id; ?>"
                            <?= $arProfile["CHECKED"] == "Y" ? "checked=\"checked\"" : ""; ?>
                        >
                        <span><?= htmlspecialcharsbx($arDelivery["TITLE"]) ?></span>
                    </label>
                </div>
            <?endforeach;
        else:

            if (count($arDelivery["LOGOTIP"]) > 0):

                $arFileTmp = CFile::ResizeImageGet(
                    $arDelivery["LOGOTIP"]["ID"],
                    array("width" => "95", "height" => "55"),
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                    true
                );

                $deliveryImgURL = $arFileTmp["src"];
            else:
                $deliveryImgURL = $templateFolder . "/images/logo-default-d.gif";
            endif;

            ?>

            <div class="form-group row">
                <label class="col-lg-12 control-label">

                    <input type="radio"
                           name="<?= htmlspecialcharsbx($arDelivery["FIELD_NAME"]) ?>"
                           value="<?= $delivery_id ?>"
                        <?= $arDelivery["CHECKED"] == "Y" ? "checked=\"checked\"" : ""; ?>>
                    <span><?= htmlspecialcharsbx($arDelivery["NAME"]) ?></span>

                </label>
            </div>

            <?
        endif;
    endforeach;
    ?>
<? endif;