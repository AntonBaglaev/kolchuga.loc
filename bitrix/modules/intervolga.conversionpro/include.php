<?
/**
 * This file could not be declared with partner namespace due to MarketPlace issue.
 * You can declare classes here only with global namespace.
 * Support ticket #474133
 */

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

if (Loader::includeModule('sale') && Option::get("main", "~sale_converted_15", 'N') != 'Y') {
    \CAdminNotify::Add(Array(
        "MESSAGE" => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_NOT_CONVERTED'),
        "TAG" => "CONVERSIONPRO_NOT_CONVERTED",
        "MODULE_ID" => 'intervolga.conversionpro',
    ));

    return false;
}

if (Loader::includeModule('intervolga.conversion')) {
    \CAdminNotify::Add(Array(
        "MESSAGE" => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_NOT_COMPATIBLE'),
        "TAG" => "CONVERSIONPRO_NOT_COMPATIBLE",
        "MODULE_ID" => 'intervolga.conversionpro',
    ));

    return false;
}

/**
 * Polyfill for array_column
 * @param array $input
 * @param $columnKey
 * @param null $indexKey
 * @return array|bool
 */
function ivcp_array_column(array $input, $columnKey, $indexKey = null)
{
    if (function_exists('array_column')) {
        return array_column($input, $columnKey, $indexKey);
    }

    $array = array();
    foreach ($input as $value) {
        if (!array_key_exists($columnKey, $value)) {
            trigger_error("Key \"$columnKey\" does not exist in array");
            return false;
        }
        if (is_null($indexKey)) {
            $array[] = $value[$columnKey];
        } else {
            if (!array_key_exists($indexKey, $value)) {
                trigger_error("Key \"$indexKey\" does not exist in array");
                return false;
            }
            if (!is_scalar($value[$indexKey])) {
                trigger_error("Key \"$indexKey\" does not contain scalar value");
                return false;
            }
            $array[$value[$indexKey]] = $value[$columnKey];
        }
    }
    return $array;
}

class IntervolgaConversionProConverter
{
    const MODULE_ID = 'intervolga.conversionpro';

    /********************************************************************************
     * Cart & order methods
     ********************************************************************************/

    /**
     * Convert order to e-commerce action field array
     *
     * @param \Bitrix\Sale\Order $order
     * @return array
     * @throws \Bitrix\Main\Config\ConfigurationException
     */
    public static function orderToActionField(\Bitrix\Sale\Order $order)
    {
        if (!Loader::includeModule('sale')) {
            throw new \Bitrix\Main\Config\ConfigurationException(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                    array('#MODULE_NAME#' => 'sale'))
            );
        }

        $currency = $order->getCurrency();

        $tax = (float)$order->getTaxValue();
        $shipping = (float)$order->getDeliveryPrice();
        $revenue = (float)$order->getPrice();

        $actionField = array(
            'id' => $order->getField('ACCOUNT_NUMBER'),
            'revenue' => self::convertCurrency($revenue, $currency),
            'tax' => self::convertCurrency($tax, $currency),
            'shipping' => self::convertCurrency($shipping, $currency)
        );

        $affiliateId = (int)$order->getField('AFFILIATE_ID');
        if ($affiliateId > 0) {
            $affiliateFields = \CSaleAffiliate::GetByID($affiliateId);
            $affiliate = trim('[' . $affiliateId . '] ' . $affiliateFields['AFF_SITE']);
            $actionField['affiliation'] = $affiliate;
        }

        $discount = $order->getDiscount();
        $discount->calculate();
        $discountResult = $discount->getApplyResult();
        $coupons = array_keys($discountResult['COUPON_LIST']);
        if (count($coupons)) {
            $actionField['coupon'] = implode(',', $coupons);
        }

        $goalId = Option::get(self::MODULE_ID, 'order_goal');
        if ('' != $goalId) {
            $actionField['goal_id'] = $goalId;
        }

        array_walk($actionField, array('\IntervolgaConversionProConverter', 'removeQuotes'));

