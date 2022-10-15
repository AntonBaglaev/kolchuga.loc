<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if($_GET['formresult'] == 'addok')
{
	if (isset($arParams["SUCCESS_INC_JS"]) &&
			!empty($arParams["SUCCESS_INC_JS"]))
	{
			$arResult['FORM_NOTE'] .= "<script type='text/javascript'>".$arParams["SUCCESS_INC_JS"]."</script>";
	}
    echo json_encode(array('success' => $arResult['FORM_NOTE']));
    die();
} elseif($arResult['FORM_ERRORS']){
    echo json_encode(array('errors' => $arResult['FORM_ERRORS'], 'errors_text' => $arResult['FORM_ERRORS_TEXT']));
    die();
}
?>
<div id="modal-buyoneclick" class="mfp-modal mfp-hide">
    <div class="mfp-modal-header">
        Зарезервировать
    </div>
    <div class="mfp-modal-content js-modal-reserve">
        <?= $arResult['FORM_HEADER'] ?>
        <div class="form__horizontal">
            <? foreach($arResult['QUESTIONS'] as $code => $question):
                $field = reset($question['STRUCTURE']);
                if($field['FIELD_TYPE'] == 'hidden' || $code=="MANAGER_COMMENT" || $code=="AGREE" || $code=="AGE") continue; ?>
                <div class="form__group">
                    <label for="field_11"><?= $field['MESSAGE'] ?><?if($question['REQUIRED'] == 'Y'):?><span>*</span><?endif?></label>
                    <div class="form__input">
                        <?if($code !== 'STORE_LIST'):?>
                        <input id='<?=$code?>'
                               type="<?= $field['FIELD_TYPE'] ?>"
                               name="form_<?= $field['FIELD_TYPE'] ?>_<?= $field['ID'] ?>"
                               value=""
                               autocomplete="off"
                               maxlength="200"/>
                        <?else:?>
						
                            <select name="form_<?= $field['FIELD_TYPE'] ?>_<?= $field['ID'] ?>">
                                <?foreach($arResult['STORE_LIST'] as $idstore=> $store):?>
                                    <?if($store["AMOUNT"]>0 && $store["SHOW_IN_LIST_ID"]==298880):?>
                                        <option value="<?=$store['NAME']?>"><?=$store['NAME']?></option>
                                    <?endif;?>
                                <?endforeach;?>
								<?if($arResult['STORE_LIST'][631125]["AMOUNT"]>0  && $arResult['STORE_LIST'][116]["AMOUNT"]<1  && $arResult['STORE_LIST'][116]["SHOW_IN_LIST_ID"]==298880){
									?><option value="<?=$arResult['STORE_LIST'][116]['NAME']?>(<?=$arResult['STORE_LIST'][631125]['NAME']?>)"><?=$arResult['STORE_LIST'][116]['NAME']?>(<?=$arResult['STORE_LIST'][631125]['NAME']?>)</option><?
								}?>
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
            <div class="form__group form__group_preorder">
				<label class="label--checkbox">
                    <p class="form_preorder_agree"><input type="checkbox" name="form_text_53" value="18" >Я подтверждаю, что мне испольнилось 18 лет<span class="req">*</span></p>
                </label>
                <label class="label--checkbox">
                    <p class="form_preorder_agree"><input type="checkbox" name="form_text_29" value="1" checked="checked">
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