<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 17.05.2018
 * Time: 11:31
 */

namespace litebox\kassa\lib\Template\Products;


use litebox\kassa\lib\Template\GenerateData;

class Options extends GenerateData
{
//    /** @var string $type One of SELECT, RADIO, CHECKBOX, TEXTFIELD, TEXTAREA, DATE, FILES */
//    public $type;
//    /** @var string $name Product option name, e.g. Color */
//    public $name;
//    /** @var array $choices All possible option selections for the types SELECT, CHECKBOX or RADIO. This field is omitted for the product option with no selection (e.g. text, datepicker or upload file options) */
//    public $choices = [];
//    /** @var int $defaultChoice The number, starting from 0, of the option’s default selection. Only presents if the type is SELECT or RADIO */
//    public $defaultChoice;
//    /** @var bool $required true if this option is required, false otherwise. Default is false */
//    public $required;
//    /** @var string $propCode PROPCODE */
//    public $propcode;
//
//    public $rules = [
//        'type' => 'CODE',
//        'name' => 'NAME',
//        'defaultChoice' => 'DEFAULT_VALUE',
//        'required' => 'IS_REQUIRED',
//        'propcode' => 'PROPCODE'
//    ];

    /** @var double $price price */
    public $price;
    /** @var int $id id */
    public $id;
    /** @var array $params params */
    public $params;
    /** @var string $vat_code null */
    public $vat_code;

    public $rules = [
        'price' => 'PRICE',
        'id' => 'ID',
        'vat_code' => 'VAT_CODE',
        'params' => 'PARAMS'
    ];
}