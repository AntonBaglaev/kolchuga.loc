<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 10/06/16
 * Time: 22:24
 */
use \Bitrix\Main\EventManager;
use \Bitrix\Sale\Order;

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/splitOrder.php';

/* splits order */
EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleOrderSaved',
    'splitOrder'
);

/* send mail about unavailable products can be paid */
EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleStatusOrderChange',
    'sendCanPaidOrder'
);

/* send mail about part of products was paid */
EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleOrderBeforeSaved',
    'sendPaymentPaid'
);


EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleCancelOrder',
    'CanceUpdateStatus'
);

function CanceUpdateStatus($order_id, $status, $info) {
    if($status == "Y"){
        // получаем объект существующего заказа
		$order = \Bitrix\Sale\Order::load($order_id);		 
		// задаем значение для поля STATUS_ID - O (статус: Отменен)
		$order->setField('STATUS_ID', 'O');		 
		// сохраняем изменения
		$order->save();
    }
}

function splitOrder(\Bitrix\Main\Event $event)
{
    global $APPLICATION;

    if(strstr($APPLICATION->getCurPage(), 'bitrix/admin/')){
        return true;
    }

    CModule::IncludeModule('iblock');
    CModule::IncludeModule('sale');

    /** @var \Bitrix\Sale\Order $order */
    $order = $event->getParameter('ENTITY');


    if($order->getId() > 0)
        $order = \Bitrix\Sale\Order::load($order->getId());

    if((int)$order->getField('PAY_SYSTEM_ID') !== 3){

        return $order;
    }

    $splitOrder = new DataInlifeSplitOrder($order, true);
    $order = $splitOrder->split();

    return $order;
}

/* this function was created because d7 has no event for payment paid */
function sendPaymentPaid(\Bitrix\Main\Event $event)
{

    /** @var \Bitrix\Sale\Order $order */
    $order = $event->getParameter('ENTITY');

    if($order->isNew() || $order->isPaid()){
        return true;
    }

    /** @var \Bitrix\Sale\Order $beforeOrder */
    $beforeOrder = Order::load($order->getId());

    $paymentCollection = $order->getPaymentCollection();
    $oldPaymentCollection = $beforeOrder->getPaymentCollection();

    $shipmentCollection = $order->getShipmentCollection();

    $arPayments = array();
    $arOldPayments = array();

    if($paymentCollection->count() < 2){
        return true;
    }

    $orderUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/personal/order/detail/' . $order->getId() . '/';

    /** @var \Bitrix\Sale\Payment $payment */
    foreach($paymentCollection as $i => $payment){

        if(!$payment->isPaid())
            continue;

        $payment_id = $payment->getId();

        /** @var \Bitrix\Sale\Payment $old_payment */
        $old_payment = $oldPaymentCollection->getItemById($payment_id);

        if(!is_object($old_payment) || $old_payment->isPaid()) continue;

        /* Get products for payment */

        /** @var \Bitrix\Sale\Shipment $shipment */
        $shipment = $shipmentCollection[$i];
        $basketNames = array();

        if(is_object($shipment)){

            /** @var  $shipmentItemCollection */
            $shipmentItemCollection = $shipment->getShipmentItemCollection();


            /** @var \Bitrix\Sale\ShipmentItem $item */
            foreach($shipmentItemCollection as $item){
                $basketItem = $item->getBasketItem();
                $basketNames[] = $basketItem->getField('NAME');
            }
        }

        $basketString = implode(', ', $basketNames);

        $result = \CEvent::Send('SALE_ORDER_PARTLY_PAID', 's1', array(
            'ORDER_ID' => $order->getId(),
            'BASKET' => $basketString,
            'ORDER_URL' => $orderUrl,
            'SUM' => number_format(floatval($payment->getSum()), 2, '.', ' ') . ' руб.',
        ));
    }

}

