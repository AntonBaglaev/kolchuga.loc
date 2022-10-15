<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 09.04.2018
 * Time: 13:19
 */

namespace litebox\kassa\lib\Template\Products;

use litebox\kassa\lib\Template\Category\Category;
use litebox\kassa\lib\Template\GenerateData;

class Item extends GenerateData
{
    /** @var int $id Unique integer product identifier */
    public $id;
    /** @var string $sku Product SKU. Items with options can have several SKUs specified in the product variations. */
    public $sku;
    /** @var int $quantity Amount of product items in stock. This field is omitted for the products with unlimited stock */
    public $quantity;
    /** @var bool $unlimited true if the product has unlimited stock */
    public $unlimited;
    /** @var bool $inStock true if the product or any of its variations is in stock (quantity is more than zero) or has unlimited quantity. false otherwise. */
    public $inStock;
    /** @var string $name Product title */
    public $name;
    /** @var int $price Base product price */
    public $price;
    /** @var int $defaultDisplayedPrice Product price displayed in a storefront for logged out customer for default location (store location). May differ from the price value when the product has options and variations and the default variation’s price is different from the base product price. It also includes taxes */
    public $defaultDisplayedPrice;
    /** @var array $wholesalePrices Sorted array of wholesale price tiers (quantity limit and price pairs) */
    public $wholesalePrices;
    /** @var int $compareToPrice Product’s sale price displayed strike-out in the customer frontend Omitted if empty */
    public $compareToPrice;
    /** @var bool $isShippingRequired true if product requires shipping, false otherwise */
    public $isShippingRequired;
    /** @var int $weight Product weight in the units defined in store settings. Omitted for intangible products */
    public $weight;
    /** @var string $url URL of the product’s details page in the store */
    public $url;
    /** @var string $created Date and time of the product creation */
    public $created;
    /** @var string $updated Product last update date/time */
    public $updated;
    /** @var int $createTimestamp The date of product creation in UNIX Timestamp format, e.g 1427268654 */
    public $createTimestamp;
    /** @var int $updateTimestamp Product last update date in UNIX Timestamp format, e.g 1427268654 */
    public $updateTimestamp;
    /** @var int $productClassId Id of the class (type) that this product belongs to. 0 value means the product is of the default 'General’ class */
    public $productClassId;
    /** @var bool $enabled true if product is enabled, false otherwise. Disabled products are not displayed in the store front. */
    public $enabled;
    /** @var array $options A list of the product options. Empty ([]) if no options are specified for the product. */
    public $options;
    /** @var int $warningLimit The minimum 'warning’ amount of the product items in stock, if set. When the product quantity reaches this level, the store administrator gets an email notification. */
    public $warningLimit;
    /** @var bool $fixedShippingRateOnly true if shipping cost for this product is calculated as 'Fixed rate per item’ (managed under the “Tax and Shipping” section of the product management page in Ecwid Control panel). false otherwise. With this option on, the fixedShippingRate field specifies the shipping cost of the product */
    public $fixedShippingRateOnly = false;
    /** @var bool $fixedShippingRate When fixedShippingRateOnly is true, this field sets the product fixed shipping cost per item. When fixedShippingRateOnly is false, the value in this field is treated as an extra shipping cost the product adds to the global calculated shipping */
    public $fixedShippingRate = false;
    /** @var int $defaultCombinationId Identifier of the default product variation, which is defined by the default values of product options. */
    public $defaultCombinationId;
    /** @var string $thumbnailUrl URL of the product thumbnail displayed on the product list pages. Thumbnails size is defined in the store settings. Default size of the biggest dimension is 400px. The original uploaded product image is available in the originalImageUrl field. */
    public $thumbnailUrl;
    /** @var string $imageUrl URL of the product image resized to fit 1500x1500px. The original uploaded product image is available in the originalImageUrl field. */
    public $imageUrl;
    /** @var string $smallThumbnailUrl URL of the product thumbnail resized to fit 160x160px. The original uploaded product image is available in the originalImageUrl field. */
    public $smallThumbnailUrl;
    /** @var string $hdThumbnailUrl Product HD thumbnail URL resized to fit 800x800px */
    public $hdThumbnailUrl;
    /** @var string $originalImageUrl URL of the original not resized product image */
    public $originalImageUrl;
    /** @var string $originalImage Details of the product image */
    public $originalImage;
    /** @var string $description Product description in HTML */
    public $description;
    /** @var object $galleryImages List of the product gallery images */
    public $galleryImages;
    /** @var array $categoryIds Private token: List of the categories, which the product belongs to. Public token: List of the enabled categories the product belongs to. Any token: If no categories provided, product is displayed on the store front page, see showOnFrontpage field, or all categories of that product are disabled */
    public $categoryIds;
    /** @var \litebox\kassa\lib\Template\Category\Category $categories List of the categories the product belongs to with brief details (for any access token). If no categories provided, product belogs to store front page, see showOnFrontpage field */
    public $categories;
    /** @var string $seoTitle Page title to be displayed in search results on the web. Recommended length is under 55 characters */
    public $seoTitle;
    /** @var string $seoDescription Page description to be displayed in search results on the web. Recommended length is under 160 characters */
    public $seoDescription;
    /** @var int $defaultCategoryId Default category ID of the product. If value is 0, then product does not have a default category and is not shown anywhere in storefront */
    public $defaultCategoryId;
    /** @var object $favorites Product favorites stats */
    public $favorites;
    /** @var array $attributes Product attributes and their values */
    public $attributes;
    /** @var array $files Downloadable files (E-goods) attached to the product */
    public $files;
    /** @var object $relatedProducts Related or “You may also like” products of the product */
    public $relatedProducts;
    /** @var array $combinations List of the product variations */
    public $combinations;
    /** @var object $dimensions Product dimensions info */
    public $dimensions;
    /** @var int $showOnFrontpage A positive number indicates the position (index) of a product in the store front page – the smaller the number, the higher the product is displayed on a page. A missing field means the product is not shown in the store front page (for private tokens) */
    public $showOnFrontpage;
    /** @var string $vat_code null */
    public $vat_code;

