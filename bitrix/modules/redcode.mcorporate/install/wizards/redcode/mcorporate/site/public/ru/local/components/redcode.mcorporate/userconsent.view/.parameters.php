<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

if(!\Bitrix\Main\Loader::includeModule("iblock"))
	return;

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$getActiveList = \Bitrix\Main\UserConsent\Agreement::getActiveList();

$arrayFields = array(
	"NAME" => Loc::getMessage("ARRAY_FIELDS_NAME"),
	"SURNAME" => Loc::getMessage("ARRAY_FIELDS_SURNAME"),
	"PATRONYMIC" => Loc::getMessage("ARRAY_FIELDS_PATRONYMIC"),
	"EMAIL" => "E-mail",
	"PHONE" => Loc::getMessage("ARRAY_FIELDS_PHONE"),
);

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"ACTIVE_LIST" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("ACTIVE_LIST_NAME"),
			"TYPE" => "LIST",
			"VALUES" => $getActiveList,
		),
		"PERSONAL_DATA" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("PERSONAL_DATA_NAME"),
			"TYPE" => "LIST",
			"VALUES" => $arrayFields,
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y",
			"MULTIPLE" => "Y",
		),
	),
);