<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?/*$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
    "AREA_FILE_SHOW" => "sect",
    "AREA_FILE_SUFFIX" => "sal",
    "AREA_FILE_RECURSIVE" => "N",
    "EDIT_TEMPLATE" => ""
),
    false,
    array(
        "ACTIVE_COMPONENT" => "Y"
    )
); ?><?

if($curPage == '/'){
    ?><? $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "COMPONENT_TEMPLATE" => ".default",
            "EDIT_TEMPLATE" => "",
            "PATH" => SITE_DIR . "en/include_content/footer.php"
        )
    ); ?><?
}*/?><?
/* if(strstr($curPage, '/personal/') && ($USER->GetID()!="11460"  && $_REQUEST['ps']!=22) ){
    echo '</div></div>';
}else*/ if(strstr($curPage, '/personal/')){ ?>
		</div>
			</div>
			<?if($USER->IsAuthorized()){?>
			<div class="col-lg-3 pr-lg-0">
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
			</div>
			<?}?>
		</div>
	</div>
</div>
<?}?>
<div class="clearfix"></div>
</div><!-- @end static-page -->
</div><!-- @end container -->
</div><!-- @end main__inner -->

<? $APPLICATION->IncludeFile( "/include/footer-new.php" ); ?>

</div><!-- @end main -->
<?php 
/*
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
<script type="text/javascript"> (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter36451865 = new Ya.Metrika({
                    id: 36451865,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true,
                    trackHash: true
                });
            } catch (e) {
            }
        });
        var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () {
            n.parentNode.insertBefore(s, n);
        };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks"); 
</script>
*/
?>
<?
    //if(!isset($_COOKIE['consultant_hide'])){
/* $APPLICATION->IncludeComponent("bitrix:form.result.new", "consultant_new", Array(
            "SEF_MODE" => "N",
            "WEB_FORM_ID" => 2,
            "LIST_URL" => "",
            "EDIT_URL" => "",
            "SUCCESS_URL" => "",
            "CHAIN_ITEM_TEXT" => "",
            "CHAIN_ITEM_LINK" => "",
            "IGNORE_CUSTOM_TEMPLATE" => "Y",
            "USE_EXTENDED_ERRORS" => "Y",
            "CACHE_TYPE" => "N",
            "CACHE_TIME" => "36000000",
            "SEF_FOLDER" => "/",
            "VARIABLE_ALIASES" => Array()
));*/
    //}

?>

<div id="toTops" >&#8682;</div>
<?if($APPLICATION->GetCurPage() !== '/'){?>
<?$APPLICATION->IncludeFile('/include/wasbanner.php', array(), array())?> 
<?}else{?>
<?$APPLICATION->IncludeFile('/include/wasbanner_index.php', array(), array())?> 
<?}?>
<?/* <script src="//web.webpushs.com/js/push/ec214847912f2e13bbf69efff8827a47_1.js" async></script> */?>
<?/*<script type="application/javascript" src="//cdn.callbackhunter.com/cbh.js?hunter_code=9b09f696dba79218f1b0504d442d5491" charset="UTF-8" async="true"></script>*/?>
<?if(!empty($_REQUEST['CHAT_NO'])){$_SESSION['CHAT_NO']=$_REQUEST['CHAT_NO'];}
		if(empty($_SESSION['CHAT_NO'])){?>
<script src="//cdn.callbackhunter.com/cbh.js?hunter_code=9b09f696dba79218f1b0504d442d5491" async></script>
		<?}?>
</body>
</html>