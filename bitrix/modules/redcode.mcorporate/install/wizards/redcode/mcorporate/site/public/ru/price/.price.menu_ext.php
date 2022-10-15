<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"bitrix:menu.sections", 
	"", 
	array(
		"IS_SEF" => "Y",
		"IBLOCK_TYPE" => "redcode_corporate",
		"IBLOCK_ID" => "#PRICE_IBLOCK_ID#",
		"SECTION_URL" => "",
		"DEPTH_LEVEL" => "2",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SEF_BASE_URL" => "#SITE_DIR#price/",
		"SECTION_PAGE_URL" => "",
		"DETAIL_PAGE_URL" => ""
	),
	false
);

$aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);