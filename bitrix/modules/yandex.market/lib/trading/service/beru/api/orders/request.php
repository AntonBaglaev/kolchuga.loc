<?php

namespace Yandex\Market\Trading\Service\Beru\Api\Orders;

use Bitrix\Main;
use Yandex\Market;

class Request extends Market\Api\Partner\Orders\Request
{
	public function buildResponse($data)
	{
		return new Response($data);
	}
}
