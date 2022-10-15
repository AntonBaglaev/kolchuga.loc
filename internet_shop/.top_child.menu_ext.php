<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

	$aMenuLinksExt = $APPLICATION->IncludeComponent(
		"kolchuga:menu.sections", 
		"", 
		array(
			"IS_SEF" => "Y",
			"IBLOCK_TYPE" => "",
			"IBLOCK_ID" => "40",
			"DEPTH_LEVEL" => 3,
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"SEF_BASE_URL" => "/internet_shop/",
			"SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
			"DETAIL_PAGE_URL" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/"
		),
		false,
		array(
			"ACTIVE_COMPONENT" => "Y"
		)
	);


	/*$aMenuLinksExt = $APPLICATION->IncludeComponent(
		"bitrix:menu.sections", 
		"", 
		array(
			"IS_SEF" => "Y",
			"IBLOCK_TYPE" => "",
			"IBLOCK_ID" => "40",
			"DEPTH_LEVEL" => "1",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"SEF_BASE_URL" => "/internet_shop/",
			"SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
			"DETAIL_PAGE_URL" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/"
		),
		false,
		array(
			"ACTIVE_COMPONENT" => "Y"
		)
	);*/
	


$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);

?>