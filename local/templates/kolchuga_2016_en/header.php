<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Page\Asset as JsLoader;

Loc::loadLanguageFile(__FILE__);
$curPage = $APPLICATION->GetCurPage();

?><!DOCTYPE HTML>
<html lang="en">
<head>
    <title><? $APPLICATION->ShowTitle() ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="image/x-icon" href="/favicon.ico" rel="icon">
    <link type="image/x-icon" href="/favicon.ico" rel="shortcut icon">

    <?
    JsLoader::getInstance()->addString("<link href='http://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>");
    JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/fonts.css");
    JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/plugins.css");
    JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/style.css");

    //Js
    JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.min.js');
    JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/main.min.js');
    JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/init.js');

    $APPLICATION->ShowHead();

    ?>
    <!--[if lt IE 10]>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fix/placeholder.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fix/respond.min.js"></script>
    <![endif]-->
    <!--[if (gte IE 6)&(lte IE 8)]>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fix/selectivizr-min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/fonts.css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/plugins.css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/style.css?<?=time()?>">
</head>

<body>
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<div class="main">
    <header class="header">
        <div class="container">
            <div class="header__top">
                <div class="header__lang">
                    <a href="/"><?= GetMessage('TITLE_LANG_RUS') ?></a>
                    <a href="/en/" class="active">english</a>
                </div>
                <? $APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth_popup", Array(
                        "REGISTER_URL" => "/register/",
                        "FORGOT_PASSWORD_URL" => "",
                        "PROFILE_URL" => "/personal/profile/",
                        "SHOW_ERRORS" => "Y"
                    )
                ); ?>
            </div>
            <div class="header__middle">
                <div class="header__middle--left">
                    <? $APPLICATION->IncludeComponent("bitrix:menu", "w_icons", Array(
                            "ROOT_MENU_TYPE" => "top_left",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "N",
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => "",
                        )
                    ); ?>
                </div>
                <div class="header__logo">
                    <a href="/en/" class="logo"></a>
                </div>
                <div class="header__middle--right">

                    <div class="header__search">
                        <div class="search-toggle">
                            <span class="icon-search"></span>
                        </div>
                        <form class="form__search" action="/internet_shop/">
                            <input type="text" class="input_inside" name="q" value="" size="15" placeholder="Search" maxlength="50">
                            <button class="btn__search" type="submit" name="s">
                                <span class="icon-search"></span>
                            </button>
                        </form>
                    </div>

                    <? $APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "", Array(
                            "PATH_TO_BASKET" => "/personal/cart/",
                            "PATH_TO_ORDER" => "/personal/order/make/",
                            "SHOW_DELAY" => "Y",
                            "SHOW_NOTAVAIL" => "Y",
                            "SHOW_SUBSCRIBE" => "N"
                        )
                    ); ?>

                </div>
            </div>
        </div>
    </header>
    <nav class="navbar" role="navigation">
        <div class="container">
            <? $APPLICATION->IncludeComponent("bitrix:menu", "header", Array(
                    "ROOT_MENU_TYPE" => "top",
                    "MAX_LEVEL" => "2",
                    "CHILD_MENU_TYPE" => "top_child",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => "",
                )
            ); ?>
            <? $APPLICATION->IncludeComponent("bitrix:menu", "header_catalog", Array(
                    "ROOT_MENU_TYPE" => "top_catalog",
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "N",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => "",
                )
            ); ?>
        </div>
    </nav>

    <div class="main__inner">
        <div class="container">
            <div class="static-page"><?

                if($curPage !== '/'){
                    ?>
                    <div class="title-page">
                        <h1><? $APPLICATION->ShowTitle() ?></h1>
                    </div>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:breadcrumb",
                        "",
                        Array(
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => "",
                            "SITE_ID" => "s1",
                            "START_FROM" => "0"
                        )
                    ); ?>
                    <?
                }
                if(strstr($curPage, '/personal/')){
                echo '<div class="personal">';
                ?>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "COMPONENT_TEMPLATE" => ".default",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => SITE_DIR . "include_content/personal_sidebar.php"
                    )
                ); ?>
                <div class="personal__wrapper">
<? }
