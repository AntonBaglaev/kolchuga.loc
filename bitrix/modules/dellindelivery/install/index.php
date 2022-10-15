<?php

IncludeModuleLangFile(__FILE__);

class DellinDelivery extends CModule {

	var $MODULE_ID = "dellindelivery";
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;
	public $PARTNER_NAME;
	public $PARTNER_URI;
	public $MODULE_GROUP_RIGHTS = 'N';
	public $NEED_MAIN_VERSION = '';
	public $NEED_MODULES = array('sale');

	public function __construct() {

		$arModuleVersion = array();

		$path = str_replace('\\', '/', __FILE__);
		$path = substr($path, 0, strlen($path) - strlen('/index.php'));
		include($path . '/version.php');

		if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
			$this->MODULE_VERSION = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		}

		$this->PARTNER_NAME = GetMessage('DELLIN_PARTNER_NAME');
		$this->PARTNER_URI = 'http://dellin.ru/';

		$this->MODULE_NAME = GetMessage('DELLIN_MODULE_NAME');
		$this->MODULE_DESCRIPTION = GetMessage('DELLIN_MODULE_DESCRIPTION');
	}

	public function DoInstall() {

			RegisterModuleDependences('sale', 'OnSaleBeforeStatusOrder', $this->MODULE_ID, 'DellinDelivery', 'OnSaleBeforeStatusOrderHandler');
			RegisterModuleDependences('sale', 'OnSaleStatusOrder', $this->MODULE_ID, 'DellinDelivery', 'OnSaleStatusOrderHandler');
			RegisterModuleDependences('sale', 'OnOrderAdd', $this->MODULE_ID, 'DellinDelivery', 'OnOrderAddHandler');
			RegisterModuleDependences('sale', 'onSaleDeliveryHandlersBuildList', $this->MODULE_ID, 'DellinDelivery', 'Init');
			$GLOBALS['DB']->RunSQLBatch($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$this->MODULE_ID.'/install/db/'.$GLOBALS['DBType'].'/install.sql');
			RegisterModule($this->MODULE_ID);
	}

	public function DoUninstall() {

			UnRegisterModuleDependences('sale', 'OnSaleBeforeStatusOrder', $this->MODULE_ID, 'DellinDelivery', 'OnSaleBeforeStatusOrderHandler');
			UnRegisterModuleDependences('sale', 'OnSaleStatusOrder', $this->MODULE_ID, 'DellinDelivery', 'OnSaleStatusOrderHandler');
			UnRegisterModuleDependences('sale', 'OnOrderAdd', $this->MODULE_ID, 'DellinDelivery', 'OnOrderAddHandler');
			UnRegisterModuleDependences('sale', 'onSaleDeliveryHandlersBuildList', $this->MODULE_ID, 'DellinDelivery', 'Init');
			$GLOBALS['DB']->RunSQLBatch($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$this->MODULE_ID.'/install/db/'.$GLOBALS['DBType'].'/uninstall.sql');
			CAgent::RemoveModuleAgents($this->MODULE_ID);
			UnRegisterModule($this->MODULE_ID);


	}

}