    public $rules = [
        'id' => 'ID',
        'sku' => 'sku',
        'quantity' => 'QUANTITY',
        'vat_code' => 'VAT_CODE',
        'unlimited' => 'QUANTITY_TRACE_ORIG',
        'inStock' => 'QUANTITY_TRACE_ORIG',
        'name' => 'NAME',
        'price' => 'PRICE',
        'defaultDisplayedPrice' => 'PRICE',
        'isShippingRequired' => '',
        'weight' => 'WEIGHT',
        'url' => 'DETAIL_PAGE_URL',
        'created' => 'DATE_CREATE',
        'updated' => 'TIMESTAMP_X',
        'createTimestamp' => 'DATE_CREATE_UNIX',
        'updateTimestamp' => 'TIMESTAMP_X_UNIX',
        'productClassId' => '',
        'enabled' => 'ENABLED',
        'options' => 'OPTIONS',
        'thumbnailUrl' => 'thumbnailUrl',
        'imageUrl' => 'imageUrl',
        'smallThumbnailUrl' => 'smallThumbnailUrl',
        'hdThumbnailUrl' => 'hdThumbnailUrl',
        'originalImageUrl' => 'originalImageUrl',
        'originalImage' => 'originalImage',
        'description' => 'DETAIL_TEXT',
        'categoryIds' => 'IBLOCK_SECTION_ID',
        'seoTitle' => 'seoTitle',
        'seoDescription' => 'seoDescription',
        'defaultCategoryId' => 'IBLOCK_SECTION_ID',
        'files' => '',
        'relatedProducts' => '',
        'combinations' => '',
        'dimensions' => '',
        'showOnFrontpage' => ''
    ];
}