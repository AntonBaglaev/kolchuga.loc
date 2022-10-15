<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$sale = Loader::includeModule('sale') && Loader::includeModule('currency');

$arComponentParameters = array(
    'PARAMETERS' => array(
        'ID' => array(
            'NAME' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_PRODUCTLIST_ID'),
            'TYPE' => 'TEXT',
            'MULTIPLE' => 'Y',
            'REFRESH' => 'Y'
        ),
        'NAME' => array(
            'NAME' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_PRODUCTLIST_NAME'),
            'TYPE' => 'TEXT',
            'MULTIPLE' => 'Y'
        ),
        'PRICE' => array(
            'NAME' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_PRODUCTLIST_PRICE'),
            'TYPE' => 'TEXT',
            'MULTIPLE' => 'Y'
        ),
        'CURRENCY' => array(
            'NAME' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_PRODUCTLIST_CURRENCY'),
            'TYPE' => 'TEXT',
            'MULTIPLE' => 'Y'
        ),
    )
);
