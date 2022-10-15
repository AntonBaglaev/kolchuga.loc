<?php

namespace Yandex\Market\Trading\Entity\Common;

use Yandex\Market;
use Bitrix\Main;
use Bitrix\Catalog;

class Store extends Market\Trading\Entity\Reference\Store
{
	use Market\Reference\Concerns\HasLang;

	const PRODUCT_FIELD_QUANTITY = 'CATALOG_QUANTITY';

	/** @var Environment */
	protected $environment;

	protected static function includeMessages()
	{
		Main\Localization\Loc::loadMessages(__FILE__);
	}

	public function __construct(Environment $environment)
	{
		parent::__construct($environment);
	}

	public function getEnum($siteId = null)
	{
		return array_merge(
			$this->getCatalogQuantityEnum(),
			$this->getCatalogStoreEnum($siteId)
		);
	}

	public function getDefaults()
	{
		return [
			static::PRODUCT_FIELD_QUANTITY,
		];
	}

	protected function getCatalogQuantityEnum()
	{
		return [
			[
				'ID' => static::PRODUCT_FIELD_QUANTITY,
				'VALUE' => static::getLang('TRADING_ENTITY_COMMON_STORE_CATALOG_QUANTITY', null, static::PRODUCT_FIELD_QUANTITY),
			],
		];
	}

	protected function getCatalogStoreEnum($siteId)
	{
		$result = [];
		$filter = [ '=ACTIVE' => 'Y' ];

		if ($siteId !== null)
		{
			$filter[] = [
				'LOGIC' => 'OR',
				[ '=SITE_ID' => $siteId ],
				[ 'SITE_ID' => false ],
			];
		}

		$query = Catalog\StoreTable::getList([
			'filter' => $filter,
			'select' => [ 'ID', 'TITLE', 'ADDRESS' ]
		]);

		while ($row = $query->fetch())
		{
			$storeTitle = (string)$row['TITLE'] !== '' ? $row['TITLE'] : $row['ADDRESS'];

			$result[] = [
				'ID' => $row['ID'],
				'VALUE' => '[' . $row['ID'] . '] ' . $storeTitle,
			];
		}

		return $result;
	}

	public function getAmounts($stores, $productIds)
	{
		$catalogQuantityIndex = array_search(static::PRODUCT_FIELD_QUANTITY, $stores, true);
		$quantityChain = [];

		if ($catalogQuantityIndex !== false)
		{
			array_splice($stores, $catalogQuantityIndex, 1);

			$quantityChain[] = $this->getQuantityFromProduct($productIds);
		}

		if (!empty($stores))
		{
			$quantityChain[] = $this->getQuantityFromStore($stores, $productIds);
		}

		return $this->mergeQuantityChain($quantityChain);
	}

	protected function getQuantityFromProduct($productIds)
	{
		$result = [];

		if (!empty($productIds) && Main\Loader::includeModule('catalog'))
		{
			foreach (array_chunk($productIds, 500) as $productIdChunk)
			{
				$query = Catalog\ProductTable::getList([
					'filter' => [ '=ID' => $productIdChunk ],
					'select' => [ 'ID', 'QUANTITY', 'QUANTITY_RESERVED', 'TIMESTAMP_X' ]
				]);

				while ($row = $query->fetch())
				{
					if ((float)$row['QUANTITY_RESERVED'] > 0)
					{
						$quantityList = [
							Market\Data\Trading\Stocks::TYPE_FIT => $row['QUANTITY'] + $row['QUANTITY_RESERVED'],
							Market\Data\Trading\Stocks::TYPE_AVAILABLE => $row['QUANTITY'],
						];
					}
					else
					{
						$quantityList = [
							Market\Data\Trading\Stocks::TYPE_FIT => $row['QUANTITY'],
						];
					}

					$result[] = [
						'ID' => $row['ID'],
						'TIMESTAMP_X' => $row['TIMESTAMP_X'],
						'QUANTITY_LIST' => $quantityList
					];
				}
			}
		}

		return $result;
	}

