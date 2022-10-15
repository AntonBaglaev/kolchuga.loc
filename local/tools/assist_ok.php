<?php
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/postRequest.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**************************************************************\n\n", FILE_APPEND | LOCK_EX);

echo 'Проверяем заказ '.$arParams['CODE'].'... ';


if(intval($arParams['CODE'])>0){
	
	echo 'Успешно<br>';
	
	$yes_payment_id=false;
	if(!empty($arParams['payment_id']) && intval($arParams['payment_id'])>0){
		echo '<br>Проверяем номер заказа в Ассист '.$arParams['payment_id'].'... ';
		$yes_payment_id=$arParams['payment_id'];
	}
	
	echo 'Проверяем статус:<br>';
	$ule=[
		21=>'Cклад',
		18=>'Варварка',
		19=>'Ленинский проспект',
		20=>'Волоколамское шоссе',
		23=>'Барвиха',
	];
	$order = \Bitrix\Sale\Order::load($arParams['CODE']);
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
	
	//echo "<pre>";print_r($arPayments);echo "</pre>";die;
	
	if(!empty($arPayments['PARAM_EXTRA']['ASSIST_SHOP_IDP'])){
		/* $arPayments['PARAM_EXTRA'] = [
				'ASSIST_SHOP_IDP' => 115708,
				'ASSIST_SHOP_LOGIN' => 'demo_COLCHUGA',
				'ASSIST_SHOP_PASSWORD' => 'Prik0lchuga',
				'ASSIST_SERVER_URL' => 'payments.demo.paysecure.ru',
			]; */
			$url_yes='https://'.$arPayments['PARAM_EXTRA']['ASSIST_SERVER_URL'].'/charge/charge.cfm';
			
			$massa=[
				"merchant"=>[
					"merchant_id"=>$arPayments['PARAM_EXTRA']['ASSIST_SHOP_IDP'],
					"login"=>$arPayments['PARAM_EXTRA']['ASSIST_SHOP_LOGIN'],
					"password"=>$arPayments['PARAM_EXTRA']['ASSIST_SHOP_PASSWORD']
				]
			];
			
			$url_status='https://'.$arPayments['PARAM_EXTRA']['ASSIST_SERVER_URL'].'/orderstate/orderstate.cfm';
			$massa_status=$massa;
			if($yes_payment_id){
				$massa_status["ordernumber"]=$yes_payment_id;
			}else{
				$massa_status["ordernumber"]=$arPayments['PAYMENT_ID'];
			}
			
			$massa_status["startyear"]=date("Y", mktime(date('H'), date('i'), 0, date('m'), date('d')-30, date('Y')));
			$massa_status["startmonth"]=date("n", mktime(date('H'), date('i'), 0, date('m'), date('d')-30, date('Y')));
			$massa_status["startday"]=date("j", mktime(date('H'), date('i'), 0, date('m'), date('d')-30, date('Y')));
			$massa_status["starthour"]=date("H", mktime(date('H'), date('i'), 0, date('m'), date('d')-30, date('Y')));
			$massa_status["startmin"]=date("i", mktime(date('H'), date('i'), 0, date('m'), date('d')-30, date('Y')));
			
			$massa_status["format"]=3;
			
			function postRequest($url, $data) {
			$data_string = json_encode($data);
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/postRequest.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****data_string******\n".print_r($data_string, true), FILE_APPEND | LOCK_EX);
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
			
			function ardt($massiv){
				$result=[];
				foreach($massiv['#'] as $key=>$value){
					if(empty($value[1])){
						if(!is_array($value[0]['#'])){
							$result[$key]=$value[0]['#'];
						}else{
							$result[$key]=ardt($value[0]);
						}
					}else{
						//echo "<pre>";print_r($value);echo "</pre>";die;
						foreach($value as $key2=>$item){
							$result[$key][$key2]=ardt($item);
						}
					}
					
				}
				
				return $result;
			}
			//echo "<blockquote class='blockquote'><pre>";print_r($massa_status);echo "</pre></blockquote><br>";
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/postRequest.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($massa_status, true), FILE_APPEND | LOCK_EX);
			$result=postRequest($url_status, $massa_status);
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/postRequest.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($result, true), FILE_APPEND | LOCK_EX);
			//echo "<blockquote class='blockquote'><pre>";print_r($result);echo "</pre></blockquote><br>";die;
			require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/xml.php");
			$objXML = new CDataXML();
			$objXML->LoadString($result);
			/* $node = $objXML->tree->children[0]; */
			$arData = $objXML->GetArray();
			
			
			//$arResult=ardt($arData['result']);
			$arResult=\Kolchuga\Settings::ardt($arData['result']);
			 
			//echo "<blockquote class='blockquote'><pre>";print_r($arResult);echo "</pre></blockquote><br>";die;
			$status=[
				'Approved'=>'Оплачен',
				'Delayed'=>'Ожидает подтверждения',
				'PartialDelayed '=>'Подтвержден частично',
				'Timeout '=>'Закрыт по истечении времени',
				'Declined '=>'Отклонен',
			];
			
			if(!empty($arResult['order'][0])){
				$nideno='N';
				foreach($arResult['order'] as $kluch=>$value){
					if($value['orderstate']=='Delayed'){
						$arResult['order']=$value;
						$nideno='Y';
						break;
					}elseif($value['orderstate']=='Approved'){
						$arResult['order']=$value;
						$nideno='Y';
						break;
					}
				}
				if($nideno=='N'){
					echo "<strong>Внимание!!! Не определена запись, которую нужно подтвердить.</strong><br>";
				}
			}
			echo 'Текущий статус: '.(!empty($status[$arResult['order']['orderstate']]) ? $status[$arResult['order']['orderstate']]: $arResult['order']['orderstate'] ).'<br>';
			
			echo "<blockquote class='blockquote'><pre>";print_r($arResult['order']);echo "</pre></blockquote><br>";
			
			if($arResult['order']['orderstate']=='Delayed'){
				echo 'Идет подтверждение заказа...<br>';
				$charge=$massa;
				$charge['billnumber']=$arResult['order']['billnumber'];
				$charge['amount']=(string)round($order->getPrice(), 2);
				$charge['currency']='RUB';
				$charge['chequeitem']=[];
				
				

				$shipmentCollection = $order->getShipmentCollection();
				foreach($shipmentCollection as $shipment)
				{
					$shipment_id = $shipment->getId();

					//пропускаем системные
					if ($shipment->isSystem())
					continue;

					//получаем Коллекцию Товаров в Корзине каждой Отгрузки
					$shipmentItemCollection = $shipment->getShipmentItemCollection();
					$position_in_chek=1;
					foreach($shipmentItemCollection as $item)
					{
						//объект Товара в корзине Отгрузки
						$basketItem = $item->getBasketItem();

						//не учитываем товары, которые нельзя купить или которые отложены
						//if (!$basketItem->canBuy() || $basketItem->isDelay())
						//continue;

						$tmp_row = [
							//'id'=> $basketItem->getField('PRODUCT_XML_ID'), //Код товара
							"product"=>$basketItem->getProductId(),
							"name"=>$basketItem->getField('NAME'), //Наименование
							"price"=>(string)round($basketItem->getPrice(), 2), //Цена
							"quantity"=>$basketItem->getQuantity(), //Количество            
							"amount"=>(string)round($basketItem->getFinalPrice(), 2), //сумма позиции = Количество * Цена
							"tax"=>'vat20', //Налог   
							'marking_code_group' => $basketItem->getMarkingCodeGroup(),              
						];
						
						if(!empty($tmp_row['marking_code_group'])){
							//объект Складской инфы в корзине Отгрузки
							$collection = $item->getShipmentItemStoreCollection(); 
							foreach ($collection as $itemstore){
								$tmp_row['marking_code']=$itemstore->getMarkingCode();
								$tmp_row['gs1code']=base64_encode($tmp_row['marking_code']);//GS1 DataMatrix/"Честный Знак" код маркировки товара  
							}
						}
						
						$tmp_row['id']=$position_in_chek;
						$charge['chequeitem'][] = $tmp_row;
						$position_in_chek++;
						
					}
					$price = $shipment->getPrice();
					if($price>0){
						$tmp_row = [
							//'id'=> $basketItem->getField('PRODUCT_XML_ID'), //Код товара
							"product"=>$shipment->getField('DELIVERY_ID'),
							"name"=>'Доставка', //Наименование
							"price"=>$price, //Цена
							"quantity"=>1, //Количество   
							"tax"=>'vat20', //Налог   
							"amount"=>$price, //сумма позиции = Количество * Цена		
							//"subjtype"=>"1", //Признак предмета расчета https://docs.assist.ru/pages/viewpage.action?pageId=9339465
						];
						$tmp_row['id']=$position_in_chek;
						$charge['chequeitem'][] = $tmp_row;
						$position_in_chek++;
					}
				}
				file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/postRequest.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($charge, true), FILE_APPEND | LOCK_EX);
				//$charge["format"]=3;
				//echo "<pre>";print_r($charge);echo "</pre>";die;
				
				$result2=postRequest($url_yes, $charge);
				file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/postRequest.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($result2, true), FILE_APPEND | LOCK_EX);
				//echo "<pre>";print_r($result2);echo "</pre>";
				$rrr=json_decode($result2, true);
				echo $rrr['charge']['message'];
				
				echo '<br><br>Информация:<br>';
				echo 'Номер заказа в асист: '.$rrr['charge']['billnumber'].'<br>';
				echo 'Дата: '.$rrr['charge']['packetdate'].'<br>';
				echo 'Сумма заказа: '.$rrr['charge']['orderamount'].'<br>';
				echo 'Карта: '.$rrr['charge']['meannumber'].'<br>';
				echo 'Статус: '.$rrr['charge']['orderstate'].'<br>';
				echo 'Сумма подтверждения: '.$rrr['charge']['amount'].'<br>';
				echo 'Ответ подтверждения: '.$rrr['charge']['responsecode'].'<br>';
				echo 'Тип карты: '.$rrr['charge']['meantypename'].'<br>';
				echo 'Страна: '.$rrr['charge']['bankcountry'].'<br>';
				echo 'Клиент: <br>';
				echo 'Фамилия: '.$rrr['charge']['customer']['lastname'].'<br>';
				echo 'Имя: '.$rrr['charge']['customer']['firstname'].'<br>';
				echo 'Почта: '.$rrr['charge']['customer']['email'].'<br>';				
				
			}
			
			
			
			
	/* 		
			
			{
  "merchant": {
    "merchant_id": 0,
    "login": "string",
    "password": "string"
  },
  "billnumber": "string",
  "amount": 0,
  "currency": "string",
  "language": "string",
  "clientip": "string",
  "ticket_number": "string",
  "pnr": "string",
  "product_id": 0,
  "chequeitem": [
    {
      "id": "string",
      "product": "string",
      "name": "string",
      "price": 0,
      "amount": 0,
      "quantity": 0,
      "tax": "string",
      "fpmode": "string",
      "еancode": "string",
      "uncode": "string",
      "gs1code": "string",
      "furcode": "string",
      "egaiscode": "string",
      "hscode": "string",
      "subjtype": "string",
      "agentmode": 0,
      "transferoperatorphone": "string",
      "transferoperatorname": "string",
      "transferoperatoraddress": "string",
      "transferoperatorinn": "string",
      "paymentreceiveroperatorphone": "string",
      "paymentagentoperation": "string",
      "paymentagentphone": "string",
      "supplierphone": "string",
      "suppliername": "string",
      "supplierinn": "string",
      "excise": 0,
      "countryoforigin": "string",
      "numberofcustomsdeclaration": "string",
      "lineattribute": "string"
    }
  ],
  "fiscalization": {
    "generatereceipt": 0,
    "receiptline": "string",
    "tax": "string",
    "fpmode": "string",
    "taxationsystem": "string",
    "lastname": "string",
    "firstname": "string",
    "middlename": "string",
    "taxpayerid": "string",
    "customerdocid": "string",
    "paymentaddress": "string",
    "paymentplace": "string",
    "cashier": "string",
    "cashierinn": "string",
    "paymentterminal": "string",
    "transferoperatorphone": "string",
    "transferoperatorname": "string",
    "transferoperatoraddress": "string",
    "transferoperatorinn": "string",
    "paymentreceiveroperatorphone": "string",
    "paymentagentphone": "string",
    "paymentagentoperation": "string",
    "supplierphone": "string",
    "paymentagentmode": 0,
    "documentrequisite": "string",
    "userrequisites": {
      "name": "string",
      "value": "string"
    },
    "companyname": "string"
  }
}
	 */		
	 /*
	 Array
(
    [charge] => Array
        (
            [customermessage] => Завершено успешно
            [message] => Завершено успешно
            [testmode] => 1
            [operationtype] => 200
            [orderdate] => 22.03.2021 13:00:54
            [packetdate] => 22.03.2021 13:15:53
            [orderamount] => 150.00
            [ordercomment] => 
            [cardexpirationdate] => 12/25
            [ordercurrency] => RUB
            [recommendation] => 
            [processingname] => Fake
            [meannumber] => 411111****1111
            [orderstate] => Approved
            [rate] => 1
            [amount] => 150.00
            [responsecode] => AS000
            [meantypename] => VISA
            [protocoltypename] => 
            [bankcountry] => Россия
            [customer] => Array
                (
                    [lastname] => Волков
                    [firstname] => Алексей
                    [middlename] => 
                    [ipaddress] => 194.58.115.195
                    [email] => tgarl@yandex.ru
                )

            [cardholder] => TEST
            [approvalcode] => 
            [signature] => kA0DAAIRzfHw5YyCWOEBy2RiCF9DT05TT0xFYFiYiTUxMTU3MDgyMzI4MDg0NzcuMiwxNTg1MCxB
UzAwMCwxNTAuMDAsUlVCLDQxMTExMSoqKioxMTExLCxBcHByb3ZlZCwyMi4wMy4yMDIxIDEzOjE1
OjUziEYEABECAAYFAmBYmIkACgkQzfHw5YyCWOHnrgCgzvdQzAFUYPhc0dPh9OX4FsrotbQAoKrp
0ioJew+lKn8yfJtqe50Wixh2
            [billnumber] => 5115708232808477.2
            [issuebank] => New Assist Bank
            [currency] => RUB
            [ordernumber] => 15850
            [meansubtype] => Classic
        )

)

	 
	 */
			//echo "<pre>";print_r($arPayments);echo "</pre>";
	}else{
		echo '<span style="color:#ff0000;">В заказе используется система оплаты не Ассист - '.$arPayments['NAME'].'( ID => '.$arPayments['PAY_SYSTEM_ID'].')</span><br>';
		echo 'Исправьте Платежную систему на нужную<br><br>';
		foreach($ule as $kl=>$vl){
			echo $vl.' -> ['. $kl.'] Ассист<br>';
		}
	}
   
}