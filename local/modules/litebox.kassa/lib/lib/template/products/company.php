<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 13.04.2018
 * Time: 17:15
 */

namespace litebox\kassa\lib\Template\Products;

use litebox\kassa\lib\Api\Methods\v1\Base;
use litebox\kassa\lib\Template\GenerateData;

class Company extends GenerateData
{
    /** @var string $companyName The company name displayed on the invoice */
    public $companyName;
    /** @var string $email Company (store administrator) email */
    public $email;
    /** @var string $street Company address. 1 or 2 lines separated by a new line character */
    public $street;
    /** @var string $city Company city */
    public $city;
    /** @var string $countryCode A two-letter ISO code of the country */
    public $countryCode;
    /** @var string $postalCode Postal code or ZIP code */
    public $postalCode;
    /** @var string $stateOrProvinceCode State code (e.g. NY) or a region name */
    public $stateOrProvinceCode;
    /** @var string $phone Company phone number */
    public $phone;

    private $rules = [
        'companyName' => '',
        'email' => '',
        'street' => '',
        'city' => '',
        'countryCode' => '',
        'postalCode' => '',
        'stateOrProvinceCode' => '',
        'phone' => '',
    ];

    public function __construct($dataItem)
    {
        $this->companyName = \COption::GetOptionString("main", "site_name");
        $this->email = \COption::GetOptionString("main", "email_from");
//        foreach ($this as $key => &$value) {
//            if ($this->rules[$key]) {
//                $value = $dataItem[$this->rules[$key]];
//            }
//        }
    }
}