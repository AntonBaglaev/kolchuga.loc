<?php

namespace Yandex\Market\Ui\Trading;

use Yandex\Market;
use Bitrix\Main;

class OrderList extends Market\Ui\Reference\Page
{
	use Market\Reference\Concerns\HasLang;

	protected static function includeMessages()
	{
		Main\Localization\Loc::loadMessages(__FILE__);
	}

	public function show()
	{
		$setupCollection = $this->getSetupCollection();
		$siteId = $this->getRequestSiteId();
		$setup = $this->resolveSetup($setupCollection, $siteId);

		$this->showSiteSelector($setupCollection, $siteId);
		$this->showOrderList($setup);
	}

	protected function showSiteSelector(Market\Trading\Setup\Collection $setupCollection, $selectedSiteId)
	{
		global $APPLICATION;

		if (count($setupCollection) > 1)
		{
			$redirectUrl = $APPLICATION->GetCurPageParam('', ['site']);
			$redirectUrl .= (strpos($redirectUrl, '?') === false ? '?' : '&') . 'site=';
			$onChange = "window.location = '" . $redirectUrl . "' + this.value;";
			$options = $this->buildSiteOptions($setupCollection);

			echo Market\Ui\UserField\View\Select::getControl($options, $selectedSiteId, [
				'onchange' => $onChange,
			]);
			echo '<br />';
			echo '<br />';
		}
	}

	protected function buildSiteOptions(Market\Trading\Setup\Collection $setupCollection)
	{
		$result = [];

		/** @var Market\Trading\Setup\Model $setup */
		foreach ($setupCollection as $setup)
		{
			$siteId = $setup->getSiteId();
			$siteEntity = $setup->getEnvironment()->getSite();
			$siteTitle =  '[' . $siteId . '] ' . $siteEntity->getTitle($siteId);

			$result[] = [
				'ID' => $siteId,
				'VALUE' => htmlspecialcharsbx($siteTitle),
			];
		}

		return $result;
	}

	protected function showOrderList(Market\Trading\Setup\Model $setup)
	{
		global $APPLICATION;

		$documents = $this->getPrintDocuments($setup);

		$this->initializePrintActions($setup, $documents);

		$APPLICATION->IncludeComponent('yandex.market:admin.grid.list', '', [
			'GRID_ID' => 'YANDEX_MARKET_ADMIN_TRADING_ORDER_LIST',
			'PROVIDER_TYPE' => 'TradingOrder',
			'CONTEXT_MENU_EXCEL' => 'Y',
			'SETUP_ID' => $setup->getId(),
			'BASE_URL' => $this->getComponentBaseUrl($setup),
			'PAGER_LIMIT' => 50,
			'DEFAULT_FILTER_FIELDS' => [
				'STATUS',
				'DATE_CREATE',
				'DATE_SHIPMENT',
				'FAKE',
			],
			'DEFAULT_LIST_FIELDS' => [
				'ID',
				'ACCOUNT_NUMBER',
				'DATE_CREATE',
				'DATE_SHIPMENT',
				'BASKET',
				'TOTAL',
				'SUBSIDY',
				'STATUS_LANG',
			],
			'ROW_ACTIONS' => $this->getOrderListRowActions($setup, $documents),
			'ROW_ACTIONS_PERSISTENT' => 'Y',
			'GROUP_ACTIONS' => $this->getOrderListGroupActions($setup, $documents),
			'GROUP_ACTIONS_PARAMS' => [
				'disable_action_target' => true,
			]
		]);
	}

	protected function initializePrintActions(Market\Trading\Setup\Model $setup, $documents)
	{
		static::loadMessages();

		Market\Ui\Library::load('jquery');

		Market\Ui\Assets::loadPluginCore();
		Market\Ui\Assets::loadPlugins([
			'lib.printdialog',
			'OrderList.Print',
		]);

		Market\Ui\Assets::loadMessages([
			'PRINT_DIALOG_SUBMIT',
			'UI_TRADING_ORDER_LIST_PRINT_REQUIRE_SELECT_ORDERS'
		]);

		$pageAssets = Main\Page\Asset::getInstance();

		$printParams = [
			'url' => Market\Ui\Admin\Path::getModuleUrl('trading_order_print', [
				'view' => 'dialog',
				'setup' => $setup->getId(),
				'alone' => 'Y',
			]),
			'items' => $this->getPrintItems($documents),
		];

		$pageAssets->addString(
			'<script>
				BX.YandexMarket.OrderList.print = new BX.YandexMarket.OrderList.Print(null, ' . \CUtil::PhpToJSObject($printParams) . ');
			</script>',
			false,
			Main\Page\AssetLocation::AFTER_JS
		);
	}

