<?php
namespace Starrys\Cashbox;

use Bitrix\Main;
use Bitrix\Main\Config\Option;
use Bitrix\Sale\Cashbox\Cashbox;
use Bitrix\Sale\Cashbox\Check;
use Bitrix\Sale\Cashbox\Manager;
use Bitrix\Sale\Cashbox\Internals\CashboxTable;
use Bitrix\Sale\Cashbox\Internals\CashboxCheckTable;
use Bitrix\Sale\Cashbox\CheckManager;
use Bitrix\Sale\Cashbox\SellCheck;
use Bitrix\Sale\Cashbox\SellReturnCashCheck;
use Bitrix\Sale\Cashbox\SellReturnCheck;
use Bitrix\Sale\Cashbox\AdvancePaymentCheck;
use Bitrix\Sale\Cashbox\AdvanceReturnCashCheck;
use Bitrix\Sale\Cashbox\AdvanceReturnCheck;
use Bitrix\Sale\Cashbox\CreditCheck;
use Bitrix\Sale\Cashbox\CreditReturnCheck;
use Bitrix\Sale\Cashbox\CreditPaymentCheck;
use Bitrix\Main\Localization\Loc;
use Starrys\Cashbox\Api\Client;
use Starrys\Cashbox\Api\Command;
use Starrys\Cashbox\Api\Helper;
use Starrys\Cashbox\Api\TaxId;
use Starrys\Cashbox\Api\DocumentType;
use Starrys\Cashbox\Api\PayAttribute;
use Starrys\Cashbox\Api\ProductList;



Loc::loadMessages(__FILE__);

\CModule::IncludeModule("catalog");


class CashboxStarrys extends Cashbox {

	const CACHE_ID = 'STARRYS_CASHBOX_IDS';
	const TTL = 31536000;

	public static function getStarrysCashboxes() {
		//TODO use \Bitrix\Sale\Cashbox\Manager::getListFromCache()
		$result = array();
		$cacheManager = Main\Application::getInstance()->getManagedCache();

		if ($cacheManager->read(self::TTL, self::CACHE_ID)) {
			$result = $cacheManager->get(self::CACHE_ID);
		}

		if (!$result) {
			$dbRes = CashboxTable::getList(
							array(
								'select' => array('*'),
								'filter' => array('=HANDLER' => '\Starrys\Cashbox\CashboxStarrys','ACTIVE' => 'Y')
							));

			while ($cashbox = $dbRes->fetch())
			{
				$result[$cashbox['ID']] = $cashbox;
			}
			$cacheManager->set(self::CACHE_ID, $result);
		}
		return $result;
	}

	private function getCheckTypeMap()
	{
		return array(
			SellCheck::getType() => DocumentType::DEBIT,
			SellReturnCashCheck::getType() => DocumentType::REFUND_DEBIT,
			SellReturnCheck::getType() => DocumentType::REFUND_DEBIT,
			AdvancePaymentCheck::getType() => DocumentType::DEBIT,
			AdvanceReturnCashCheck::getType() => DocumentType::REFUND_DEBIT,
			AdvanceReturnCheck::getType() => DocumentType::REFUND_DEBIT,
			CreditCheck::getType() => DocumentType::DEBIT,
			CreditReturnCheck::getType() => DocumentType::REFUND_DEBIT,
			CreditPaymentCheck::getType() => DocumentType::DEBIT,
			PartPaymentCheck::getType() => DocumentType::DEBIT,
		);
	}

	private function getPaymentAttrTypeMap()
	{
		return array(
			SellCheck::getType() => PayAttribute::FULL_PAYMENT,
			SellReturnCashCheck::getType() => PayAttribute::FULL_PAYMENT,
			SellReturnCheck::getType() => PayAttribute::FULL_PAYMENT,
			AdvancePaymentCheck::getType() => PayAttribute::PREPAID_EXPENSE,
			AdvanceReturnCashCheck::getType() => PayAttribute::PREPAID_EXPENSE,
			AdvanceReturnCheck::getType() => PayAttribute::PREPAID_EXPENSE,
			CreditCheck::getType() => PayAttribute::WITHOUT_PAYMENT,
			CreditReturnCheck::getType() => PayAttribute::WITHOUT_PAYMENT,
			CreditPaymentCheck::getType() => PayAttribute::WITHOUT_PAYMENT,
			PartPaymentCheck::getType() => PayAttribute::FULL_PAYMENT,//PayAttribute::PART_PAYMENT_BEFORE,
		);
	}

