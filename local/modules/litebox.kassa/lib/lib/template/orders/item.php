<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 06.04.2018
 * Time: 10:36
 */

namespace litebox\kassa\lib\Template\Orders;


use litebox\kassa\lib\Template\GenerateData;

class Item extends GenerateData
{
    /** @var int $id Order item ID. Can be used to address the item in the order, e.g. to manage ordered items. */
    public $id;
    /** @var int $productId Store product ID */
    public $productId;
    /** @var int $categoryId ID of the category this product belongs to. If the product belongs to many categories, categoryID will return the ID of the default product category. If the product doesn’t belong to any category, 0 is returned */
    public $categoryId;
    /** @var int $price Price of ordered item in the cart */
    public $price;
    /** @var int $productPrice Basic product price without options markups, wholesale discounts etc. */
    public $productPrice;
    /** @var int $weight Product weight */
    public $weight;
    /** @var string $sku Product SKU. If the chosen options match a variation, this will be a variation SKU. */
    public $sku; //id главного товара, не предложения
    /** @var int $quantity Amount purchased */
    public $quantity;
    /** @var string $shortDescription Product description truncated to 120 characters */
    public $shortDescription;
    /** @var int $tax Tax amount applied to the item */
    public $tax;
    /** @var int $shipping Order item shipping cost */
    public $shipping;
    /** @var int $quantityInStock The number of products in stock in the store */
    public $quantityInStock;
    /** @var string $name Product name */
    public $name;
    /** @var bool $isShippingRequired true/false: shows whether the item requires shipping */
    public $isShippingRequired;
    /** @var bool $trackQuantity true/false: shows whether the store admin set to track the quantity of this product and get low stock notifications */
    public $trackQuantity;
    /** @var bool $fixedShippingRateOnly true/false: shows whether the fixed shipping rate is set for the product */
    public $fixedShippingRateOnly;
    /** @var string $imageUrl Product image URL */
    public $imageUrl;
    /** @var int $fixedShippingRate Fixed shipping rate for the product */
    public $fixedShippingRate;
    /** @var bool $digital true/false: shows whether the item has downloadable files attached */
    public $digital;
    /** @var bool $productAvailable true/false: shows whether the product is available in the store */
    public $productAvailable;
    /** @var bool $couponApplied true/false: shows whether a discount coupon is applied for this item */
    public $couponApplied;
    /** @var array Files $files Files attached to the order item */
    public $files; //??? object
    /** @var array OrderItemOption $selectedOptions Product options values selected by the customer */
    public $selectedOptions;//??? object
    /** @var array $taxes Taxes applied to this order item */
    public $taxes; //object
    /** @var object $dimensions Product dimensions info */
    public $dimensions;//object
    /** @var int $couponAmount Coupon discount amount applied to item. Provided if discount applied to order. Is not recalculated if order is updated later manually */
    public $couponAmount;
    /** @var array $discounts Discounts applied to order item 'as is’. Provided if discounts are applied to order (not including discount coupons) and are not recalculated if order is updated later manually */
    public $discounts;
    /** @var array $taxesOnShipping Taxes applied to shipping. null for old orders, [] for orders with taxes applied to subtotal only. Are not recalculated if order is updated later manually */
    public $taxesOnShipping;

    public $rules = [
        'id' => 'ID',
        'productId' => 'PRODUCT_ID',
        'categoryId' => 'categoryId',
        'price' => 'PRICE',
        'productPrice' => 'BASE_PRICE',
        'weight' => 'WEIGHT',
        'sku' => 'sku',
        'quantity' => 'QUANTITY',
        'shortDescription' => 'shortDescription',
        'tax' => 'VAT_RATE',
        'shipping' => '',
        'quantityInStock' => 'QUANTITY_STORE',
        'name' => 'ELEMENT_NAME',
        'isShippingRequired' => '',
        'trackQuantity' => 'QUANTITY_TRACE',
        'fixedShippingRateOnly' => '',
        'imageUrl' => 'imageUrl',
        'fixedShippingRate' => '',
        'digital' => '',
        'productAvailable' => '',
        'couponApplied' => 'couponApplied',
        'couponAmount' => 'DISCOUNT_PRICE',
        'discounts' => '',
    ];
}