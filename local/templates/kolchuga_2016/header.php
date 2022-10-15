<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Page\Asset as JsLoader;

Loc::loadLanguageFile(__FILE__);
$curPage = $APPLICATION->GetCurPage();

if(!strstr($curPage, 'en/')){
    $english = true;
}

$GLOBALS['saleFilter'] = array(
    'PROPERTY_AKTSIYA_VALUE' => 'Да'
);
$str=explode("/", $APPLICATION->GetCurDir());

?><!DOCTYPE HTML>
<html lang="ru">
<head>
	<link rel="canonical" href="https://www.kolchuga.ru<?=$curPage?>">
	<title><?if($curlPage !== '/'){$APPLICATION->ShowTitle() ?><?}else{?>Кольчуга - оружейный магазин в Москве.<?;}?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="image/x-icon" href="/favicon.ico" rel="icon">
    <link type="image/x-icon" href="/favicon.ico" rel="shortcut icon">

    <?$APPLICATION->ShowHead();?>
	<?
	//CSS
	/* JsLoader::getInstance()->addString("<link href='https://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='preload' type='text/css' as='style'>");
	JsLoader::getInstance()->addString("<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='preload' type='text/css' as='style'>");
	JsLoader::getInstance()->addString("<link href='".SITE_TEMPLATE_PATH."/css/fonts.css' rel='preload' type='text/css' as='style'>"); */

	//JsLoader::getInstance()->addString("<link href='https://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css' >");
	//JsLoader::getInstance()->addString("<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>");
	
	JsLoader::getInstance()->addString('<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet"><link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">', true);
	?><style>
@font-face{
	font-family:icomoon;
	src:url(<?=SITE_TEMPLATE_PATH?>/fonts/icomoon.eot);
	src:url(<?=SITE_TEMPLATE_PATH?>/fonts/icomoon.eot) format('embedded-opentype'),url(<?=SITE_TEMPLATE_PATH?>/fonts/icomoon.ttf) format('truetype'),url(<?=SITE_TEMPLATE_PATH?>/fonts/icomoon.woff) format('woff'),url(<?=SITE_TEMPLATE_PATH?>/fonts/icomoon.svg) format('svg');
	font-weight:400;
	font-style:normal;
	font-display: swap;
	}
</style><?
JsLoader::getInstance()->addString('<link rel="preload" href="'.SITE_TEMPLATE_PATH.'/fonts/icomoon.woff" as="font" type="font/woff" crossorigin="anonymous">', true);
	JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/fonts.css");
	JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/bootstrap.css');
	JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/plugins.css");
	JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/style.css");
	JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/dev_style.css");

	//Js
	//JsLoader::getInstance()->addString("<script type='text/javascript' src='".SITE_TEMPLATE_PATH."/js/jquery.min.js' rel='preload' as='script' data-skip-moving='true'></script>");
	JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.min.js');
	JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/bootstrap.min.js');
	JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/main.min.js');
	JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/custom.js');
	JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/init.js');
	JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.menu-aim.js');
	JsLoader::getInstance()->addJs('/local/templates/.default/common.kolchuga/c-form.js');
    JsLoader::GetInstance()->addJs(SITE_TEMPLATE_PATH."/js/add2basket.js");

	//UI
	JsLoader::GetInstance()->addCss(SITE_TEMPLATE_PATH."/js/ui/jquery-ui.min.css");
	JsLoader::GetInstance()->addJs(SITE_TEMPLATE_PATH."/js/ui/jquery-ui.min.js");
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
    
    <script> 
        //Bigdata fix
        var bx_rcm_adaptive_recommendation_event_attaching = function(){
            return true;
        }
    </script>
	
    <meta name="google-site-verification" content="wdH_YSHQIYclUZKkK_D_2YodfhbrUai74iTM1zZrRbU" />
	<meta name="yandex-verification" content="a11aa5c9d222c32d" />
	<meta name="cmsmagazine" content="ae8ba650af558ef6ab6e2d287a6b2901" />
	
	<!-- Google Tag Manager -->
		<script data-skip-moving="true">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-TTM58DK');</script>
    <!-- End Google Tag Manager -->
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script data-skip-moving="true" async src="https://www.googletagmanager.com/gtag/js?id=UA-177109637-1"></script>
	<script data-skip-moving="true">
	 window.dataLayer = window.dataLayer || [];
	 function gtag(){dataLayer.push(arguments);}
	 gtag('js', new Date());

	 gtag('config', 'UA-177109637-1');
	</script>
