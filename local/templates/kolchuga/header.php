<?//Filters used for goods on whole site
$GLOBALS['saleFilter'] = array(
	'PROPERTY_AKTSIYA_VALUE' => 'Да'
);

?>
<!DOCTYPE HTML>
<html>
<head>
    <title><? $APPLICATION->ShowTitle(); ?></title>

    <LINK REL="SHORTCUT ICON" href="/images/logo.ico" type="image/x-icon">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
    <meta http-equiv='Content-Type' content='text/html; charset=windows-1251'>
    <? $APPLICATION->ShowMeta("keywords") ?>
    <? $APPLICATION->ShowMeta("description") ?>
	<link rel="icon" href="/favicon.ico" type="image/x-icon">

    <link href='http://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>

	<?
		/* CSS */
		$APPLICATION->SetAdditionalCSS("/css/fonts.css");
		$APPLICATION->SetAdditionalCSS("/banner/flexslider.css");
		$APPLICATION->SetAdditionalCSS("/css/design_all.css");
	
		/* JS */
		use \Bitrix\Main\Page\Asset as Jsloader;

		Jsloader::getInstance()->addJs("/js/jquery.min.js");
		Jsloader::getInstance()->addJs("/js/cufon-yui.js");
		Jsloader::getInstance()->addJs("/js/adventure_400.font.js");
		Jsloader::getInstance()->addJs("/js/swfobject.js");
		Jsloader::getInstance()->addJs("/banner/jquery.flexslider.js");
		Jsloader::getInstance()->addJs("/js/jquery.jcarousel.min.js");
		Jsloader::getInstance()->addJs("/js/jquery.dropkick-1.0.0.js");
		//Jsloader::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery.sticky-kit.min.js");
		Jsloader::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/init.js");
		
		$APPLICATION->ShowHead();
	?>

	<?/*
		



<script type="text/javascript">
			$(document).ready(function () {
				//Cufon.replace('.adventure', {hover: 'true'});
			});
		</script>
		<script type="text/javascript" src="/js/jquery.tools.min.js"></script>
		<script type="text/javascript" src="/js/jquery/jquery.thickbox.js"></script>
		<link href="/css/thickbox.css" type="text/css" rel="stylesheet" /> -->
		<!-- <script src='/js/dsm.js'></script>
		<script src='/js/cookie.js'></script>
	*/?>

    <script>
        ;function BgChange(id, namesrc) {
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
    <!--[if lte IE 7]>
		<link href="/css/design_ie.css" type="text/css" rel="stylesheet">
    <![endif]-->
    <!--[if lt IE 9]>
		<script src="/js/html5.js"></script>
		<script src="/js/css3-mediaqueries.js"></script>
    <![endif]-->
</head>
<body>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter36451865 = new Ya.Metrika({
                    id:36451865,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/36451865" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
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
				<div class="header-inner">
					<div class="header-top">
						<div class="header-left">
							<ul class="header-ul-left">
								<li>
									<a href="/weapons_salons/gift_certificate/" title="Подарочный сертификат">
										<span class="icon-gift">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
											<span class="path4"></span>
										</span>
									</a>
								</li>
								<li>
									<a href="/weapons_salons/discount-program/" title="Дисконтная карта"><span class="icon-credit-card-alt"></span></a>
								</li>
								<li>
									<a href="/about_company/contacts.php" title="Контакты"><span class="icon-phone"></span></a>
								</li>
							</ul>
						</div>
						<div class="header-center text-center">
							<div class="logo">
								<a href="/" class="logo_company"></a>
							</div>
							<?/*<div class="content">
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
							</div>*/?>
						</div>
						<div class="header-right text-right">
							<div class="year18">18+</div>
							<div class="long">
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
							<ul class="header-ul-right">
								<li>
									<?$APPLICATION->IncludeComponent(
										"bitrix:search.form",
										"search_header",
										Array(
											"COMPONENT_TEMPLATE" => ".default",
											"PAGE" => "#SITE_DIR#internet_shop/",
											"USE_SUGGEST" => "N"
										)
									);?>
								</li>
								<?$APPLICATION->IncludeComponent(
									"bitrix:sale.basket.basket.line",
									"basketviewer_min",
									Array(
										"PATH_TO_BASKET" => "/internet_shop/basket/",
										"PATH_TO_PERSONAL" => "/internet_shop/the-order-of-the-goods/",
										"SHOW_PERSONAL_LINK" => "N"
									)
								);?>
							</ul>
						</div>
					</div>
					<? $APPLICATION->IncludeComponent("bitrix:menu", "top_menu",
						array(
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
					<?if(strstr($APPLICATION->GetCurPage(), '/internet_shop/')):?>	
						<div class="block_top_menu_child">
							<div class="block_menu_child_body">
								<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list","header_line",
									Array(
										"VIEW_MODE" => "TEXT",
										"SHOW_PARENT_NAME" => "Y",
										"IBLOCK_TYPE" => "",
										"IBLOCK_ID" => "40",
										"SECTION_ID" => "",
										"SECTION_CODE" => "",
										"SECTION_URL" => "/internet_shop/#SECTION_CODE_PATH#/",
										"COUNT_ELEMENTS" => "N",
										"TOP_DEPTH" => "1",
										"SECTION_FIELDS" => "",
										"SECTION_USER_FIELDS" => "",
										"ADD_SECTIONS_CHAIN" => "Y",
										"CACHE_TYPE" => "N",
										"CACHE_TIME" => 0,
										"CACHE_NOTES" => "",
										"CACHE_GROUPS" => "Y"
									)
								);?>
							</div>
						</div>
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
					<?else:?>
						<? $APPLICATION->IncludeComponent(
							"bitrix:menu", "top_menu_child",
							Array(
								"ROOT_MENU_TYPE" => "top_child",
								"MENU_CACHE_TYPE" => "N",
								"MENU_CACHE_TIME" => "3600",
								"MENU_CACHE_USE_GROUPS" => "Y",
								"MENU_CACHE_GET_VARS" => "",
								"MAX_LEVEL" => "1", 
								"CHILD_MENU_TYPE" => false,
								"USE_EXT" => "N",
								"DELAY" => "N",
								"ALLOW_MULTI_SELECT" => "N",
							),
							false,
							array(
								"ACTIVE_COMPONENT" => "Y"
							)
						);?>
					<?endif?>
				</div>
			</div>
		

            <div class="center">
                <div class="ov_hidden">
                    <? $APPLICATION->IncludeComponent("bitrix:menu", "left_child_menu2", Array(
                        "ROOT_MENU_TYPE" => "top_child3",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => "",
                        "MAX_LEVEL" => "1", 
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "N",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                    ),
                        false,
                        array(
                            "ACTIVE_COMPONENT" => "Y"
                        )
                    ); ?>
                    <div class="content">
                        <div>
                            <? if ($APPLICATION->GetCurPage() !== "/"){
                                echo '<h1 class="border_circl color_blue">';
                                $APPLICATION->ShowTitle();
                                echo '<i></i> <b></b></h1>';
                                
                                
                                if(strstr($APPLICATION->GetCurPage(), 'internet_shop')){
	                                $APPLICATION->IncludeComponent("bitrix:main.include","",Array(
											"AREA_FILE_SHOW" => "sect", 
											"AREA_FILE_SUFFIX" => "fs", 
											"AREA_FILE_RECURSIVE" => "Y", 
											"EDIT_TEMPLATE" => "" 
										)
									);
                                }
                            }   
                            ?>
                        </div>
						<?if($IS_CATALOG == 'Y'):?>
							<?$APPLICATION->IncludeComponent("bitrix:breadcrumb","",Array(
									"START_FROM" => "0", 
									"PATH" => "", 
									"SITE_ID" => "s1" 
								)
							);?>
						<?endif;?>
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