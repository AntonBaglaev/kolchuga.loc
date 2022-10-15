<?php

namespace Yandex\Market\Trading\Service\Beru;

use Yandex\Market;
use Bitrix\Main;

class Info extends Market\Trading\Service\Reference\Info
{
	use Market\Reference\Concerns\HasLang;

	protected static function includeMessages()
	{
		Main\Localization\Loc::loadMessages(__FILE__);
	}

	public function getTitle($version = '')
	{
		$suffix = $version !== '' ? '_' . $version : '';

		return static::getLang('TRADING_SERVICE_BERU_INFO_TITLE' . $suffix, null, $this->provider->getCode());
	}

	public function getDescription()
	{
		return static::getLang('TRADING_SERVICE_BERU_INFO_DESCRIPTION', null, '');
	}

	public function getLogoPath()
	{
		return Market\Ui\Assets::getRootDirectoryPath('images') . '/assets/beru.svg';
	}

	public function getMessage($code, $replaces = null, $fallback = null)
	{
		return static::getLang('TRADING_SERVICE_BERU_INFO_' . $code, $replaces, $fallback);
	}

	public function getProfileValues()
	{
		return [
			'NAME' => static::getLang('TRADING_SERVICE_BERU_PROFILE_NAME'),
		];
	}
}