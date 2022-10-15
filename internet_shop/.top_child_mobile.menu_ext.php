<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;
$aMenuLinksExt = array();

if(CModule::IncludeModule('iblock'))
{
	
		if(defined("BX_COMP_MANAGED_CACHE"))
			$GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_40");

		
			$aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
				"IS_SEF" => "Y",
				"SEF_BASE_URL" => "/internet_shop/",
				"SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
				"DETAIL_PAGE_URL" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
				"IBLOCK_TYPE" => "",
				"IBLOCK_ID" => '40',
				"DEPTH_LEVEL" => "3",
				"CACHE_TYPE" => "N",
			), false, Array('HIDE_ICONS' => 'N'));
		
	
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);

?>