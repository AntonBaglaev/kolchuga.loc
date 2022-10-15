<?php

namespace Yandex\Market\Trading\Entity\Sale;

use Yandex\Market;
use Bitrix\Main;

class AnonymousUser extends User
{
	/** @var Environment */
	protected $environment;
	protected $serviceCode;
	protected $siteId;

	protected static function includeMessages()
	{
		parent::includeMessages();
		Main\Localization\Loc::loadMessages(__FILE__);
	}

	public function __construct(Environment $environment, $serviceCode, $siteId)
	{
		parent::__construct($environment, []);
		$this->serviceCode = $serviceCode;
		$this->siteId = $siteId;
	}

	public function checkInstall()
	{
		$userId = $this->getOptionValue();

		if ($userId !== null)
		{
			if (!$this->isExistUser($userId))
			{
				$this->id = null;
				$this->releaseOptionValue();
			}
			else
			{
				$this->clearUserPhoneAuth($userId);
			}
		}
	}

	public function getId()
	{
		$result = $this->getOptionValue();

		if ($result === null)
		{
			$result = parent::getId();
		}

		return $result;
	}

	protected function getSearchFilters()
	{
		return [
			[ '=XML_ID' => $this->getXmlId() ],
		];
	}

	public function install(array $data = [])
	{
		$result = parent::install($data);

		if ($result->isSuccess())
		{
			$this->saveOptionValue($result->getId());
		}

		return $result;
	}

	protected function getOptionName()
	{
		return 'trading_' . $this->serviceCode . '_user_id';
	}

	protected function getOptionValue()
	{
		$name = $this->getOptionName();
		$value = (int)Market\Config::getOption($name);
		$result = null;

		if ($value > 0)
		{
			$result = $value;
		}

		return $result;
	}

	protected function saveOptionValue($userId)
	{
		$name = $this->getOptionName();

		Market\Config::setOption($name, $userId);
	}

	protected function releaseOptionValue()
	{
		$name = $this->getOptionName();

		Market\Config::removeOption($name);
	}

	protected function getDefaultData()
	{
		return [
			'LID' => $this->siteId,
			'EMAIL' => $this->serviceCode . 'anonymous@market.yandex.ru',
			'ACTIVE' => 'N',
			'NAME' => static::getLang('TRADING_ENTITY_SALE_ANONYMOUS_USER_NAME'),
			'XML_ID' => $this->getXmlId(),
			'EXTERNAL_AUTH_ID' => 'saleanonymous',
		];
	}

	protected function getXmlId()
	{
		return 'yamarket_' . $this->serviceCode . '_anonymous';
	}

	protected function isExistUser($id)
	{
		$id = (int)$id;
		$result = false;

		if ($id > 0)
		{
			$query = Main\UserTable::getList([
				'filter' => [ '=ID' => $id ],
				'select' => [ 'ID' ],
			]);

			$result = (bool)$query->fetch();
		}

		return $result;
	}

	protected function clearUserPhoneAuth($id)
	{
		$id = (int)$id;

		if ($id > 0 && $this->hasPhoneRegistration())
		{
			$query = Main\UserPhoneAuthTable::getList([
				'select' => [ 'USER_ID' ],
				'filter' => [
					'=USER_ID' => $id,
					'=CONFIRMED' => 'N',
				],
			]);

			if ($row = $query->fetch())
			{
				Main\UserPhoneAuthTable::delete($row['USER_ID']);
			}
		}
	}
}