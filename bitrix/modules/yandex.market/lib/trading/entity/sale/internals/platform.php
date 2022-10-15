<?php

namespace Yandex\Market\Trading\Entity\Sale\Internals;

use Yandex\Market;
use Bitrix\Main;
use Bitrix\Sale;

if (!Main\Loader::includeModule('sale') || !class_exists(Sale\TradingPlatform\Platform::class)) { return; }

class Platform extends Sale\TradingPlatform\Platform
{
	public function installExtended(array $data = [])
	{
		return $this->addPlatformRecord($data);
	}

	public function install()
	{
		return $this->installExtended()->getId();
	}

	protected function addPlatformRecord(array $data = [])
	{
		$fields = [
			'CODE' => $this->getCode(),
			'CLASS' => '\\' . static::class,
			'ACTIVE' => 'N',
			'SETTINGS' => '',
		];
		$fields += array_intersect_key(
			$data,
			[ 'NAME' => true, 'DESCRIPTION' => true, ]
		);

		$addResult = Sale\TradingPlatformTable::add($fields);

		if ($addResult->isSuccess())
		{
			$this->id = $addResult->getId();
			$this->isInstalled = true;
		}

		return $addResult;
	}
}