        return $actionField;
    }

    /**
     * Convert basket to product-array list
     *
     * @param \Bitrix\Sale\Basket $basket
     * @return array with basket item id as key
     * @throws \Bitrix\Main\Config\ConfigurationException
     */
    public static function basketToProductList(\Bitrix\Sale\Basket $basket)
    {
        if (!Loader::includeModule('sale')) {
            throw new \Bitrix\Main\Config\ConfigurationException(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                    array('#MODULE_NAME#' => 'sale'))
            );
        }

        $productIds = array();
        foreach ($basket->getBasketItems() as $basketItem) {
            /** @var \Bitrix\Sale\BasketItem $basketItem */

            $productIds[] = $basketItem->getProductId();
        }

        $discountResult = null;
        if (count($productIds)) {
            $basket->rewind(); // Discount calculation rises fatal error without it

            if (null !== $basket->getOrder()) {
                // Order discount
                $discount = $basket->getOrder()->getDiscount();
            } else {
                // Basket discount
                $discount = \Bitrix\Sale\Discount::loadByBasket($basket);
            }
            $discount->calculate();
            $discountResult = $discount->getApplyResult();
        }

        $enrichData = self::enrichProducts($productIds);

        $productList = array();
        foreach ($basket->getBasketItems() as $basketItem) {
            /** @var \Bitrix\Sale\BasketItem $basketItem */

            $product = self::basketItemToProduct($basketItem, $discountResult);
            $product = array_merge($product, $enrichData[$basketItem->getProductId()]);

            $productList[$basketItem->getId()] = $product;
        }

        array_walk($productList, array('\IntervolgaConversionProConverter', 'removeQuotes'));

        return $productList;
    }


    /**
     * Convert basket item to product-array
     *
     * @param \Bitrix\Sale\BasketItem $basketItem
     * @param array|null $discountResult
     * @return array|null
     * @throws \Bitrix\Main\Config\ConfigurationException
     */
    protected static function basketItemToProduct(\Bitrix\Sale\BasketItem $basketItem, $discountResult)
    {
        if (!Loader::includeModule('sale')) {
            throw new \Bitrix\Main\Config\ConfigurationException(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                    array('#MODULE_NAME#' => 'sale'))
            );
        }

        $product = array();

        $product['id'] = $basketItem->getProductId();
        if (0 === (int)$product['id']) {
            $product['name'] = trim($basketItem->getField('NAME'));
        } else {
            $product['name'] = '[' . $product['id'] . ']' . trim($basketItem->getField('NAME'));
        }

        $variants = array();
        foreach ($basketItem->getPropertyCollection() as $itemProperty) {
            /** @var \Bitrix\Sale\BasketPropertyItem $itemProperty */

            $code = $itemProperty->getField('CODE');
            if ('CATALOG.XML_ID' === $code || 'PRODUCT.XML_ID' === $code) {
                continue;
            }
            if ('' === trim($itemProperty->getField('VALUE'))) {
                continue;
            }

            $variants[] = trim($itemProperty->getField('VALUE'));
        }
        if (count($variants)) {
            $product['variant'] = implode('/', $variants);
        }

        $price = $basketItem->getPrice();

        /** @var \Bitrix\Sale\Basket $basket */
        $basket = $basketItem->getCollection();
        if (null !== $discountResult &&
            null === $basket->getOrder() &&
            array_key_exists('PRICES', $discountResult) &&
            array_key_exists('BASKET', $discountResult['PRICES']) &&
            array_key_exists($basketItem->getId(), $discountResult['PRICES']['BASKET']) &&
            array_key_exists('PRICE', $discountResult['PRICES']['BASKET'][$basketItem->getId()])
        ) {
            $price = $discountResult['PRICES']['BASKET'][$basketItem->getId()]['PRICE'];
        }
        $price = self::convertCurrency($price, $basketItem->getCurrency());
        if ($price) {
            $product['price'] = $price;
        }

        $product['quantity'] = $basketItem->getQuantity();

        if (null !== $discountResult && array_key_exists('ORDER', $discountResult)) {
            $coupons = array();

            foreach ($discountResult['ORDER'] as $discount) {
                if ('' === $discount['COUPON_ID']) {
                    continue;
                }

                if (!array_key_exists('RESULT', $discount) ||
                    !array_key_exists('BASKET', $discount['RESULT']) ||
                    !array_key_exists($basketItem->getId(), $discount['RESULT']['BASKET'])
                ) {
                    continue;
                }
                $coupons[] = $discount['COUPON_ID'];
            }

            if (count($coupons)) {
                $product['coupon'] = implode(',', $coupons);
            }
        }

        return $product;
    }

    /**
     * Convert iblock element list to product-array list
     *
     * @param array $elements with items like ('ID'=>'...', 'NAME'=>'...', 'PRICE'=>'...', 'CURRENCY'=>'...')
     * @return array
     */
    public static function catalogElementsToProducts(array $elements)
    {
        $products = array();
        foreach ($elements as $element) {
            $element['ID'] = (int)$element['ID'];
            if ($element['ID'] <= 0 && strlen($element['NAME']) <= 0) {
                continue;
            }

            $product = array();

            if ($element['ID'] > 0) {
                $product['id'] = $element['ID'];
            }
            if (strlen($element['NAME']) > 0) {
                $product['name'] = $element['NAME'];
                if ($element['ID']) {
                    $product['name'] = '[' . $element['ID'] . '] ' . $element['NAME'];
                }
            }
            if ($element['PRICE'] > 0 && strlen($element['CURRENCY'])) {
                $product['price'] = self::convertCurrency($element['PRICE'], $element['CURRENCY']);
            }

            $products[$element['ID']] = $product;
        }

        $enrichedProducts = array();
        $enrichData = self::enrichProducts(array_keys($products));
        foreach ($products as $id => $original) {
            $enrichedProducts[] = array_merge($products[$id], $enrichData[$id]);
        }

        array_walk($enrichedProducts, array('\IntervolgaConversionProConverter', 'removeQuotes'));

        return $enrichedProducts;
    }

    /********************************************************************************
     * Common methods
     ********************************************************************************/

    /**
     * Currencies supported by both Universal Analytics and Yandex.Metrka
     * @var array
     */
    protected static $supportedCurrencies = array('AUD', 'CAD', 'CHF', 'CNY', 'EUR', 'GBP', 'RUB', 'THB', 'TRY', 'UAH',
        'USD');

    /**
     * Currencies supported by both Universal Analytics & Yandex.Metrika and available in system
     * @return array
     */
    public static function availableCurrencies()
    {
        $availableCurrencies = array();
        if (Loader::includeModule('currency')) {
            $availableCurrencies = array_keys(\Bitrix\Currency\CurrencyManager::getCurrencyList());
        }

        return array_intersect($availableCurrencies, self::$supportedCurrencies);
    }

    /**
     * Return base currency code
     *
     * @return string
     * @throws \Bitrix\Main\Config\ConfigurationException
     */
    public static function baseCurrency()
    {
        if (!Loader::includeModule('currency')) {
            throw new \Bitrix\Main\Config\ConfigurationException(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                    array('#MODULE_NAME#' => 'currency'))
            );
        }

        $mainCurrency = Option::get(self::MODULE_ID, 'main_currency');
        if (!in_array($mainCurrency, self::availableCurrencies())) {
            throw new \Bitrix\Main\Config\ConfigurationException(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_MAIN_CURRENCY',
                    array('#CURRENCY#' => $mainCurrency))
            );
        }

        //        return \Bitrix\Currency\CurrencyManager::getBaseCurrency();
        return $mainCurrency;
    }


    /**
     * Convert price in some currency to price in base currency
     *
     * @param float|string $price source price
     * @param string $currency
     * @return float
     * @throws \Bitrix\Main\Config\ConfigurationException
     */
    protected static function convertCurrency($price, $currency)
    {
        if (!Loader::includeModule('currency')) {
            throw new \Bitrix\Main\Config\ConfigurationException(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                    array('#MODULE_NAME#' => 'currency'))
            );
        }

        $price = (float)$price;
        $baseCurrency = self::baseCurrency();

        if ($baseCurrency === $currency) {
            return $price;
        }

        return \CCurrencyRates::ConvertCurrency($price, $currency, $baseCurrency);
    }


    /**
     * Decode html-entities to unsafe but readable representation
     *
     * @param mixed $value
     */
    protected static function removeQuotes(&$value)
    {
        if (!is_string($value))
            return;

        // Triple kill!!!
        $value = html_entity_decode(
            html_entity_decode(
                html_entity_decode(
                    strip_tags($value)
                )
            )
        );
    }

    /**
     * Cached product metadata. Used by enrichProducts.
     *
     * @var array
     */
    protected static $productToIblock = array();

    /**
     * Enrich each product with brand and category path
     *
     * @param array $productIds like
     * @return array
     * @throws \Bitrix\Main\Config\ConfigurationException
     */
    protected static function enrichProducts(array $productIds)
    {
        if (!Loader::includeModule('iblock')) {
            throw new \Bitrix\Main\Config\ConfigurationException(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                    array('#MODULE_NAME#' => 'iblock'))
            );
        }
        if (!Loader::includeModule('catalog')) {
            throw new \Bitrix\Main\Config\ConfigurationException(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                    array('#MODULE_NAME#' => 'catalog'))
            );
        }

        $productIds = array_unique($productIds);
        $productsNoMeta = array_diff($productIds, array_keys(self::$productToIblock));

        if (count($productsNoMeta)) {
            $skuMeta = \CCatalogSKU::getProductList($productsNoMeta);
            $parentProductIds = ivcp_array_column($skuMeta, 'ID');

            $iblockElements = array();
            $query = \CIBlockElement::GetList(
                array(),
                array('=ID' => array_merge($productsNoMeta, $parentProductIds)),
                false,
                false,
                array('ID', 'NAME', 'IBLOCK_ID', 'IBLOCK_SECTION_ID')
            );
            while ($row = $query->GetNextElement()) {
                $element = $row->GetFields();
                $iblockElements[$element['ID']] = $element;

                $iblockElements[$element['ID']]['CATEGORY'] = self::getSectionPath($element['IBLOCK_ID'], $element['IBLOCK_SECTION_ID']);

                $iblockElements[$element['ID']]['NAME'] = $element['NAME'];

                $brandProperty = Option::get(self::MODULE_ID, 'iblock_' . $element['IBLOCK_ID'] . '_brand', '');
                if ('' == $brandProperty) {
                    continue;
                }

                $rawProperties = $row->GetProperties(false, array('CODE' => $brandProperty));
                $rawProperty = array_shift($rawProperties);
                if (is_array($rawProperty['VALUE']) && 0 === count($rawProperty['VALUE'])) {
                    continue;
                }
                if (!is_array($rawProperty['VALUE']) && 0 === strlen($rawProperty['VALUE'])) {
                    continue;
                }

                $displayProperty = \CIBlockFormatProperties::GetDisplayValue($element, $rawProperty, '');
                if (is_array($displayProperty['DISPLAY_VALUE'])) {
                    $displayProperty['DISPLAY_VALUE'] = implode('/', $displayProperty['DISPLAY_VALUE']);
                }
                $iblockElements[$element['ID']]['BRAND'] = strip_tags($displayProperty['DISPLAY_VALUE']);
            }

            foreach ($iblockElements as $id => $element) {
                $extracted = array('id' => $id);

                if (!array_key_exists($id, $skuMeta)) {
                    if ($element['NAME']) {
                        $extracted['name'] = '[' . $id . '] ' . $element['NAME'];
                    }
                    if ($element['BRAND']) {
                        $extracted['brand'] = $element['BRAND'];
                    }
                    if ($element['CATEGORY']) {
                        $extracted['category'] = $element['CATEGORY'];
                    }
                } else {
                    $parentId = $skuMeta[$id]['ID'];
                    if (!array_key_exists($parentId, $iblockElements)) {
                        continue;
                    }
                    $parent = $iblockElements[$parentId];

                    $extracted['id'] = $parentId;

                    if ($parent['NAME']) {
                        $extracted['name'] = '[' . $parentId . '] ' . $parent['NAME'];
                    }
                    if ($parent['BRAND']) {
                        $extracted['brand'] = $parent['BRAND'];
                    }
                    if ($parent['CATEGORY']) {
                        $extracted['category'] = $parent['CATEGORY'];
                    }
                }

                self::$productToIblock[$id] = $extracted;
            }
        }

        $result = array();
        foreach ($productIds as $productId) {
            $result[$productId] = self::$productToIblock[$productId];
        }

        return $result;
    }


    /**
     * Cached section paths. Used by getSectionPath.
     *
     * @var array
     */
    protected static $sectionToPath = array();

    /**
     * Generate category path, e.g. 'Cat 1/Cat 1.1/Cat 1.1.1'
     *
     * @param int $iblockId
     * @param int $sectionId
     * @return null|string
     * @throws \Bitrix\Main\Config\ConfigurationException
     */
    protected static function getSectionPath($iblockId, $sectionId)
    {
        if (!Loader::includeModule('iblock')) {
            throw new \Bitrix\Main\Config\ConfigurationException(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERROR_LOAD_MODULE',
                    array('#MODULE_NAME#' => 'iblock'))
            );
        }

        $iblockId = intval($iblockId);
        $sectionId = intval($sectionId);

        if (0 === $iblockId || 0 === $sectionId) {
            return null;
        }

        $requiredKey = $iblockId . '_' . $sectionId;
        if (!array_key_exists($requiredKey, self::$sectionToPath)) {
            self::$sectionToPath[$requiredKey] = null;

            $sections = array();
            $iblockSectionResult = \CIBlockSection::GetNavChain($iblockId, $sectionId, array('ID', 'NAME'));
            while ($p = $iblockSectionResult->GetNext()) {
                $sections[] = trim(str_replace('/', '|', $p['NAME']));

                $tmpKey = $iblockId . '_' . $p['ID'];
                self::$sectionToPath[$tmpKey] = implode('/', array_slice($sections, 0, 5));
            }
        }

        return self::$sectionToPath[$requiredKey];
    }
}


