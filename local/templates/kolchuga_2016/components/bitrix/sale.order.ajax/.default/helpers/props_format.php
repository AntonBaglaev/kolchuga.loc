<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if (!function_exists("PrintPropsForm")) {
    function PrintPropsForm($arSource = array(), $locationTemplate = ".default", $template_path)
    {
        global $USER;

        if (!empty($arSource)) {
            ?>
            <?
            $loc_counter = 0;
            foreach ($arSource as $arProperties) {
                if ($arProperties['CODE'] !== '1С_CODE') {
                    ?>

                    <div class="form-group form-order-width">
                        <label class="control-label" for="">
                            <div class="control-label-inner">
                                    <span>
                                        <?= $arProperties["NAME"] ?>
                                        <? if ($arProperties["REQUIED"] == "Y"): ?>
                                            <span class="req">*</span>
                                        <?endif ?>
                                    </span>
                            </div>
                        </label>
                    <?
                }
                if ($arProperties["TYPE"] == "CHECKBOX") {
                    ?>
                <input type="hidden" name="<?= $arProperties["FIELD_NAME"] ?>" value="">

                    <div class="bx_block r1x3 pt8">
                        <?= $arProperties["NAME"] ?>
                        <? if ($arProperties["REQUIED_FORMATED"] == "Y"): ?>
                            <span class="bx_sof_req">*</span>
                        <?endif; ?>
                    </div>

                    <div class="bx_block r1x3 pt8">
                        <input type="checkbox" name="<?= $arProperties["FIELD_NAME"] ?>"
                               id="<?= $arProperties["FIELD_NAME"] ?>"
                               value="Y"<? if ($arProperties["CHECKED"] == "Y") echo " checked"; ?>>

                        <?
                        if (strlen(trim($arProperties["DESCRIPTION"])) > 0):
                            ?>
                            <div class="bx_description">
                                <?= $arProperties["DESCRIPTION"] ?>
                            </div>
                            <?
                        endif;
                        ?>
                    </div>

                    <div style="clear: both;"></div>
                <?
                }
                elseif ($arProperties["TYPE"] == "TEXT")
                {
                ?>

                <input class="form-control" size="<?= $arProperties["SIZE1"] ?>"
                       value="<?= $arProperties["VALUE"] ?>"
                       name="<?= $arProperties["FIELD_NAME"] ?>"
                       id="<?= $arProperties["FIELD_NAME"] ?>"
                    <? if ($arProperties['REQUIRED'] == 'Y') echo 'required'; ?>>

                <?
                }
                elseif ($arProperties["TYPE"] == "SELECT")
                {
                ?>
                    <div class="col-xxs-24 col-xs-17">
                        <select name="<?= $arProperties["FIELD_NAME"] ?>" id="<?= $arProperties["FIELD_NAME"] ?>"
                                size="<?= $arProperties["SIZE1"] ?>">
                            <?
                            foreach ($arProperties["VARIANTS"] as $arVariants):
                                ?>
                                <option
                                    value="<?= $arVariants["VALUE"] ?>"<? if ($arVariants["SELECTED"] == "Y") echo " selected"; ?>><?= $arVariants["NAME"] ?></option>
                                <?
                            endforeach;
                            ?>
                        </select>
                    </div>
                <?
                }
                elseif ($arProperties["TYPE"] == "TEXTAREA")
                {
                $rows = ($arProperties["SIZE2"] > 10) ? 4 : $arProperties["SIZE2"];
                ?>
                    <textarea rows="<?= $rows ?>"
                              cols="<?= $arProperties["SIZE1"] ?>"
                              name="<?= $arProperties["FIELD_NAME"] ?>"
                              id="<?= $arProperties["FIELD_NAME"] ?>"
                              class="form-control"
                        <? if ($arProperties['REQUIRED'] == 'Y') echo 'required'; ?>
                    ><?= $arProperties["VALUE"] ?></textarea>
                <?
                }
                elseif ($arProperties["TYPE"] == "LOCATION")
                {
                $loc_counter++;

                $arProperties['VALUE'] =
                    $arProperties['VALUE'] && $arProperties['VALUE'] !== ', ' ? $arProperties['VALUE'] : $arProperties['DEFAULT_VALUE'];

                $arLocs = CSaleLocation::GetByID($arProperties['VALUE'], LANGUAGE_ID);
                $loc_name = $arLocs["CITY_NAME"] . ", " . $arLocs["REGION_NAME"];


                ?>

                        <input type="hidden"
                               name="<?= $arProperties["FIELD_NAME"] ?>"
                               value="<?= $arProperties["VALUE"] ?>">
                        <input class="form-control" size="<?= $arProperties["SIZE1"] ?>"
                               value="<?= $loc_name ?>"
                               id="<?= $arProperties["FIELD_NAME"] ?>"
                               autocomplete="off"
                            <? if ($arProperties['REQUIRED'] == 'Y') echo 'required="required"'; ?>>

                    <script>
                        $('#<?=$arProperties["FIELD_NAME"]?>').devbridgeAutocomplete({
                            serviceUrl: '<?=$template_path . '/helpers/ajax_location.php'?>',
                            onSelect: function (suggestion) {
                                $(this).prev().val(suggestion.data.id);
                                $(this).parents('form').trigger('paramsChange');
                            }
                        });
                    </script>

                    <?
                }
                ?>
                </div>

                <?
            }
            ?>

            <?
        }
    }
}
?>