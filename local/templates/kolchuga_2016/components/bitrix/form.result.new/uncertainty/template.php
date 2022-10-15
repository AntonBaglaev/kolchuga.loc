<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if($_GET['formresult'] == 'addok'){
    echo json_encode(array('success' => $arResult['FORM_NOTE']));
    die();
} elseif($arResult['FORM_ERRORS']){
    echo json_encode(array('errors' => $arResult['FORM_ERRORS'], 'errors_text' => $arResult['FORM_ERRORS_TEXT']));
    die();
}
?>
<div id="modal-sizeuncertainty" class="mfp-modal mfp-hide">
    <div class="mfp-modal-header">Не уверены в размере?</div>
    <div class="mfp-modal-content js-modal-reserve">
        <?= $arResult['FORM_HEADER'] ?>
        <div class="form__horizontal">
            <? foreach($arResult['QUESTIONS'] as $code => $question):
                $field = reset($question['STRUCTURE']);
                if($field['FIELD_TYPE'] == 'hidden' || $code=="MANAGER_COMMENT") continue; ?>
                <div class="form__group">
                    <label for="field_11"><?= $field['MESSAGE'] ?><?if($question['REQUIRED'] == 'Y'):?><span>*</span><?endif?></label>
                    <div class="form__input">
                        <?if($code !== 'STORE_LIST'):?>
                            <? if($field['FIELD_TYPE'] == 'textarea'): ?>
                                <textarea name="form_<?= $field['FIELD_TYPE'] ?>_<?= $field['ID'] ?>"></textarea>
                            <? else: ?>
                                <input id='<?=$code?>_<?= $field['ID'] ?>'
                                   type="<?= $field['FIELD_TYPE'] ?>"
                                   name="form_<?= $field['FIELD_TYPE'] ?>_<?= $field['ID'] ?>"
                                   value=""
                                   autocomplete="off"
                                   maxlength="200"/>
                            <? endif ?>
                        <?else:?>
                            <select name="form_<?= $field['FIELD_TYPE'] ?>_<?= $field['ID'] ?>">
                                <?foreach($arResult['STORE_LIST'] as $store):?>
                                    <?if($store["AMOUNT"]>0):?>
                                        <option value="<?=$store['NAME']?>"><?=$store['NAME']?></option>
                                    <?endif;?>
                                <?endforeach;?>
                            </select>
                        <?endif?>
                    </div>
                </div>
            <? endforeach;
            foreach($arResult['QUESTIONS'] as $code => $question):
                $field = reset($question['STRUCTURE']);
                if($field['FIELD_TYPE'] !== 'hidden' ) continue; ?>
                <input type="hidden" name="form_hidden_<?= $field['ID'] ?>" data-code="<?= $code ?>" value="">
            <? endforeach; ?>
            <div class="form__group form__group--nolabel error"></div>
            <div class="form__group form__group--nolabel">
                <div class="form__input text-center">
                    <input type="submit" class="btn btn-primary" name="web_form_submit" value="Отправить">
                </div>
            </div>
        </div>
        <?= $arResult['FORM_FOOTER'] ?>
    </div>
</div>