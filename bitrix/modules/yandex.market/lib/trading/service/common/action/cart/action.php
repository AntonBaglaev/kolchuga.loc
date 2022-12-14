<?php

namespace Yandex\Market\Trading\Service\Common\Action\Cart;

use Yandex\Market;
use Bitrix\Main;
use Yandex\Market\Trading\Entity as TradingEntity;
use Yandex\Market\Trading\Service as TradingService;

class Action extends TradingService\Common\Action\HttpAction
{
	/** @var Request */
	protected $request;
	/** @var TradingEntity\Reference\User */
	protected $user;
	/** @var TradingEntity\Reference\Order */
	protected $order;
	protected $basketMap = [];
	protected $basketErrors = [];
	protected $basketInvalidProducts = [];
	protected $basketInvalidData = [];

	protected function createRequest(Main\HttpRequest $request, Main\Server $server)
	{
		return new Request($request, $server);
	}

	public function getAudit()
	{
		return Market\Logger\Trading\Audit::CART;
	}

	public function process()
	{
		$this->createUser();
		$this->createOrder();

		$this->initializeOrder();
		$this->fillOrder();
		$this->finalizeOrder();

		$this->collectResponse();
	}

	protected function createUser()
	{
		$userRegistry = $this->environment->getUserRegistry();

		$this->user = $userRegistry->getAnonymousUser($this->provider->getCode(), $this->getSiteId());
	}

	protected function createOrder()
	{
		$orderRegistry = $this->environment->getOrderRegistry();
		$userId = $this->getUserId();
		$siteId = $this->getSiteId();
		$currency = $this->getCurrency();

		$this->order = $orderRegistry->createOrder($siteId, $userId, $currency);
	}

	protected function initializeOrder()
	{
		$this->fillPersonType();
		$this->order->initialize();
	}

	protected function fillOrder()
	{
		$this->fillXmlId();
		$this->fillProfile();
		$this->fillRegion();
		$this->fillBasket();
	}

	protected function finalizeOrder()
	{
		$this->order->finalize();
	}

	protected function fillXmlId()
	{
		$platform = $this->getPlatform();

		$this->order->fillXmlId(null, $platform);
	}

	protected function fillPersonType()
	{
		$personType = $this->provider->getOptions()->getPersonType();

		$this->order->setPersonType($personType);
	}

	protected function fillProfile()
	{
		$options = $this->provider->getOptions();
		$profileId = (string)$options->getProfileId();
		$values = null;

		if ($profileId !== '')
		{
			$profile = $this->environment->getProfile();
			$values = $profile->getValues($profileId);
		}

		if (!empty($values))
		{
			$this->order->fillProperties($values);
		}
	}

	protected function fillRegion()
	{
		$location = $this->environment->getLocation();
		$requestRegion = $this->request->getCart()->getDelivery()->getRegion()->getFields();
		$locationId = $location->getLocation($requestRegion);

		$this->order->setLocation($locationId);
	}

	protected function fillBasket()
	{
		$items = $this->request->getCart()->getItems();
		$offerMap = $this->getOfferMap($items);
		$allProductData = $this->getBasketData($items, $offerMap);

		/** @var Market\Api\Model\Cart\Item $item */
		foreach ($items as $itemIndex => $item)
		{
			$offerId = $item->getOfferId();
			$productId = $this->getProductId($offerId, $offerMap);

			if ($productId !== null)
			{
				$meaningfulValues = $item->getMeaningfulValues();
				$quantity = $item->getCount();
				$data = isset($allProductData[$productId]) ? $allProductData[$productId] : null;
				$dataKeyWithQuantity = $productId . '|' . $quantity;

				if (isset($allProductData[$dataKeyWithQuantity]))
				{
					$data = ($data !== null)
						? $data + $allProductData[$dataKeyWithQuantity]
						: $allProductData[$dataKeyWithQuantity];
				}

				if (!empty($meaningfulValues))
				{
					$data = ($data !== null)
						? $data + $meaningfulValues
						: $meaningfulValues;
				}

				if (isset($data['ERROR']))
				{
					$addResult = new Main\Result();
					$dataError = $data['ERROR'] instanceof Main\Error
						? $data['ERROR']
						: new Main\Error($data['ERROR']);

					$addResult->addError($dataError);
				}
				else
				{
					$addResult = $this->order->addProduct($productId, $quantity, $data);
				}

				$addData = $addResult->getData();

				if (isset($addData['BASKET_CODE']))
				{
					$this->basketMap[$itemIndex] = $addData['BASKET_CODE'];
				}
				else
				{
					$this->basketInvalidProducts[$itemIndex] = $productId;
					$this->basketInvalidData[$itemIndex] = $data;
				}

				if (!$addResult->isSuccess())
				{
					$this->basketErrors[$itemIndex] = implode(PHP_EOL, $addResult->getErrorMessages());
				}
			}
		}
	}

	protected function getOfferMap(Market\Api\Model\Cart\ItemCollection $items)
	{
		$skuMap = $this->provider->getOptions()->getProductSkuMap();
		$result = null;

		if (!empty($skuMap))
		{
			$product = $this->environment->getProduct();
			$offerIds = $items->getOfferIds();

			$result = $product->getOfferMap($offerIds, $skuMap);
		}

		return $result;
	}

