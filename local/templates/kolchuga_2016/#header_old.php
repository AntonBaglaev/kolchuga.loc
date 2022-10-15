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
	<title><? /*Сеть оружейных салонов Кольчуга*/ ?><?if($curlPage !== '/'){/*?> - <?*/ $APPLICATION->ShowTitle() ?><?}else{?>Кольчуга - оружейный магазин в Москве.<?;}?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="image/x-icon" href="/favicon.ico" rel="icon">
    <link type="image/x-icon" href="/favicon.ico" rel="shortcut icon">

    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':

    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],

    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=

    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);

    })(window,document,'script','dataLayer','GTM-TTM58DK');</script>
    <?
    JsLoader::getInstance()->addString("<link href='https://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>");
    JsLoader::getInstance()->addString("<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>");
    JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/fonts.css");
	JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/bootstrap.css');
    JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/plugins.css");
    JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/style.css");
    JsLoader::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/dev_style.css");

    //Js
    JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.min.js');
	JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/bootstrap.min.js');
    JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/main.min.js');
    JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/custom.js');
    JsLoader::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/init.js');
		JsLoader::getInstance()->addJs('/local/templates/.default/common.kolchuga/c-form.js');

    //UI
    JsLoader::GetInstance()->addCss(SITE_TEMPLATE_PATH."/js/ui/jquery-ui.min.css");
    JsLoader::GetInstance()->addJs(SITE_TEMPLATE_PATH."/js/ui/jquery-ui.min.js");

    $APPLICATION->ShowHead();

    ?>
    <!-- Google Tag Manager -->


    <!-- End Google Tag Manager -->
    <!--[if lt IE 10]>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fix/placeholder.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fix/respond.min.js"></script>
    <![endif]-->
    <!--[if (gte IE 6)&(lte IE 8)]>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fix/selectivizr-min.js"></script>
    <![endif]-->
    <?if($_SERVER['HTTP_HOST'] == 'kolchuga.ru.dev'):?>
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/fonts.css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/plugins.css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/style.css">
    <?endif?>
    <script>
        //Bigdata fix
        var bx_rcm_adaptive_recommendation_event_attaching = function(){
            return true;
        }
    </script>

    <? if(strpos($APPLICATION->GetCurUri(), 'PAGEN_') !== false): ?>
        <link rel="canonical" href="<?=$APPLICATION->GetCurPage(false)?>" />
    <? endif ?>


    <script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jquery.menu-aim.js"></script>

    <meta name="google-site-verification" content="wdH_YSHQIYclUZKkK_D_2YodfhbrUai74iTM1zZrRbU" /> 

    <meta name="yandex-verification" content="a11aa5c9d222c32d" />

<!-- CallbackHunter -->

<!-- /CallbackHunter -->
<!-- Global site tag (gtag.js) - Google Analytics --><script async src="https://www.googletagmanager.com/gtag/js?id=UA-177109637-1"></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());

 gtag('config', 'UA-177109637-1');
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
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
</head>

<body>
<!-- Google Tag Manager (noscript) -->



<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TTM58DK" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

<!-- End Google Tag Manager (noscript) -->
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<div class="main">