function sendCanPaidOrder(\Bitrix\Main\Event $event){

    /** @var \Bitrix\Sale\Order $order */
    $order = $event->getParameter('ENTITY');
    $status = $order->getField('STATUS_ID');

    switch ($status) {
		case 'P':
			$paymentCollection = $order->getPaymentCollection();
			$shipmentCollection = $order->getShipmentCollection();

			if($paymentCollection->count() < 2)
				return true;

			/* We get shipment by index of payment, cause bitrix core hasn't links between shipments and payments */

			/** @var \Bitrix\Sale\Shipment $shipment */
			$shipment = $shipmentCollection[$paymentCollection->count() - 1];

			if(!$shipment)
				return true;

			/** @var  $shipmentItemCollection */
			$shipmentItemCollection = $shipment->getShipmentItemCollection();

			$basketNames = array();

			/** @var \Bitrix\Sale\ShipmentItem $item */
			foreach($shipmentItemCollection as $item){
				$basketItem = $item->getBasketItem();
				$basketNames[] = $basketItem->getField('NAME');
			}

			$basketString = implode(', ', $basketNames);
			$orderUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/personal/order/detail/' . $order->getId() . '/';


			$result = \CEvent::Send('SALE_ORDER_MANAGER_APPROVED', 's1', array(
				'ORDER_ID' => $order->getId(),
				'BASKET' => $basketString,
				'ORDER_URL' => $orderUrl
			));
			break;
		//TEST
		/* case 'T':
			//$order->getPrice();
			$price=$order->getField('PRICE');			
			if ($price>=5000){
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/status_T.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****d oId******\n".print_r($price, true), FILE_APPEND | LOCK_EX);
				$result = \CEvent::Send('SALE_STATUS_CHANGED_T', 's1', array(
					'ORDER_ID' => $order->getId(),					
				),
				'Y',
				'',
				array(
					'https://' . $_SERVER['HTTP_HOST'] .'/upload/fest_pdf/14713640.pdf'
				)
				);
			}
			
			break; */
		default:
			return true;
		
	}	
	
	/* if($status !== 'P'){
        return true;
    } */
	    
}

