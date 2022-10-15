<?php

namespace Yandex\Market\Ui;

use Yandex\Market;

class Access
{
	const RIGHTS_READ = 'R';
	const RIGHTS_WRITE = 'W';

	public static function isReadAllowed()
	{
		return static::hasRights(static::RIGHTS_READ);
	}

	public static function isWriteAllowed()
	{
		return static::hasRights(static::RIGHTS_WRITE);
	}

	public static function hasRights($level)
	{
		return static::getRights() >= $level;
	}

	protected static function getRights()
	{
		$moduleId = Market\Config::getModuleName();

		return \CMain::GetUserRight($moduleId);
	}
}