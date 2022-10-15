<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 13.04.2018
 * Time: 16:42
 */

namespace litebox\kassa\lib\Template;

class GeneralInfo extends GenerateData
{
    /** @var int $storeId Ecwid Store ID */
    public $storeId;
    /** @var string $storeUrl Storefront URL */
    public $storeUrl = SITE_SERVER_NAME;

    public $rules = [
        'storeUrl' => 'url'
    ];
}