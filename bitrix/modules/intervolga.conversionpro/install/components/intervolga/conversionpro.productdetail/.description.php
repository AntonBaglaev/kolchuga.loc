<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
	"NAME" => Loc::getMessage("INTERVOLGA_CONVERSIONPRO_PRODUCTDETAIL_COMPONENT_NAME"),
	"DESCRIPTION" => Loc::getMessage("INTERVOLGA_CONVERSIONPRO_PRODUCTDETAIL_COMPONENT_DESCRIPTION"),
	"CACHE_PATH" => "Y",
	"SORT" => 100,
	"PATH" => array(
		"ID" => "intervolga",
		"NAME" => "intervolga.ru",
		"CHILD" => array(
			"ID" => 'conversionpro',
			"NAME" => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_MODULE_NAME'),
		)
	),
);