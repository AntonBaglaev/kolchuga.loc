<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$photo_ids = array();
if($arResult['DETAIL_PICTURE']['ID'] > 0)
    $photo_ids[] = $arResult['DETAIL_PICTURE']['ID'];

if(is_array($arResult['PROPERTIES']['MORE_PHOTO']['VALUE']))
    $photo_ids = array_merge($photo_ids, $arResult['PROPERTIES']['MORE_PHOTO']['VALUE']);
?>
    <div class="catalog__detail--item">
        <div class="catalog__detail--left">

            <div class="catalog__gallery">
                <? if(count($photo_ids) > 0): ?>
                    <div class="catalog__gallery--big">

                        <div id="slider" class="flexslider">
                            <ul class="slides popup-gallery">
                                <? foreach($photo_ids as $id):
                                    $orig =
                                        CFile::ResizeImageGet($id, array('width' => 1024, 'height' => 768), BX_RESIZE_IMAGE_PROPORTIONAL)['src'];
                                    $middle =
                                        CFile::ResizeImageGet($id, array('width' => 534, 'height' => 400), BX_RESIZE_IMAGE_PROPORTIONAL)['src']; ?>
                                    <li>
                                        <a href="<?= $orig ?>">
                                            <img src="<?= $middle ?>" alt="<?= $arResult['NAME'] ?>">
                                        </a>
                                    </li>
                                <? endforeach; ?>

                            </ul>
                        </div>
                    </div>
                    <div class="catalog__gallery--thumb">
                        <div id="carousel" class="flexslider">
                            <ul class="slides">
                                <? foreach($photo_ids as $id):
                                    $thumb =
                                        CFile::ResizeImageGet($id, array('width' => 112, 'height' => 85), BX_RESIZE_IMAGE_EXACT)['src'] ?>
                                    <li class="">
                                        <span><img src="<?= $thumb ?>" alt="<?= $arResult['NAME'] ?>"></span>
                                    </li>
                                <? endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {

                            //$('.b-filter__name').click(function(){
                            //$.fn.matchHeight._update($('.js-mh'));
                            //});

                            $('#carousel').flexslider({
                                animation: "slide",
                                controlNav: false,
                                animationLoop: false,
                                slideshow: false,
                                itemWidth: 126,
                                itemMargin: 0,
                                prevText: "",
                                nextText: "",
                                asNavFor: '#slider'
                            });

                            $('#slider').flexslider({
                                animation: "slide",
                                controlNav: false,
                                animationLoop: false,
                                slideshow: false,
                                prevText: "",
                                nextText: "",
                                sync: "#carousel"
                            });

                        });
                    </script>
                <? else: ?>
                    <div class="no-photo"></div>
                <? endif ?>
            </div>


        </div>
        <div class="catalog__detail--right">

            <div class="catalog__param">
                <div class="catalog__param--left">
                    <div class="catalog__param--title">Характеристики</div>
                    <ul>
                        <? foreach($arResult['DISPLAY_PROPERTIES'] as $prop):
                            if(!$prop['DISPLAY_VALUE'] || $prop['CODE'] == 'TREBUETSYA_LITSENZIYA') continue ?>
                            <li>
                                <em><?= $prop['NAME'] ?></em>
                                <b><?= is_array($prop['DISPLAY_VALUE']) ? implode(' / ', $prop['DISPLAY_VALUE']) : $prop['DISPLAY_VALUE'] ?></b>
                            </li>
                        <? endforeach; ?>
                    </ul>
                </div>
                <div class="catalog__param--right">
                    <div class="catalog__param--title">Наличие</div>
                    <ul>

                        <? foreach($arResult['STORES'] as $store): ?>
                            <li class="<?= $store['AMOUNT'] > 0 ? 'yes' : '' ?>"><a
                                    href="<?= $store['LINK'] ?>"><?= $store['NAME'] ?></a></li>
                        <? endforeach; ?>
                    </ul>
                </div>
            </div>


            <div class="catalog__option-list">
                <? /* Colors sku was canseled by client */
                /*if(count($arResult['SKU']) < 2):?>
                    <div class="catalog__option-list__item"><?//?><div>
                <?else:?>
                <div class="catalog__option-list__item">
                    <select name="SKU_COLOR" id="">
                        <option value="">Выбрать цвет</option>
                        <?foreach($arResult['SKU'] as $code => $items):?>
                        <option value="<?=$code?>"><?=$code?></option>
                        <?endforeach;?>
                    </select>
                </div>
                <?endif;*/
                /* check sizes */
                $check_sizes = array();
                foreach(reset($arResult['SKU']) as $item){
                    $check_sizes[] = $item['PROPERTY_RAZMER_VALUE'];
                }

                $check_sizes = array_unique($check_sizes);
                if(count($check_sizes) == 1 && $check_sizes[0] == ''){
                    $arResult['SKU'] = false;
                }

                if($arResult['SKU'] && $arResult['SKU_COUNT'] > 1): ?>
                <div class="catalog__option-list__item">
                    <select name="SKU_SIZE">
                        <option value="">Выбрать цвет</option>
                        <? foreach(reset($arResult['SKU']) as $code => $item): ?>
                            <option value="<?= $item['ID'] ?>"
                                    data-max="<?=$item['CATALOG_QUANTITY']?>"><?= $item['PROPERTY_RAZMER_VALUE'] ?></option>
                        <? endforeach; ?>
                    </select>
                    <? endif; ?>
                </div>
            </div>

            <div class="catalog__option-list__num">
                <span class="catalog__option-list__num__title">Количество</span>
            <span class="catalog__option-list__num__body">
                <input type="text"
                       name=""
                       class="js-q"
                       value="0"
                       data-max="<?= $arResult['CATALOG_QUANTITY'] ?>"
                >
            </span>
            </div>

            <div class="catalog__option-list__price">
                <div class="price__block">
                    <? if($arResult['MIN_PRICE']['VALUE'] > $arResult['MIN_PRICE']['DISCOUNT_VALUE']): ?>
                        <span class="old-price"><?= $arResult['MIN_PRICE']['PRINT_VALUE'] ?></span>
                    <?endif;
                    if($arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0):?>
                        <span class="discount">Скидка <?= $arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ?>%</span>
                    <? endif ?>
                    <span class="price"><?= $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></span>
                </div>
            </div>
            <? if($arResult['PROPERTIES']['TREBUETSYA_LITSENZIYA']['VALUE']): ?>
                <div class="catalog__license">
                    <div class="catalog__license__item">
                        <span>Только по лицензии</span>
                    </div>
                </div>
            <? endif ?>
            <div class="catalog__btn text-center">
                <noindex><a class="js-buy-btn btn btn-primary" href="#" data-id="<?=$arResult['ID']?>" rel="nofollow">Купить</a>
                </noindex>
                <div class="add-cart" style="display:none">
                    <div class="add-cart__inner">
                        <div class="add-cart__img"></div>
                        <div class="add-cart__body">
                            <div><b>Товар добавлен в корзину</b></div>
                            <div><a href="/personal/cart/">Оформить заказ</a></div>
                            <div><a class="hide-success" href="#">Продолжить покупки</a></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="catalog__detail--desc">
        <?= $arResult['DETAIL_TEXT'] ?>
    </div>

    <div class="catalog__detail--info">
        <p><img src="upload/detail_discount.jpg" alt=""></p>
        <p>С 23 марта в оружейных салонах «Кольчуга» действуют скидки. Сумма скидки для всех составляет 10%, для
            обладателей золотых карт - 20%*.</p>
        <p><strong>Цены на сайте указаны с учетом 10% скидки.</strong></p>
        <p>Акция действует во всех салонах «Кольчуга», а также в онлайн-магазине!** </p>
        <p>На оружие, стоимостью свыше 400 тысяч рублей, для всех покупателей в период акции действуют условия, как для
            обладателей золотых карт:
        </p>
        <ul>
            <li>Оружие от 400 000 до 1 000 000 рублей - 5%</li>
            <li>Оружие от 1 000 000 до 5 000 000 рублей - 3%</li>
            <li>Оружие, покупаемое по безналичному расчету от 2 000 000 рублей - 2%</li>
        </ul>
        <p><strong>Цены на оружие, стоимостью свыше 400 тысяч рублей указаны без учёта скидок.</strong></p>
        <p>* Скидки по данной акции не суммируются с дисконтными картами, со скидкой, предоставляемой в дни рождения, а
            так же на товары со скидкой по другим акциям.
            <br>**При оформлении онлайн-заказа со скидкой 20% укажите номер своей золотой карты. Наш менеджер свяжется с
            Вами для уточнения итоговой стоимости заказа с учётом скидки 20%.</p>
        <p>Удачной охоты!</p>
    </div>
