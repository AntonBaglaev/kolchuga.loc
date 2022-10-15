<?php

/** @global CMain $APPLICATION */
use Bitrix\Main\Localization\Loc;

$accessLevel = $APPLICATION->GetGroupRight('yandex.market');

if ($accessLevel >= 'R')
{
	Loc::loadMessages(__FILE__);

	return [
		[
			'parent_menu' => 'global_menu_services',
			'section' => 'yamarket_turbo',
			'sort' => 1000,
			'text' => Loc::getMessage('YANDEX_MARKET_MENU_TURBO_ROOT'),
			'title' => Loc::getMessage('YANDEX_MARKET_MENU_TURBO_ROOT'),
			'icon' => 'yamarket_turbo_icon',
			'items_id' => 'menu_yamarket_turbo',
			'items' => [
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_SETUP'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_SETUP'),
					'url' => 'yamarket_setup_list.php?lang='.LANGUAGE_ID . '&service=turbo',
					'more_url' => [
						'yamarket_setup_edit.php?lang='.LANGUAGE_ID.'&service=turbo',
						'yamarket_setup_run.php?lang='.LANGUAGE_ID.'&service=turbo',
						'yamarket_log.php?lang='.LANGUAGE_ID.'&service=turbo',
					]
				],
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_ORDER_ADMIN'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_ORDER_ADMIN'),
					'url' => 'yamarket_trading_order_admin.php?lang='.LANGUAGE_ID . '&service=turbo',
					'more_url' => []
				],
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_SETTINGS'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_SETTINGS'),
					'url' => 'yamarket_trading_edit.php?lang='.LANGUAGE_ID . '&service=turbo',
					'more_url' => []
				],
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_EVENT'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_EVENT'),
					'url' => 'yamarket_trading_log.php?lang='.LANGUAGE_ID . '&service=turbo',
					'more_url' => []
				],
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_CONFIRMATION'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_CONFIRMATION'),
					'url' => 'yamarket_confirmation_list.php?lang='.LANGUAGE_ID,
					'more_url' => [
						'yamarket_confirmation_list.php',
						'yamarket_confirmation_edit.php',
					]
				],
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_HELP'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_HELP'),
					'url' => 'javascript:window.open("https://yandex.ru/support/turbo-module-1c-bitrix/", "_blank");void(0);',
					'more_url' => []
				]
			],
		],
		[
			'parent_menu' => 'global_menu_services',
			'section' => 'yamarket_beru',
			'sort' => 1005,
			'text' => Loc::getMessage('YANDEX_MARKET_MENU_BERU_ROOT'),
			'title' => Loc::getMessage('YANDEX_MARKET_MENU_BERU_ROOT'),
			'icon' => 'yamarket_beru_icon',
			'items_id' => 'menu_yamarket_beru',
			'items' => [
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_ORDER_ADMIN'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_ORDER_ADMIN'),
					'url' => 'yamarket_trading_order_admin.php?lang='.LANGUAGE_ID . '&service=beru',
					'more_url' => []
				],
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_ORDER_LIST'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_ORDER_LIST'),
					'url' => 'yamarket_trading_order_list.php?lang='.LANGUAGE_ID . '&service=beru',
					'more_url' => []
				],
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_SETTINGS'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_SETTINGS'),
					'url' => 'yamarket_trading_edit.php?lang='.LANGUAGE_ID . '&service=beru',
					'more_url' => []
				],
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_EVENT'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_EVENT'),
					'url' => 'yamarket_trading_log.php?lang='.LANGUAGE_ID . '&service=beru',
					'more_url' => []
				],
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_HELP'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_HELP'),
					'url' => 'javascript:window.open("https://yandex.ru/support/beru-module-1c-bitrix/", "_blank");void(0);',
					'more_url' => []
				]
			],
		],
		[
			'parent_menu' => 'global_menu_services',
			'section' => 'yamarket_origin',
			'sort' => 1010,
			'text' => Loc::getMessage('YANDEX_MARKET_MENU_ORIGIN_ROOT'),
			'title' => Loc::getMessage('YANDEX_MARKET_MENU_ORIGIN_ROOT'),
			'icon' => 'yamarket_origin_icon',
			'items_id' => 'menu_yamarket',
			'items' => [
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_SETUP'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_SETUP'),
					'url' => 'yamarket_setup_list.php?lang='.LANGUAGE_ID,
					'more_url' => [
						'yamarket_setup_list.php',
						'yamarket_setup_edit.php',
						'yamarket_setup_run.php',
						'yamarket_migration.php'
					]
				],
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_PROMO'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_PROMO'),
					'url' => 'yamarket_promo_list.php?lang='.LANGUAGE_ID,
					'more_url' => [
						'yamarket_promo_list.php',
						'yamarket_promo_edit.php',
						'yamarket_promo_run.php',
						'yamarket_promo_result.php',
					]
				],
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_LOG'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_LOG'),
					'url' => 'yamarket_log.php?lang='.LANGUAGE_ID,
					'more_url' => []
				],
				[
					'text' => Loc::getMessage('YANDEX_MARKET_MENU_HELP'),
					'title' => Loc::getMessage('YANDEX_MARKET_MENU_HELP'),
					'url' => 'javascript:window.open("https://yandex.ru/support/market-cms/", "_blank");void(0);',
					'more_url' => []
				]
			]
		],
	];
}
else
{
	return false;
}