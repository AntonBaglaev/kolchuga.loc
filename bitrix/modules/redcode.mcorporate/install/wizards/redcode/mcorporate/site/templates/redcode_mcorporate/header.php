<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

$asset = \Bitrix\Main\Page\Asset::getInstance();
$loc = new \Bitrix\Main\Localization\Loc;
$loc->loadMessages(__FILE__);
?>
<!DOCTYPE HTML>
<html lang="<?=LANGUAGE_ID?>">
<head>
	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<![endif]-->
	<!--[if lt IE 9]>
		<script src="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH."/js/html5shiv.min.js");?>"></script>
	<![endif]-->

	<title><?$APPLICATION->ShowTitle();?></title>
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<meta name="theme-color" content="#2B2A29" />
	
	<link rel="icon" type="image/x-icon" href="<?=SITE_TEMPLATE_PATH;?>/img/favicon16.ico" sizes="16x16" />
	<link rel="icon" type="image/x-icon" href="<?=SITE_TEMPLATE_PATH;?>/img/favicon32.ico" sizes="32x32" />
	<link rel="icon" type="image/x-icon" href="<?=SITE_TEMPLATE_PATH;?>/img/favicon96.ico" sizes="96x96" />
	
	<link href="//fonts.googleapis.com/css?family=Rubik:300,400,400i,500,500i,700|Roboto:400,500,600,700,900&amp;subset=cyrillic" type="text/css" rel="stylesheet" />
	
	<?php
		$asset->addJs(SITE_TEMPLATE_PATH."/js/jquery-2.2.4.min.js");
		$APPLICATION->ShowHead();
		$detailed = $APPLICATION->GetCurPage(false) != SITE_DIR;
		
		$logo = "#SITE_LOGO#";
		if($logo != "logo")
			$logo = ($detailed ? "logo_detail" : "logo");
	?>
</head>

<body <?echo ($detailed ? "class='detailed'" : "")?>>
<?php
$APPLICATION->ShowPanel();
$optionTheme = $APPLICATION->IncludeComponent("redcode.mcorporate:switch.color", "", array(), false, array("HIDE_ICONS" => "Y"));
?>

<header>
	<div class="headerWrap">
		<div class="<?echo ($detailed ? "logo_detail" : "logo");?>">
			<a href="<?=SITE_DIR;?>" <?echo ($logo == "logo" ? "class='logoNoBackground'" : "");?>>
				<?
				$APPLICATION->IncludeComponent(
					"bitrix:main.include", "", 
					array(
						"AREA_FILE_SHOW" => "file",
						"PATH" => SITE_DIR."include_areas/header/".$logo.".php",
					)
				);
				?>
			</a>
		</div>

		<div class="topMenu materialIcons">&#xE5D2;</div>

		<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
				"AREA_FILE_SHOW" => "file",
				"PATH" => SITE_DIR."include_areas/contact/search.php",
			),
			false,
			array(
			"ACTIVE_COMPONENT" => "Y"
			)
		);?>
		
		<div class="top_callBack">
			<div data-id="callBack" class="request_call modalButton"><?=$loc->getMessage("REQUEST_CALL");?></div>
		</div>
		
		<?$APPLICATION->IncludeComponent(
			"bitrix:menu", 
			"headerMenu", 
			array(
				"ALLOW_MULTI_SELECT" => "N",
				"CHILD_MENU_TYPE" => "left",
				"COMPONENT_TEMPLATE" => "headerMenu",
				"DELAY" => "N",
				"MAX_LEVEL" => "2",
				"MENU_CACHE_GET_VARS" => array(
				),
				"MENU_CACHE_TIME" => "3600",
				"MENU_CACHE_TYPE" => "N",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"MENU_THEME" => "site",
				"ROOT_MENU_TYPE" => "topHeader",
				"USE_EXT" => "Y"
			),
			false
		);?>
	</div>
</header>

<?if($detailed){?>
	<div class="mainTitle">
		<?$APPLICATION->IncludeComponent(
			"bitrix:breadcrumb", 
			"", 
			array(
				"START_FROM" => "0",
				"PATH" => "",
				"SITE_ID" => SITE_ID,
				"COMPONENT_TEMPLATE" => ""
			),
			false
		);?>
		<h1 class="<?$APPLICATION->ShowProperty("sizeTitle");?>"><?$APPLICATION->ShowTitle(false);?></h1>
	</div>
	<div class="workArea">
<?}?>