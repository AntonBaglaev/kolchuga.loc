#!/opt/php72/bin/php
<?php 
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/..");
//echo "<pre>";print_r($_SERVER["DOCUMENT_ROOT"]);echo "</pre>";die;
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('BX_NO_ACCELERATOR_RESET', true);
define('CHK_EVENT', true);
define('BX_WITH_ON_AFTER_EPILOG', true);

file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/postRequest_listorder.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($_SERVER["DOCUMENT_ROOT"], true), FILE_APPEND | LOCK_EX);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
use \Bitrix\Highloadblock as HL;
array_map('CModule::IncludeModule', array('iblock', 'catalog', 'sale','highloadblock'));
 
 function postRequest($url, $data) {
			$data_string = json_encode($data);
			$result = file_get_contents($url, null, stream_context_create(array(
				'http' => array(
					'method' => 'POST',
					'header' => 'Content-Type: application/json' . "\r\n"
                    . 'Content-Length: ' . strlen($data_string) . "\r\n",
					'content' => $data_string,
				),
			)));
			
			return $result;
			}
function ardt($massiv){
	
				$result=array();
				foreach($massiv['#'] as $key=>$value){
					if(empty($value[1])){
						if(!is_array($value[0]['#'])){
							$result[$key]=$value[0]['#'];
						}else{
							$result[$key]=ardt($value[0]);
						}
					}else{
						foreach($value as $key2=>$item){
							if(is_array($item['#'])){
								$result[$key][$key2]=ardt($item);
							}else{
								$result[$key][$key2]=$item['#'];
							}
						}
					}
					
				}
				
				return $result;
			}
			
$url='https://payments303.paysecure.ru/resultbydate/resultbydate.cfm';

$paycompany=array(
	21 =>'Cклад',
	18 =>'Варварка',
	19 =>'Ленинский проспект',
	20 =>'Волоколамское шоссе',
);
$hlblock = HL\HighloadBlockTable::getById(8)->fetch();//поля HL [ID], [NAME], [TABLE_NAME]
$entity = HL\HighloadBlockTable::compileEntity($hlblock);//объект содержимого HL
$entity_data_class = $entity->getDataClass();//класс работы с текущей сущностью(таблицей)

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/xml.php");

