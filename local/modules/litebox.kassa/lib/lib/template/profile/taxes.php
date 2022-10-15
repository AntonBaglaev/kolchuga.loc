<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 15.04.2018
 * Time: 23:24
 */

namespace litebox\kassa\lib\Template\Profile;

use litebox\kassa\lib\Template\GenerateData;

class Taxes extends GenerateData
{
    /** @var int $id Unique internal ID of the tax */
    public $id;
    /** @var string $name Displayed tax name */
    public $name;
    /** @var bool $enabled Whether tax is enabled true / false */
    public $enabled;
    /** @var bool $includeInPrice true if the tax rate is included in product prices. */
    public $includeInPrice;
    /** @var bool $useShippingAddress true if the tax is calculated based on shipping address, false if billing address is used */
    public $useShippingAddress;
    /** @var bool $taxShipping true is the tax applies to subtotal+shipping cost . false if the tax is applied to subtotal only */
    public $taxShipping;
    /** @var bool $appliedByDefault true if the tax is applied to all products. false is the tax is only applied to thos product that have this tax enabled */
    public $appliedByDefault;
    /** @var int $defaultTax Tax value, in %, when none of the destination zones match */
    public $defaultTax;

    public $rules = [
        'id' => 'TAX_ID',
        'name' => 'NAME',
        'enabled' => 'ACTIVE',
        'includeInPrice' => 'IS_IN_PRICE',
        'useShippingAddress' => '',
        'taxShipping' => '',
        'appliedByDefault' => '',
        'defaultTax' => 'VALUE',
    ];
}