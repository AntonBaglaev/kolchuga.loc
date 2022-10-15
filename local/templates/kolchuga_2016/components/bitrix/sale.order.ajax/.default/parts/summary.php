<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

    <div class="col-xxs-12 col-xs-6 col-sm-4 col-md-12 col-lg-6">
        <span class="total-price"><?=GetMessage("SOA_TEMPL_SUM_IT")?> <?=showPrice($arResult['ORDER_TOTAL_PRICE_FORMATED'])?></span>
    </div>
    <div class="col-xxs-12 col-xs-6 col-sm-8 col-md-12 col-lg-6">
        <a href="" class="btn btn-primary js-btn-checkout">Оформить заказ</a>
    </div>