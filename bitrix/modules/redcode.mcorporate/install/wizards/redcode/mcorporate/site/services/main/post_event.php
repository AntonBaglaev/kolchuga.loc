<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

IncludeModuleLangFile(__FILE__);


/* START POST TEMPLATE (1 форма) */
$rsET = CEventType::GetByID("REDCODE_MC_CALLBACK", "ru");
if(!$arET = $rsET->Fetch())
{
	/* Создание почтового события */
	$et = new CEventType;
	$et->Add(array(
		"LID" => "ru",
		"EVENT_NAME" => "REDCODE_MC_CALLBACK",
		"NAME" => GetMessage("REDCODE_CALLBACK_TYPE_NAME"),
		"DESCRIPTION" => GetMessage("REDCODE_CALLBACK_TYPE_DESCRIPTION")
	));
}

$rsMess = CEventMessage::GetList($by = "site_id", $order = "desc", array("EVENT_NAME" => "REDCODE_MC_CALLBACK", "LID" => WIZARD_SITE_ID));
if(!$GetPostTemplateEseySite = $rsMess->Fetch())
{
	/* Создание почтового шаблона */
	$message = new CEventMessage;
	$REDCODE_CALLBACK_ID = $message->Add(array(
		"ACTIVE" => "Y",
		"EVENT_NAME" => "REDCODE_MC_CALLBACK",
		"LID" => WIZARD_SITE_ID,
		"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
		"EMAIL_TO" => "#EMAIL_TO#",
		"SUBJECT" => GetMessage("REDCODE_CALLBACK_SUBJECT"),
		"BODY_TYPE" => "html",
		"MESSAGE" => GetMessage("REDCODE_CALLBACK_MESSAGE")
	));
}
else
{
	$REDCODE_CALLBACK_ID = $GetPostTemplateEseySite["ID"];

	/* Обновление почтового шаблона */
	$message = new CEventMessage;
	$updateMessage = array(
		"LID"		=> WIZARD_SITE_ID,
		"SUBJECT"	=> GetMessage("REDCODE_CALLBACK_SUBJECT"),
		"MESSAGE"	=> GetMessage("REDCODE_CALLBACK_MESSAGE"),
	);
	$message->Update($GetPostTemplateEseySite["ID"], $updateMessage);
}
/* END POST TEMPLATE */


/* START POST TEMPLATE (2 форма) */
$rsET = CEventType::GetByID("REDCODE_MC_QUESTION", "ru");
if(!$arET = $rsET->Fetch())
{
	/* Создание почтового события */
	$et = new CEventType;
	$et->Add(array(
		"LID" => "ru",
		"EVENT_NAME" => "REDCODE_MC_QUESTION",
		"NAME" => GetMessage("REDCODE_QUESTION_TYPE_NAME"),
		"DESCRIPTION" => GetMessage("REDCODE_QUESTION_TYPE_DESCRIPTION")
	));
}

$arFilter = Array(
	"EVENT_NAME" => "REDCODE_MC_QUESTION",
	"LID" => WIZARD_SITE_ID,
	"SUBJECT" => "Вопрос об услуге от пользователя | #SITE_NAME#",
);
$rsMess = CEventMessage::GetList($by = "site_id", $order = "desc", $arFilter);

if(!$GetPostTemplateEseySite = $rsMess->Fetch())
{
	/* Создание почтового шаблона */
	$message = new CEventMessage;
	$REDCODE_QUESTION_ID = $message->Add(array(
		"ACTIVE" => "Y",
		"EVENT_NAME" => "REDCODE_MC_QUESTION",
		"LID" => WIZARD_SITE_ID,
		"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
		"EMAIL_TO" => "#EMAIL_TO#",
		"SUBJECT" => GetMessage("REDCODE_QUESTION_SUBJECT"),
		"BODY_TYPE" => "html",
		"MESSAGE" => GetMessage("REDCODE_QUESTION_MESSAGE")
	));
}
else
{
	$REDCODE_QUESTION_ID = $GetPostTemplateEseySite["ID"];

	/* Обновление почтового шаблона */
	$message = new CEventMessage;
	$updateMessage = array(
		"LID"		=> WIZARD_SITE_ID,
		"SUBJECT"	=> GetMessage("REDCODE_QUESTION_SUBJECT"),
		"MESSAGE"	=> GetMessage("REDCODE_QUESTION_MESSAGE"),
	);
	$message->Update($GetPostTemplateEseySite["ID"], $updateMessage);
}
/* END POST TEMPLATE */


