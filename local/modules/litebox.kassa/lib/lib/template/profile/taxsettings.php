<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 15.04.2018
 * Time: 23:54
 */

namespace litebox\kassa\lib\Template\Profile;

class TaxSettings
{
    /** @var bool $automaticTaxEnabled true if store taxes are calculated automatically, else otherwise */
    public $automaticTaxEnabled = true;
    /** @var array $taxes Manual tax settings for a store */
    public $taxes;
}