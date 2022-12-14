<?php

namespace Yandex\Market\Trading\Setup;

use Bitrix\Main;
use Yandex\Market;

class Model extends Market\Reference\Storage\Model
{
	use Market\Reference\Concerns\HasLang;

	protected $environment;
	protected $service;

	protected static function includeMessages()
	{
		Main\Localization\Loc::loadMessages(__FILE__);
	}

	public static function getDataClass()
	{
		return Table::getClassName();
	}

	/**
	 * @param string $serviceCode
	 * @param string $siteId
	 *
	 * @return Model
	 * @throws Main\ArgumentException
	 * @throws Main\ObjectNotFoundException
	 */
	public static function loadByServiceAndSite($serviceCode, $siteId)
	{
		$list = static::loadList([
			'filter' => [
				'=TRADING_SERVICE' => $serviceCode,
				'=SITE_ID' => $siteId,
			],
			'limit' => 1,
		]);

		if (empty($list))
		{
			$message = static::getLang('TRADING_SETUP_MODEL_NOT_FOUND');
			throw new Main\ObjectNotFoundException($message);
		}

		return reset($list);
	}

	/**
	 * @param string $externalId
	 * @param string $siteId
	 *
	 * @return Model
	 * @throws Main\ArgumentException
	 * @throws Main\ObjectNotFoundException
	 */
	public static function loadByExternalIdAndSite($externalId, $siteId)
	{
		$list = static::loadList([
			'filter' => [
				'=EXTERNAL_ID' => $externalId,
				'=SITE_ID' => $siteId,
			],
			'limit' => 1,
		]);

		if (empty($list))
		{
			$message = static::getLang('TRADING_SETUP_MODEL_NOT_FOUND');
			throw new Main\ObjectNotFoundException($message);
		}

		return reset($list);
	}

	public function isInstalled()
	{
		return ($this->getId() > 0);
	}

	public function install()
	{
		$this->fillName();

		$this->installService();
		$this->installPlatform();
		$this->installInternalRecord();
	}

	public function uninstall()
	{
		$this->uninstallService();
	}

	protected function fillName()
	{
		if ((string)$this->getField('NAME') === '')
		{
			$serviceInfo = $this->getService()->getInfo();
			$serviceTitle = $serviceInfo->getTitle() . ' (' . $this->getSiteId() . ')';

			$this->setField('NAME', $serviceTitle);
		}
	}

	protected function installService()
	{
		$environment = $this->getEnvironment();
		$siteId = $this->getSiteId();

		$this->getService()->getInstaller()->install($environment, $siteId);
	}

	protected function uninstallService()
	{
		$environment = $this->getEnvironment();
		$siteId = $this->getSiteId();
		$context = [
			'SITE_USED' => Facade::hasActiveSetup($siteId, $this->getId()),
			'PLATFORM_USED' => Facade::hasActiveSetupUsingExternalPlatform($this->getExternalId(), $this->getId()),
		];

		$this->getService()->getInstaller()->uninstall($environment, $siteId, $context);
	}

	protected function installPlatform()
	{
		$platform = $this->getPlatform();

		if (!$platform->isInstalled())
		{
			$info = $this->getService()->getInfo();
			$platform->install($info);
		}

		$this->setField('EXTERNAL_ID', $platform->getId());
	}

	protected function installInternalRecord()
	{
		$fields = $this->getFields();
		$primary = $this->getId();

		if ($primary > 0)
		{
			$dbResult = Table::update($primary, array_diff_key($fields, [ 'ID' => true, ]));
		}
		else
		{
			$dbResult = Table::add($fields);

			if ($dbResult->isSuccess())
			{
				$id = $dbResult->getId();
				$this->setField('ID', $id);
			}
		}

		Market\Result\Facade::handleException($dbResult);
	}

	public function isActive()
	{
		return (string)$this->getField('ACTIVE') === Table::BOOLEAN_Y;
	}

	public function activate()
	{
		$this->activatePlatform();
		$this->updateActiveFlag(true);
	}

	public function deactivate()
	{
		$this->deactivatePlatform();
		$this->updateActiveFlag(false);
	}

	protected function activatePlatform()
	{
		$this->getPlatform()->activate();
	}

	protected function deactivatePlatform()
	{
		if (!Facade::hasActiveSetupUsingExternalPlatform($this->getExternalId(), $this->getId()))
		{
			$this->getPlatform()->deactivate();
		}
	}

	protected function updateActiveFlag($direction)
	{
		$value = $direction ? Table::BOOLEAN_Y : Table::BOOLEAN_N;
		$updateResult = Table::update($this->getId(), [ 'ACTIVE' => $value ]);

		Market\Result\Facade::handleException($updateResult);
		$this->setField('ACTIVE', $value);
	}

	public function getServiceCode()
	{
		return $this->getField('TRADING_SERVICE');
	}

	public function getSiteId()
	{
		return $this->getField('SITE_ID');
	}

	public function getExternalId()
	{
		return $this->getField('EXTERNAL_ID');
	}

	public function getEnvironment()
	{
		if ($this->environment === null)
		{
			$this->environment = $this->loadEnvironment();
		}

		return $this->environment;
	}

	protected function loadEnvironment()
	{
		return Market\Trading\Entity\Manager::createEnvironment();
	}

	public function getPlatform()
	{
		$serviceCode = $this->getServiceCode();
		$siteId = $this->getSiteId();
		$platformRegistry = $this->getEnvironment()->getPlatformRegistry();

		return $platformRegistry->getPlatform($serviceCode, $siteId);
	}

	public function wakeupService()
	{
		$service = $this->getService();
		$settingValues = $this->getSettingsValues();

		$service->getOptions()->setValues($settingValues);
		$service->wakeup();

		return $service;
	}

	public function getService()
	{
		if ($this->service === null)
		{
			$this->service = $this->loadService();
		}

		return $this->service;
	}

	protected function loadService()
	{
		$serviceCode = $this->getServiceCode();

		return Market\Trading\Service\Manager::createProvider($serviceCode);
	}

	/**
	 * @return Market\Trading\Settings\Collection
	 */
	public function getSettings()
	{
		return $this->getChildCollection('SETTINGS');
	}

	public function getSettingsValues()
	{
		return array_merge(
			$this->getSettings()->getValues(),
			[
				'SETUP_ID' => $this->getId(),
				'SITE_ID' => $this->getSiteId(),
				'PLATFORM_ID' => $this->getExternalId(),
			]
		);
	}

	protected function getChildCollectionReference($fieldKey)
	{
		$result = null;

		switch ($fieldKey)
		{
			case 'SETTINGS':
				$result = Market\Trading\Settings\Collection::getClassName();
			break;
		}

		return $result;
	}
}