	public function getOption($name, $default = '') {
		$value = trim($this->getValueFromSettings( 'OPTIONS',strtoupper($name)));
		if(!$value) {
			$value = trim(Option::get("starrys.cashbox", strtolower($name), $default));
		}
		if(!$value) {
			$value = $default;
		}
		return $value;
	}


	public static function getName() {
		return Loc::getMessage('STARRYS.CASHBOX_NAME');
	}

	public function enqueCheck(Check $check) {
		$checkData = $check->getDataForCheck();
		$productCommands = array();

		$checkTypeMap = $this->getCheckTypeMap();
		$documentType = $checkTypeMap[$checkData['type']];

		$paymentAttrTypeMap = $this->getPaymentAttrTypeMap();
		$paymentAttr = $paymentAttrTypeMap[$checkData['type']];

		$cash = 0;
		$ecash = 0;
		$card = 0;

		foreach($checkData['payments'] as $payment) {
			if ($payment['is_cash'] == 'N') {
				$ecash += $payment['sum'];
			} elseif ($payment['is_cash'] == 'A') {
				$card += $payment['sum'];
			} else {
				$cash += $payment['sum'];
			}
		}

		$vat = TaxId::NO_VAT;
		$lines = array();
		$totalSum =  0;
		$iterator = 0;
		$totalItems = count($checkData['items']);
		$lines = new ProductList($cash + $ecash + $card);
		$nds_settings = $this->getOption('nds', 0);

		foreach ($checkData['items'] as $item) {
			if (!$nds_settings) {
				if($item['vat']){
					$res = \CCatalogVat::GetByID($item['vat']);
					$vatData = $res->Fetch();
					if ($vatData['NAME'] == Loc::getMessage('STARRYS.CASHBOX_OPTIONS_NDS_VAT_4')) {
						$vat = TaxId::NO_VAT;
					} else {
						switch($vatData['RATE']) {
							case 18:
							case 20:
								$vat = TaxId::VAT_18;break;
							case 10:$vat = TaxId::VAT_10;break;
							case  0:$vat = TaxId::VAT_0;break;
							default: $vat = TaxId::NO_VAT;
						}
					}
				} else {
					$vat = TaxId::NO_VAT;
				}
			} else {
				$vat = intval($nds_settings);
			}

			if(ToUpper(SITE_CHARSET) != "UTF-8"){
				$item['name'] = iconv('cp1251','utf-8',$item['name']);
			}

			$lines->addItem($item['name'], $item['price'], $vat, $item['quantity'], $paymentAttr);
		}


		$orderNumber = $check->getField('ORDER_ID');
		$arOrder = \CSaleOrder::GetByID($orderNumber);
		if($arOrder) {
			$orderNumber = $arOrder['ACCOUNT_NUMBER'];
		}
		$orderTitle = Loc::getMessage('STARRYS.CASHBOX_ORDER_NUMBER');

		if(ToUpper(SITE_CHARSET) != "UTF-8"){
			$orderTitle = iconv('cp1251', 'utf-8', $orderTitle);
		}

		$field = $this->getOption('contact_field', 'EMAIL');
		if ($field == 'EMAIL') {
			$contact = $checkData['client_email'];
		} else {
			$phone = $this->normalizePhone($checkData['client_phone']);
			if (preg_match('/^79(\d{9})$/', $phone)) {
				$contact = $phone;
			} else {
				$contact = $checkData['client_email'];
			}
		}

		$requestData = array(
			'RequestId'             => $checkData['unique_id'],
			'Password'              => intval($this->getOption('cashier_password')),
			'PhoneOrEmail'          => $contact,
			'Group'                 => $this->getOption('group'),
			'FullResponse'          => (bool)$this->getOption('fullresponse'),
			'Cash'                  => round($cash * 100),
			'Device'                => 'auto',
			'NonCash'               => array(round($card * 100), round($ecash * 100), 0),
			'MaxDocumentsInTurn'    => intval($this->getOption('docs_in_turn')),
			'TaxMode'               => pow(2, $this->getOption('tax_mode')),
			'DocumentType'          => $documentType,
			'Lines'                 => $lines->getItems(),
			"ClientId"				=> $this->getOption('client_id'),
			"UserRequisite"			=> array(
					"Title" => $orderTitle,
					"Value" => $orderNumber
				)
		);

		if(!is_callable("curl_init")) {
			\CEventLog::Add(array(
				"SEVERITY" => "ERROR",
				"AUDIT_TYPE_ID" => GetMessage("STARRYS.CASHBOX_PRINT_ERROR"),
				"MODULE_ID" => "starrys.cashbox",
				"ITEM_ID" => $checkData['unique_id'],
				"DESCRIPTION" => "Curl extension not installed",
			));
			return;
		}
		$api = $this->initApi();

		$result = $api->sendRequest('Complex', $requestData);

		$now = time();
		if($this->getOption('log')){
			@file_put_contents(
				__DIR__.'/log_'.date('Y-m-d', $now).'.txt',
				date('Y-m-d H:i:s')."\nRequest[\n".var_export($api,true)."]\nResponse[\n".var_export($result,true)."]\nCheck[\n".var_export($checkData['items'],true)."]\n\n",
				FILE_APPEND
			);
		}

		if ($result && $result->response && $result->response->Response) {
			if ($result->response->Response->Error == 0) {
				$dbRes = CashboxCheckTable::getList(array('select' => array('STATUS'), 'filter' => array('ID' => $checkData['unique_id'])));
					$data = $dbRes->fetch();
					if ($data)
					{
						if ($data['STATUS'] !== 'Y')
						{
							$rp = $result->response;
							$dateTime = new Main\Type\DateTime( sprintf("%02s.%02s.20%s %02s:%02s:%02s",
								$rp->Date->Date->Day,
								$rp->Date->Date->Month,
								$rp->Date->Date->Year,
								$rp->Date->Time->Hour,
								$rp->Date->Time->Minute,
								$rp->Date->Time->Second
							), "d.m.Y H:i:s");
							parse_str($rp->QR, $linkParams);
							if (defined("\\Bitrix\\Sale\\Cashbox\\Check::PARAM_FISCAL_DOC_ATTR")) {
								$checkParam = array(
									Check::PARAM_FISCAL_DOC_ATTR	=> $linkParams['fp'],
									Check::PARAM_FISCAL_DOC_NUMBER	=> $linkParams['i'],
									Check::PARAM_FN_NUMBER			=> $linkParams['fn'],
									Check::PARAM_DOC_SUM			=> $linkParams['s'],
									Check::PARAM_DOC_TIME			=> $dateTime->getTimestamp(),
									Check::PARAM_CALCULATION_ATTR	=> ($linkParams['n'] == 1)?Check::CALCULATED_SIGN_INCOME:Check::CALCULATED_SIGN_CONSUMPTION,
									Check::PARAM_REG_NUMBER_KKT		=> $rp->DeviceRegistrationNumber
								);
							} else {
								$checkParam = array('qr' => $rp->QR);
							}
							$result = CashboxCheckTable::update(
								$checkData['unique_id'],
								array(
									'STATUS' => 'Y',
									'LINK_PARAMS' => $checkParam,
									'DATE_PRINT_END' => new Main\Type\DateTime()
								)
							);
						}
					}
			} else {
				@file_put_contents(
						__DIR__.'/error_'.date('Y-m-d', $now).'.txt',
						date('Y-m-d H:i:s')."\nRequest[\n$api]\nResponse[\n".var_export($result,true)."]\nCheck[\n".var_export($checkData,true)."]\n\n",
						FILE_APPEND
				);
			}
		}

	}

