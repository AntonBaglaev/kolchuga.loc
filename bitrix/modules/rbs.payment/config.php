<?
/**
 * Комментарии при установке и при настройке
 */
$mess["module_name"] = "Прием платежей через Сбербанк";
$mess["module_description"] = "Сбербанк - http://www.sberbank.ru/";
$mess["partner_name"] = "Сбербанк";
$mess["partner_uri"] = "http://www.sberbank.ru/";

/**
 * URL API
 */
define('PROD_URL', 'https://securepayments.sberbank.ru/payment/rest/'); // Продакшн/Бой
define('TEST_URL', 'https://3dsec.sberbank.ru/payment/rest/'); // Тест

/**
 * Версия плагина
 */
define(VERSION, '2.4');
define(VERSION_DATE, '2016-05-23 00:00:00');

/**
 * Если utf-8, то true. Если cp1251 - false (специфично для Bitrix)
 */
if (LANG_CHARSET == 'UTF-8') {
	define(ENCODING, true);
} else {
	define(ENCODING, false);
}
