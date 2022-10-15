<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = array(
    'PARAMETERS' => array(
        'ID' => array(
            'NAME' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_PRODUCTDETAIL_ID'),
            'TYPE' => 'TEXT',
        ),
        'NAME' => array(
            'NAME' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_PRODUCTDETAIL_NAME'),
            'TYPE' => 'TEXT',
        ),
        'PRICE' => array(
            'NAME' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_PRODUCTDETAIL_PRICE'),
            'TYPE' => 'TEXT',
        ),
        'CURRENCY' => array(
            'NAME' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_PRODUCTDETAIL_CURRENCY'),
            'TYPE' => 'TEXT',
        ),
    )
);
