<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if($_GET['formresult'] == 'addok'){
    echo json_encode(array('success' => $arResult['FORM_NOTE']));
    die();
} elseif($arResult['FORM_ERRORS']){
    echo json_encode(array('errors' => $arResult['FORM_ERRORS'], 'errors_text' => $arResult['FORM_ERRORS_TEXT']));
    die();
}
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($arResult);echo "</pre>";
?>
<div id="modal-psert" class="mfp-modal mfp-hide">
    <div class="mfp-modal-header">
        Зарезервировать
    </div>
    <div class="mfp-modal-content ">
        <?= $arResult['FORM_HEADER'] ?>
        <div class="form__horizontal">
            <? foreach($arResult['QUESTIONS'] as $code => $question):
                $field = reset($question['STRUCTURE']);
                if($field['FIELD_TYPE'] == 'hidden') continue; ?>
                <div class="form__group">
                    <label for="field_<?= $field['ID'] ?>"><?= $question['CAPTION'] ?><?if($question['REQUIRED'] == 'Y'):?><span>*</span><?endif?></label>
                    <div class="form__input">
					<?if($field['FIELD_TYPE'] == 'textarea'){?>
                            <textarea id='<?=$code?>'
                                   name="form_<?= $field['FIELD_TYPE'] ?>_<?= $field['ID'] ?>"
                                   autocomplete="off"
                                   ></textarea>
					<?}else{?>
                        <input id='<?=$code?>'
                               type="<?= $field['FIELD_TYPE'] ?>"
                               name="form_<?= $field['FIELD_TYPE'] ?>_<?= $field['ID'] ?>"
                               value=""
                               autocomplete="off"
                               maxlength="200"/>
					<?}?>  
                    </div>
                </div>
            <? endforeach;
            foreach($arResult['QUESTIONS'] as $code => $question):
                $field = reset($question['STRUCTURE']);
                if($field['FIELD_TYPE'] !== 'hidden' ) continue; ?>
                <input type="hidden" name="form_hidden_<?= $field['ID'] ?>" data-code="<?= $code ?>" value="">
            <? endforeach; ?>
			<input type="hidden" name="web_form_submit" value="Y">
            <div class="form__group form__group_preorder">
                <label class="label--checkbox">
                    <p class="form_preorder_agree"><input type="checkbox" name="form_text_46" value="1" checked="checked">
                                        Подтверждаю согласие на обработку <a href="/information/politika-konfidentsialnosti.php">персональных данных</a>
                                        <span class="req">*</span></p>
                </label>
            </div>
            <div class="form__group form__group--nolabel error"></div>
            <div class="form__group form__group--nolabel">
                <div class="form__input text-center">
                    <input type="submit" class="btn btn-primary" name="web_form_submit" value="Зарезервировать">
                </div>
            </div>
        </div>
        <?= $arResult['FORM_FOOTER'] ?>
    </div>
</div>