<?php

namespace Yandex\Market\Trading\Service\Beru\Action\OrderAccept;

use Yandex\Market;
use Bitrix\Main;
use Yandex\Market\Trading\Service as TradingService;

class Request extends TradingService\Common\Action\OrderAccept\Request
{
	/**
	 * @return TradingService\Beru\Model\Order
	 * @throws Market\Exceptions\Api\InvalidOperation
	 */
	public function getOrder()
	{
		return $this->getRequiredModel('order');
	}

	protected function getChildModelReference()
	{
		return [
			'order' => TradingService\Beru\Model\Order::class,
		];
	}
}