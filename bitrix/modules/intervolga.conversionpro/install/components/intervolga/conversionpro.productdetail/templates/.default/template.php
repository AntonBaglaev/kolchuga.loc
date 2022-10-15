<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

$productIds = $APPLICATION->IncludeComponent(
    "intervolga:conversionpro.productlist",
    "",
    Array(
        "ID" => array($arParams['ID']),
        "NAME" => array($arParams['NAME']),
        "PRICE" => array($arParams['PRICE']),
        "CURRENCY" => array($arParams['CURRENCY']),
    ),
    $component
);

if ($productIds && count($productIds)):
    $id = (int)array_shift($productIds); ?>
    <script type="text/javascript">
        (function () {
            window['conversionpro_detail'] = window['conversionpro_detail'] || [];
            window['conversionpro_detail'].push(<?=$id?>);

            BX.onCustomEvent('onConversionProDetailShown', [<?=$id?>]);
        })();
    </script>
<? endif; ?>