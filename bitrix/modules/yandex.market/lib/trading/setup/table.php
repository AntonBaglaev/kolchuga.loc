<?php

namespace Yandex\Market\Trading\Setup;

use Bitrix\Main;
use Yandex\Market;

class Table extends Market\Reference\Storage\Table
{
	public static function getTableName()
	{
		return 'yamarket_trading_setup';
	}

	public static function getUfId()
	{
		return 'YAMARKET_TRADING_SETUP';
	}

	public static function getMap()
	{
		return [
			new Main\Entity\IntegerField('ID', [
				'autocomplete' => true,
				'primary' => true
			]),
			new Main\Entity\StringField('NAME', [
				'required' => true,
				'validation' => [__CLASS__, 'validateName'],
			]),
			new Main\Entity\BooleanField('ACTIVE', [
				'values' => [static::BOOLEAN_N, static::BOOLEAN_Y],
				'default_value' => static::BOOLEAN_Y,
			]),
			new Main\Entity\EnumField('TRADING_SERVICE', [
				'required' => true,
				'values' => Market\Trading\Service\Manager::getVariants(),
			]),
			new Main\Entity\StringField('SITE_ID', [
				'required' => true,
				'validation' => [__CLASS__, 'validateSiteId'],
			]),
			new Main\Entity\StringField('EXTERNAL_ID', [
				'required' => true,
				'validation' => [__CLASS__, 'validateExternalId'],
			]),
		];
	}

	public static function getReference($primary = null)
	{
		return [
			'SETTINGS' => [
				'TABLE' => Market\Trading\Settings\Table::getClassName(),
				'LINK_FIELD' => 'SETUP_ID',
				'LINK' => [
					'SETUP_ID' => $primary,
				],
			],
		];
	}

	public static function validateName()
	{
		return [
			new Main\Entity\Validator\Length(null, 65),
		];
	}

	public static function validateSiteId()
	{
		return [
			new Main\Entity\Validator\Length(null, 10),
		];
	}

	public static function validateExternalId()
	{
		return [
			new Main\Entity\Validator\Length(null, 20),
		];
	}
}
