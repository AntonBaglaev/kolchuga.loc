<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

$arTemplateParameters = array(
	"USE_SUGGEST" => array(
		"NAME" => GetMessage("TP_BSF_USE_SUGGEST"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"PLACEHOLDER_TEXT" => array(
		"NAME" => GetMessage("PLACEHOLDER_TEXT_NAME"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("PLACEHOLDER_TEXT_DEFAULT"),
	),
);