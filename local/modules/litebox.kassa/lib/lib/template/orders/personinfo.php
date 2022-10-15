<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 07.04.2018
 * Time: 2:52
 */

namespace litebox\kassa\lib\Template\Orders;


use litebox\kassa\lib\Template\GenerateData;

class PersonInfo extends GenerateData
{
    /** @var string $name Full name */
    public $name;
    /** @var string $companyName Company name */
    public $companyName;
    /** @var string $street Address line 1 and address line 2, separated by ’\n’ */
    public $street;
    /** @var string $city City */
    public $city;
    /** @var string $countryCode Two-letter country code */
    public $countryCode;
    /** @var string $countryName Country name */
    public $countryName;
    /** @var string $postalCode Postal/ZIP code */
    public $postalCode;
    /** @var string $stateOrProvinceCode State code, e.g. NY */
    public $stateOrProvinceCode;
    /** @var string $stateOrProvinceName State name */
    public $stateOrProvinceName;
    /** @var string $phone Phone number */
    public $phone;

    public $rules = [
        'name' => 'FIO',
        'companyName' => '',
        'street' => 'ADDRESS',
        'city' => 'CITY',
        'countryCode' => '',
        'countryName' => 'CITY',
        'postalCode' => 'ZIP',
        'stateOrProvinceCode' => '',
        'stateOrProvinceName' => '',
        'phone' => 'PHONE',
    ];
}