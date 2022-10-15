</div>
<? $APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
    "AREA_FILE_SHOW" => "sect",
    "AREA_FILE_SUFFIX" => "sal",
    "AREA_FILE_RECURSIVE" => "N",
    "EDIT_TEMPLATE" => ""
),
    false,
    array(
        "ACTIVE_COMPONENT" => "Y"
    )
); ?>
</div>
</div>
</div>
</div>
</div>

<div class="botgal center">
    <div class="content">
        <? $APPLICATION->IncludeComponent(
            "bitrix:main.include",
            ".default",
            array(
                "AREA_FILE_RECURSIVE" => "Y",
                "AREA_FILE_SHOW" => "page",
                "AREA_FILE_SUFFIX" => "footer",
                "COMPONENT_TEMPLATE" => ".default",
                "EDIT_TEMPLATE" => ""
            ),
            false
        ); ?></div>
</div>

<?
if($APPLICATION->GetCurPage() == "/"){
    ?>
    <div class="botgal">
    <? $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "template9",
        array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => SITE_DIR . "include/gallery_bottom.php",
            "EDIT_TEMPLATE" => "",
            "COMPONENT_TEMPLATE" => "template9",
            "AREA_FILE_SUFFIX" => "inc"
        ),
        false
    ); ?>
    </div><?
}
?>

<div class="footer color_white">
    <div class="footer_body">

        <div class="footer-col">
            <div class="footer-header">ПОЛЕЗНАЯ ИНФОРМАЦИЯ</div>
            <? $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "footer",
                Array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "footer1",
                    "COMPONENT_TEMPLATE" => ".default",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(""),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "footer1",
                    "USE_EXT" => "N"
                )
            ); ?>
        </div>
        <div class="footer-col">
            <div class="footer-header">ПОКУПАТЕЛЯМ</div>
            <? $APPLICATION->IncludeComponent("bitrix:menu", "footer", array(
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "footer2",
                "COMPONENT_TEMPLATE" => ".default",
                "DELAY" => "N",
                "MAX_LEVEL" => "1",
                "MENU_CACHE_GET_VARS" => "",
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "ROOT_MENU_TYPE" => "footer2",
                "USE_EXT" => "N"
            ),
                false,
                array(
                    "ACTIVE_COMPONENT" => "Y"
                )
            ); ?>
        </div>


        <div class="footer-col">
            <div class="footer-header">КОНТАКТЫ</div>
            <div class="address">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR . "include/address.php",
                        "EDIT_TEMPLATE" => ""
                    ),
                    false
                ); ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="footer-dt">
            <div class="footer-dtc text-left">
                <div class="datai">
                    <a class="data_logo" href="http://www.datainlife.ru">
                        <img alt="" src="/images/datain.png">
                    </a>
                    <div class="databody">
                        <a href="http://www.datainlife.ru"></a><br/>
                        <a href="http://www.datainlife.ru"></a>
                    </div>
                </div>
            </div>
            <div class="footer-dtc text-center">
                <div class="copyright">
                    <? $APPLICATION->IncludeComponent("bitrix:main.include", "social", Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR . "include/copyright.php",
                        "EDIT_TEMPLATE" => "",
                    ),
                        false
                    ); ?>
                </div>
            </div>
            <div class="footer-dtc text-right">
                <div class="counters">
                    <? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR . "include/counters.php",
                        "EDIT_TEMPLATE" => "",
                    ),
                        false
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
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
</body>
</html>