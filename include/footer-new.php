<link href="/local/templates/kolchuga_2016/css/footer.css?<?=time()?>" type="text/css"  rel="stylesheet" />
<link href="/local/templates/kolchuga_2016/css/font-awesome/css/font-awesome.css" type="text/css"  rel="stylesheet" />

<?
$arFile = \Kolchuga\Pict::getWebpImgSrc("/local/templates/kolchuga_2016/images/new-footer-img/foot-bg.png", $intQuality = 90)
?>
<footer class="footer footer-new" style="background-image: url(<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>)" data-bg="<?=$arFile['DETAIL_PICTURE']['SRC']?>" data-bg-webp="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
<div class="footer__container">
        <!--<div class="footer__top">
            <?require($_SERVER['DOCUMENT_ROOT']."/include/podp-new/templates.php");?>
        </div>

<div class="footer__top">
            <?require($_SERVER['DOCUMENT_ROOT']."/include/podp-new/new.php");?>
        </div>-->


		<div class="footer-menu dflex">
			<div class="footer__middle footer-menu ">
				<div class="footer-menu-item">
					<div class="footer__middle_header">Покупателям</div>
					<p class="footer__middle_p"><a href="/contacts/">Контакты</a></p>
                                        <p class="footer__middle_p"><a href="/o-kompanii/requisites.php">Реквизиты оружейных салонов</a></p>
					<p class="footer__middle_p"><a href="/information/dostavka.php">Доставка</a></p>
					<p class="footer__middle_p"><a href="/sposoby-oplaty/">Оплата</a></p>
					<p class="footer__middle_p"><a href="/information/usloviya-vozvrata.php">Обмен и возврат</a></p>
					<p class="footer__middle_p"><a href="/information/rezerv-grazhdanskogo-oruzhiya-i-patronov.php">Резерв гражданского оружия</a></p>
					<p class="footer__middle_p"><a href="/weapons_salons/legislative-base/">Законодательная база</a></p>
					<p class="footer__middle_p"><a href="/information/chasto-zadavaemye-voprosy.php">Часто задаваемые вопросы</a></p>
				</div>
				<div class="footer-menu-item">
					<div class="footer__middle_header">О компании</div>
					<p class="footer__middle_p"><a href="/o-kompanii/">О нас</a></p>
					<p class="footer__middle_p"><a href="/services/">Услуги</a></p>
					<p class="footer__middle_p"><a href="/programma-loyalnosti/">Программы лояльности</a></p>
					<p class="footer__middle_p"><a href="/services/servisnye-tsentry-po-remontu-i-obsluzhivaniyu-oruzhiya/">Сервисное обслуживание</a></p>
					<p class="footer__middle_p"><a href="/o-kompanii/dealers/">Дилеры</a></p>
					<p class="footer__middle_p"><a href="/weapons_salons/vacancies/">Вакансии</a></p>
					<p class="footer__middle_p"><a href="/information/politika-konfidentsialnosti.php">Политика конфиденциальности</a></p>
					<p class="footer__middle_p"><a href="/sitemap/">Карта сайта</a></p>
					<div class="footer__social">
						<? $APPLICATION->IncludeComponent("bitrix:main.include", "template22", Array(
						"AREA_FILE_SHOW" => "file",	// Показывать включаемую область
						"AREA_FILE_SUFFIX" => "inc",
						"COMPONENT_TEMPLATE" => ".default",
						"EDIT_TEMPLATE" => "",	// Шаблон области по умолчанию
						"PATH" => SITE_DIR."/include_content/social_icons_new2.php",	// Путь к файлу области
					),
						false
					); ?>
					</div>
				</div>
			</div>
			<div class="footer__middle footer-menu dflex">
				<div class="footer-menu-item">
					<div class="footer__middle_header">Скидки и новости</div>
					<?require($_SERVER['DOCUMENT_ROOT']."/include/podp-new/templates.php");?>
				</div>
				<div class="footer-menu-item l-hide">
					<div class="footer__middle_header">Преимущества</div>
					<p class="footer__middle_p">Лучшие оружейные бренды</p>
					<p class="footer__middle_p">Доставка по всей России</p>
					<p class="footer__middle_p">Выбор удобного способа оплаты</p>
					<?/* <p class="footer__middle_p">Cамовывоз</p> */?>
					<p class="footer__middle_p">Консультация специалиста</p>
					<p class="footer__middle_p">Гарантия качества</p>
					<p class="footer__middle_p">Сервисное обслуживание</p>
					
				</div>
			</div>
		 </div>

        <!--<div class="footer__bottom">
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
        </div>-->
		<div style="color:#ffffff;font-size:0.8em;text-align:center;padding-top:1em;">Обращаем ваше внимание на то, что вся представленная на сайте информация, касающаяся технических характеристик (цвет, внешний вид, комплектация и прочие), наличия на складе, стоимости товаров, носит информационный характер и ни при каких условиях не является публичной офертой, определяемой положениями Статьи 437(2) Гражданского кодекса РФ.</div>
		<div style="color:#ffffff;font-size:0.8em;text-align:center;padding-top:1em;">На сайте kolchuga.ru используются материалы с возрастным ограничением <span style="font-size:1.2em;">18+</span>. Продолжая оставаться на сайте вы подтверждаете, что вам исполнилось 18 лет.</div>
    </div>
</footer>