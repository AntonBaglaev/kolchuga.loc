<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 09.04.2018
 * Time: 1:22
 */

namespace litebox\kassa\lib\Template\Category;


use litebox\kassa\lib\Template\GenerateData;

class Category extends GenerateData
{
    /** @var int $id Internal unique category ID */
    public $id;
    /** @var ?int $parentId ID of the parent category, if any */
    public $parentId;
    /** @var int $orderBy Sort order of the category in the parent category subcategories list */
    public $orderBy;
    /** @var string $hdThumbnailUrl Category HD thumbnail URL resized to fit 800x800px */
    public $hdThumbnailUrl;
    /** @var string $thumbnailUrl Category thumbnail URL. The thumbnail size is specified in the store settings. Resized to fit 400x400px by default */
    public $thumbnailUrl;
    /** @var string $imageUrl Category image URL. A resized original image to fit 1500x1500px */
    public $imageUrl;
    /** @var string $originalImageUrl Link to the original (not resized) category image */
    public $originalImageUrl;
    /** @var string $originalImage Details of the category image */
    public $originalImage;
    /** @var string $name Category name */
    public $name;
    /** @var string $url URL of the category page in the store  */
    public $url;
    /** @var int $productCount Number of products in the category and its subcategories */
    public $productCount;
    /** @var int $enabledProductCount Number of enabled products in the category (excluding its subcategories) */
    public $enabledProductCount;
    /** @var string $description The category description in HTML */
    public $description;
    /** @var bool $enabled true if the category is enabled, false otherwise. Use hidden_categories in request to get disabled categories */
    public $enabled;
    /** @var array $productIds IDs of products assigned to the category as they appear in Ecwid Control Panel > Catalog > Categories. To make this field appear in a response, send productIds=true in a request. */
    public $productIds;

    public $rules = [
        'id' => 'ID',
        'parentId' => 'IBLOCK_SECTION_ID',
        'orderBy' => 'SORT',
        'name' => 'NAME',
        'url' => 'SECTION_PAGE_URL',
        'productCount' => '',
        'enabledProductCount' => '',
        'description' => 'DESCRIPTION',
        'enabled' => 'ACTIVE', //true/false
        'productIds' => '',
    ];

    public function __construct($dataItem)
    {
        parent::__construct($dataItem);

        $url = $this->url;

        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https://';
        }
        else {
            $protocol = 'http://';
        }

        $url = str_replace('#SECTION_CODE#', $dataItem['CODE'], $url);
        $url = str_replace('#SITE_DIR#', SITE_SERVER_NAME, $url);

        $this->url = $protocol . $url;
    }
}