</head>
<body>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" data-skip-moving="true">
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(36451865, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true,
        ecommerce:"dataLayer"
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/36451865" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TTM58DK" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<div class="main">


	 <? $APPLICATION->IncludeComponent("bitrix:menu", "header_mobile", Array(
            "ROOT_MENU_TYPE" => "topnew.mobile",
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
	
    <header class="header site-header navbar-sticky">
        <div class="container-fluid">
			<div class="row">
				<div class="header__top_tel">
				<div class="container"><div class="row">
                    <div class="header__top_switcher">
                        <div class="header__lang">
                            <a href="/" class="active"><?= GetMessage('TITLE_LANG_RUS') ?></a> <span>/</span> <a
                                    href="/en/">english</a>
                        </div>
                    </div>
                    <div class="header__top_menu">

                        <? $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "aim_menu_topnew_v2",
                            array(
                                "ROOT_MENU_TYPE"        => "topnew",
                                "MAX_LEVEL"             => "2",
                                "CHILD_MENU_TYPE"       => "top_child",
                                "USE_EXT"               => "N",
                                "DELAY"                 => "N",
                                "ALLOW_MULTI_SELECT"    => "N",
                                "MENU_CACHE_TYPE"       => "Y",
                                "MENU_CACHE_TIME"       => "3600000",
                                "MENU_CACHE_USE_GROUPS" => "N",
                                "MENU_CACHE_GET_VARS"   => array(),
                                "COMPONENT_TEMPLATE"    => "aim_menu_topnew_v2"
                            ),
                            false
                        );
                        ?>

                    </div>

                    <?/*<div class="col-6 col-sm-6 col-md-2 pl-md-0">
                    <div class="header__top_tel_block">
                        <div class="header__top_tel_link">
                            <a href="/contacts/" <?= $APPLICATION->GetCurDir() == '/contacts/' ? 'class="active"' : '' ?>>Контакты</a>
                        </div>
                    </div>
                </div>*/?>
				</div></div>
				</div>
				
				<div class="container header__top_nav"><div class="row">
					<div class="col-3 col-sm-3 d-block d-sm-block d-md-none">
						<div class="gamburger_menu">
						<? $APPLICATION->IncludeComponent(
							"bitrix:menu", 
							"w_icons", 
							array(
								"ROOT_MENU_TYPE" => "top_left",
								"MAX_LEVEL" => "1",
								"CHILD_MENU_TYPE" => "N",
								"USE_EXT" => "Y",
								"DELAY" => "N",
								"ALLOW_MULTI_SELECT" => "N",
								"MENU_CACHE_TYPE" => "Y",
								"MENU_CACHE_TIME" => "3600000",
								"MENU_CACHE_USE_GROUPS" => "N",
								"MENU_CACHE_GET_VARS" => array(
								),
								"COMPONENT_TEMPLATE" => "w_icons"
							),
							false
						); ?>
						</div>
					</div>
					<div class="col-6 col-sm-6 col-md-2 order-1">
						<div class="header__logo">
							<a href="/" class="logo"></a>
						</div>
					</div>
					
					<div class="col-md-4 order-3 order-md-2 header__top_search">
						<div class="header__search">
							
								<?/*<form class="form__search smart_search" action="/internet_shop/">
									<input id="smart_search_query" type="text" class="input_inside" name="q" value="<?=(!empty($_REQUEST['q'])?$_REQUEST['q']:'')?>" size="15" placeholder="Поиск" maxlength="50">
									<button class="btn__search" type="submit" name="s" title="Найти">
										<span class="icon-search"></span>
									</button>
									
								</form>*/?>

                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:search.title",
                                    "search_title_v2",
                                    array(
                                        "NUM_CATEGORIES"               => "1",
                                        "TOP_COUNT"                    => "5",
                                        "CHECK_DATES"                  => "N",
                                        "SHOW_OTHERS"                  => "N",
                                        "PAGE"                         => SITE_DIR . "internet_shop/",
                                        "CATEGORY_0_TITLE"             => GetMessage("SEARCH_GOODS"),
                                        "CATEGORY_0"                   => array(
                                            0 => "iblock_1c_catalog",
                                        ),
                                        "CATEGORY_0_iblock_catalog"    => array(
                                            0 => "all",
                                        ),
                                        "CATEGORY_OTHERS_TITLE"        => GetMessage("SEARCH_OTHER"),
                                        "SHOW_INPUT"                   => "Y",
                                        "INPUT_ID"                     => "title-search-input",
                                        "CONTAINER_ID"                 => "search",
                                        "PRICE_CODE"                   => array(
                                            0 => "Розничная",
                                        ),
                                        "SHOW_PREVIEW"                 => "Y",
                                        "PREVIEW_WIDTH"                => "75",
                                        "PREVIEW_HEIGHT"               => "75",
                                        "CONVERT_CURRENCY"             => "Y",
                                        "COMPONENT_TEMPLATE"           => "bootstrap_v4",
                                        "ORDER"                        => "date",
                                        "USE_LANGUAGE_GUESS"           => "N",
                                        "TEMPLATE_THEME"               => "blue",
                                        "PRICE_VAT_INCLUDE"            => "Y",
                                        "PREVIEW_TRUNCATE_LEN"         => "",
                                        "CURRENCY_ID"                  => "RUB",
                                        "CATEGORY_0_iblock_1c_catalog" => array(
                                            0 => "40",
                                        )
                                    ),
                                    false
                                ); ?>
							
						</div>
					</div>
					<div class="col-md-5 order-4 order-md-3 header__top_mobile">
						<nav class="navbar aim_menu2" role="navigation">
							<div class="container">
							
							<? $APPLICATION->IncludeComponent("bitrix:menu", "aim_menu22", Array(
										"ROOT_MENU_TYPE" => "top",
										"MAX_LEVEL" => "4",
										"CHILD_MENU_TYPE" => "top_child",
										"USE_EXT" => "Y",
										"DELAY" => "N",
										"ALLOW_MULTI_SELECT" => "N",
										"MENU_CACHE_TYPE" => "Y",
										"MENU_CACHE_TIME" => "36000000",
										"MENU_CACHE_USE_GROUPS" => "N",
										"MENU_CACHE_GET_VARS" => "",
									)
								); ?>							
							</div>
								
						</nav>
					</div>
					
					<div class="col-3 col-sm-3 col-md-1 pl-md-0 order-2 order-md-4 header__service-wrapper">
                        <div class="header__auth">
                            <? $APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth_popup2", array(
                                    "REGISTER_URL"        => "/register/",
                                    "FORGOT_PASSWORD_URL" => "",
                                    "PROFILE_URL"         => "/personal/profile/",
                                    "SHOW_ERRORS"         => "Y"
                                )
                            ); ?>
                        </div>
                        <div class="header__basket">
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:sale.basket.basket.small",
                                "basket_small_v2",
                                array(
                                    "PATH_TO_BASKET"     => "/personal/cart/",
                                    "PATH_TO_ORDER"      => "/personal/order/make/",
                                    "SHOW_DELAY"         => "N",
                                    "SHOW_NOTAVAIL"      => "N",
                                    "SHOW_SUBSCRIBE"     => "N",
                                    "COMPONENT_TEMPLATE" => "basket_small_v2"
                                ),
                                false
                            ); ?>
                        </div>
                    </div>

					<? if(strpos($APPLICATION->GetCurPage(false), '/internet_shop/') === false): ?>
							<div class="container-fluid order-6"><div class="row">
						<div class="col-12">
									<? $APPLICATION->IncludeComponent("bitrix:menu", "header_catalog", Array(
											"ROOT_MENU_TYPE" => "top_child",
											"MAX_LEVEL" => "1",
											"CHILD_MENU_TYPE" => "N",
											"USE_EXT" => "Y",
											"DELAY" => "N",
											"ALLOW_MULTI_SELECT" => "N",
											"MENU_CACHE_TYPE" => "Y",
											"MENU_CACHE_TIME" => "36000000",
											"MENU_CACHE_USE_GROUPS" => "N",
											"MENU_CACHE_GET_VARS" => "",
										)
									); ?>
									<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
									"AREA_FILE_SHOW" => "page",
									"AREA_FILE_SUFFIX" => "verh",
									"EDIT_TEMPLATE" => "page_verh.php"
									),
									false
									);?>
								<? endif ?>
							</div></div>
						</div>
				</div></div>
				
			</div>
		</div>
	
	<script>	
	if(screen.width <= 700){
  document.querySelector('.aim_catalog').classList.remove('aim_catalog');
}
	</script>	
