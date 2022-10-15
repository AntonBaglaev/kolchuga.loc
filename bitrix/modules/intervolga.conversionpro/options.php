<?
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$moduleId = 'intervolga.conversionpro';


/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Test access level
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
if (!$USER->IsAdmin()) {
    $APPLICATION->AuthForm(Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ACCESS_DENIED'));
}


/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Test shareware module state
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
$moduleError = '';
switch (Loader::includeSharewareModule($moduleId)) {
    case MODULE_NOT_FOUND:
        $moduleError = Loc::getMessage('INTERVOLGA_CONVERSIONPRO_MODULE_NOT_FOUND');
        break;

    case MODULE_DEMO_EXPIRED:
        $moduleError = Loc::getMessage('INTERVOLGA_CONVERSIONPRO_MODULE_DEMO_EXPIRED');
        break;
}

if (strlen($moduleError)) {
    $APPLICATION->SetTitle(Loc::getMessage('INTERVOLGA_CONVERSIONPRO_MODULE_ERROR'));
    require_once($_SERVER['DOCUMENT_ROOT'] . BX_ROOT . '/modules/main/include/prolog_admin_after.php');
    $message = new CAdminMessage($moduleError);
    echo $message->Show();
    require($_SERVER['DOCUMENT_ROOT'] . BX_ROOT . '/modules/main/include/epilog_admin.php');
    die();
}


/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Tabs and options definition
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
$allOptions = array(
    'BASE_SETTINGS' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_BASE_SETTINGS'),
    'READY_WHEN' => array('ready_when',
        Loc::getMessage('INTERVOLGA_CONVERSIONPRO_READY_WHEN'),
        null,
        array(
            'selectbox',
            array(
                'yg' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_READY_WHEN_YG'),
                'oy' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_READY_WHEN_OY'),
                'og' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_READY_WHEN_OG'),
                'dr' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_READY_WHEN_DR')
            )
        )
    ),
    'METRIKA_ID' => array('metrika_id',
        Loc::getMessage('INTERVOLGA_CONVERSIONPRO_METRIKA_ID'),
        null,
        array('text', 52)
    ),
    'ANALYTICS_ID' => array('analytics_id',
        Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ANALYTICS_ID'),
        null,
        array('text', 52)
    ),
    'CONTAINER_NAME' => array('container_name',
        Loc::getMessage('INTERVOLGA_CONVERSIONPRO_CONTAINER_NAME'),
        null,
        array('text', 52)
    ),
    'WAIT_DEADLINE' => array('wait_deadline',
        Loc::getMessage('INTERVOLGA_CONVERSIONPRO_WAIT_DEADLINE'),
        null,
        array('text', 52)
    ),
    'SHOP_SETTINGS' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_SHOP_SETTINGS'),
    'MAIN_CURRENCY' => array('main_currency',
        Loc::getMessage('INTERVOLGA_CONVERSIONPRO_MAIN_CURRENCY'),
        null,
        array(
            'selectbox',
            array_intersect_key(array(
                'AUD' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_CURRENCY_AUD'),
                'CAD' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_CURRENCY_CAD'),
                'CHF' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_CURRENCY_CHF'),
                'CNY' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_CURRENCY_CNY'),
                'EUR' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_CURRENCY_EUR'),
                'GBP' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_CURRENCY_GBP'),
                'RUB' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_CURRENCY_RUB'),
                'THB' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_CURRENCY_THB'),
                'TRY' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_CURRENCY_TRY'),
                'UAH' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_CURRENCY_UAH'),
                'USD' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_CURRENCY_USD')
            ), array_flip(
                    \IntervolgaConversionProConverter::availableCurrencies()
                )
            )
        )
    ),
    'SEND_ORDERS' => array('send_orders',
        Loc::getMessage('INTERVOLGA_CONVERSIONPRO_SEND_ORDERS'),
        null,
        array(
            'selectbox',
            array(
                'pr' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_SEND_ORDERS_PURCHAICED'),
                'pp' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_SEND_ORDERS_PATRIALLY_PAID'),
                'fp' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_SEND_ORDERS_FULLY_PAID')
            )
        )
    ),
    'ORDER_GOAL' => array('order_goal',
        Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ORDER_GOAL'),
        null,
        array('text', 52)
    ),
);

$catalogs = array();
if (Loader::includeModule('catalog') && Loader::includeModule('iblock')) {
    $catalogIterator = \Bitrix\Catalog\CatalogIblockTable::getList(array(
        'select' => array('IBLOCK_ID', 'NAME' => 'IBLOCK.NAME'),
        'filter' => array('=PRODUCT_IBLOCK_ID' => 0),
        'order' => array('IBLOCK_ID' => 'ASC')
    ));
    while ($catalog = $catalogIterator->fetch()) {
        $id = (int)$catalog['IBLOCK_ID'];
        $catalogs[$id] = array(
            'NAME' => $catalog['NAME'],
            'PROPERTIES' => array()
        );
    }
    unset($catalog, $catalogIterator);

    if (count($catalogs)) {
        $propertyIterator = \Bitrix\Iblock\PropertyTable::getList(array(
            'select' => array('ID', 'CODE', 'NAME', 'IBLOCK_ID'),
            'filter' => array('=IBLOCK_ID' => array_keys($catalogs), '=ACTIVE' => 'Y', '!=XML_ID' => \CIBlockPropertyTools::XML_SKU_LINK, '!CODE' => null),
            'order' => array('IBLOCK_ID' => 'ASC', 'SORT' => 'ASC', 'ID' => 'ASC')
        ));
        while ($property = $propertyIterator->fetch()) {
            $iblockId = (int)$property['IBLOCK_ID'];
            $code = $property['CODE'];
            $catalogs[$iblockId]['PROPERTIES'][$code] = $property['NAME'] . ' [' . $property['ID'] . ']';
        }
        unset($property, $propertyIterator, $arIblockNames, $arIblockIDs);
    }
}
if (count($catalogs)) {
    $allOptions['BRAND_SETTINGS'] = Loc::getMessage('INTERVOLGA_CONVERSIONPRO_BRAND_SETTINGS');
    foreach ($catalogs as $iblockId => $iblockParams) {
        $allOptions['IBLOCK_' . $iblockId . '_BRAND'] = array('iblock_' . $iblockId . '_brand',
            $iblockParams['NAME'],
            '',
            array(
                'selectbox',
                array_merge(array('' => '-'), $iblockParams['PROPERTIES'])
            )
        );

    }
}

/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Processing SAVE button
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_REQUEST['save']) > 0 && check_bitrix_sessid()) {
    $waitDeadline = intval($_REQUEST['wait_deadline']);
    if ($waitDeadline < 1) {
        $waitDeadline = 1;
    } else if ($waitDeadline > 3 * 365) {
        $waitDeadline = 3 * 365;
    }
    $_REQUEST['wait_deadline'] = $waitDeadline;

    __AdmSettingsSaveOptions($moduleId, $allOptions);

    LocalRedirect($APPLICATION->GetCurPage() . '?lang=' . LANGUAGE_ID . '&mid_menu=1&mid=' . urlencode($moduleId));
}

