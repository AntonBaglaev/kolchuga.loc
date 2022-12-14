<?php

namespace Yandex\Market\Trading\Service\Beru\Action\SendStatus;

use Yandex\Market;
use Bitrix\Main;
use Yandex\Market\Trading\Entity as TradingEntity;
use Yandex\Market\Trading\Service as TradingService;

class Action extends TradingService\Common\Action\SendStatus\Action
{
	/** @var TradingService\Beru\Provider */
	protected $provider;

	public function __construct(TradingService\Beru\Provider $provider, TradingEntity\Reference\Environment $environment, array $data)
	{
		parent::__construct($provider, $environment, $data);
	}

	protected function createRequest(array $data)
	{
		return new Request($data);
	}

	protected function isChangedOrderStatus($orderId, $state)
	{
		$serviceKey = $this->provider->getUniqueKey();
		$storedStatusEncoded = Market\Trading\State\OrderStatus::getValue($serviceKey, $orderId);
		$result = false;

		if ($storedStatusEncoded === null)
		{
			$result = true;
		}
		else
		{
			list($submitStatus, $submitSubStatus) = $this->getExternalStatus($state);
			list($storedStatus, $storedSubStatus) = explode(':', $storedStatusEncoded);

			if ($storedStatus !== $submitStatus)
			{
				$result = true;
			}
			else if (
				$submitStatus === TradingService\Beru\Status::STATUS_PROCESSING
				&& $submitSubStatus !== $storedSubStatus
			)
			{
				$result = true;
			}
		}

		return $result;
	}

	protected function checkHasStatus($orderId, $state)
	{
		$result = false;

		try
		{
			$serviceStatuses = $this->provider->getStatus();
			$externalOrder = $this->loadExternalOrder($orderId);
			$orderStatus = $externalOrder->getStatus();
			$subStatus = $externalOrder->getSubStatus();

			switch ($state)
			{
				case TradingService\Beru\Status::STATE_SHOP_FAILED:
					$result = $externalOrder->isCancelRequested() || $serviceStatuses->isCanceled($orderStatus);
				break;

				case TradingService\Beru\Status::STATE_READY_TO_SHIP:
					$availableStates = [
						TradingService\Beru\Status::STATE_READY_TO_SHIP => true,
						TradingService\Beru\Status::STATE_SHIPPED => true,
					];

					$result =
						$serviceStatuses->isLeftProcessing($orderStatus)
						|| ($serviceStatuses->isProcessing($orderStatus) && isset($availableStates[$subStatus]));
				break;

				case TradingService\Beru\Status::STATE_SHIPPED:
					$result =
						$serviceStatuses->isLeftProcessing($orderStatus)
						|| ($serviceStatuses->isProcessing($orderStatus) && $subStatus === $state);
				break;
			}
		}
		catch (Market\Exceptions\Api\Request $exception)
		{
			$result = false;
		}

		return $result;
	}

	protected function getExternalStatus($state)
	{
		if ($state === TradingService\Beru\Status::STATE_SHOP_FAILED)
		{
			$status = TradingService\Beru\Status::STATUS_CANCELLED;
		}
		else
		{
			$status = TradingService\Beru\Status::STATUS_PROCESSING;
		}

		return [ $status, $state ];
	}
}