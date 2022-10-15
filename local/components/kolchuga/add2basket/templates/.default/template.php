<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="add2basket_price-buy">
    <div class="add2basket_price-buy_wrapper">
        <?
        $intCounter = 0;
        $commonAmount = 0;

        foreach ($arResult['ITEMS'] as $arItem):

            $commonAmount = $commonAmount + $arItem['QUANTITY'];

            if ($arItem['QUANTITY'] < 2 || $arItem['CAN_BUY'] != 'Y')
                continue; ?>
            <? if ($arItem['RAZMER_CURRENT']): ?>
            <div class="add2basket_price-buy_offer js-add2basket_price-buy_offer"
                 data-product="<?= $arItem['ID'] ?>"
                <?= ($arItem['QUANTITY'] > 0 && $arItem['CAN_BUY'] == 'Y') ? '' : 'disabled' ?>><?= $arItem['RAZMER_CURRENT'] ?></div>
        <? else: ?>
            <div class="js-add2basket_price-buy_offer _selected"
                 data-product="<?= $arItem['ID'] ?>"
                <?= ($arItem['QUANTITY'] > 0 && $arItem['CAN_BUY'] == 'Y') ? '' : 'disabled' ?>></div>
        <? endif;

            $intCounter++;
            ?>
        <? endforeach ?>
    </div>

    <div class="add2basket_notification">Выберите размер</div>

    <? if ($intCounter): ?>
        <a class="add2basket_price-buy_button js-add2basket_price-buy_button">В корзину</a>
    <? elseif ($commonAmount): ?>
        
    <? else: ?>
        <a class="add2basket_price-not_available">Нет в наличии</a>
    <? endif ?>
</div>
