<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Error;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

Loc::loadMessages(__FILE__);

class MainUserConsentViewComponent extends CBitrixComponent
{
	/** @var ErrorCollection $errors */
	protected $errors;

	protected function prepareResult()
	{
		$agreement = new \Bitrix\Main\UserConsent\Agreement($this->arParams["ACTIVE_LIST"]);
		if (!$agreement)
		{
			$this->errors->add(array(new Error(Loc::getMessage("MAIN_USER_CONSENT_VIEW_ERROR"))));
			return false;
		}
		else
		{
			$arrayFields = array(
				"NAME" => Loc::getMessage("ARRAY_FIELDS_NAME"),
				"SURNAME" => Loc::getMessage("ARRAY_FIELDS_SURNAME"),
				"PATRONYMIC" => Loc::getMessage("ARRAY_FIELDS_PATRONYMIC"),
				"EMAIL" => "E-mail",
				"PHONE" => Loc::getMessage("ARRAY_FIELDS_PHONE"),
			);
			$keyFields = array_keys($arrayFields);
			
			$type = $agreement->getData();
			$this->arResult["TYPE"] = $type["TYPE"];
			
			$this->arParams["PERSONAL_DATA"] = array_diff($this->arParams["PERSONAL_DATA"], array(""));
			
			$arFields = "<ul>";
			foreach($this->arParams["PERSONAL_DATA"] as $key => $personalData)
			{
				if(isset($arrayFields[$personalData]))
					$arFields .= "<li>".$arrayFields[$personalData]."</li>";
				else
					$arFields .= "<li>".$personalData."</li>";
			}
			$arFields .= "</ul>";

			$this->arResult["TEXT"] = $agreement->getText();
			$this->arResult["TEXT"] = str_replace("%fields%", $arFields, $this->arResult["TEXT"]);
		}

		return true;
	}

	protected function printErrors()
	{
		foreach ($this->errors as $error)
		{
			ShowError($error);
		}
	}

	public function executeComponent()
	{
		$this->errors = new \Bitrix\Main\ErrorCollection();

		if (!$this->prepareResult())
		{
			$this->printErrors();
			return;
		}

		$this->includeComponentTemplate();
	}
}