	private function normalizePhone($phone) {
		$repl = array(' ','-','(',')','+');
		$phone = str_replace($repl, "", $phone);
		if(preg_match('/^8(\d{10})$/', $phone, $m)){
			$phone = '7'.$m[1];
		}
		if(preg_match('/^9(\d{9})$/', $phone, $m)){
			$phone = '79'.$m[1];
		}
		return $phone;
	}



	public function initApi() {
		include_once __DIR__.'/../install/version.php';

		$api = new Client(
			$this->getOption('endpoint'),
			$this->getOption('group'),
			"auto"
			);

		$api->setPasswords($this->getOption('cashier_password'), $this->getOption('admin_password'))
			->setCmsId('Bitrix', $arModuleVersion['VERSION']);

		if ($this->getOption('client_id')) {
			$api->setClientId($this->getOption('client_id'));
		}
		if ($this->getOption('cert_path')) {
			$cert_path = $_SERVER["DOCUMENT_ROOT"].'/'.trim($this->getOption('cert_path'),"/");
			$key_path = $_SERVER["DOCUMENT_ROOT"].'/'.trim($this->getOption('key_path'),"/");
			$api->setCertificate($cert_path, $key_path, $this->getOption('cert_password'));
		}

		return $api;
	}

	public function getCheckLink(array $linkParams)
	{
		$ofd = $this->getOfd();
		if ($ofd !== null)
			return $ofd->generateCheckLink($linkParams);
		return '';
	}