<?if($_REQUEST['newhead']!='Y'){?>
	 <? $APPLICATION->IncludeComponent("bitrix:menu", "header_mobile", Array(
            "ROOT_MENU_TYPE" => "topnew",
            "MAX_LEVEL" => "3",
            "CHILD_MENU_TYPE" => "top_child_mobile",
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "N",
            "MENU_CACHE_TYPE" => "Y",
            "MENU_CACHE_TIME" => "36000000",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_CACHE_GET_VARS" => "",
        )
    ); ?>
    <header class="header">
        <div class="container-fluid">
			<div class="row">
				<div class="header__top_tel">
				<div class="container"><div class="row">
					<div class="col-6 col-sm-6 col-md-2">
						<div class="header__lang">
							<a href="/" class="active"><?= GetMessage('TITLE_LANG_RUS') ?></a> <span>/</span> <a href="/en/">english</a>
						</div>
					</div>
					<div class="col-md-8 d-none d-md-block">
						<div class="header__middle--center">
							<? $APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"aim_menu_topnew", 
								array(
									"ROOT_MENU_TYPE" => "topnew",
									"MAX_LEVEL" => "1",
									"CHILD_MENU_TYPE" => "N",
									"USE_EXT" => "Y",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N",
									"MENU_CACHE_TYPE" => "Y",
									"MENU_CACHE_TIME" => "3600000",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"MENU_CACHE_GET_VARS" => array(
									),
									"COMPONENT_TEMPLATE" => "aim_menu_topnew"
								),
								false
								); ?>
						</div>
					</div>
					<div class="col-6 col-sm-6 col-md-2 pl-md-0">
						<div class="header__top_tel_block">
							<div class="header__top_tel_link">
								<a href="tel:88002349420">8 (800) 234-94-20</a>                    
							</div>
							<div class="header__top_tel_block_text">
								<div class="tel_block_text">
									<div><span class="tel_text_left">Салон на Варварке:</span> <a href="tel:+74952343443" class="tel_text_right">+7 (495) 234-34-43</a></div>
									<div><span class="tel_text_left">Салон на Волоколамском шоссе:</span> <a href="tel:+74954901420" class="tel_text_right">+7 (495) 490-14-20</a></div>
									<div><span class="tel_text_left">Салон на Ленинском Проспекте:</span> <a href="tel:+74956512500" class="tel_text_right">+7 (495) 651-25-00</a></div>
									<div><span class="tel_text_left">Салон в г. Люберцы:</span> <a href="tel:+74955542240" class="tel_text_right">+7 (495) 554-22-40</a></div>
									<div><span class="tel_text_left">Интернет-магазин:</span> <a href="tel:88002349420" class="tel_text_right">8 (800) 234-94-20</a></div>
								</div>
								<div class="tel_block_title">
									<span><i class="fa fa-caret-down" aria-hidden="true"></i></span>
									
								</div>
							</div>
						</div>
					</div>
				</div></div>
				</div>
				
				<div class="container"><div class="row">
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
								"MENU_CACHE_USE_GROUPS" => "Y",
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
					
					<div class="col-md-4 order-3 order-md-2">
						<div class="header__search">
							
								<form class="form__search smart_search" action="/search/">
									<input id="smart_search_query" type="text" class="input_inside" name="q" value="<?=(!empty($_REQUEST['q'])?$_REQUEST['q']:'')?>" size="15" placeholder="Поиск" maxlength="50">
									<button class="btn__search" type="submit" name="s" title="Найти">
										<span class="icon-search"></span>
									</button>
									
								</form>

							
						</div>
					</div>
					<div class="col-md-5 order-4 order-md-3">
						<nav class="navbar aim_menu2" role="navigation">
							<div class="container">
								<? $APPLICATION->IncludeComponent("bitrix:menu", "aim_menu2", Array(
										"ROOT_MENU_TYPE" => "top",
										"MAX_LEVEL" => "4",
										"CHILD_MENU_TYPE" => "top_child",
										"USE_EXT" => "Y",
										"DELAY" => "N",
										"ALLOW_MULTI_SELECT" => "N",
										"MENU_CACHE_TYPE" => "N",
										"MENU_CACHE_TIME" => "36000000",
										"MENU_CACHE_USE_GROUPS" => "Y",
										"MENU_CACHE_GET_VARS" => "",
									)
								); ?>
								
							</div>
								
						</nav>
					</div>
					
					<div class="col-3 col-sm-3 col-md-1 pl-md-0 order-2 order-md-4">
						<? $APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth_popup2", Array(
							"REGISTER_URL" => "/register/",
							"FORGOT_PASSWORD_URL" => "",
							"PROFILE_URL" => "/personal/profile/",
							"SHOW_ERRORS" => "Y"
							)
						); ?>
						<? $APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "default_new", Array(
								"PATH_TO_BASKET" => "/personal/cart/",
								"PATH_TO_ORDER" => "/personal/order/make/",
								"SHOW_DELAY" => "Y",
								"SHOW_NOTAVAIL" => "Y",
								"SHOW_SUBSCRIBE" => "N"
							)
						); ?>
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
											"MENU_CACHE_USE_GROUPS" => "Y",
											"MENU_CACHE_GET_VARS" => "",
										)
									); ?>
								<? endif ?>
							</div></div>
						</div>
				</div></div>
				
			</div>
		</div>
		
		<style>
	


		</style>
		
	<script>	
	if(screen.width <= 700){
  document.querySelector('.aim_catalog').classList.remove('aim_catalog');
}
	</script>	
