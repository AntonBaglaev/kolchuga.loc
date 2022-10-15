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
}?>
<div class="header__basket">

        <a href="<?= $arParams['PATH_TO_BASKET'] ?>" title="<?=GetMessage('BASKET_TITLE')?>">
            <span id="bid" ><svg width="27" height="27" viewBox="3 3 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11 27C9.4 27 8 28.3 8 30C8 31.7 9.3 33 11 33C12.7 33 14 31.7 14 30C14 28.3 12.7 27 11 27ZM2 3V6H5L10.4 17.4L8.4 21.1C8.2 21.5 8 22 8 22.5C8 24.2 9.4 25.5 11 25.5H29V22.5H11.6C11.4 22.5 11.2 22.3 11.2 22.1V21.9L12.6 19.5H23.8C24.9 19.5 25.9 18.9 26.4 18L31.8 8.3C31.9 8.1 32 7.8 32 7.6C32 6.7 31.3 6 30.5 6H8.3L6.9 3H2ZM26 27C24.3 27 23 28.3 23 30C23 31.7 24.3 33 26 33C27.6 33 29 31.7 29 30C29 28.3 27.7 27 26 27Z" fill="#21385E"/>
</svg></span>
        </a>
    
</div>