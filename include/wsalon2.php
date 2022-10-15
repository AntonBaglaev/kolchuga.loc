<?php
$storeList = \Kolchuga\StoreList::getListSalonProp();

\Bitrix\Main\Page\Asset::getInstance()->addCss('/include/css/wsalon.css');
?>

<section class="salons">

    <h2>Оружейные салоны «Кольчуга»</h2>

    <div class="salons-row">

        <? foreach ($storeList['STORE_LIST_ALL'] as $idsalon => $val): ?>
            <? if (in_array($idsalon, [631125, 705387])) continue; ?>

            <div class="salons-card">
                <div class="col d-flex flex-column position-static salons-card-body">
                    <h4><img src="/images/location.png"><a href="/weapons_salons/<?= $val['CODE'] ?>/"><?= $val['PROPERTY_DOP_NAME_VALUE'] ?></a></h4>

                    <? if (!empty($val['PROPERTY_PHONES_VALUE'])) { ?>
                        <div class="salons-card-title">Оружейный салон</div>
                        <div class="salons-card-phone"><a
                                    href="tel:<?= $val['E164_PHONE'] ?>"><?= $val['PROPERTY_PHONES_VALUE'] ?></a></div>
                        <div class="salons-card-info"><?= $val['PROPERTY_CLOCK_VALUE'] ?></div>
                    <? } ?>

                    <div class="salons-card-hr"></div>

                    <? if (!empty($val['PROPERTY_PHONES_SERVICE_VALUE'])) { ?>
                        <div class="salons-card-title">Сервисный центр</div>
                        <div class="salons-card-phone"><a
                                    href="tel:<?= $val['E164_PHONE_SERVICE'] ?>"><?= $val['PROPERTY_PHONES_SERVICE_VALUE'] ?></a>
                        </div>
                        <div class="salons-card-info"><?= $val['PROPERTY_MASTERSKAYA_VALUE'] ?></div>
                    <? } ?>

                    <div class="mb-auto"><br></div>

                    <div class="salons-card-footer">

                        <a href="https://yandex.ru/maps/?rtext=~<?= $val['PROPERTY_DOP_YANDEX_VALUE'] ?>"
                           target="_blank"><img src="/images/main-icon/gps.png"
                                                alt="<?= $val['PROPERTY_DOP_NAME_VALUE'] ?> Построить маршрут"><span>Построить маршрут</span></a>
                        <a href="whatsapp://send?phone=<?= $val['PROPERTY_WHATSAPP_PHONE_VALUE'] ?>"><img
                                    src="/images/svg/whatsapp-svgrepo-com.svg" style=" width: 30px;"><span>Написать в&nbsp;WhatsApp</span></a>
                        <a href="mailto:<?= $val['PROPERTY_E_MAIL_VALUE'] ?>"><img src="/images/main-icon/post.png"
                                                                                   alt="<?= $val['PROPERTY_DOP_NAME_VALUE'] ?> Отправить E-mail"><span>Отправить E-mail</span></a>

                    </div>
                </div>
            </div>

        <? endforeach ?>

    </div>

</section>
