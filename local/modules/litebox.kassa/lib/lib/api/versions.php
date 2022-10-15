<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 03.04.2018
 * Time: 0:08
 */

namespace litebox\kassa\lib\Api;


class Versions
{
    /**
     * @var array $allowVersions Разрешенные версии
     */
    public $allowVersions = [
        'v1',
    ];

    /**
     * Проверка выбранной версии, если не найдна будет возвращена последняя доступная
     * @param $version
     * @return mixed
     */
    public function check($version)
    {
        if (in_array($version, $this->allowVersions)) {
            return $version;
        } else {
            return ['error' => 'this version not found'];
        }
    }
}