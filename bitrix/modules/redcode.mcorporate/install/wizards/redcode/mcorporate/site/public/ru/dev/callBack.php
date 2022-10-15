<?php
define("NO_KEEP_STATISTIC", true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(SITE_CHARSET == "windows-1251")
	$_REQUEST["userName"] = mb_convert_encoding($_REQUEST["userName"], "windows-1251", "utf-8");

$arEventFields = array( 
	"AUTHOR_NAME" => $_REQUEST["userName"],
	"AUTHOR_PHONE" => $_REQUEST["userPhone"],
	"AUTHOR_EMAIL" => $_REQUEST["userEmail"],
	"URL_IMG" => $_REQUEST["urlImg"],
	"EMAIL_TO" => $_REQUEST["emailTo"],
);

\Bitrix\Main\Mail\Event::send(
	array(
		"EVENT_NAME" => "REDCODE_CALLBACK",
		"DUPLICATE" => "N",
		"LID" => "#LID#",
		"MESSAGE_ID" => $_REQUEST["eventMessageId"],
		"C_FIELDS" => $arEventFields,
	)
);