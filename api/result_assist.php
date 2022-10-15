<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use \Bitrix\Highloadblock as HL;
use \Bitrix\Sale\Internals\CompanyTable;
	array_map('CModule::IncludeModule', array('iblock', 'catalog', 'sale','highloadblock'));
	
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
foreach($request as $key=>$vl){
	$requestArr[$key]=$vl;
}
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/result_assist_order.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****request******\n".print_r($requestArr, true), FILE_APPEND | LOCK_EX);


if(!empty($requestArr['merchant_id'])){
	
		
		$merchant_id=$requestArr['merchant_id'];
	unset($requestArr['token']);
	unset($requestArr['version']);
	unset($requestArr['alphaauthresult']);
	unset($requestArr['challenge']);
	unset($requestArr['eci']);
	//unset($requestArr['merchant_id']);


	$input_array = array_change_key_case($requestArr, CASE_UPPER);
	foreach($input_array as $key0=>$value0){				
		$data['UF_'.$key0]=$value0;				
	}
	$data['UF_ECOM_MPOS']='ECOM';
	if(in_array($merchant_id, [570542,657871])){
		$data['UF_ECOM_MPOS']='MPOS';
	}
	if($requestArr['meantypename']=='CASH'){
		$data['UF_ECOM_MPOS']='CASH';
	}

	$hlblock = HL\HighloadBlockTable::getById(8)->fetch();//поля HL [ID], [NAME], [TABLE_NAME]
	$entity = HL\HighloadBlockTable::compileEntity($hlblock);//объект содержимого HL
	$entity_data_class = $entity->getDataClass();//класс работы с текущей сущностью(таблицей)

	/*
	UF_PAYSYSTEMID
	UF_PAYSYSTEMNAME
	UF_ORDER_ID_SITE
	UF_COMPANY
	*/
$paramsCompany = array(
	'select' => array('ID','NAME'),
	
);
$dbResultListCompany = \Bitrix\Sale\Internals\CompanyTable::getList($paramsCompany);
$name_company=[];
while ($resultCompany = $dbResultListCompany->Fetch()){
	$name_company[$resultCompany['ID']]=$resultCompany['NAME'];
}
	$rsData = $entity_data_class::getList(array(
			"select" => array('ID','UF_BILLNUMBER'), //выбираем все поля
			"filter" => array("UF_BILLNUMBER" => $data['UF_BILLNUMBER'])				
		));
	$rsData = new CDBResult($rsData, $sTableID);
	if($rsData->SelectedRowsCount()>0){
		while ($arItem = $rsData->Fetch()) {
			$entity_data_class::update($arItem['ID'], $data);
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/result_assist_order.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****update******\n".print_r($arItem['ID'], true), FILE_APPEND | LOCK_EX);
			if($data['UF_ORDERSTATE']=='Approved'){
				
				$orderSite=$arItem['UF_ORDER_ID_SITE'];
				  $orderSiteError=$arItem['UF_ERROR_ORDER_NUM'];
				  $paySite=$arItem['UF_ORDERNUMBER'];
				  $paySiteError=$arItem['UF_ERROR_PAY_NUM'];
				
				$payments = array();
				$select = array(
					'ID', 'ORDER_ID', 'PAY_SYSTEM_ID', 'PAID'
				);
				$params = array(
					'select' => $select,
					'filter' => array('ID' => (!empty($paySiteError) ? $paySiteError:$paySite)),
					'limit'  => 1,		
				);

				$dbResultList = \Bitrix\Sale\Internals\PaymentTable::getList($params);
				$payments = $dbResultList->fetchAll();
				if(intval($payments[0]['ORDER_ID'])>0 && $data['UF_ORDERSTATE']=='Approved'){
					$order = \Bitrix\Sale\Order::load($payments[0]['ORDER_ID']);
					$company_id=$order->getField('COMPANY_ID');
					if(!empty($company_id)){
						/* $name_company=[
							1=>'АО "ФИРМА "КОЛЬЧУГА"',
							2=>'ООО "Кольчуга"',
							3=>'Магазин №1 Охотник - рыболов-турист',
							4=>'ООО "Охотник на Тверской"',
						]; */
						$data['UF_COMPANY']=$name_company[$company_id];
					}
					$cancel=$order->getField("CANCELED");
					$sttus=$order->getField("STATUS_ID");
					$nuno_oplatit='N';

					if($cancel!='Y' && $sttus!='O' && $payments[0]['PAID']=='N'){
						$nuno_oplatit='Y';
					}

					if($nuno_oplatit=='Y'){
						\CSaleOrder::PayOrder($payments[0]['ORDER_ID'], "Y"); // статус оплачен (Y/N)
						\CSaleOrder::StatusOrder($payments[0]['ORDER_ID'], 'PU'); 
					}
				}
			}
			
		}
	}else{
		$paysystemorderid=0;
		if(!empty($data['UF_SLIPNO']) && $data['UF_BILLNUMBER']!=$data['UF_SLIPNO']){
			$rsDataSLIP = $entity_data_class::getList(array(
				"select" => array('ID','UF_BILLNUMBER','UF_ORDER_ID_SITE','UF_ERROR_ORDER_NUM','UF_ORDERNUMBER','UF_ERROR_PAY_NUM'), //выбираем все поля
				"filter" => array("UF_BILLNUMBER" => $data['UF_SLIPNO'])				
			));
					$orderSite=0;
					$orderSiteError=0;
					$paySite=0;
					$paySiteError=0;
			
				while ($arItemSLIP = $rsDataSLIP->Fetch()) {
					$orderSite=$arItem['UF_ORDER_ID_SITE'];
					$orderSiteError=$arItem['UF_ERROR_ORDER_NUM'];
					$paySite=$arItem['UF_ORDERNUMBER'];
					$paySiteError=$arItem['UF_ERROR_PAY_NUM'];
				}
				
				
				if(!empty($paySiteError)){
					$paysystemorderid=$paySiteError;
				}elseif(!empty($paySite)){
					$paysystemorderid=$paySite;
				}
				
				
		}
		$search_pay=$data['UF_ORDERNUMBER'];
		if($paysystemorderid>0 && $paysystemorderid!=$data['UF_ORDERNUMBER']){
			$search_pay=$paysystemorderid;
		}
		$payments = array();
		$select = array(
			'ID', 'ORDER_ID', 'PAY_SYSTEM_ID', 'PAID'
		);
		$params = array(
			'select' => $select,
			'filter' => array('ID' => $search_pay),
			'limit'  => 1,		
		);

		$dbResultList = \Bitrix\Sale\Internals\PaymentTable::getList($params);
		$payments = $dbResultList->fetchAll();
		if ($arPaySys = \CSalePaySystem::GetByID($payments[0]['PAY_SYSTEM_ID']))
		{
		   $data['UF_PAYSYSTEMNAME']=$arPaySys["PSA_NAME"];
		   $PSA_NAME=$arPaySys["PSA_NAME"];
		}
		$data['UF_PAYSYSTEMID']=$payments[0]['PAY_SYSTEM_ID'];
		$data['UF_ORDER_ID_SITE']=$payments[0]['ORDER_ID'];
		$order = \Bitrix\Sale\Order::load($data['UF_ORDER_ID_SITE']);
		$company_id=$order->getField('COMPANY_ID');
		$data['UF_COMPANY']=$PSA_NAME;
		if(!empty($company_id)){
			/* $name_company=[
				1=>'АО "ФИРМА "КОЛЬЧУГА"',
				2=>'ООО "Кольчуга"',
				3=>'Магазин №1 Охотник - рыболов-турист',
				4=>'ООО "Охотник на Тверской"',
			]; */
			$data['UF_COMPANY']=$name_company[$company_id];
		}
		
		$itog = $entity_data_class::add($data);	
		if($itog->isSuccess())
		{
			$ID = $itog->getId();
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/result_assist_order.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****add******\n".print_r($ID, true), FILE_APPEND | LOCK_EX);
			
			if(intval($data['UF_ORDER_ID_SITE'])>0 && $data['UF_ORDERSTATE']=='Approved'){
				
				$cancel=$order->getField("CANCELED");
				$sttus=$order->getField("STATUS_ID");
				$nuno_oplatit='N';

				if($cancel!='Y' && $sttus!='O' && $payments[0]['PAID']=='N'){
					$nuno_oplatit='Y';
				}

				if($nuno_oplatit=='Y'){
					\CSaleOrder::PayOrder($payments[0]['ORDER_ID'], "Y"); // статус оплачен (Y/N)
					\CSaleOrder::StatusOrder($payments[0]['ORDER_ID'], 'PU'); 
				}
			}
		}
	}
					
}