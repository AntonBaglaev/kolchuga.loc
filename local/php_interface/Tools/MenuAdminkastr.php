<?
namespace Tgarl\Tools;

class MenuAdminkastr 
{
	
function ModifiAdminMenu(&$adminMenu, &$moduleMenu){
	$moduleMenu[] = array(
		"parent_menu" => "global_menu_tgarl", // в раздел "Сервис"
		"section" => "tgarl_baza",
		"sort"        => 5001,                    // сортировка пункта меню - поднимем повыше
		"text" => 'Дополнительные страницы',
		"title" => 'Дополнительные страницы',
		"icon" => "tgarl_baza_menu_icon",
		"page_icon" => "tgarl_baza_page_icon",
		"items_id" => "menu_tgarl_baza",
		"url" => "tgarl_adminkastr.php?lang=".LANG,
		"items" => array(
			[
				'text' => 'Подтверждение заказа в Assist ',
				'title' => 'Подтверждение заказа в Assist ',
				"url" => "tgarl_adminka_assist.php?lang=".LANGUAGE_ID,
			],
			[
				'text' => 'Список заказов в Assist ',
				'title' => 'Список заказов в Assist ',
				"url" => "tgarl_adminka_assist_orderlist.php?lang=".LANGUAGE_ID,
			],
			[
				'text' => 'Статус заказа в Assist ',
				'title' => 'Статус заказа в Assist ',
				"url" => "tgarl_adminka_assist_status.php?lang=".LANGUAGE_ID,
			],
			[
				'text' => 'Дополнительный фильтр по заказам ',
				'title' => 'Дополнительный фильтр по заказам',
				"url" => "tgarl_adminka_filterorder.php?lang=".LANGUAGE_ID,
			],
		)
	);
	
	$moduleMenu[] = array(
		"parent_menu" => "global_menu_tgarl", // в раздел "Сервис"
		"section" => "tgarl_ozon",
		"sort"        => 5002,                    // сортировка пункта меню - поднимем повыше
		"text" => 'Сервис Ozon',
		"title" => 'Сервис Ozon',
		"icon" => "tgarl_ozon_menu_icon",
		"page_icon" => "tgarl_ozon_page_icon",
		"items_id" => "menu_tgarl_ozon",
		"url" => "tgarl_adminka_ozon.php?lang=".LANG,
		"items" => array(
			[
				'text' => 'Выбрать настройки для Ozon',
				'title' => 'Выбрать настройки для Ozon',
				"url" => "tgarl_adminka_ozon_item_add.php?lang=".LANGUAGE_ID,
			],
			[
				'text' => 'Заполнить товары для Ozon',
				'title' => 'Заполнить товары для Ozon',
				"url" => "tgarl_adminka_ozon_item_add2.php?lang=".LANGUAGE_ID,
			],
			[
				'text' => 'Загрузить товары на Ozon',
				'title' => 'Загрузить товары на Ozon',
				"url" => "tgarl_adminka_ozon_item_add3.php?lang=".LANGUAGE_ID,
				"items" => array(
					[
						'text' => 'Загрузить заполненные полностью товары на Ozon',
						'title' => 'Загрузить заполненные полностью товары на Ozon',
						"url" => "tgarl_adminka_ozon_item_add3_1.php?lang=".LANGUAGE_ID,
					],
				)
			],
			[
				'text' => 'Недавно добавленные на Ozon (еще без ozon_id)',
				'title' => 'Недавно добавленные на Ozon (еще без ozon_id)',
				"url" => "tgarl_adminka_ozon_item_list2.php?lang=".LANGUAGE_ID,
			],
			[
				'text' => 'Список товаров на Ozon',
				'title' => 'Список товаров на Ozon',
				"url" => "tgarl_adminka_ozon_item_list.php?lang=".LANGUAGE_ID,
			],
			[
				'text' => 'Обновить количество на Ozon',
				'title' => 'Обновить количество на Ozon',
				"url" => "tgarl_adminka_ozon_item_add4.php?lang=".LANGUAGE_ID,
			],
			[
				'text' => 'Обновить цены на Ozon',
				'title' => 'Обновить цены на Ozon',
				"url" => "tgarl_adminka_ozon_item_add5.php?lang=".LANGUAGE_ID,
			],
		)
	);	
		
}

}
?>