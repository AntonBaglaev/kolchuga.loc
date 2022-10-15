<?
IncludeModuleLangFile(__FILE__);

if (!CModule::IncludeModule('iblock') || !CModule::IncludeModule('sale'))
{
	CAdminNotify::Add(Array(
		"MESSAGE" => GetMessage("INTERVOLGA_CONVERSION_DLA_RABOTY_RESENIA") . ' <a href="/bitrix/admin/module_admin.php">' . GetMessage("INTERVOLGA_CONVERSION_USTANOVLENY_MODULI") . '"</a>',
		"TAG" => "CONVERSION_IBLOCK_SALE",
		"MODULE_ID" => "intervolga.conversion",
		"ENABLE_CLOSE" => "Y"
	));

	return false;
}

Class CIntervolgaConversion
{
	const MODULE_ID = 'intervolga.conversion';

	function OnBasketAdd($ID, $arFields)
	{
		if (!CModule::IncludeModule(self::MODULE_ID))
			return;

		global $APPLICATION;

		self::debug($APPLICATION->get_cookie('CONVERSION_CHECK'), "OnBasketAdd / CONVERSION_CHECK");

		if ($APPLICATION->get_cookie('CONVERSION_CHECK') !== 'N')
		{
			self::debug(true, "OnBasketAdd / set BASKET_ADDED");

			$APPLICATION->set_cookie("BASKET_ADDED_G", 'Y', time() + 60 * 60 * 1, '/', '');
			$APPLICATION->set_cookie("BASKET_ADDED_Y", 'Y', time() + 60 * 60 * 1, '/', '');
		}
	}

	function debug($var, $message = false)
	{
		if (!defined("CONVERSION_DEBUG") || !CONVERSION_DEBUG)
			return;

		$result = "HTTP_REFERER: " . $_SERVER["HTTP_REFERER"] . "\n";
		$result .= "REQUEST_URI: " . $_SERVER["REQUEST_URI"] . "\n";
		$result .= "HTTP_USER_AGENT: " . $_SERVER["HTTP_USER_AGENT"] . "\n";

		$result .= $message ? $message . " :: " : "";
		$result .= print_r($var, true);

		AddMessage2Log($result, self::MODULE_ID);
	}

	function OnOrderAdd($orderID, $arOrder)
	{
		if (!CModule::IncludeModule(self::MODULE_ID))
			return;

		global $APPLICATION;

		self::debug($APPLICATION->get_cookie('CONVERSION_CHECK'), "OnOrderAdd / CONVERSION_CHECK");

		if ($APPLICATION->get_cookie('CONVERSION_CHECK') !== 'N')
		{
			$order = CSaleOrder::GetByID($orderID);

			self::debug($order, "OnOrderAdd / order");


			self::debug(true, "OnOrderAdd / set ORDER_ADDED");

			$APPLICATION->set_cookie("ORDER_ADDED_G", $order["ACCOUNT_NUMBER"], time() + 60 * 60 * 1, '/', '');
			$APPLICATION->set_cookie("ORDER_ADDED_Y", $order["ACCOUNT_NUMBER"], time() + 60 * 60 * 1, '/', '');


			self::debug($orderID, "OnOrderAdd / orderID");
			self::debug($order["ACCOUNT_NUMBER"], "OnOrderAdd / ACCOUNT_NUMBER");
			self::debug($order["USER_ID"], "OnOrderAdd / USER_ID");
			self::debug(md5("ORDER" . $order["ACCOUNT_NUMBER"] . $order["USER_ID"]), "OnOrderAdd / set ORDER_CHECK");

			$APPLICATION->set_cookie("ORDER_CHECK", md5("ORDER" . $order["ACCOUNT_NUMBER"] . $order["USER_ID"]), time() + 60 * 60 * 1, '/', '');
		}

	}

	function OnProlog()
	{
		// Initialize module before request processing
		// for capturing 1-click-buy
		CModule::IncludeModule(self::MODULE_ID);
	}

	function OnEpilog()
	{
		if (!CModule::IncludeModule(self::MODULE_ID))
			return;

		global $APPLICATION;

		if (!defined('INTERVOLGA_CONVERSION_AJAX'))
			$APPLICATION->AddHeadScript("/bitrix/js/intervolga.conversion/conversion.min.js");

		$order = self::getOrder();

		self::debug($order, "OnEpilog / order");

		if (is_array($order))
		{
			$APPLICATION->AddHeadString('<script type="text/javascript">window.eshopOrder=' . CUtil::PhpToJsObject($order) . '</script>');
		}
	}

	function getOrder()
	{
		global $APPLICATION;

		self::debug($APPLICATION->get_cookie('CONVERSION_CHECK'), "getOrder / CONVERSION_CHECK");

		if ($APPLICATION->get_cookie('CONVERSION_CHECK') === 'N') return;

		$orderNumber = $APPLICATION->get_cookie("ORDER_ADDED_G");

		self::debug($orderNumber, "getOrder / orderNumber_G");

		if (strlen($orderNumber) == 0)
		{
			$orderNumber = $APPLICATION->get_cookie("ORDER_ADDED_Y");

			self::debug($orderNumber, "getOrder / orderNumber_Y");
		}

		if (strlen($orderNumber) == 0)
			return;

		//$arOrder = CSaleOrder::GetByID($orderID);
		$arOrder = self::getOrderByNumber($orderNumber);
		if ($arOrder === null)
			return;

		self::debug($arOrder, "getOrder / arOrder");


		self::debug(md5("ORDER" . $orderNumber . $arOrder["USER_ID"]), "getOrder / ORDER_CHECK");

		if ($APPLICATION->get_cookie('ORDER_CHECK') !== md5("ORDER" . $orderNumber . $arOrder["USER_ID"]))
		{
			$APPLICATION->set_cookie("ORDER_ADDED_G", 0, time() + 60 * 60 * 1, '/', '');
			$APPLICATION->set_cookie("ORDER_ADDED_Y", 0, time() + 60 * 60 * 1, '/', '');

			return;
		}

		$orderProps = CSaleOrderPropsValue::GetOrderProps($arOrder["ID"]);
		while ($arProps = $orderProps->Fetch())
		{
			if ($arProps["TYPE"] == "LOCATION")
			{
				$arVal = CSaleLocation::GetByID($arProps["VALUE"], LANGUAGE_ID);
				$arOrder["COUNTRY"] = $arVal["COUNTRY_NAME_LANG"];
				$arOrder["REGION"] = $arVal["REGION_NAME_LANG"];
				$arOrder["CITY"] = $arVal["CITY_NAME_LANG"];
			}
		}

		$arBasketItems = array();
		$dbBasketItems = CSaleBasket::GetList(
			array(), array("ORDER_ID" => $arOrder["ID"]), false,
			false, array("PRODUCT_ID", "PRICE", "CURRENCY", "QUANTITY", "NAME")
		);

		$itemsIDs = array();
		while ($arItem = $dbBasketItems->Fetch())
		{
			$arItem["NAME"] = str_replace("'", '"', $arItem["NAME"]);
			$arBasketItems[] = $arItem;
			$itemsIDs[] = $arItem["PRODUCT_ID"];
		}

		$productSections = array();
		if (count($itemsIDs) > 0)
		{
			$sections = CIBlockElement::GetElementGroups($itemsIDs, true);
			while ($arSection = $sections->Fetch())
			{
				$productSections[$arSection["IBLOCK_ELEMENT_ID"]] = $arSection["NAME"];
			}
		}

		$eshopOrder = array(
			'id' => $arOrder["ACCOUNT_NUMBER"],
			'affiliation' => GetMessageJS("INTERVOLGA_CONVERSION_INTERNET_MAGAZIN"),
			'revenue' => $arOrder["PRICE"],
			'shipping' => $arOrder["PRICE_DELIVERY"],
			'tax' => $arOrder["TAX_VALUE"],
			'currency' => $arOrder["CURRENCY"],
			'city' => isset($arOrder["CITY"]) ? $arOrder["CITY"] : "",
			'state' => isset($arOrder["REGION"]) ? $arOrder["REGION"] : "",
			'country' => isset($arOrder["COUNTRY"]) ? $arOrder["COUNTRY"] : "",
			'items' => array()
		);
		foreach ($arBasketItems as $arItem)
		{
			$eshopOrder['items'][] = array(
				'id' => $arItem["PRODUCT_ID"],
				'name' => $arItem["NAME"],
				'category' => isset($productSections[$arItem["PRODUCT_ID"]]) ? $productSections[$arItem["PRODUCT_ID"]] : "",
				'price' => $arItem["PRICE"],
				'quantity' => intval($arItem["QUANTITY"]),
				'currency' => $arItem["CURRENCY"]
			);
		}

		self::debug($eshopOrder, "getOrder / eshopOrder");

		return $eshopOrder;
	}

	function getOrderByNumber($number)
	{
		$rsOrders = CSaleOrder::GetList(
			array("ID" => "DESC"),
			array("ACCOUNT_NUMBER" => $number),
			false,
			array("nTopCount" => 1) //just one order
		);
		if ($order = $rsOrders->Fetch())
		{
			self::debug($order, "getOrderByNumber / order");

			return $order;
		}
		else
		{
			self::debug(null, "getOrderByNumber / order");

			return null;
		}
	}

	function OnAfterUserAuthorize($user_fields)
	{
		if (!CModule::IncludeModule(self::MODULE_ID))
			return;

		global $USER, $APPLICATION;

		if ($USER->IsAdmin())
		{
			$APPLICATION->set_cookie("CONVERSION_CHECK", 'N', false, '/', '');

			self::debug('N', "OnAfterUserAuthorize / CONVERSION_CHECK");
		}
		else
		{
			$APPLICATION->set_cookie("CONVERSION_CHECK", 'Y', false, '/', '');

			self::debug('Y', "OnAfterUserAuthorize / CONVERSION_CHECK");
		}
	}
}

?>