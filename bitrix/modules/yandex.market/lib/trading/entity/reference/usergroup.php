<?php

namespace Yandex\Market\Trading\Entity\Reference;

use Yandex\Market;
use Bitrix\Main;

abstract class UserGroup
{
	protected $environment;
	protected $serviceCode;
	protected $siteId;

	public function __construct(Environment $environment, $serviceCode, $siteId)
	{
		$this->environment = $environment;
		$this->serviceCode = $serviceCode;
		$this->siteId = $siteId;
	}

	/**
	 * @return bool
	 */
	public function isInstalled()
	{
		return ($this->getId() > 0);
	}

	/**
	 * @param array $data
	 *
	 * @return Main\Entity\AddResult
	 */
	public function install(array $data = [])
	{
		throw new Market\Exceptions\NotImplementedMethod(static::class, 'install');
	}

	/**
	 * @return int|null
	 */
	public function getId()
	{
		throw new Market\Exceptions\NotImplementedMethod(static::class, 'getId');
	}
}