	public function getState() {
		$api = $this->initApi();
		$result = $api->batchExec(array(new Command("NoOperation")));
		if($result->code == 200 && !$result->response->Error && $result->response->Responses){
			foreach($result->response->Responses as $r) {
				if($r->Path == '/fr/api/v2/NoOperation' && !$r->Response->Error){
					return array('RESULT' => true, 'MSG' => Loc::getMessage('STARRYS.CASHBOX_SUCCESS_STATUS'));
				}
			}
		} elseif($result->code == 200 && $result->response->Error) {
			if (isset($result->response->ErrorMessages)) {
				$result = implode(',', $result->response->ErrorMessages);
			} else {
				foreach($result->response->Responses as $r) {
					if($r->Path == '/fr/api/v2/NoOperation' && $r->Response->Error) {
						return array('RESULT' => true, 'MSG' => $r->ExchangeError);
					}
				}
			}
		} else {
			$result = Loc::getMessage('STARRYS.CASHBOX_ERROR_STATUS', array('#CODE#' => $result->code, '#ERROR#' => $result->error));
		}
		return array('RESULT' => false, 'MSG'=> $result);
	}


	public static function getConnectionLink($handler_file, $document_number = "")  {
		$context = Main\Application::getInstance()->getContext();
		$scheme = $context->getRequest()->isHttps() ? 'https' : 'http';
		$server = $context->getServer();
		$domain = $server->getServerName();

		if (preg_match('/^(?<domain>.+):(?<port>\d+)$/', $domain, $matches))
		{
				$domain = $matches['domain'];
				$port   = $matches['port'];
		}
		else
		{
				$port = $server->getServerPort();
		}
		$port = in_array($port, array(80, 443)) ? '' : ':'.$port;
		$token = static::createValidationToken($document_number);
		return sprintf('%s://%s%s/bitrix/tools/%s?token=%s', $scheme, $domain, $port, $handler_file, $token);
	}

	public function buildCheckQuery(Check $check) {
		return array();
	}

	public function buildZReportQuery($id) {
		return array();
	}

	public static function printChecks()
	{
		$cashBoxes = CashboxStarrys::getStarrysCashboxes();
		foreach($cashBoxes as $cashBoxId => $settings) {
			$checkRows = CheckManager::getPrintableChecks(array($cashBoxId), array());

			$cashbox = Manager::getObjectById($cashBoxId);
			foreach($checkRows as $checkRow) {
				$check = CheckManager::create($checkRow);
				$cashbox->enqueCheck($check);
			}
		}
		return '\Starrys\Cashbox\CashboxStarrys::printChecks();';
	}

	public static function checkStatus() {
		return '\Starrys\Cashbox\CashboxStarrys::checkStatus();';
		$cashboxes = CashboxStarrys::getStarrysCashboxes();
		$list = \Bitrix\Sale\Cashbox\Manager::getListFromCache();
		foreach($cashboxes as $id=>$settings){
			if(isset($list[$id])){
				$item = $list[$id];
				$cashbox = Manager::getObjectById($id);
				$state = $cashbox->getState($id);
				$item['PRESENTLY_ENABLED'] = $state['RESULT']?'Y':'N';
				\Bitrix\Sale\Cashbox\Manager::saveCashbox($item);
			}
		}
		return '\Starrys\Cashbox\CashboxStarrys::checkStatus();';
	}

