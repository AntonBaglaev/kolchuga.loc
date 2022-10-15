<?php

namespace Yandex\Market\Trading\Entity\Common;

use Yandex\Market;
use Bitrix\Main;

class UserGroup extends Market\Trading\Entity\Reference\UserGroup
{
	protected $id;

	public function getId()
	{
		if ($this->id === null)
		{
			$this->id = $this->searchGroup();
		}

		return $this->id;
	}

	public function install(array $data = [])
	{
		$fullData = $this->getDefaultData() + $data;
		$result = new Main\Entity\AddResult();

		$addProvider = new \CGroup();
		$addResult = $addProvider->Add($fullData);

		if ($addResult !== false)
		{
			$this->id = $addResult;
			$result->setId($addResult);
		}
		else
		{
			$error = new Main\Error($addProvider->LAST_ERROR);
			$result->addError($error);
		}

		return $result;
	}

	protected function getDefaultData()
	{
		return [
			'ACTIVE' => 'Y',
			'C_SORT' => 1000,
			'IS_SYSTEM' => 'Y',
			'ANONYMOUS' => 'N',
			'STRING_ID' => $this->getXmlId(),
		];
	}

	protected function searchGroup()
	{
		$result = null;

		$query = Main\GroupTable::getList([
			'filter' => [ '=STRING_ID' => $this->getXmlId(), ],
			'select' => [ 'ID', ],
			'limit' => 1,
		]);

		if ($row = $query->fetch())
		{
			$result = (int)$row['ID'];
		}

		return $result;
	}

	protected function getXmlId()
	{
		return 'yamarket_' . strtolower($this->serviceCode);
	}
}