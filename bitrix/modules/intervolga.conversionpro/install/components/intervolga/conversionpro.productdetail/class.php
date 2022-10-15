<?
namespace Intervolga\ConversionPro\Components;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
Loc::loadMessages(__FILE__);


class ProductDetail extends \CBitrixComponent
{
    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }
}

