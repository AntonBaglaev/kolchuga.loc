<?php

namespace Yandex\Market\Trading\Service\Beru\Action\Stocks;

use Yandex\Market;
use Bitrix\Main;

class Request extends Market\Trading\Service\Common\Action\HttpRequest
{
	public function getWarehouseId()
	{
		return (string)$this->getRequiredField('warehouseId');
	}

	public function getSkus()
	{
		return (array)$this->getRequiredField('skus');
	}
}