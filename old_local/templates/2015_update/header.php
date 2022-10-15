<!DOCTYPE HTML>
<html>
<head>
    <title><? $APPLICATION->ShowTitle(); ?></title>

    <LINK REL="SHORTCUT ICON" href="/images/logo.ico" type="image/x-icon">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
    <meta http-equiv='Content-Type' content='text/html; charset=windows-1251'>
    <? $APPLICATION->ShowMeta("keywords") ?>
    <? $APPLICATION->ShowMeta("description") ?>

    <meta http-equiv='Content-Type' content='text/html; charset=windows-1251'>

    <link href="/css/design_all.css" rel="stylesheet" type="text/css">
    <!--[if lte IE 7]>
    <link href="/css/design_ie.css" type="text/css" rel="stylesheet">
    <![endif]-->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <script src="/js/jquery-1.8.1.js" type="text/javascript"></script>
    <script src="/js/cufon-yui.js" type="text/javascript"></script>
    <script src="/js/adventure_400.font.js" type="text/javascript"></script>
    <script src="/js/swfobject.js" type="text/javascript"></script>
    <link
        href='http://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic&subset=latin,cyrillic-ext,latin-ext,cyrillic'
        rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/banner/flexslider.css" type="text/css">
    <script src="/banner/jquery.flexslider.js"></script>


    <script type="text/javascript" src="/js/jquery.jcarousel.min.js"></script>
    <script type="text/javascript" src="/js/jquery.dropkick-1.0.0.js"></script>
    <!--[if lt IE 9]>
    <script src="/js/html5.js"></script>
    <script src="/js/css3-mediaqueries.js"></script>
    <![endif]-->
    <script type="text/javascript">
        $(document).ready(function () {
            Cufon.replace('.adventure', {hover: 'true'});
        });
    </script>


    <!-- <script type="text/javascript" src="/js/jquery.tools.min.js"></script>
    <script type="text/javascript" src="/js/jquery/jquery.thickbox.js"></script>
    <link href="/css/thickbox.css" type="text/css" rel="stylesheet" /> -->

    <!-- <script src='/js/dsm.js'></script>
    <script src='/js/cookie.js'></script> -->
    <? $APPLICATION->ShowHead(); ?>
    <script>
        function BgChange(id, namesrc) {
            id = "id_item_" + id;
            if (document.getElementById(id)) {
                if (namesrc == 0) {
                    document.getElementById(id).background = ImageOut;
                }
                if (namesrc == 1) {
                    document.getElementById(id).background = ImageOver;
                }
            }
        }
        function TdChange(id, class_name) {
            document.getElementById(id).className = class_name;
        }
        function MenuChange(id, class_name) {
            document.getElementById(id).className = class_name;
        }
        function newImage(arg) {
            if (document.images) {
                rslt = new Image();
                rslt.src = arg;
                return rslt;
            }
        }
    </script>
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-58535221-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>
<body>
<?
// is catalog page
$IS_CATALOG = "Y";
if (strpos($APPLICATION->GetCurPage(true), SITE_DIR . "internet_shop/") === false)
    $IS_CATALOG = "N";
