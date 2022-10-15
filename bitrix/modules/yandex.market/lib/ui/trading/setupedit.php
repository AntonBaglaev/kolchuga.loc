<?php

namespace Yandex\Market\Ui\Trading;

use Yandex\Market;
use Bitrix\Main;

Main\Localization\Loc::loadMessages(__FILE__);

class SetupEdit extends Market\Ui\Reference\Form
{
	const STATE_INACTIVE = 'inactive';
	const STATE_EDIT = 'edit';

	protected $setup;

	public function hasRequest()
	{
		return ($this->getRequestAction() !== null);
	}

	public function isRequestHandledByView($state)
	{
		return ($state === static::STATE_EDIT && $this->getRequestAction() !== 'deactivate');
	}

	protected function getRequestAction()
	{
		return $this->request->get('action');
	}

	public function refreshPage()
	{
		global $APPLICATION;

		$setup = $this->getSetup();
		$query = [
			'site' => $setup->getSiteId(),
			'service' => $setup->getServiceCode(),
		];
		$url = $APPLICATION->GetCurPageParam(
			http_build_query($query),
			array_merge(
				array_keys($query),
				[ 'action', 'sessid' ]
			)
		);

		LocalRedirect($url);
	}

	public function processRequest()
	{
		$action = $this->getRequestAction();

		switch ($action)
		{
			case 'activate':
				$this->processRequestActivate();
			break;

			case 'deactivate':
				$this->processRequestDeactivate();
			break;

			default:
				throw new Main\SystemException('requested action not implemented');
			break;
		}
	}

	protected function processRequestActivate()
	{
		$setup = $this->getSetup();

		$setup->install();
		$setup->activate();
	}

	protected function processRequestDeactivate()
	{
		$setup = $this->getSetup();

		$setup->deactivate();
		$setup->uninstall();
	}

	public function resolveState()
	{
		$setup = $this->getSetup();

		if (!$setup->isActive())
		{
			$result = static::STATE_INACTIVE;
		}
		else
		{
			$result = static::STATE_EDIT;
		}

		return $result;
	}

	public function setTitle()
	{
		global $APPLICATION;

		$service = $this->getSetup()->getService();
		$title = $service->getOptions()->getTitle();

		$APPLICATION->SetTitle($title);
	}

	public function handleException(\Exception $exception)
	{
		try
		{
			$this->handleEditById($exception);

			$message = $exception->getMessage();
		}
		catch (Main\SystemException $innerException)
		{
			$message = $innerException->getMessage();
		}

		\CAdminMessage::ShowMessage([
			'TYPE' => 'ERROR',
			'MESSAGE' => $message,
		]);
	}

	protected function handleEditById(\Exception $exception)
	{
		global $APPLICATION;

		if (
			$exception instanceof Main\ArgumentException
			&& $exception->getParameter() === 'service'
			&& $this->request->getRequestMethod() === Main\Web\HttpClient::HTTP_GET
		)
		{
			$id = $this->request->getQuery('id');

			if ($id !== null)
			{
				$setup = Market\Trading\Setup\Model::loadById($id);
				$query = [
					'lang' => LANGUAGE_ID,
					'service' => $setup->getServiceCode(),
					'siteId' => $setup->getSiteId(),
				];
				$url = $APPLICATION->GetCurPageParam(
					http_build_query($query),
					array_merge(array_keys($query), [ 'id' ])
				);

				LocalRedirect($url);
				die();
			}
		}
	}

	public function show($state = self::STATE_INACTIVE)
	{
		switch ($state)
		{
			case static::STATE_INACTIVE:
				$this->showSiteSelector();
				$this->showActivateForm();
			break;

			case static::STATE_EDIT:
				$this->showSiteSelector();
				$this->showEditForm();
			break;

			default:
				throw new Main\SystemException('view not implemented');
			break;
		}
	}

