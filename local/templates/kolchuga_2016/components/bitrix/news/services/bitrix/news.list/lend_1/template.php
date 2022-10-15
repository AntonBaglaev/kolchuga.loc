<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if ($arResult["ITEMS"][0]['SORT'] == 1) {
    $osnovnoy = $arResult["ITEMS"][0];
    unset($arResult["ITEMS"][0]);
    ?>

    <? CJSCore::Init(['popup']); ?>

    <div class="row pb-5">
        <div class="col-12 text-center pl-0 pr-0">
            <img src="/images/services_centers/service_page1.jpg" class="cover-top">
        </div>
    </div>
    <div class="row pb-5">
        <div class="container pb-5">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>Услуги сервисных центров «Кольчуга»</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <p>При каждом оружейном салоне «Кольчуга» действуют сервисные центры, располагающие развитым
                        материально-техническим оснащением. Прямые поставки и наличие оригинальных запчастей от
                        производителей позволяют оперативно решать большинство задач, связанных с гарантийным и
                        постгарантийным ремонтом оружия. </p>
                </div>
            </div>
            <div class="row">

                <div class="col-12 service_centers_divider"></div>

                <div class="col d-flex flex-column service_centers">
                    <div class="service_centers_title">ТК "БАРВИХА Luxury Village"</div>

                    <div class="service_centers_btn"><a href="javascript:void(0);" class="<?= $GLOBALS['USER']->IsAuthorized() ? 'js_get_sert' : 'js-open-auth' ?>" data-salon="barvikha">Оставить заявку</a></div>
                </div>
                <div class="col d-flex flex-column service_centers">
                    <div class="service_centers_title">ул. Варварка, 3 "Гостиный двор"</div>

                    <div class="service_centers_btn"><a href="javascript:void(0);" class="<?= $GLOBALS['USER']->IsAuthorized() ? 'js_get_sert' : 'js-open-auth' ?>" data-salon="varvarka">Оставить заявку</a></div>
                </div>
                <div class="col d-flex flex-column service_centers">
                    <div class="service_centers_title">Волоколамское шоссе, 86</div>

                    <div class="service_centers_btn"><a href="javascript:void(0);" class="<?= $GLOBALS['USER']->IsAuthorized() ? 'js_get_sert' : 'js-open-auth' ?>" data-salon="volokolamskoe">Оставить заявку</a></div>
                </div>
                <div class="col d-flex flex-column service_centers">
                    <div class="service_centers_title">Ленинский проспект, 44</div>

                    <div class="service_centers_btn"><a href="javascript:void(0);" class="<?= $GLOBALS['USER']->IsAuthorized() ? 'js_get_sert' : 'js-open-auth' ?>" data-salon="leninsky">Оставить заявку</a></div>
                </div>
                <div class="col d-flex flex-column service_centers">
                    <div class="service_centers_title">г. Люберцы, ул. Котельническая, 24А</div>

                    <div class="service_centers_btn"><a href="javascript:void(0);" class="<?= $GLOBALS['USER']->IsAuthorized() ? 'js_get_sert' : 'js-open-auth' ?>" data-salon="lyubertsy">Оставить заявку</a></div>
                </div>

            </div>

        </div>
    </div>
    </div>
    <div class="row pb-5">
        <div class="col-12 pl-0 pr-0">
            <div class="acor-container">
                <input type="checkbox" name="acor" id="acor1" class="no_check"/>
                <label for="acor1">
                    <img src="/images/services_centers/service_page2.jpg" class="cover-top">
                    <span class="">Кастомизация</span>
                </label>
                <div class="acor-body">
                    <div class="container pb-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="next_salon">
                                    <h2 class="text-center">Кастомизация</h2>
                                    <ul style="  margin: 0 auto;   display: table;">
                                        <li>Покрытие металлических деталей и стволов краской Dura Coat</li>
                                        <li><a href="voronenie-i-pokrytie-duracoat/">Воронение деталей и стволов
                                                оружия</a></li>
                                        <li><a href="ustanovka-pritselov/">Установка прицелов</a></li>
                                        <li>Установка открытых прицельных приспособлений</li>
                                        <li>Установка креплений</li>
                                        <li>Расточка ложи Blaser под Match или Semi Weight</li>
                                        <li>Лазерная гравировка по металлу</li>
                                        <li>Лазерная пайка антабки на ствол оружия</li>
                                        <li>Установка проставок регулировки приклада</li>
                                        <li> Удлинитель магазина на полуавтомат и помповые ружья</li>
                                        <li> Сошки, вензель, подствольный фонарь</li>
                                        <li> Регулировка питча и погиба приклада</li>
                                        <li> Замена приклада и цевья</li>
                                        <li> Замена затыльника</li>
                                        <li><a href="tyuning-oruzhiya/">Тюнинг оружия</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <input type="checkbox" name="acor" id="acor2" class="no_check"/>
                <label for="acor2">
                    <img src="/images/services_centers/service_page3.jpg" class="cover-top">
                    <span class="">Ремонт</span>
                </label>
                <div class="acor-body">
                    <div class="container pb-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="next_salon">
                                    <h2 class="text-center">Ремонт</h2>
                                    <ul style="  margin: 0 auto;   display: table;">
                                        <li>Диагностика неисправности оружия</li>
                                        <li><a href="remont-oruzhiya/">Ремонт и замена УСМ</a></li>
                                        <li> Регулировка, замена и ремонт газоотводного узла оружия</li>
                                        <li> Замена трубки и пружины магазина</li>
                                        <li> Замена деталей и узлов в пневматическом оружии и ОООП</li>
                                        <li> Локальная лазерная пайка по металлу</li>
                                        <li> Извлечение посторонних предметов из канала ствола</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <input type="checkbox" name="acor" id="acor3" class="no_check"/>
                <label for="acor3">
                    <img src="/images/services_centers/service_page4.jpg" class="cover-top">
                    <span class="">Обслуживание</span>
                </label>
                <div class="acor-body">
                    <div class="container pb-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="next_salon">
                                    <h2 class="text-center">Обслуживание и предпродажная подготовка</h2>
                                    <p class="text-center">По вашему желанию сотрудники сервисного центра проведут
                                        предпродажную подготовку выбранного вами нарезного, гладкоствольного или
                                        пневматического оружия.</p>
                                    <ul style="  margin: 0 auto;   display: table;">
                                        <li> Чистка основных узлов и деталей</li>
                                        <li> Обработка деревянных деталей</li>
                                        <li> Извлечение посторонних предметов из канала ствола</li>
                                        <li><a href="zatochka-nozhey/">Заточка холодного оружия и хозяйственно -
                                                бытового инвентаря</a></li>
                                        <li><a href="pristrelka-oruzhiya-i-optiki/">Пристрелка оптики (дневной, ночной,
                                                оптики на пневматическом оружии)</a></li>
                                        <li> Пристрелка тепловизионного прицела</li>
                                        <li> Пристрелка коллиматорного прицела</li>
                                        <li> Холодная пристрелка ружей</li>
                                        <li><a href="predprodazhnaya-podgotovka-i-obsluzhivanie/">Предпродажная
                                                подготовка и обслуживание</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <? if (!empty($osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'])) { ?>
                    <input type="checkbox" name="acor" id="acor4" class="no_check"/>
                    <label for="acor4">
                        <img src="/images/services_centers/service_page5.jpg" class="cover-top">
                        <img src="/images/services_centers/service_page6.png" class="logo_sc">
                        <span class="with_logo">Контакты сервисных центров</span>
                    </label>
                    <div class="acor-body">
                        <div class="container pb-5">
                            <div class="row">
                                <div class="col-12">

                                    <div class="next_salon text-center">


                                        <? foreach ($osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'] as $id) { ?>
                                            <div class='next_salon_item pb-5'>
                                                <? if ($id == 699777) { ?>
                                                    <h2>БАРВИХА LUXURY VILLAGE</h2>
                                                <? } else { ?>
                                                    <h2><?= $osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_ADDRESS_SRC'] ?></h2>
                                                <? } ?>

                                                        <? $arPhones = explode('доб.', $osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_PHONES_SERVICE_VALUE']); ?>

                                                        <a href="tel:<?= current($arPhones) ?>"><?= $osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_PHONES_SERVICE_VALUE'] ?></a><br>
                                                Часы
                                                работы: <?= $osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_MASTERSKAYA_VALUE'] ?>
                                                <? if (!empty($osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_DOP_DESCRIPTION_VALUE'])) {
                                                    ?>
                                                    <br><?= $osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_DOP_DESCRIPTION_VALUE']['TEXT'] ?>
                                                    <?
                                                } ?>
                                            </div>
                                        <? } ?>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>


	<style>
	.cover{object-fit:cover;object-position:center;width:100%}
	.cover-top{object-fit:cover;object-position:center top;width:100%}
	.cover-left{object-fit:cover;object-position:left center;width:100%}
	.contain{object-fit:contain;object-position:center;width:100%}
	
	.acor-container {
    margin: 20px 0;
}
.acor-container .acor-body {    
    height: 0;    
    line-height: 18px;    
    box-sizing: border-box;
    transition: color 0.5s, padding 0.5s;
    overflow: hidden;    
}
.acor-container .acor-body p {
    margin: 0 0 10px;
}
.acor-container label {
    cursor: pointer;    
    display: block;   
    width: 100%;
    font-weight: 300;
    box-sizing: border-box;
    z-index: 100;    
    font-size: 18px;
    margin: 0 0 5px;
    transition: color .35s;
	position:relative;
}
.acor-container label:hover {
    color: #FFF;
}
.acor-container label span {
    position: absolute;
    z-index: 3;
    left: 50%;
    transform: translate(-50%, -50%);
    top: 40%;
    font-size: 3em;
	color: #fff;
}
.acor-container input{
    display: none;
}

.acor-container input:checked + label {
   /*  background-color: #285f8f;
    color: #FFF;
    box-shadow: 0 8px 26px rgba(0,0,0,0.4), 0 28px 30px rgba(0,0,0,0.3); */
}

.acor-container input:checked + label + .acor-body {
    height: auto;
    
    color: #000;
    
}
.acor-container label .logo_sc{
	position: absolute;
    z-index: 1;
    left: 50%;
    width: 300px;
    transform: translate(-50%, 50%);
	top: 10%;
}
.acor-container label span.with_logo{
	top: 70%;
    white-space: nowrap;
}
.new_bread{display:none !important;}
.title-page{display:none;}
.scenter p{font-size:18px;line-height:34px;}
.acor-body ul li {font-size:18px;line-height:28px;}
.acor-container label {
    position: relative;
    padding-bottom: 34.9%;
    height: 0;
    overflow: hidden;
    display: block;
}
.acor-container label:after {
    overflow: hidden;
    position: absolute;
    top: 0;
    content: "";
    z-index: 100;
    width: 100%;
    height: 100%;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 1;
    pointer-events: none;
    background-color: rgba(33, 56, 94, 0.5);
    z-index: 1;
    border-radius: 0;
    visibility: visible;
}
.acor-container label:hover:after {
    visibility: hidden;
    opacity: 0;
    -webkit-transform: scale(0);
    -ms-transform: scale(0);
    transform: scale(0);
}

@media (max-width: 600px){
	.acor-container label span {
		font-size: 1.5em;
	}
	.acor-container label .logo_sc{
		width: 180px;
		top: 0;
		transform: translate(-50%, 25%);
	}
	.acor-container label span.with_logo{
		top: 70%;
		line-height: 1em;
		transform: translate(-50%, 0);
		left: 50%;
		text-align: center;
		font-size: 1em;
	}
}
	</style>
<script>
$(function () {
    $('.acor-container label').on('click', function (e) {
        var offset = $(this).next('.acor-body').offset();
        var heig = $(this).next('.acor-body').height();		
        if(offset && heig < 1) {
            $('html,body').animate({
                scrollTop: $(this).next('.acor-body').offset().top -20
            }, 500); 
        }
    }); 
});
</script>
<?}?>