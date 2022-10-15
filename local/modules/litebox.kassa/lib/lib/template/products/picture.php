<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 09.04.2018
 * Time: 16:01
 */

namespace litebox\kassa\lib\Template\Products;

use litebox\kassa\lib\Template\GenerateData;

class Picture extends GenerateData
{
    /** @var int $id Internal gallery image ID */
    public $id;
    /** @var string $alt Image description, displayed in the image tag’s alt attribute */
    public $alt;
    /** @var string $url Deprecated. Original image URL. Equals originalImageUrl */
    public $url;
    /** @var string $thumbnail Deprecated. Image thumbnail URL resized to fit 160x160px. Equals smallThumbnailUrl */
    public $thumbnail;
    /** @var string $hdThumbnailUrl Product HD thumbnail URL resized to fit 800x800px */
    public $hdThumbnailUrl;
    /** @var string $hdThumbnailUrl URL of the product thumbnail displayed on the product list pages. Thumbnails size is defined in the store settings. Default size of the biggest dimension is 400px. The original uploaded product image is available in the originalImageUrl field. */
    public $thumbnailUrl;
    /** @var string $smallThumbnailUrl URL of the product thumbnail resized to fit 160x160px. The original uploaded product image is available in the originalImageUrl field. */
    public $smallThumbnailUrl;
    /** @var string $imageUrl URL of the product image resized to fit 1500x1500px. The original uploaded product image is available in the originalImageUrl field. */
    public $imageUrl;
    /** @var string $originalImageUrl URL of the original not resized product image */
    public $originalImageUrl;
    /** @var int $width Image width */
    public $width;
    /** @var int $height Image height */
    public $height;

    public $rules = [
        'id' => 'ID',
        'alt' => 'DESCRIPTION',
        'url' => 'SRC',
        'thumbnail' => 'SRC',
        'hdThumbnailUrl' => 'SRC',
        'thumbnailUrl' => 'SRC',
        'smallThumbnailUrl' => 'SRC',
        'imageUrl' => 'SRC',
        'originalImageUrl' => 'SRC',
        'width' => 'WIDTH',
        'height' => 'HEIGHT',
    ];
}