	/**
	 * @param Market\Trading\Service\Reference\Document\AbstractDocument[] $documents
	 *
	 * @return array
	 */
	protected function getPrintItems($documents)
	{
		$result = [];

		foreach ($documents as $type => $document)
		{
			$result[] = [
				'TYPE' => $type,
				'TITLE' => $document->getTitle(),
			];
		}

		return $result;
	}

	/**
	 * @param Market\Trading\Setup\Model $setup
	 * @param Market\Trading\Service\Reference\Document\AbstractDocument[] $documents
	 *
	 * @return array
	 */
	protected function getOrderListRowActions(Market\Trading\Setup\Model $setup, $documents)
	{
		$result = [];

		$result['EDIT'] = [
			'ICON' => 'view',
			'TEXT' => static::getLang('UI_TRADING_ORDER_LIST_ACTION_ORDER_VIEW'),
			'URL' => '#EDIT_URL#',
		];

		foreach ($documents as $type => $document)
		{
			$key = 'PRINT_' . strtoupper($type);

			$result[$key] = [
				'TEXT' => $document->getTitle('PRINT'),
				'METHOD' => 'BX.YandexMarket.OrderList.print.openDialog("' .  $type .  '", "#ID#")',
			];
		}

		return $result;
	}

	/**
	 * @param Market\Trading\Setup\Model $setup
	 * @param Market\Trading\Service\Reference\Document\AbstractDocument[] $documents
	 *
	 * @return array
	 */
	protected function getOrderListGroupActions(Market\Trading\Setup\Model $setup, $documents)
	{
		$result = [];

		foreach ($documents as $type => $document)
		{
			$key = 'PRINT_' . strtoupper($type);

			$result[$key] = [
				'type' => 'button',
				'value' => $key,
				'name' => $document->getTitle('PRINT'),
				'action' => 'BX.YandexMarket.OrderList.print.openGroupDialog("' .  $type .  '", YANDEX_MARKET_ADMIN_TRADING_ORDER_LIST)',
			];
		}

		return $result;
	}

	protected function getPrintDocuments(Market\Trading\Setup\Model $setup)
	{
		$printer = $setup->getService()->getPrinter();
		$result = [];

		foreach ($printer->getTypes() as $type)
		{
			$result[$type] = $printer->getDocument($type);
		}

		return $result;
	}

	protected function getComponentBaseUrl(Market\Trading\Setup\Model $setup)
	{
		global $APPLICATION;

		$queryParameters = [
			'lang' => LANGUAGE_ID,
			'service' => $setup->getServiceCode(),
			'site' => $setup->getSiteId(),
		];

		return $APPLICATION->GetCurPage() . '?' . http_build_query($queryParameters);
	}

	protected function getSetupCollection()
	{
		$serviceCode = $this->getServiceCode();

		return Market\Trading\Setup\Collection::loadByFilter([
			'filter' => [
				'=TRADING_SERVICE' => $serviceCode,
				'=ACTIVE' => Market\Trading\Setup\Table::BOOLEAN_Y,
			],
		]);
	}

	protected function getServiceCode()
	{
		$result = (string)$this->request->get('service');

		if ($result === '')
		{
			$message = static::getLang('UI_TRADING_ORDER_LIST_SERVICE_CODE_NOT_SET');
			throw new Main\ArgumentException($message, 'service');
		}

		if (!Market\Trading\Service\Manager::isExists($result))
		{
			$message = static::getLang('UI_TRADING_ORDER_LIST_SERVICE_CODE_INVALID', [ '#SERVICE#' => $result ]);
			throw new Main\SystemException($message);
		}

		return $result;
	}

	protected function getRequestSiteId()
	{
		return $this->request->get('site');
	}

	/**
	 * @param Market\Trading\Setup\Collection $setupCollection
	 * @param string|null $siteId
	 *
	 * @return Market\Trading\Setup\Model
	 * @throws Main\SystemException
	 */
	protected function resolveSetup(Market\Trading\Setup\Collection $setupCollection, $siteId = null)
	{
		if ($siteId !== null)
		{
			$setup = $setupCollection->getBySite($siteId);

			if ($setup === null)
			{
				$message = static::getLang('UI_TRADING_ORDER_LIST_SETUP_NOT_FOUND', [ '#SITE_ID#' => $siteId ]);
				throw new Main\SystemException($message);
			}

			if (!$setup->isActive())
			{
				$message = static::getLang('UI_TRADING_ORDER_LIST_SETUP_INACTIVE', [ '#SITE_ID#' => $siteId ]);
				throw new Main\SystemException($message);
			}
		}
		else
		{
			$setup = $setupCollection->getActive();

			if ($setup === null)
			{
				$message = static::getLang('UI_TRADING_ORDER_LIST_SETUP_NOT_EXISTS');
				throw new Main\SystemException($message);
			}
		}

		return $setup;
	}
}