<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 23.04.2018
 * Time: 15:04
 */

namespace litebox\kassa\lib\Api\Methods\v1;


class Token extends Base
{
    public $needToken = false;

    public function executeGET()
    {
        $hash = $this->generateToken();

        $result = [
            'access_token' => $hash
        ];

        return $result;
    }

}
