<?php

namespace Yandex\Market\Trading\Service\Beru\Model;

use Yandex\Market;
use Bitrix\Main;
use Yandex\Market\Trading\Service as TradingService;

class OrderFacade extends Market\Api\Model\OrderFacade
{
	protected static function createLoadListRequest()
	{
		return new TradingService\Beru\Api\Orders\Request();
	}

	protected static function createLoadRequest()
	{
		return new TradingService\Beru\Api\Order\Request();
	}
}