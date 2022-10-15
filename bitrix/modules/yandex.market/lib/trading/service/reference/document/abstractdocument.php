<?php

namespace Yandex\Market\Trading\Service\Reference\Document;

use Bitrix\Main;
use Yandex\Market;
use Yandex\Market\Trading\Entity as TradingEntity;
use Yandex\Market\Trading\Service as TradingService;

abstract class AbstractDocument
{
	protected $provider;

	public function __construct(TradingService\Reference\Provider $provider)
	{
		$this->provider = $provider;
	}

	abstract public function getTitle($version = '');

	abstract public function getEntityType();

	abstract public function render(array $items, array $settings = []);

	public function getSettings()
	{
		return [];
	}

	protected function renderComponent($templateName, array $parameters = [])
	{
		global $APPLICATION;

		ob_start();

		$APPLICATION->IncludeComponent('yandex.market:trading.print.document', $templateName, $parameters);

		return ob_get_clean();
	}
}