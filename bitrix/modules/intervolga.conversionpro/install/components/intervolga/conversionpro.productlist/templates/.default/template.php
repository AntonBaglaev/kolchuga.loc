<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

/** @var array $arResult */

if ($arResult['PRODUCTS'] && $arResult['PRODUCTS_JS']):?>
    <script type="text/javascript">
        (function () {
            window['conversionpro_products'] = window['conversionpro_products'] || {};
            var products = <?=$arResult['PRODUCTS_JS']?>;

            for(var i = 0; i<products.length; i++) {
                var product = products[i],
                    id = product['id'];
                if (!id) {
                    continue;
                }
                window['conversionpro_products'][id] = window['conversionpro_products'][id] || product;
            }
        })();
    </script>
<? endif; ?>