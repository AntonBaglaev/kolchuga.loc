<?php

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Yandex\Market;

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin.php';

Loc::loadMessages(__FILE__);

if (!Main\Loader::includeModule('yandex.market'))
{
	\CAdminMessage::ShowMessage([
		'TYPE' => 'ERROR',
		'MESSAGE' => Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_REQUIRE_MODULE')
	]);
}
else if (!Market\Ui\Access::isReadAllowed())
{
	\CAdminMessage::ShowMessage([
		'TYPE' => 'ERROR',
		'MESSAGE' => Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_ACCESS_DENIED')
	]);
}
else
{
	Market\Metrika::load();

	$request = Main\Context::getCurrent()->getRequest();
	$service = trim($request->get('service'));
	$baseQuery = [
		'lang' => LANGUAGE_ID,
	];

	if ($service !== '')
	{
		$baseQuery['service'] = $service;
	}

	$APPLICATION->IncludeComponent(
		'yandex.market:admin.grid.list',
		'',
		[
			'GRID_ID' => 'YANDEX_MARKET_ADMIN_SETUP_LIST',
			'ALLOW_SAVE' => Market\Ui\Access::isWriteAllowed(),
			'PROVIDER_TYPE' => 'Setup',
			'MODEL_CLASS_NAME' => Market\Export\Setup\Model::class,
			'SERVICE' => $service,
			'EDIT_URL' => Market\Ui\Admin\Path::getModuleUrl('setup_edit', $baseQuery) . '&id=#ID#',
			'ADD_URL' => Market\Ui\Admin\Path::getModuleUrl('setup_edit', $baseQuery),
			'TITLE' => Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_PAGE_TITLE'),
			'NAV_TITLE' => Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_NAV_TITLE'),
			'LIST_FIELDS' => [
				'ID',
				'NAME',
				'EXPORT_SERVICE',
				'EXPORT_FORMAT',
				'DOMAIN',
				'HTTPS',
				'IBLOCK',
				'FILE_NAME',
				'ENABLE_AUTO_DISCOUNTS',
				'AUTOUPDATE',
				'REFRESH_PERIOD'
			],
			'DEFAULT_LIST_FIELDS' => [
				'ID',
				'NAME',
				'EXPORT_SERVICE',
				'EXPORT_FORMAT',
				'DOMAIN',
				'HTTPS',
				'IBLOCK',
				'FILE_NAME',
			],
			'CONTEXT_MENU' => [
				[
					'TEXT' => Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_BUTTON_ADD'),
					'LINK' => Market\Ui\Admin\Path::getModuleUrl('setup_edit', $baseQuery),
					'ICON' => 'btn_new'
				]
			],
			'ROW_ACTIONS' => [
				'RUN' => [
					'URL' => Market\Ui\Admin\Path::getModuleUrl('setup_run', $baseQuery) . '&id=#ID#',
					'ICON' => 'unpack',
					'TEXT' => Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_ROW_ACTION_RUN')
				],
				'EDIT' => [
					'URL' => Market\Ui\Admin\Path::getModuleUrl('setup_edit', $baseQuery) . '&id=#ID#',
					'ICON' => 'edit',
					'TEXT' => Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_ROW_ACTION_EDIT'),
					'DEFAULT' => true
				],
				'LOG' => [
					'URL' =>
						Market\Ui\Admin\Path::getModuleUrl('log', $baseQuery)
						. '&set_filter=Y&find_setup=#ID#',
					'ICON' => 'view',
					'TEXT' => Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_ROW_ACTION_LOG'),
				],
				'COPY' => [
					'URL' => Market\Ui\Admin\Path::getModuleUrl('setup_edit', $baseQuery) . '&id=#ID#&copy=Y',
					'ICON' => 'copy',
					'TEXT' => Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_ROW_ACTION_COPY')
				],
				'DELETE' => [
					'ICON' => 'delete',
					'TEXT' => Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_ROW_ACTION_DELETE'),
					'CONFIRM' => 'Y',
					'CONFIRM_MESSAGE' => Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_ROW_ACTION_DELETE_CONFIRM')
				]
			],
			'GROUP_ACTIONS' => [
				'delete' => Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_ROW_ACTION_DELETE')
			]
		]
	);

	$note = (string)Loc::getMessage('YANDEX_MARKET_ADMIN_SETUP_LIST_NOTE_' . strtoupper($service));

	if ($note !== '')
	{
		echo BeginNote('style="max-width: 600px;"');
		echo $note;
		echo EndNote();
	}
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_admin.php';