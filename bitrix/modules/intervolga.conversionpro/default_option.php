<?
$mainCurrency = '';
if (\Bitrix\Main\Loader::includeModule('currency')) {
    $baseCurrency = \Bitrix\Currency\CurrencyManager::getBaseCurrency();

    if (in_array($baseCurrency, \IntervolgaConversionProConverter::availableCurrencies())) {
        $mainCurrency = $baseCurrency;
    }
}


$intervolga_conversionpro_default_option = array(
	'metrika_id' => '',
	'analytics_id' => '',
	'ready_when' => 'dr',
	'container_name' => 'dataLayer',
	'wait_deadline' => 30,
	'main_currency' => $mainCurrency,
	'send_orders' => 'pr',
	'order_goal' => ''
);
