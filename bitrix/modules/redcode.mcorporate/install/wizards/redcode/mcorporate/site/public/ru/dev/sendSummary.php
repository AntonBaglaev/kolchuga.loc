<?php
define("NO_KEEP_STATISTIC", true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(SITE_CHARSET == "windows-1251")
	$_REQUEST["nameElement"] = mb_convert_encoding($_REQUEST["nameElement"], "windows-1251", "utf-8");

$arEventFields = array(
	"SUMMARY_NAME" => $_REQUEST["nameElement"],
	"URL_IMG" => $_REQUEST["urlImg"],
	"EMAIL_TO" => $_REQUEST["emailTo"],
);

$fileID = array(0 => $_REQUEST["fileID"]);

CEvent::SendImmediate("REDCODE_SUMMARY", "#LID#", $arEventFields, "N", $_REQUEST["eventMessageId"], $fileID);
CFile::Delete($_REQUEST["fileID"]);