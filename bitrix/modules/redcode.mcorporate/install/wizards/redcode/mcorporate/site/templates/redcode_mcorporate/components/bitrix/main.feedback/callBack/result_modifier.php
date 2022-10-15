<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!empty($arParams["FORM_TITLE"]))
	$arParams["FORM_TITLE"] = strip_tags($arParams["FORM_TITLE"]);
else
	$arParams["FORM_TITLE"] = GetMessage("COMPONENT_FORM_TITLE_DEFAULT");

if(!empty($arParams["FORM_NAME_SUBMIT"]))
	$arParams["FORM_NAME_SUBMIT"] = strip_tags($arParams["FORM_NAME_SUBMIT"]);
else
	$arParams["FORM_NAME_SUBMIT"] = GetMessage("COMPONENT_FORM_NAME_SUBMIT_DEFAULT");
	

$defaultCallBack = array(
	"NAME" => "
		<div>
			<input type='text' class='inputField' name='userName' ".(in_array("NAME", $arParams["REQUIRED_FIELDS"]) ? 'required=required' : '')." />
			<label class='inputLabel'>".GetMessage("COMPONENT_FEEDBACK_NAME")."</label>
		</div>
	",
	"SURNAME" => "
		<div>
			<input type='text' class='inputField' name='userSurname' ".(in_array("SURNAME", $arParams["REQUIRED_FIELDS"]) ? 'required=required' : '')." />
			<label class='inputLabel'>".GetMessage("COMPONENT_FEEDBACK_SURNAME")."</label>
		</div>
	",
	"PATRONYMIC" => "
		<div>
			<input type='text' class='inputField' name='userPatronymic' ".(in_array("PATRONYMIC", $arParams["REQUIRED_FIELDS"]) ? 'required=required' : '')." />
			<label class='inputLabel'>".GetMessage("COMPONENT_FEEDBACK_PATRONYMIC")."</label>
		</div>
	",
	"PHONE" => "
		<div>
			<input type='tel' class='inputField' name='userPhone' ".(in_array("PHONE", $arParams["REQUIRED_FIELDS"]) ? 'required=required' : '')." />
			<label class='inputLabel'>".GetMessage("COMPONENT_FEEDBACK_PHONE")."</label>
		</div>
	",
	"SUBJECT" => "
		<div>
			<input type='text' class='inputField' name='userSubject' ".(in_array("SUBJECT", $arParams["REQUIRED_FIELDS"]) ? 'required=required' : '')." />
			<label class='inputLabel'>".GetMessage("COMPONENT_FEEDBACK_SUBJECT")."</label>
		</div>
	",
	"FILE" => "
		<div class='fileForm'>
			<label class='inputLabel'>".GetMessage("COMPONENT_FEEDBACK_FILE")."</label>
			<input type='file' class='inputField' name='userFile' ".(in_array("FILE", $arParams["REQUIRED_FIELDS"]) ? 'required=required' : '')." />
			<span></span>
		</div>
	",
	"EMAIL" => "
		<div>
			<input type='email' class='inputField' name='userEmail' ".(in_array("EMAIL", $arParams["REQUIRED_FIELDS"]) ? 'required=required' : '')." />
			<label class='inputLabel'>".GetMessage("COMPONENT_FEEDBACK_EMAIL")."</label>
		</div>
	",
	"MESSAGE" => "
		<div>
			<div class='messageField' contenteditable='true' name='userMessage'></div>
			<label class='inputLabel'>".GetMessage("COMPONENT_FEEDBACK_MESSAGE")."</label>
		</div>
	",
);

foreach($arParams["ELEMENT_FORM"] as $key => $element)
{
	$arResult["ELEMENT"][$key][] = $defaultCallBack[$element];
	$arResult["ELEMENT"][$key]["NAME"] = $element;
}