	protected function getBasketData(Market\Api\Model\Cart\ItemCollection $items, $offerMap = null)
	{
		$context = [
			'USER_ID' => $this->getUserId(),
			'SITE_ID' => $this->getSiteId(),
			'CURRENCY' => $this->getCurrency(),
		];

		if ($offerMap !== null)
		{
			$productIds = array_values($offerMap);
			$quantities = $items->getQuantities($offerMap);
		}
		else
		{
			$productIds = $items->getOfferIds();
			$quantities = $items->getQuantities();
		}

		return $this->mergeBasketData(
			$this->getProductData($productIds, $quantities, $context),
			$this->getPriceData($productIds, $quantities, $context)
		);
	}

	protected function mergeBasketData($productData, $priceData)
	{
		$keys = array_merge(array_keys($productData), array_keys($priceData));
		$keys = array_unique($keys);
		$result = [];

		foreach ($keys as $key)
		{
			$hasProductData = isset($productData[$key]);
			$hasPriceData = isset($priceData[$key]);

			if ($hasProductData && $hasPriceData)
			{
				$result[$key] = $priceData[$key] + $productData[$key];
			}
			else if ($hasProductData)
			{
				$result[$key] = $productData[$key];
			}
			else if ($hasPriceData)
			{
				$result[$key] = $priceData[$key];
			}
		}

		return $result;
	}

	protected function getProductData($productIds, $quantities, $context)
	{
		$product = $this->environment->getProduct();

		return $product->getBasketData($productIds, $quantities, $context);
	}

	protected function getPriceData($productIds, $quantities, $context)
	{
		$options = $this->provider->getOptions();
		$price = $this->environment->getPrice();
		$context += [
			'SOURCE' => $options->getPriceSource(),
			'PRICE_TYPE' => $options->getPriceTypes(),
			'USE_DISCOUNT' => $options->usePriceDiscount(),
		];

		return $price->getBasketData($productIds, $quantities, $context);
	}

	protected function collectResponse()
	{
		$this->collectDelivery();
		$this->collectItems();
		$this->collectPaymentMethods();
		$this->collectTaxSystem();
	}

	protected function collectDelivery()
	{
		$this->response->setField('cart.deliveryCurrency', $this->request->getCart()->getCurrency());
		$this->response->setField('cart.deliveryOptions', []);
	}

	protected function collectTaxSystem()
	{
		$taxSystem = $this->getTaxSystem();

		if ($taxSystem !== '')
		{
			$this->response->setField('cart.taxSystem', $taxSystem);
		}
	}

	protected function collectItems()
	{
		$items = $this->request->getCart()->getItems();
		$hasValidItems = false;
		$hasTaxSystem = ($this->getTaxSystem() !== '');
		$disabledKeys = [];

		if (!$hasTaxSystem)
		{
			$disabledKeys['vat'] = true;
		}

		/** @var Market\Api\Model\Cart\Item $item */
		foreach ($items as $itemIndex => $item)
		{
			$offerId = $item->getOfferId();
			$responseItem = [
				'offerId' => $offerId,
				'count' => 0,
				'delivery' => false,
				'vat' => 'NO_VAT',
			];

			if (isset($this->basketMap[$itemIndex]))
			{
				$basketCode = $this->basketMap[$itemIndex];
				$basketResult = $this->order->getBasketItemData($basketCode);

				if ($basketResult->isSuccess())
				{
					$hasValidItems = true;
					$basketData = $basketResult->getData();
					$responseItem['count'] = (float)$basketData['QUANTITY'];
					$responseItem['delivery'] = true;
					$responseItem['price'] = (float)$basketData['PRICE'];
					$responseItem['vat'] = Market\Data\Vat::convertForService($basketData['VAT_RATE']);
				}
			}

			$responseItem = array_diff_key($responseItem, $disabledKeys);

			$this->response->pushField('cart.items', $responseItem);
		}

		if (!$hasValidItems)
		{
			$this->response->setField('cart.items', []);
		}
	}

	protected function collectPaymentMethods()
	{
		$this->response->setField('cart.paymentMethods', []);
	}

	protected function getProductId($offerId, $offerMap)
	{
		$result = null;

		if ($offerMap === null)
		{
			$result = $offerId;
		}
		else if (isset($offerMap[$offerId]))
		{
			$result = $offerMap[$offerId];
		}

		return $result;
	}

	protected function getUserId()
	{
		return $this->user->getId();
	}

	protected function getCurrency()
	{
		$requestCurrency = $this->request->getCart()->getCurrency();
		$normalizedCurrency = Market\Data\Currency::getCurrency($requestCurrency);

		if ($normalizedCurrency === false)
		{
			$result = $requestCurrency;
		}
		else
		{
			$result = $normalizedCurrency;
		}

		return $result;
	}

	protected function getTaxSystem()
	{
		return (string)$this->provider->getOptions()->getTaxSystem();
	}
}