	protected function showSiteSelector()
	{
		global $APPLICATION;

		$selected = $this->getSetup()->getSiteId();
		$enum = $this->getSiteEnum();

		if (count($enum) > 1)
		{
			$redirectUrl = $APPLICATION->GetCurPageParam('', ['site']);
			$redirectUrl .= (strpos($redirectUrl, '?') === false ? '?' : '&') . 'site=';
			$onChange = "window.location = '" . htmlspecialcharsbx($redirectUrl) . "' + this.value;";

			echo '<select name="site" onchange="' . $onChange . '">';

			foreach ($enum as $option)
			{
				$isSelected = ($option['ID'] === $selected);

				echo
					'<option value="' . htmlspecialcharsbx($option['ID']) . '" ' . ($isSelected ? 'selected' : '') . '>'
					. htmlspecialcharsbx($option['VALUE'])
					. '</option>';
			}

			echo '</select>';
			echo '<br />';
			echo '<br />';
		}
	}

	protected function showActivateForm()
	{
		$this->showFormProlog();
		$this->showActivateButton();
		$this->showFormEpilog();
	}

	protected function showActivateButton()
	{
		$isAllowed = $this->isAuthorized($this->getWriteRights());

		echo BeginNote();
		echo Market\Config::getLang('ADMIN_TRADING_ACTIVATE_NOTE');
		echo EndNote();

		echo '<input type="hidden" name="action" value="activate" />';
		echo '<input 
			class="adm-btn-save ' . ($isAllowed ? '' : 'adm-btn-disabled') . '" 
			type="submit" 
			value="' . Market\Config::getLang('ADMIN_TRADING_ACTIVATE_BUTTON') . '" 
			' . ($isAllowed ? '' : 'disabled') . '
		 />';
	}

	protected function showEditForm()
	{
		global $APPLICATION;

		$setup = $this->getSetup();
		$tabs = $this->getEditFormTabs();
		$fields = $this->getEditFormFields();
		$contextMenu = $this->getEditFormContextMenu();
		$writeRights = $this->getWriteRights();
		$resetConfirmMessage = Market\Config::getLang('ADMIN_TRADING_RESET_BUTTON_CONFIRM');

		$APPLICATION->IncludeComponent('yandex.market:admin.form.edit', '', [
			'FORM_ID' => 'YANDEX_MARKET_ADMIN_TRADING_EDIT',
			'PROVIDER_TYPE' => 'TradingSettings',
			'CONTEXT_MENU' => $contextMenu,
			'PRIMARY' => $setup->getId(),
			'TABS' => $tabs,
			'FIELDS' => $fields,
			'BUTTONS' => [
				[
					'BEHAVIOR' => 'save',
					'NAME' => Market\Config::getLang('ADMIN_TRADING_SAVE_BUTTON'),
				],
				[
					'NAME' => Market\Config::getLang('ADMIN_TRADING_RESET_BUTTON'),
					'ATTRIBUTES' => [
						'name' => 'postAction',
						'value' => 'reset',
						'onclick' => 'if (!confirm("' . addslashes($resetConfirmMessage) . '")) { return false; }'
					],
				],
			],
			'ALLOW_SAVE' => $this->isAuthorized($writeRights),
			'SAVE_PARTIALLY' => true,
		]);
	}

	protected function getEditFormContextMenu()
	{
		global $APPLICATION;

		return [
			[
				'TEXT' => Market\Config::getLang('ADMIN_TRADING_DEACTIVATE_BUTTON'),
				'LINK' => $APPLICATION->GetCurPageParam(
					http_build_query(['sessid' => bitrix_sessid(), 'action' => 'deactivate']),
					[ 'sessid', 'action ']
				),
			]
		];
	}

	protected function getEditFormTabs()
	{
		$setup = $this->getSetup();
		$service = $setup->getService();

		return $service->getOptions()->getTabs();
	}

	protected function getEditFormFields()
	{
		$setup = $this->getSetup();
		$service = $setup->getService();
		$environment = $setup->getEnvironment();
		$siteId = $setup->getSiteId();

		return $service->getOptions()->getFields($environment, $siteId);
	}

	public function getServiceCode()
	{
		$result = (string)$this->request->get('service');

		if ($result === '')
		{
			$message = Market\Config::getLang('ADMIN_TRADING_SERVICE_CODE_NOT_SET');
			throw new Main\ArgumentException($message, 'service');
		}

		if (!Market\Trading\Service\Manager::isExists($result))
		{
			$message = Market\Config::getLang('ADMIN_TRADING_SERVICE_CODE_INVALID', [ '#SERVICE#' => $result ]);
			throw new Main\SystemException($message);
		}

		return $result;
	}