	protected function getQuantityFromStore($storeList, $productIdList)
	{
		$result = [];
		$storeList = (array)$storeList;

		Main\Type\Collection::normalizeArrayValuesByInt($storeList);

		if (
			!empty($storeList)
			&& !empty($productIdList)
			&& Main\Loader::includeModule('iblock')
			&& Main\Loader::includeModule('catalog')
		)
		{
			foreach (array_chunk($productIdList, 500) as $productIdChunk)
			{
				$amountList = [];

				$query = \CCatalogStoreProduct::GetList(
					[],
					[ '=STORE_ID' => $storeList, '=PRODUCT_ID' => $productIdChunk ],
					false,
					false,
					[ 'PRODUCT_ID', 'AMOUNT' ]
				);

				while ($row = $query->fetch())
				{
					if (!isset($amountList[$row['PRODUCT_ID']]))
					{
						$amountList[$row['PRODUCT_ID']] = 0;
					}

					$amountList[$row['PRODUCT_ID']] += $row['AMOUNT'];
				}

				if (!empty($amountList))
				{
					$queryProduct = Catalog\ProductTable::getList([
						'filter' => [ '=ID' => array_keys($amountList) ],
						'select' => [ 'ID', 'TIMESTAMP_X' ]
					]);

					while ($product = $queryProduct->fetch())
					{
						$result[] = [
							'ID' => $product['ID'],
							'TIMESTAMP_X' => $product['TIMESTAMP_X'],
							'QUANTITY' => $amountList[$product['ID']]
						];
					}
				}
			}
		}

		return $result;
	}

	protected function mergeQuantityChain($chain)
	{
		$result = [];

		if (count($chain) === 1)
		{
			$result = reset($chain);
		}
		else
		{
			$productMap = [];

			foreach ($chain as $quantityList)
			{
				foreach ($quantityList as $productData)
				{
					$productId = $productData['ID'];

					if (!isset($productMap[$productId]))
					{
						$resultLength = array_push($result, $productData);
						$productMap[$productId] = $resultLength - 1;
					}
					else
					{
						$resultIndex = $productMap[$productId];
						$resultData = &$result[$resultIndex];
						$hasResultDataQuantityList = isset($resultData['QUANTITY_LIST']);
						$hasProductDataQuantityList = isset($productData['QUANTITY_LIST']);

						if ($hasResultDataQuantityList && $hasProductDataQuantityList)
						{
							foreach ($productData['QUANTITY_LIST'] as $quantityType => $quantity)
							{
								if (!isset($resultData['QUANTITY_LIST'][$quantityType]))
								{
									$resultData['QUANTITY_LIST'][$quantityType] = $quantity;
								}
								else
								{
									$resultData['QUANTITY_LIST'][$quantityType] += $quantity;
								}
							}
						}
						else if ($hasResultDataQuantityList || $hasProductDataQuantityList)
						{
							$mergeData = $hasResultDataQuantityList ? $resultData : $productData;
							$mergeQuantity = $hasResultDataQuantityList ? $productData['QUANTITY'] : $resultData['QUANTITY'];
							$mergeTypes = [
								Market\Data\Trading\Stocks::TYPE_FIT => true,
								Market\Data\Trading\Stocks::TYPE_AVAILABLE => true,
							];

							foreach ($mergeData['QUANTITY_LIST'] as $quantityType => $quantity)
							{
								if (isset($mergeTypes[$quantityType]))
								{
									$mergeData['QUANTITY_LIST'][$quantityType] += $mergeQuantity;
								}
							}

							$resultData = $mergeData;
						}
						else
						{
							$resultData['QUANTITY'] += $productData['QUANTITY'];
						}

						unset($resultData);
					}
				}
			}
		}

		return $result;
	}
}