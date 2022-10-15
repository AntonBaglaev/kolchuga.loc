<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php
use \Bitrix\Main\Localization\Loc as Loc;
$this->setFrameMode(true);
$this->addExternalJs($templateFolder . '/coutdown/jquery.countdown.min.js');
$this->addExternalJs($templateFolder . '/coutdown/jquery.countdown-ru.js');

?>

<div class="maxwidth-theme pb-80">

    <!--404-->

    <div class="page-404">
        <div class="row">
            <div class="col-md-6">
                <div class="page-404__left-block">
                    <img class="page-404__img" src="<?=$templateFolder . '/images/404.svg'?>" alt="">
                    <div class="page-404__title"><?= Loc::getMessage("TITLE") ?></div>
                    <div class="page-404__sub-text"><?= Loc::getMessage("SUB_TEXT") ?></div>
                    <? if(!empty($arResult['COUPON']) && !empty($arResult['TIME'])): ?>
                        <div class="page-404__text"><?= Loc::getMessage("TEXT") ?></div>
                    <? endif; ?>
                </div>
            </div>

            <? if(!empty($arResult['COUPON']) && !empty($arResult['TIME'])): ?>
                <div class="col-md-6">
                    <div class="page-404-promo" style="background-image: url(<?=$templateFolder . '/images/gift.svg'?>)">
                        <div class="page-404-promo__title"><?= Loc::getMessage("PROMO_TITLE") ?></div>
                        <div class="page-404-promo__text"><?= Loc::getMessage("PROMO_TEXT_1") ?><span class="font-weight-bold"><?= Loc::getMessage("PROMO_TEXT_2") ?></span><?= Loc::getMessage("PROMO_TEXT_3") ?></div>
                        <div class="page-404-promo__promo-block">
                            <div class="page-404-promo__promo"><?= Loc::getMessage("PROMOCODE") ?><span><?=$arResult['COUPON']?></span></div>
                            <a href="#" class="page-404-promo__copy js-btn-copy-to-clipboard" data-clipboard-text="<?=$arResult['COUPON']?>"><?= Loc::getMessage("COPY") ?></a>
                        </div>
                        <div class="page-404-promo__button-block">
                            <a href="/" class="btn page-404-promo__btn page-404-promo__btn-back"><?= Loc::getMessage("BACK") ?></a>
                            <a href="/catalog/" class="btn page-404-promo__btn page-404-promo__btn-catalog"><?= Loc::getMessage("CATALOG") ?></a>
                        </div>
                        <div class="page-404-promo__italic"><?= Loc::getMessage("TIMER") ?><span class="timer" data-timer="<?=$arResult['TIME']?>">...</span></div>
                    </div>
                </div>
            <? endif; ?>

        </div>
    </div>

    <!--Популярные категории-->

    <!--Популярные товары-->

</div>
