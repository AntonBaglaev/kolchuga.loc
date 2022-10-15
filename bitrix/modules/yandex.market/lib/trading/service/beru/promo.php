<?php

namespace Yandex\Market\Trading\Service\Beru;

use Yandex\Market;
use Bitrix\Main;
use Yandex\Market\Trading\Service as TradingService;

class Promo
{
	use Market\Reference\Concerns\HasLang;

	const GENERIC_BUNDLE = 'GENERIC_BUNDLE';
	const CHEAPEST_AS_GIFT = 'CHEAPEST_AS_GIFT';
	const BLUE_SET = 'BLUE_SET';
	const BLUE_FLASH = 'BLUE_FLASH';

	protected $provider;

	protected static function includeMessages()
	{
		Main\Localization\Loc::loadMessages(__FILE__);
	}

	public function __construct(Provider $provider)
	{
		$this->provider = $provider;
	}

	public function getTitle($type)
	{
		return static::getLang('TRADING_SERVICE_BERU_PROMO_TYPE_' . $type, null, $type);
	}

	public function getVisibleTypes()
	{
		return [
			static::GENERIC_BUNDLE,
			static::CHEAPEST_AS_GIFT,
			static::BLUE_SET,
			static::BLUE_FLASH,
		];
	}
}