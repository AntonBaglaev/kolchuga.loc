<?php

namespace Starrys\Cashbox;

use Bitrix\Main;
use Bitrix\Sale\Cashbox\Check;
use Bitrix\Sale\Result;

Main\Localization\Loc::loadMessages(__FILE__);

/**
 * Class AdvancePaymentCheck
 * @package Bitrix\Sale\Cashbox
 */

class PartPaymentCheck extends Check
{
	/**
	 * @return string
	 */
	public static function getType()
	{
		return 'partpayment';
	}

	/**
	 * @return string
	 */
	public static function getName()
	{
		return Main\Localization\Loc::getMessage('STARRYS.CASHBOX_PART_PAYMENT_NAME');
	}

	/**
	 * @return string
	 */
	public static function getCalculatedSign()
	{
		return static::CALCULATED_SIGN_INCOME;
	}

	/**
	 * @return array
	 */
	protected function extractDataInternal()
	{
		$result = parent::extractDataInternal();


		return $result;
	}

	/**
	 * @return Result
	 * @throws Main\ArgumentException
	 * @throws Main\ArgumentNullException
	 * @throws Main\ArgumentOutOfRangeException
	 * @throws Main\ArgumentTypeException
	 * @throws Main\LoaderException
	 * @throws Main\NotImplementedException
	 * @throws Main\ObjectPropertyException
	 * @throws Main\SystemException
	 */
	public function validate()
	{
		$result = new Result();

		$data = $this->extractData();

		if (!isset($data['PRODUCTS']))
		{
			$result->addError(new Main\Error(Main\Localization\Loc::getMessage('SALE_CASHBOX_SELL_ERROR_NO_PRODUCTS')));
			return $result;
		}

		return $result;
	}

	/**
	 * @return string
	 */
	public static function getSupportedRelatedEntityType()
	{
		return static::SUPPORTED_ENTITY_TYPE_NONE;
	}

}