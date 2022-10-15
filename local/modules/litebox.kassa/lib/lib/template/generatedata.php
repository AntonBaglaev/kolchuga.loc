<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 23.04.2018
 * Time: 17:48
 */

namespace litebox\kassa\lib\Template;


class GenerateData
{
    /**
     * GenerateData constructor.
     * Заполнение объекта по правилам из массива $this->rules
     * @param $dataItem
     */
    public function __construct($dataItem)
    {
        foreach ($this as $key => &$value) {
            if ($this->rules[$key]) {
                $value = $dataItem[$this->rules[$key]];
            }
        }
        unset($this->rules);
    }
}