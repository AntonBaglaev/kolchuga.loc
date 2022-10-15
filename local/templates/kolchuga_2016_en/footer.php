<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
                <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                    "AREA_FILE_SHOW" => "sect",
                    "AREA_FILE_SUFFIX" => "sal",
                    "AREA_FILE_RECURSIVE" => "N",
                    "EDIT_TEMPLATE" => ""
                    ),
                    false,
                    array(
                    "ACTIVE_COMPONENT" => "Y"
                    )
                );?><?

                if($curPage == '/')
                {
                    ?><?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "COMPONENT_TEMPLATE" => ".default",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => SITE_DIR."include_content/footer.php"
                        )
                    );?><?
                }
                if(strstr($curPage, '/personal/'))
                    echo '</div></div>';
            ?></div><!-- @end static-page -->
        </div><!-- @end container -->
    </div><!-- @end main__inner -->
    <footer class="footer">
        <div class="container">

            <div class="footer__top">
                <div class="footer__top--left">
                    <div class="footer__top--header"><?=GetMessage('TITLE_CUSTOMERS')?></div>
                    <div class="footer__top--body js-mh">
                        <? $APPLICATION->IncludeComponent("bitrix:menu", ".default", Array(
                                "ROOT_MENU_TYPE" => "footer_top",
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => false,
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
                </div>
                <div class="footer__top--right">
                    <div class="footer__top--header"><?=GetMessage('TITLE_CONTACTS')?></div>
                    <div class="footer__top--body js-mh">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"AREA_FILE_SHOW" => "file",
								"AREA_FILE_SUFFIX" => "inc",
								"COMPONENT_TEMPLATE" => ".default",
								"EDIT_TEMPLATE" => "",
								"PATH" => SITE_DIR."include_content/contacts.php"
							)
						);?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"AREA_FILE_SHOW" => "file",
								"AREA_FILE_SUFFIX" => "inc",
								"COMPONENT_TEMPLATE" => ".default",
								"EDIT_TEMPLATE" => "",
								"PATH" => SITE_DIR."include_content/social_icons.php"
							)
						);?>
                    </div>
                </div>
            </div>

            <div class="footer__middle">
                <div class="footer__middle--body">
                    <? $APPLICATION->IncludeComponent("bitrix:menu", ".default", Array(
                            "ROOT_MENU_TYPE" => "footer_middle",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => false,
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
            </div>

            <div class="footer__bottom">
                <div class="footer__bottom--left">
                    <ul class="footer__bottom-payments">
                        <li><img class="visa" src="<?=SITE_TEMPLATE_PATH?>/images/icon-visa.svg" alt="" width="56" height="18"></li>
                        <li><img class="mastercard" src="<?=SITE_TEMPLATE_PATH?>/images/icon-mastercard.svg" alt="" width="44" height="26"></li>
                        <li><img class="maestro" src="<?=SITE_TEMPLATE_PATH?>/images/icon-maestro.svg" alt="" width="44" height="26"></li>
                    </ul>
               </div>
                <div class="footer__bottom--center">
                    <div class="footer__bottom-copyrights">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"AREA_FILE_SHOW" => "file",
								"AREA_FILE_SUFFIX" => "inc",
								"COMPONENT_TEMPLATE" => ".default",
								"EDIT_TEMPLATE" => "",
								"PATH" => SITE_DIR."include_content/copyrights.php"
							)
						);?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div><!-- @end main -->
</body>
</html>
