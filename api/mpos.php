<?php
/**
 * Created .
 * User: avolkov
 * Date: 22.08.2020
 * Time: 00:34
 */
set_time_limit(800);
ini_set('memory_limit', '12192M');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
foreach($request as $key=>$vl){
	$requestArr[$key]=$vl;
}
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/mpos.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****request******\n".print_r($requestArr, true), FILE_APPEND | LOCK_EX);

array_map('CModule::IncludeModule', ['iblock', 'catalog', 'sale']);
$ORDER_ID=intval($requestArr['orderid']);
if($ORDER_ID>0){
function exportOrder($order_num) {
 
    $order = \Bitrix\Sale\Order::load($order_num); //Объект заказа Bitrix D7
	$status=$order->getField("STATUS_ID");
	if(!in_array($status, ['N','P','CD'])){		
		$rows['error']='Статус заказа не соответсвует оплате. Обратитесь к менеджеру.';		
		return \Bitrix\Main\Web\Json::encode($rows);
	}
	if($order->isCanceled()){
		return \Bitrix\Main\Web\Json::encode(['error'=>'Заказ уже отменен']);
	}
 
    $order_date = $order->getDateInsert()->toString(); //строка - дата создания заказа
 
    $basket = $order->getBasket(); //Объект корзины Bitrix D7
 
    $rows = []; //Массив данных для записи в файл
	
	
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
		
	$uleCompany=[
		1=>'Варварка',
		2=>'Cклад',
		3=>'Ленинский проспект',
		4=>'Волоколамское шоссе',
		5=>'Барвиха',
	];
	$companyId=$order->getField('COMPANY_ID');
	
	$uleCompanyArr=[
		1=>['657871','AO Кольчуга'],
		2=>['570542','ООО Кольчуга'],
		3=>['628016','Магазин №1 Охотник - рыболов-турист'],
		4=>['908468','ООО "Охотник на Тверской"'],
	];
	
	if(!empty($uleCompanyArr[$companyId])){
		$rows['merchant_id'] = $uleCompanyArr[$companyId]['0'];
	}
	
	$rows['ordernum'] = $arPayments['PAYMENT_ID'];
	$rows['amount'] = $order->getPrice();
	$rows['delivery_price'] = $order->getDeliveryPrice();;
	$rows['currency'] = 'RUB';
	
	
	
	$propertyCollection = $order->getPropertyCollection();
	$ar = $propertyCollection->getArray();
	
	foreach($ar['properties'] as $val){
		if($val['CODE']=='FIO'){ $rows['clientname'] = $val['VALUE'][0]; }
		if($val['CODE']=='EMAIL'){ $rows['clientemail'] = $val['VALUE'][0]; }
		if($val['CODE']=='PHONE'){ $rows['clientphone'] = $val['VALUE'][0]; }
	}
	
	$rows['items'] = [];	
 
    /*foreach ($basket->getBasketItems() as $item) {//Обход элементов корзины Bitrix D7
        $name = $item->getField('NAME');
 
        //Масив данных одной строки файла
        $tmp_row = [
			'id'=> $item->getField('PRODUCT_XML_ID'), //Код товара
            "product"=>$item->getProductId(),
            "name"=>$name, //Наименование
            "price"=>$item->getPrice(), //Цена
            "quantity"=>$item->getQuantity(), //Количество            
        ];
         
        $rows['items'][] = $tmp_row;
    }*/
	
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
			if (!$basketItem->canBuy() || $basketItem->isDelay())
			continue;

			$tmp_row = [
				//'id'=> $basketItem->getField('PRODUCT_XML_ID'), //Код товара
				"product"=>$basketItem->getProductId(),
				"name"=>$basketItem->getField('NAME'), //Наименование
				"price"=>$basketItem->getPrice(), //Цена
				"quantity"=>$basketItem->getQuantity(), //Количество            
				"amount"=>$basketItem->getFinalPrice(), //сумма позиции = Количество * Цена
				"tax"=>'vat20', //Налог   
				'marking_code_group' => $basketItem->getMarkingCodeGroup(),   
				//"subjtype"=>"1", //Признак предмета расчета https://docs.assist.ru/pages/viewpage.action?pageId=9339465
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
			$rows['items'][] = $tmp_row;
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
							"amount"=>$price, //сумма позиции = Количество * Цена							       
						];
						$tmp_row['id']=$position_in_chek;
						$rows['items'][] = $tmp_row;
						$position_in_chek++;
					}
	}	
	//return $rows;
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/mpos.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****rows******\n".print_r($rows, true), FILE_APPEND | LOCK_EX);
	return \Bitrix\Main\Web\Json::encode($rows);
    
}

echo \exportOrder($ORDER_ID);
}