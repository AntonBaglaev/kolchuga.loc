<?php

namespace Yandex\Market\Component\Setup;

use Bitrix\Main;
use Yandex\Market;

class GridList extends Market\Component\Model\GridList
{
	protected $uiService;

	public function prepareComponentParams($params)
	{
		global $APPLICATION;

		$result = parent::prepareComponentParams($params);
		$result['SERVICE'] = trim($params['SERVICE']);

		if ($result['SERVICE'] !== '')
		{
			$result['BASE_URL'] = $APPLICATION->GetCurPageParam(
				http_build_query([ 'service' => $result['SERVICE'] ]),
				[ 'service' ]
			);
		}

		return $result;
	}

	protected function getReferenceFields()
	{
		$result = parent::getReferenceFields();
		$result['IBLOCK'] = [];

		return $result;
	}

	public function getDefaultFilter()
	{
		$result = parent::getDefaultFilter();
		$serviceFilter = $this->getUiServiceFilter();

		if ($serviceFilter !== null)
		{
			$result[] = $serviceFilter;
		}

		return $result;
	}

	protected function getUiServiceFilter()
	{
		$uiService = $this->getUiService();
		$exportServices = $uiService->getExportServices();

		if (!$uiService->isInverted())
		{
			$result = [
				'=EXPORT_SERVICE' => $exportServices,
			];
		}
		else if (!empty($exportServices))
		{
			$result = [
				'!=EXPORT_SERVICE' => $exportServices,
			];
		}
		else
		{
			$result = null;
		}

		return $result;
	}

	public function getFields(array $select = [])
	{
		$result = parent::getFields($select);
		$result = $this->excludeServiceDisabledFields($result);

		if (isset($result['EXPORT_SERVICE']))
		{
			$result['EXPORT_SERVICE'] = $this->modifyExportServiceField($result['EXPORT_SERVICE']);

			$this->resolveExportServiceFilter($result['EXPORT_SERVICE']);
		}

		if (isset($result['EXPORT_FORMAT'], $result['EXPORT_SERVICE']))
		{
			$result['EXPORT_FORMAT'] = $this->modifyExportFormatField($result['EXPORT_FORMAT'], $result['EXPORT_SERVICE']);
		}

		return $result;
	}

	protected function excludeServiceDisabledFields($fields)
	{
		$uiService = $this->getUiService();
		$disabledFields = $uiService->getExportSetupDisabledFields();
		$disabledFieldsMap = array_flip($disabledFields);

		return array_diff_key($fields, $disabledFieldsMap);
	}

	protected function modifyExportServiceField($field)
	{
		if (isset($field['VALUES']))
		{
			$uiService = $this->getUiService();
			$exportServices = $uiService->getExportServices();
			$exportServicesMap = array_flip($exportServices);
			$isInverted = $uiService->isInverted();

			foreach ($field['VALUES'] as $optionKey => $option)
			{
				$isExists = isset($exportServicesMap[$option['ID']]);

				if ($isExists === $isInverted)
				{
					unset($field['VALUES'][$optionKey]);
				}
			}
		}

		return $field;
	}

	protected function resolveExportServiceFilter($field)
	{
		if (!isset($field['VALUES']) || count($field['VALUES']) < 2)
		{
			$filterFields = $this->getComponentParam('FILTER_FIELDS');
			$filterIndex = array_search($field['FIELD_NAME'], $filterFields, true);

			if ($filterIndex !== false)
			{
				array_splice($filterFields, $filterIndex, 1);

				$this->setComponentParam('FILTER_FIELDS', $filterFields);
			}
		}
	}

	protected function modifyExportFormatField($field, $serviceField)
	{
		if (isset($field['VALUES'], $serviceField['VALUES']))
		{
			$exportServices = array_column($serviceField['VALUES'], 'ID');
			$existsTypes = [];

			foreach ($exportServices as $service)
			{
				$types = Market\Export\Xml\Format\Manager::getTypeList($service);

				if ($types !== null)
				{
					$existsTypes += array_flip($types);
				}
			}

			foreach ($field['VALUES'] as $optionKey => $option)
			{
				if (!isset($existsTypes[$option['ID']]))
				{
					unset($field['VALUES'][$optionKey]);
				}
			}
		}

		return $field;
	}

	protected function getUiService()
	{
		if ($this->uiService === null)
		{
			$this->uiService = $this->loadUiService();
		}

		return $this->uiService;
	}

	protected function loadUiService()
	{
		$serviceName = (string)$this->getComponentParam('SERVICE');

		if ($serviceName === '')
		{
			$result = Market\Ui\Service\Manager::getCommonInstance();
		}
		else
		{
			$result = Market\Ui\Service\Manager::getInstance($serviceName);
		}

		return $result;
	}
}