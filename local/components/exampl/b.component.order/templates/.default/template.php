<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
$this->addExternalCss($templateFolder . '/css/custom.css?ver=' . time());
$_SESSION['ORDER_LOG'] = $_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/log/';

?>

<section class="order header">
    <div class="order__wrapper">
        <div class="logo">
            <a href="/">
                <img src="<?= $templateFolder ?>/images_delivery/logo.svg" alt="logo">
            </a>
        </div>
        <div class="time"><?= Loc::getMessage("time") ?></div>
        <div class="phone">
            <div class="soc-serv">
                <a class="callibri_phone" href="tel:<?= Loc::getMessage("phone") ?>"><?= Loc::getMessage("phone") ?></a><br>
                <div class="soc-item whatsapp">
                    <a href="https://chat.whatsapp.com/Js9dfMpWcrAIrzovmnlBZD">
                        <div></div>
                    </a>
                </div>
                <div class="soc-item telegramm">
                    <a rel="nofollow" href="https://t.me/rephon">
                        <div></div>
                    </a>
                </div>
                <div class="soc-item vk">
                    <a href="https://vk.com/rephon.store">
                        <div></div>
                    </a>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
        <div class="address">
            <a class="ta" href="/about/contacts/"><?= Loc::getMessage("address") ?></a>
        </div>
    </div>
</section>

