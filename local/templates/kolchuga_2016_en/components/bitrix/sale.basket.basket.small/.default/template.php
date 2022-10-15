<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$sum = 0;
$q = 0;
$delay = 0;
$delay_items = array();

foreach ($arResult['ITEMS'] as $arItem) {
    if ($arItem['DELAY'] == 'N' && $arItem['CAN_BUY'] == 'Y') {
        $sum += floatval($arItem['PRICE']) * $arItem['QUANTITY'];
        $q += intval($arItem['QUANTITY']);
    } elseif($arItem['DELAY'] == 'Y'){
        $delay = $delay+ 1;
        $delay_items[] = $arItem['PRODUCT_ID'];
    }
}

if ($_REQUEST['ajax'] == 'Y' || $_REQUEST['type'] == 'ajax_basket_data') {
    $arParams['RESPONSE']['CART_PRICE'] = number_format($sum, 0, '', ' ') . ' руб.';
    $arParams['RESPONSE']['CART_COUNT'] = $q;
    $arParams['RESPONSE']['DELAY_COUNT'] = $delay;
    echo \Bitrix\Main\Web\Json::encode($arParams['RESPONSE']);
    die();
}?><ul>
    <li>
        <a href="<?= $arParams['PATH_TO_BASKET'] ?>" title="<?=GetMessage('BASKET_TITLE')?>">
            <span id="bid" class="icon-shopping-bag js-cart-count"><b><?=$q?></b></span>
        </a>
    </li>
    <li><a href="/personal/profile/"><span class="icon-user"></span></a></li>
    <li><a href="/personal/favorite/"><span class="icon-heart-o"><em class="js-fav-count"><?=$delay?></em></span></a></li>
</ul>