/* START POST TEMPLATE (3 форма) */
$rsET = CEventType::GetByID("REDCODE_MC_SUMMARY", "ru");
if(!$arET = $rsET->Fetch())
{
	/* Создание почтового события */
	$et = new CEventType;
	$et->Add(array(
		"LID" => "ru",
		"EVENT_NAME" => "REDCODE_MC_SUMMARY",
		"NAME" => GetMessage("REDCODE_SUMMARY_TYPE_NAME"),
		"DESCRIPTION" => GetMessage("REDCODE_SUMMARY_TYPE_DESCRIPTION")
	));
}

$rsMess = CEventMessage::GetList($by = "site_id", $order = "desc", array("EVENT_NAME" => "REDCODE_MC_SUMMARY", "LID" => WIZARD_SITE_ID));
if(!$GetPostTemplateEseySite = $rsMess->Fetch())
{
	/* Создание почтового шаблона */
	$message = new CEventMessage;
	$REDCODE_SUMMARY_ID = $message->Add(array(
		"ACTIVE" => "Y",
		"EVENT_NAME" => "REDCODE_MC_SUMMARY",
		"LID" => WIZARD_SITE_ID,
		"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
		"EMAIL_TO" => "#EMAIL_TO#",
		"SUBJECT" => GetMessage("REDCODE_SUMMARY_SUBJECT"),
		"BODY_TYPE" => "html",
		"MESSAGE" => GetMessage("REDCODE_SUMMARY_MESSAGE")
	));
}
else
{
	$REDCODE_SUMMARY_ID = $GetPostTemplateEseySite["ID"];

	/* Обновление почтового шаблона */
	$message = new CEventMessage;
	$updateMessage = array(
		"LID"		=> WIZARD_SITE_ID,
		"SUBJECT"	=> GetMessage("REDCODE_SUMMARY_SUBJECT"),
		"MESSAGE"	=> GetMessage("REDCODE_SUMMARY_MESSAGE"),
	);
	$message->Update($GetPostTemplateEseySite["ID"], $updateMessage);
}
/* END POST TEMPLATE */


/* START POST TEMPLATE (4 форма) */
$rsET = CEventType::GetByID("REDCODE_MC_WRITE_US", "ru");
if(!$arET = $rsET->Fetch()){
	/* Создание почтового события */
	$et = new CEventType;
	$et->Add(array(
		"LID" => "ru",
		"EVENT_NAME" => "REDCODE_MC_WRITE_US",
		"NAME" => GetMessage("REDCODE_WRITE_US_TYPE_NAME"),
		"DESCRIPTION" => GetMessage("REDCODE_WRITE_US_TYPE_DESCRIPTION")
	));
}

$rsMess = CEventMessage::GetList($by = "site_id", $order = "desc", array("EVENT_NAME" => "REDCODE_MC_WRITE_US", "LID" => WIZARD_SITE_ID));
if(!$GetPostTemplateEseySite = $rsMess->Fetch())
{
	/* Создание почтового шаблона */
	$message = new CEventMessage;
	$REDCODE_WRITE_US_ID = $message->Add(array(
		"ACTIVE" => "Y",
		"EVENT_NAME" => "REDCODE_MC_WRITE_US",
		"LID" => WIZARD_SITE_ID,
		"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
		"EMAIL_TO" => "#EMAIL_TO#",
		"SUBJECT" => GetMessage("REDCODE_WRITE_US_SUBJECT"),
		"BODY_TYPE" => "html",
		"MESSAGE" => GetMessage("REDCODE_WRITE_US_MESSAGE")
	));
}
else
{
	$REDCODE_WRITE_US_ID = $GetPostTemplateEseySite["ID"];

	/* Обновление почтового шаблона */
	$message = new CEventMessage;
	$updateMessage = array(
		"LID"		=> WIZARD_SITE_ID,
		"SUBJECT"	=> GetMessage("REDCODE_WRITE_US_SUBJECT"),
		"MESSAGE"	=> GetMessage("REDCODE_WRITE_US_MESSAGE"),
	);
	$message->Update($GetPostTemplateEseySite["ID"], $updateMessage);
}
/* END POST TEMPLATE */