</header>
<?}else{?>

    <? $APPLICATION->IncludeComponent("bitrix:menu", "header_mobile", Array(
            "ROOT_MENU_TYPE" => "top",
            "MAX_LEVEL" => "3",
            "CHILD_MENU_TYPE" => "top_child_mobile",
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "N",
            "MENU_CACHE_TYPE" => "Y",
            "MENU_CACHE_TIME" => "36000000",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_CACHE_GET_VARS" => "",
        )
    ); ?>
    <header class="header">
        <div class="container">
            <div class="header__top_tel">
                <div class="header__top_tel_block">
                    <div class="header__top_tel_link">
                        <a href="tel:88002349420">8 (800) 234-94-20</a>                    
                    </div>
                    <div class="header__top_tel_block_text">
                        <div class="tel_block_text">
                            <div><span class="tel_text_left">Салон на Варварке:</span> <a href="tel:+74952343443" class="tel_text_right">+7 (495) 234-34-43</a></div>
                            <div><span class="tel_text_left">Салон на Волоколамском шоссе:</span> <a href="tel:+74954901420" class="tel_text_right">+7 (495) 490-14-20</a></div>
                            <div><span class="tel_text_left">Салон на Ленинском Проспекте:</span> <a href="tel:+74956512500" class="tel_text_right">+7 (495) 651-25-00</a></div>
                            <div><span class="tel_text_left">Салон в г. Люберцы:</span> <a href="tel:+74955542240" class="tel_text_right">+7 (495) 554-22-40</a></div>
                            <div><span class="tel_text_left">Интернет-магазин:</span> <a href="tel:88002349420" class="tel_text_right">8 (800) 234-94-20</a></div>
                            
                        </div>
                        <div class="tel_block_title">
                            <span>Телефоны салонов</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header__top">
                <div class="header__lang">
                    <a href="/" class="active"><?= GetMessage('TITLE_LANG_RUS') ?></a>
                    <a href="/en/">english</a>
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
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"COMPONENT_TEMPLATE" => "w_icons"
	),
	false
); ?>
                </div>
                <div class="header__logo">
                    <a href="/" class="logo"></a>
                </div>
                <div class="header__middle--right">
                
                    <div class="header__search">
                        <div class="search-toggle field-search">
                            <div class="button-search"><p>Поиск</p><span class="icon-search symbol-search"></span></div>                            
                            <span class="icon-search new-icon-search" title="Поиск"></span>                            
                        </div>

                            <form class="form__search smart_search" action="/search/">
                                <input id="smart_search_query" type="text" class="input_inside" name="q" value="" size="15" placeholder="Поиск по сайту" maxlength="50">
                                <button class="btn__search" type="submit" name="s" title="Найти">
                                    <span class="icon-search"></span>
                                </button>
                                <?  $arSearchSection = getSearchSection();
                                $curSearchSection = 0;
                                if(!empty($_REQUEST["section"]) && array_key_exists($_REQUEST["section"],getSearchSection()))
                                    $curSearchSection = intval($_REQUEST["section"]);
                                ?>
                                <ul class="category_list">
                                    <li><input type="radio" name="section" value="0" id="section_search_0" <?if(!$curSearchSection):?>checked="checked"<?endif;?> class="no_check"><label for="section_search_0">Везде</label></li>
                                    <?foreach($arSearchSection as $key=>$value):?>
                                        <li><input type="radio" name="section" value="<?=$key?>" id="section_search_<?=$key?>" <?if($curSearchSection==$key):?>checked="checked"<?endif;?> class="no_check"><label for="section_search_<?=$key?>"><?=$value?></label></li>
                                    <?endforeach;?>
                                </ul>

                                <div class="items_list">
                                    <div class="s_title show_result inv">Товары</div>
                                    <div class="s_inner show_result inv"></div>
                                    <button class="s_send show_result inv" type="submit" name="s" title="Показать все результаты">Показать все результаты</button>
                                    <div class="no_result inv">Не найдены результаты по вашему запросу</div>
                                </div>
                                <div class="clear"></div>

                                <a class="form__search_close" href=""><span class="icon-close"></span></a>
                            </form>

                        <? /*if($_GET['t'] == 'y'): ?>
                        <? else: ?>

                            <form class="form__search" action="/search/">
                                <input type="text" class="input_inside" name="q" value="" size="15"
                                       placeholder="Поиск по сайту" maxlength="50">
                                <button class="btn__search" type="submit" name="s" title="Найти">
                                    <span class="icon-search"></span>
                                </button>
                                <?  $arSearchSection = getSearchSection();
                                $curSearchSection = 0;
                                if(!empty($_REQUEST["section"]) && array_key_exists($_REQUEST["section"],getSearchSection()))
                                    $curSearchSection = intval($_REQUEST["section"]);
                                ?>
                                <ul>
                                    <li><input type="radio" name="section" value="0" id="section_search_0" <?if(!$curSearchSection):?>checked="checked"<?endif;?> class="no_check"><label for="section_search_0">Везде</label></li>
                                    <?foreach($arSearchSection as $key=>$value):?>
                                        <li><input type="radio" name="section" value="<?=$key?>" id="section_search_<?=$key?>" <?if($curSearchSection==$key):?>checked="checked"<?endif;?> class="no_check"><label for="section_search_<?=$key?>"><?=$value?></label></li>
                                    <?endforeach;?>
                                </ul>
                                <a class="form__search_close" href=""><span class="icon-close"></span></a>
                            </form>

                        <? endif*/ ?>
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
	
	<nav class="navbar aim_menu" role="navigation">
        <div class="container">
            <? $APPLICATION->IncludeComponent("bitrix:menu", "aim_menu", Array(
                    "ROOT_MENU_TYPE" => "top",
                    "MAX_LEVEL" => "4",
                    "CHILD_MENU_TYPE" => "top_child",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => "",
                )
            ); ?>
            <? if(strpos($APPLICATION->GetCurPage(false), '/internet_shop/') === false): ?>
                <? $APPLICATION->IncludeComponent("bitrix:menu", "header_catalog", Array(
                        "ROOT_MENU_TYPE" => "top_child",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "N",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_CACHE_TYPE" => "Y",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => "",
                    )
                ); ?>
            <? endif ?>
        </div>
    </nav>

    <? /* ?>
        <nav class="navbar" role="navigation">
            <div class="container">
                <? $APPLICATION->IncludeComponent("bitrix:menu", "header", Array(
                        "ROOT_MENU_TYPE" => "top",
                        "MAX_LEVEL" => "2",
                        "CHILD_MENU_TYPE" => "top_child",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_CACHE_TYPE" => "Y",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => "",
                    )
                ); ?>
                <? $APPLICATION->IncludeComponent("bitrix:menu", "header_catalog", Array(
                        "ROOT_MENU_TYPE" => "top_child",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "N",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_CACHE_TYPE" => "Y",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => "",
                    )
                ); ?>
            </div>
        </nav>
    <? */ ?>