foreach($paycompany as $idcompany=>$namecompany){
	$arPayments=array();
	
	$arPayments['PARAM_EXTRA'] = array(
		'ASSIST_SHOP_IDP' => \Bitrix\Sale\BusinessValue::get("ASSIST_SHOP_IDP", "PAYSYSTEM_".$idcompany ),
		'ASSIST_SHOP_LOGIN' => \Bitrix\Sale\BusinessValue::get("ASSIST_SHOP_LOGIN", "PAYSYSTEM_".$idcompany ),
		'ASSIST_SHOP_PASSWORD' => \Bitrix\Sale\BusinessValue::get("ASSIST_SHOP_PASSWORD", "PAYSYSTEM_".$idcompany ),
		'ASSIST_SERVER_URL' => \Bitrix\Sale\BusinessValue::get("ASSIST_SERVER_URL", "PAYSYSTEM_".$idcompany ),
	);
	 
	$arPaySys = \CSalePaySystem::GetByID($idcompany);
	$PSA_NAME=$arPaySys["PSA_NAME"];
	
	$massa=array(
		"merchant"=>array(
			"merchant_id"=>$arPayments['PARAM_EXTRA']['ASSIST_SHOP_IDP'],
			"login"=>$arPayments['PARAM_EXTRA']['ASSIST_SHOP_LOGIN'],
			"password"=>$arPayments['PARAM_EXTRA']['ASSIST_SHOP_PASSWORD']
		)
	);
	
	$massa["startyear"]=date("Y", mktime(date('H')-23, date('i')-59, 0, date('m'), date('d'), date('Y')));
	$massa["startmonth"]=date("n", mktime(date('H')-23, date('i')-59, 0, date('m'), date('d'), date('Y')));
	$massa["startday"]=date("j", mktime(date('H')-23, date('i')-59, 0, date('m'), date('d'), date('Y')));
	$massa["starthour"]=date("H", mktime(date('H')-23, date('i')-59, 0, date('m'), date('d'), date('Y')));
	$massa["startmin"]=date("i", mktime(date('H')-23, date('i')-59, 0, date('m'), date('d'), date('Y')));;
	$massa["format"]=3; 
	//echo "<pre>";print_r($massa);echo "</pre>";
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/postRequest_listorder.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($massa, true), FILE_APPEND | LOCK_EX);
	$result=postRequest($url, $massa);
	
	$objXML = new CDataXML();
	$objXML->LoadString($result);			
	$arData = $objXML->GetArray();


	$arResult=\Kolchuga\Settings::ardt($arData['result']);
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/postRequest_listorder.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($arResult, true), FILE_APPEND | LOCK_EX);
	
	if(!empty($arResult['payment'])){	
				
		if(!empty($arResult['payment'][0])){
			foreach($arResult['payment'] as $key=>$value){
				
				$rsData = $entity_data_class::getList(array(
					"select" => array('ID','UF_BILLNUMBER'), //выбираем все поля
					"filter" => array("UF_BILLNUMBER" => $value['billnumber'])				
				));
				$rsData = new CDBResult($rsData, $sTableID);
				if($rsData->SelectedRowsCount()>0){
					while ($arItem = $rsData->Fetch()) {
						$data=array();
						$input_array = array_change_key_case($value, CASE_UPPER);
						foreach($input_array as $key0=>$value0){				
							$data['UF_'.$key0]=$value0;				
						}
						
						$entity_data_class::update($arItem['ID'], $data);
					}
				}else{
					$data=array();
					$input_array = array_change_key_case($value, CASE_UPPER);
					foreach($input_array as $key0=>$value0){				
						$data['UF_'.$key0]=$value0;				
					}
					$payments = array();
					$select = array(
						'ID', 'ORDER_ID', 'PAY_SYSTEM_ID'
					);
					$params = array(
						'select' => $select,
						'filter' => array('ID' => $data['UF_ORDERNUMBER']),
						'limit'  => 1,		
					);

					$dbResultList = \Bitrix\Sale\Internals\PaymentTable::getList($params);
					$payments = $dbResultList->fetchAll();
					if ($arPaySys = \CSalePaySystem::GetByID($payments[0]['PAY_SYSTEM_ID']))
					{
					   $data['UF_PAYSYSTEMNAME']=$arPaySys["PSA_NAME"];
					}
					$data['UF_PAYSYSTEMID']=$payments[0]['PAY_SYSTEM_ID'];
					$data['UF_ORDER_ID_SITE']=$payments[0]['ORDER_ID'];
					$data['UF_COMPANY']=$PSA_NAME;
					
					$itog = $entity_data_class::add($data);				
				}
				
			}
		}else{
			
			$rsData = $entity_data_class::getList(array(
					"select" => array('ID','UF_BILLNUMBER'), //выбираем все поля
					"filter" => array("UF_BILLNUMBER" => $arResult['payment']['billnumber'])				
				));
			$rsData = new CDBResult($rsData, $sTableID);
			if($rsData->SelectedRowsCount()>0){
				while ($arItem = $rsData->Fetch()) {
					$data=array();
					$input_array = array_change_key_case($arResult['payment'], CASE_UPPER);
					foreach($input_array as $key=>$value){				
						$data['UF_'.$key]=$value;				
					}
					$entity_data_class::update($arItem['ID'], $data);
				}
			}else{
				$data=array();
				$input_array = array_change_key_case($arResult['payment'], CASE_UPPER);
				foreach($input_array as $key=>$value){				
					$data['UF_'.$key]=$value;				
				}
				$payments = array();
				$select = array(
					'ID', 'ORDER_ID', 'PAY_SYSTEM_ID'
				);
				$params = array(
					'select' => $select,
					'filter' => array('ID' => $data['UF_ORDERNUMBER']),
					'limit'  => 1,		
				);

				$dbResultList = \Bitrix\Sale\Internals\PaymentTable::getList($params);
				$payments = $dbResultList->fetchAll();
				if ($arPaySys = \CSalePaySystem::GetByID($payments[0]['PAY_SYSTEM_ID']))
				{
				   $data['UF_PAYSYSTEMNAME']=$arPaySys["PSA_NAME"];
				}
				$data['UF_PAYSYSTEMID']=$payments[0]['PAY_SYSTEM_ID'];
				$data['UF_ORDER_ID_SITE']=$payments[0]['ORDER_ID'];
				$data['UF_COMPANY']=$PSA_NAME;
				
				$itog = $entity_data_class::add($data);				
			}
		}
	}
}

echo 'end';