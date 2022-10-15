<?php

namespace Yandex\Market\Trading\Service\Common;

use Yandex\Market;
use Bitrix\Main;
use Yandex\Market\Trading\Entity as TradingEntity;

abstract class Installer extends Market\Trading\Service\Reference\Installer
{
	public function install(TradingEntity\Reference\Environment $environment, $siteId, array $context = [])
	{
		$this->installRoute($environment, $siteId, $context);
		$this->installUserEnvironment($environment, $siteId, $context);
	}

	protected function installRoute(TradingEntity\Reference\Environment $environment, $siteId, array $context)
	{
		$route = $environment->getRoute();

		$route->installPublic($siteId);
	}

	protected function installUserEnvironment(TradingEntity\Reference\Environment $environment, $siteId, array $context)
	{
		$group = $this->installUserGroup($environment, $siteId);
		$user = $this->installAnonymousUser($environment, $siteId);

		$this->attachUserToGroup($user, $group);
	}

	protected function installUserGroup(TradingEntity\Reference\Environment $environment, $siteId)
	{
		$userGroup = $this->getUserGroup($environment, $siteId);

		if (!$userGroup->isInstalled())
		{
			$data = $this->getUserGroupData();
			$installResult = $userGroup->install($data);

			Market\Result\Facade::handleException($installResult);
		}

		return $userGroup;
	}

	protected function getUserGroup(TradingEntity\Reference\Environment $environment, $siteId)
	{
		$userGroupRegistry = $environment->getUserGroupRegistry();

		return $userGroupRegistry->getGroup($this->provider->getCode(), $siteId);
	}

	abstract protected function getUserGroupData();

	protected function installAnonymousUser(TradingEntity\Reference\Environment $environment, $siteId)
	{
		$userRegistry = $environment->getUserRegistry();
		$user = $userRegistry->getAnonymousUser($this->provider->getCode(), $siteId);

		$user->checkInstall();

		if (!$user->isInstalled())
		{
			$installResult = $user->install();

			Market\Result\Facade::handleException($installResult);
		}

		return $user;
	}

	protected function attachUserToGroup(TradingEntity\Reference\User $user, TradingEntity\Reference\UserGroup $group)
	{
		$groupId = $group->getId();
		$attachResult = $user->attachGroup($groupId);

		Market\Result\Facade::handleException($attachResult);
	}

	public function uninstall(TradingEntity\Reference\Environment $environment, $siteId, array $context = [])
	{
		$this->uninstallRoute($environment, $siteId, $context);
	}

	protected function uninstallRoute(TradingEntity\Reference\Environment $environment, $siteId, array $context)
	{
		if (!$context['SITE_USED'])
		{
			$route = $environment->getRoute();
			$route->uninstallPublic($siteId);
		}
	}
}