?>
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<div class="container">
    <div class="main">
        <div class="all">
            <div class="header">
                <div class="header_body">
                    <div class="block_logo_company">
                        <? $APPLICATION->IncludeComponent("bitrix:main.include", "vko_right1", array(
                            "AREA_FILE_SHOW" => "sect",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => ""
                        ),
                            false,
                            array(
                                "ACTIVE_COMPONENT" => "Y"
                            )
                        ); ?>
                        <!-- <a href="/" class="text_company adventure">пїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ</a> -->
                    </div>
                    <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR . "include/basketviewer.php",
                        "EDIT_TEMPLATE" => ""
                    ),
                        false,
                        array(
                            "ACTIVE_COMPONENT" => "Y"
                        )
                    ); ?>
                    <div class="long">
                        <!-- <a href="#" class="ru adventure">пїЅпїЅпїЅпїЅпїЅпїЅпїЅ</a>
                        <a href="#" class="en adventure">english</a>	 -->
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_DIR . "include/switch site.php",
                                "EDIT_TEMPLATE" => ""
                            ),
                            false
                        ); ?>
                    </div>
                    <div class="content">
                        <div class="div_1280">
                            <? $APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                                "AREA_FILE_SHOW" => "sect",
                                "AREA_FILE_SUFFIX" => "img",
                                "AREA_FILE_RECURSIVE" => "Y",
                                "EDIT_TEMPLATE" => ""
                            ),
                                false
                            ); ?>
                        </div>
                        <div class="div_1024">
                            <? $APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                                "AREA_FILE_SHOW" => "sect",
                                "AREA_FILE_SUFFIX" => "img_min",
                                "AREA_FILE_RECURSIVE" => "Y",
                                "EDIT_TEMPLATE" => ""
                            ),
                                false
                            ); ?>
                        </div>
                    </div>
                    <div class="block_menu_top_right">
                        <? $APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "",
                            "EDIT_TEMPLATE" => ""
                        ),
                            false
                        ); ?>
                        <? $APPLICATION->IncludeComponent("bitrix:menu", "menu_top_right", array(
                            "ROOT_MENU_TYPE" => "min_menu",
                            "MENU_CACHE_TYPE" => "Y",
                            "MENU_CACHE_TIME" => "360000",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => array(),
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "top_child",
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N"
                        ),
                            false
                        ); ?>

                        <div class="year18">18+</div>
                    </div>
                    <? $APPLICATION->IncludeComponent("bitrix:menu", "top_menu", array(
                        "ROOT_MENU_TYPE" => "top",
                        "MENU_CACHE_TYPE" => "Y",
                        "MENU_CACHE_TIME" => "360000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(),
                        "MAX_LEVEL" => "2",
                        "CHILD_MENU_TYPE" => "top_child",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N"
                    ),
                        false
                    ); ?>
                </div>
                <? $APPLICATION->IncludeComponent("bitrix:menu", "top_menu_child", array(
                    "ROOT_MENU_TYPE" => 'top_child',
                    "MENU_CACHE_TYPE" => "Y",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(),
                    "MAX_LEVEL" => "1",
                    "USE_EXT" => "Y",
                    "ALLOW_MULTI_SELECT" => "N"
                ),
                    false
                ); ?>
                <div style="padding-bottom:20px">
                    <? $APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                        "AREA_FILE_SHOW" => "page",
                        "AREA_FILE_SUFFIX" => "ghome",
                        "EDIT_TEMPLATE" => ""
                    ),
                        false,
                        array(
                            "ACTIVE_COMPONENT" => "Y"
                        )
                    ); ?>
                </div>

            </div>
            <div class="center">
                <div class="ov_hidden">
                    <? $APPLICATION->IncludeComponent("bitrix:menu", "left_child_menu2", Array(
                        "ROOT_MENU_TYPE" => "top_child3",    // пїЅпїЅпїЅ пїЅпїЅпїЅпїЅ пїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ
                        "MENU_CACHE_TYPE" => "N",    // пїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ
                        "MENU_CACHE_TIME" => "3600",    // пїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ (пїЅпїЅпїЅ.)
                        "MENU_CACHE_USE_GROUPS" => "Y",    // пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ
                        "MENU_CACHE_GET_VARS" => "",    // пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ
                        "MAX_LEVEL" => "1",    // пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅ
                        "CHILD_MENU_TYPE" => "left",    // пїЅпїЅпїЅ пїЅпїЅпїЅпїЅ пїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ
                        "USE_EXT" => "N",    // пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅ пїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅ .пїЅпїЅпїЅ_пїЅпїЅпїЅпїЅ.menu_ext.php
                        "DELAY" => "N",    // пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅ
                        "ALLOW_MULTI_SELECT" => "N",    // пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ
                    ),
                        false,
                        array(
                            "ACTIVE_COMPONENT" => "Y"
                        )
                    ); ?>
                    <div class="content">
                        <div>
                            <!-- <h1 class="border_circl color_blue"><? $APPLICATION->ShowTitle() ?><i></i> <b></b></h1> -->
                            <? if ($APPLICATION->GetCurPage() != "/") {
                                echo '<h1 class="border_circl color_blue">';
                                $APPLICATION->ShowTitle();
                                echo '<i></i> <b></b></h1>';
                            } ?>
                        </div>
                        <? $APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                            "AREA_FILE_SHOW" => "page",
                            "AREA_FILE_SUFFIX" => "ctlg",
                            "EDIT_TEMPLATE" => ""
                        ),
                            false,
                            array(
                                "ACTIVE_COMPONENT" => "Y"
                            )
                        ); ?>
                        <div class="content_body">