/* START POST TEMPLATE (5 форма) */
$arFilter = Array(
	"EVENT_NAME" => "REDCODE_MC_QUESTION",
	"LID" => WIZARD_SITE_ID,
	"SUBJECT" => "Новый заказ | #SITE_NAME#",
);
$rsMess = CEventMessage::GetList($by = "site_id", $order = "desc", $arFilter);
if(!$GetPostTemplateEseySite = $rsMess->Fetch())
{
	/* Создание почтового шаблона */
	$message = new CEventMessage;
	$REDCODE_NEW_ORDERS_ID = $message->Add(array(
		"ACTIVE" => "Y",
		"EVENT_NAME" => "REDCODE_MC_QUESTION",
		"LID" => WIZARD_SITE_ID,
		"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
		"EMAIL_TO" => "#EMAIL_TO#",
		"SUBJECT" => GetMessage("REDCODE_NEW_ORDERS_SUBJECT"),
		"BODY_TYPE" => "html",
		"MESSAGE" => GetMessage("REDCODE_NEW_ORDERS_MESSAGE")
	));
}
else
{
	$REDCODE_NEW_ORDERS_ID = $GetPostTemplateEseySite["ID"];

	/* Обновление почтового шаблона */
	$message = new CEventMessage;
	$updateMessage = array(
		"LID"     => WIZARD_SITE_ID,
		"SUBJECT" => GetMessage("REDCODE_NEW_ORDERS_SUBJECT"),
		"MESSAGE" => GetMessage("REDCODE_NEW_ORDERS_MESSAGE"),
	);
	$message->Update($GetPostTemplateEseySite["ID"], $updateMessage);
}
/* END POST TEMPLATE */


$siteEmail = $wizard->GetVar("siteEmail");

CWizardUtil::ReplaceMacros(
	WIZARD_SITE_PATH."/_index.php",
	array(
		"REDCODE_WRITE_US_ID" => $REDCODE_WRITE_US_ID,
		"EMAIL" => $siteEmail
	)
);
CWizardUtil::ReplaceMacros(
	WIZARD_SITE_PATH."/contacts/index.php",
	array(
		"REDCODE_WRITE_US_ID" => $REDCODE_WRITE_US_ID,
		"EMAIL" => $siteEmail
	)
);
CWizardUtil::ReplaceMacros(
	WIZARD_SITE_PATH."/company/vacancies/index.php",
	array(
		"REDCODE_SUMMARY_ID" => $REDCODE_SUMMARY_ID,
		"EMAIL" => $siteEmail
	)
);

CWizardUtil::ReplaceMacros(
	$_SERVER["DOCUMENT_ROOT"]."/local/templates/".WIZARD_TEMPLATE_ID."/components/bitrix/news/services/detail.php",
	array(
		"REDCODE_QUESTION_ID" => $REDCODE_QUESTION_ID,
		"EMAIL" => $siteEmail,
		"FORM_NAME_SUBMIT" => GetMessage("FORM_NAME_SUBMIT"),
		"FORM_TITLE_QUESTION" => GetMessage("FORM_TITLE_QUESTION"),
	)
);

CWizardUtil::ReplaceMacros(
	$_SERVER["DOCUMENT_ROOT"]."/local/templates/".WIZARD_TEMPLATE_ID."/components/bitrix/news/projects/detail.php",
	array(
		"REDCODE_NEW_ORDERS_ID" => $REDCODE_NEW_ORDERS_ID,
		"REDCODE_QUESTION_ID" => $REDCODE_QUESTION_ID,
		"EMAIL" => $siteEmail,
		"FORM_TITLE_QUESTION" => GetMessage("FORM_TITLE_QUESTION"),
		"FORM_TITLE_PROJECTS" => GetMessage("FORM_TITLE_PROJECTS"),
		"FORM_NAME_SUBMIT" => GetMessage("FORM_NAME_SUBMIT")
	)
);

CWizardUtil::ReplaceMacros(
	$_SERVER["DOCUMENT_ROOT"]."/local/templates/".WIZARD_TEMPLATE_ID."/footer.php",
	array(
		"REDCODE_CALLBACK_ID" => $REDCODE_CALLBACK_ID,
		"EMAIL" => $siteEmail,
		"FORM_TITLE" => GetMessage("FORM_TITLE_CALLBACK"),
		"FORM_NAME_SUBMIT" => GetMessage("FORM_NAME_SUBMIT")
	)
);