	protected function getSiteEnum()
	{
		$siteEntity = $this->getSetup()->getEnvironment()->getSite();
		$result = [];

		foreach ($siteEntity->getVariants() as $siteId)
		{
			$result[] = [
				'ID' => $siteId,
				'VALUE' => '[' . $siteId . '] ' . $siteEntity->getTitle($siteId),
			];
		}

		return $result;
	}

	/**
	 * @return Market\Trading\Setup\Model
	 */
	public function getSetup()
	{
		if ($this->setup === null)
		{
			$this->setup = $this->resolveSetup();
		}

		return $this->setup;
	}

	protected function resolveSetup()
	{
		$requestedSiteId = $this->getRequestedSiteId();
		$serviceSetupCollection = $this->getServiceSetupCollection();
		$result = null;

		if ($requestedSiteId !== null)
		{
			$result = $serviceSetupCollection->getBySite($requestedSiteId);

			if ($result === null)
			{
				$result = $this->initializeNewSetup($requestedSiteId);
			}

			if (!$this->checkExistsSiteId($result, $requestedSiteId))
			{
				$message = Market\Config::getLang('ADMIN_TRADING_REQUEST_SITE_ID_NOT_EXISTS', [ '#SITE_ID#' => $requestedSiteId ]);
				throw new Main\SystemException($message);
			}
		}
		else if (count($serviceSetupCollection) > 0)
		{
			$firstSetup = $serviceSetupCollection[0];
			$siteVariants = $this->getSetupSiteVariants($firstSetup);
			$activeSites = $this->getActiveSites($serviceSetupCollection);
			$existActiveSites = array_intersect($siteVariants, $activeSites);
			$siteId = null;

			if (!empty($existActiveSites))
			{
				$siteId = reset($existActiveSites);
			}
			else if (!empty($siteVariants))
			{
				$siteId = reset($siteVariants);
			}

			if ($siteId === null)
			{
				$message = Market\Config::getLang('ADMIN_TRADING_CANT_RESOLVE_SITE_ID');
				throw new Main\SystemException($message);
			}

			$result = $serviceSetupCollection->getBySite($siteId);

			if ($result === null)
			{
				$result = $this->initializeNewSetup();
				$result->setField('SITE_ID', $siteId);
			}
		}
		else
		{
			$result = $this->initializeNewSetup();
			$siteId = $this->resolveNewSetupSiteId($result);

			if ($siteId === null)
			{
				$message = Market\Config::getLang('ADMIN_TRADING_CANT_RESOLVE_SITE_ID');
				throw new Main\SystemException($message);
			}

			$result->setField('SITE_ID', $siteId);
		}

		return $result;
	}

	protected function initializeNewSetup($siteId = null)
	{
		return Market\Trading\Setup\Model::initialize([
			'ACTIVE' => Market\Trading\Setup\Table::BOOLEAN_N,
			'TRADING_SERVICE' => $this->getServiceCode(),
			'SITE_ID' => $siteId,
		]);
	}

	protected function getSetupSiteVariants(Market\Trading\Setup\Model $setup)
	{
		return $setup->getEnvironment()->getSite()->getVariants();
	}

	protected function getActiveSites(Market\Trading\Setup\Collection $setupCollection)
	{
		$result = [];

		/** @var Market\Trading\Setup\Model $setup */
		foreach ($setupCollection as $setup)
		{
			if ($setup->isActive())
			{
				$result[] = $setup->getSiteId();
			}
		}

		return $result;
	}

	protected function checkExistsSiteId(Market\Trading\Setup\Model $setup, $siteId)
	{
		$siteVariants = $setup->getEnvironment()->getSite()->getVariants();

		return in_array($siteId, $siteVariants, true);
	}

	protected function resolveNewSetupSiteId(Market\Trading\Setup\Model $setup)
	{
		$siteVariants = $setup->getEnvironment()->getSite()->getVariants();
		$result = null;

		if (!empty($siteVariants))
		{
			$result = reset($siteVariants);
		}

		return $result;
	}

	protected function getRequestedSiteId()
	{
		return $this->request->get('site');
	}

	protected function getServiceSetupCollection()
	{
		$serviceCode = $this->getServiceCode();

		return Market\Trading\Setup\Collection::loadByService($serviceCode);
	}
}