</header>

    

    <div class="main__inner">
    <?if( $curPage == '/' || $curPage == '/index2.php' ){

        $APPLICATION->IncludeComponent(
            'kolchuga:home.slider',
            '',
            array(
                'CACHE_TYPE' => 'Y',
                'CACHE_TIME' => 180,
            )
        );

    }elseif($str[1]=='brands' && !empty($str[2])){?>
	
	<?
		global $seeinbrand;
		$seeinbrand['PROPERTY_SEE_IN_BRAND']=$str[2];
	?>
		<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"slider_brand.main", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "slider.main",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "DETAIL_TEXT",
			4 => "DETAIL_PICTURE",
			5 => "",
		),
		"FILTER_NAME" => "seeinbrand",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "58",
		"IBLOCK_TYPE" => "banners",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "LINK",
			1 => "LOGO_USER",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	),
	false
);?>
	<?}?>
        <div class="container<?php $APPLICATION->ShowProperty("fluid_container") ?>">
            <div class="static-page"><?

                if ($curPage !== '/') {
					
					if($str[1]=='services' || $str[1]=='services2' || $str[1]=='services_centers' || $str[2]=='it-is-interesting'|| $str[1]=='articles'|| $str[1]=='news'|| $str[1]=='discount'){}else{
                    ?>
				
                    <?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb", 
	"default_new", 
	array(
		"COMPONENT_TEMPLATE" => "default_new",
		"PATH" => "",
		"SITE_ID" => "s1",
		"START_FROM" => $start_level
	),
	false
);?>
		
                    <? if(strpos($APPLICATION->GetCurPage(false), '/internet_shop/') !== 0 && $str[1]!='optovik'): ?>
                        <?php if ($APPLICATION->GetCurPage() != '/personal/profile/' && $_GET['forgot_password'] != 'yes'): ?>
                            <? if(strpos($APPLICATION->GetCurPage(false), '/ajax/') !== 0): ?>
                                <div class="title-page">
                                    <h1 class="js-page-title"><? exCSite::ShowH1(); //$APPLICATION->ShowTitle() ?></h1>
                                </div>
                            <?php endif ?>
                        <?php endif ?>
                    <? endif ?>
                                        
                    <?
                }
                }
                /* if(strstr($curPage, '/personal/') && ($USER->GetID()!="11460"  && $_REQUEST['ps']!=22)){
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
<? }else */ if(strstr($curPage, '/personal/')){?>
                <div class="personal ">
                <div class="container-fluid"><div class="row">
                <?if(!$USER->IsAuthorized()){?>
				<div class="col-12 pl-0 pr-0">
				<?}else{?>
				<div class="col-lg-9 pl-0">
				<?}?>
                <div class="personal__wrapper">
				<?if(!$USER->IsAuthorized()){?>
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
				<?}?>
<? }
