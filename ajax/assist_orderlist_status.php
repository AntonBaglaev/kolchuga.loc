<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
use Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;

Loader::includeModule("sale");
Loader::includeModule("highloadblock");
//die;
if(/* $_REQUEST['sessid']==bitrix_sessid() && */ !empty($_REQUEST['rell'])){

$hlblock = HL\HighloadBlockTable::getById(8)->fetch();//поля HL [ID], [NAME], [TABLE_NAME]
$entity = HL\HighloadBlockTable::compileEntity($hlblock);//объект содержимого HL
$entity_data_class = $entity->getDataClass();//класс работы с текущей сущностью(таблицей)
//if($val['UF_ORDERSTATE']=='Approved'){echo 'Оплачен';}
$rsData = $entity_data_class::getList(array(
	"select" => array('*'), //выбираем все поля
	"filter" => array(
		"UF_BILLNUMBER" => $_REQUEST['rell'], 
		//'UF_ORDERSTATE'=>'Approved'
	),	
));
   //echo "<pre>";print_r($_REQUEST);echo "</pre>";die;
 $rsData = new CDBResult($rsData, $sTableID);
	if($rsData->SelectedRowsCount()>0){
		$arItem = $rsData->Fetch();
		
		$order = \Bitrix\Sale\Order::load($arItem['UF_ORDER_ID_SITE']);
		$paymentCollection = $order->getPaymentCollection();

		$arPayments=[];
		foreach($paymentCollection as $payment){

			$paid = $payment->isPaid();

			$paysystem = $payment->getPaySystem();

			$cash = $paysystem->isCash();
			$hasAction = false;

			$pathToAction = \Bitrix\Main\Application::getDocumentRoot().$paysystem->getField('ACTION_FILE');

			$pathToAction = str_replace("\\", "/", $pathToAction);

			while (substr($pathToAction, strlen($pathToAction) - 1, 1) == "/")
				$pathToAction = substr($pathToAction, 0, strlen($pathToAction) - 1);


			if (file_exists($pathToAction))
			{
				if (is_dir($pathToAction) && file_exists($pathToAction."/payment.php"))
					$pathToAction .= "/payment.php";

				$hasAction = true;
			}

			if(!$paid && !$cash ){
				
					$link = '/personal/order/payment/' . '?ORDER_ID=' . $id . '&PAYMENT_ID=' . $payment->getId();
					$type = false;
				
			}
			else {
				$link = false;
			}

			$name = $payment->getField('PAY_SYSTEM_NAME');
			$arPayments = array(
				'PAY_SYSTEM_ID' => $payment->getField('PAY_SYSTEM_ID'),
				'NAME' => $name,
				'PAYMENT_ID' => $payment->getId(),
				'LINK' => $link,
				'PAID' => $paid,
				'TYPE' => $type,
				
			);
			$arPayments['PARAM_EXTRA'] = [
					'ASSIST_SHOP_IDP' => \Bitrix\Sale\BusinessValue::get("ASSIST_SHOP_IDP", "PAYSYSTEM_".$arPayments['PAY_SYSTEM_ID'] ),
					'ASSIST_SHOP_LOGIN' => \Bitrix\Sale\BusinessValue::get("ASSIST_SHOP_LOGIN", "PAYSYSTEM_".$arPayments['PAY_SYSTEM_ID'] ),
					'ASSIST_SHOP_PASSWORD' => \Bitrix\Sale\BusinessValue::get("ASSIST_SHOP_PASSWORD", "PAYSYSTEM_".$arPayments['PAY_SYSTEM_ID'] ),
					'ASSIST_SERVER_URL' => \Bitrix\Sale\BusinessValue::get("ASSIST_SERVER_URL", "PAYSYSTEM_".$arPayments['PAY_SYSTEM_ID'] ),
				];
		}
		if(!empty($arPayments['PARAM_EXTRA']['ASSIST_SHOP_IDP'])){
			$massa=[
				"merchant"=>[
					"merchant_id"=>$arPayments['PARAM_EXTRA']['ASSIST_SHOP_IDP'],
					"login"=>$arPayments['PARAM_EXTRA']['ASSIST_SHOP_LOGIN'],
					"password"=>$arPayments['PARAM_EXTRA']['ASSIST_SHOP_PASSWORD']
				]
			];
			
			$url_status='https://'.$arPayments['PARAM_EXTRA']['ASSIST_SERVER_URL'].'/orderresult/orderresult.cfm';
			$massa_status=$massa;
			/* if(!empty($arItem['UF_ORDERNUMBER'])){
				$massa_status["ordernumber"]=$arItem['UF_ORDERNUMBER'];
			}else{
				$massa_status["ordernumber"]=$arPayments['PAYMENT_ID'];
			} */
				$massa_status["billnumber"]=$_REQUEST['rell'];
			$massa_status["startyear"]=date("Y", mktime(date('H'), date('i'), 0, date('m'), date('d')-14, date('Y')));
			$massa_status["startmonth"]=date("n", mktime(date('H'), date('i'), 0, date('m'), date('d')-14, date('Y')));
			$massa_status["startday"]=date("j", mktime(date('H'), date('i'), 0, date('m'), date('d')-14, date('Y')));
			$massa_status["starthour"]=date("H", mktime(date('H'), date('i'), 0, date('m'), date('d')-14, date('Y')));
			$massa_status["startmin"]=date("i", mktime(date('H'), date('i'), 0, date('m'), date('d')-14, date('Y')));
			
			$massa_status["format"]=3;
		
			function postRequest($url, $data) {
			$data_string = json_encode($data);
			$result = file_get_contents($url, null, stream_context_create([
				'http' => [
					'method' => 'POST',
					'header' => 'Content-Type: application/json' . "\r\n"
                    . 'Content-Length: ' . strlen($data_string) . "\r\n",
					'content' => $data_string,
				],
			]));
			
			return $result;
			}
			
			$result=postRequest($url_status, $massa_status);
			require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/xml.php");
			$objXML = new CDataXML();
			$objXML->LoadString($result);
			$arData = $objXML->GetArray();
			
			$arResult=\Kolchuga\Settings::ardt($arData['result']);
			if(!empty($arResult['order'])){
				$operat=$arResult['order']['operation'];
				$operation= array_pop($operat);
				$data=[
					'UF_ORDERDATE'=>$arResult['order']['orderdate'],
					'UF_ORDERSTATE'=>$arResult['order']['orderstate'],
					'UF_PACKETDATE'=>$arResult['order']['packetdate'],
					'UF_OPERATIONDATE'=>$operation['operationdate'],
				];
				$entity_data_class::update($arItem['ID'], $data);
			}
			 
			 $status=[
				'Approved'=>'Оплачен',
				'Delayed'=>'Ожидает подтверждения',
				'PartialDelayed '=>'Подтвержден частично',
				'Timeout '=>'Закрыт по истечении времени',
				'Declined '=>'Отклонен',
			];
			 echo $status[$arResult['order']['orderstate']];
			//echo "<blockquote class='blockquote'><pre>";print_r($arResult);echo "</pre></blockquote><br>";die;
		
		}
		
	}  
   
   
   
   
   
   
   
   
}