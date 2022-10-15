<?php

namespace Yandex\Market\Ui\UserField;

use Yandex\Market;
use Bitrix\Main;

class StringType extends \CUserTypeString
{
	use Market\Reference\Concerns\HasLang;

	protected static function includeMessages()
	{
		Main\Localization\Loc::loadMessages(__FILE__);
	}

	function GetEditFormHTML($arUserField, $arHtmlControl)
	{
		$attributes = Helper\Attributes::extractFromSettings($arUserField['SETTINGS']);

		$result = static::getEditInput($arUserField, $arHtmlControl);
		$result = Helper\Attributes::insertInput($result, $attributes);

		if (isset($arUserField['SETTINGS']['COPY_BUTTON']))
		{
			$result .= ' ' . static::getCopyButton($arUserField, $arHtmlControl);
		}

		if (isset($arUserField['SETTINGS']['ROWS']) && $arUserField['SETTINGS']['ROWS'] > 1)
		{
			$arHtmlControl['VALIGN'] = 'top';
		}

		return $result;
	}

	function GetAdminListViewHtml($arUserField, $arHtmlControl)
	{
		if ((string)$arHtmlControl['VALUE'] !== '')
		{
			$result = $arHtmlControl['VALUE'];
		}
		else
		{
			$result = '&nbsp;';
		}

		return $result;
	}

	protected static function getEditInput($userField, $htmlControl)
	{
		if ($userField['ENTITY_VALUE_ID'] < 1 && (string)$userField['SETTINGS']['DEFAULT_VALUE'] !== '')
		{
			$htmlControl['VALUE'] = htmlspecialcharsbx($userField['SETTINGS']['DEFAULT_VALUE']);
		}

		if ($userField['SETTINGS']['ROWS'] < 2)
		{
			$htmlControl['VALIGN'] = 'middle';
			
			return '<input type="text" '.
				'name="'.$htmlControl['NAME'].'" '.
				'size="'.$userField['SETTINGS']['SIZE'].'" '.
				($userField['SETTINGS']['MAX_LENGTH']>0? 'maxlength="'.$userField['SETTINGS']['MAX_LENGTH'].'" ': '').
				'value="'.$htmlControl['VALUE'].'" '.
				($userField['EDIT_IN_LIST'] !== 'Y' ? 'disabled="disabled" ': '').
				'>';
		}
		else
		{
			return '<textarea '.
				'name="'.$htmlControl['NAME'].'" '.
				'cols="'.$userField['SETTINGS']['SIZE'].'" '.
				'rows="'.$userField['SETTINGS']['ROWS'].'" '.
				($userField['SETTINGS']['MAX_LENGTH']>0? 'maxlength="'.$userField['SETTINGS']['MAX_LENGTH'].'" ': '').
				($userField['EDIT_IN_LIST'] !== 'Y' ? 'disabled="disabled" ': '').
				'>'.$htmlControl['VALUE'].'</textarea>';
		}
	}

	protected static function getCopyButton($userField, $htmlControl)
	{
		static::loadMessages();

		Market\Ui\Assets::loadPlugin('Ui.Input.CopyClipboard');
		Market\Ui\Assets::loadMessages([
			'INPUT_COPY_CLIPBOARD_SUCCESS',
			'INPUT_COPY_CLIPBOARD_FAIL',
		]);

		return
			'<button class="adm-btn js-plugin-click" type="button" data-plugin="Ui.Input.CopyClipboard">'
				. static::getLang('UI_USER_FIELD_STRING_COPY')
			. '</button>';
	}
}