$aTabs = array(
    array(
        'DIV' => 'common_tab',
        'TAB' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_COMMON_TAB'),
        'TITLE' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_COMMON_TAB'),
        'OPTIONS' => $allOptions
    ),
);


/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Show UI
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
echo BeginNote();
echo Loc::getMessage('INTERVOLGA_CONVERSIONPRO_QUEUE_LENGTH', array(
    '#COUNT#' => \Intervolga\ConversionPro\Internal\QueueTable::getCount()
));
echo '&nbsp;&nbsp;/&nbsp;&nbsp;';
echo Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ERRORS_LOG', array(
    '#COUNT#' => \CEventLog::GetList(array(), array('MODULE_ID' => $moduleId))->SelectedRowsCount()
));
echo '<br>';
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
echo Loc::getMessage('INTERVOLGA_CONVERSIONPRO_DEBUG', array(
    '#SITE_URL#' => ($request->isHttps() ? 'https://' : 'http://') . $request->getHttpHost()
));
echo EndNote();


$tabControl = new CAdminTabControl('tabControl', $aTabs);
?>
    <form method='post' action='' name='bootstrap'>
        <? $tabControl->Begin();

        foreach ($aTabs as $aTab) {
            $tabControl->BeginNextTab();
            __AdmSettingsDrawList($moduleId, $aTab['OPTIONS']);
        }

        $tabControl->Buttons(array('btnApply' => false, 'btnCancel' => false, 'btnSaveAndAdd' => false)); ?>

        <?= bitrix_sessid_post(); ?>
        <? $tabControl->End(); ?>
    </form>
<?