<?}?>
    

    <div class="main__inner">
    <?if( $curPage == '/' || $curPage == '/index2.php' ){
		?>
		<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"slider_full.main", 
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
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "57",
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
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	),
	false
);?>
		<?
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
        <div class="container">
            <div class="static-page"><?

                if ($curPage !== '/') {
					
					if($str[1]=='services' || $str[1]=='services2' || $str[1]=='services_centers' || $str[2]=='it-is-interesting'|| $str[1]=='articles'|| $str[1]=='news'){}else{
                    ?>
		<?if($_REQUEST['newhead']!='Y'){?>			
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
		<?}else{?>
		
		<?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"PATH" => "",
		"SITE_ID" => "s1",
		"START_FROM" => $start_level
	),
	false
);?>
		<?}?>
                    <? if(strpos($APPLICATION->GetCurPage(false), '/internet_shop/') !== 0 && $str[1]!='optovik'): ?>
                        <?php if ($APPLICATION->GetCurPage() != '/personal/profile/' && $_GET['forgot_password'] != 'yes'): ?>
                            <? if(strpos($APPLICATION->GetCurPage(false), '/ajax/') !== 0): ?>
                                <div class="title-page">
                                    <h1 class="js-page-title"><? exCSite::ShowH1(); //$APPLICATION->ShowTitle() ?></h1>
                                </div>
                            <?php endif ?>
                        <?php endif ?>
                    <? endif ?>
                    <?/*if(strstr($curPage, '/internet_shop/') || CSite::InDir('/search/')) {
						$start_level = 0;
						if(strstr($curPage, '/internet_shop/')) $start_level = 1;
					 $APPLICATION->IncludeComponent(
                        "bitrix:breadcrumb",
                        "",
                        Array(
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => "",
                            "SITE_ID" => "s1",
                            "START_FROM" => $start_level
                        )
                    );}*/?>
                    
                    <?
                }
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
