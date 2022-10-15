<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if($_GET['formresult'] == 'addok'){
    echo json_encode(array('success' => $arResult['FORM_NOTE']));
    die();
} elseif($arResult['FORM_ERRORS']){
    echo json_encode(array('errors' => $arResult['FORM_ERRORS'], 'errors_text' => $arResult['FORM_ERRORS_TEXT']));
    die();
}
?>

<style>
    #modal-consultant {
        position: fixed;
        bottom: 20px;
/*        display: block!important;*/
        z-index: 100;
        border: 1px #cecece solid;
        right: 20px;
        width: 300px;
    }
</style>
<div id="modal-consultant" class="mfp-modal mfp-hide">
    <div class="mfp-modal-header">
        Задать вопрос
    </div>
    <div class="mfp-modal-content js-modal-reserve">
        <?= $arResult['FORM_HEADER'] ?>
        <div class="form__horizontal">
            <? foreach($arResult['QUESTIONS'] as $code => $question):

                $field = reset($question['STRUCTURE']);
                if($field['FIELD_TYPE'] == 'hidden') continue;
                if($code == 'MANAGER_COMMENT') continue;
                if($field["ID"]==15){

            ?>
                    <div class="form__group">
                        <label for="field_11"><?=$question["CAPTION"]?><?if($question['REQUIRED'] == 'Y'):?><span>*</span><?endif?></label>
                        <div class="form__input">
                        <input id='<?=$code?>'
                               class="custom-file-input"
                               type="<?= $field['FIELD_TYPE'] ?>"
                               name="form_<?= $field['FIELD_TYPE'] ?>_<?= $field['ID'] ?>"
                               value=""
                               autocomplete="off"
                               maxlength="200"/>
                        </div>
                    </div>
                <?}else{
                ?>
                <div class="form__group">
                    <label for="field_11"><?= $field['MESSAGE'] ?><?if($question['REQUIRED'] == 'Y'):?><span>*</span><?endif?></label>
                    <div class="form__input">
                        <?if($field['FIELD_TYPE'] == 'textarea'):?>
                            <textarea id='<?=$code?>'
                                   name="form_<?= $field['FIELD_TYPE'] ?>_<?= $field['ID'] ?>"
                                   autocomplete="off"
                                   ></textarea>
                        <?else:?>
                            <input id='<?=$code?>'
                                   type="<?= $field['FIELD_TYPE'] ?>"
                                   name="form_<?= $field['FIELD_TYPE'] ?>_<?= $field['ID'] ?>"
                                   value=""
                                   autocomplete="off"
                                   maxlength="200"/>
                        <?endif?>
                    </div>
                </div>
                <?}?>
            <? endforeach;
            foreach($arResult['QUESTIONS'] as $code => $question):
                $field = reset($question['STRUCTURE']);
                if($field['FIELD_TYPE'] !== 'hidden') continue; ?>
                <input type="hidden" name="form_hidden_<?= $field['ID'] ?>" data-code="<?= $code ?>" value="">
            <? endforeach; ?>
            <input type="hidden" name="web_form_submit" value="Y">
            <div class="form__group form__group--nolabel error"></div>
            <div class="form__group form__group--nolabel">
                <div class="form__input text-center">
                    <input type="submit" class="btn btn-primary" name="web_form_submit" value="Отправить">
                </div>
            </div>
        </div>
        <?= $arResult['FORM_FOOTER'] ?>
    </div>
    <button title="Закрыть" class="mfp-close close-consultant"><span class="icon-close"></span></button>
</div>