/**
 *          -g   click              Нажатие на товар (ссылку на товар)
 *      +y  +g   detail             Просмотр полного описания (карточки) товара
 *      +y  +g   add                Добавление одного или нескольких товаров в корзину
 *      +y  +g   remove             Удаление одного или нескольких товаров из корзины
 *          -g   checkout           Переход к оформлению покупки
 *          -g   checkout_option    Вариант, выбранный пользователем на определенном этапе оформления покупки
 *      +y  +g   purchase           Покупка одного или нескольких товаров (оформление заказа)
 *          -g   refund             Возврат одного или нескольких товаров
 *          -g   promo_click        Клик по внутренней рекламе
 *
 * array(
 *     'ecommerce' => array(
 *         'currencyCode' => 'RUB', //обязательное
 *         'detail' => array(
 *             'actionField' => array(
 *                 'list' => 'Основной каталог'
 *             ),
 *             'products' => array(
 *                 array(
 *                     'id' => '43521', //обязательное
 *                     'name' => 'Сумка Яндекс',
 *                     'brand' => 'Яндекс',
 *                     'category' => 'Аксессуары / Сумки',
 *                     'variant' => 'Цвет: Красный',
 *                     'price' => 654.32,
 *                     'quantity' => 2,
 *                     'coupon' => 'COUPON_15'
 *                 )
 *             )
 *         ),
 *         'add' => array(
 *             'products' => array(
 *                 array() //аналогично действию detail
 *             )
 *         ),
 *         'remove' => array(
 *             'products' => array(
 *                 array() //аналогично действию detail
 *             )
 *         ),
 *         'purchase' => array(
 *             'actionField' => array(
 *                 'id' => 'ORDER_987', //обязательное
 *                 'affiliation' => 'Волгоградский филиал',
 *                 'revenue' => 654.32,
 *                 'tax' => 12.11,
 *                 'shipping' => 10.2,
 *                 'coupon' => 'COUPON_15',
 *                 'goal_id' => '1234567'
 *             ),
 *             'products' => array(
 *                 array() //аналогично действию detail
 *             )
 *         )
 *     )
 * );
 *
 */

/**
 * Closing PHP tag should be here due to MarketPlace issue.
 * Remove anything after it (spaces, newlines), otherwise site check will fail.
 */
?>