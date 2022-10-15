<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Context;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Page\Asset;
$currentPage = str_replace('index.php', '', Context::getCurrent()->getRequest()->getRequestedPage());
$isMainPage = $currentPage === SITE_DIR;
$asset = Asset::getInstance();
?>
<!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
	<head>
		<link rel="canonical" href="https://www.kolchuga.ru<?=$currentPage?>">
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
		<meta http-equiv="x-ua-compatible" content="ie=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta content="yes" name="apple-mobile-web-app-capable"/>
		<meta name="HandheldFriendly" content="true"/>
		<link type="image/x-icon" href="/favicon.ico" rel="icon">
		<link type="image/x-icon" href="/favicon.ico" rel="shortcut icon">
		<title><? $APPLICATION->ShowTitle(''); ?></title>
		<? $APPLICATION->ShowHead(); ?>
		<? \Kolchuga\Analytics::includeGoogleTag(); ?>
		<? \Kolchuga\Analytics::includeGoogleAnalytics(); ?>
		
	</head>
	<body>
	
		<? \Kolchuga\Analytics::includeYandexMetrika(); ?>
		<? \Kolchuga\Analytics::includeGoogleTagNo(); ?>
		
		<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
		<div class="main">
			<? $APPLICATION->IncludeComponent("bitrix:menu", "header_mobile", Array(
			"ROOT_MENU_TYPE" => "topnew",
			"MAX_LEVEL" => "3",
			"CHILD_MENU_TYPE" => "top_child_mobile",
			"USE_EXT" => "Y",
			"DELAY" => "N",
			"ALLOW_MULTI_SELECT" => "N",
			"MENU_CACHE_TYPE" => "A",
			"MENU_CACHE_TIME" => "36000000",
			"MENU_CACHE_USE_GROUPS" => "N",
			"CACHE_SELECTED_ITEMS" => "N",
			"MENU_CACHE_GET_VARS" => array(),
			"COMPONENT_TEMPLATE" => "header_mobile"
			),
			false
			); ?>