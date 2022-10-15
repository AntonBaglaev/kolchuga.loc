<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
array_map('CModule::IncludeModule', ['iblock', 'catalog', 'sale']);
 $ORDER_ID='15600';

function exportOrder($order_num) {
 
    $order = \Bitrix\Sale\Order::load($order_num); //Объект заказа Bitrix D7
	$status=$order->getField("STATUS_ID");
	if($status!='N'){return \Bitrix\Main\Web\Json::encode(['error_message'=>'Order is return','error_code'=>'1']);}
 
    $order_date = $order->getDateInsert()->toString(); //строка - дата создания заказа
 
    $basket = $order->getBasket(); //Объект корзины Bitrix D7
 
    $rows = []; //Массив данных для записи в файл
	$rows['ordernum'] = $order_num;
	$rows['amount'] = $order->getPrice();
	$rows['delivery_price'] = $order->getDeliveryPrice();;
	$rows['currency'] = 'RUB';
	//$rows['ordernum'] = $order_num;
	/* merchant_id	Нет/Да	Идентификатор предприятия в АПК Ассист. Параметр обязателен, если его значение отсутствует в настройках приложения.	"merchant_id":"223344" */
	
	 /*$props=$order->getAvailableFields();
	echo "<pre>";print_r($props);echo "</pre>"; 
	*/
	
	$propertyCollection = $order->getPropertyCollection();
	$ar = $propertyCollection->getArray();	
	
	foreach($ar['properties'] as $val){
		if($val['CODE']=='FIO'){ $rows['clientname'] = $val['VALUE'][0]; }
		if($val['CODE']=='EMAIL'){ $rows['clientemail'] = $val['VALUE'][0]; }
		if($val['CODE']=='PHONE'){ $rows['clientphone'] = $val['VALUE'][0]; }
	}
	$rows['items'] = [];
	
	$shipmentCollection = $order->getShipmentCollection();
	foreach($shipmentCollection as $shipment)
{
     $shipment_id = $shipment->getId();
  
     //пропускаем системные
     if ($shipment->isSystem())
      continue;
      
     $arShipments[$shipment_id] = array(
      'ID' => $shipment_id,
      'ACCOUNT_NUMBER' => $shipment->getField('ACCOUNT_NUMBER'),
      'ORDER_ID' => $shipment->getField('ORDER_ID'),
      'DELIVERY_ID' => $shipment->getField('DELIVERY_ID'),
      'PRICE_DELIVERY' => (float)$shipment->getField('PRICE_DELIVERY'),
      'BASKET' => array(),
     );
  
     //получаем Коллекцию Товаров в Корзине каждой Отгрузки
     $shipmentItemCollection = $shipment->getShipmentItemCollection();
     foreach($shipmentItemCollection as $item)
     {
      //объект Товара в корзине Отгрузки
      $basketItem = $item->getBasketItem();
  
      //не учитываем товары, которые нельзя купить или которые отложены
  if (!$basketItem->canBuy() || $basketItem->isDelay())
      continue;
		
		$tmp_row = [
			'id'=> $basketItem->getField('PRODUCT_XML_ID'), //Код товара
            "product"=>$basketItem->getProductId(),
            "name"=>$basketItem->getField('NAME'), //Наименование
            "price"=>$basketItem->getPrice(), //Цена
            "quantity"=>$basketItem->getQuantity(), //Количество            
            "amount"=>$basketItem->getQuantity() * $basketItem->getPrice(), //сумма позиции = Количество * Цена
            "tax"=>'vat20', //Налог   
			'marking_code_group' => $basketItem->getMarkingCodeGroup(),              
        ];
		$arItem = array(
			'PRODUCT_ID' => $basketItem->getProductId(),
			'NAME' => $basketItem->getField('NAME'),
			'PRICE' => $basketItem->getPrice(),    // за единицу
			'FINAL_PRICE' => $basketItem->getFinalPrice(),  // сумма
			'QUANTITY' => $basketItem->getQuantity(),
			'WEIGHT' => $basketItem->getWeight(),
			'MARKING_CODE_GROUP' => $basketItem->getMarkingCodeGroup(),   
		);
  if(!empty($arItem['MARKING_CODE_GROUP'])){
	  //объект Складской инфы в корзине Отгрузки
	  $collection = $item->getShipmentItemStoreCollection(); 
	  foreach ($collection as $itemstore){
		$arItem['MARKING_CODE']=$itemstore->getMarkingCode();
		$tmp_row['gs1code']=base64_encode($arItem['MARKING_CODE']);//GS1 DataMatrix/"Честный Знак" код маркировки товара  
	  }
  }
  $rows['items'][] = $tmp_row;
  $arShipments[$shipment_id]['BASKET'][$arItem['PRODUCT_ID']] = $arItem;
     }
 }
	echo "<pre>";print_r($arShipments);echo "</pre>";
	
	
 	
    /* foreach ($basket->getBasketItems() as $item) {//Обход элементов корзины Bitrix D7
        $name = $item->getField('NAME');
 
        //Масив данных одной строки файла
        $tmp_row = [
			'id'=> $item->getField('PRODUCT_XML_ID'), //Код товара
            "product"=>$item->getProductId(),
            "name"=>$name, //Наименование
            "price"=>$item->getPrice(), //Цена
            "quantity"=>$item->getQuantity(), //Количество            
            "amount"=>$item->getQuantity() * $item->getPrice(), //сумма позиции = Количество * Цена
            "tax"=>'vat20', //Налог            
            "gs1code"=>$item->getQuantity(), //GS1 DataMatrix/"Честный Знак" код маркировки товара  
            
        ];
         
        $rows['items'][] = $tmp_row;
    } */
	return $rows;
	return \Bitrix\Main\Web\Json::encode($rows);
    
}
echo "<pre>";print_r(\exportOrder($ORDER_ID));echo "</pre>"; die;
echo \exportOrder($ORDER_ID);