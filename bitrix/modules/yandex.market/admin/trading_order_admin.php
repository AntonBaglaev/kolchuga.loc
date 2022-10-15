<?php

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Yandex\Market;

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin.php';

Loc::loadMessages(__FILE__);

$APPLICATION->SetTitle(Loc::getMessage('YANDEX_MARKET_TRADING_ORDERS_TITLE'));

$controller = null;
$state = null;

try
{
	if (!Main\Loader::includeModule('yandex.market'))
	{
		$message = Loc::getMessage('YANDEX_MARKET_TRADING_ORDERS_REQUIRE_MODULE');
		throw new Main\SystemException($message);
	}

	if (!Market\Ui\Access::isReadAllowed())
	{
		$message = Loc::getMessage('YANDEX_MARKET_TRADING_ORDERS_ACCESS_DENIED');
		throw new Main\SystemException($message);
	}

	$request = Main\Context::getCurrent()->getRequest();
	$serviceCode = (string)$request->getQuery('service');

	if ($serviceCode === '')
	{
		$message = Loc::getMessage('YANDEX_MARKET_TRADING_ORDERS_SERVICE_UNDEFINED');
		throw new Main\SystemException($message);
	}

	$setupCollection = Market\Trading\Setup\Collection::loadByService($serviceCode);
	$setup = $setupCollection->getActive();

	if ($setup === null)
	{
		$message = Loc::getMessage('YANDEX_MARKET_TRADING_ORDERS_SETUP_NOT_FOUND');
		throw new Main\SystemException($message);
	}

	if (!$setup->isActive())
	{
		$message = Loc::getMessage('YANDEX_MARKET_TRADING_ORDERS_SETUP_INACTIVE');
		throw new Main\SystemException($message);
	}

	$platform = $setup->getPlatform();
	$orderRegistry = $setup->getEnvironment()->getOrderRegistry();
	$url = $orderRegistry->getAdminListUrl($platform);

	LocalRedirect($url);
	die();
}
catch (Main\SystemException $exception)
{
	\CAdminMessage::ShowMessage([
		'TYPE' => 'ERROR',
		'MESSAGE' => $exception->getMessage(),
	]);
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_admin.php';