<? if (!empty($arResult['BASKET_USER']['PRICE_TOTAL'])): ?>

    <section class="order">

        <div class="order__wrapper">
            <form class="order__form" action="" id="order_submit" novalidate>

                <input type="hidden" name="PATH_TO_AJAX" value="<?= $templateFolder . '/order_confrim.php' ?>">
                <input type="hidden" name="PATH_TO_BASKET" value="<?= $templateFolder . '/basket_update.php' ?>">
                <input type="hidden" name="PATH_TO_CITY" value="<?= $templateFolder . '/get_city.php' ?>">
                <input type="hidden" name="PATH_TO_DELIVERY_TODOOR"
                       value="<?= $templateFolder . '/get_delivery_todoor.php' ?>">
                <input type="hidden" name="PATH_TO_DELIVERY_TRANSPORT"
                       value="<?= $templateFolder . '/get_delivery_transport.php' ?>">
                <input type="hidden" name="PATH_TO_DELIVERY_PRICE"
                       value="<?= $templateFolder . '/get_delivery_price.php' ?>">
                <input type="hidden" name="PATH_TO_MAP" value="<?= $templateFolder . '/get_map.php' ?>">
                <input type="hidden" name="LOCATION_CITY" value="">
                <input type="hidden" name="LOCATION_CITY_ID" value="">
                <input type="hidden" name="DELIVERY_ADDRESS" value="">
                <input type="hidden" name="DELIVERY_ADDRESS_ID" value="">
                <input type="hidden" name="DELIVERY_STREET" value="">
                <input type="hidden" name="DELIVERY_STREET_ID" value="">
                <input type="hidden" name="DELIVERY_HOUSE" value="">
                <input type="hidden" name="DELIVERY_HOUSE_ID" value="">
                <input type="hidden" name="DELIVERY_DISTRICT" value="">
                <input type="hidden" name="DELIVERY_DISTRICT_ID" value="">
                <input type="hidden" name="DELIVERY_ID" value="">
                <input type="hidden" name="DELIVERY_TARIFFID" value="">
                <input type="hidden" name="PAY_SYSTEM_ID" value="">
                <input type="hidden" name="YA_DELIVERY_ID" value="">
                <input type="hidden" name="YA_POINT_ID" value="">
                <input type="hidden" name="YA_POINT_INFO" value="">

                <fieldset class="order-registration">
                    <h2 class="order-registration__title"><?= Loc::getMessage("title") ?></h2>
                    <span class="order-registration__text"><sup>*</sup><?= Loc::getMessage("registration") ?></span>
                    <div class="order-registration__container">

                        <div class="order-registration__data">
                            <label for="phone"
                                   class="order-registration__label"><sup>*</sup><?= Loc::getMessage("PHONE") ?></label>
                            <input id="phone" type="text" name="PROPERTY_PHONE"
                                   value="<?= $arResult['USER_INFO']['PHONE'] ?>" required>
                        </div>

                        <div class="order-registration__data">

                            <label class="order-registration__label"><sup>*</sup><?= Loc::getMessage("city") ?></label>
                            <input type="text" class="city-input" id="input-city" date-prev="" value="" required>
                            <div id="loader-city">
                                <img src="<?= $templateFolder ?>/images_delivery/loader.svg" alt="">
                            </div>

                            <div class="order-registration__list"></div>

                            <div class="deliver none">

                                <p class="deliver__title"><?= Loc::getMessage("deliver_title") ?></p>

                                <div class="deliver__wrapper">


                                    <div class="deliver__type" id="samovivoz">
                                        <input type="radio" name="delivery" id="pickup" value="pickup">
                                        <label for="pickup"><?= Loc::getMessage("pickup") ?></label>
                                    </div>


                                    <div class="deliver__type" id="dostavka">
                                        <input type="radio" name="delivery" id="courier" value="courier">
                                        <label class="courier-delivery"
                                               for="courier"><?= Loc::getMessage("courier_delivery") ?></label>
                                    </div>

                                    <div class="contacts-delivery none">
                                        <input type="text" id="suggest" placeholder="" required>
                                    </div>

                                    <div class="contacts-delivery none">
                                        <input type="text" name="HOUSE" placeholder="" required>
                                        <input type="text" name="DELIVERY_DATE" id="data" placeholder="" readonly>
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>

                                    <div class="contacts-delivery-result-todoor"></div>

                                    <div class="deliver__type" id="vidacha">
                                        <input type="radio" name="delivery" id="transport" value="delivery">
                                        <label for="transport"><?= Loc::getMessage("transport") ?></label>
                                    </div>

                                    <div class="contacts-delivery-result-transport"></div>

                                </div>

                                <div class="pay">
                                    <p class="pay__title"><?= Loc::getMessage("pay") ?></p>
                                    <div class="pay__wrapper">

                                        <? if (!empty($arParams['CASH_PAYMENT_ID'])): ?>

                                            <input type="radio" id="cash" name="payment"
                                                   data-payment="<?= $arParams['CASH_PAYMENT_ID'] ?>">
                                            <label for="cash"><?= Loc::getMessage("cash") ?></label>

                                        <? endif; ?>

                                        <? if (!empty($arParams['CARD_PAYMENT_ID'])): ?>

                                            <input type="radio" id="card" name="payment"
                                                   data-payment="<?= $arParams['CARD_PAYMENT_ID'] ?>">
                                            <label for="card"><?= Loc::getMessage("card") ?></label>

                                        <? endif; ?>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="order-registration__data">
                            <label for="name"
                                   class="order-registration__label"><sup>*</sup><?= Loc::getMessage("USER_LAST_NAME") ?>
                            </label>
                            <input type="text" id="user-last-name" name="USER_LAST_NAME"
                                   value="<?= $arResult['USER_INFO']['USER_LAST_NAME'] ?>" required>
                        </div>

                        <div class="order-registration__data">
                            <label for="name"
                                   class="order-registration__label"><sup>*</sup><?= Loc::getMessage("USER_NAME") ?>
                            </label>
                            <input type="text" id="user-name" name="USER_NAME"
                                   value="<?= $arResult['USER_INFO']['USER_NAME'] ?>" required>
                        </div>

                        <div class="order-registration__data">
                            <label for="name"
                                   class="order-registration__label"><sup>*</sup><?= Loc::getMessage("USER_SECOND_NAME") ?>
                            </label>
                            <input type="text" id="user-second-name" name="USER_SECOND_NAME"
                                   value="<?= $arResult['USER_INFO']['USER_SECOND_NAME'] ?>" required>
                        </div>

                        <div class="order-registration__data">
                            <label for="email"
                                   class="order-registration__label"><sup>*</sup><?= Loc::getMessage("EMAIL") ?></label>
                            <input type="text" id="email" name="PROPERTY_EMAIL"
                                   value="<?= $arResult['USER_INFO']['EMAIL'] ?>" required>
                        </div>

                        <div class="order-registration__data">
                            <label for="comment"
                                   class="order-registration__label"><?= Loc::getMessage("COMMENT") ?></label>
                            <textarea id="comment" cols="30" rows="6" name="PROPERTY_COMMENT"></textarea>
                        </div>

                    </div>
                </fieldset>

                <fieldset class="basket-goods">
                    <div class="basket-goods__wrapper">
                        <div class="basket-goods__items">
                            <h2 class="basket-goods__title"><?= Loc::getMessage("basket") ?></h2>

                            <div class="basket-goods__container"></div>

                        </div>
                        <h2 class="total-order__title"><?= Loc::getMessage("order") ?></h2>
                        <div class="total-order__wrapper">
                            <div class="total-order">
                                <span class="total-order__sum"><?= Loc::getMessage("sum") ?></span>
                                <span class="total-order__count"><?= number_format($arResult['BASKET_USER']['PRICE_TOTAL'], 2, '.', ' ') ?> р.</span>
                            </div>
                            <div class="total-order order-delivery none">
                                <span class="total-order__delivery"><?= Loc::getMessage("delivery") ?></span>
                                <span class="total-order__price"><?= number_format($arResult['BASKET_USER']['DELIVERY_TOTAL'], 2, '.', ' ') ?> р.</span>
                            </div>
                            <div class="total-price none">
                                <span class="total-price__title"><?= Loc::getMessage("total") ?></span>
                                <span class="total-price__count"><?= number_format($arResult['BASKET_USER']['PRICE_TOTAL'], 2, '.', ' ') ?> р.</span>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="submit-result"></div>

                <div class="order-button__container">
                    <input type="submit" value="Оформить заказ" class="order-button">
                </div>

            </form>
        </div>

        <div class="order-promo">
            <span class="order-promo__text"><?= Loc::getMessage("promo1") ?></span>
            <span class="order-promo__text"><?= Loc::getMessage("promo2") ?></span>
            <span class="order-promo__call"><?= Loc::getMessage("promo3") ?><a
                        href="tel:<?= Loc::getMessage("phone") ?>"><?= Loc::getMessage("phone") ?></a></span>
        </div>

    </section>

<? else: ?>

    <div class="container">
        <h1 class="caption"><?= Loc::getMessage("caption") ?></h1>
    </div>

<? endif; ?>

<div id="loader">
    <img src="<?= $templateFolder ?>/images_delivery/loader.svg" alt="">
</div>