AddEventHandler("sale", "OnOrderStatusSendEmail", "CustomOnOrderStatusSendEmail");
function CustomOnOrderStatusSendEmail($ID, &$eventName, &$arFields, $val)
{
	if($val=='PU'){
		$dd="16.09.2021 23:59:59";
		if(strtotime($dd) > time() ){			
			//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/status_T.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****d oId******\n".print_r(array($ID, $eventName, &$arFields, $val), true), FILE_APPEND | LOCK_EX);
			$sendfile='N';
			$uri='';
			$fileAr=[];
			$order = \Bitrix\Sale\Order::load($ID);
			$price=$order->getPrice();	
			
			$bb=$order->getDateInsert();
			$dd2="07.09.2021 19:00:00";
			$mono='N';
			if(strtotime($dd2) < $bb->getTimestamp() ){$mono='Y';}
			
			if($mono=='Y'){
				$db_vals32 = \CSaleOrderPropsValue::GetList(array(), array('ORDER_ID' => $ID, 'ORDER_PROPS_ID' => 32))->Fetch();
				if(!empty($db_vals32['VALUE'])){
					file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/status_PU.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****Proverka******\n".print_r($db_vals32['VALUE'], true), FILE_APPEND | LOCK_EX);
					$listOrders=[];
					$arFilter = Array(
						"PROPERTY_CODE" => "EACH_ORDER_HASH",
						"PROPERTY_VALUE" => $db_vals32['VALUE'],
					);
					$rsSales = \CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter, false, false, array('ID','PAYED','PROPERTY_VAL_BY_CODE_FILE_MAIL','PRICE'));
					if($rsSales->SelectedRowsCount() > 1){
						while ($arSales = $rsSales->Fetch()){
							$listOrders[]=$arSales;	
							if($arSales['PAYED']!='Y'){$mono='N';}
							if(!empty($arSales['PROPERTY_VAL_BY_CODE_FILE_MAIL'])){$mono='N';}
						}
						file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/status_PU.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****Proverka list******\n".print_r($listOrders, true), FILE_APPEND | LOCK_EX);
						if($mono=='Y'){
							$price=0;
							foreach($listOrders as $zn){
								$price = $price + $zn['PRICE'];
							}
						}
						//print_r($listOrders);
					}else{
						file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/status_PU.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****Proverka count******\n".print_r('count = 1', true), FILE_APPEND | LOCK_EX);
					}
				}
			}
			
			if($price>=10000 && $mono=='Y'){
				$filecount=1;
				if($price>=20000 && $price<30000){ $filecount=2; }
				if($price>=30000){ $filecount=3; }
				
				$historyEntityType = 'ORDER'; //В данном случае для заказа
				$historyType = 'ORDER_COMMENTED'; //Нужный тип можно посмотеть в классе \CSaleOrderChangeFormat в $operationTypes
				\Bitrix\Sale\OrderHistory::addAction(
					$historyEntityType,
					$order->getId(),
					$historyType,
					$order->getId(),
					$order,
					['COMMENTS' => 'Основные условия FEST обеспечены']
				);
				
				if ($arOrderProps = \CSaleOrderProps::GetByID(33)) {
												$db_vals = \CSaleOrderPropsValue::GetList(array(), array('ORDER_ID' => $ID, 'ORDER_PROPS_ID' => $arOrderProps['ID']));
												if ($arVals = $db_vals->Fetch()) {
													if(empty($arVals['VALUE'])){
														$sendfile='Y';
														$path = $_SERVER["DOCUMENT_ROOT"]."/upload/fest_pdf/"; // задаем путь до сканируемой папки с изображениями
														$images = scandir($path); // сканируем папку
														if ($images !== false) { // если нет ошибок при сканировании
															$images = preg_grep("/\.(?:pdf)$/i", $images); // через регулярку создаем массив только изображений
															//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/status_T.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****d oId******\n".print_r(array($ID, $eventName, &$arFields, $val,$images), true), FILE_APPEND | LOCK_EX);
															if (is_array($images)) { // если изображения найдены
																
																for ($i = 1; $i <= $filecount; $i++) {																
																	$fpdf=array_shift($images);
																	rename( $_SERVER['DOCUMENT_ROOT'].'/upload/fest_pdf/'.$fpdf, $_SERVER['DOCUMENT_ROOT'].'/upload/qtiket_pdf/'.$fpdf);
																	$fileAr[]='https://' . $_SERVER['HTTP_HOST'] .'/upload/qtiket_pdf/'.$fpdf;	
																}
																	
																$uri=implode(', ',$fileAr);	
																
																\Bitrix\Sale\OrderHistory::addAction(
																	$historyEntityType,
																	$order->getId(),
																	$historyType,
																	$order->getId(),
																	$order,
																	['COMMENTS' => 'Обновляем свойство '.$arVals['NAME'].' Устанавливаем значение '.$uri]
																);
															
																\CSaleOrderPropsValue::Update($arVals['ID'], array(
																	'NAME' => $arVals['NAME'],
																	'CODE' => $arVals['CODE'],
																	'ORDER_PROPS_ID' => $arVals['ORDER_PROPS_ID'],
																	'ORDER_ID' => $arVals['ORDER_ID'],
																	'VALUE' => $uri,
																));
															
															}else{
																$sendfile='N';
															}
														}else{
															$sendfile='N';
														}
													}else{
														file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/status_PU.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**** SEND ******\n".print_r($arVals, true), FILE_APPEND | LOCK_EX);
													}
												} else {
													$sendfile='Y';
													$path = $_SERVER["DOCUMENT_ROOT"]."/upload/fest_pdf/"; // задаем путь до сканируемой папки с изображениями
														$images = scandir($path); // сканируем папку
														if ($images !== false) { // если нет ошибок при сканировании
															$images = preg_grep("/\.(?:pdf)$/i", $images); // через регулярку создаем массив только изображений
															//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/status_T.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****d oId******\n".print_r(array($ID, $eventName, &$arFields, $val,$images), true), FILE_APPEND | LOCK_EX);
															if (is_array($images)) { // если изображения найдены
															
																for ($i = 1; $i <= $filecount; $i++) {																
																	$fpdf=array_shift($images);
																	rename( $_SERVER['DOCUMENT_ROOT'].'/upload/fest_pdf/'.$fpdf, $_SERVER['DOCUMENT_ROOT'].'/upload/qtiket_pdf/'.$fpdf);
																	$fileAr[]='https://' . $_SERVER['HTTP_HOST'] .'/upload/qtiket_pdf/'.$fpdf;	
																}
																	
																$uri=implode(', ',$fileAr);	
																
																\Bitrix\Sale\OrderHistory::addAction(
																	$historyEntityType,
																	$order->getId(),
																	$historyType,
																	$order->getId(),
																	$order,
																	['COMMENTS' => 'Заполняем свойство '.$arOrderProps['NAME'].' Устанавливаем значение '.$uri]
																);
																
																 \CSaleOrderPropsValue::Add(array(
																	'NAME' => $arOrderProps['NAME'],
																	'CODE' => $arOrderProps['CODE'],
																	'ORDER_PROPS_ID' => $arOrderProps['ID'],
																	'ORDER_ID' => $ID,
																	'VALUE' => $uri,
																));
															}else{
																$sendfile='N';
															}
														}else{
															$sendfile='N';
														}
												}
				}
			}
			if($sendfile=='Y'){
				file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/status_PU.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****d oId******\n".print_r(array($ID, $fileAr), true), FILE_APPEND | LOCK_EX);
				$ob = \Bitrix\Main\Mail\Event::send(array(
					//"EVENT_NAME" => $eventName,
					"EVENT_NAME" => 'ARMS_FEST',
					"LID" => "s1",
					"C_FIELDS" => $arFields,
					'FILE' => $fileAr,
				));
				\Bitrix\Sale\OrderHistory::addAction(
					$historyEntityType,
					$order->getId(),
					$historyType,
					$order->getId(),
					$order,
					['COMMENTS' => 'Отправляем письмо с подарком']
				);
				return false;
			}
		}
	}
}

