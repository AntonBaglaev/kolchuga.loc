<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

$site = ($_REQUEST["site"] <> "" ? $_REQUEST["site"] : ($_REQUEST["src_site"] <> "" ? $_REQUEST["src_site"] : false));
$arFilter = array("ACTIVE" => "Y");
if($site !== false)
	$arFilter["LID"] = $site;

$dbType = CEventMessage::GetList($by = "ID", $order = "DESC", $arFilter);
while($arType = $dbType->GetNext())
	$arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];

$elementForm = array(
	"NAME" => GetMessage("PARAMETERS_FEEDBACK_NAME"),
	"SURNAME" => GetMessage("PARAMETERS_FEEDBACK_SURNAME"),
	"PATRONYMIC" => GetMessage("PARAMETERS_FEEDBACK_PATRONYMIC"),
	"SUBJECT" => GetMessage("PARAMETERS_FEEDBACK_SUBJECT"),
	"PHONE" => GetMessage("PARAMETERS_FEEDBACK_PHONE"),
	"FILE" => GetMessage("PARAMETERS_FEEDBACK_FILE"),
	"EMAIL" => GetMessage("PARAMETERS_FEEDBACK_EMAIL"),
	"MESSAGE" => GetMessage("PARAMETERS_FEEDBACK_MESSAGE"),
);

$requiredFields = array_merge(array("NONE" => GetMessage("PARAMETERS_FEEDBACK_OPTIONAL")), $elementForm);
unset($requiredFields["MESSAGE"]);

$arTemplateParameters = array(
	"FORM_TITLE" => array(
		"NAME" => GetMessage("PARAMETERS_FORM_TITLE"), 
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("PARAMETERS_FORM_TITLE_DEFAULT"),
		"PARENT" => "BASE",
	),
	"FORM_NAME_SUBMIT" => array(
		"NAME" => GetMessage("PARAMETERS_FORM_NAME_SUBMIT"), 
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("PARAMETERS_FORM_NAME_SUBMIT_DEFAULT"),
		"PARENT" => "BASE",
	),
	"EVENT_MESSAGE_ID" => array(
		"NAME" => GetMessage("MFP_EMAIL_TEMPLATES"),
		"TYPE" => "LIST",
		"VALUES" => $arEvent,
		"DEFAULT" => "",
		"MULTIPLE" => "N",
		"COLS" => 25,
		"PARENT" => "BASE",
	),
	"ELEMENT_FORM" => array(
		"NAME" => GetMessage("PARAMETERS_FEEDBACK_ELEMENT_FORM"),
		"TYPE" => "LIST",
		"VALUES" => $elementForm,
		"DEFAULT" => "",
		"MULTIPLE" => "Y",
		"COLS" => 25,
		"PARENT" => "BASE",
	),
	"REQUIRED_FIELDS" => array(
		"NAME" => GetMessage("MFP_REQUIRED_FIELDS"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $requiredFields,
		"DEFAULT" => "",
		"COLS" => 25,
		"PARENT" => "BASE",
	),
	"USE_CAPTCHA" => array(
		"HIDDEN" => "Y",
	),
	"OK_TEXT" => array(
		"HIDDEN" => "Y",
	),
);