	public static function getSettings($modelId = 0)
	{
		$settings = array(
			'OPTIONS' => array(
				'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_SERVER_LABEL'),
				'ITEMS' => array(
					'ENDPOINT' => array (
							'TYPE' => 'STRING',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_ENDPOINT')
						),
					'GROUP' => array (
							'TYPE' => 'STRING',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_GROUP')
						),
					'CLIENT_ID' => array (
							'TYPE' => 'STRING',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_CLIENT_ID')
						),
					'CASHIER_PASSWORD' => array(
							'TYPE' => 'STRING',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_CASHIER_PASSWORD')
					),
					'ADMIN_PASSWORD' => array(
							'TYPE' => 'STRING',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_ADMIN_PASSWORD')
					),
					'DOCS_IN_TURN' => array (
							'TYPE' => 'STRING',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_DOCS_IN_TURN')
						),
					'CERT_PATH' => array (
							'TYPE' => 'STRING',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_CERT_PATH')
						),
					'KEY_PATH' => array (
							'TYPE' => 'STRING',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_KEY_PATH')
						),
					'CERT_PASSWORD' => array (
							'TYPE' => 'STRING',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_CERT_PASSWORD')
						),
					'CONTACT_FIELD' => array (
							'TYPE' => 'ENUM',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_CONTACT_FIELD'),
							'VALUE' => 'EMAIL',
							'OPTIONS' => array(
								'EMAIL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_CONTACT_FIELD_EMAIL'),
								'PHONE' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_CONTACT_FIELD_PHONE'),
							)
						),
					'TAX_MODE' => array (
							'TYPE' => 'ENUM',
							'LABEL' => Loc::getMessage('SALE_CASHBOX_ATOL_FARM_SETTINGS_SNO'),
							'VALUE' => '0',
							'OPTIONS' => array(
								'0' => Loc::getMessage('SALE_CASHBOX_ATOL_FARM_SNO_OSN'),
								'1' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_USN_6'),
								'2' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_USN_15'),
								'3' => Loc::getMessage('SALE_CASHBOX_ATOL_FARM_SNO_ENVD'),
								'4' => Loc::getMessage('SALE_CASHBOX_ATOL_FARM_SNO_ESN'),
								'5' => Loc::getMessage('SALE_CASHBOX_ATOL_FARM_SNO_PATENT')
							)
						),
					'NDS'	=> array(
							'TYPE' => 'ENUM',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_NDS'),
							'VALUE' => 0,
							'OPTIONS' => array(
								0 => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_NDS_BITRIX'),
								TaxId::VAT_18 => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_NDS_VAT_1'),
								TaxId::VAT_10 => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_NDS_VAT_2'),
								TaxId::VAT_0 => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_NDS_VAT_3'),
								TaxId::NO_VAT => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_NDS_VAT_4'),
								TaxId::VAT_18_118 => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_NDS_VAT_5'),
								TaxId::VAT_10_110 => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_NDS_VAT_6'),
							)
						),
					'FULLRESPONSE' => array (
							'TYPE' => 'ENUM',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_FULLRESPONSE'),
							'VALUE' => 0,
							'OPTIONS' => array(
								0 => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_FULLRESPONSE_NO'),
								1 => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_FULLRESPONSE_YES'),
							)
						),
					'FFD105' => array (
							'TYPE' => 'ENUM',
							'LABEL' => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_FFD105'),
							'VALUE' => 0,
							'OPTIONS' => array(
								0 => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_FFD105_NO'),
								1 => Loc::getMessage('STARRYS.CASHBOX_OPTIONS_FFD105_YES'),
							)
						)
					)
				),
		);


		return $settings;
	}

	public static function isSupportedFFD105()
	{
		$supportFFD105 = false;
		$cashBoxes = self::getStarrysCashboxes();
        foreach($cashBoxes as $cashBoxId => $settings) {
        	$cashbox = Manager::getObjectById($cashBoxId);
        	if ($cashbox->getOption('FFD105')) {
        		$supportFFD105 = true;
        	}
        }
		return $supportFFD105;
	}

}
?>