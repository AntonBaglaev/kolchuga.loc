<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 07.04.2018
 * Time: 19:48
 */

namespace litebox\kassa\lib\Template\Orders;

use litebox\kassa\lib\Template\GenerateData;

class OrderItemOption extends GenerateData
{
    /** @var string $name Option name */
    public $name;
    /** @var string $type Option type */
    public $type;
    /** @var string $value Selected/entered value by customer. Multiple values separated by comma in a single string */
    public $value;
    public $valuesArray;
    /** @var array $files Attached files */
    public $files;
    /** @var array $selections Details of selected product options. If sent in update order request, other fields will be regenerated based on information in this field */
    public $selections;

    public $rules = [
        'name' => 'NAME',
        'type' => '',
        'value' => 'VALUE',
        'valuesArray' => '',
        'files' => 'files',
        'selections' => '',
    ];
}