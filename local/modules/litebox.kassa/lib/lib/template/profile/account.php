<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 13.04.2018
 * Time: 16:55
 */

namespace litebox\kassa\lib\Template\Profile;

use litebox\kassa\lib\Template\GenerateData;

class Account extends GenerateData
{
    /** @var string $accountName Full store owner name */
    public $accountName;
    /** @var string $accountNickName Store owner nickname on the Ecwid forums */
    public $accountNickName;
    /** @var string $accountEmail Store owner email */
    public $accountEmail;
    /** @var array $availableFeatures A list of the premium features available on the store’s pricing plan */
    public $availableFeatures;

    public $rules = [
        'accountName' => 'NAME',
        'accountNickName' => 'LOGIN',
        'accountEmail' => 'EMAIL',
    ];
}