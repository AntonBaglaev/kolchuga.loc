<?php

namespace Yandex\Market\Trading\Service\Beru\Model\Cart;

use Yandex\Market;
use Bitrix\Main;
use Yandex\Market\Trading\Service as TradingService;

class Item extends Market\Api\Model\Cart\Item
{
	public function getFeedId()
	{
		return (int)$this->getRequiredField('feedId');
	}
}