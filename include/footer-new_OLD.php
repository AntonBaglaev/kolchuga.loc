<link href="/local/templates/kolchuga_2016/css/footer.css" type="text/css"  rel="stylesheet" />
<link href="/local/templates/kolchuga_2016/css/font-awesome/css/font-awesome.css" type="text/css"  rel="stylesheet" />
<footer class="footer footer-new">
<div class="container">
        <div class="footer__top">
            <?require($_SERVER['DOCUMENT_ROOT']."/include/podp-new/templates.php");?>
        </div>

<div class="footer__top">
            <?require($_SERVER['DOCUMENT_ROOT']."/include/podp-new/new.php");?>
        </div>



        <div class="footer__middle">
            <div class="footer__middle_col3 footer__middle_col2">
                <div class="footer__middle_header">Покупателям</div>
                <p class="footer__middle_p"><a href="/o-kompanii/contacts.php">Контакты</a></p>
                <p class="footer__middle_p"><a href="/information/dostavka.php">Доставка</a></p>
                <p class="footer__middle_p"><a href="/sposoby-oplaty/">Оплата</a></p>
                <p class="footer__middle_p"><a href="/information/usloviya-vozvrata.php">Обмен и возврат</a></p>
                <p class="footer__middle_p"><a href="/information/rezerv-grazhdanskogo-oruzhiya-i-patronov.php">Резерв гражданского оружия</a></p>
                <p class="footer__middle_p"><a href="/weapons_salons/legislative-base/">Законодательная база</a></p>
                <p class="footer__middle_p"><a href="/information/chasto-zadavaemye-voprosy.php">Часто задаваемые вопросы</a></p>
            </div>
            <div class="footer__middle_col3 footer__middle_col2">
                <div class="footer__middle_header">О компании</div>
                <p class="footer__middle_p"><a href="/o-kompanii/">О нас</a></p>
                <p class="footer__middle_p"><a href="/services/">Услуги</a></p>
                <p class="footer__middle_p"><a href="/programma-loyalnosti/">Программы лояльности</a></p>
                <p class="footer__middle_p"><a href="/services_centers/">Сервисные центры</a></p>
                <p class="footer__middle_p"><a href="/o-kompanii/dealers/">Дилеры</a></p>
                <p class="footer__middle_p"><a href="/weapons_salons/vacancies/">Вакансии</a></p>
                <p class="footer__middle_p"><a href="/information/politika-konfidentsialnosti.php">Политика конфиденциальности</a></p>
                <p class="footer__middle_p"><a href="/sitemap/">Карта сайта</a></p>
            </div>
            <div class="footer__middle_col3 footer__middle_col1">
                <div class="footer__middle_header">Преимущества</div>
                <p class="footer__middle_p">Лучшие оружейные бренды</p>
                <p class="footer__middle_p">Доставка по всей России</p>
                <p class="footer__middle_p">Выбор удобного способа оплаты</p>
                <p class="footer__middle_p">Бесплатный самовывоз</p>
                <p class="footer__middle_p">Консультация специалиста</p>
                <p class="footer__middle_p">Гарантия качества</p>
                <p class="footer__middle_p">Сервисное обслуживание</p>
            </div>
        </div>

        <div class="footer__bottom">
            <div class="footer__bottom_col3">
                <? $APPLICATION->IncludeComponent("bitrix:main.include", "template22", Array(
	"AREA_FILE_SHOW" => "file",	// Показывать включаемую область
		"AREA_FILE_SUFFIX" => "inc",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_TEMPLATE" => "",	// Шаблон области по умолчанию
		"PATH" => SITE_DIR."/include_content/social_icons_new.php",	// Путь к файлу области
	),
	false
); ?>
            </div>
            <div class="footer__bottom_col3">
                <div class="footer_copy">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "COMPONENT_TEMPLATE" => ".default",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => SITE_DIR . "include_content/copyrights.php"
                        )
                    ); ?>
                </div>
            </div>
            <div class="footer__bottom_col3">
                <div class="footer__bottom-payments">
                    <div class="footer-paytitle">Мы принимаем</div>
                    <div class="footer-paybody">
                        <i class="fa fa-cc-visa" aria-hidden="true"></i>
                        <i class="fa fa-cc-mastercard" aria-hidden="true"></i>      
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>