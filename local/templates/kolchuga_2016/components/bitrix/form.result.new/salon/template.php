<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if($_GET['formresult'] == 'addok'){
    echo json_encode(array('success' => $arResult['FORM_NOTE']));
    die();
} elseif($arResult['FORM_ERRORS']){
    echo json_encode(array('errors' => $arResult['FORM_ERRORS'], 'errors_text' => $arResult['FORM_ERRORS_TEXT']));
    die();
}
//echo "<pre>";print_r($arResult['QUESTIONS']);echo "</pre>";
?>
<div id="salon_form">
<?=$arResult["FORM_HEADER"]?>
<?$page = $APPLICATION->GetCurPage();
$urls = 'https://www.kolchuga.ru'.$page;?>
<input type="hidden" name="form_hidden_51" value="<?=$urls?>">
<input type="hidden" name="web_form_submit" value="Y">
<div class="form-group input-material">
					  <input type="text" class="form-control" id="name-field" name="form_text_47" required="" value="">
					  <label for="name-field">Имя</label>
				  </div>
				  <div class="form-group input-material">
					  <input type="text" class="form-control" id="number-field" name="form_text_48" required="" value="">
					  <label for="number-field">Телефон</label>
				  </div>
				  <div class="form-group input-material">
					  <input type="email" class="form-control" id="email-field" name="form_email_49" value="">
					  <label for="email-field">Email</label>
				  </div>
				  
				  <div class="form-group input-material">
					  <textarea class="form-control" id="textarea-field" rows="3" name="form_textarea_50" required="" value=""></textarea>
					  <label for="textarea-field">Ваше сообщение</label>
				  </div>
				  
				 <div class="form__group form__group--nolabel error"></div> 
					
				  <div class="text-center">
					  <button type="submit" class="btn btn-cta" id="submitbutton" name="web_form_submit">Отправить</button>
				  </div>
<?=$arResult["FORM_FOOTER"]?>
</div>