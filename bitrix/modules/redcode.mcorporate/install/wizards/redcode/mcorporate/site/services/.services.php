<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

$arServices = array(
	"main" => array(
		"NAME" => GetMessage("SERVICE_MAIN_SETTINGS"),
		"STAGES" => array(
 			"files.php",
			"template.php",
			"theme.php",
			"post_event.php",
		),
	),

	"iblock" => array(
		"NAME" => GetMessage("SERVICE_IBLOCK"),
		"STAGES" => array(
			"types.php",
			"articles.php",
			"documents.php",
			"history.php",
			"map.php",
			"news.php",
			"partners.php",
			"price.php",
			"priceServices.php",
			"requisites.php",
			"services.php",
			"reviews.php",
			"shares.php",
			"slider.php",
			"social.php",
			"staff.php",
			"theses.php",
			"vacancies.php",
			"projects.php",
		),
	),
);