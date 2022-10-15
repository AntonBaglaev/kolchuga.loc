<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 02.04.2018
 * Time: 23:28
 */

namespace litebox\kassa\lib\Template;

class Result
{
    /**
     * @var integer $total общее количество записей
     */
    public $total = 0;
    /**
     * @var int $count возвращаемое количество записей
     */
    public $count = 0;
    /**
     * @var int $page текущая страница
     */
    public $page = 1;
    /**
     * @var int $pageSize количество элементов на странице
     */
    public $pageSize = 50;
    /**
     * @var array $items найденные элементы
     */
    public $items = [];
}