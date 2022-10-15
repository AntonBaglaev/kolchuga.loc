<?php

namespace Yandex\Market\Trading\Service\Beru;

use Yandex\Market;
use Bitrix\Main;
use Yandex\Market\Trading\Service as TradingService;

class Printer extends TradingService\Reference\Printer
{
	use Market\Reference\Concerns\HasLang;

	protected $provider;

	protected static function includeMessages()
	{
		Main\Localization\Loc::loadMessages(__FILE__);
	}

	public function __construct(Provider $provider)
	{
		parent::__construct($provider);
	}

	protected function getSystemMap()
	{
		return [
			'boxLabel' => Document\BoxLabel::class,
			'deliveryAct' => Document\DeliveryAct::class,
		];
	}
}